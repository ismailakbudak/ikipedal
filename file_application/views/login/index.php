
    <!-- container
    ================================== -->
    <div class="container">

    <!-- Modal newuser
    =====================================================-->

          <div  class="row well" style="padding: 30px 0px 30px 0px; margin:5px 0px 0px 0px; background-color: #FFFFFF; " >
                        <div class="col-lg-4" ></div>
                        <div class="col-lg-4 well" >
                      <div  id="message" >
                         <?
                             if( isset($val) )
                                echo $val;
                         ?>
                      </div>
                      <ul class="nav navbar-nav navbar-right " >
                        <li class="dropdown">
                              <? if( strcmp(lang('lang'), "tr") == 0 ){ ?>
                                <a tabindex="2" style="padding: 0px 13px 0px 13px;"  href="<?=base_url() . $this->lang->switch_uri('en')?>">
                                    <i class="en-32"></i> </a>
                              <? }else{ ?>
                                <a tabindex="1"  style="padding: 0px 13px 0px 13px;" href="<?=base_url() . $this->lang->switch_uri('tr')?>">
                                    <i class="tr-32"></i>  </a>
                              <? }  ?>
                        </li>
                      </ul>
                               <div class="bs-example form-horizontal">
                                   <fieldset>
                                           <legend><i class="text-primary glyphicon glyphicon-log-in one" ></i><?=lang('g.userlogin')?> </legend>
                                           <div class="form-group margin-20" style="padding-top: 15px;"  >
                                              <button id="faceLogin" class="btn btn-primary form-control mrn-lr-20" style="margin-bottom:20px; " > <img src="<?=public_url()?>styles/images/facebook-back.png"  width="26" height="26"  style="padding-top: 0px; margin-top: -4px; margin-left: -16px; width: 26px; height: 26px;" /> <?=lang('g.facelogin')?> </button>
                                           </div>
                                           <h4> <?=lang('g.or')?> </h4>
                                           <div class="form-group margin-20" id="loginError" >
                                                  <div class="form-group" style=" margin-left:20px" >
                                                     <div class="input-group">
                                                        <input type="text" class="form-control" id="inputLoginEmail"  placeholder="<?=lang('g.mail')?>">
                                                        <span class="input-group-addon ">@</span>
                                                      </div>
                                                   </div>
                                                   <div class="form-group" style="margin-left:20px">
                                                       <div class="input-group">
                                                          <input  type="password" class="form-control" id="inputLoginPassword" placeholder="<?=lang('g.pass')?>">
                                                          <span class="input-group-addon " ><i class="glyphicon glyphicon-lock " ></i></span>
                                                       </div>
                                                   </div>
                                           </div>
                                            <div class="form-group margin-20" >
                                                      <button id="buttonLogin" class="btn btn-primary form-control mrn-lr-20" > <?=lang('g.login')?>  </button>
                                             </div>
                                    </fieldset>
                               </div>
                               <br/>
                               <br/>
                               <p style="font-size:19px; margin:10px 0px 10px 0px" > <a href="<?php echo new_url()?>" ><i class=" glyphicon glyphicon-home one"></i> <?=lang('g.mainpage')?> </a> </p>
                               <p style="font-size:13px; margin:10px 0px 40px 0px" > <a href="<?php echo new_url('signup/forgotPassword')?>" class="text-warning" ><i class="glyphicon glyphicon-warning-sign one"></i> <?=lang('g.forgot')?> </a> </p>
                        </div>
                        <div class="col-lg-4" ></div>
          </div>
         <script src="<?=public_url() . 'scripts/partial/login.js'?>"></script>
         <script src="<?=public_url() . 'scripts/partial/face-process.js'?>"></script>