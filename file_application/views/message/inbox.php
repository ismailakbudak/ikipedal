     <style type="text/css">
                .one-thread { display: block;
                              color: #666 !important;
                              padding: 0px 0px;
                              cursor: pointer;
                              margin: 4px;
                              background-color:  #eee; }
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
                                     padding: 0px 0px;
                                     margin-bottom: -1px;
                                     background-color:  #eee;
                                     border-width: 5px;
                                     border-radius: 7px;
                                     border: 1px solid #ddd;  }
                .badge{ background-color: #E65300; }

                .msg .glyphicon{font-size: 25px; margin: 5px;}
     </style>

        <div class="row">
          <div class="col-lg-12">
            <div class="bs-example">
                <ul class="list-group">
                    <?
                         foreach ($inbox as $message) {
                             $origin      = explode(',',$message['origin']);
                             $origin      = $origin[0];
                             $destination = explode(',',$message['destination']);
                             $destination = $destination[0];
                             $offer_id    =   urlencode(base64_encode( $message['event_id'] ));
                             $sender      =   urlencode(base64_encode( $message['sender_userid'] ));
                             $path        = new_url('message/inbox/' . $offer_id ."/" . $sender);
                         	   $val="<li class='list-group-item  message '>
                                     	<a href='". $path ."' class='row one-thread' data-offer_id='". $this->encrypt->encode($message['event_id']) ."' data-sender_userid='".$this->encrypt->encode($message['sender_userid'])."'  >
                                             <div class='col-lg-3 msg-who '>
                                                                <div class='col-lg-3' style='text-align: center;'>
                                                                     <img class='tip pic-img' src='".$message['foto']."' style='width: 50px; height: 60px' height='60' width='50'>
                                                                </div>
                                                                <div class='col-lg-9 name' style='text-align: center; padding-top:20px'>
                                                                    ".$message['name'] . " " .$message['surname'] ."
                                                                </div>
                                             </div>
                                             <div class='col-lg-4 msg '>
                                                      <span class='badge ". (($message['readed_receive'] == 0) ? "unread" : "") ."' >".$message['number']."</span>
                                                      ". $origin . " → " . $destination ."
                                             </div>
                                             <div class='col-lg-5 msg'>
                                                  <div class='col-lg-7'>
                                                      ".  tr(date_format(date_create(  $message['created_at']  ), ' l jS F Y H:i'), $this->lang->lang() ) ."
                                                   </div>
                                                   <div class='col-lg-5' data-offer_id='". $this->encrypt->encode($message['event_id']) ."' data-sender_userid='".$this->encrypt->encode($message['sender_userid'])."' >";
                                              if($message['readed_receive'] != 0){
		                                               $val.=    " <span href='#delete-modal' data-toggle='modal' class='delete-meessages'  >
		                                                               <i title='". lang("delete") ."' class='text-danger glyphicon glyphicon-trash' ></i>
		                                                           </span>
		                                                           <span href='#' class='archieve-messages'  >
		                                                              <i title='". lang("m.archieve") ."' class='text-info glyphicon glyphicon-compressed' ></i>
		                                                           </span>";
									            }
                                                  $val.= " <span href='#block-user-modal-inbox'  data-toggle='modal' class='block-user-inbox'  >
                                                               <i title='". lang("m.block2") ."' class='text-primary glyphicon glyphicon-pause' ></i>
                                                           </span>
                                                   </div>
                                             </div>
                                        </a>
                                    </li>";
                         	  echo  $val;
                         }
                         if( count($inbox) == 0 ){
                              echo " <div class='bs-example'>
                                         <div class='alert alert-dismissable alert-info'>
                                              <button type='button' class='close' data-dismiss='alert' title='". lang('close') ."' >&times;</button>
                                              <h4> ". lang("m.empty") ." <a href='". new_url('message/index') ."' style='margin:10px' title='". lang('refresh') ."' ><i class='glyphicon glyphicon-refresh'></i> </a> </h4>
                                         </div>
                                     </div>";
                         }
                    ?>
                </ul>
            </div>
          </div>
        </div>

        <div class='row' > 
          <div class="pagination">
            <ul>
              <?= $this->pagination->create_links(); ?>
            </ul>
          </div>
        </div>     
        
       <!-- Delete message modal inbox -->
      <div id="delete-modal" class="modal fade" tabindex="-1" data-backdrop="static"  data-keyboard="false" data-offer_id="-1"; data-sender_userid="-1";  style="display: none;">
             <div class="modal-body">
                   <p><?=lang("m.commit")?></p>
             </div>
             <div class="modal-footer">
                   <button type="button" data-dismiss="modal" class="btn width-100"><?=lang("g.cancel")?></button>
                   <button type="button" data-dismiss="modal" class="btn btn-primary width-100"><?=lang("g.yes")?></button>
             </div>
      </div>
       <!-- block user modal inbox -->
      <div id="block-user-modal-inbox" class="modal fade" tabindex="-1" data-backdrop="static" data-width="440px" data-keyboard="false" data-offer_id="-1"; data-sender_userid="-1";  style="display: none;">
             <div class="modal-body">
                   <legend class="name" ></legend>
                   <p><?=lang("m.desc-block")?></p>
                   <textarea  id='inputMessage' class='form-control' rows='3' style='max-width: 390px; max-height:100px; margin-bottom:10px' id='textArea'></textarea>
             </div>
             <div class="modal-footer">
                   <button type="button" data-dismiss="modal" class="btn width-100"><?=lang("g.cancel")?></button>
                   <button type="button" data-dismiss="modal" class="btn btn-primary width-100"><?=lang("m.doblock")?></button>
             </div>
      </div>
      <script src="<?= public_url() . 'scripts/partial/messages/inbox.js'?>"></script>

