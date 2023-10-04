function convertDateFormat(dlog){
	var f_date = dlog.split(' ');
	var a_date = f_date[0].split('-');
	var d =a_date[2]+'/'+a_date[1]+'/'+a_date[0];
	var t =f_date[1].substring(0,5);
	return '<i class="far fa-calendar-alt"></i> '+d+' | <i class="far fa-clock"></i> '+t;
}

function convertAVGDateFormat(dlog){
	var f_date = dlog.split(' ');
	var a_date = f_date[0].split('-');
	var d =a_date[2]+'/'+a_date[1]+'/'+a_date[0];
	var t =f_date[1].substring(0,5);
	return 'อัพเดทข้อมูลเมื่อ : '+d+' เวลา '+t+' น.';
}

$(function () {
	var BASE_URL = 'https://www.cmuccdc.org/';
	$(".switch_lang").on('click', function () {
		$.post(BASE_URL+"main/switch_lang",{lang:$(this).attr('lang'), url:$(this).attr('redirect')}, function(data) {
			location.reload();
		});
	});
	$(".switch_type").on('click', function () {
		$.post(BASE_URL+"main/switch_type",{sType:$(this).attr('sType'),url:$(this).attr('redirect')}, function(data) {
			location.reload();
		});
	});
	
	$("#btn-hourly-filter").on('click', function () {
		var s_value = $("#select-hourly-filter").val();
		if(s_value){
			document.location.href = '/hourly/'+s_value;
		}else{alert('กรุณาเลือกจังหวัดเพื่อดูข้อมูล ค่าฝุ่นรายชั่วโมง');}
	});
			
	$("#btn-daily-filter").on('click', function () {
		var s_value = $("#select-daily-filter").val();
		if(s_value){
			document.location.href = '/daily/'+s_value;
		}else{alert('กรุณาเลือกจังหวัดเพื่อดูข้อมูล ค่าฝุ่นรายวัน');}
	});		
	

	$("#news-page-news-feed .news-slice").slice(0, 6).show();
	$(".news-see-more-btn").on('click', function (e) {
		e.preventDefault();
		$("#news-page-news-feed .news-slice:hidden").slice(0, 6).slideDown();
		if ($("#news-page-news-feed .news-slice:hidden").length === 0) {
			$(".news-see-more-btn").addClass('disabled btn');
		}
	}); // News Page Load End
	
	$("#research_feed .research_list").slice(0, 6).show();
	$(".research_more").on('click', function (e) {
		e.preventDefault();
		$("#research_feed .research_list:hidden").slice(0, 6).slideDown();
		if ($("#research_feed .research_list:hidden").length === 0) {
			$(".research_more").addClass('disabled btn');
		}
	}); // News Page Load End
	
	
	$( ".ccdc_content" ).find( "iframe" ).wrap('<div class="embed-responsive embed-responsive-16by9"/>');
	$( ".ccdc_content" ).find( "iframe" ).addClass('embed-responsive-item');
			
    $('.btn-close').on('click', function () {
        $('.card').hide();
    });
    $('#btn_contact').on('click', function () {
        $(this).toggleClass('open');
        if ($(this).is('.open')) {
            $('#main').addClass('fade_out');
            $('#main').removeClass('fade_in');
            $('#contact').removeClass('fade_out');
            $('#contact').addClass('fade_in');
            $('footer').addClass('fade_out');
            $('footer').removeClass('fade_in');
            if ($('#menu_slide').length <= 0) {
                $('#menu_slide').removeClass('out_slide');
                $('#menu_slide').hide();
            }
            if($('.content').length > 0){
                $('#main').hide();$('#contact').show();
            }
            if ($(window).width() <= 575.98 && $('.content').length <= 0) {
                $('body').css('overflow', 'auto');
            }
            if ($(window).scrollTop() >= 115) {
                $('#menu_slide').addClass('out_slide');
                $('#menu_slide').removeClass('in_slide');
                $('#btn_contact').addClass('out_slide_btn');
                $('#btn_contact').removeClass('in_slide_btn');
            }
        } else if (!$(this).is('.open')) {
            $('#contact').addClass('fade_out');
            $('#contact').removeClass('fade_in');
            $('#main').removeClass('fade_out');
            $('#main').addClass('fade_in');
            $('footer').removeClass('fade_out');
            $('footer').addClass('fade_in');
            if ($('#menu_slide').length <= 0) {
                $('#menu_slide').addClass('frist');
                $('#menu_slide').show();
            }
            if($('.content').length > 0){
                $('#main').show();$('#contact').hide();
            }
            if ($(window).width() <= 575.98 && $('.content').length <= 0) {
                $('body').css('overflow', 'hidden');
            }
            if ($(window).scrollTop() >= 115) {
                $('#menu_slide').addClass('in_slide');
                $('#menu_slide').removeClass('out_slide');
                $('#btn_contact').addClass('in_slide_btn');
                $('#btn_contact').removeClass('out_slide_btn');
            }
        }
    });
    var window_top = $(window).scrollTop();
    if (window_top >= 115) {
        if ($('#menu_slide').is('.frist')) $('#menu_slide').removeClass('frist');
        if (!$('#btn_contact').is('.open')) {
            $('#menu_slide').addClass('in_slide');
            $('#menu_slide').removeClass('out_slide');
            $('#btn_contact').addClass('in_slide_btn');
            $('#btn_contact').removeClass('out_slide_btn');
        }
    } else {
        if ($('#btn_contact').is('.open')) {
            $('#menu_slide').removeClass('in_slide');
            $('#btn_contact').removeClass('in_slide_btn');
        }
        if (!$('#menu_slide').is('.frist') && !$('#btn_contact').is('.open')) {
            $('#menu_slide').addClass('out_slide');
            $('#menu_slide').removeClass('in_slide');
            $('#btn_contact').addClass('out_slide_btn');
            $('#btn_contact').removeClass('in_slide_btn');
        }
    }
    $(window).scroll(function () {
        var check_scroll = $(window).scrollTop();
        if ($(window).width() > 992) {
            if (check_scroll >= 115) {
                if ($('#menu_slide').is('.frist')) $('#menu_slide').removeClass('frist');
                if (!$('#btn_contact').is('.open')) {
                    $('#menu_slide').addClass('in_slide');
                    $('#menu_slide').removeClass('out_slide');
                    $('#btn_contact').addClass('in_slide_btn');
                    $('#btn_contact').removeClass('out_slide_btn');
                }
            } else {
                if ($('#btn_contact').is('.open')) {
                    $('#menu_slide').removeClass('in_slide');
                    $('#btn_contact').removeClass('in_slide_btn');
                }
                if (!$('#menu_slide').is('.frist') && !$('#btn_contact').is('.open')) {
                    $('#menu_slide').addClass('out_slide');
                    $('#menu_slide').removeClass('in_slide');
                    $('#btn_contact').addClass('out_slide_btn');
                    $('#btn_contact').removeClass('in_slide_btn');
                }
            }
        }
    });
});