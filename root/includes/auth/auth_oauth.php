<?php

/**
*
* @package MOD oauthorize
* @version $Id
* @copyright (c) 2007 phpBB Group
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

/**
* @ignore
*/

if (!defined('IN_PHPBB'))
{
   exit;
}

// Basic function for login
// Relying on association between user_id and custom provider id
// Registered with user profile

function login_oauth(&$oauth_id, &$provider)
{
	global $db;

  $oauth_column = 'pf_'.$provider.'_id';

	if (!$oauth_id)
	{
		return array(
			'status'	=> LOGIN_ERROR_USERNAME,
			'error_msg'	=> 'NO_ERROR_OAUTH',
			'user_row'	=> array('user_id' => ANONYMOUS),
		);
	}

	$sql = 'SELECT user_id FROM '.PROFILE_FIELDS_DATA_TABLE.' WHERE '.$oauth_column. " = '" .$oauth_id ."'";
	$result = $db->sql_query($sql);
	$row = $db->sql_fetchrow($result);
	$db->sql_freeresult($result);
	
	if (sizeof($row) > 0) 
  {	
		return array(
			'status'		=> LOGIN_SUCCESS,
			'error_msg'		=> false,
			'user_row'		=> $row,
		);
	} 
  else 
  {
		return array(
			'status'	=> LOGIN_ERROR_USERNAME,
			'error_msg'	=> 'LOGIN_ERROR_USERNAME',
			'user_row'	=> array('user_id' => ANONYMOUS),
		);
	}	
}

?>
