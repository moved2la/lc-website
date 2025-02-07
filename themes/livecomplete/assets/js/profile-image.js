jQuery(document).ready(function($) {
    // Upload image
    $('#upload_profile_image_button').click(function(e) {
        e.preventDefault();
        var image = wp.media({
            title: 'Select or Upload Profile Image',
            multiple: false
        }).open().on('select', function() {
            var uploaded_image = image.state().get('selection').first();
            var image_url = uploaded_image.get('url');
            $('#custom_profile_image').val(image_url);
            $('.profile-image-container img').remove();
            $('.profile-image-container').prepend('<img src="' + image_url + '" style="max-width: 150px; height: auto; margin-bottom: 10px;">');
            $('#remove_profile_image_button').show();
        });
    });

    // Remove image
    $('#remove_profile_image_button').click(function(e) {
        e.preventDefault();
        $('#custom_profile_image').val('');
        $('.profile-image-container img').remove();
        $(this).hide();
    });
}); 