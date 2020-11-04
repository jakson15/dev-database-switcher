=== Plugin Name ===
Contributors: (this should be a list of wordpress.org userid's)
Donate link: https://github.com/jakson15
Tags: comments, spam
Requires at least: 3.0.1
Tested up to: 3.4
Stable tag: 4.3
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Simple plugin to switch between local and remote database by one click.
Working without logging in every time we change database works only on localhost because of security reasons.

== Description ==

Create wp-config-remote.php file with remote database access and switch between them from admin bar.

To each wp-config you have add constant LOGIN_USERNAME and put there username or e-mail you want to login after database switch.
`define('LOGIN_USERNAME', 'username');`

