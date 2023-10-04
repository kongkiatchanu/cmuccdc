$(function () {
    setTimeout(function () {
        $('#layout-main').addClass('active');
    }, 100);
    if ($('.login-form').length) {
        $('.login-form').validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            rules: {
                username: {
                    required: true
                },
                password: {
                    required: true
                },
                remember: {
                    required: false
                }
            },

            messages: {
                username: {
                    required: "Username is required."
                },
                password: {
                    required: "Password is required."
                }
            },

            invalidHandler: function (event, validator) { //display error alert on form submit   
                $('.alert-danger', $('.login-form')).show();
            },

            highlight: function (element) { // hightlight error inputs
                $(element)
                    .closest('.form-group').addClass('has-error'); // set error class to the control group
            },

            success: function (label) {
                label.closest('.form-group').removeClass('has-error');
                label.remove();
            },

            errorPlacement: function (error, element) {
                error.insertAfter(element.closest('.input-icon'));
            },

            submitHandler: function (form) {
                form.submit();
            }
        });

        $('.login-form input').keypress(function (e) {
            if (e.which == 13) {
                if ($('.login-form').validate().form()) {
                    $('.login-form').submit();
                }
                return false;
            }
        });
    }

    if ($('.frm-login').length) {
        $('.frm-login').validate({
            rules: {
                username: {
                    required: true
                },
                password: {
                    required: true
                }
            },

            messages: {
                username: {
                    required: "กรุณากรอกชื่อผู้ใช้งาน!"
                },
                password: {
                    required: "กรุณากรอกรหัสผ๋าน!"
                }
            },
            highlight: function (element) { // hightlight error inputs
                $(element).closest('.frm-login').addClass('was-validated'); 
            },
            success: function (label) {
                label.closest('.form-group').removeClass('has-error');
                label.remove();
            },
            errorPlacement: function (error, element) {
                element.closest('.col-form-input').find('.invalid-feedback').html(error);
            },
            submitHandler: function (form) {
                form.submit();
            }
        });
    }

    if ($('.frm-tracking').length) {
        $('.frm-tracking').validate({
            // errorElement: 'div', //default input error message container
            // errorLabelContainer: '.invalid-feedback', // default input error message class
            rules: {
                tracking: {
                    required: true
                }
            },
            messages: {
                tracking: {
                    required: "กรุณากรอกรหัสเครื่อง!"
                }
            },
            highlight: function (element) { // hightlight error inputs
                $(element).closest('.frm-tracking').addClass('was-validated'); 
            },
            success: function (label) {
                label.closest('.form-group').removeClass('has-error');
                label.remove();
            },
            errorPlacement: function (error, element) {
                element.closest('.col-form-input').find('.invalid-feedback').html(error);
            },
            submitHandler: function (form) {
                form.submit();
            }
        });
    }

    // $('#frm-tracking').submit(function (e) {
    //     e.preventDefault();
    //     var tracking_id = $('#tracking').val();
    //     if (tracking_id != '') {
    //         $('#tracking-modal').modal('show');
    //     } else {
    //         console.log("Not tracking!");
    //     }
    // });
    //animated////////////////////////////////////////////////////////////////////////
    if ($('#anima-online').length) {
        var element = $('#anima-online');
        var anima_online = {
            // container: element,
            container: element[0],
            renderer: 'svg',
            loop: false,
            autoplay: false,
            path: element.data('icon')
        };
    }
    if ($('#anima-offline').length) {
        var element = $('#anima-offline');
        var anima_offline = {
            container: element[0],
            renderer: 'svg',
            loop: false,
            autoplay: false,
            path: element.data('icon')
        };
    }
    if ($('#anima-install').length) {
        var element = $('#anima-install');
        var anima_install = {
            container: element[0],
            renderer: 'svg',
            loop: true,
            autoplay: false,
            path: element.data('icon')
        }
    }
    if ($('#anima-fix').length) {
        var element = $('#anima-fix');
        var anima_fix = {
            container: element[0],
            renderer: 'svg',
            loop: true,
            autoplay: false,
            path: element.data('icon')
        }
    }
    //modal-open
    $('#tracking-modal').on('shown.bs.modal', function (e) {
        if ($('#anima-online').length) {
            anima_online = lottie.loadAnimation(anima_online);
            anima_online.addEventListener('DOMLoaded', function () {
                anima_online.setSpeed(0.75);
                anima_online.playSegments([0, 70], true);
            });
        }
        if ($('#anima-offline').length) {
            $('.status').addClass('text-danger');
            anima_offline = lottie.loadAnimation(anima_offline);
            anima_offline.addEventListener('DOMLoaded', function () {
                anima_offline.setSpeed(0.75);
                anima_offline.playSegments([70, 198], true);
            });
        }
        if ($('#anima-install').length) {
            $('.status').addClass('text-base-color2');
            anima_install = lottie.loadAnimation(anima_install);
            anima_install.addEventListener('DOMLoaded', function () {
                anima_install.setSpeed(0.5);
                anima_install.play();
            });
        }
        if ($('#anima-fix').length) {
            anima_fix = lottie.loadAnimation(anima_fix);
            anima_fix.addEventListener('DOMLoaded', function () {
                anima_fix.setSpeed(0.5);
                anima_fix.play();
            });
        }
    });
    //modal-close
    $('#tracking-modal').on('hidden.bs.modal', function (e) {
        if ($('#anima-online').length) {
            anima_online = lottie.loadAnimation(anima_online);
            anima_online.addEventListener('DOMLoaded', function () {
                anima_online.destroy();
            });
        }
        if ($('#anima-offline').length) {
            anima_offline = lottie.loadAnimation(anima_offline);
            anima_offline.addEventListener('DOMLoaded', function () {
                anima_offline.destroy();
            });
        }
        if ($('#anima-install').length) {
            anima_install = lottie.loadAnimation(anima_install);
            anima_install.addEventListener('DOMLoaded', function () {
                anima_install.destroy();
            });
        }
        if ($('#anima-fix').length) {
            anima_fix = lottie.loadAnimation(anima_fix);
            anima_fix.addEventListener('DOMLoaded', function () {
                anima_fix.destroy();
            });
        }
    });
    //dasgboard
    $('.search').each(function () {
        var self = $(this);
        var div = self.children('div');
        var placeholder = div.children('input').attr('placeholder');
        var placeholderArr = placeholder.split(/ +/);
        if (placeholderArr.length) {
            var spans = $('<div />');
            $.each(placeholderArr, function (index, value) {
                spans.append($('<span />').html(value + '&nbsp;'));
            });
            div.append(spans);
        }
        self.click(function () {
            self.addClass('open');
            setTimeout(function () {
                self.find('input').focus();
            }, 750);
        });
        $(document).click(function (e) {
            if (!$(e.target).is(self) && !jQuery.contains(self[0], e.target)) {
                self.removeClass('open');
            }
        });
    });
    //set-anima
    if ($('#anima-home').length) {
        var element = $('#anima-home');
        var anima_home = {
            container: element[0],
            renderer: 'svg',
            loop: false,
            autoplay: false,
            path: element.data('icon')
        };
    }
    //event-anima
    if ($('#anima-home').length) {
        anima_home = lottie.loadAnimation(anima_home);
        $('#anima-home').hover(function () {
            // over
            anima_home.setSpeed(1.75);
            anima_home.playSegments([0, 16], true);
        }, function () {
            // out
            anima_home.setSpeed(1.75);
            anima_home.playSegments([16, 24], true);
        });
    }
    if ($('.anima-arrow').length) {
        if ($('.nav-item').hasClass('active')) {
            $('.nav-item.active .anima-arrow').removeClass('down');
            $('.nav-item.active .anima-arrow').addClass('up');
        }
        if($('.nav-item').not('.active')){
            $('.nav-item').not('.active').find('.collapse').collapse('hide');
        }
        $('.nav-item').not('.active').find('.anima-arrow').removeClass('up');
        $('.nav-item').not('.active').find('.anima-arrow').addClass('down');
        var element = $('.anima-arrow');
        $('.anima-arrow').each(function (index) {
            var anima_arrow = {
                container: element[index],
                renderer: 'svg',
                loop: true,
                autoplay: false,
                path: element.data('icon')
            };
            anima_arrow = lottie.loadAnimation(anima_arrow);
            $('.nav-link').on('mouseenter', function () {
                anima_arrow.setSpeed(0.75);
                anima_arrow.play();
            });
            $('.nav-link').on('mouseleave', function () {
                anima_arrow.setSpeed(0.75);
                anima_arrow.stop();
            });
           
        });
        $('.collapse').on('shown.bs.collapse', function () {
            $('.nav-link.collapsed').find('.anima-arrow').removeClass('up');
            $('.nav-link.collapsed').find('.anima-arrow').addClass('down');
            $('.nav-link').not('.collapsed').find('.anima-arrow').removeClass('down');
            $('.nav-link').not('.collapsed').find('.anima-arrow').addClass('up');
        });
        $('.collapse').on('hidden.bs.collapse', function () {
            $('.nav-link.collapsed').find('.anima-arrow').removeClass('up');
            $('.nav-link.collapsed').find('.anima-arrow').addClass('down');
            $('.nav-link').not('.collapsed').find('.anima-arrow').removeClass('down');
            $('.nav-link').not('.collapsed').find('.anima-arrow').addClass('up');
        });
    }
    //datatable////////////////////////////////////////////////////////////////////////
    if($('#table-test').length){
        $('#table-test').DataTable({
            "lengthMenu": [[5, 10, 20, 30, -1], [5, 10, 20, 30, "All"]]
        });
    }
    //admin/////////////////////////////////////////////////////////////////////////////
    var preview = $("#upload-preview");  
    var container= $("div.containerz");
    var base_url = 'https://www.cmuccdc.org/';

    /* DROPZONE */
    // Dropzone.autoDiscover = false;
        
    if ($('#dropzone').length) {
        var myDropzone = new Dropzone("#dropzone",{
            url: 'https://www.cmuccdc.org/assets/plugins/dropzone/upload.php',
            maxFiles: 1,
            autoProcessQueue: false,
            addRemoveLinks: true,
            init: function() {
                this.on("maxfilesexceeded", function(file){
                        this.removeAllFiles();
                        this.addFile(file);
                    });
                },
                success: function(file, response){
                    $("#h_image").val(response);
                }
                
        });
    }
        
    $('#remove_image_cover').on("click",function(){
        $('#dropzone').show();
        $('#image_cover_show').hide();
    });
    /* DROPZONE */

    if($("#frm_slide").length){
        $("#frm_slide").validate({
            // errorContainer: container,
            // errorLabelContainer: $("ol", container),
            // wrapper: "li",
            // meta: "validate",
            submitHandler: function(form) {
                        
                myDropzone.processQueue();
    
                setTimeout(function(){
                    //if($("#h_image").val()){
                        form.submit();
                //}
                },1000)
                        
            }
        });
    }
});

//scrollbar////////////////////////////////////////////////////////////////////////
if ($('#main-scrollbar').length) {
    Scrollbar.use(OverscrollPlugin);
    var options = {
        damping: .05,
        thumbMinSize: 5,
        renderByPixel: true,
        alwaysShowTracks: false,
        continuousScrolling: true
    };
    if ($('#main-scrollbar').length) {
        var element1 = document.querySelector('#main-scrollbar');
        Scrollbar.init(element1, options);
    }
    if ($('#sidebar').length) {
        var element2 = document.querySelector('#sidebar');
        Scrollbar.init(element2, options);
    }
}