(function($){$(".datepicker").datepicker({minDate:0,maxDate:"+2M +10D",dateFormat:"yy-mm-dd",dayNames:dayNames,dayNamesMin:dayNamesMin,monthNames:monthNames,prevText:prevText,nextText:nextText});$(".exit-alert").on("click",function(){$(this).closest(".copy-date").slideUp();return false});$(".copy-alert").on("click",function(){$(this).parent().find(".copy-date").slideToggle();return false});$(".show-offer").on("click",function(){$(this).parent().parent().find(".offers").slideToggle();return false}); $(".delete-alert").on("click",function(){var alert_id=$(this).parent().data("id"),data={alert_id:alert_id},url="alert/delete",result=JSON.parse(AjaxSendJson(url,data));if(strcmp(result.status,"success")==0)location.reload(true);else if(strcmp(result.status,"fail")==0)HataMesaj(result.text);else if(strcmp(result.status,"error")==0)HataMesaj(result.message);else HataMesaj(er.error_send);return false});$(".inputSave").on("click",function(){var alert_id=$(this).data("id"),date=$(this).prev(".datepicker").val(), data={alert_id:alert_id,date:date},url="alert/copy",result=JSON.parse(AjaxSendJson(url,data));if(strcmp(result.status,"success")==0)location.reload(true);else if(strcmp(result.status,"fail")==0)HataMesaj(result.text);else if(strcmp(result.status,"error")==0)HataMesaj(result.message);else HataMesaj(er.error_send);return false})})(jQuery);