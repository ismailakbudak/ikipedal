  (function($) {

    // face login
    $('#face , #test').on('click', function(event) {
      event.preventDefault();
      event.stopPropagation();
      $.msgGrowl({
        element: $(this).parent(),
        type: 'error', //$(this).attr ('data-type') // info success warning error
        title: 'Header',
        text: 'DEnemem text'
      });

    });


    /*buttonFindRide Click
     ======================================== */
    $('#buttonFindRide').on('click', function() {
      window.location = base_url + "main";
      window.scrollTo(0, 100, 0); // move to (x,y)
      $('#pac-input').focus();
    });

    $.fn.modal.defaults.spinner = $.fn.modalmanager.defaults.spinner =
      '<div class="loading-spinner" style="width: 200px; margin-left: -100px;">' +
      '<div class="progress progress-striped active">' +
      '<div class="progress-bar" style="width: 100%;"></div>' +
      '</div>' +
      '</div>';
    $.fn.modalmanager.defaults.resize = true;


  })(jQuery);