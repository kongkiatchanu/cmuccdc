$(function () {
    $('#frm-tracking').submit(function (e) { 
        e.preventDefault();
        var tracking_id = $('#tracking').val();
        if(tracking_id!=''){
            $('li.step').removeClass('active');
            $('.title span').removeClass('active');
            if(tracking_id=='1'){
                $('li.step:first-child').addClass('active');
                $('.status-online').addClass('active');
            }
            else if(tracking_id=='2'){
                $('li.step:nth-child(2)').addClass('active');
                $('.status-offline').addClass('active');
            }
            else if(tracking_id=='3'){
                $('li.step:nth-child(3)').addClass('active');
                $('.status-install').addClass('active');
            }
            else{
                $('li.step:last-child').addClass('active');
                $('.status-fix').addClass('active');
            }
            $('#tracking-modal').modal('show');
        }else{
            console.log("Not tracking!");
        }
    });
});
