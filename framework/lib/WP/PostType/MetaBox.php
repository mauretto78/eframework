<?php

namespace Framework\Framework\WP\PostType;

use Framework\Framework\WP\Action;
use Framework\Framework\WP\Image;

/**
 * This class add meta boxes to posts.
 *
 * This is a modified version of Easy Wordpress Custom Types by Jeffrey Way https://github.com/JeffreyWay/Easy-WordPress-Custom-Post-Types
 *
 * @author Mauro Cassani <assistenza@easy-grafica.com>
 */
class MetaBox
{
    /**
     * The name of the meta box.
     *
     * @var string
     */
    private $title;

    /**
     * The name of the post type name.
     *
     * @var string
     */
    private $postTypeName;

    /**
     * A list of form fields for the meta box.
     *
     * @var array
     */
    private $formFields = array();

    /**
     * A list of form fields types available for the meta box.
     *
     * @var array
     */
    private $formFieldsTypes = ['text', 'date', 'number', 'textarea', 'checkbox', 'selectmultiple', 'select', 'file', 'media', 'colorpicker', 'editor'];

    /**
     * MetaBox constructor.
     *
     * @param $title
     * @param $formFields
     */
    public function __construct($title, $formFields)
    {
        $this->title = $title;
        $this->formFields = (array) $formFields;

        if (!isset($_SESSION)) {
            session_start();
        }
        if (!isset($_SESSION['taxonomy_data'])) {
            $_SESSION['taxonomy_data'] = array();
        }
    }

    /**
     * Creates the meta box.
     * This is the function invoked by PostType.
     *
     * @param $postTypeName
     */
    public function createBoxFor($postTypeName)
    {
        $action = Action::getInstance();
        $this->postTypeName = $postTypeName;
        $action->add('admin_init', array($this, 'add'));
        $action->add('save_post', array($this, 'save'));
    }

    /**
     * Adds the meta box.
     */
    public function add()
    {
        add_meta_box(
            strtolower(str_replace(' ', '_', $this->title)), // id
            $this->title, // title
            array($this, 'renderBox'),
            $this->postTypeName, // associated post type
            'normal', // location/context. normal, side, etc.
            'default', // priority level
            array($this->formFields) // optional passed arguments.
        );
    }

    /**
     * Renders the meta box.
     *
     * @param $post
     */
    public function renderBox($post)
    {
        global $post;

        // Add an nonce field so we can check for it later.
        wp_nonce_field(plugin_basename(__FILE__), 'jw_nonce');

        foreach ($this->formFields as $label => $fieldType) {
            if (is_array($fieldType)) {
                $fieldTypeName = $fieldType[0];
            } else {
                $fieldTypeName = $fieldType;
            }
            // checks if the $fiels is an allowed and calls the corresponding function to render the form field.
            if (in_array($fieldTypeName, $this->formFieldsTypes)) {
                $idName = $this->_normalize($this->title).'_'.$this->_normalize($label);
                $value = get_post_meta($post->ID, $idName, true);

                $fn = 'render'.ucfirst($fieldTypeName);

                $output = "<p><label>{$label}</label>";
                $output .= $this->$fn($idName, $value, $fieldType);
                array_push($_SESSION['taxonomy_data'], $idName);
                $output .= '</p>';

                $this->_print($output);
            }
        }
    }

    /**
     * Renders the text field input.
     *
     * @param $idName
     * @param $value
     */
    public function renderText($idName, $value, $fieldType = null)
    {
        $output = "<input type='text' id='{$idName}' name='{$idName}' value='{$value}' class='widefat'>";

        return $output;
    }

    /**
     * Renders the date field input.
     *
     * @param $idName
     * @param $value
     */
    public function renderDate($idName, $value, $fieldType = null)
    {
        $output = "<input type='date' id='{$idName}' name='{$idName}' value='{$value}' class='widefat'>";

        return $output;
    }

    /**
     * Renders the number field input.
     *
     * @param $idName
     * @param $value
     */
    public function renderNumber($idName, $value, $fieldType = null)
    {
        $output = "<input type='number' min='1' max='1000' step='1' id='{$idName}' name='{$idName}' value='{$value}' class='widefat'>";

        return $output;
    }

    /**
     * Renders the textarea field input.
     *
     * @param $idName
     * @param $value
     */
    public function renderTextarea($idName, $value, $fieldType = null)
    {
        $output = "<textarea id='{$idName}' name='{$idName}' class='widefat' rows='10'>{$value}</textarea>";

        return $output;
    }

    /**
     * Renders the textarea field input.
     *
     * @param $idName
     * @param $value
     */
    public function renderCheckbox($idName, $value, $fieldType = null)
    {
        $output = '';
        foreach ($fieldType[1] as $key => $option) {
            $arrayValue = explode(',', $value);
            if (in_array($option, $arrayValue)) {
                $checked = "checked='checked'";
            } else {
                $checked = '';
            }
            $output .= "<p><input name='{$idName}[]' type='checkbox' value='{$option}' {$checked} /> {$key}</p>";
        }

        return $output;
    }

    /**
     * Renders the select multiple field input.
     *
     * @param $idName
     * @param $value
     */
    public function renderSelectMultiple($idName, $value, $fieldType = null)
    {
        $output = "<select multiple id='{$idName}' name='{$idName}[]' class='widefat'>";

        foreach ($fieldType[1] as $key => $option) {
            $arrayValue = explode(',', $value);
            if (in_array($option, $arrayValue)) {
                $selected = "selected='selected'";
            } else {
                $selected = '';
            }
            $output .= "<option value='{$option}' {$selected}>{$key}</option>";
        }
        $output .= '</select>';

        return $output;
    }

    /**
     * Renders the select field input.
     *
     * @param $idName
     * @param $value
     */
    public function renderSelect($idName, $value, $fieldType = null)
    {
        $output = "<select id='{$idName}' name='{$idName}' class='widefat'>";

        foreach ($fieldType[1] as $key => $option) {
            $arrayValue = explode(',', $value);
            if (in_array($option, $arrayValue)) {
                $selected = "selected='selected'";
            } else {
                $selected = '';
            }
            $output .= "<option value='{$option}' {$selected}>{$key}</option>";
        }
        $output .= '</select>';

        return $output;
    }

    /**
     * Renders the file field input.
     *
     * @param $idName
     * @param $value
     */
    public function renderFile($idName, $value, $fieldType = null)
    {
        $output = "<input type='file' id='{$idName}' name='{$idName}' value='{$value}' class='widefat'>";

        // If a file was uploaded, display it below the input.
        $file = get_post_meta($post->ID, $idName, true);

        $file_type = wp_check_filetype($file);
        $image_types = array('jpeg', 'jpg', 'bmp', 'gif', 'png');
        if (isset($file)) {
            if (in_array($file_type['ext'], $image_types)) {
                $output .= "<img src='$file' alt='' style='max-width: 400px;' />";
            } else {
                $output .= "<a href='$file'>$file</a>";
            }
            $output .= "<p><a rel='$file' class='delete-meta-box $post->ID' id='$idName' href='#'>Delete this file</a></p>";
        }

        return $output;
    }

    /**
     * Renders the media field input.
     *
     * @param $idName
     * @param $value
     */
    public function renderMedia($idName, $value, $fieldType = null)
    {
        $output = "<div class='media-meta-box ef-group'>";
        $output .= "<input type='hidden' class='upload-value' id='{$idName}' name='{$idName}' value='{$value}'>";
        $output .= "<a class='btn btn-upload media-upload'><i class='fa fa-upload'></i> Upload</a>";
        $output .= "<span class='upload-file-path'>";
        $output .= ($value) ? Image::renderForAdminPanel($value) : '';
        $output .= '</span>';
        $output .= '</div>';

        return $output;
    }

    /**
     * Renders the colorpicker field input.
     *
     * @param $idName
     * @param $value
     */
    public function renderColorpicker($idName, $value, $fieldType = null)
    {
        //$style = 'width: 30px;height: 30px; position: relative;top: 4px;padding: 1px 2px;margin-left: 5px;background: #fff;border: 1px solid #ddd;';
        $output = "<input type='text' id='{$idName}' name='{$idName}' value='{$value}' class='jscolor widefat'";

        return $output;
    }

    /**
     * Renders the editor field input.
     *
     * @param $idName
     * @param $value
     */
    public function renderEditor($idName, $value, $fieldType = null)
    {
        wp_editor($value, $idName, array('textarea_name' => $idName, 'media_buttons' => false));
    }

    /**
     * Save the meta when the post is saved.
     */
    public function save()
    {
        // Only do the following if we physically submit the form,
        // and now when autosave occurs.
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        global $post;

        if ($_POST && !wp_verify_nonce($_POST['jw_nonce'], plugin_basename(__FILE__))) {
            return;
        }

        // Get all the form fields that were saved in the session,
        // and update their values in the db.
        if (isset($_SESSION['taxonomy_data'])) {
            foreach ($_SESSION['taxonomy_data'] as $formName) {
                if (!empty($_FILES[$formName])) {
                    if (!empty($_FILES[$formName]['tmp_name'])) {
                        $upload = wp_upload_bits($_FILES[$formName]['name'], null, file_get_contents($_FILES[$formName]['tmp_name']));

                        if (isset($upload['error']) && $upload['error'] != 0) {
                            wp_die('There was an error uploading your file. The error is: '.$upload['error']);
                        } else {
                            update_post_meta($post->ID, $formName, $upload['url']);
                        }
                    }
                } else {
                    if (!isset($_POST[$formName])) {
                        $_POST[$formName] = '';
                    }
                    if (isset($post->ID)) {
                        if (is_array($_POST[$formName])) {
                            $_POST[$formName] = implode(',', $_POST[$formName]);
                        }
                        update_post_meta($post->ID, $formName, $_POST[$formName]);
                    }
                }
            }

            $_SESSION['taxonomy_data'] = array();
        }
    }

    /**
     * Normalizes a given string.
     *
     * @param $string
     *
     * @return mixed
     *
     * @TODO Include in a separate class helper.
     */
    private function _normalize($string)
    {
        return strtolower(str_replace(' ', '_', $string));
    }

    /**
     * echo an $output.
     *
     * @param $output
     *
     * @return mixed
     *
     * @TODO Include in a separate class helper.
     */
    private function _print($output)
    {
        echo $output;
    }
}
