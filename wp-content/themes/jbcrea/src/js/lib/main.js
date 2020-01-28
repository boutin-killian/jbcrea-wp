import $ from 'jquery';
import LazyLoad from 'vanilla-lazyload';
import polyfill from "./polyfill";

let main = {

    load() {

        console.log("Made with ❤ by JBCrea.");

        $(document).ready(function () {

            $(".wpcf7-validates-as-required").after("<div class='alert'></div>");

            // // STYLE SELECT
            // $('select').niceSelect();
            //
            // // DATE FIELD IN FORMS
            // $('.datepicker-here').datepicker({
            //     language: 'fr',
            //     autoClose: true,
            // });

            // Shrinking Title Bar
            $(window).on('scroll resize load', function () {
                if ($(this).scrollTop() > $('.title-bar').outerHeight()) {
                    $('.title-bar').addClass('shrink');
                } else {
                    $('.title-bar').removeClass('shrink');
                }
            });

            $('#nav-main .menu-item-has-children').find('> a').click(function (e) {
                e.preventDefault();
            });

            $('.cssmenu li.menu-item-has-children > a').on('click', function () {
                $(this).removeAttr('href');
                var element = $(this).parent('li');
                if (element.hasClass('open')) {
                    element.removeClass('open');
                    element.find('li').removeClass('open');
                    element.find('ul').slideUp();
                }
                else {
                    element.addClass('open');
                    element.children('ul').slideDown();
                    element.siblings('li').children('ul').slideUp();
                    element.siblings('li').removeClass('open');
                    element.siblings('li').find('li').removeClass('open');
                    element.siblings('li').find('ul').slideUp();
                }
            });

            $('.cssmenu>li.menu-item-has-children>a').append('<span class="holder"></span>');

            // MENU OPEN & CLOSE
            $('.burger').click(function () {
                $(this).toggleClass('opens');
            });

            $('.js-off-canvas-overlay').click(function () {
                $('.burger').toggleClass('opens');
                $('.menu-item > a').toggleClass('opens');
            });

            main.loaded();
        });

    },

    loaded() {

        // Load all necessary polyfill
        polyfill.load();

        // Page Popups
        let $popup = $('#popup');
        $(document).on('click', '.open-popup', function (e) {

            e.preventDefault();
            e.stopPropagation();

            $.ajax({
                method: "POST",
                url: wp_data.ajax_url,
                data: {
                    method: "POST",
                    action: 'post_content',
                    ID: $(this).data('post-id'),
                    security: wp_data.security
                }
            })
                .done(function (response) {
                    $popup.find('.popup-content').html(response);
                    $popup.foundation('open');
                })
                .fail(function () {
                    console.error("Error getting post content");
                });
        });

        // Lazy Loading des images
        if ($('.lazy').length) {
            new LazyLoad();
        }

    },
};

export default main;
