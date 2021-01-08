<p align="center"><a href="https://mwbemes.com/"><img src="https://docs.mwbemes.com/wp-content/uploads/2018/02/logo-1.png" alt="mwbemes.com"></a></p>

<p align="center">
<img src="https://img.shields.io/github/v/release/mwbemes/mwb-woocommerce-wishlist?label=stable" alt="Latest release">
<img src="https://img.shields.io/github/license/mwbemes/mwb-woocommerce-wishlist" alt="License">
<img src="https://img.shields.io/github/last-commit/mwbemes/mwb-woocommerce-wishlist" alt="Last commit">
<img src="https://img.shields.io/github/languages/code-size/mwbemes/mwb-woocommerce-wishlist" alt="Code size">
</p>

Welcome to the mwb WooCommerce Wishlist repository on GitHub. Here you can browse the source, look at open issues and keep track of the development.

If you are not a developer, please, use the [mwb WooCommerce Wishlist plugin page](https://wordpress.org/plugins/mwb-woocommerce-wishlist/) on WordPress.org.

## About plugin

The wishlist is one of the most powerful and popular tools in an ecommerce shop. Thanks to the wishlist, users can:

* Save their favourite products, find them quickly and easily at a later time and buy them.
* Share the wishlist with relatives and friends for Christmas, birthdays and similar occasions so they can buy them one of the products from the list.
* Share the wishlist on social networks and get indirect advertising for your store.

This means that you’ll be able to loyalise customers, push them to buy and attract new customers any time a wishlist is shared. Not bad for one plugin only, don’t you think?

Our mwb WooCommerce Wishlist has more than **800,000 active installations** and that’s why it’s **the most popular wishlist plugin ever.**

To celebrate this record and say thanks to all the plugin users, we’ve decided to release a new 3.0 version that has improved the design tremendously  and added many new options.

**If you like the new design, please, [leave a review](https://wordpress.org/support/plugin/mwb-woocommerce-wishlist/reviews/#new-post) to help the plugin grow!**

[Free version live demo >](https://plugins.mwbemes.com/mwb-woocommerce-wishlist-free/)
[Documentation >](https://docs.mwbemes.com/mwb-woocommerce-wishlist)

### Basic features

* Select a page for your wishlist
* Select where to show the shortcode ‘Add to wishlist’
* Show the ‘Remove from wishlist’ button when the product is in the Wishlist
* Show the ‘Add to wishlist’ button also on the Shop page
* Customise columns that will be displayed in the wishlist table
* Product variation support (if the user selects a specific color or size and then adds it to the wishlist, this details will be saved)

### Premium features

[Premium version live demo >](https://plugins.mwbemes.com/mwb-woocommerce-wishlist/)

The free version of our plugin works like a charm, but the premium one is an even more powerful tool to increase sales and conversions. By upgrading to the premium version, you can:

* View the wishlists created by logged-in customers
* View a list of popular products (added to wishlists)
* Send promotionals email to users who have added a specific product to their wishlist
* Show the ‘Ask for an estimate’ button to let customers send the content of their wishlist to the admin and get a quotation
* Add optional notes to the quote request
* Enable/disable the wishlist features for unlogged users
* Show a notice to unlogged users: invite them to log in to benefit from all the wishlist functionalities
* Allow users to create as many wishlists as they want
* Allow users to manage wishlists, rename and delete them, add or remove items
* Allow users to search and see registered wishlists
* Allow users to set visibility options for each wishlist, by making them either public (visible to everyone), private (visible to the owner only) or shared (visible only to people it has been shared with)
* Allow users to manage the item quantity in the wishlist
* Show multiple ‘Add to Cart’ buttons in the wishlist table
* Show product price variations (Amazon style)
* Allow users to move an element from one wishlist to another, right from the wishlist table
* Allow users to drag and drop products to arrange their order in the wishlist
* Choose modern & beautiful layouts for the wishlist page and tables
* Provide your customers with nice widgets to help them find their wishlist quickly and easily.

[GET THE PREMIUM VERSION HERE with a 100% Money Back guarantee >](https://mwbemes.com/themes/plugins/mwb-woocommerce-wishlist/)

## Getting started

* [Installation Guide](#quick-guide)
* [Languages](#available-languages)
* [Documentation](#documentation)
* [FAQ](#faq)
* [Changelog](#changelog)
* [Support](#support)
* [Reporting Security Issue](#reporting-security-issues)

## Installation guide

Clone the plugin directly into `wp-content/plugins/` directory of your WordPress site.

Otherwise, you can 

1. Download the repository .zip file.
2. Unzip the downloaded package.
3. Upload the plugin folder into the `wp-content/plugins/` directory of your WordPress site.

Finally, you'll need to activate `mwb WooCommerce Wishlist` from Plugins page.

## Available Languages

* Chinese - CHINA
* Chinese - TAIWAN
* Croatian - CROATIA
* Danish - DENMARK
* Dutch - NETHERLANDS
* English - UNITED KINGDOM (Default)
* French - FRANCE
* German - GERMANY
* Hebrew - ISRAEL
* Italian - ITALY
* Korean - KOREA
* Persian - IRAN, ISLAMIC REPUBLIC OF
* Polish - POLAND
* Portuguese - BRAZIL
* Portuguese - PORTUGAL
* Russian - RUSSIAN FEDERATION
* Spanish - ARGENTINA
* Spanish - SPAIN
* Spanish - MEXICO
* Swedish - SWEDEN
* Turkish - TURKEY
* Ukrainian - UKRAINE

## Documentation

You can find the official documentation of the plugin [here](https://docs.mwbemes.com/mwb-woocommerce-wishlist/)

We're also working hard to release a developer guide; please, follow our [social channels](http://twitter.com/mwbemes) to be informed about any update.

## FAQ

**Does mwb WooCommerce Wishlist allows adding an “add to wishlist” button on the products on shop page and archive pages?**

Yes, from version 3.0 the plugin also allows showing the Add to wishlist button on your **shop page, category pages, product shortcodes, product sliders,** and all the other places where the WooCommerce products’ loop is used.

**Can I customize the wishlist page?**

Yes, the page is a simple template and you can override it by putting the file template "wishlist.php" inside the "woocommerce" folder of the theme folder.

**Can I move the position of "Add to wishlist" button?**

Yes, you can move the button to another default position or you can also use the shortcode inside your theme code.

**Can I change the style of "Add to wishlist" button?**

Yes, you can change the colors of background, text and border or apply a custom css. You can also use a link or a button for the "Add to wishlist" feature.

**Wishlist page returns a 404 error?**

Try to regenerate permalinks from Settings -> Permalinks by simply saving them again.

**Have you encountered anomalies after plugin update, that did not exist in the previous version?**

This might depend on the fact that your theme overrides plugin templates. Check if the developer of your theme has released a compatibility update with version 3.0 or later of mwb WooCommerce Wishlist. As an alternative you can try the plugin in WordPress default theme to leave out any possible influences by the theme.

**I am currently using Wishlist plugin with Catalog Mode enabled in my site. Prices for products should disappear, yet they still appear in the wishlist page. Can I remove them?**

Yes, of course you can. To avoid Wishlist page to show product prices, you can hide price column from wishlist table. Go to mwb -> Wishlist -> Wishlist Page Options and disable option "Product price".

## Changelog

### 3.0.15 - Released on 16 October 2020

* New: support for WooCommerce 4.6
* Update: plugin framework
* Tweak: return product price as float in item class
* Fix: prevent possible fatal error when printing ATW button
* Fix: original price being sent to database as int instead of float
* Dev: added new filter mwb_wcwl_set_session_cookie
* Dev: added new filter mwb_wcwl_privacy_value
* Dev: added new parameter to mwb_wcwl_{privacy}_wishlist_visibility filter

## Support

This repository should be considered as a development tool.
Please, post any support request about this plugin on [wp.org support forum](https://wordpress.org/support/plugin/mwb-woocommerce-wishlist/)

If you have purchased the premium version and need support, please, refer to our [support desk](https://mwbemes.com/my-account/support/dashboard/)

## Reporting Security Issues
To disclose a security issue to our team, please, contact us from our [contact form](https://mwbemes.com/contact-form/).