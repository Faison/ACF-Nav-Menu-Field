ACF-Nav-Menu-Field
==================

Add [Navigation Menus](http://codex.wordpress.org/Navigation_Menus) to [Advanced Custom Fields](http://wordpress.org/extend/plugins/advanced-custom-fields/) (ACF) with the Nav Menu Field plugin! This plugin adds the Nav Menu Field type to ACF (versions 5 & 4), allowing you to select from the menus you create in the WordPress Admin backend to use on your website's frontend.

Using ACF, you can set the Nav Menu Field to return the selected menu's:

*	ID for lightweight coding,
*	Object for more involved programming, or
*	HTML (generated from [wp_nav_menu](http://codex.wordpress.org/Function_Reference/wp_nav_menu)) for quickly displaying a menu.

I created this plugin because I needed to display a secondary menu that changed depending on what page you're on. Most of those pages were children of the same page, but then I had to throw a couple of Custom Post Types in there too. Because of the Custom Post Types, I couldn't just grab the top most parent for the current page and use [wp_list_pages](http://codex.wordpress.org/Function_Reference/wp_list_pages). So I did some research and decided to extend the functionality of my favourite plugin, [Advanced Custom Fields](http://wordpress.org/extend/plugins/advanced-custom-fields/). Now when I create a new Page or Custom Post, I just select the menu from a drop down menu!

Feel free to try this add-on on your dev site, ask questions on the support link above, and please review this add-on. By leaving a rating and review, you help this plugin become even better!

Also, Pull Requests are very much welcome :D