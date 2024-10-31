=== Service Status ===
Author: Mediaburst Ltd <hello@mediaburst.co.uk>
Website: http://www.mediaburst.co.uk/wordpress/service-status/
Contributors: mediaburst, martinsteel
Tags: status, server, service
Requires at least: 3.0.0
Tested up to: 3.3.1
Stable tag: 1.2

Add a service status page to your WordPress powered website.

== Description ==

Add a new status page to keep your customers up to date with your current service status

Adds a custom post type and admin pages to manage your status updates.

All you need to do is log in to wordpress admin and it's as simple as adding a
post.

To see what this plugin can do have a look at [our status page](http://www.mediaburst.co.uk/status/ "Mediaburst service status page").

If you have any questions or feedback drop us an email at hello@mediaburst.co.uk.

== Installation ==

1. Upload the 'service-status' directory to the '/wp-content/plugins/' directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Login to Wordpress Admin and setup your statuses (Under Options)
4. Add some status updates.

== Frequently Asked Questions ==

= Can I use a custom page template for my status updates? =

Simply create an archive-service-status.php and single-service-status.php file in your theme.
They use the standard Wordpress loop so copying archive.php and single.php is a good
place to start.

= How do I set the possible status values? =

Once the plugin is activated you should see a Service Status entry under the Wordpress 
Settings menu.  On this page you can add as many statuses as you need.

= Can I change the custom post type name? =

Yes.  You need to change $post_type variable in the Site_Status_Options class.
You'll also need to rename any theme files to archive-<NEW-TYPE>.php and single-<NEW-TYPE>.php

= Can I include the current status in a blog post or page? =

Yes.  There are two shortcodes in can include in either a blog post or within
page content, these will be replaced when somebody views the page. 
1. [service-status-name] Name of the current status.
2. [service-status-desc] Full text description of the current status.

= Can I include the current status in my theme? =

Yes. There are two functions you can call to get the status and the status
description.

1. Status
`<?php
if(class_exists('Service_Status')) {
	echo Service_Status::current_status();
} ?>`
2. Status Description
`<?php
if(class_exists('Service_Status')) {
        echo Service_Status::current_status_description();
} ?>`


== Screenshots ==

1. Service Status admin page

2. Add/Edit a status update

2. Options page where you add/edit/remove statuses

== Themeing ==

If you want to display your status updates with custom styling simply create
two new pages in your theme.

= archive-service-status.php =

Display a list of your status updates, just like the standard post archive.
Use all the normal WordPress functions such as the_title() and the_excerpt()
within the loop.

= single-service-status.php =

Show a single service status update, just like the standard single post page.
Again uses the standard WordPress functions.

If you've made use of the Products feature, to tag each update with the
affected products, call get_the_terms() like this:

`<?php 
get_the_terms( $post->ID, 'products' ); 
foreach ( $terms as $term ) {
	printf( '<li>%s</li>', $term->name );
}
?>`

== Changelog ==

= 1.2 = 
* Removed the custom rewrite rules as these broke rewrites for other custom
  post types.  This means permalinks change from /status/post-id to
  /status/post-title.   Thanks to Steve Ogg for the bug report.

= 1.1 =
* Added support for comments on status updates, new option under settings
* Tidied up code in to separate class files

= 1.0 = 
* Public release

= 0.1 = 
* Internal development release

== Upgrade Notice ==

= 1.2 =
* The rewrite rules used in previous versions broke other custom post types.
  This version changes the permalink structure from /status/id to /status/title 
  to fix the problem. Sorry about the change but I don't want to break other plugins.
  

