# RD_00000011_Starter_Theme_WP

## Requirement

PHP 7.1

For a full PHP 5.6 compatibility, you can downgrade Twig to v1.

## Install

`composer install`

`npm install`

## Use

`npm run watch` : watches for changes in js and scss files

`npm run prod` : compile assets for production & update theme version

### Settings

#### Theme

Theme settings can be set in `inc/JBCrea/GKSite.php` : 

* Theme support (post formats, etc.)
* Onepage support activated or not

It's important to change the *SECURITY_KEY* constant for each project, as it is used for WordPress nonces.

##### Templates

Page templates like `template-page-xxx.php` should have their twig counterpart in `templates/pages/template-page-xxx.twig`.

It's mandatory when one page mode is enabled. 

##### Flexible content blocks (Gutenberg)

Blocks are registered as components based on whats selected in "Options technique > Blocs Gutenberg" on admin.

Each block has its own Javascript, Sass file and Twig template. 

In addition, it also have a class file for adding its own ACF fields.

If Gutenberg blocks are not shown on admin side, be sure to update "Options techniques" to save selection of "Blocs Gutenberg".

To register a block just add another folder in /themes/{theme-name}/blocks with his 4 files (PHP, twig, scss and JS) and check this newly created block in "Options technique > Blocs Gutenberg" on admin.

##### One page

One page settings can be set directly from WP Admin panel.

In One page mode, a page content can be open in a popup by adding the `open-popup` class on a link to this page.

Les champs ACF sont stockés dans le context avec la variable "data". Voir GKPageSection pour plus de précision sur son fonctionnement.

##### Maintenance mode

To enable maintenance mode, navigate to options pages of wordpress admin, tab "Mode maintenance" and click on button to activate.

It's possible to choose end date of maintenance mode. 

Template to override to stylize maintenance mode page is "/templates/maintenance.twig" in main theme

##### Cookie Consent

Cookie consent is already set when Google Analytics is enabled in the site options. 

To display the cookie banner on-demand, just add the `cookies-consent` class on a link.

#### Hot reload

Browsersync is proxying http://127.0.0.1:8090 by default.

This can be changed in webpack.config.js

### Custom Twig functions and filter

#### Functions

`post_link( $slug, $type = 'page', $lang = null )` 

Return the link for the page with slug = $slug.
If using polylang, $lang can also be set.

`gk_image($path, $alt = "", $class = "", $responsive = true, $sizes = "100vw", $background = false)` 

Return a lazy loaded image
    
  - $path : path or uri to the image
  - $alt : Replacement text
  - $classes : Additional classes
  - $responsive : Will generate different sizes of the image automatically (in the theme cache/ directory)
  - $sizes : sets the size of the loaded image in the viewport
  - $background : Image will be loaded as a background image

#### Filters

`image|watermark($watermark_image=null, $position='bottom right', $force=false)`

Automatically add a watermark on an image
    
  - $watermark_image : Optionnal. Path to the watermark image (relative to the theme directory). Defaults to 'static/images/watermark.png')
  - $position : Optionnal. Position for the watermark ('center center', bottom right', 'top left', ...)
  - $force : Optionnal. Will overwrite the previously generated image.

