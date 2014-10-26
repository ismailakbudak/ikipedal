<div class='container' >
  <style type="text/css">
  .one-thread { display: block;
  color: #666 !important;
  padding: 0px 0px;
  cursor: pointer;
  margin: 4px;
  background-color:  #fff; }
  .msg{   padding: 10px; text-align: center;}
  .message{        border-color: #eee;
  border-width: 5px;
  border-radius: 10px;
  -webkit-transition: 0.5s ease-in-out all;
  -moz-transition: 0.5s ease-in-out all;
  -ms-transition: 0.5s ease-in-out all;
  -o-transition: 0.5s ease-in-out all;
  transition: 0.5s ease-in-out all;
  font-weight: bold;
  font-size: 14px;
  margin-top: 5px;  }
  .message:hover{  border-color: #FFFFFF;
  -moz-box-shadow: 0px 0px 14px #3195F3;
  -webkit-box-shadow: 0px 0px 0px #9AA7B4;
  box-shadow: 0px 0px 11px #3FD2FF;    }
  .list-group-item {   position: relative;
  display: block;
  float: left;
  width: 200px;
  height:110px;
  margin: 5px 5px;
  margin-bottom: -1px;
  background-color:  #fff;
  border-width: 5px;
  border-radius: 7px;
  border: 1px solid #ddd;  }
  .age{ font-size: 10px; color: rgb(245, 130, 130); }
  .icon{margin-right: 5px; margin-left: 5px; }
  .icon1{margin-right: 0px; margin-left: 5px; }
  .icon2{margin-right: 5px; margin-left: 0px; }
  .icon3{margin-right: 10px; margin-left: 10px; }
  .icon4{margin-right: 5px; margin-left: 5px; }
  .icon3:hover{ font-size: 19px; color:rgb(214, 255, 0); }
  .icon:hover{ font-size: 16px; color:rgb(214, 255, 0);}
  .yellow{ color:rgb(214, 255, 0);}
  .green{color: #009900; font-weight: bold; }
  .orange{color: #CC9900; font-weight: bold;}
  .red{color: #990000; font-weight: bold;}
  .padding10{  padding: 0px; text-align: left; padding-right: 30px;}
  .row-ofer{margin: 0px; width: 100%;  }
  .safari .edit-row{float:left; }
  .panel-body{background-color: rgb(245, 245, 245); padding:2px;}
  /* for button set */
  .btn-group-justified { padding-bottom: 20px; width: 49%;  }
  .panel-primary {  border-color: #eee; border-width: 5px; border-radius: 7px;
  -webkit-transition: 0.5s ease-in-out all;
  -moz-transition: 0.5s ease-in-out all;
  -ms-transition: 0.5s ease-in-out all;
  -o-transition: 0.5s ease-in-out all;
  transition: 0.5s ease-in-out all;
  }
  .panel-primary:hover {
  border-color: #7DD7EE;
  -moz-box-shadow: 0px 0px 14px #3195F3;
  -webkit-box-shadow: 0px 0px 14px #3195F3;
  box-shadow: 0px 0px 14px #23ACD6;
  }
  blockquote{margin: 0px 0px 0px; border-color: rgba(0, 0, 0, 0.15); height: auto; margin: 2px; }
  .date{          background-color: #fff;
  padding: 0 27px 0 25px;
  margin-right: 10px;
  margin-left: 10px;
  width: 140px;
  text-align: center;
  border-width: 2px;
  border-radius: 50px;
  font-size: 15px;
  font-weight: 300;
  text-overflow: ellipsis;
  float:left;
  }
  .dod{ width:5px; float:left; margin-left: 3px; margin-right: 3px; padding-top:6px; }
  .sol{float: left; padding-left: 7px; padding-top:7px; color: orange}
  .sol2{float: left; padding-top:7px;  color: orange}
  .time{width:63px; float:left; padding-left: 3px }
  .width-200{ width: 200px; text-align: right; float: right; padding-bottom: 3px }
  .panel-heading-my { background-color: #324F6F !important; }
  /* for return days  */
  .day-label{font-size: 13px; padding: 0px;}
  .ui-button-text { padding: .35em 1.2em !important; }
  .popover-content{width: 250px;}
  .popover-content .row{ margin: 0px;  padding: 0px;   }
  .tip{ margin-bottom: 2px; margin-right: 5px;}
  </style>
  <legend  class="">
    <?
    $count = 0;                                   // use for buttonset
    $lang = $this->lang->lang();                  // which language
    echo lang( "ovl.looks" );
    ?>
  </legend>
  <div class="last-offer" >
    <?
    $value = $offer;
    $origin = explode(',', $value['origin']);
    $row_count = 0;
    $origin = $origin[0];
    $destination = explode(',', $value['destination']);
    $destination = $destination[0];
    $base = new_url();
    $url_detail = $base . urlCreate($lang, $origin, $destination, $value['normal_id']);
    $url_look = $base . 'offers/look/' . $value['id'];
    $val = " <div class='panel panel-primary' data-count='" . $row_count . "'>
      <div class='panel-heading'>
        <h3 class='panel-title'> {$origin}";
        if ($value['is_way']) {
        $val .= " <i class='yellow glyphicon glyphicon-arrow-left icon1' title='" . lang('io.titletwoway') . "'></i>
        <i class='yellow glyphicon glyphicon-arrow-right icon2' title='" . lang('io.titletwoway') . "'></i> {$destination}";
        } else {
        $val .= " <i class='yellow glyphicon glyphicon-arrow-right icon1' title='" . lang('io.titleonetime') . "'></i> {$destination}";
        }
        $val .= "
        <a href='{$url_detail}' ><i title='" . lang('io.titleshow') . "' class=' glyphicon glyphicon-eye-open icon3 right'></i></a>
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
              $date = tr(date_format(date_create($value['return_date']), ' l jS F Y'), $lang);
              $times = explode(':', $value['return_time']);
              $time = $times[0] . ":" . $times[1];
              $val .= " <i class='text-danger glyphicon glyphicon-calendar two' title='" . lang('io.titlereturndate') . "'></i>  {$date}
              <i class='text-danger glyphicon glyphicon-time icon4 two' title='" . lang('io.titledeparturetime') . "'></i>  {$time}
              </span>
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
    echo $val;
    ?>
    </div><!--  <div class="last offer" /> -->
    <div class='container'>
      <?
      $total = 0;
      foreach ($offer['look_list'] as $value) {
      $username = $value['name'];
      $surname  = $value['surname'];
      $date = date('Y');
      $age =  $date - $value['birthyear'] . lang("age");
      $alt = $username ." ". $value['surname'] ."(". $age  .")" ;
      $path = $value['foto'];
      $times = $value['number'] . lang('ovl.times');
      $total += $value['number'];
      echo " <div class='list-group-item  message ' >
        <a href='". new_url('user/show/'. urlencode( base64_encode($value['user_id']) )  ) ."' class='row one-thread' >
          <div class='row'>
            <div class='col-lg-4' style='text-align: center;'>
              <img alt='". $alt ."' title='". $alt ."'  class='tip pic-img' src='". $path ."' style='width: 50px; height: 60px' height='60' width='50'>
            </div>
            <div class='col-lg-8 name' style='text-align: center; padding-top:5px'>
              <div class='row' >". $username ."</div>
              <div class='row' >". $surname  ."</div>
              <div class='row age' >".  $age  ."</div>
              <div class='row ' >".  $times  ."</div>
            </div>
          </div>
        </a>
      </div>";
      }
      if( count($offer['look_list']) == 0 ){
      $url_refresh =   new_url('offers/showList/'. $offer['id']);
      echo " <div class='bs-example'>
        <div class='alert alert-dismissable alert-info'>
          <button type='button' class='close' data-dismiss='alert' title='". lang('close') ."' >&times;</button>
          <h4> ". lang("ovl.empty") ." <a href='". $url_refresh ."' style='margin:10px; margin-top: 10px !important;' title='". lang('refresh') ."' ><i class='glyphicon glyphicon-refresh'></i> </a> </h4>
        </div>
      </div>";
      }
      else{
      $number = $offer['look_count']['look'] - $total;
      $number = $number . lang('ovl.times');
      $username = lang("ovl.notmember");
      $path   = public_url('assets/male.png');
      echo "<div class='list-group-item  message ' >
        <div class='row'>
          <div class='col-lg-4' style='text-align: center;'>
            <img   class='tip pic-img' src='". $path ."' style='width: 50px; height: 60px' height='60' width='50'>
          </div>
          <div class='col-lg-8 name' style='text-align: center; padding-top:5px'>
            <div class='row' >". $username ."</div>
            <div class='row' > </div>
            <div class='row ' >".  $number  ."</div>
          </div>
        </div>
      </div>";
      }
      ?>
    </div>
    <div id="loader">  </div>
    <script type="text/javascript" > er.blank_date = '<?=lang("o.blank_date")?>'; er.same_date = '<?=lang("o.same_date")?>'; er.choose_day = '<?=lang("o.choose_day")?>'; return_days_count = '<?=$count?>'; </script>
    <script src="<? echo   public_url() . 'scripts/partial/index-offers.js'  ?>"></script>