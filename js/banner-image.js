jQuery(document).ready(function($) {
    $('#meta-image-button').click(function(e) {
        e.preventDefault();
        var image_frame;
        if (image_frame) {
            image_frame.open();
            return;
        }
        image_frame = wp.media({
            title: 'Select or Upload Image',
            button: {
                text: 'Use This Image'
            },
            multiple: false
        });
        image_frame.on('select', function() {
            var attachment = image_frame.state().get('selection').first().toJSON();
            $('#meta-image').val(attachment.url);
            $('#meta-image-preview').attr('src', attachment.url);
        });
        image_frame.open();
    });
    $('#remove-banner-image').on('click', function(e){
        e.preventDefault();
        //$('input#meta-image-button').show();
        $('#meta-image').val('');
        $('#meta-image-preview').attr('src', '');
        $(this).hide();
    });
});