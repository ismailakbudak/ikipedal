
    <!-- container
    ================================== -->
    <div class="container">
    <!-- Modal newuser
    =====================================================-->

          <div  class="row  well" style="padding: 60px 0px 80px 0px; margin:5px 0px 0px 0px; background-color: #FFFFFF; ">
              <div class="col-lg-4" ></div>
              <div class="col-lg-5 well" >
                     <div  id="message" ></div>
                     <ul class="nav navbar-nav navbar-right " style="">
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
                               <legend><i class="text-primary glyphicon glyphicon-log-in one" ></i><?=lang('u.passwordNew')?> </legend>
                               <div class="form-group margin-20" id="loginError" >
                                      <div class="form-group" style=" margin-left:20px" >
                                        <div class="input-group">
                                           <input type="password" class="form-control" id="inputPassword"  placeholder="<?=lang('g.pass')?>">
                                           <span class="input-group-addon "> <i class="glyphicon glyphicon-lock " ></i> </span>
                                         </div>
                                      </div>
                              </div>
                              <div class="form-group margin-20" id="loginError" >
                                      <div class="form-group" style=" margin-left:20px" >
                                        <div class="input-group">
                                           <input type="password" class="form-control" id="inputPasswordAgain"  placeholder="<?=lang('g.passagain')?>">
                                           <span class="input-group-addon "> <i class="glyphicon glyphicon-lock " ></i> </span>
                                         </div>
                                      </div>
                              </div>
                              <div class="form-group margin-20" >
                                      <button id="buttonSendPassword" class="btn btn-primary form-control mrn-lr-20"  > <?=lang('u.create')?>  </button>
                              </div>
                       </fieldset>
                    </div>
                  <br/>
                  <br/>
                  <p style="font-size:19px; margin:20px 0px 20px 0px" > <a href="<?php echo new_url()?>" ><i class=" glyphicon glyphicon-home one"></i> <?=lang('g.mainpage')?> </a> </p>

              </div>
              <div class="col-lg-3" ></div>
    </div>
    <script type="text/javascript"> var new_data = '<?=$new?>'; </script>
    <script src="<?php echo public_url() . 'scripts/partial/newuser.js'?>"></script>





