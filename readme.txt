=== Social Links Icons ===
Tags: social, social networks, color, icons, svg, social profiles, media, custom social icons, social links icons, social link icons, social link icon
Donate link:
Contributors: dimbouteille
Requires at least: 4.2
Tested up to: 5.2.1
Requires PHP: 7.2
License: GPLv3
Stable tag: 1.0
License URI: https://www.gnu.org/licenses/gpl-3.0.html

Simply customize and manage links and icons to more than 25 social networks and add your own social networks!

== Description ==
Social Links Icons allows you to simply group and manage links to your social networks and display them on your pages.

Currently the plugin manages more than 20 social networks such as Facebook, Twitter, Youtube, Instagram, Twitch, Github, LinkedIn, ... If you wish, you can also add your own social networks!

In addition, the plugin also allows you to configure the icons and colors of each social network.

== Installation ==
1. Upload the entire social-links-icons folder to the /wp-content/plugins/ directory
2. Activate the plugin through the "Plugins" menu in WordPress
3. Configure the links and icons in the "Setting" tab.

== Frequently Asked Questions ==
= Which social networks are supported by default ?

* Behance
* Blogger
* Discord
* Dribbble
* Facebook
* Flickr
* Github
* Google Play
* Instagram
* Linkedin
* Medium
* Pinterest
* Reddit
* Skype
* Slack
* Snapchat
* Soundcloud
* Stackoverflow
* Steam
* Telegram
* Tumblr
* Twitch
* Twitter
* Vimeo
* WhatsApp
* Youtube

= Where to find Svg icons ?

You can find icons on one of the following sites: [https://iconmonstr.com/](https://iconmonstr.com/), [https://www.flaticon.com/](https://www.flaticon.com/), [https://icones8.fr/icons](https://www.flaticon.com/), [https://icomoon.io/app/#/select](https://icomoon.io/app/#/select).

= How to view social networks on a page?

To view the list of social networks, you can use the following shortcode:

`

// To display the list of with the name of the social network
[sli-list]

or

// To display the list of with the social network icon
[sli-list content="svg"]
`
If you want to change the HTML code generated: [see documentation](https://github.com/dimitriBouteille/social-links-icons)

= How to display social networks in a template?

`
global $socialLinksIcons;
$networks = $socialLinksIcons->all();
foreach($networks as $network) {
    // Do something
}
`

= How to add a social network ?

You can simply add social networks, please read the document: [see documentation](https://github.com/dimitriBouteille/social-links-icons)

== Screenshots ==

1. Default plugin interface

== Changelog ==
= 1.0 =

First release