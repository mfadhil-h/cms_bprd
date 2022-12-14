(function( $ ) {
	"use strict";

  // Attach a submit handler to the form
  $( "#form_add" ).submit(function( event ) {
    // Stop form from submitting normally
    event.preventDefault();
   
    // Get some values from elements on the page:
    var $form = $( this ),
      url = $form.attr( "action" );
   
    // Send the data using post
    $.ajax({
                  url: url,
                  dataType: "json",
                  method: "POST",
                  data: $form.serialize(),
                  success: function( data ) {
                      if (data.length === 0) {
                          alert('failed');
                      }else{
                          if(data.stat)
                          {
                            location.reload();
                          }else{
                            alert(data.msg);
                          }
                      }
                  }
            });
  });

  // Attach a submit handler to the form
  $( "#form_edit" ).submit(function( event ) {
   
    // Stop form from submitting normally
    event.preventDefault();
   
    // Get some values from elements on the page:
    var $form = $( this ),
      url = $form.attr( "action" );
   
    // Send the data using post
    $.ajax({
                  url: url,
                  dataType: "json",
                  method: "POST",
                  data: $form.serialize(),
                  success: function( data ) {
                      if (data.length === 0) {
                          alert('failed');
                      }else{
                          if(data.stat)
                          {
                            history.go(-1);
                          }else{
                            alert(data.msg);
                          }
                      }
                  }
            });
   
  });

	// Attach a submit handler to the form
  $( "#form_edit2" ).submit(function( event ) {
   
    // Stop form from submitting normally
    event.preventDefault();
   
    // Get some values from elements on the page:
    var $form = $( this ),
      url = $form.attr( "action" );
   
    // Send the data using post
    $.ajax({
                  url: url,
                  dataType: "json",
                  method: "POST",
                  data: $form.serialize(),
                  success: function( data ) {
                      if (data.length === 0) {
                          alert('failed');
                      }else{
                          if(data.stat)
                          {
                            history.go(-1);
                          }else{
                            alert(data.msg);
                          }
                      }
                  }
            });
   
  });

  $( "#btn_cancel" ).click(function (event) {
    event.preventDefault();
    history.go(-1);
  });

})(jQuery);