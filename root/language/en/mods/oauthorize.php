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
  'OAUTH_INT_CONNECT' => 'Login with OAuth',
  'OAUTH_MSG_NO_LINK' => 'No forum account is associated with this <strong><a href="%1$s">%2$s</a></strong> %3$s account. Contact admins.',
  'OAUTH_MSG_LOGGED' => 'You were logged in as <strong>%1$s</strong> through your <strong><a href="%2$s">%3$s</a></strong> %4$s account.',
  'OAUTH_MSG_ISSUE' => 'An issue has happened. Please retry.',
  'OAUTH_UNKOWN_PROVIDER' => 'Unknown provider',
  'OAUTH_UNKOWN_ACTION' => 'Unknown action', 
));

?>