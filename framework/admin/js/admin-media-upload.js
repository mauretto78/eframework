jQuery(document).ready(function($){

    /**
     * Instantiate mediaUploader.
     */
    var btn = $('.media-upload'),
        sliderSortable = $('#ef-slider-sortable'),
        mediaUploader = wp.media.frames.file_frame = wp.media({
            title: 'Choose a file',
            button: {
                text:'Upload a file'
            },
            multiple: false
        });

    /**
     * Call mediaUploader on click on every .media-upload button.
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
    $('.upload-file-path').on("click", ('.delete-file'), function(e) {

        var $this = $(this),
            group = $this.parents('.ef-group'),
            filePath = $this.parents('.upload-file-path');

        filePath.prev().removeClass('margin-top-15');
        filePath.html('');
        group.find('.upload-value').val('');

        e.preventDefault();
    });

    /**
     * Call mediaUploader on click on every #ef-slider-sortable .media-upload button.
     */
    sliderSortable.on("click", ('.media-upload'), function(e) {

        var $this = $(this);

        // Fill corresponding hidden field with the selected file path.
        mediaUploader.on('select',function () {
            attachment = mediaUploader.state().get('selection').first().toJSON();

            var efSlide = $this.parents('.ef-slide-img'),
                efSlideValue = efSlide.prev(),
                fileType = attachment.type,
                fileUrl = attachment.url;

            if(fileType == 'image'){
                efSlideValue.val(fileUrl);
                efSlide.html('<div class="thumbnail" style="background-image: url(\''+fileUrl+'\');"><span title="delete this image" class="thumbnail-delete delete-file"><i class="fa fa-times"></i></span></div>');
            } else {
                console.log('Only images allowed!');
            }

        });

        // Open mediaUploader.
        if(mediaUploader){
            mediaUploader.open();
            return;
        }

        e.preventDefault();
    });


    sliderSortable.on("click", ('.delete-file'), function(e) {

        var $this = $(this),
            efSlide = $this.parents('.ef-slide-img'),
            efSlideValue = efSlide.prev();

        efSlideValue.val('');
        efSlide.html('<a class="media-upload">upload</a>');

        e.preventDefault();
    });
});