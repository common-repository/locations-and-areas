//Dismiss
jQuery(document).on('click', '.laa-getting-started-notice .notice-dismiss', function() {
    jQuery.ajax({
        url: ajaxurl,
        data: {
            action: 'laa_dismiss_getting_started_notice'
        }
    });
});

//Map Style Preview
jQuery(document).on('change', '#laa_map_style', function() {
  jQuery('#laa_map_style_preview').attr('data-style', this.value);
});

//Media Uploader
jQuery(function($){
  $('body').on('click', '.laa_upload_image_button', function(e){
      e.preventDefault();

      var button = $(this),
      image_uploader = wp.media({
          title: 'Custom image',
          library : {
              type : 'image'
          },
          button: {
              text: 'Use this image'
          },
          multiple: false
      }).on('select', function() {
          var attachment = image_uploader.state().get('selection').first().toJSON();
          var url = attachment.sizes.large ? attachment.sizes.large.url : attachment.sizes.full.url;
          $('#laa_location_image').val(url);
          $('#laa_location_image_preview').addClass('has-image');
          $('#laa_location_image_preview').html('<img src="' +  url + '">');
      })
      .open();
  });
});