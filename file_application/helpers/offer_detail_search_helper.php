<?php if (!defined('BASEPATH')) {exit('No direct script access allowed');
}

/*******
| sidebar for offer detail Member verifications  content
| @parameter |  user
| @return    |  html content
|
 ****/
function getMemberVerification($user) {
	$verifications = array();
	if ($user['email_check']) {
		$email = "<div class='row verification'>
                                 <i class='col-xs-1 text-primary glyphicon ' style='width: 1em;' >@</i>
                                 <div class='col-xs-8 text-verified text-success'>
                                       " . lang("od.email") . "
                                 </div>
                                 <i class='col-xs-2 validated'></i>
                          </div>";
		$verifications[] = $email;
	}

	$face = "";
	if ($user['face_check']) {
		$face = "<div class='row verification'>
                                   <i class='col-xs-2 text-primary  glyphicon icon-facebook ' style='height: 23px; width:1em; margin-top:5px'></i>
                                   <div class='col-xs-8 text-verified text-success'>
                                      " . $user['friends'] . " " . lang("od.friends") . "
                                   </div>
                                   <i class='col-xs-2 validated'></i>
                           </div>";
		$verifications[] = $face;
	}
	if (count($verifications) > 0) {
		$val = "<div class='row verified-title'>
                              <div class='row'>
                                   <h4 class='driver-h' > " . lang("od.verification") . " </h4>
                              </div>";
		foreach ($verifications as $value) {
			$val .= $value;
		}

		$val .= "</div>";
	}
	return (isset($val)) ? $val : "";
}

/****
|  Write tripdate content
|  @parameter | offer , lang
|  @return    | html content
|
 ****/
function tripDateContent($offer, $lang) {
	$content = "";
	$estimated = isset($offer['estimated']) ? (($offer['estimated'] == 1) ? lang("od.estimated") : ""):"";

	$departure = " <div class='row out-row' style='padding-right: 8px; padding-left: 8px;' >
		                                      <div class='row alt-cizgi' >
		                                           <label for='datepickerStart' class='col-lg-4 control-label ' style='padding-top:2px;' >
		                                              " . lang('od.date') . "
		                                           </label>
		                                           <div class='col-lg-8 no-padding5'>
		                                               <div class='col-lg-12 no-padding'>
		                                                      <i class='text-success glyphicon glyphicon-calendar two' style='margin-right:0px;'></i>
		                                                      " . tr(date_format(date_create($offer['departure_date']), ' l jS F Y'), $lang) . " " . $estimated . "
		                                               </div>
		                                           </div>
		                                      </div>
		                                      <div class='row alt-cizgi' >
		                                             <label for='datepickerStart' class='col-lg-4 control-label ' style='padding-top:5px;' >
		                                              " . lang('od.time') . "
		                                             </label>
		                                             <div class='col-lg-8 no-padding5'>
		                                                    <i class='text-success glyphicon glyphicon-time two date-location' ></i>
		                                                    <div class='time2'>" . substr($offer['departure_time'], 0, -3) . " " . $estimated . "</div>
		                                             </div>
		                                      </div>
		                                </div>";

	$return = "<div class='row out-row' style='padding-right: 8px; padding-left: 8px;'  >
                                              <div class='row alt-cizgi'>
                                                    <label for='datepickerEnd' class='col-lg-4 control-label' style='padding-top:2px;'>
                                                     " . lang('od.dateR') . "
                                                    </label>
                                                    <div class='col-lg-8 no-padding5'>
                                                          <div class='col-lg-12 no-padding'>
                                                                 <i class='text-danger glyphicon glyphicon-calendar two' style='margin-right:0px;' ></i>
                                                                 " . tr(date_format(date_create($offer['return_date']), ' l jS F Y'), $lang) . "
                                                          </div>
                                                    </div>
                                              </div>
                                              <div class='row alt-cizgi' >
                                                      <label for='datepickerStart' class='col-lg-4 control-label ' style='padding-top:5px;' >
                                                       " . lang('od.timeR') . "
                                                      </label>
                                                      <div class='col-lg-8 no-padding5'>
                                                             <i class='text-danger glyphicon glyphicon-time two date-location' ></i>
                                                             <div class='time2'>" . substr($offer['return_time'], 0, -3) . "</div>
                                                      </div>
                                              </div>
                                    </div>";
	$content = $departure;
	$content .= ($offer['round_trip'] == '1') ? $return : '';

	return $content;
}

/****
|  Write waypoints content
|  @parameter | offer
|  @return    | html content
|
 ****/
function wayPoints($offer) {
	$val = "";
	if ($offer['is_way']) {

		$str = explode(",", $offer['origin']);
		$val .= "<strong   class='text-primary text-20'   title='$str[0]' >" . $str[0] . "</strong>→";

		$way_points = explode("?", $offer['way_points']);
		foreach ($way_points as $way) {
			$str2 = explode(",", $way);
			$val .= "<span title='{$way}' >" . $str2[0] . "</span>→";

		}
		$str2 = explode(",", $offer['destination']);
		$val .= "<strong  class='text-primary text-20' title='{$offer['destination']}' >" . $str2[0] . "</strong>";
	} else {
		$str = explode(",", $offer['origin']);
		$str2 = explode(",", $offer['destination']);
		$val .= "<strong class='text-primary text-20' > <span title='{$offer['origin']}' > " . $str[0] . " </span> → <span title='{$offer['destination']}' > " . $str2[0] . " </span> </strong>";
	}

	return $val;
}
