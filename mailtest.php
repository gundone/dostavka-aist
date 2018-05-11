<?php
/**
 * This file can be used to validate that the WordPress wp_mail() function is working.
 * To use, change the email address in $to below, save, and upload to your WP root.
 * Then browse to the file in your browser.
 * 
 * For full discussion and instructions, see the associated post here:
 * http://b.utler.co/9L
 * 
 * Author:      Chad Butler
 * Author URI:  http://butlerblog.com/
 */
/*  
	Copyright (c) 2012-2015  Chad Butler
	
	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License, version 2, as
	published by the Free Software Foundation.
	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.
	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
	You may also view the license here:
	http://www.gnu.org/licenses/gpl.html
*/
 
// Set $to as the email you want to send the test to.
$to = "";
 
// No need to make changes below this line.
 
// Email subject and body text.
$subject = 'wp_mail function test';
$message = 'This is a test of the wp_mail function: wp_mail is working';
$headers = '';
 
// Load WP components, no themes.
define('WP_USE_THEMES', false);
require($_SERVER['DOCUMENT_ROOT'].'/wp-load.php');
 
// send test message using wp_mail function.
$sent_message = wp_mail( $to, $subject, $message, $headers );
//display message based on the result.
if ( $sent_message ) {
    // The message was sent.
    echo 'The test message was sent. Check your email inbox.';
} else {
    // The message was not sent.
    echo 'The message was not sent!';
}