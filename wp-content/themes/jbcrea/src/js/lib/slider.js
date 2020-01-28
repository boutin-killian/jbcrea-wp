import $ from 'jquery';
import Swiper from 'swiper/js/swiper';

(function( $ ) {

    class SlideShow {

        constructor(element, options) {
            this.element = element;
            this.options = options;
            this.init();
        }

        init(){
            const that = this;

            this.swiper = new Swiper(this.element, {
                ...this.options,

                speed: 1000,
                grabCursor: true,
                watchSlidesProgress: true,
                watchSlidesVisibility: true,

                on: {
                    progress: function() {
                        if (typeof(that.options.customAnimation) === 'undefined' || !that.options.customAnimation)
                            return;

                        let swiper = this;
                        for (let i = 0; i < swiper.slides.length; i++) {

                            let slideProgress = swiper.slides[i].progress;
                            let innerOffset = swiper.width * 0.5;
                            let innerTranslate = slideProgress * innerOffset;
                            swiper.slides[i].querySelector(".slide-inner").style.transform = "translate3d(" + innerTranslate + "px, 0px, 0px)";
                        }
                    },
                    touchStart: function() {
                        if (typeof(that.options.customAnimation) === 'undefined' || !that.options.customAnimation)
                            return;

                        let swiper = this;
                        for (let i = 0; i < swiper.slides.length; i++) {
                            swiper.slides[i].style.transition = "";
                        }
                    },
                    setTransition: function(speed) {
                        if (typeof(that.options.customAnimation) === 'undefined' || !that.options.customAnimation)
                            return;

                        let swiper = this;
                        for (let i = 0; i < swiper.slides.length; i++) {
                            swiper.slides[i].style.transition = speed + "ms";
                            swiper.slides[i].querySelector(".slide-inner").style.transition =
                                speed + "ms";
                        }
                    }
                }

            });
        }
    }

    $.fn.slideShow = function( options ) {

        let settings = $.extend({
            grabCursor: true,
            keyboard: true,
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev"
            },
            pagination: {
                el: '.swiper-pagination',
                type: 'bullets',
            },
            customAnimation: true,
            autoplay: {
                delay: 5000,
            },
        }, options );

        return this.each(function()
        {
            return new SlideShow($(this), settings);
        });

    };

}( jQuery ));