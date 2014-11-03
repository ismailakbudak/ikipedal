(function($) {
  //$( "[rel=popover]" ).popover('show');
  CapitiliazeFirst(["#pac-input", "#pac-input2"]);

  $(".reset").on('click', function() {
    var time1 = optionSaatMin; // $(this).data('min'),
    time2 = optionSaatMax; // $(this).data('max');
    obj.slider('setValue', [time1, time2]);
    setTimeValues(time1, time2);
    if (time1 == 24)
      time1 = 00;
    if (time2 == 24)
      time2 = 00;
    if (time1 < 10)
      time1 = '0' + time1;
    if (time2 < 10)
      time2 = '0' + time2;
    time1 = time1 + ":00";
    time2 = time2 + ":00";
    $(".trip-time #yaz").text(time1 + ' - ' + time2); 
    $("#datepicker").val("");
    $("input[type='radio'][value='all']").prop('checked', true);
    applyShowHide();
    setTimeout(function() {
      setOfferCount()
    }, 100);
    return false;
  });
 
  if (place2.status != 1 || strcmp("", destination) == 0)
    $("#change-direct").prop('disabled', true);
  // for time interval display
  function setTimeValues(min, max) {
    optionTimemin = min * 60 * 60;
    optionTimemax = max * 60 * 60;
  }
  var obj = $('#time-slider').slider()
    .on('slide', function(ev) {
      var time1 = ev.value[0];
      var time2 = ev.value[1];
      if (time1 == 24)
        time1 = 00;
      if (time2 == 24)
        time2 = 00;

      if (time1 < 10)
        time1 = '0' + time1;
      if (time2 < 10)
        time2 = '0' + time2;
      time1 = time1 + ":00";
      time2 = time2 + ":00";
      $(".trip-time #yaz").text(time1 + ' - ' + time2);

      setTimeValues(ev.value[0], ev.value[1]);

      time1 = ev.value[0] * 60 * 60;
      time2 = ev.value[1] * 60 * 60;

      var array = $("#allOffers").find('.list-group-item'),
        val,
        $id;
      for (var i = 0; i < array.length; i++) {
        val = $(array[i]).find('a').data('trip_time');
        $id = $(array[i]);
        $id.removeClass('no-trip_time');
        if (time1 <= val && val <= time2) {
          $id.removeClass('no-trip_time')
        } else {
          $id.addClass('no-trip_time')
        }
      };
      setOfferCount();
    }); 

  $(".show-date").on('click', function() {
    $("#dateAlert").slideToggle();
  });

  function setOfferCount() {
    var array = $("#allOffers").find('.list-group-item'),
      count = 0;
    for (var i = 0; i < array.length; i++) {
      $id = $(array[i]);
      if ( 
        !$id.hasClass("no-date") &&
        !$id.hasClass("no-time") && 
        !$id.hasClass("no-trip_date") &&
        !$id.hasClass("no-trip_time")) {
        count++;
      }
    };
    $("#offerCount").text(count);
    $("#offerCountBottom").find('.count').text(count);
    if (count >= 5) {
      $("#offerCountBottom").removeClass('none-display');
    } else {
      $("#offerCountBottom").addClass('none-display');
    }
    OfferMesaj(count);
  }

  // Right bottom alert-success message
  function OfferMesaj(text) {
    text = jQuery.trim(text);
    var dil = "Bilgilendirme !",
      offer = " teklif listelendi.";
    if (strcmp(er.lang, "en") == 0) {
      dil = "Information !",
      offer = "  offers listed.";
    }
    // Bottom message
    /*
    if ($(".msgGrowl-container").find(".msgGrowl").length <= 1) {
      $.msgGrowl({
        element: $('body').parent(),
        type: 'info', //$(this).attr ('data-type') // info success warning error
        title: dil,
        text: text.charAt(0).toUpperCase() + text.slice(1) + offer // capitialize first character
      });
    }
    */
  }

  $("#datepicker").datepicker({
    minDate: 0,
    maxDate: "+3M +10D",
    dateFormat: "yy-mm-dd",
    dayNames: dayNames,
    dayNamesMin: dayNamesMin,
    monthNames: monthNames,
    prevText: prevText,
    nextText: nextText
  }).on('change', function() {
      dateChange()
    });
  $(".trip-date .date-delete").on('click', function() {
    $("#datepicker").val("");
    dateChange();
  });

  function dateChange() {
    var val = $("#datepicker").val(),
      array = $("#allOffers").find('.list-group-item'),
      dataDate, $id;

    if (strcmp("", val) == 0) {
      for (var i = 0; i < array.length; i++) {
        $id = $(array[i]);
        $id.removeClass('no-trip_date');
      };
    } else {
      for (var i = 0; i < array.length; i++) {
        $id = $(array[i]);
        dataDate = $id.find('a').data('trip_date');
        $id.removeClass('no-trip_date');
        if (strcmp(dataDate, val) == 0)
          $id.removeClass('no-trip_date');
        else
          $id.addClass('no-trip_date');
      };
    }
    setOfferCount();
  } 
  // Time group show hide
  $("input[name='optionsRadiosTime']").on('click', function() {
    var option = $(this).val(),
      class_name = "no-time",
      data_name = 'time_group',
      array = $("#allOffers").find('.list-group-item'),
      val,
      $id;
    for (var i = 0; i < array.length; i++) {
      val = $(array[i]).find('a').data(data_name);
      $id = $(array[i]);
      $id.removeClass(class_name);
      if (strcmp("all", option) == 0) {
        $id.removeClass(class_name);
      } else {
        if (option == val) {
          $id.removeClass(class_name)
        } else {
          $id.addClass(class_name)
        }
      }
      // console.log( " İNLİST Time :" + option + " : "+ val );
    };
    setOfferCount();
  });
  // Date group show hide
  $("input[name='optionsRadiosDate']").on('click', function() {
    var option = $(this).val(),
      class_name = "no-date",
      data_name = 'date_group',
      array = $("#allOffers").find('.list-group-item'),
      val,
      $id;
    for (var i = 0; i < array.length; i++) {
      val = $(array[i]).find('a').data(data_name);
      $id = $(array[i]);
      $id.removeClass(class_name);
      if (strcmp("all", option) == 0) {
        $id.removeClass(class_name);
      } else {
        if (option == val) {
          $id.removeClass(class_name)
        } else {
          $id.addClass(class_name)
        }
      }
      // console.log( " İNLİST Date :" + option + " : "+ val );
    };
    setOfferCount();
  }); 

  $("#sortBy .sort").on('click', function() {
    $("#sorting").removeClass("none-display");
    var array = $("#allOffers").find('.list-group-item');
    if (array.length > 60) {
      $('body').modalmanager('loading');
    }

    for (var i = 0; i < array.length; i++) {
      $(array[i]).removeClass("no-date")
        .removeClass("no-time") 
        .removeClass("no-trip_date")
        .removeClass("no-trip_time");
    };
    try {
      var $id = $(this),
        type = $id.data('sort');
      if ($id.hasClass('active')) {
        if (strcmp(type, "ASC") == 0) {
          $id.data('sort', 'DESC');
          $id.find("i").removeClass("glyphicon-arrow-down").addClass("glyphicon-arrow-up");
        } else {
          $id.data('sort', 'ASC');
          $id.find("i").removeClass("glyphicon-arrow-up").addClass("glyphicon-arrow-down");
        }
      } else {
        $("#sortBy .sort").removeClass("active");
        $id.addClass("active");
      }
      setTimeout(function() {
        sortList($id);
      }, 100);
    } catch (err) {
      HataMesaj(er.error_occurred);
    }

    return false;
  });
  // after the new arrange display data or hide
  function applyShowHide() {
    var array = $("#allOffers").find('.list-group-item'), 
      trip_date = $("#datepicker").val(), 
      time_group = $("input[name='optionsRadiosTime']:checked").val(),
      date_group = $("input[name='optionsRadiosDate']:checked").val(), 
      tempValue, $id, $data;
    // geçiçi değerler
    var   dataDateGroup, dataDate, dataTrip_time;
    for (var i = 0; i < array.length; i++) {
      $data = $(array[i]).find('a');
      $id = $(array[i]); 
      dataDateGroup = $data.data('date_group');
      dataTimeGroup = $data.data('time_group'); 
      dataDate = $data.data('trip_date');
      dataTrip_time = $data.data('trip_time'); 
      $id.removeClass('no-date');
      $id.removeClass('no-time'); 
      $id.removeClass('no-trip_date');
      $id.removeClass('no-trip_time');
      // for trip_time
      if (optionTimemin <= dataTrip_time && dataTrip_time <= optionTimemax) {
        $id.removeClass('no-trip_time');
      } else {
        $id.addClass('no-trip_time');
      }
      // for trip_date
      if (strcmp("", trip_date) == 0) {
        $id.removeClass('no-trip_date');
      } else {
        if (strcmp(dataDate, trip_date) == 0)
          $id.removeClass('no-trip_date');
        else
          $id.addClass('no-trip_date');
      } 
      // date_group için
      if (strcmp("all", date_group) == 0) {
        $id.removeClass('no-date');
      } else {
        if (date_group == dataDateGroup) {
          $id.removeClass('no-date')
        } else {
          $id.addClass('no-date')
        }
      }
      // for time_group
      if (strcmp("all", time_group) == 0) {
        $id.removeClass('no-time');
      } else {
        if (time_group == dataTimeGroup) {
          $id.removeClass('no-time')
        } else {
          $id.addClass('no-time')
        }
      } 
    };
  }

  function sortList($id) {
    try {
      var ul = "allOffers";
      var on = $id.data('on');
      var type = $id.data('sort');
      if (typeof ul == "string")
        ul = document.getElementById(ul);
      var lis = ul.getElementsByTagName("LI");
      var vals = [];
      for (var i = 0, l = lis.length; i < l; i++)
        vals.push(lis[i].innerHTML);

      var boolValid = false;
      if (strcmp(on, "date") == 0) {
        vals.sort(SortByDate);
        boolValid = true;
      } 
      else
        boolValid = false;
      if (boolValid) {
        if (strcmp("DESC", type) == 0)
          vals.reverse();
        for (var i = 0, l = lis.length; i < l; i++)
          lis[i].innerHTML = vals[i];
        //console.log( "Tip : "+ on +" Sorted : " + type  );
        $('[rel=popover]').popover();
        applyShowHide();
        setTimeout(function() {
          $("#sorting").addClass("none-display");
          if (vals.length > 60) {
            $('body').modalmanager('loading');
          }
        }, 400);
      }
    } catch (err) { 
      HataMesaj(er.error_occurred);
    }
  }

  //This will sort your array
  function SortByDate(a, b) {
    var aName = $(a).data('date');
    var bName = $(b).data('date');
    return ((aName < bName) ? -1 : ((aName > bName) ? 1 : 0));
  }
  
})(jQuery); 