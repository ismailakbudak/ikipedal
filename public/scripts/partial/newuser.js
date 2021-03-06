             /// SOURCE application_file/views/signup/
            /**********************  new_password.php  *****************************/

            $(function() {
              $('#buttonSendPassword').on('click', function() {
                var newPassword = $('#inputPassword'),
                  newPassword2 = $('#inputPasswordAgain');
                var boolValid = true;
                boolValid = boolValid && FillKontrolParent(newPassword, er.blank_pass);
                boolValid = boolValid && FillKontrolParent(newPassword2, er.blank_pass);
                boolValid = boolValid && LengthKontrolParent(newPassword, 6, er.pass_length);
                boolValid = boolValid && MatchKontrolParent(newPassword, newPassword2, er.pass_match);
                if (boolValid) {
                  var data = {
                      newPassword: newPassword.val(),
                      new_data: new_data
                    },
                    url = 'user/new_password',
                    result = JSON.parse(AjaxSendJson(url, data));
                  if (strcmp(result.status, 'success') == 0) {
                    BasariMesaj(result.text)
                  } else if (strcmp(result.status, 'fail') == 0) {
                    HataMesaj(result.text)
                  } else if (strcmp(result.status, 'error') == 0) {
                    HataMesaj(result.message);
                  } else {
                    HataMesaj(er.error_send)
                  }
                } else
                  HataMesaj(er.edit_info);
              });
            });

             /// SOURCE application_file/views/signup/
            /**********************  newuser.php  *****************************/
            (function($) {

              $('#inputName').focus();

              $('#inputSurname').on('change', function() {
                $(this).val($(this).val().toUpperCase());
              });
              $('#inputName').on('change', function() {
                var string = jQuery.trim($(this).val());
                string = string.charAt(0).toUpperCase() + string.slice(1);
                $(this).val(string);
              });
              $("#captchaNew").on('click', function() {
                createCaptcha();
                $('#inputCap').val("");
                return false;
              });

              function createCaptcha() {
                $('#inputCap').focus();
                $.ajax({
                  type: "POST",
                  url: base_url + 'signup/createCaptcha',
                  dataType: "text",
                  cache: false,
                  data: {
                    xx: 'test'
                  },
                  success: function(answer) {
                    document.getElementById("captchaDiv").innerHTML = answer;
                  },
                  error: function() {
                    HataMesaj('body', 'error', er.error, er.error_send);
                  },
                  complete: function() {}
                });
              }
              /*Kullanıcı kayıt işlemi
             ======================================== */
              $('#inputSignup').on('click', function() {

                var thisID = this,
                  sex = $('#inputSex'),
                  name = $('#inputName'),
                  surname = $('#inputSurname'),
                  pass = $('#inputPassword'),
                  pass2 = $('#inputPasswordAgain'),
                  email = $('#inputEmail'),
                  birth = $('#inputBirthYear'),
                  cap = $('#inputCap');

                var boolValid = true;
                boolValid = boolValid && SelectKontrol(sex, er.sel_sex);
                boolValid = boolValid && FillKontrol(name, er.blank_name);
                boolValid = boolValid && FillKontrol(surname, er.blank_surname);
                boolValid = boolValid && EmailKontrol(email, er.invalid_email);
                boolValid = boolValid && FillKontrol(pass, er.blank_pass);
                boolValid = boolValid && LengthKontrol(pass, 6, er.pass_length);
                boolValid = boolValid && MatchKontrol(pass, pass2, er.pass_match);
                boolValid = boolValid && SelectKontrol(birth, er.sel_birth);
                boolValid = boolValid && FillKontrolParent(cap, er.blank_cap);

                if (boolValid) {
                  $('#loading').modal();
                  var dataForm = {
                    sex: sex.val(),
                    name: name.val(),
                    surname: surname.val(),
                    password: pass.val(),
                    email: email.val(),
                    birthyear: birth.val(),
                    captcha: cap.val()
                  };
                  $.ajax({
                    type: "POST",
                    url: base_url + 'signup/createUser',
                    dataType: "text",
                    cache: false,
                    data: dataForm,
                    success: function(result) {
                      if (strcmp(enviroment, 'development') == 0) {
                        alert(result);
                      }
                      var answer = JSON.parse(result);
                      if (strcmp(answer.status, 'success') == 0) {
                        window.location = base_url; //Redirect(base_url + 'login/?result=1');
                      } else if (strcmp(answer.status, 'emailusing') == 0) {
                        Hata($('#inputEmail').parent(), er.email_using);
                      } else if (strcmp(answer.status, 'fail') == 0) {
                        HataMesaj(thisID, 'error', er.error, er.sign_failed);
                      } else if (strcmp(answer.status, 'mistake') == 0) {
                        Hata(cap.parent().parent(), er.wrong_cap);
                        createCaptcha();
                        cap.val("");
                      } else if (strcmp(answer.status, 'error') == 0) {
                        HataMes($('#message'), answer.message);
                      } else {
                        HataMesaj(thisID, 'error', er.error, er.sign_failed);
                      }
                    },
                    error: function() {
                      HataMesaj(thisID, 'error', er.error, er.error_send);
                    },
                    complete: function() {
                      $('#loading').modal('toggle');
                    }
                  });
                } else {
                  HataMesaj(this, 'warning', er.warning, er.edit_info);
                }

                return false; // don't refresh form

              }); /***** End Kullanıcı kayıt işlemi  *************/


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

              function SelectKontrol(id, mesaj) {
                if (id.val() == "" || id.val() == "0") {
                  Hata(id.parent(), mesaj);
                  return false;
                } else {
                  return true;
                }
              }

              function FillKontrol(id, mesaj) {
                if (id.val() == "" || id.val() == "0") {
                  Hata(id.parent(), mesaj);
                  return false;
                } else {
                  return true;
                }
              }

              function IntegerKontrol(id, mesaj) {
                if (isNaN(id.val()) == true || id.val() == "") {
                  Hata(id, mesaj);
                  return false;
                } else {
                  return true;
                }
              }

              function LengthKontrol(id, length, mesaj) {
                if (id.val().length >= parseInt(length)) {
                  return true;
                } else {
                  Hata(id.parent(), mesaj);
                  return false;
                }
              }

              function MatchKontrol(id1, id2, mesaj) {
                if (id1.val() == id2.val()) {
                  return true;
                } else {
                  Hata(id1.parent(), mesaj);
                  Hata(id2.parent(), mesaj);
                  return false;
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
            /**********************End of the  newuser.php  *****************************/


            /**********************  password.php  *****************************/
            $(function() {

              $("#buttonSend").on('click', function() {
                var email = $("#inputEmail"),
                  boolValid = true;
                boolValid = boolValid && EmailKontrol(email, er.invalid_email);
                if (boolValid) {
                  var data = {
                      email: email.val()
                    },
                    url = 'signup/forgotPasswordAction';
                  $('#message').append(loader);

                  $.ajax({
                    type: "POST",
                    url: base_url + url,
                    dataType: "text",
                    cache: false,
                    data: data,
                    success: function(result) {
                      if (strcmp(enviroment, 'development') == 0)
                        alert(result);
                      result = JSON.parse(result);
                      if (strcmp(result.status, 'success') == 0)
                        Basari($('#message'), result.text);
                      else if (strcmp(result.status, 'mistake') == 0)
                        HataMes($('#message'), result.text);
                      else if (strcmp(result.status, 'fail') == 0)
                        Hata(email.parent(), result.message);
                      else
                        HataMesaj(er.error_send)
                      email.val("");
                    },
                    error: function() {
                      HataMesaj(er.error_send)
                    },
                    complete: function() {
                      $('#message').find('#sending').remove();
                    }
                  });
                } else
                  HataMesaj(er.edit_info);

                return false;
              });
            });
            /********************** End of the password.php  *****************************/