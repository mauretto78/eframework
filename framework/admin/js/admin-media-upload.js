jQuery(function($) {

    /**
     * Instantiate mediaUploader.
     */
    var btn = $('.btn-upload'),
        deleteFile = $('.delete-file'),
        mediaUploader = wp.media.frames.file_frame = wp.media({
            title: 'Choose a file',
            button: {
                text:'Upload a file'
            },
            multiple: false
        });

    /**
     * Call mediaUploader on click on every .btn-upload button.
     */
    btn.on("click",function(e){

        var $this = $(this);

        // Fill corresponding hidden field with the selected file path.
        mediaUploader.on('select',function () {
            attachment = mediaUploader.state().get('selection').first().toJSON();

            var fileType = attachment.type,
                fileUrl = attachment.url;

            $this.prev().val(fileUrl);

            if(fileType == 'image'){
                $this.next().html('<div class="thumbnail" style="background-image: url(\''+fileUrl+'\');"><span title="delete this image" class="thumbnail-delete delete-file"><i class="fa fa-times"></i></span></div>');
                $this.addClass('margin-top-15');
            } else {
                $this.next().html(fileUrl+' <br><a href="#" class="delete-file">Delete this file</a>');
            }

        });

        // Open mediaUploader.
        if(mediaUploader){
            mediaUploader.open();
            return;
        }

        e.preventDefault();
    });

    /**
     * Delete file by clicking delete button.
     */
    $('.upload-file-path').delegate(deleteFile, "click", function(e) {

        var $this = $(this),
            group = $this.parents('.ef-group');

        $this.prev().removeClass('margin-top-15');
        $this.html('');
        group.find('.upload-value').val('');

        e.preventDefault();
    });
});