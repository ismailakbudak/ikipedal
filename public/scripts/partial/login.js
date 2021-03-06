(function($) {


  $('#inputLoginEmail').focus();

  /*Kullanıcı Giriş işlemi
     ======================================== */
  $('#buttonLogin').on('click', function() {
    var thisID = this,
      pass = $('#inputLoginPassword'),
      email = $('#inputLoginEmail');

    var boolValid = true;
    boolValid = boolValid && EmailKontrol(email, er.invalid_email);
    boolValid = boolValid && FillKontrol(pass, er.blank_pass);

    if (boolValid) {

      var dataLogin = {
        password: pass.val(),
        email: email.val()
      };

      $.ajax({
        type: "POST",
        url: base_url + 'login/checkLogin',
        dataType: "text",
        cache: false,
        data: dataLogin,
        success: function(result) {
          if (strcmp(enviroment, 'development') == 0) {
            alert(result);
          }
          var answer = JSON.parse(result);
          if (strcmp(answer.status, 'login') == 0) {
            window.location = base_url + "main/";
          } else if (strcmp(answer.status, 'not-active') == 0) {
            HataMesajModal(thisID, answer.text);
          } else if (strcmp(answer.status, 'ban') == 0) {
            Hata($('#loginError'), er.ban);
          } else if (strcmp(answer.status, 'error') == 0) {
            Hata($('#loginError'), er.wrong_data);
          } else if (strcmp(answer.status, 'error2') == 0) {
            HataMes($('#message'), answer.message);
          } else {
            HataMesaj(thisID, er.error_send)
          }
        },
        error: function() {
          HataMesaj(thisID, 'error', er.error, er.error_send);
        }
      });
    } else {
      HataMesaj(thisID, 'warning', er.warning, er.edit_info);
    }

    return false;
  }); /***** End Kullanıcı giriş işlemi  *************/


  /** Kontrollerin başlangıcı
        ====================================*/ //
  function Redirect(url) {
    window.location = url;
  }

  function HataMesaj(id, type, title, text) {
    text = jQuery.trim(text);
    if ($(".msgGrowl-container").find(".msgGrowl").length <= 1) {
      $.msgGrowl({
        element: $(id).parent(),
        type: type, //$(this).attr ('data-type') // info success warning error
        title: title,
        text: text.charAt(0).toUpperCase() + text.slice(1)
      });
    }
  }
  /*
          function strcmp ( str1, str2 ) {
              str1 = str1.trim();
              str2 = str2.trim();
              return ( ( str1 == str2 ) ? 0 : ( ( str1 > str2 ) ? 1 : -1 ) );
          } 
          */
  function Hata(id, text) {
    text = jQuery.trim(text);
    var error = '<div id="alert" class="alert alert-dismissable alert-danger"> ' + ' <button type="button" class="close" data-dismiss="alert">&times;</button> ' + '<strong>Opps.. </strong> ' + text.charAt(0).toUpperCase() + text.slice(1) + '</div>';
    id.parent().addClass('has-error')
      .append(error);
    setTimeout(function() {
      id.parent().removeClass("has-error", 3000);
      id.parent().find('#alert').remove();
    }, 3000);
  }

  function FillKontrol(id, mesaj) {
    if (id.val() == "" || id.val() == "0") {
      Hata(id.parent(), mesaj);
      return false;
    } else {
      return true;
    }
  }


  function EmailKontrol(id, mesaj) {
    if (!id.val().match(/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/)) {
      Hata(id.parent(), mesaj);
      return false;
    } else {
      return true;
    }
  }
  /***** Kontrollerin sonu 
            ==================================****/

})(jQuery);