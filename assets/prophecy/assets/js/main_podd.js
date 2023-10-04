$(function () {
    var base_url = "https://www.cmuccdc.org/";
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
            if ($('.content').length > 0) {
                $('#main').hide();
                $('#contact').show();
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
            if ($('.content').length > 0) {
                $('#main').show();
                $('#contact').hide();
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
        if ($(window).width() > 575.98) {
            if ($('#menu_slide').is('.frist')) $('#menu_slide').removeClass('frist');
        }
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
    var mySwiper = new Swiper('.swiper-container', {
        lazy: true,
        slidesPerView: 1,
        spaceBetween: 5,
        loop: true,
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        breakpoints: {
            640: {
                slidesPerView: 2,
                loop: true,
            },
            768: {
                slidesPerView: 5,
                loop: true,
            },
            1024: {
                slidesPerView: 5,
                loop: false,
            },
        }
    });
    var mySwiper_title = new Swiper('.swiper-container-title', {
        lazy: true,
        slidesPerView: 1,
        loop: true,
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        breakpoints: {
            640: {
                slidesPerView: 2,
                loop: true,
            },
            768: {
                slidesPerView: 4,
                loop: true,
                autoplay: {
                    delay: 2500,
                    disableOnInteraction: false,
                }
            },
            1024: {
                slidesPerView: 5,
                loop: false,
                autoplay: {
                    delay: 2500,
                    disableOnInteraction: false,
                }
            },
        }
    });
    var mySwiper_footer = new Swiper('.swiper-container-footer', {
        lazy: true,
        slidesPerView: 1,
        loop: true,
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        breakpoints: {
            640: {
                slidesPerView: 1,
                loop: true,
            },
            768: {
                slidesPerView: 4,
                loop: true,
                autoplay: {
                    delay: 2500,
                    disableOnInteraction: false,
                }
            },
            1024: {
                slidesPerView: 5,
                loop: false,
                autoplay: {
                    delay: 2500,
                    disableOnInteraction: false,
                }
            },
        }
    });
    $('.swiper-container .swiper-slide img').on('click', function (e) {
        var ele_active = $('.swiper-slide').find('img.active');
        $(ele_active).removeClass('active img_grayscale_in');
        $(ele_active).addClass('img_grayscale_out');
        $(this).removeClass('img_grayscale_out');
        $(this).addClass('active img_grayscale_in');
        var swiper_tab_id = $(this).attr('data-swiper-tab');
        $('.swiper-tab').addClass('d-none');
        $(swiper_tab_id).removeClass('d-none');
    });

    var Scrollbar = window.Scrollbar;
    Scrollbar.init(document.querySelector('#swiper'));

    $('.btn').tooltip('disable');

    var clipboard = new ClipboardJS('.btn');
    clipboard.on('success', function(e) {
        $(e.trigger).tooltip('enable').tooltip('show');
        e.clearSelection();
    });
    
    clipboard.on('error', function(e) {
        console.error('Action:', e.action);
        console.error('Trigger:', e.trigger);
    });
});