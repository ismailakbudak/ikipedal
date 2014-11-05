<?php if (!defined('BASEPATH')) {exit('No direct script access allowed');
}
 
/**
 *    Array sort function
 *
 *   @param  $array sıralanacak dizi
 *   @param  $on    sıralanacak özellik
 *   @param  $order ascendinf or descending
 *   @return array
 **/
function array_sort($array, $on, $order = SORT_ASC) {
	$new_array = array();
	$sortable_array = array();
	if (count($array) > 0) {
		foreach ($array as $k => $v) {
			if (is_array($v)) {
				foreach ($v as $k2 => $v2) {
					if ($k2 == $on) {
						$sortable_array[$k] = $v2;
					}
				}
			} else {
				$sortable_array[$k] = $v;
			}
		}
		switch ($order) {
			case SORT_ASC:
				asort($sortable_array);
				break;
			case SORT_DESC:
				arsort($sortable_array);
				break;
		}
		foreach ($sortable_array as $k => $v) {
			$new_array[] = $array[$k];
		}
	} 
	//count of date
	$countDate = array('today' => 0,
		'1days' => 0,
		'2days' => 0,
		'3days' => 0,
		'4days' => 0,
		'5daysOver' => 0);
	//count of time // 1_2 - 2_3 gibi
	$countTimes = array('00_04' => 0, '04_08' => 0, '08_12' => 0, '12_16' => 0, '16_20' => 0, '20_24' => 0);  
	$today = strtotime(date('Y-m-d'));
	$minTime = 24;
	$maxTime = 0;
	foreach ($new_array as &$value) {
		// count of dates
		$date = strtotime(date('Y-m-d', strtotime($value['departure_date'])));
		$days1 = $today+(60 * 60 * 24);
		$days2 = $today+(60 * 60 * 24 * 2);
		$days3 = $today+(60 * 60 * 24 * 3);
		$days4 = $today+(60 * 60 * 24 * 4);
		if ($date <= $today) {
			$countDate['today']++;
			$value['date_group'] = 0;
		} else if ($date <= $days1) {
			$countDate['1days']++;
			$value['date_group'] = 1;
		} else if ($date <= $days2) {
			$countDate['2days']++;
			$value['date_group'] = 2;
		} else if ($date <= $days3) {
			$countDate['3days']++;
			$value['date_group'] = 3;
		} else if ($date <= $days4) {
			$countDate['4days']++;
			$value['date_group'] = 4;
		} else {
			$countDate['5daysOver']++;
			$value['date_group'] = 5;
		}
		// count of times
		$t = explode(':', $value['departure_time']);
		if ($minTime > $t[0]) {
			$minTime = $t[0];
		}

		if ($maxTime < $t[0]) {
			$maxTime = $t[0];
		}
		$time = $t[0] * 60 * 60 + $t[1] * 60;
		$value['trip_time'] = $time;
		$time1 = 4 * 60 * 60;
		$time2 = 8 * 60 * 60;
		$time3 = 12 * 60 * 60;
		$time4 = 16 * 60 * 60;
		$time5 = 20 * 60 * 60;
		if ($time > 0 && $time <= $time1) {
			$countTimes['00_04']++;
			$value['time_group'] = 0;
		} else if ($time >= $time1 && $time < $time2) {
			$countTimes['04_08']++;
			$value['time_group'] = 1;
		} else if ($time >= $time2 && $time < $time3) {
			$countTimes['08_12']++;
			$value['time_group'] = 2;
		} else if ($time >= $time3 && $time < $time4) {
			$countTimes['12_16']++;
			$value['time_group'] = 3;
		} else if ($time >= $time4 && $time < $time5) {
			$countTimes['16_20']++;
			$value['time_group'] = 4;
		} else {
			$countTimes['20_24']++;
			$value['time_group'] = 5;
		} 
		$start = explode(",", $value['origin']);
		$end = explode(",", $value['destination']);
		$event_id = $value['event_id'];
		$value['path'] = urlCreate(lang('lang'), $start[0], $end[0], $event_id);
	}
	$trip_time = array('min' => $minTime + 0, 'max' => $maxTime + 0);
	return array('offers' => $new_array, 
		'countDate' => $countDate,
		'countTimes' => $countTimes, 
		'trip_time' => $trip_time);
}

/**
 *
 *
 *   @param
 *   @return
 **/
function photoCheckUserReturnArray($user) {
	$foto = $user['foto'];// check user photo is exist
	$is_photo = 1;
	if (strcmp($foto, "") != 0) {
		$path = realpath(getcwd() . "/assets/");// get path
		$array = explode('/', $foto);// split url "/"
		if (count($array) > 2 && strcmp(trim($array[count($array) - 2]), "assets") == 0) {// does url belong us
			$file_name = $array[count($array) - 1];// last element is file name
			if (file_exists(realpath($path . '/' . $file_name))) {// is exist or not if there is file use it else use default image
				$foto = $foto;
				if (strcmp($file_name, "male.png") == 0 || strcmp($file_name, "female.png") == 0) {
					$is_photo = 0;
				}
			} else {
				$foto = public_url() . 'assets/';
				$foto .= ($user['sex'] == 1) ? 'male.png' : 'female.png';
				$is_photo = 0;
			}
		} else {

			$foto = $foto;
		}
	} else {
		$foto = public_url() . 'assets/';
		$foto .= ($user['sex'] == 1) ? 'male.png' : 'female.png';
		$is_photo = 0;
	}
	return array('foto' => $foto, 'is_photo' => $is_photo);;
}

/**
 *   Create date2 only mounth adn year
 *
 *   @param
 *   @return
 **/
function dateConvertSearch($date2, $lang) {

	$time = date('H:i', strtotime($date2));
	$date = strtotime(date('Y-m-d', strtotime($date2)));
	$today = strtotime(date('Y-m-d'));
	$day1 = $today+(60 * 60 * 24);
	$day2 = $today+(60 * 60 * 24 * 2);
	$day3 = $today+(60 * 60 * 24 * 3);
	$day4 = $today+(60 * 60 * 24 * 4);
	if ($date == $today) {
		$date = "Today";
	} else if ($date == $day1) {
		$date = "Tomorrow";
	} else if ($date == $day2) {
		$date = "2 days later ";
	} else if ($date == $day3) {
		$date = "3 days later ";
	} else if ($date == $day4) {
		$date = "4 days later ";
	} else {

		$date = date_format(date_create($date2), 'l jS F Y ');
	}
	$aylarIng = array("January" => "Ocak",
		"February" => "Şubat",
		"March" => "Mart",
		"April" => "Nisan",
		"May" => "Mayıs",
		"June" => "Haziran",
		"July" => "Temmuz",
		"August" => "Ağustos",
		"September" => "Eylül",
		"October" => "Ekim",
		"November" => "Kasım",
		"December" => "Aralık",
		"Monday" => "Pazartesi",
		"Tuesday" => "Salı",
		"Wednesday" => "Çarşamba",
		"Thursday" => "Perşembe",
		"Friday" => "Cuma",
		"Saturday" => "Cumartesi",
		"Sunday" => "Pazar",
		"nd" => "",
		"th" => "",
		"st" => "",
		"rd" => "",
		"Today" => "Bugün",
		"Yesterday" => "Dün",
		"Tomorrow" => "Yarın",
		" days ago " => " gün önce ",
		"days later" => " gün sonra ",
	);
	if (strcmp($lang, "tr") == 0) {
		return strtr($date, $aylarIng);
	} 
	else{
		return $date;
	}
}

/**
 *     write all offer
 *
 *   @param
 *   @return
 **/
function writeOffer($v, $date ) { 
	$username = $v['name'];
	$age = $date - $v['birthyear'] . lang("age");
	$alt = $username . " " . $v['surname'] . " ( " . $age . " )";
	$name = $username;// ." ". $v['surname'];
	$path = $v['foto'];
	$level = (strcmp(lang('lang'), "tr") == 0) ? $v['tr_level'] : $v['en_level'];
	$v['average'] = isset($v['average']) ? $v['average'] : 0;
	$average = number_format($v['average'], 1, ".", "");
	$displayVote = ($average > 0) ? "" : "display:none;";
	$displayFace = ($v['face_check'] == 1) ? "" : "display:none;";
    
	$ways = wayPoints($v);  
  
	$val = "<li class='list-group-item offer row'   >
                         <a  class='see' href='" . new_url($v['path']) . "' data-date='" . strtotime($v['departure_date'] . ' ' . $v['departure_time']) . "'
                                                        data-trip_date='{$v['departure_date']}'
                                                        data-date_group='{$v['date_group']}'
                                                        data-time_group='{$v['time_group']}'
                                                        data-trip_time='{$v['trip_time']}'   >
                                <div class='col-lg-3 user-info'>
                                    <div class='row'>
                                        <div class='col-lg-4 left foto'>
                                           <img class='tip pic-img' title='$alt' alt='$alt' src='$path' width='60' height='70' style='width: 60px; height: 70px' >
                                        </div>
                                        <div class='col-lg-8 left name'>
                                            <div class='row ad'> $name </div>
                                            <div class='row'> $age </div>
                                            <div class='row'> $level </div>
                                        </div>
                                    </div>
                                    <div class='row alt-info'>
                                        <div class='row pad' style='$displayVote' >
                                             <span class='star-small star-" . number_format($v['average'], 1, "-", "") . "' title='" . $average . " / 5' ></span>
                                             <div class='vote' >" . $v['number'] . "  " . lang("sr.receive") . " </div>
                                        </div>
                                        <div class='row pad' style='$displayFace' >
                                             <span class='glyphicon icon-facebook' style='float:left; height: 20px; width:1.4em; margin-top:5px'></span>
                                             <div class='face' >" . $v['friends'] . "  " . lang("sr.friends") . "</div>
                                        </div>
                                    </div>
                                </div>
                                <div class='col-lg-7 left-border offer-info'>
                                      <div class='row date-title'>
                                         <div class='side' > <i class='glyphicon glyphicon-calendar ' style='margin-right:0px;'></i>
" . dateConvertSearch($v['departure_date'], lang('lang')) . "
                                         </div>
                                         <div class='side' style='color: #3a87ad;'> <i class='text-info glyphicon glyphicon-time ' style='margin-right:0px;'></i>
                                               " . substr($v['departure_time'], 0, 5) . "
                                         </div>
                                      </div>
                                      <div class='row ways' > $ways </div>
                                      <div class='row colour-yes point-departure' > " . lang("sr.origin") . " {$v['origin']} </div>
                                      <div class='row colour-no point-arrivial' > {$v['destination']} </div>
                                </div>
                                <div class='col-lg-2 price-info'>
                                      <div class='row price' >  </div>  
                                </div>
                         </a>
                     </li>
                    ";
	// <div class='row'> RO->id : {$v['ride_offer_id']} No : {$v['no']}  Tip : {$v['tip']}  Is_way : {$v['is_way']}  class:{$v['price_class']}   </div>
	return $val;
}
 
 

/**
 *  Date content write
 *
 *   @param
 *   @return
 **/
function dateContentWrite($countDate, $allCount) {
	$valDate = "";

	foreach ($countDate as $key => $value) {
		$name = lang("sr." . $key);
		$class = "none-display";
		if ($value != 0) {
			$class = "display";
		}
		$val = "$name <span>(<strong class='badge badge-date'>" . $value . "</strong>)</span> ";
		if (strcmp($key, "today") == 0) {
			$data = 0;
		} else if (strcmp($key, "1days") == 0) {
			$data = 1;
		} else if (strcmp($key, "2days") == 0) {
			$data = 2;
		} else if (strcmp($key, "3days") == 0) {
			$data = 3;
		} else if (strcmp($key, "4days") == 0) {
			$data = 4;
		} else if (strcmp($key, "5daysOver") == 0) {
			$data = 5;
		}
		$valDate .= "<div data-date='$data' class='radio $class'>
                                      <label>
                                         <input type='radio' name='optionsRadiosDate'  value='$data' > $val
                                      </label>
                                    </div> ";
	}
	$valDate = " <div class='bs-docs-section clearfix dates'>
                               <div class='row row-side side-info ' >
                                  <div  class='title' >" . lang("sr.date") . "</div>
                               </div>
                               <div class='row row-side numbers'>
                                       <div  data-date='all' class='radio'>
                                         <label>
                                            <input type='radio' name='optionsRadiosDate'  value='all' checked=''>
                                            " . lang('sr.alltype') . " <span>(<strong class='badge badge-date'>" . $allCount . "</strong>)</span>
                                         </label>
                                       </div> $valDate
                               </div>
                           </div>";
	return $valDate;
}

/**
 *   Times content write
 *
 *   @param
 *   @return
 **/
function timesContentWrite($countTimes, $allCount) {
	$valDate = "";
	foreach ($countTimes as $key => $value) {
		$name = lang("sr." . $key);
		$class = "none-display";
		if ($value != 0) {
			$class = "display";
		}
		$val = "$name <span>(<strong class='badge badge-times'>" . $value . "</strong>)</span> ";
		if (strcmp($key, "00_04") == 0) {
			$data = 0;
		} else if (strcmp($key, "04_08") == 0) {
			$data = 1;
		} else if (strcmp($key, "08_12") == 0) {
			$data = 2;
		} else if (strcmp($key, "12_16") == 0) {
			$data = 3;
		} else if (strcmp($key, "16_20") == 0) {
			$data = 4;
		} else if (strcmp($key, "20_24") == 0) {
			$data = 5;
		}
		$valDate .= "<div data-times='$data' class='radio $class'>
                                      <label>
                                         <input type='radio' name='optionsRadiosTime'  value='$data' > $val
                                      </label>
                                    </div> ";
	}
	$valDate = " <div class='bs-docs-section clearfix times'>
                               <div class='row row-side side-info ' >
                                  <div  class='title' >" . lang("sr.times") . "</div>
                               </div>
                               <div class='row row-side numbers'>
                                       <div  data-times='all' class='radio'>
                                         <label>
                                            <input type='radio' name='optionsRadiosTime'  value='all' checked=''>
                                            " . lang('sr.alltype') . " <span>(<strong class='badge badge-times'>" . $allCount . "</strong>)</span>
                                         </label>
                                       </div> $valDate
                               </div>
                           </div>";
	return $valDate;
}
 
