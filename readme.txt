=== jContact ===
Contributors: amitmalakar
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=ABY7RLME3DBZ6
Tags: contact form, email, templates, notification, approve, decline, ajax, javascript, status
Requires at least: 3.3
Tested up to: 3.5.1
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

This is Ajax based contact form plugin with user notification and admin interface to handle user requests.

== Description ==

This is Ajax based contact form plugin. This plugin has the following features:

a) A confirmation email will be sent to the user on contact form submission.
b) User details will be listed in plugin sub-menu (admin interface)
c) Admin can choose to approve or reject a user request and a confirmation mail will be sent to the user on each case.
d) Admin can delete a user recode from the database.
e) Email templates for initial contact, approval and rejection is easily customizable with legends (like user name, email, url, etc.) 

== Installation ==

1. Upload `plugin-name.php` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Use **shortcode** *[j-contact]*.

== Frequently asked questions ==

= Who will use this plugin? =
Anyone who need a contact form with email notification to admin. 

= How email notificaiton works? =
There are 3 types of notifications. First, when the user submits the contact form, an email is sent to the user and admin. Second, in case the admin approves user request, an email is sent to the user. Third, if the admin rejects the user request.

= Can I change the email message? =
Yes, you can change the email template from admin section. Where you'll have the option to change templates for first contact, approval and rejection of user request.


== Screenshots ==

1. jContact Admin panel - **user listings**. This is the list of users who submitted contact form.
2. jContact Admin panel - **email templates**. This is the section where you define the email templates.
3. jContact Contact form - **contact form** that will be submitted by the user, email notification will also be sent.

== Changelog ==

= 1.0 =


== Upgrade notice ==

= 1.0 =
