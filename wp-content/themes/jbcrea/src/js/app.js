import $ from 'jquery';

/* Foundation JS imports here */
import './lib/foundation';

/* Babel polyfills to enable Promise support, etc. */
import "@babel/polyfill";

/* Main stylesheets, do not remove */
import "../scss/app.scss";
import "../admin/scss/admin.scss";

/* Your own modules go here */
import options from './lib/options';
import cookies from './lib/cookies';
import main from './lib/main';
import contact from './lib/contact';
import forms from "./lib/forms";

if (wp_data.options.ga_enabled || wp_data.options.cookies_banner_enabled){
    cookies.load();
}
options.load();
main.load();
forms.load();
contact.load();

$(document).foundation();