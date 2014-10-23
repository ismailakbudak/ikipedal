   (function($) {
 
       $(".datepicker").datepicker({
           minDate: 0,
           maxDate: "+2M +10D",
           dateFormat: "yy-mm-dd",
           dayNames: dayNames,
           dayNamesMin: dayNamesMin,
           monthNames: monthNames,
           prevText: prevText,
           nextText: nextText
       });
       $(".exit-alert").on('click', function() {
           $(this).closest(".copy-date").slideUp();
           return false;
       });
       $(".copy-alert").on('click', function() {
           $(this).parent().find(".copy-date").slideToggle();
           return false;
       });

       $(".show-offer").on('click', function() {
           $(this).parent().parent().find(".offers").slideToggle();
           return false;
       });

      $("#createAlert").on('click', function() {

          $.ajax({
            type: "POST",
            dataType: "text",
            url: base_url + 'alert/create',
            data: {
              date: $("#datepickerAlert").val()
            },
            cache: false,
            success: function(answer) {
              if (strcmp(enviroment, 'development') == 0) {
                alert(answer);
              }
              result = JSON.parse(answer);
              if (strcmp(result.status, 'success') == 0) {
                BasariMesaj(result.text)
              } // show bottom alert 
              else if (strcmp(result.status, 'fail') == 0) {
                HataMesaj(result.text)
              } // show bottom alert
              else if (strcmp(result.status, 'error') == 0) {
                HataMesaj(result.message)
              } // show bottom alert
              else {
                HataMesaj(er.error_send)
              } // show bottom alert   
            },
            error: function() {
              HataMesaj(er.error_send);
            }
          });

        });

       //delete-alert
       $(".delete-alert").on('click', function() {
           var alert_id = $(this).parent().data('id'),
               data = {
                   alert_id: alert_id
               },
               url = 'alert/delete',
               result = JSON.parse(AjaxSendJson(url, data));
           if (strcmp(result.status, 'success') == 0) {
               location.reload(true)
           } // reload page
           else if (strcmp(result.status, 'fail') == 0) {
               HataMesaj(result.text)
           } // show bottom alert
           else if (strcmp(result.status, 'error') == 0) {
               HataMesaj(result.message)
           } // show top
           else {
               HataMesaj(er.error_send)
           } // show bottom alert  

           return false;
       });
       //copy-alert
       $(".inputSave").on('click', function() {
           var alert_id = $(this).data('id'),
               date = $(this).prev(".datepicker").val(),
               data = {
                   alert_id: alert_id,
                   date: date
               },
               url = 'alert/copy',
               result = JSON.parse(AjaxSendJson(url, data));
           if (strcmp(result.status, 'success') == 0) {
               location.reload(true)
           } // reload page
           else if (strcmp(result.status, 'fail') == 0) {
               HataMesaj(result.text)
           } // show bottom alert
           else if (strcmp(result.status, 'error') == 0) {
               HataMesaj(result.message)
           } // show top
           else {
               HataMesaj(er.error_send)
           } // show bottom alert  

           return false;
       });

   })(jQuery);