      <?
        $this->load->view('include/head');
      ?>
     <div class="container">

      <!-- Navbar
      ================================================== -->
      <div class="bs-docs-section clearfix " >
        <div class="row">
          <div class="col-lg-12">
            <div class="bs-example">
                     <div class=" navbar navbar-default " style="font-size: 18px;">  <!-- navbar-sm -->
                       <div class="navbar-header ">  <!--nav-->
                          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                          </button>
                          <a href="<?php echo new_url()?>" class="navbar-brand"><i class=" glyphicon glyphicon-home one"></i><?=lang('g.mainpage')?> </a>
                       </div>
                       <div class="navbar-collapse collapse navbar-responsive-collapse" id="navbar-main">
                         <ul class="nav navbar-nav">
                            <li><a href="<?php echo new_url() . 'main/works';?>" >
                               <i class="glyphicon glyphicon-book one"></i> <?=lang('g.how')?> </a>
                            </li>
                            <li><a id="buttonOfferRide" href="<?php echo new_url() . 'offers/newest';?>"  >
                                   <i class="glyphicon glyphicon-briefcase one"></i> <?=lang('g.offer')?> </a>
                            </li>
                            <li><a id="buttonFindRide" href="<?php echo new_url(((strcmp(lang('lang'), "tr") == 0) ? "ara-seyahat" : "search-travel"))?>"   >
                              <i class=" glyphicon glyphicon-search one"></i> <?=lang('g.search')?></a>
                            </li>
                            <li><a data-toggle="modal" href="#report-problem"   >
                              <i class=" glyphicon glyphicon-flag one"></i> <?=lang('g.problem')?></a>
                            </li>
                        </ul>
                         <ul class="nav navbar-nav navbar-right ">
                           <li><a  data-toggle="modal" href="#joinus">
                                <i class="glyphicon glyphicon-tree-conifer one"></i> <?=lang('g.join')?> </a>
                           </li>
                           <li><a  data-toggle="modal" href="#login">
                              <i class="glyphicon glyphicon-log-in one"></i> <?=lang('g.login')?> </a>
                           </li><!-- class="btn btn-success"-->

                           <li>
                              <? if( strcmp(lang('lang'), "tr") == 0 ){ ?>
                                <a tabindex="2" style="padding: 0px 13px 0px 13px;"  href="<?=base_url() . $this->lang->switch_uri('en')?>">
                                    <i class="en-32"></i> </a>
                              <? }else{ ?>
                                <a tabindex="1"  style="padding: 0px 13px 0px 13px;" href="<?=base_url() . $this->lang->switch_uri('tr')?>">
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
      </div><!-- End of the container -->

     <div class="container" style="padding: 0 100px 0px 100px">
         <div  id="message" ></div>
         <div id="fb-root"></div>
     </div

    <!-- Modal login
    =====================================================-->
    <div id="login" class="modal fade" tabindex="-1" data-width="440" data-height="380" style="display: none;">
        <div class="modal-header">
             <button type="button" class="close" data-dismiss="modal" title="<?=lang('close')?>" aria-hidden="true">&times;</button>
             <h3 class="modal-title"> <i class="glyphicon glyphicon-log-in one"></i> <?=lang('g.userlogin')?>  </h3>
        </div>
        <div class="modal-body">
               <div  class="row mrn-lr-20">
                   <!--
                   <fb:login-button show-faces="true" id="faceLoginHeaderNonUser" class="btn form-control " scope="email,user_birthday" width="300" max-rows="1"> <?=lang('g.facelogin')?>  </fb:login-button>
                   -->
                     <button id="faceLoginHeaderNonUser" class="btn btn-primary form-control " > <img src="<?=public_url()?>styles/images/facebook-back.png"  width="26" height="26"  style="padding-top: 0px; margin-top: -4px; margin-left: -16px; width: 26px; height: 26px;" /> <?=lang('g.facelogin')?> </button>

               </div>
               <h4> <?=lang('g.or')?> </h4>
               <div class="row" style="">
                     <div class="well">
                        <form class="bs-example form-horizontal">
                             <fieldset>
                                  <div class="form-group" id="loginError" style="margin-right: 10px; margin-left: 10px;" >
                                         <div class="form-group mrn-lr-20" >
                                               <div class=" input-group">
                                                    <input type="text" class="form-control" id="inputLoginEmail"  placeholder="<?=lang('g.mail')?>">
                                                    <span class="input-group-addon">@</span>
                                               </div>
                                          </div>
                                          <div class="form-group mrn-lr-20">
                                               <div class=" input-group">
                                                    <input  type="password" class="form-control" id="inputLoginPassword" placeholder="<?=lang('g.pass')?>">
                                                    <span class="input-group-addon " ><i class="glyphicon glyphicon-lock " ></i></span>
                                               </div>
                                          </div>
                                          <div class="form-group margin-20 mrn-lr-30" style="margin-top:35px; margin-bottom:20px;  " >
                                            <button id="buttonLogin" class="btn btn-primary form-control" > <?=lang('g.login')?> </button>
                                          </div>
                                  </div>

                             </fieldset>
                        </form>
                        <p class="col-xs-6" style="font-size:13px; padding-top:15px" > <a href="<?php echo new_url('signup/forgotPassword')?>" class="text-warning"  ><i class=" glyphicon glyphicon-warning-sign one"></i> <?=lang('g.forgot')?> </a> </p>
                        <p class="col-xs-6" style="font-size:13px; padding-top:15px" > <a class="text-primary" data-toggle="modal" href="#joinus" data-dismiss="modal" ><i class=" glyphicon glyphicon-tree-conifer one"></i> <?=lang('g.join')?> </a></p>

                      </div>
               </div>
       </div>
    </div><!-- END of the Modal login -->

    <!-- Modal joinus
    =====================================================-->
    <div id="joinus" class="modal fade" tabindex="-1" data-width="430" data-height="360" style="display: none;">
        <div class="modal-header">
             <button type="button" class="close" data-dismiss="modal" title="<?=lang('close')?>" aria-hidden="true">&times;</button>
             <h3 class="modal-title"><i class="glyphicon glyphicon-tree-conifer one"></i> <?=lang('g.freesignup')?> </h3>
        </div>
        <div class="modal-body">
               <div  class="row">
                   <div class="well">
                        <form class="bs-example form-horizontal">
                             <fieldset>
                             <legend><?=lang('g.signupface')?>  <strong class="text-primary"><?=lang('g.tensec')?>  <i class="glyphicon glyphicon-time "></i></strong></legend>
                              <div class="form-group-30 ">
                                    <button id="faceSignupHeaderNonuser" class="btn btn-primary form-control"  > <img src="<?=public_url()?>styles/images/facebook-back.png"  width="26" height="26"  style="padding-top: 0px; margin-top: -4px; margin-left: -16px; width: 26px; height: 26px;" /> <?=lang('g.signup')?></button>
                               </div>
                             </fieldset>
                        </form>
                   </div>
               </div>
               <h4><?=lang('g.or')?></h4>
               <div class="row">
                     <div class="well">
                        <form class="bs-example form-horizontal">
                             <fieldset>
                             <legend><?=lang('g.signupnew')?> <strong class="text-primary"> <?=lang('g.sixtysec')?>  <i class="glyphicon glyphicon-time "></i></strong></legend>
                              <div class="form-group-30">
                                    <button  id="captchaReady" class="btn btn-primary form-control" data-toggle="modal" href="#newuser" data-dismiss="modal" > <?=lang('g.signup')?> </button>
                               </div>
                             </fieldset>
                        </form>
                      </div>
               </div>
       </div>
    </div><!-- END of the Modal joinus -->

     <!-- Modal newuser
    =====================================================-->
    <div id="newuser" class="modal fade" tabindex="-1" data-width="450" data-height="580" style="display: none;">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" title="<?=lang('close')?>" aria-hidden="true">&times;</button>
        <h3 class="modal-title"><?=lang('g.signform')?> </h3>
      </div>
      <div class="modal-body">
         <div class="well">
                          <form class="bs-example form-horizontal" id="formSignup">
                            <fieldset>
                              <legend><i class="text-primary glyphicon glyphicon-user one" ></i> <?=lang('g.signupnew')?> <strong class="text-primary"><?=lang('g.sixtysec')?>  <i class="glyphicon glyphicon-time "></i></strong></legend>

                               <div class="form-group-30">
                                      <div class="form-group margin-4">
                                           <div class=" input-group">
                                                <select  class="form-control" id="inputSex" >
                                                   <option value="0" class="default"> <?=lang('g.sex')?> </option>
                                                   <option value="1"> <?=lang('g.m')?> </option>
                                                   <option value="2"> <?=lang('g.f')?> </option>
                                                </select>
                                                <span class="input-group-addon " ><i class="glyphicon glyphicon-list " ></i></span>
                                            </div>
                                     </div>
                                     <div class="form-group margin-4">
                                           <div class=" input-group">
                                               <input type="text" class="form-control" id="inputName" placeholder="<?=lang('g.name')?>">
                                               <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign " ></i></span>
                                           </div>
                                      </div>
                                      <div class="form-group margin-4">
                                             <div class=" input-group">
                                                  <input type="text" class="form-control" id="inputSurname" placeholder="<?=lang('g.surname')?>">
                                                  <span class="input-group-addon"><i class="glyphicon glyphicon-info-sign " ></i></span>
                                             </div>
                                      </div>
                              </div>
                              <div class="form-group-30">

                                      <div class="form-group margin-4">
                                          <div class=" input-group">
                                             <input type="text" class="form-control input-group" id="inputEmail" placeholder="<?=lang('g.mail')?>">
                                             <span class="input-group-addon">@</span>
                                          </div>
                                      </div>

                                      <div class="form-group margin-4">
                                            <div class=" input-group">
                                                 <input  type="password" class="form-control" id="inputPassword" placeholder="<?=lang('g.pass')?>">
                                                 <span class="input-group-addon " ><i class="glyphicon glyphicon-lock " ></i></span>
                                            </div>
                                      </div>

                                      <div class="form-group margin-4">
                                            <div class=" input-group">
                                                 <input type="password" class="form-control" id="inputPasswordAgain" placeholder="<?=lang('g.passagain')?>">
                                                 <span class="input-group-addon " ><i class="glyphicon glyphicon-lock " ></i></span>
                                            </div>
                                      </div>

                                      <div class="form-group margin-4">
                                            <div class=" input-group">
                                                   <select   class="form-control" id="inputBirthYear">
                                                       <option value="0" class="default" > <?=lang('g.byear')?></option>
                                                        <?
                                                        $year1 = getdate();
                                                        $year  = $year1['year'];
                                                        for ($i = $year - 18; $i >= 1930; $i--) {
                                                            echo "<option value='{$i}'> $i </option>";
                                                        }
                                                        ?>
                                                   </select>
                                                   <span class="input-group-addon " ><i class="glyphicon glyphicon-list " ></i></span>
                                            </div>
                                     </div>
                                      <div class="form-group margin-4">
                                            <div class="input-group ">
                                                <div id="captchaDiv" class="col-lg-3" style="padding-top:5px; padding-right:0px; padding-left:0px; float:left">

                                                </div>
                                                <div class="col-lg-2" style="padding-right: 0px; padding-top:8px; padding-left:25px; float:left">
                                                    <a id="captchaNew" href="#"><i class="glyphicon glyphicon-refresh three"></i></a>
                                                </div>
                                                <div class="input-group col-lg-7"  style="padding-right: 0px; padding-left: 0px; float:left">
                                                     <input type="text" class="form-control" id="inputCap" placeholder="<?=lang('g.passcap')?>">
                                                     <span class="input-group-addon " ><i class="glyphicon glyphicon-lock " ></i></span>
                                                </div>
                                            </div>
                                    </div>
                                     <div class="margin-4 mrn-lr-20" style="margin-top:35px;  " >
                                        <button id="inputSignup" class="btn btn-primary form-control" type="button" > <?=lang('g.signup')?></button>
                                     </div>
                                </div>

                            </fieldset>
                          </form>
              </div>
       </div>
    </div><!-- END of the Modal yeniüyelik -->

     <!-- Modal loading
    =====================================================-->
    <div id="loading" class="modal fade" style=" border-radius: 16px;" tabindex="-1" data-width="350" data-height="150" data-backdrop="static"  style="display: none;">
        <div class="well" style=" border-radius: 16px; margin-bottom: 0px !important; margin-right: 0px; margin-left: 0px; ">
                             <fieldset style="font-size:20px; padding-bottom:10px; padding-left: 40px; ">
                                  <div class="row"><?=lang('g.usercreating')?>
                                       <img class="pic-img" src="<?=public_url()?>/styles/images/loading2.gif" width="35" height="35" >
                                     </div>
                                     <div class="row">
                                      <strong class="text-primary"><?=lang('g.wait')?> </strong>
                                     </div>
                             </fieldset>
        </div>
    </div><!-- END of the Modal loading -->
     <script src="<?=public_url() . 'scripts/partial/headerNonUser.js'?>"></script>
     <script src="<?=public_url() . 'scripts/partial/face-process.js'?>"></script>