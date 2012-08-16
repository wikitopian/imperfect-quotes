=== Imperfect Quotes ===
Contributors: Brandon Ferens, Perfect Space Inc., Matt Parrott
Donate link: http://www.swarmstrategies.com/imperfect-quotes
Tags: Imperfect Quotes, imperfect, quote, quotes, widget, plugin, shortcode, testimonial, testimonials, random
Requires at least: 3.4.1
Tested up to: 3.4.1
Stable tag: 0.9.3
License: GPLv2
License URI: http://www.gnu.org/licenses/gpl-2.0.html

== Description ==

Use the intuitive and powerful rich text interface to add and edit quotes,
using the 'featured image' functionality to add a thumbnail image. Then, use
either the supplied widget, a simple shortcode, or a straightforward function
in your theme to add either a specific quote or a random quote to your site.

This plugin is a fork of Perfect Quotes. I forked it because it's an excellent
plugin. In some ways, it's more powerful and flexible than this one. I highly
recommend it if this plugin is too simple for you and you don't need either
the thumbnail feature or the rich text editing option.

= Features =

* Widget based to easily place your quotes where you like.
* A custom shortcode is included if you want to place your quotes within a post or a page.
* Based on Custom Post types with its own admin menu.

= Support languages =
* PHP
* CSS
* jQuery/javascript

== Installation ==

1. Upload plugin folder to the `/wp-content/plugins/` directory.
2. Activate the plugin through the "Plugins" menu in WordPress.
3. Go to the Imperfect Quotes menu and select Add new.
4. Type in the author.
5. Type in the quote.
6. Add a `Featured Image` to the post (don't actually insert the image, though!)

It will look something like this:

The trouble with quotes on the internet is that
it’s difficult to discern whether or not they are genuine.
- Abraham Lincoln [lincoln.jpg]

= Widget =

1. Include the widget by going to Appearance > Widgets.
2. Drag the Imperfect Quotes widget to the area of your choice.
3. Give your widget a custom title if you wish.

= Shortcode =

From any page or post, you can add shortcode to display all your quotes.

From the Imperfect Quotes home area, there is a column called Shortcode.
Find the particular quote you want and copy the corresponding shortcode.
It looks something like [imperfect_quotes id="1"].
Paste this into your post or onto a page and your quote will magically appear!
 
= For more help =

For more help please visit http://www.swarmstrategies.com/imperfect-quotes

== Frequently Asked Questions ==

= Does your plugin have a feature to randomly select quotes? =

Unless you specify the quote by its id, it'll be randomly selected.

= Why am I seeing two pictures of Abraham Lincoln on my page? =

That's because you're not only associating the quote with a featured image,
you're adding the image to the quote itself. If you click 'Use as Featured
Image' at the bottom of the image properties dialog, then 'X' out of the
dialog, you'll have a featured image without inserting it into the quote.

While this is a bit counter-intuitive, it gives you the power to insert images
and other rich content into quotes when you actually want to do that.

== Screenshots ==

1. How the quote appears on a website
2. Manage the quotes on the admin page
3. Add a thumbnail to your quote

== Changelog ==

= 0.9.1 =
* Forked! IMPerfect Quotes
* Rich text editor for the quote
* 'Featured Image' functionality for thumbnails of the author
* Removed 'Action Button'
* Simplified shortcode attributes
* Don't support showing multiple quotes
* Don't support metadata

= 0.3.3 =
* No more ugly custom field interface! A nice new look that makes entering your quotes much easier!
* A brand new editor window feature that allows you to select your quote(s) and insert the shortcode for you!

= 0.3.2 =
Renamed some functions to avoid conflict with other plugins

= 0.3.1 =
Added a new custom field for displaying where the author is from. It could be a book, or a company, or a... Really anything!

= 0.3 =
Added the ability to display random quotes or testimonials.

= 0.2 =
* Added much better shortcode implementation.
* Added the shortcode to the Custom Post overview page for easy integration into your post or page.

= 0.1 =
This is the initial release.

== Upgrade Notice ==

= 0.3.3 =
* Brand new interface so you don't have to manually enter the custom field codes any more.
* Brand new shortcode insertion popup, so all you have to do is select the quote and insert it directly into your editor window!

= 0.3.2 =
Renamed some functions to avoid conflict with other plugins.

= 0.3.1 =
This upgrade give you the ability to show where the author is from. Whether it is a company, book, location, whatever. Great for testimonials for a business site.

= 0.3 =
This update gives the ability to display random quotes if so desired.

= 0.2 =
The shortcode in this version fixes a rather large issue with the shortcode and also gives you the shortcode dynamically.

= 0.1 =
This is the initial release.
