<?php
   $this->load->view('include/head');
?> 
     <div class="container " >
 <!-- Navbar
      ================================================== -->
      <div class="bs-docs-section clearfix " >
        <div class="row">
          <div class="col-lg-12">
            <div class="bs-example">

                    <div class="navbar navbar-default"  style="font-size: 18px;">
                         <div class="navbar-header">
                             <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
                              <span class="icon-bar"></span>
                              <span class="icon-bar"></span>
                              <span class="icon-bar"></span>
                              <span class="icon-bar"></span>
                            </button>
                            <a href="<?= new_url() ?>" class="navbar-brand"><i class=" glyphicon glyphicon-home one"></i>
                             <?=lang('g.mainpage')?></a>
                         </div>
                         <div class="navbar-collapse collapse navbar-responsive-collapse" id="navbar-main">
                           <ul class="nav navbar-nav">
                              <li><a href="<?php echo new_url() . 'main/works'; ?>"   >
                                 <i class="glyphicon glyphicon-book one"></i> <?=lang('g.how')?></a>
                              </li>
                              <li><a id="buttonOfferRide"  href="<?php echo new_url() . 'main/offerRide'; ?>"  >
                                     <i class="glyphicon glyphicon-briefcase one"></i> <?=lang('g.offer')?> </a>
                              </li> 
                              <li>
                                <a id="buttonFindRide" href="<?php echo new_url(  ((strcmp(lang('lang'), "tr") == 0) ? "ara-seyahat" : "search-travel" ) ); ?>"    >
                                  <i class=" glyphicon glyphicon-search one"></i> <?=lang('g.search')?></a>
                              </li>
                              <li><a data-toggle="modal" href="#report-problem"   >
                                <i class=" glyphicon glyphicon-flag one"></i> <?=lang('g.problem')?></a>
                              </li> 
                           </ul>
                           <ul class="nav navbar-nav navbar-right ">
                                <li ><a href="<?php echo new_url("profil")?>"   class="dan glyphicon glyphicon-bell three">
                                  <span class="badge btn-warning mybadge2"  ><?php echo $alert_count ?></span></a>
                                </li>
                                <li ><a href="<?php echo new_url() . 'message'  ?>"   class="succ glyphicon glyphicon-comment three">
                                    <span class="badge btn-warning mybadge"  ><?php echo $mesage_count ?></span></a>
                                </li>
                                <li style="padding:3px; padding-top:5px;">  </li>
                                <li class="dropdown">
                                    <!-- data-toggle="dropdown" href="#" -->
                                    <a class="dropdown-toggle"  data-toggle="dropdown" href="#" id="themes"> 
                                      <img class="pic-img" src="<?= $fotoname ?> " width="20px" height="23px" > <?= $username ?> 
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="themes">
                                      <li style="margin-top:10px" ><a tabindex="0" href="<?php echo new_url() . 'profil/'  ?>">
                                        <i class="text-success  glyphicon glyphicon-dashboard two"></i> <?=lang('g.dashboard')?></a>
                                      </li>
                                      <li class="divider"></li>
                                      <li><a tabindex="1" href="<?php echo new_url() . 'profil/profile'   ?>">
                                        <i class="text-info     glyphicon glyphicon-user two"></i> <?=lang('g.profil')?></a>
                                      </li>
                                      <li><a tabindex="2" href="<?php echo new_url() . 'message'  ?>">
                                        <i class="text-warning  glyphicon glyphicon-comment two"></i> <?=lang('g.messages')?>  </a>
                                      </li>
                                      <li><a tabindex="3" href="<?php echo new_url() . 'review'   ?>">
                                        <i class="text-danger   glyphicon glyphicon-star two"></i> <?=lang('g.reviews')?>  </a>
                                      </li>
                                      <li><a tabindex="4" href="<?php echo new_url() . 'offer'    ?>">
                                        <i class="text-info     glyphicon glyphicon-briefcase two"></i> <?=lang('g.offers')?>  </a>
                                      </li>
                                      <li><a tabindex="5" href="<?php echo new_url() . 'alert'   ?>">
                                        <i class="text-danger   glyphicon glyphicon-bell two"></i> <?=lang('g.alerts')?>   </a>
                                      </li>
                                      <li class="divider"></li>
                                      <li><a tabindex="6" href="<?php echo new_url() . 'login/logOut'; ?>">
                                        <i class="text-danger   glyphicon glyphicon-log-out two"></i> <?=lang('g.logout')?> </a>
                                      </li>
                                    </ul>
                               </li>
                               <li> 
                                  <? if( strcmp(lang('lang'), "tr") == 0 ){ ?>
                                    <a tabindex="2" style="padding: 0px 13px 0px 13px;"  href="<?=  base_url(). $this->lang->switch_uri('en')  ?>">
                                        <i class="en-32"></i> </a>
                                  <? }else{ ?>
                                    <a tabindex="1"  style="padding: 0px 13px 0px 13px;" href="<?= base_url(). $this->lang->switch_uri('tr') ?>">
                                        <i class="tr-32"></i>  </a>
                                  <? }  ?>
                               </li>
                            </ul>
                        </div>
                      </div>

               </div>
             </div>  
           </div>
        </div>
     </div> <!-- End of the container -->    
 
     <div class="container" style="padding: 0 100px 0px 100px">
         <div  id="message" ></div>
         <div id="fb-root"></div>
     </div>

    <script type="text/javascript">  var base_url = '<?= new_url(); ?>', enviroment = '<?= ENVIRONMENT ?>',  er={  <?= createErrorObject() ?> };   </script>
    <script src="<?=  public_url() . 'scripts/partial/headerUser.js'  ?>"></script> 
    