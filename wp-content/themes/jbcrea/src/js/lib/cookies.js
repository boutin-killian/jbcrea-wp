import $ from 'jquery';
import 'cookieconsent/build/cookieconsent.min.js';
import Cookies from 'js-cookie';
import main from "./main";

let cookies = {

    load() {

        let ccPopup;
        $(window).on('load', function () {

            if (wp_data.options.cookies_banner_enabled){
                window.cookieconsent.initialise({
                    palette: {
                        "popup": {
                            "background": (wp_data.options.cookies_banner_bgcolor !== null ? wp_data.options.cookies_banner_bgcolor : '#11a09a')
                        },
                        "button": {
                            "background": (wp_data.options.cookies_banner_button_color !== null ? wp_data.options.cookies_banner_button_color : '#FFF')
                        }
                    },
                    type: "opt-in",
                    content: {
                        message: "En poursuivant votre navigation sur ce site, vous acceptez l’utilisation de cookies nous permettant de réaliser des statistiques et ainsi d'améliorer notre qualité de services",
                        dismiss: "Refuser",
                        allow: "J'accepte",
                        deny: "Refuser",
                        link: "En savoir plus",
                        href: wp_data.options.privacy_policy_url,
                        policy: 'Cookies',
                    },
                    revokeBtn: '<div style="display: none;"></div>',
                    autoAttach: false,

                    onInitialise: function (status) {
                        let type = this.options.type;
                        let didConsent = this.hasConsented();
                        if (type === 'opt-in' && didConsent && wp_data.options.ga_id !== '') {
                            enableCookies();
                        }
                    },

                    onStatusChange: function (status, chosenBefore) {
                        let type = this.options.type;
                        let didConsent = this.hasConsented();
                        if (type === 'opt-in' && didConsent && wp_data.options.ga_id !== '') {
                            enableCookies();
                        } else {
                            disableCookies();
                        }
                    },

                    onPopupOpen: function(){
                        // Cookie policy in a popup if onepage enabled
                        if (wp_data.options.is_one_page && wp_data.options.privacy_policy_id){
                            setTimeout(function(){
                                $(".cc-message .cc-link").addClass('open-popup').attr('data-post-id', wp_data.options.privacy_policy_id).attr('data-open', 'popup').attr('target', '');
                                main.loaded();
                            }, 1000);
                        }
                    },

                    onRevokeChoice: function () {
                        disableCookies();
                    },
                }, function (popup) {
                    ccPopup = popup;
                });
                document.body.appendChild(ccPopup.element);
            }else if (wp_data.options.ga_enabled){
                enableCookies();
            }

        });

        function enableCookies() {

            if ( wp_data.options.ga_id !== '' ){
                window.dataLayer = window.dataLayer || [];

                function gtag() {
                    dataLayer.push(arguments);
                }

                gtag('js', new Date());
                gtag('config', wp_data.options.ga_id, { 'anonymize_ip': true });
            }
        }

        function disableCookies() {

            if (wp_data.options.ga_id !== '') {

                let tag_id = wp_data.options.ga_id.replace(new RegExp('-', 'g'), '_');

                Cookies.remove('_ga', {path: '/', domain: wp_data.options.ga_domain});
                Cookies.remove('_gat_gtag_' + tag_id, {path: '/', domain: wp_data.options.ga_domain});
                Cookies.remove('_gid', {path: '/', domain: wp_data.options.ga_domain});
            }
        }

        $(document).ready(function () {

            // Cookies Consent popup
            $('.cookies-consent *').on('click', function (e) {
                e.preventDefault();
                ccPopup.open();
                return false;
            });

        });
    }
};

export default cookies;