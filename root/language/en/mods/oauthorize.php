<?php
/**
*
* sortables captcha [English]
*
* @package language
* @version $Id: captcha_sortables.php 9875 2009-08-13 21:40:23Z Derky $
* @copyright (c) 2009 phpBB Group
* @copyright (c) 2009 Derky - phpBB3styles.net
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

/**
* DO NOT CHANGE
*/
if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

// DEVELOPERS PLEASE NOTE
//
// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
//
// Placeholders can now contain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
// equally where a string contains only two placeholders which are used to wrap text
// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine

$lang = array_merge($lang, array(
  'OAUTH_FB_AUTHORIZE' => 'Link Facebook',
	'OAUTH_FB_DEAUTHORIZE' => 'Unlink Facebook',
  'OAUTH_FB_CONNECT' => 'Connect',
  'OAUTH_FB_REGISTER' => 'Register with Facebook',
  'OAUTH_FB_REGISTRATION' => 'Registration with Facebook',
  'OAUTH_TW_AUTHORIZE' => 'Link Twitter',
	'OAUTH_TW_DEAUTHORIZE' => 'Unlink Twitter',
  'OAUTH_TW_CONNECT' => 'Connect',
  'OAUTH_TW_REGISTER' => 'Register with Twitter',
  'OAUTH_TW_REGISTRATION' => 'Registration with Twitter',
  'OAUTH_MSG_CUT_LINK' => 'Your <strong><a href="%1$s">%2$s</a></strong> %3$s account is not linked with this forum account anymore.',
  'OAUTH_MSG_MAPPED_LINK' => 'Your <strong><a href="%1$s">%2$s</a></strong> %3$s account is now mapped to this <strong><a href="./memberlist.php?mode=viewprofile&amp;u=%4$s">%5$s</a></strong> forum account.',
  'OAUTH_MSG_NO_LINK' => 'No forum account is associated with this <strong><a href="%1$s">%2$s</a></strong> %3$s account. You may <a href="%4$s" >register a new account</a> or login as you normally would.',
  'OAUTH_MSG_LOGGED' => 'You were logged in as <strong>%1$s</strong> through your <strong><a href="%2$s">%3$s</a></strong> %4$s account.',
  'OAUTH_MSG_ALREADY_MAPPED' => 'Duplication: An account is already mapped with this ID.',
  'OAUTH_MSG_ALREADY_REGISTERED' => 'You already have an account with us and is currently logged in.',
  'OAUTH_MSG_ISSUE' => 'An issue has happened. Please retry.',
  'OAUTH_MSG_AGREEMENT' => 'You can subcribe using your Facebook or Twitter account',
  'OAUTH_UNKOWN_PROVIDER' => 'Unknown provider',
  'OAUTH_UNKOWN_ACTION' => 'Unknown action', 
));

?>