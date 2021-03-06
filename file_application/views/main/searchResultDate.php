<!-- For Map css  -->
<?=link_tag(public_url() . 'styles/map-main.css');?>
<?=link_tag(public_url() . 'styles/searchResult.css');?>

<!-- container -->
<div class="container" >
  <!-- Navbar for map -->
  <div class="bs-docs-section clearfix"  >
    <div class="row">
      <div class="col-lg-12">
       <div class="bs-example">
                <div class="navbar navbar-default" style="padding-bottom:10px" >
                      <div class="col-lg-4">
                        <input   id="pac-input" name="inputStart" type="text" class=" form-control" style="margin-top:8px;" placeholder=" <?=lang('m.startlocation')?> ">
                      </div>
                      <div class="col-lg-4">
                         <input  id="pac-input2" name="inputEnd" type="text" class="form-control " style="margin-top:8px;" placeholder=" <?=lang('m.destinationlocation')?> ">
                      </div>
                      <div class="col-lg-1">
                        <button id="change-direct"  type="button" class="btn btn-default form-control  margin-6" style="margin-top:8px;" > &#60;   &#62; </button>
                      </div>
                      <div class="col-lg-3" >
                        <button id="search" type="button" class="btn btn-warning margin-6 form-control "  style="margin-top:8px;"> <?=lang('m.search')?> </button>
                      </div>
                 </div><!-- /.navbar -->
              </div><!-- /example -->
      </div>
    </div>
  </div><!-- End of the navbar -->
  <div class="row" style="display:none">
     <div class="col-lg-12">
        <div id="map" class="collapse in" >
           <div id="map-canvas"></div>
        </div>
     </div>
  </div><!-- End of the navbar -->
  <div class="row row-side" style="margin-top:0px; min-height:440px; " >
    <div class="col-lg-9"   >
        <div class="row" >
              <div class='well trip-content' style='min-height:440px;'>
                    <fieldset class='content-side'>
                           <div class="bs-docs-section clearfix">
                                 <div class="row row-side" >
                                      <h3  class="col-lg-12 title" style="margin-top: 0px; margin-bottom: 0px; font-size: 30px;" >
                                        <strong  class="badge badge-offer" style="font-size: 30px;" > <?=$counts . " </strong>  " . lang("sr.exist")?>
                                      </h3>
                                 </div>
                                 <hr>
                                 <div class="row row-side offers" >
                                    <h3  class="col-lg-4 title" ><strong id="offerCount" class="badge badge-offer" > <?=count($results['offers']) . " </strong>  " . lang("sr.found")?> </h3>
                                    <? if(false){ 
                                      "<div class='col-lg-5 right none-display' id='sorting' style='text-align: left; float: left; font-size: 17px; padding: 0px; padding-top: 27px;' > <img src='<?=public_url('styles/images/ajax-loader-blue.gif')?>' width='25' height='25' > <?=lang('sr.sorting')?> </div>
                                      <div class='bs-example col-lg-2 right' style='padding: 0px; padding-top:25px'>
                                        <div id='sortBy' class='btn-group btn-group-justified'  style='width:120px;'>
                                          <a href='#' data-on='date'  class='btn my btn-sm btn-default sort active' data-sort='ASC' title='<?=lang('sr.titleSortDate')?>' > <?=lang('sr.date')?> <i class='glyphicon glyphicon-arrow-down'></i> </a>
                                        </div>
                                      </div>";
                                    }?>
                                 </div>
                                 <div class="row row-side">
                                      <div class="col-lg-12">
                                            <ul class="list-group" id="allOffers" data-finish='0' >
                                                <?
                                                    $date       = date('Y'); 
                                                    foreach ($results['offers'] as $v)
                                                         echo  writeOffer($v,$date);
                                                ?>
                                            </ul>
                                      </div>
                                 </div>
                                 <div  id="loader" class="row row-side" style="text-align:center; padding:10px" > </div>

                                <div id='offerCountBottom' class="row row-side none-display" >
                                     <h3  class="col-lg-4 title" ><strong  class="badge badge-offer count" > <?=count($results['offers']) . " </strong>  " . lang("sr.found")?> </h3>
                                </div>
                            </div>
                    </fieldset>
                    <div class="pagination">
                      <ul>
                        <?= $this->pagination->create_links(); ?>
                      </ul>
                    </div>    
              </div>
        </div> 
    </div>
    <div class="col-lg-3" style=" margin-top: 9px; ">
      <div class="row" >
            <div class='well' style='min-height:440px;'>
                  <fieldset class='content-side'>
                     <?   $allCount = count( $results['offers'] );
                          $min = 0;
                          $max = 0;
                          if(  $allCount > 0 ){

                                  $min = $results['trip_time']['min'] + 0;
                                  $max = ( $results['trip_time']['max'] == 24 ) ? 24 : $results['trip_time']['max'] + 1;
                                  $minSaat = $min;
                                  $maxSaat = $max;
                                  if( $min < 10 )
                                     $minSaat = "0".$min;
                                  if( $max < 10 )
                                     $maxSaat = "0".$max;

                               ?>
                                  <div class='bs-docs-section clearfix prices'>
                                     <div class='row row-side ' style=" font-size: 20px; " >
                                          <a href="#" class="reset" data-min="<?=$min?>" data-max="<?=$max?>" > <strong  class='text-primary' ><i class="glyphicon glyphicon-refresh two" ></i> <?=lang("sr.reset")?> </strong>  </a>
                                     </div>

                                  </div>
                                   <hr style="margin-top: 10px; margin-bottom: 0px;" >
                                  <? if(false){ 
                                           "<div class='bs-docs-section clearfix trip-date'>
                                                <div class='row row-side side-info ' >
                                                   <div  class='title' >" . lang("sr.trip-date") . "</div>
                                                </div>
                                                <div class='row row-side numbers'>
                                                  <i class='text-success glyphicon glyphicon-calendar two date-text' ></i>
                                                  <input type='text'  class='form-control date input-sm' id='datepicker' placeholder=" . lang('sr.trip-date'). ">
                                                  <i class='text-danger glyphicon glyphicon-remove-circle  date-delete' style='cursor: pointer;' ></i>
                                               </div>
                                           </div>";
                                      }
                                  ?>
                                  <div class='bs-docs-section clearfix trip-time'>
                                       <br>
                                       <div  class='title ' ><i class="text-info glyphicon glyphicon-time two " style="margin-left:17px;"></i>
                                          <?=lang("sr.trip-time")?> - <strong id="yaz" > <?=$minSaat . ":00 - " . $maxSaat . ":00"?>  </strong></div>
                                       <div class='numbers' style=''>
                                          <input type="text" class="span2 none-display" value="" data-slider-min="0" data-slider-max="24" data-slider-step="1" data-slider-value="[<?=$min . "," . $max?>]" id="time-slider">
                                      </div>
                                  </div> <? 

                              //$countDate = $results['countDate'];
                              //echo dateContentWrite($countDate,  $allCount );

                              $countTimes = $results['countTimes'];
                              echo timesContentWrite($countTimes,  $allCount );
                          }
                          else{ ?>
                              <div class='bs-docs-section clearfix results'>
                                  <div class='row row-side side-info ' style='padding-bottom: 20px;' >
                                     <div  class='title' style='font-size:16px;' > <?=lang("sr.searchInfo")?> </div>
                                  </div>
                                  <div class='row row-side numbers'>
                                     <div class='col-lg-12 title text-primary' style='font-size:15px;'  > <?=lang("sr.not_found");?> </div>
                                  </div>
                              </div>
                              <div class='bs-docs-section clearfix results'>
                                  <div class='row row-side side-info ' >
                                     <div  class='title' ></div>
                                  </div>
                                  <div class='row row-side numbers' style='font-size:14px;'  >
                                         <div class='col-lg-12 title ' style='padding-top:10px;'  ><a class='click' href="<?=new_url("offers/newest")?>"> <?=lang("sr.offerTrip");?> </a></div>
                                  </div> 
                              </div>
                           <?}
                     ?>
                  </fieldset>
            </div>
      </div>
      <div class="row" >
      </div>
    </div>
  </div>
  <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&#38;sensor=false&#38;libraries=places"></script>
  <script src="<?php echo public_url() . 'scripts/partial/searchMap.js'?>"></script>
  <script src="<?php echo public_url() . 'scripts/partial/slider.js'?>"></script>
  <script type="text/javascript">
       var  loading  = " <img src='<?=public_url()?>styles/images/loading2.gif' width='35' height='35' > <?=lang('loading')?> " ,   optionTimemin = '<?=$min * 60 * 60?>' ,  optionTimemax = '<?=$max * 60 * 60?>' ,   optionSaatMin = '<?=$min?>' ,  optionSaatMax = '<?=$max?>' ;
       var place1 = { x:'0', y:'0', status:'0' }, place2 = { x:'0',  y:'0', status:'0' };
  </script>
  <script src="<?php echo public_url() . 'scripts/partial/alerts.js'?>"></script>
  <script src="<?php echo public_url() . 'scripts/partial/searchResult.js'?>"></script>



