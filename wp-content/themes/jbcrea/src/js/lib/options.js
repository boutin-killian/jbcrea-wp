import $ from 'jquery';
import SmoothScroll from 'smooth-scroll';

let options = {

    load(){

        // SMOOTH SCROLL
        if (wp_data.options.smooth_scroll_enabled){

            let scrollOptions  = {
                speed: 1000,
                easing: 'easeOutCubic',
                offset: $(window).width() > 640 ? 60 : 0, // Offset to header height on medium screens
            };

            let scroll = new SmoothScroll('a.scrollto, a.scrolltop, #nav-main a', scrollOptions);

            // Auto scroll to section on page load
            $(document).ready(function(){
                if ( window.location.hash ) {

                    let anchor = $( window.location.hash);

                    if (anchor.length > 0){
                        scroll.animateScroll( $( window.location.hash)[0], null, scrollOptions );
                    }
                }
            });

            // SCROLL TOP
            if (wp_data.options.scroll_top_enabled){

                let offset = 300,
                    offset_opacity = 1200,
                    scroll_top_duration = 700,
                    $back_to_top = $('.scrolltop');

                $(window).scroll(function () {
                    ( $(this).scrollTop() > offset ) ? $back_to_top.addClass('is-visible') : $back_to_top.removeClass('is-visible fade-out');
                    if ($(this).scrollTop() > offset_opacity) {
                        $back_to_top.addClass('fade-out');
                    }
                });

                if (!wp_data.options.smooth_scroll_enabled){
                    $back_to_top.on('click', function (event) {
                        event.preventDefault();
                        scroll.animateScroll( 0 , null, scrollOptions );
                    });
                }
            }
        }

    },
};

export default options;