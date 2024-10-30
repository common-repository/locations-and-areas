document.addEventListener('DOMContentLoaded', function(e) {
  
  // Event: "Add Location"-Form send
  jQuery('#laa_add_location').submit(function(event) {

    event.preventDefault();
    let formData = new FormData(this);

    formData.append('action','laa_add_location_from_frontend');

    jQuery.ajax({
      type: 'POST',
      url: laa_ajax.ajaxurl,
      cache: false,
      contentType: false,
      processData: false,
      data: formData,
      success: function (response, textStatus, XMLHttpRequest) {
        if(response.success == false) {
          laaShowError(response.data);
        }
        if(response.success == true) {
          jQuery('#laa_add_location').trigger('reset');
          laaShowThankYou();
        }
      },
      error: function (XMLHttpRequest, textStatus, errorThrown) { 
        console.log(errorThrown);
      }
    });
  });

  function laaShowThankYou() {
    jQuery('#laa_add_location').hide();
    jQuery('#laa_add_location_error').hide();
    jQuery('#laa_add_location_thankyou').show();
  }

  function laaShowError(errors) {
    const errorWrapEl = jQuery('#laa_add_location_error');
    errorWrapEl.html('');
    errors.forEach(error => {
      errorWrapEl.append(error.message + '<br>');
    });
    errorWrapEl.show();
  }
});