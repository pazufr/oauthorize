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

/**
* Function used by oauthorize.php file
* @package MOD oauthorize
*/

// Record session_oauth array in specific session_oauth field 

function record_session_oauth($session_oauth)
{
  global $db, $user;
  
  $sql = 'UPDATE ' . SESSIONS_TABLE . " 
            SET session_oauth = '" .$db->sql_escape(json_encode($session_oauth)). "'
            WHERE session_id = '" . $db->sql_escape($user->session_id) . "'";
  $db->sql_query($sql); 
  $db->sql_freeresult($result);

  return true;
}

// Record oauth_id in custom field associated to the provider
// $insert_too set to true when not sure if we have to do an update or an insert
// $insert_too set to false when it is sure, that record exists

function record_oauth_id($oauth_id, $provider, $insert_too = true)
{
  global $db, $user;
  
  $oauth_column = 'pf_oauth_'.$provider.'_id';
  $row = array();  
  
  if ($insert_too)
  {
    $sql='SELECT user_id FROM '.PROFILE_FIELDS_DATA_TABLE.' WHERE user_id ='. $user->data['user_id'];
    $result = $db->sql_query($sql);
    $row = $db->sql_fetchrowset($result);
    $db->sql_freeresult($result);  
  } 
  
  if (empty($row) && $insert_too) 
  {
    $sql = 'INSERT INTO '.PROFILE_FIELDS_DATA_TABLE.' (user_id, '.$oauth_column.') VALUES ('.$user->data['user_id'].", '" . $db->sql_escape($oauth_id) . "')";
    $db->sql_query($sql);    
  }
  else 
  {
    $sql =  'UPDATE '.PROFILE_FIELDS_DATA_TABLE.' SET '.$oauth_column . " = '".$db->sql_escape($oauth_id). "' WHERE user_id=".$user->data['user_id'];      
    $db->sql_query($sql);                           
  }
  
  return true;
}

// Basic function to know the full current url
// Used as callback url for Twitter by example

function get_current_url() 
{
  $current_url = 'http';
  if ($_SERVER['HTTPS'] == 'on')
  {
    $current_url .= 's';
  }
  $current_url .= '://';
  if ($_SERVER["SERVER_PORT"] != '80')
  {
    $current_url .= $_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'].$_SERVER['REQUEST_URI'];
  }
  else 
  {
    $current_url .= $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
  }
  return $current_url;
}

?>