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
        if($(window).width() > 575.98){
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
    $.getJSON(base_url+"assets/prophecy/assets/js/all/standard_aqi.json?v=2",function (data) {
        //pm25
        $.each(data[0].us_aqi['pm25'], function (index, value) { 
            $('.cate_us .us'+(index+1)).css("background-color","rgba(" + value.color + ")");
            (index>=4)?$('.cate_us .num.us'+(index+1)).html('<span class="text-shadow-drop-bottom anime_delay05">≥ ' + value.min +'</span>'):$('.cate_us .num.us'+(index+1)).html('<span class="text-shadow-drop-bottom anime_delay05">' + value.min + '-' + value.max + '</span>');
            $('.cate_us .aqi .detail_pm_aqi.us'+(index+1)).html('<img class="shadow-drop-bottom-icon anime_delay1" src="https://www.cmuccdc.org/template/image/' + value.dustboy_icon + '">');
            // (index>=4)?$('.cate_us_daily .num.us'+(index+1)).html('<span class="text-shadow-drop-bottom anime_delay05">≥ ' + value.min +'</span>'):$('.cate_us_daily .num.us'+(index+1)).html('<span class="text-shadow-drop-bottom anime_delay05">' + value.min + '-' + value.max + '</span>');
        });
        $.each(data[0].th_aqi['pm25'], function (index, value) { 
            $('.cate_th .th'+(index+1)).css("background-color","rgba(" + value.color + ")");
            (index>=3)?$('.cate_th .num.th'+(index+1)).html('<span class="text-shadow-drop-bottom anime_delay05">≥ ' + value.min +'</span>'):$('.cate_th .num.th'+(index+1)).html('<span class="text-shadow-drop-bottom anime_delay05">' + value.min + '-' + value.max + '</span>');
            $('.cate_th .aqi .detail_pm_aqi.th'+(index+1)).html('<img class="shadow-drop-bottom-icon anime_delay1" src="https://www.cmuccdc.org/template/image/' + value.dustboy_icon + '">');
            // (index>=3)?$('.cate_th_daily .num.th'+(index+1)).html('<span class="text-shadow-drop-bottom anime_delay05">≥ ' + value.min +'</span>'):$('.cate_th_daily .num.th'+(index+1)).html('<span class="text-shadow-drop-bottom anime_delay05">' + value.min + '-' + value.max + '</span>');
        });
        //aqi
        // $.each(data[0].us_aqi['aqi'], function (index, value) { 
        //     $('.cate_us_daily .us'+(index+1)).css("background-color","rgba(" + value.color + ")");
        //     (index>=4)?$('.cate_us_daily .daily.us'+(index+1)).html('<span class="text-shadow-drop-bottom anime_delay05">≥ ' + value.min +'</span>'):$('.cate_us_daily .daily.us'+(index+1)).html('<span class="text-shadow-drop-bottom anime_delay05">' + value.min + '-' + value.max + '</span>');
        // });
        // $.each(data[0].th_aqi['aqi'], function (index, value) { 
        //     $('.cate_th_daily .th'+(index+1)).css("background-color","rgba(" + value.color + ")");
        //     (index>=3)?$('.cate_th_daily .daily.th'+(index+1)).html('<span class="text-shadow-drop-bottom anime_delay05">≥ ' + value.min +'</span>'):$('.cate_th_daily .daily.th'+(index+1)).html('<span class="text-shadow-drop-bottom anime_delay05">' + value.min + '-' + value.max + '</span>');
        // });
    });
    $('#table_pm25_nearby1,#table_pm25_nearby2,#table_pm25_nearby3,#table_pm25_nearby4,#table_pm25_nearby5,#table_pm25_nearby6,#table_pm25_nearby7,#table_pm25_nearby8,#table_pm25_nearby9,#table_pm25_nearby10,#table_pm25_nearby11,#table_pm25_nearby12,#table_pm25_nearby13').DataTable({
        "lengthMenu": [
            [-1,10, 20, 50],
            ["All",10, 20, 50]
        ],
        "order": [],
    });
    function colorpm25(pm25){
        if(pm25<=15){
            return '0,191,243'
        }else if(pm25>15&&pm25<=25){
            return '0,166,81'
        }else if(pm25>25&&pm25<=37){
            return '253,192,78'
        }else if(pm25>37&&pm25<=75){
            return '242,101,34'
        }else{
            return '205,0,0'
        }
    }
    map('map1',base_url+'report/pdf_pm25_test/1?v=1','th',18.7804223,99.9535746,7);
    map('map2',base_url+'report/pdf_pm25_test/2?v=1','th',16.7804223,99.9535746,7);
    map('map3',base_url+'report/pdf_pm25_test/3?v=1','th',14.7804223,99.9535746,7);
    map('map4',base_url+'report/pdf_pm25_test/4?v=1','th',15.2804223,99.9535746,7);
    map('map5',base_url+'report/pdf_pm25_test/5?v=1','th',14.7804223,99.9535746,6);
    map('map6',base_url+'report/pdf_pm25_test/6?v=1','th',14.7804223,99.9535746,6);
    map('map7',base_url+'report/pdf_pm25_test/7?v=1','th',16.2804223,103.0535746,8);
    map('map8',base_url+'report/pdf_pm25_test/8?v=1','th',17.2804223,103.0535746,7);
    map('map9',base_url+'report/pdf_pm25_test/9?v=1','th',16.5804223,103.0535746,7);
    map('map10',base_url+'report/pdf_pm25_test/10?v=1','th',15.2804223,105.0535746,8);
    map('map11',base_url+'report/pdf_pm25_test/11?v=1','th',7.2804223,99.9535746,8);
    map('map12',base_url+'report/pdf_pm25_test/12?v=1','th',7.0076994,100.4753595,14); 
    map('map13',base_url+'report/pdf_pm25_test/13?v=1','th',13.7248936,100.5530265,11);
   
    function map(id,url,index_map,lat,lng,zoom) {
        var normalMap = L.tileLayer.ThaiProvider('Google.Normal.Map', {
            maxZoom: 18,
            minZoom: 5
        }),
        satelliteMap = L.tileLayer.ThaiProvider('Google.Satellite.Map', {
            maxZoom: 18,
            minZoom: 5
        });
        var baseLayers = {
            "Normal map": normalMap,
            "Satellite map": satelliteMap,
        }
        var map = L.map(id, {
            layers: [normalMap],
            attributionControl: false
        });
        L.control.layers(baseLayers).addTo(map);

        map.createPane('labels');
        map.getPane('labels').style.zIndex = 650;
        map.getPane('labels').style.pointerEvents = 'none';
        map.setView({
            lat: lat!=null?lat:0,
            lng: lng!=null?lng:0
        }, zoom);
        //Locate
        var lc = L.control.locate({
            position: "topleft",
            strings: {
                title: "My location"
            },
            locateOptions: {
                enableHighAccuracy: true
            },
        }).addTo(map);
        $.getJSON(url, function (db) {
            if (db) {
                $.each(db, function (index, value) {
                    $.each(value.stations, function (i, v) {
                        
                        var marker = {};
                        var number_title,color_marker,title_en,title,dustboy_icon,chk_safety;
                        //////////////////////////////////////////////////////////////
                        // chk_safety = 0;
                        number_title = Math.floor(parseFloat(v.pm25['PM25']));
                        color_marker = colorpm25(v.pm25['PM25']);
                        // title_en = value.us_title_en;
                        // title = value.us_title;
                        // dustboy_icon = value.us_dustboy_icon;
                        //////////////////////////////////////////////////////////////
                        if(number_title){
                            // console.log(v.location_lat);
                            // console.log(v.location_lon);
                            // console.log(number_title);
                            marker = L.marker([v.location_lat, v.location_lon], {
                                icon: L.divIcon({
                                    className: "custom_marker",
                                    iconSize: [35, 35], 
                                    iconAnchor: [0, 0],
                                    labelAnchor: [-6, 0],
                                    popupAnchor: [17, 0],
                                    html: '<div class="custom_marker slit_in_vertical anime_delay075" style="background-color:rgba(' + color_marker + ')">' + number_title + '</div>'
                                })
                            }).addTo(map);
                        }
                    });
                });
            }
        });
    }
});