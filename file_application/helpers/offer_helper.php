<?php if (!defined('BASEPATH')) {exit('No direct script access allowed');
}
/**
 *  Zamanı dile göre cevir
 *
 *   @param
 *   @return
 **/
function timeLang($time, $lang) {
	$en = array("saat" => "hr",
		"sa" => "hr",
		"dakika" => "min",
		"dk" => "min",
	);
	$tr = array("hr" => "saat",
		"saat" => "saat",
		"sa" => "saat",
		"min" => "dk",
		"dakika" => "dk",
		"minute" => "dakika",
	);
	if (strcmp($lang, "en") == 0) {
		return strtr($time, $en);
	} else {
		return strtr($time, $tr);
	}
}
/**
 *   Günleri dile göre cevir
 *
 *   @param
 *   @return
 **/
function en($day, $lang) {
	$days = array("Pazartesi" => "Monday",
		"Salı" => "Tuesday",
		"Çarşamba" => "Wednesday",
		"Perşembe" => "Thursday",
		"Cuma" => "Friday",
		"Cumartesi" => "Saturday",
		"Pazar" => "Sunday",
	);
	if (strcmp($lang, "en") == 0) {
		return strtr($day, $days);
	} else {
		return $day;
	}
}
/**
 *   Return two way trip content
 *
 *   @param
 *   @return html content
 *
 **/
function trip($value, $lang, $row_count = 0) {
	$origin = explode(',', $value['origin']);
	$origin = $origin[0];
	$destination = explode(',', $value['destination']);
	$destination = $destination[0];
	$base = new_url();
	$url_update = $base . 'offer/update/' . $value['id'];
	$url_detail = $base . urlCreate($lang, $origin, $destination, $value['normal_id']);
	$url_show = new_url('offers/showList/' . $value['normal_id']);
	$url_look = $base . 'offers/look/' . $value['id'];
	$val = " <div class='panel panel-primary' data-count='" . $row_count . "'>
  <div class='panel-heading'>
    <h3 class='panel-title'>";
	$rutin = " <i class='yellow text-primary glyphicon glyphicon-retweet icon4 ' title='" . lang('io.titlerutin') . "'></i>";
	$val .= ($value['trip_type'] == "1") ? $rutin : "";
	$val .= $origin;
	if ($value['round_trip']) {
		$val .= "<i class='yellow glyphicon glyphicon-arrow-left icon1' title='" . lang('io.titletwoway') . "'></i>
    <i class='yellow glyphicon glyphicon-arrow-right icon2' title='" . lang('io.titletwoway') . "'></i> {$destination}";
	} else {
		$val .= " <i class='yellow glyphicon glyphicon-arrow-right icon1' title='" . lang('io.titleonetime') . "'></i> {$destination}";
	}

	$val .= "
    <a href='{$url_update}' ><i title='" . lang('io.titleupdate') . "' class=' glyphicon glyphicon-pencil icon3 right'></i></a>
    <a class='delete-offer' data-toggle='modal' href='#delete-modal' data-id='" . $value['id'] . "' ><i title='" . lang('io.titledelete') . "' class=' glyphicon glyphicon-trash icon3 right'></i></a>
    <a href='{$url_detail}' ><i title='" . lang('io.titleshow') . "' class=' glyphicon glyphicon-eye-open icon3 right'></i></a>
    <a href='{$url_show}' ><i title='" . lang('io.titleshowlist') . "' class=' glyphicon glyphicon-user icon3 right'></i></a>
    </h3>
  </div>
  <div class='panel-body ' >
    <div class='row row-ofer'>
      <div class='col-lg-9 '>
        <blockquote  class='col-lg-12 safari'>
          <span class='row row-ofer edit-row' >";
	$date = tr(date_format(date_create($value['departure_date']), ' l jS F Y'), $lang);
	$times = explode(':', $value['departure_time']);
	$time = $times[0] . ":" . $times[1];
	$val .= "   <i class='text-success glyphicon glyphicon-calendar two' title='" . lang('io.titledeparturedate') . "' ></i>  {$date}
          <i class='text-success glyphicon glyphicon-time icon4 two' title='" . lang('io.titledeparturetime') . "'></i> {$time}
          </span>
          <span class='row row-ofer edit-row'>
          <i class='text-info glyphicon glyphicon-map-marker two' title='" . lang('io.titleroute') . "' ></i>";
	if ($value['is_way']) {
		$str = explode(",", $value['origin']);
		$val .= "<strong title='$str[0]' >" . $str[0] . "</strong>→";
		$way_points = explode("?", $value['way_points']);
		foreach ($way_points as $way) {
			$str2 = explode(",", $way);
			$val .= "<strong title='{$way}' >" . $str2[0] . "</strong>→";
		}
		$str2 = explode(",", $value['destination']);
		$val .= "<strong title='{$value['destination']}' >" . $str2[0] . "</strong>";
	} else {
		$str = explode(",", $value['origin']);
		$str2 = explode(",", $value['destination']);
		$val .= "<strong> <span title='{$value['origin']}' > " . $str[0] . " </span> → <span title='{$value['destination']}' > " . $str2[0] . " </span> </strong>";
	}
	$totaltime = timeLang($value['total_time'], $lang);
	$val .= " <i class='text-info glyphicon glyphicon-road icon4 two' title='" . lang('io.titletriplength') . "'></i> {$value['total_distance']}
          <i class='text-info glyphicon glyphicon-time icon4 two' title='" . lang('io.titletriptime') . "'></i> {$totaltime}
          </span>
          <span class='row row-ofer'>";

	if ($value['round_trip']) {
		$date = tr(date_format(date_create($value['return_date']), ' l jS F Y'), $lang);
		$times = explode(':', $value['return_time']);
		$time = $times[0] . ":" . $times[1];
		$val .= "
		  <i class='text-danger glyphicon glyphicon-calendar two' title='" . lang('io.titlereturndate') . "'></i>  {$date}
          <i class='text-danger glyphicon glyphicon-time icon4 two' title='" . lang('io.titledeparturetime') . "'></i>  {$time}";
	}
	$val .= "</span>
        </blockquote>
      </div>
      <div class='col-lg-3 '>
        <blockquote class='pull-right' style='border-color: rgba(0, 0, 0, 0.15); height:100px'>
          <span class='row row-ofer  width-200' style='float:left' >
          <span class='badge' style='background-image:linear-gradient(#ff6707,#dd5600 60%,#c94e00)'>{$value['look_count']['look']}</span> " . lang('io.countshow') . "
          </span>
        </blockquote>
      </div>
    </div>
  </div>
</div> ";
	return $val;
}// END of the twoWayTrip() function
?>