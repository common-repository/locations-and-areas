=== Locations and Areas - Leaflet Map with Region Tabs ===
Contributors: 100plugins, freemius
Tags: map, location, area, region, leaflet, gutenberg, marker, pins
Requires at least: 4.6
Tested up to: 6.2
Requires PHP: 5.6
Stable tag: 1.7.2
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl-3.0.html

An awesome map with features like: multiple regions as tabs, no API keys needed, frontend location adding, marker clustering & beautiful map and marker styles.

== Description ==

=== What does it do? ===
An awesome map with features like: multiple regions as tabs, no API keys needed, frontend location adding, marker clustering & beautiful map and marker styles. 

=== If you want to focus on letting your visitors add markers by themselves check out my other more popular plugin Open User Map. It's based on this plugin but has a lot more features.===
[Open User Map](https://wordpress.org/plugins/open-user-map/)


Look at the Demo and use-cases [here](https://www.locations-and-areas.com/). You can even add your own locations right away. Give it a try!

Showcase widely distributed locations on a single map with additional navigation tabs for regions. The map is based on [Leaflet JS](https://leafletjs.com/) and offers you several free map styles. So you do not need an API Key, Access Token or any other external registration. There are no API request limits. 

Adding locations is as simple as dropping a location marker on a map. You can search for addresses worldwide to quickly find the right spots. Use the Gutenberg Block to integrate your map or place the shortcode anywhere on your site. Close by locations will group together in clusters. This is optional.

**🎅✨ The PRO Version now has a free 7-day trial period. No credit card required!**

=== Let your visitors "fly" back and forth between widely distributed locations with the additional area navigation ===
Make use of Areas (Regions) to provide different focus points to your visitor.

https://youtu.be/GQsBmCvSXmU


=== Your visitors can add locations directly inside the map (frontend) [PRO Feature] ===
Just by clicking a "+"-Button a form will popup to let them enter location details the same comfortable way you do it in the backend. After submit the location proposal will be "pending" and wait for your review approval to get published.

https://www.youtube.com/watch?v=pwvMj0uLGxE

=== List of free Features: ===
- based on Leaflet
- no API Keys
- multiple map styles
- multiple marker styles
- locations with images
- Shortcode with optional attributes
- Gutenberg Block
- marker clustering

=== PRO Features 🚀🚀🚀: ===
- Frontend adding
- Admin approval for pending locations
- custom "Thank you"-message
- More beautiful map styles
- More marker icon styles
- Direct support from the developer
- Access all future PRO features
- Request for features


=== A possible use case: ===
You have offices in Europe, Asia and North America and don‘t want to include a whole world map or three separate maps for that. This plugin let‘s you set multiple focus areas within one map. Your visitors will switch (literally ”fly”) between your focus areas just by clicking the links on top of the map.

=== Another use case: ===
You have several stores in different cities. Your site visitors will be able to ”fly” between the cities to get an overview of the exact locations inside every city. You can set the zoom level for every area individually.

=== ...and another use case: ===
You want to build a map service where your visitors can add locations on their own. This could be a travel blog or a something like our [map with 500+ kite and windsurfing spots worldwide](https://surfspots.locations-and-areas.com).

**The possibilities are endless. We are very curious about what you are building with the help of our plugin. Please don't hesitate to let us know or ask for feature requests in the support forum. As this plugin is under permanenent development we are keen to know what are the features that you need? Contact us!

== Installation ==
From your WordPress dashboard

1. Visit Plugins > Add New
2. Search for “Locations and Areas”
3. Install and activate Locations and Areas from your Plugins page
4. Click on the new menu item “Locations” and create your first Location!
5. Use the Gutenberg Block "Locations and Areas Map" (category "Widgets") or just use the shortcode `[locations-and-areas-map]` to show the map on your site.

== Frequently Asked Questions ==
= Do I need an API Key or some external registration? =
No, the plugin is based on Leaflet.js and offers you free map styles that don’t need any kind of registration.

= How to integrate the map? =
Use the Gutenberg Block "Locations and Areas Map" or just place the shortcode `[locations-and-areas-map]` anywhere in your content or integrate it within your theme template with PHP:

`echo do_shortcode("[locations-and-areas-map]")`

you can also override the initial map focus with shortcode attributes:

`[locations-and-areas-map lat="51.50665732176545" long="-0.12752251529432854" zoom="13"]`

= Can I set the initial map position individualy? =
If you want to override the initial map focus (settings) just use the shortcode with attributes:

`[locations-and-areas-map lat="51.50665732176545" long="-0.12752251529432854" zoom="13"]`

= Do I need GPS coordinates? =
No. Add a new location or define an area view simply by droping a marker on the map. You can search for addresses as well. If you want to use GPS coordinates though, there is an option for that.

= Can I use Gutenberg? =
Yes! You will find the "Locations and Areas Map"-Block under widgets.

= Can I use vertical navigation for areas? =
Yes, go to plugin settings and choose from different layouts.

= Can I use marker clustering? =
Yes! This is enabled by default. You can disable it in the settings.

= Can I use custom styles? =
Yes, we encourage you to do so. This plugin is supposed to be developer friendly. Feel free to override the .locations-and-areas class in css to create your own awesome design.

= I want to submit a feature request. =
Please do so! You can use the support forum to let us know about your ideas helping to make this plugin better. 

== Screenshots ==
1. Let your visitors "fly" between multiple Areas to showcase your Locations on a single map.
2. Show detail information on location
3. Use Marker clustering for locations that are close to each other
4. New layout option: Vertical Areas navigation
5. Edit Screen for Locations
6. Edit Screen for Areas
7. Settings Screen
8. Integrate the map with Gutenberg Block Editor.
9. Or maybe try a dark map style?
10. Use-case: A map with 500+ kite and windsurfing spots worldwide
11. Add locations from the frontend (PRO Version)
12. Let your site visitors submit a location. You will approve it before it's published. (PRO Version)

== Changelog ==
= 1.7.2 =
* Freemius SDK Update

= 1.7.1 =
* Security Update

= 1.7.0 =
* better responsive styles for small screens
* better initial map position when adding another location
* better frontend form
* escaping single quotes from HTML input
* new feature: use shortcode attributes to set initial map focus
* code optimization

= 1.6.9 =
* Code optimization
* better style & wording for opt in screen

= 1.6.8 =
* Code optimization
* Style & Wording optimization

= 1.6.7 =
* Add "Getting started" notice

= 1.6.6 =
* Added 7-day trial to PRO version

= 1.6.5 =
* BUGFIX: JS compatibility error with Gravity Forms

= 1.6.4 =
* wording

= 1.6.3 =
* Major release of the PRO version
* Feature: more map styles and visual selector
* Feature: multiple marker icon styls and visual selector
* PRO Feature: Let your visitors add locations directly in the map. They will be public after your approval.
* PRO Feature: More custom map styles
* PRO Feature: More marker icon styles
* Basic code refactoring

= 1.5.6 =
* Feature: Add link to Google Maps for address (optional)

= 1.5.5 =
* Bugfix: Location CPT

= 1.5.4 =
* Optimize Marker cluster options

= 1.5.3 =
* Feature: Gesture handling for touch devices
* Feature: Marker Clustering (optional)
* New default marker icon
* Replace additional Stadia maps with "CartoDB.DarkMatter" map

= 1.5.2 =
* Bugfix: JS error in Gutenberg Editor

= 1.5.1 =
* Style optimization
* Renaming Plugin to "Locations and Areas"

= 1.5.0 =
* FEATURE: use a map to add locations and areas visually (GPS coordinates as an option)
* Post type optimization
* Code structure optimized

= 1.4.6 =
* Cache Busting
* Fixing issue with page speed optimization plugins
* code optimization

= 1.4.5 =
* Bugfix Image Preview

= 1.4.4 =
* Bugfix Media Uploader

= 1.4.3 =
* FEATURE: Image upload for locations
* Better styled location popup
* Show address (optional)
* Bugfix: Initial Map Focus

= 1.4.2 =
* WordPress 5.8 compatibility
* Add default map style
* FEATURE: unlock three additional map styles hint
* wording

= 1.4.1 =
* FEATURE: Give us a little feedback and unlock three new map styles.
* FEATURE: Preview map styles on settings page.
* fixing translation bug with Gutenberg Block
* code optimization

= 1.4.0 =
* FEATURE: use the new Gutenberg Block to include the map
* code optimization

= 1.3.0 =
* ensure PHP 5.6 compatibility

= 1.2.1 =
* wording correction

= 1.2.0 =
* FEATURE: vertical areas navigation is now available (new setting "Layout")
* fully switching to public translation from translate.wordpress.org
* code optimization

= 1.1.0 =
* prevent map zoom by scrolling the page
* code optimization
* ensure compatibility for current WordPress version 

= 1.0.3 =
* BUGFIX: map not loading when using inline js caching 3rd party caching plugins
* BUGFIX: missing coordinates for areas

= 1.0.2 =
* changes in readme, title, icon, description

= 1.0.1 =
* changes in readme and description

= 1.0 =
* manage locations as CPT
* manage areas as taxonomy
* choose map style
* areas are optional
* provide shortcode