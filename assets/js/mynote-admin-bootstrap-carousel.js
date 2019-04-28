

(function($) {
    $(function() {

        'use strict';

        // Instantiates the variable that holds the media library frame.
        var metaImageFrame;
    
        // Runs when the media button is clicked.
        $('body').click(function(e) {

            // Get the btn
            var btn = e.target;
    
            // Check if it's the upload button
            if ( !btn || !$( btn ).attr('data-media-uploader-target') ) return;
    
            // Get the field target
            var field = $( btn ).data('media-uploader-target');

            // Prevents the default action from occuring.
            e.preventDefault();
    
            // Sets up the media library frame
            metaImageFrame = wp.media.frames.metaImageFrame = wp.media({
                title: meta_image.title,
                button: {text: 'Use this file'},
            });

            // Runs when an image is selected.
            metaImageFrame.on('select', function() {

                // Grabs the attachment selection and creates a JSON representation of the model.
                var media_attachment = metaImageFrame.state().get('selection').first().toJSON();
    
                // Sends the attachment URL to our custom image input field.
                //$(field).val(media_attachment.url);
                $(field).val(media_attachment.sizes['medium'].url);
                $(field + '-full').val(media_attachment.sizes['full'].url);

            });

            // Opens the media library frame.
            metaImageFrame.open();
        });

        $('#btn-add-mc').click(function() {
            var clone_field = $('#bmc-1').clone();

            // get the last DIV which ID starts with ^= "mynote-carousel"
            var mynote_carousel_div = $('div[id^="bmc"]:last');

            if (mynote_carousel_div.length == 1) {
                // Read the Number from that DIV's ID (i.e: 3 from "mynote-carousel-1")
                // And increment that number by 1
                var num = parseInt(mynote_carousel_div.attr('id').match(/\d+/g), 10) + 1;

                var clone_field = clone_field.attr('id', 'bmc-' + num);

                clone_field.find('button').attr('data-media-uploader-target', '#mynotecarousel-'  + num);
                clone_field.find('.mynote-carousel-image').attr('id', 'mynotecarousel-'  + num);
                clone_field.find('.mynote-carousel-image').attr('name', 'mynote_carousel_image['  + num + ']');
                clone_field.find('.mynote-carousel-title').attr('name', 'mynote_carousel_title['  + num + ']');
                clone_field.find('.mynote-carousel-description').attr('name', 'mynote_carousel_description['  + num + ']');

                $('#bootstrap-carousel-metabox').append(clone_field);
            }
        });
    });
})(jQuery);