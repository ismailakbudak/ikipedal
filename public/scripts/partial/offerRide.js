(function($) {

  CapitiliazeFirst(["#pac-input", "#pac-input2", "#inputEventName", "#inputExplainGoing"]);

  $("#inputContinue").on('click', function() {


    var totalDistance = $("#totalDistance").text(),
      totalTime = $("#totalTime").text(),
      DistancesWay = "",
      TimesWay = "",
      distances = $("#total").find(".row").find(".distance"),
      times = $("#total").find(".row").find(".time");

    if (distances.length > 1) {
      for (var i = 0; i < distances.length; i++) {
        DistancesWay += $(distances[i]).text();
        TimesWay += $(times[i]).text();
        if (i < distances.length - 1) {
          DistancesWay += '?';
          TimesWay += '?';
        }
      };
    }

    var startPoint = $('#pac-input'),
      destinationPoint = $('#pac-input2'),
      array = $('#iteneraryPanel').find('.wayPoint'),
      wayPointsString = '';

    for (var i = 0; i < array.length; i++) {
      if (i != array.length - 1)
        wayPointsString += $(array[i]).val() + "?";
      else
        wayPointsString += $(array[i]).val();
    }
    var lengthTotal = $("#total").children().length,
      textTotal = $("#total").text();
    if (lengthTotal == 0) {
      Hata($("#total"), er.blank_travel);
      return false;
    }
    var isTwoway,
      startDate = $("#datepickerStart"),
      startDateTimeHour = $("#datepickerStartTimeHour"),
      startDateTimeMinute = $("#datepickerStartTimeSecond"),
      endDate = $("#datepickerEnd"),
      endDateTimeHour = $("#datepickerEndTimeHour"),
      endDateTimeMinute = $("#datepickerEndTimeSecond"),
      inputName = $('#inputEventName'),
      inputExplainGoing = $('#inputExplainGoing'),
      inputEventType = $('#inputEventType'),
      trip_type = 0;
    if ($('input[name=twoWayCheck]:checked').val() == 'on')
      isTwoway = true;
    else
      isTwoway = false;


    var boolValid = true;
    boolValid = boolValid && FillKontrol(inputName, er.blank_name);
    boolValid = boolValid && FillKontrol(startPoint, er.blank_start_point);
    boolValid = boolValid && FillKontrol(destinationPoint, er.blank_destination_point);
     
 
    //console.log(JSON.stringify(locations, null, 4));
    if (locations.length < 2) {
      HataMesaj(er.locations);
      return false;
    }
    if ($("#radiosOnetime").is(":checked") === true) {
      trip_type = 0;
    } else {
      trip_type = 1;
    }
    boolValid = boolValid && FillKontrolParent(startDate, er.blank_start_date);
    if (isTwoway) {
      boolValid = boolValid && FillKontrolParent(endDate, er.blank_return_date);
      boolValid = boolValid && SameData(endDate, startDate, er.same_date);
    }
    if (boolValid) {
      var dataForm = {
          trip_type: trip_type,
          round_trip: isTwoway,
          origin: startPoint.val(),
          destination: destinationPoint.val(),
          name: inputName.val(),
          event_type: inputEventType.val(),
          explain_departure: inputExplainGoing.val(),
          way_points: wayPointsString,
          departure_date: startDate.val(),
          departure_time: startDateTimeHour.val() + ":" + startDateTimeMinute.val(),
          return_date: endDate.val(),
          return_time: endDateTimeHour.val() + ":" + endDateTimeMinute.val(),
          locations: locations,
          total_distance: totalDistance,
          total_time: totalTime,
          DistancesWay: DistancesWay,
          TimesWay: TimesWay
        },
        url = 'offersAjax/createEvent',
        result = JSON.parse(AjaxSendJson(url, dataForm));

      if (strcmp(result.status, 'success') == 0) {
        window.location = base_url + result.path;
      } else if (strcmp(result.status, 'fail') == 0) {
        HataMesaj(er.fail)
      } else if (strcmp(result.status, 'error') == 0) {
        HataMesaj(result.message);
      } else if (strcmp(result.status, 'login') == 0) {
        $('#login').modal('toggle');
      } else {
        HataMesaj(er.error_send)
      }
    } else {
      //HataMesaj(er.edit_info);
    }
    return false;
  });

  function SameData(endDate, startDate, mesaj) {
    if (endDate.val() == startDate.val()) {
      var startDateTimeHour = $("#datepickerStartTimeHour"),
        endDateTimeHour = $("#datepickerEndTimeHour");
      if (startDateTimeHour.val() <= endDateTimeHour.val() - 1) {
        return true;
      } else {
        Hata(endDate.parent().parent().parent(), mesaj);
        return false;
      }
    } else {
      return true;
    }
  }

  function SameDay(id, endDate, startDate, mesaj) {
    if (endDate.val() == startDate.val()) {
      Hata(id, mesaj);
      return false;
    } else {
      return true;
    }
  }
  $("#twoWayCheck").attr('checked', true);
  $("#datepickerStart").datepicker({
    minDate: 0,
    maxDate: "+2M +10D",
    dateFormat: "yy-mm-dd",
    dayNames: dayNames,
    dayNamesMin: dayNamesMin,
    monthNames: monthNames,
    prevText: prevText,
    nextText: nextText
  });
  $("#datepickerEnd").datepicker({
    minDate: 0,
    maxDate: "+3M +10D",
    dateFormat: "yy-mm-dd",
    dayNames: dayNames,
    dayNamesMin: dayNamesMin,
    monthNames: monthNames,
    prevText: prevText,
    nextText: nextText
  });
  $("#datepickerEnd").on('mouseover', function() {
    $(this).datepicker("option", "minDate", $("#datepickerStart").val());
  });


  $("#twoWayCheck").on('click', function() {
    if ($(this).is(':checked') === true) {
      $("#returnDate").slideDown();
    } else {
      $("#returnDate").slideUp();
    }
  });

  $("#pac-input, #pac-input2").on('keydown', function() {
    $("#total").children().remove();
    $("#total").text('');
  });

  var sayi = 0;
  MakeAutoComplete('pac-input');
  MakeAutoComplete('pac-input2');
  mapDraw();
  $('#buttonAdd').on('click', function() {
    $("#total").children().remove();
    $("#total").text('');
    sayi = sayi + 1;
    var value = '  <div class="form-group form-padding wayPoints">  ' +
      '    <div class="input-group">  ' +
      '       <input id="wayPoint' + sayi + '" type="text" class="form-control wayPoint" placeholder="' + er.position + '">  ' +
      '       <span class="input-group-btn">  ' +
      '           <button class="btn btn-danger minus" type="button">X</button>  ' +
      '       </span>  ' +
      '     </div>  ' +
      '    </div> ';

    $('#iteneraryPanel').append(value);

    CapitiliazeFirst(["#wayPoint" + sayi]);

    ActivateRemove();
    var id = 'wayPoint' + sayi;
    MakeAutoComplete(id);
    $("#" + id).focus();
  });


  // after the adding we need to initialize that it has a click event
  function ActivateRemove() {
    $('#iteneraryPanel').find('.wayPoint').on('keydown', function() {
      $("#total").children().remove();
      $("#total").text('');
    });
    $('.minus').on('click', function() {
      $(this).parent().parent().parent().remove()
      mapDraw();
    });
  }

  // silme işlemleri için metot
  function mapDraw() {
    function initialize() {
      var mapOptions = {
        center: new google.maps.LatLng(39, 35),
        scrollwheel: false,
        zoom: 5
      };
      var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
      var types = "";
      map.controls[google.maps.ControlPosition.TOP_LEFT].push(types);
      var directionsDisplay;
      var directionsService = new google.maps.DirectionsService();
      var start = document.getElementById('pac-input').value,
        end = document.getElementById('pac-input2').value;

      var param = [];
      var array = $('#iteneraryPanel').find('.wayPoint');

      for (var i = 0; i < array.length; i++) {
        param.push({
          location: $(array[i]).val()
        });
      };
      directionsDisplay = new google.maps.DirectionsRenderer();
      map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
      directionsDisplay.setMap(map);
      var request = {
        origin: start,
        destination: end,
        waypoints: param,
        travelMode: google.maps.TravelMode.DRIVING
      };
      directionsService.route(request, function(response, status) {
        if (status == google.maps.DirectionsStatus.OK) {
          directionsDisplay.setDirections(response);
          /* Toplma mesafeyi yazdırma */
          var result = directionsDisplay.getDirections();
          var total = 0,
            minute = 0,
            text = "";
          var myroute = result.routes[0];
          var j = 0;
          for (var i = 0; i < myroute.legs.length; i++) {
            total += myroute.legs[i].distance.value;
            minute += parseInt(myroute.legs[i].duration.value);
            if (param.length == 0) {
              if (strcmp(er.lang, "en") == 0)
                text += "  " + myroute.legs[i].duration.text.replace('gün', 'day').replace('saat', 'hour').replace('dakika', 'minute');
              else
                text += "  " + myroute.legs[i].duration.text;
            } else {
              if (strcmp(er.lang, "en") == 0)
                text += "  " + myroute.legs[i].duration.text.replace('gün', 'day').replace('saat', 'hour').replace('dakika', 'minute');
              else
                text += "  " + myroute.legs[i].duration.text;
              text += " ";
              if (j < param.length) {
                text += " <div>  >>>>>>>>>  " + param[j]['location'] + "   >>>>>>>>>   </div>";
                j += 1;
              }
            }
          }

          var hour = Math.floor(minute / 3600),
            min = Math.ceil((minute % 3600) / 60);
          total = total / 1000.0;
          var value = " <div >" + er.total_seyahat + total + ' km ' + "</div> " +
            " <div >" + er.total_time + hour + er.saat + min + er.dakika + "</div> </ br>" +
            " <div >" + start + "   >>>>>>>>> </div>" +
            text +
            " <div >" + end + "   <<<<<<<<< </div>";
          document.getElementById('total').innerHTML = value;

        }
      });
    }
    google.maps.event.addDomListener(window, 'load', initialize());
  }
  /* Map draw sonu */

  function MakeAutoComplete(id1) {
    function initialize() {

      var mapOptions = {
        center: new google.maps.LatLng(39, 35),
        scrollwheel: false,
        zoom: 5
      };
      var map = new google.maps.Map(document.getElementById('map-canvas'),
        mapOptions);
      var infowindow = new google.maps.InfoWindow();
      var marker = new google.maps.Marker({
        map: map
      });
      var input = document.getElementById(id1);

      var types = "";
      map.controls[google.maps.ControlPosition.TOP_LEFT].push(types);

      var autocomplete = new google.maps.places.Autocomplete(input);
      autocomplete.bindTo('bounds', map);

      google.maps.event.addListener(autocomplete, 'place_changed', function() {
        infowindow.close();
        marker.setVisible(false);
        var place = autocomplete.getPlace();
        if (!place.geometry) {
          return;
        }
        map.setCenter(place.geometry.location);
        map.setZoom(8);
        marker.setIcon(({
          url: place.icon,
          size: new google.maps.Size(71, 71),
          origin: new google.maps.Point(0, 0),
          anchor: new google.maps.Point(17, 34),
          scaledSize: new google.maps.Size(35, 35)
        }));
        marker.setPosition(place.geometry.location);
        marker.setVisible(true);
        var address = '';
        if (place.address_components) {
          address = [
            (place.address_components[0] && place.address_components[0].short_name || ''), (place.address_components[1] && place.address_components[1].short_name || ''), (place.address_components[2] && place.address_components[2].short_name || '')
          ].join(' ');
        }
        infowindow.setContent('<div><strong>' + place.name + '</strong><br>' + address);
        infowindow.open(map, marker);

        if (input.name == "inputStart") {
          makeDirection();
          setTimeout(function() {
            $('#pac-input2').focus();
          }, 10);
        } else {
          makeDirection();
        }
      });

      function makeDirection() {
        var directionsDisplay;
        var directionsService = new google.maps.DirectionsService();
        var start = document.getElementById('pac-input').value,
          end = document.getElementById('pac-input2').value;

        var param = [];
        var array = $('#iteneraryPanel').find('.wayPoint');
        for (var i = 0; i < array.length; i++) {
          param.push({
            location: $(array[i]).val()
          });
        }

        createLocations(start, end, param);

        directionsDisplay = new google.maps.DirectionsRenderer();
        map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
        directionsDisplay.setMap(map);
        var request = {
          origin: start,
          destination: end,
          waypoints: param,
          travelMode: google.maps.TravelMode.DRIVING
        };
        directionsService.route(request, function(response, status) {

          if (status == google.maps.DirectionsStatus.OK) {
            directionsDisplay.setDirections(response);
            /* Toplma mesafeyi yazdırma */
            /*
            var result = directionsDisplay.getDirections();
            var total = 0,
              minute = 0,
              text = "";
            var myroute = result.routes[0];

            var j = 0;
            for (var i = 0; i < myroute.legs.length; i++) {
              total += myroute.legs[i].distance.value;
              minute += parseInt(myroute.legs[i].duration.value);
              if (param.length == 0) {
                if (strcmp(er.lang, "en") == 0)
                  text += "  " + myroute.legs[i].duration.text.replace('gün', 'day').replace('saat', 'hour').replace('dakika', 'minute');
                else
                  text += "  " + myroute.legs[i].duration.text;
              } else {
                if (strcmp(er.lang, "en") == 0)
                  text += "  " + myroute.legs[i].duration.text.replace('gün', 'day').replace('saat', 'hour').replace('dakika', 'minute');
                else
                  text += "  " + myroute.legs[i].duration.text;
                text += " ";
                if (j < param.length) {
                  text += " <div>  >>>>>>>>>  " + param[j]['location'] + "   >>>>>>>>>   </div>";
                  j += 1;
                }
              }
            }
            var hour = Math.floor(minute / 3600),
              min = Math.ceil((minute % 3600) / 60);
            total = total / 1000.0;
            var value = " <div >" + er.total_seyahat + total + ' km ' + "</div> " +
              " <div >" + er.total_time + hour + er.saat + min + er.dakika + "</div> </ br>" +
              " <div >" + start + "   >>>>>>>>> </div>" +
              text +
              " <div >" + end + "   <<<<<<<<< </div>";
              */

            // Toplma mesafeyi yazdırma 
            var result = directionsDisplay.getDirections(),
              total = 0,
              minute = 0,
              text = "",
              myroute = result.routes[0],
              j = 0;
            for (var i = 0; i < myroute.legs.length; i++) {
              total += myroute.legs[i].distance.value;
              minute += parseInt(myroute.legs[i].duration.value);
              var dil = "";
              if (param.length == 0) {
                if (strcmp(er.lang, "en") == 0)
                  dil = "  " + myroute.legs[i].duration.text.replace('gün', 'day').replace('saat', 'hour').replace('dakika', 'minute');
                else
                  dil = "  " + myroute.legs[i].duration.text;
                text += " <div class='row'> <div class='col-lg-4 time'> " + dil + "</div> " +
                  " <div class='col-lg-2 distance'>" + myroute.legs[i].distance.value / 1000.0 + "</div> " +
                  " <div class='col-lg-1'> km </div> " +
                  " </div>";
              } else {
                if (strcmp(er.lang, "en") == 0)
                  dil = "  " + myroute.legs[i].duration.text.replace('gün', 'day').replace('saat', 'hour').replace('dakika', 'minute');
                else
                  dil = "  " + myroute.legs[i].duration.text;
                text += " <div class='row'> <div class='col-lg-4 time'  > " + dil + "</div> " +
                  " <div class='col-lg-2 distance'>" + myroute.legs[i].distance.value / 1000.0 + "</div> " +
                  " <div class='col-lg-1'> km </div> " +
                  " </div>";
                if (j < param.length) {
                  text += " <div  >  >>>>>>>>>  " + param[j]['location'] + "   >>>>>>>>>   </div>";
                  j += 1;
                }
              }

            }


            var hour = Math.floor(minute / 3600),
              min = Math.ceil((minute % 3600) / 60);
            total = total / 1000.0;

            var value = "<div class='col-lg-4'>" +
              er.total_seyahat + " </div><div style='padding-left: 14px' id='totalDistance'> " + total + ' km ' + "</div> " +
              "<div class='col-lg-4'>" +
              er.total_time + "</div> <div id='totalTime' class='col-lg-12'> " + hour + er.saatS + min + er.dakikaS + "</div> </ br>" +
              " <div class='col-lg-12' >" + start + "   >>>>>>>>> </div>" +
              "<div class='col-lg-12'>" + text + "</div>" +
              " <div class='col-lg-12'>" + end + "   <<<<<<<<< </div>";
            document.getElementById('total').innerHTML = value;

          }
        });

      }
    }
    google.maps.event.addDomListener(window, 'load', initialize());
  }; // End of the MakeAutoComplete 


  // get location 
  var locations = [];

  function createLocations(start, end, param) {
    if (start.trim().length > 0 && end.trim().length > 0) {
      locations = [];
      var array = param,
        start = start,
        end = end,
        mygc = new google.maps.Geocoder();
      mygc.geocode({
        'address': start
      }, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
          var point = {
            type: 'start',
            name: start,
            lat: results[0].geometry.location.lat(),
            lng: results[0].geometry.location.lng()
          };
          locations.push(point);
        } else {
          alert(er.error_occurred + " " + er.refresh);
          location.reload(true);
        }
      });
      mygc.geocode({
        'address': end
      }, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
          var point = {
            type: 'end',
            name: end,
            lat: results[0].geometry.location.lat(),
            lng: results[0].geometry.location.lng()
          };
          locations.push(point);
        } else {
          alert(er.error_occurred + " " + er.refresh);
          location.reload(true);
        }
      });
      for (var i = 0, n = array.length; i < array.length; i++) {
        if (array[i] != "") {
          (function(address, callback) {
            mygc.geocode({
              'address': address.location
            }, function(results, status) {
              if (status == google.maps.GeocoderStatus.OK) {
                var point = {
                  type: 'way',
                  name: address.location,
                  lat: results[0].geometry.location.lat(),
                  lng: results[0].geometry.location.lng()
                };
                locations.push(point);
              } else {
                alert(er.error_occurred + " " + er.refresh);
                location.reload(true);
              }
              if (--n === 0) {
                callback(array);
              }
            });
          })(array[i], function() {
            //console.log( JSON.stringify( locations, null,4) );  console.log('geocoding finished');
          });
        }
      };
    };
  }; // End of the createLocations

})(jQuery);