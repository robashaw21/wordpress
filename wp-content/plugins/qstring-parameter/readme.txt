=== qstring-parameter ===
Contributors: sakush100 
Tags: get, url, query, string, address
Requires at least: 3.0
Tested up to: 3.6
Stable tag: trunk

Qstring is a plugin to allow to access get parameters from query string or URL easily

== Description ==

Sometimes wordpress developers need to pass values through PHP’s GET method. For example, you need to pass your name to another page by GET method like

http://yoursite.com/some-page/?myname=john&age=23

Now you need to retrieve myname and age variables, but wordpress is designed to ignore such things in URL. You get surprised when you don’t seen anything  with<pre>&lt;?php print_r($_GET); ?&gt;</pre> 

Hence, i decided to make a simple plugin that does this functionality. Qstring is a plugin to allow to access get parameters from query string or URL easily.

== Installation ==

Extract the zip file and just drop the contents in the wp-content/plugins/ directory of your WordPress installation and then activate the Plugin from Plugins page.
== Frequently Asked Questions ==

### Usage Examples<pre>&lt;?php<br />
// IMPORT GET PARAMETERS IN ARRAY FORMAT<br />
$myvar = load_qstrings();<br />
<br />
// USING PARAMETER WHEREVER NEEDED<br />
echo $myvar[&#39;user_id&#39;];<br />
<br />
// TO DEBUG, USE PRINT_R<br />
print_r($myvar);<br />
?&gt;</pre> 

 

### Limitations

There are some reserved keywords in wordpress like “name”. These should not be used otherwise wordpress shows “The page you requested could not be found.” OR something similar depending on your theme.

 
== Changelog ==
none, initial version