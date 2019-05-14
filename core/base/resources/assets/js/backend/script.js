var Lcms = window.Lcms || {};

Lcms.blockUI = function (options) {
    options = $.extend(true, {}, options);
    var html = '';
    if (options.animate) {
        html = '<div class="loading-message ' + (options.boxed ? 'loading-message-boxed' : '') + '">' + '<div class="block-spinner-bar"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div>' + '</div>';
    } else if (options.iconOnly) {
        html = '<div class="loading-message ' + (options.boxed ? 'loading-message-boxed' : '') + '"><img src="/vendor/core/images/loading-spinner-blue.gif" align=""></div>';
    } else if (options.textOnly) {
        html = '<div class="loading-message ' + (options.boxed ? 'loading-message-boxed' : '') + '"><span>&nbsp;&nbsp;' + (options.message ? options.message : 'LOADING...') + '</span></div>';
    } else {
        html = '<div class="loading-message ' + (options.boxed ? 'loading-message-boxed' : '') + '"><img src="/vendor/core/images/loading-spinner-blue.gif" align=""><span>&nbsp;&nbsp;' + (options.message ? options.message : 'LOADING...') + '</span></div>';
    }

    if (options.target) { // element blocking
        var el = $(options.target);
        if (el.height() <= ($(window).height())) {
            options.cenrerY = true;
        }
        el.block({
            message: html,
            baseZ: options.zIndex ? options.zIndex : 1000,
            centerY: options.cenrerY !== undefined ? options.cenrerY : false,
            css: {
                top: '10%',
                border: '0',
                padding: '0',
                backgroundColor: 'none'
            },
            overlayCSS: {
                backgroundColor: options.overlayColor ? options.overlayColor : '#555',
                opacity: options.boxed ? 0.05 : 0.1,
                cursor: 'wait'
            }
        });
    } else { // page blocking
        $.blockUI({
            message: html,
            baseZ: options.zIndex ? options.zIndex : 1000,
            css: {
                border: '0',
                padding: '0',
                backgroundColor: 'none'
            },
            overlayCSS: {
                backgroundColor: options.overlayColor ? options.overlayColor : '#555',
                opacity: options.boxed ? 0.05 : 0.1,
                cursor: 'wait'
            }
        });
    }
};

Lcms.unblockUI = function (target) {
    if (target) {
        $(target).unblock({
            onUnblock: function () {
                $(target).css('position', '');
                $(target).css('zoom', '');
            }
        });
    } else {
        $.unblockUI();
    }
};

Lcms.showNotice = function (messageType, message, messageHeader) {
    toastr.clear();

    toastr.options = {
        closeButton: true,
        positionClass: 'toast-bottom-right',
        onclick: null,
        showDuration: 1000,
        hideDuration: 1000,
        timeOut: 10000,
        extendedTimeOut: 1000,
        showEasing: 'swing',
        hideEasing: 'linear',
        showMethod: 'fadeIn',
        hideMethod: 'fadeOut'

    };
    toastr[messageType](message, messageHeader);
};

Lcms.handleError = function (data) {
    if (typeof (data.responseJSON) != 'undefined') {
        if (typeof (data.responseJSON.message) != 'undefined') {
            Lcms.showNotice('error', data.responseJSON.message, Lcms.languages.notices_msg.error);
        } else {
            $.each(data.responseJSON, function (index, el) {
                $.each(el, function (key, item) {
                    Lcms.showNotice('error', item, Lcms.languages.notices_msg.error);
                });
            });
        }
    } else {
        Lcms.showNotice('error', data.statusText, Lcms.languages.notices_msg.error);
    }
};

Lcms.countCharacter = function () {
    $.fn.charCounter = function (max, settings) {
        max = max || 100;
        settings = $.extend({
            container: '<span></span>',
            classname: 'charcounter',
            format: '(%1 ' + Lcms.languages.system.character_remain + ')',
            pulse: true,
            delay: 0
        }, settings);
        var p, timeout;

        function count(el, container) {
            el = $(el);
            if (el.val().length > max) {
                el.val(el.val().substring(0, max));
                if (settings.pulse && !p) {
                    pulse(container, true);
                }
            }
            if (settings.delay > 0) {
                if (timeout) {
                    window.clearTimeout(timeout);
                }
                timeout = window.setTimeout(function () {
                    container.html(settings.format.replace(/%1/, (max - el.val().length)));
                }, settings.delay);
            } else {
                container.html(settings.format.replace(/%1/, (max - el.val().length)));
            }
        }

        function pulse(el, again) {
            if (p) {
                window.clearTimeout(p);
                p = null;
            }
            el.animate({
                opacity: 0.1
            }, 100, function () {
                $(this).animate({
                    opacity: 1.0
                }, 100);
            });
            if (again) {
                p = window.setTimeout(function () {
                    pulse(el)
                }, 200);
            }
        }

        return this.each(function () {
            var container;
            if (!settings.container.match(/^<.+>$/)) {
                // use existing element to hold counter message
                container = $(settings.container);
            } else {
                // append element to hold counter message (clean up old element first)
                $(this).next("." + settings.classname).remove();
                container = $(settings.container)
                    .insertAfter(this)
                    .addClass(settings.classname);
            }
            $(this)
                .unbind('.charCounter')
                .bind('keydown.charCounter', function () {
                    count(this, container);
                })
                .bind('keypress.charCounter', function () {
                    count(this, container);
                })
                .bind('keyup.charCounter', function () {
                    count(this, container);
                })
                .bind('focus.charCounter', function () {
                    count(this, container);
                })
                .bind('mouseover.charCounter', function () {
                    count(this, container);
                })
                .bind('mouseout.charCounter', function () {
                    count(this, container);
                })
                .bind('paste.charCounter', function () {
                    var me = this;
                    setTimeout(function () {
                        count(me, container);
                    }, 10);
                });
            if (this.addEventListener) {
                this.addEventListener('input', function () {
                    count(this, container);
                }, false);
            }
            count(this, container);
        });
    };

    $(document).on('click', 'input[data-counter], textarea[data-counter]', function () {
        $(this).charCounter($(this).data('counter'), {
            container: '<small></small>'
        });
    });
};

Lcms.manageSidebar = function () {

    var body = $('body');
    var navigation = $('.navigation');
    var sidebar_content = $('.sidebar-content');

    navigation.find('li.active').parents('li').addClass('active');
    navigation.find('li').not('.active').has('ul').children('ul').addClass('hidden-ul');
    navigation.find('li').has('ul').children('a').parent('li').addClass('has-ul');


    $(document).on('click', '.sidebar-toggle', function (e) {
        e.preventDefault();

        body.toggleClass('sidebar-narrow');

        if (body.hasClass('sidebar-narrow')) {
            navigation.children('li').children('ul').css('display', '');

            sidebar_content.hide().delay().queue(function () {
                $(this).show().addClass('animated fadeIn').clearQueue();
            });
        } else {
            navigation.children('li').children('ul').css('display', 'none');
            navigation.children('li.active').children('ul').css('display', 'block');

            sidebar_content.hide().delay().queue(function () {
                $(this).show().addClass('animated fadeIn').clearQueue();
            });
        }
    });


    navigation.find('li').has('ul').children('a').on('click', function (e) {
        e.preventDefault();

        if (body.hasClass('sidebar-narrow')) {
            $(this).parent('li > ul li').not('.disabled').toggleClass('active').children('ul').slideToggle(250);
            $(this).parent('li > ul li').not('.disabled').siblings().removeClass('active').children('ul').slideUp(250);
        } else {
            $(this).parent('li').not('.disabled').toggleClass('active').children('ul').slideToggle(250);
            $(this).parent('li').not('.disabled').siblings().removeClass('active').children('ul').slideUp(250);
        }
    });

    $(document).on('click', '.offcanvas', function () {
        $('body').toggleClass('offcanvas-active').toggleClass('sidebar-narrow');
    });
};

Lcms.initDatepicker = function (element) {
    $(document).find(element).datepicker({
        format: 'yyyy-mm-dd',
        maxDate: 0,
        changeMonth: true,
        changeYear: true,
        autoclose: true,
    });
};

Lcms.initResources = function () {
    if (jQuery().select2) {
        $(document).find('.select-multiple').select2({
            width: '100%',
            allowClear: true,
            placeholder: $(this).data('placeholder')
        });
        $(document).find('.select-search-full').select2({
            width: '100%'
        });
        $(document).find('.select-full').select2({
            width: '100%',
            minimumResultsForSearch: -1
        });
    }

    if (jQuery().timepicker) {
        if (jQuery().timepicker) {

            $('.timepicker-default').timepicker({
                autoclose: true,
                showSeconds: true,
                minuteStep: 1,
                defaultTime: false
            });

            $('.timepicker-no-seconds').timepicker({
                autoclose: true,
                minuteStep: 5,
                defaultTime: false,
            });

            $('.timepicker-24').timepicker({
                autoclose: true,
                minuteStep: 5,
                showSeconds: false,
                showMeridian: false,
                defaultTime: false
            });
        }
    }

    if (jQuery().colorpicker) {
        $('.color-picker').colorpicker({});
    }

    this.initDatepicker('.datepicker');

    if (jQuery().fancybox) {
        $('.iframe-btn').fancybox({
            'width': '900px',
            'height': '700px',
            'type': 'iframe',
            'autoScale': false,
            openEffect: 'none',
            closeEffect: 'none',
            overlayShow: true,
            overlayOpacity: 0.7
        });
        $('.fancybox').fancybox({
            openEffect: 'none',
            closeEffect: 'none',
            overlayShow: true,
            overlayOpacity: 0.7,
            helpers: {
                media: {}
            }
        });
    }
    $('.tip').tooltip({placement: 'top'});

    if (jQuery().areYouSure) {
        $('form').areYouSure();
    }

    // Lcms.callScroll($('.list-item-checkbox'));
};

Lcms.callScroll = function (obj) {
    obj.mCustomScrollbar({
        axis: "yx",
        theme: "minimal-dark",
        scrollButtons: {
            enable: true
        },
        callbacks: {
            whileScrolling: function () {
                obj.find('.tableFloatingHeaderOriginal').css({
                    'top': -this.mcs.top + 'px'
                });
            }
        }
    });
    obj.stickyTableHeaders({scrollableArea: obj, "fixedOffset": 2});
};

Lcms.handleWaypoint = function () {
    if ($('#waypoint').length > 0) {
        new Waypoint({
            element: document.getElementById('waypoint'),
            handler: function(direction) {
                if (direction == 'down') {
                    $('.form-actions-fixed-top').removeClass('hidden');
                } else {
                    $('.form-actions-fixed-top').addClass('hidden');
                }
            }
        });
    }
};

Lcms.handlerMaskInput = function () {
    $('.us-phone-mask-input').mask('(000) 000-0000');
    $('.mask-number-mask-input-discount').mask('00 000');
}

// Handles counterup plugin wrapper
Lcms.handleCounterup = function () {
    if (!$().counterUp) {
        return;
    }

    $('[data-counter="counterup"]').counterUp({
        delay: 10,
        time: 1000
    });
};

Lcms.initMediaIntegrate = function () {
    if (jQuery().rvMedia) {
        $('[data-type="rv-media-standard-alone-button"]').rvMedia({
            multiple: false,
            onSelectFiles: function (files, $el) {
                $($el.data('target')).val(files[0].url);
            }
        });

        $('.btn_gallery').rvMedia({
            multiple: false,
            onSelectFiles: function (files, $el) {
                switch ($el.data('action')) {
                    case 'media-insert-ckeditor':
                        $.each(files, function (index, file) {
                            var link = file.url;
                            if (file.type === 'youtube') {
                                link = link.replace('watch?v=', 'embed/');
                                CKEDITOR.instances[$el.data('result')].insertHtml('<iframe width="420" height="315" src="' + link + '" frameborder="0" allowfullscreen></iframe>');
                            } else if (file.type === 'image') {
                                CKEDITOR.instances[$el.data('result')].insertHtml('<img src="' + link + '" alt="' + file.name + '" />');
                            } else {
                                CKEDITOR.instances[$el.data('result')].insertHtml('<a href="' + link + '">' + file.name + '</a>');
                            }
                        });

                        break;
                    case 'media-insert-tinymce':
                        $.each(files, function (index, file) {
                            var link = file.url;
                            var html = '';
                            if (file.type === 'youtube') {
                                link = link.replace('watch?v=', 'embed/');
                                html = '<iframe width="420" height="315" src="' + link + '" frameborder="0" allowfullscreen></iframe>';
                            } else if (file.type === 'image') {
                                html = '<img src="' + link + '" alt="' + file.name + '" />';
                            } else {
                                html = '<a href="' + link + '">' + file.name + '</a>';
                            }
                            tinymce.activeEditor.execCommand('mceInsertContent', false, html);
                        });
                        break;
                    case 'select-image':
                        var firstItem = _.first(files);
                        $el.closest('.image-box').find('.image-data').val(firstItem.url);
                        $el.closest('.image-box').find('.preview_image').attr('src', firstItem.thumb).show();
                        break;
                    case 'attachment':
                        var firstItem = _.first(files);
                        $el.closest('.attachment-wrapper').find('.attachment-id').val(firstItem.id);
                        $('.attachment-details').html('<a href="' + firstItem.url + '" target="_blank">' + firstItem.name + '</a>');
                        break;
                    case 'look-book-image':
                        var firstItem = _.first(files);
                        $el.closest('.image-look-book').find('.image-data').val(firstItem.url).trigger('change');
                        $el.closest('.image-look-book').find('.look-book-box-preview').addClass('look-book-box-tag');
                        $el.closest('.image-look-book').find('.preview_image').addClass('preview-look-book-image');
                        $el.closest('.image-look-book').find('.preview_image').attr('src', firstItem.url).show();
                        break;
                }
            }
        });

        $('.btn_remove_image').on('click', function (event) {
            event.preventDefault();
            $(this).closest('.image-box').find('img').hide();
            $(this).closest('.image-box').find('input').val('');
        });

        $('.btn_remove_look_book_image').on('click', function (event) {
            event.preventDefault();
            $(this).closest('.image-look-book').find('img').hide();
            $(this).closest('.image-look-book').find('input').val('').trigger('change');
            $(this).closest('.image-look-book').find('.preview_image').removeClass('preview-look-book-image');
            $(this).closest('.image-look-book').find('.look-book-box-preview').removeClass('look-book-box-tag');
            $(this).closest('.image-look-book').find('.tt-hotspot').remove();
        });

        // Gallery:
        $('.btn_select_gallery').rvMedia({
            onSelectFiles: function (files) {
                var result = $('#gallery-data');
                var images = [];
                var last_index = 0;
                if (result.val() !== '') {
                    images = $.parseJSON(result.val());
                    last_index = $('.list-photos-gallery .photo-gallery-item:last-child').data('id') + 1;
                }
                $.each(files, function (index, file) {
                    images.push(file.url);
                    $('.list-photos-gallery .row').append('<div class="col-md-2 col-sm-3 col-4 photo-gallery-item" data-id="' + (last_index + index) + '"><div class="gallery_image_wrapper"><img src="' + file.thumb + '" /></div></div>');
                });
                result.val(JSON.stringify(images));
                $('.reset-gallery').removeClass('hidden');
            }
        });

        var gallery_field = $('#gallery-data');
        var list_photo_gallery = $('.list-photos-gallery');
        var edit_gallery_modal = $('#edit-gallery-item');

        $('.reset-gallery').on('click', function (event) {
            event.preventDefault();
            $('.list-photos-gallery .photo-gallery-item').remove();
            gallery_field.val('');
            $(this).addClass('hidden');
        });

        list_photo_gallery.on('click', '.photo-gallery-item', function () {
            var id = $(this).data('id');
            $('#delete-gallery-item').data('id', id);
            $('#update-gallery-item').data('id', id);
            var images = $.parseJSON($('#gallery-data').val());
            if (images != null && typeof images[id] != 'undefined') {
                $('#gallery-item-description').val(images[id].description);
            }
            edit_gallery_modal.modal('show');
        });

        edit_gallery_modal.on('click', '#delete-gallery-item', function (event) {
            event.preventDefault();
            edit_gallery_modal.modal('hide');
            var id = $(this).data('id');
            var parent = list_photo_gallery.find('.photo-gallery-item[data-id=' + $(this).data('id') + ']');
            var images = $.parseJSON(gallery_field.val());
            var newListImages = [];
            $.each(images, function (index, el) {
                if (index != id) {
                    newListImages.push(el);
                }
            });
            gallery_field.val(JSON.stringify(newListImages));
            parent.remove();
            if (list_photo_gallery.find('.photo-gallery-item').length === 0) {
                $('.reset-gallery').addClass('hidden');
            }
        });

        edit_gallery_modal.on('click', '#update-gallery-item', function (event) {
            event.preventDefault();
            var id = $(this).data('id');
            var result = $('#gallery-data');
            edit_gallery_modal.modal('hide');
            var images = $.parseJSON(result.val());
            if (images != null && typeof images[id] != 'undefined') {
                images[id].description = $('#gallery-item-description').val();
            }
            result.val(JSON.stringify(images));

        });
    }
};

$(document).ready(function () {
    Lcms.countCharacter();
    // Lcms.manageSidebar();
    Lcms.initResources();
    // Lcms.handleWaypoint();
    Lcms.handleCounterup();
    Lcms.initMediaIntegrate();
    Lcms.handlerMaskInput();
});

window.Lcms = Lcms;