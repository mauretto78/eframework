jQuery(function($) {

    /**
     * Instantiate mediaUploader.
     */
    var btn = $('.btn-upload'),
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
                fileName = attachment.filename,
                fileUrl = attachment.url;

            $this.prev().val(fileName);

            if(fileType == 'image'){
                $this.next().html('<div class="thumbnail" style="background-image: url(\''+fileUrl+'\');"><span title="delete this image" class="thumbnail-delete"><i class="fa fa-times"></i></span></div>');
                $this.addClass('margin-top-15');
            } else {
                $this.next().text(fileName);
            }

        });

        // Open mediaUploader.
        if(mediaUploader){
            mediaUploader.open();
            return;
        }

        e.preventDefault();
    });
});