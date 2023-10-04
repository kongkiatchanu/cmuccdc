$(function () {
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
            // $('footer').addClass('fade_out');
            // $('footer').removeClass('fade_in');
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
            // $('footer').removeClass('fade_out');
            // $('footer').addClass('fade_in');
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
    if (!document.cookie == 'lang_cookie=TH' || !document.cookie == 'lang_cookie=EN') {
        Cookies.set('lang_cookie', 'TH');
        // console.log(document.cookie);
    } else {
        if (Cookies.get('lang_cookie') == 'EN') {
            $('#main .sub_menu .lang button[name="TH"]').toggleClass('active');
            $('#main .sub_menu .lang button[name="EN"]').toggleClass('active');
            $(".nav-link.home").html('Home');
            $(".nav-link.pm25nearby").html('PM<sub>2.5</sub>Nearby');
            $(".nav-link.hourly").html('Hourly');
            $(".nav-link.daily").html('Daily');
        }
    }
    $('#main .sub_menu .lang button').click(function (e) {
        var lang = $(this).html();
        if (!$(this).hasClass('active')) {
            $('#main .sub_menu .lang button[name="TH"]').toggleClass('active');
            $('#main .sub_menu .lang button[name="EN"]').toggleClass('active');
            if (lang == 'EN') {
                Cookies.set('lang_cookie', 'EN');
                $(".nav-link.home").html('Home');
                $(".nav-link.pm25nearby").html('PM<sub>2.5</sub>Nearby');
                $(".nav-link.hourly").html('Hourly');
                $(".nav-link.daily").html('Daily');
            } else {
                Cookies.set('lang_cookie', 'TH');
                $(".nav-link.home").html('หน้าหลัก');
                $(".nav-link.pm25nearby").html('PM<sub>2.5</sub>ตามพิกัด');
                $(".nav-link.hourly").html('ค่าฝุ่นรายชั่วโมง');
                $(".nav-link.daily").html('ค่าฝุ่นรายวัน');
            }
            $('#popupDetail').hide();
        }
    });
    var DateFormatter = {
        // monthNames: [
        //     "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน",
        //     "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"
        // ],
        monthNames: [
            "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.",
            "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค."
        ],
        dayNames: ["อาทิตย์", "จันทร์", "อังคาร", "พุธ", "พฤหัสบดี", "ศุกร์", "เสาร์"],
        formatDate: function (date, format) {
            var self = this;
            format = self.getProperDigits(format, /d+/gi, date.getDate());
            format = self.getProperDigits(format, /M+/g, date.getMonth() + 1);
            format = format.replace(/y+/gi, function (y) {
                var len = y.length;
                var year = date.getFullYear();
                if (len == 2)
                    return ((year + 543) + "").slice(-2);
                else if (len == 4)
                    return year + 543;
                return y;
            })
            format = self.getProperDigits(format, /H+/g, date.getHours());
            format = self.getProperDigits(format, /h+/g, self.getHours12(date.getHours()));
            format = self.getProperDigits(format, /m+/g, date.getMinutes());
            format = self.getProperDigits(format, /s+/gi, date.getSeconds());
            format = format.replace(/a/ig, function (a) {
                var amPm = self.getAmPm(date.getHours())
                if (a === 'A')
                    return amPm.toUpperCase();
                return amPm;
            })
            format = self.getFullOr3Letters(format, /d+/gi, self.dayNames, date.getDay())
            format = self.getFullOr3Letters(format, /M+/g, self.monthNames, date.getMonth())
            return format;
        },
        getProperDigits: function (format, regex, value) {
            return format.replace(regex, function (m) {
                var length = m.length;
                if (length == 1)
                    return value;
                else if (length == 2)
                    return ('0' + value).slice(-2);
                return m;
            })
        },
        getHours12: function (hours) {
            // https://stackoverflow.com/questions/10556879/changing-the-1-24-hour-to-1-12-hour-for-the-gethours-method
            return (hours + 24) % 12 || 12;
        },
        getAmPm: function (hours) {
            // https://stackoverflow.com/questions/8888491/how-do-you-display-javascript-datetime-in-12-hour-am-pm-format
            return hours >= 12 ? 'pm' : 'am';
        },
        getFullOr3Letters: function (format, regex, nameArray, value) {
            return format.replace(regex, function (s) {
                var len = s.length;
                if (len == 3)
                    return nameArray[value];
                else if (len == 4)
                    return nameArray[value];
                return s;
            })
        }
    }
    var DateFormatter_en = {
        monthNames: [
            "Jan", "Feb", "Mar", "Apr", "May", "Jun",
            "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"
        ],
        dayNames: ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
        formatDate: function (date, format) {
            var self = this;
            format = self.getProperDigits(format, /d+/gi, date.getDate());
            format = self.getProperDigits(format, /M+/g, date.getMonth() + 1);
            format = format.replace(/y+/gi, function (y) {
                var len = y.length;
                var year = date.getFullYear();
                if (len == 2)
                    return (year + "").slice(-2);
                else if (len == 4)
                    return year;
                return y;
            })
            format = self.getProperDigits(format, /H+/g, date.getHours());
            format = self.getProperDigits(format, /h+/g, self.getHours12(date.getHours()));
            format = self.getProperDigits(format, /m+/g, date.getMinutes());
            format = self.getProperDigits(format, /s+/gi, date.getSeconds());
            format = format.replace(/a/ig, function (a) {
                var amPm = self.getAmPm(date.getHours())
                if (a === 'A')
                    return amPm.toUpperCase();
                return amPm;
            })
            format = self.getFullOr3Letters(format, /d+/gi, self.dayNames, date.getDay())
            format = self.getFullOr3Letters(format, /M+/g, self.monthNames, date.getMonth())
            return format;
        },
        getProperDigits: function (format, regex, value) {
            return format.replace(regex, function (m) {
                var length = m.length;
                if (length == 1)
                    return value;
                else if (length == 2)
                    return ('0' + value).slice(-2);
                return m;
            })
        },
        getHours12: function (hours) {
            // https://stackoverflow.com/questions/10556879/changing-the-1-24-hour-to-1-12-hour-for-the-gethours-method
            return (hours + 24) % 12 || 12;
        },
        getAmPm: function (hours) {
            // https://stackoverflow.com/questions/8888491/how-do-you-display-javascript-datetime-in-12-hour-am-pm-format
            return hours >= 12 ? 'pm' : 'am';
        },
        getFullOr3Letters: function (format, regex, nameArray, value) {
            return format.replace(regex, function (s) {
                var len = s.length;
                if (len == 3)
                    return nameArray[value];
                else if (len == 4)
                    return nameArray[value];
                return s;
            })
        }
    }
    //test map
    if ($('.map').length > 0) {
        var width_window = $(window).width();
        var zoom_map;
        if (width_window < 1600) {
            zoom_map = 12;
        } else {
            zoom_map = 13;
        }
        $('a[data-toggle="tab"]').on('click', function (e) {
            $('#popupDetail').hide();
        });
        //////////////////////////////////////////////////////////////////////////////////////////////////////////
        var map = L.map('th_map', {
            attributionControl: false
        });
        map.createPane('labels');
        map.getPane('labels').style.zIndex = 650;
        map.getPane('labels').style.pointerEvents = 'none';
        var positron = L.tileLayer('https://{s}.basemaps.cartocdn.com/light_nolabels/{z}/{x}/{y}.png').addTo(map);
        var positronLabels = L.tileLayer('https://{s}.basemaps.cartocdn.com/light_only_labels/{z}/{x}/{y}.png').addTo(map);
        map.setView({
            lat: 13.915715,
            lng: 100.5305501
        }, zoom_map);
        //Locate
        var lc = L.control.locate({
            position: "topleft",
            strings: {
                title: "My location"
            },
            locateOptions: {
                // maxZoom: 13,
                enableHighAccuracy: true
            },
        }).addTo(map);
        $.getJSON("https://www-old.cmuccdc.org/api2/dustboy/pakkret", function (db) {
            if (db) {
                $.each(db, function (index, value) {
                    var page;
                    var number_title;
                    var color_marker;
                    if ($('#contact .menu_contact .nav-link.daily').is('.active')) {
                        page = 'daily';
                        number_title = Math.floor(parseFloat(value.daily_pm25));
                        color_marker = value.daily_th_color;
                    } else {
                        number_title = Math.floor(parseFloat(value.pm25));
                        color_marker = value.th_color;
                    }
                    var marker = L.marker([value.dustboy_lat, value.dustboy_lon], {
                        icon: L.divIcon({
                            className: "custom_marker",
                            iconSize: [35, 35],
                            iconAnchor: [0, 0],
                            labelAnchor: [-6, 0],
                            popupAnchor: [17, 0],
                            html: '<div class="custom_marker" style="background-color:rgba(' + color_marker + ')">' + number_title + '</div>'
                        })
                    }).addTo(map);
                    marker.on('click', function (e) {
                        var lang = Cookies.get("lang_cookie");
                        var time_th =db[0]['log_datetime'];
                        var time_en = db[0]['log_datetime'];
                        if (!lang=='TH' || !lang=='EN') {
                            $('.time').html('<i class="far fa-clock"></i> '+time_th);
                        } else {
                            if (lang == 'EN') {
                                $('.time').html('<i class="far fa-clock"></i> '+time_en);
                            }else{
                                $('.time').html('<i class="far fa-clock"></i> '+time_th);
                            }
                        }
                        //pm2.5/TH AQI
                        if (page != 'daily') {
                            if (lang == 'EN') {
                                // DateFormatter_en.formatDate(new Date(value.log_datetime),'D MMM YYYY hh:mm A')
                                // DateFormatter.formatDate(new Date(value.log_datetime),'D MMM YYYY HH:mm น.')
                                $('#popupDetail .card-header p').html(value.dustboy_name_en);
                                $('#popupDetail .detail_title').html(value.th_title_en);
                            } else {
                                $('#popupDetail .card-header p').html(value.dustboy_name);
                                $('#popupDetail .detail_title').html(value.th_title);
                            }

                            if ($('a[data-toggle="tab"].active').attr('name') == 'pm25') {
                                $('#popupDetail .number_title').html(Math.floor(parseFloat(value.pm25)));
                                $('#popupDetail .number_footer').html('μg/m<sup>3</sup>');
                                $('#popupDetail .card-footer span.pm25').html('PM<sub>2.5</sub> AQI ' + value.th_aqi + '');
                            } else {
                                $('#popupDetail .number_title').html(value.th_aqi);
                                $('#popupDetail .number_footer').html('PM<sub>2.5</sub> TH AQI');
                                $('#popupDetail .card-footer span.pm25').html('PM<sub>2.5</sub> ' + value.pm25 + ' μg/m<sup>3</sup>');
                            }
                            $('#popupDetail .card-header').css("background-color", "rgba(" + value.th_color + ", 0.65)");
                            $('#popupDetail .card-body').css("background-color", "rgba(" + value.th_color + ", 0.65)");
                            $('#popupDetail .card-footer').css("background-color", "rgba(" + value.th_color + ", 0.65)");
                            $('#popupDetail .card-body .anime img').attr("src", 'https://dev2.cmuccdc.org/template/image/' + value.th_dustboy_icon + '.svg');
                            $('#popupDetail .card-footer span.temp').html(value.temp + ' ℃');
                            $('#popupDetail .card-footer span.humid').html(value.humid + ' %');
                            $('#popupDetail .card-footer span.pm10').html('[PM<sub>10</sub> ' + value.pm10 + ' μg/m<sup>3</sup>]');
                        } else {
                            if (lang == 'EN') {
                                $('#popupDetail .card-header p').html(value.dustboy_name_en + '<br>' + DateFormatter_en.formatDate(new Date(value.log_datetime), 'D MMM YYYY'));
                                $('#popupDetail .detail_title').html(value.daily_th_title_en);
                            } else {
                                $('#popupDetail .card-header p').html(value.dustboy_name + '<br>' + DateFormatter.formatDate(new Date(value.log_datetime), 'D MMM YYYY'));
                                $('#popupDetail .detail_title').html(value.daily_th_title);
                            }

                            if ($('a[data-toggle="tab"].active').attr('name') == 'pm25') {
                                $('#popupDetail .number_title').html(Math.floor(parseFloat(value.daily_pm25)));
                                $('#popupDetail .number_footer').html('μg/m<sup>3</sup>');
                                $('#popupDetail .card-footer span.pm25').html('PM<sub>2.5</sub> AQI ' + value.daily_pm25_th_aqi + '');
                            } else {
                                $('#popupDetail .number_title').html(value.daily_pm25_th_aqi);
                                $('#popupDetail .number_footer').html('PM<sub>2.5</sub> TH AQI');
                                $('#popupDetail .card-footer span.pm25').html('PM<sub>2.5</sub> ' + value.daily_pm25 + ' μg/m<sup>3</sup>');
                            }
                            $('#popupDetail .card-header').css("background-color", "rgba(" + value.daily_th_color + ", 0.65)");
                            $('#popupDetail .card-body').css("background-color", "rgba(" + value.daily_th_color + ", 0.65)");
                            $('#popupDetail .card-footer').css("background-color", "rgba(" + value.daily_th_color + ", 0.65)");
                            $('#popupDetail .card-body .anime img').attr("src", 'https://dev2.cmuccdc.org/template/image/' + value.daily_th_dustboy_icon + '.svg');
                            $('#popupDetail .card-footer span.temp').html(value.daily_temp + ' ℃');
                            $('#popupDetail .card-footer span.humid').html(value.daily_humid + ' %');
                            $('#popupDetail .card-footer span.pm10').html('[PM<sub>10</sub> ' + value.daily_pm10 + ' μg/m<sup>3</sup>]');
                        }
                        $('#popupDetail').show();
                    });
                    //click pm25/th aqi
                    $('a[data-toggle="tab"]').on('click', function (e) {
                        var category = $(this).attr('name');
                        var page;
                        var number_marke;
                        var color_marker;
                        if (!$('#contact .menu_contact .nav-link.daily').is('.active') && category == 'pm25') {
                            number_marke = Math.floor(parseFloat(value.pm25));
                            color_marker = value.th_color;
                        } else if (!$('#contact .menu_contact .nav-link.daily').is('.active') && category != 'pm25') {
                            number_marke = value.th_aqi;
                            color_marker = value.th_color;
                        } else if ($('#contact .menu_contact .nav-link.daily').is('.active') && category == 'pm25') {
                            page = 'daily';
                            number_marke = Math.floor(parseFloat(value.daily_pm25));
                            color_marker = value.daily_th_color;
                        } else if ($('#contact .menu_contact .nav-link.daily').is('.active') && category != 'pm25') {
                            page = 'daily';
                            number_marke = value.daily_pm25_th_aqi;
                            color_marker = value.daily_th_color;
                        }
                        var marker = L.marker([value.dustboy_lat, value.dustboy_lon], {
                            icon: L.divIcon({
                                className: "custom_marker",
                                iconSize: [35, 35],
                                iconAnchor: [0, 0],
                                labelAnchor: [-6, 0],
                                popupAnchor: [17, 0],
                                html: '<div class="custom_marker"style="background-color:rgba(' + color_marker + ')">' + number_marke + '</div>'
                            })
                        }).addTo(map);

                        marker.on('click', function (e) {
                            var lang = Cookies.get("lang_cookie");
                            //pm2.5/TH AQI
                            if (page != 'daily') {

                                if (lang == 'EN') {
                                    $('#popupDetail .card-header p').html(value.dustboy_name_en + '<br>' + DateFormatter_en.formatDate(new Date(value.log_datetime), 'D MMM YYYY hh:mm A'));
                                    $('#popupDetail .detail_title').html(value.th_title_en);
                                } else {
                                    $('#popupDetail .card-header p').html(value.dustboy_name + '<br>' + DateFormatter.formatDate(new Date(value.log_datetime), 'D MMM YYYY HH:mm น.'));
                                    $('#popupDetail .detail_title').html(value.th_title);
                                }

                                if ($('a[data-toggle="tab"].active').attr('name') == 'pm25') {
                                    $('#popupDetail .number_title').html(Math.floor(parseFloat(value.pm25)));
                                    $('#popupDetail .number_footer').html('μg/m<sup>3</sup>');
                                    $('#popupDetail .card-footer span.pm25').html('PM<sub>2.5</sub> AQI ' + value.th_aqi + '');
                                } else {
                                    $('#popupDetail .number_title').html(value.th_aqi);
                                    $('#popupDetail .number_footer').html('PM<sub>2.5</sub> TH AQI');
                                    $('#popupDetail .card-footer span.pm25').html('PM<sub>2.5</sub> ' + value.pm25 + ' μg/m<sup>3</sup>');
                                }
                                $('#popupDetail .card-header').css("background-color", "rgba(" + value.th_color + ", 0.65)");
                                $('#popupDetail .card-body').css("background-color", "rgba(" + value.th_color + ", 0.65)");
                                $('#popupDetail .card-footer').css("background-color", "rgba(" + value.th_color + ", 0.65)");
                                $('#popupDetail .card-body .anime img').attr("src", 'https://dev2.cmuccdc.org/template/image/' + value.th_dustboy_icon + '.svg');
                                $('#popupDetail .card-footer span.temp').html(value.temp + ' ℃');
                                $('#popupDetail .card-footer span.humid').html(value.humid + ' %');
                                $('#popupDetail .card-footer span.pm10').html('[PM<sub>10</sub> ' + value.pm10 + ' μg/m<sup>3</sup>]');
                            } else {
                                if (lang == 'EN') {
                                    $('#popupDetail .card-header p').html(value.dustboy_name_en + '<br>' + DateFormatter_en.formatDate(new Date(value.log_datetime), 'D MMM YYYY hh:mm A'));
                                    $('#popupDetail .detail_title').html(value.daily_th_title_en);
                                } else {
                                    $('#popupDetail .card-header p').html(value.dustboy_name + '<br>' + DateFormatter.formatDate(new Date(value.log_datetime), 'D MMM YYYY HH:mm น.'));
                                    $('#popupDetail .detail_title').html(value.daily_th_title);
                                }

                                if ($('a[data-toggle="tab"].active').attr('name') == 'pm25') {
                                    $('#popupDetail .number_title').html(Math.floor(parseFloat(value.daily_pm25)));
                                    $('#popupDetail .number_footer').html('μg/m<sup>3</sup>');
                                    $('#popupDetail .card-footer span.pm25').html('PM<sub>2.5</sub> AQI ' + value.daily_pm25_th_aqi + '');
                                } else {
                                    $('#popupDetail .number_title').html(value.daily_pm25_th_aqi);
                                    $('#popupDetail .number_footer').html('PM<sub>2.5</sub> TH AQI');
                                    $('#popupDetail .card-footer span.pm25').html('PM<sub>2.5</sub> ' + value.daily_pm25 + ' μg/m<sup>3</sup>');
                                }
                                $('#popupDetail .card-header').css("background-color", "rgba(" + value.daily_th_color + ", 0.65)");
                                $('#popupDetail .card-body').css("background-color", "rgba(" + value.daily_th_color + ", 0.65)");
                                $('#popupDetail .card-footer').css("background-color", "rgba(" + value.daily_th_color + ", 0.65)");
                                $('#popupDetail .card-body .anime img').attr("src", 'https://dev2.cmuccdc.org/template/image/' + value.daily_th_dustboy_icon + '.svg');
                                $('#popupDetail .card-footer span.temp').html(value.daily_temp + ' ℃');
                                $('#popupDetail .card-footer span.humid').html(value.daily_humid + ' %');
                                $('#popupDetail .card-footer span.pm10').html('[PM<sub>10</sub> ' + value.daily_pm10 + ' μg/m<sup>3</sup>]');
                            }
                            $('#popupDetail').show();
                        });
                    });
                });
            }
        });
        //polygon map
        var geo = L.geoJson({
            features: []
        }).addTo(map);
        var base = 'assets/map/shp2.zip';
        shp(base).then(function (data) {
            geo.addData(data);
        });
    }
});