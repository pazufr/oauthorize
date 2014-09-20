<?php
error_reporting(E_ALL);
/**
*
* @package MOD oauthorize
* @version $Id
* @copyright (c) 2007 phpBB Group
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

// load PHPOauthLIB
use OAuth\OAuth2\Service\Google;
use OAuth\Common\Storage\Session;
use OAuth\Common\Consumer\Credentials;

require_once './oauthorize/OAuth/bootstrap.php';

/**
 * Create a new instance of the URI class with the current URI, stripping the query string
 */
$uriFactory = new \OAuth\Common\Http\Uri\UriFactory();
$currentUri = $uriFactory->createFromSuperGlobalArray($_SERVER);
$currentUri->setQuery('');

$serviceFactory = new \OAuth\ServiceFactory();

// Session storage
$storage = new Session();

define('IN_PHPBB', true);
$phpbb_root_path = (defined('PHPBB_ROOT_PATH')) ? PHPBB_ROOT_PATH : './';
$phpEx = substr(strrchr(__FILE__, '.'), 1);
include($phpbb_root_path . 'common.' . $phpEx);
include($phpbb_root_path . 'oauthorize/functions_oauthorize.' . $phpEx);

// Put your own parameters here

// Setup the credentials for the requests
$credentials = new Credentials(
  $internal_oauth_id,
  $internal_oauth_secret,
  $currentUri->getAbsoluteUri()
  );

// Nothing needed to be modified after this point

// Start session management
$user->session_begin();
$auth->acl($user->data);
$user->setup();

$provider = request_var('provider','internal'); // 
$action = request_var('action','login'); //lets default to login
$user->add_lang('mods/oauthorize');

if (!empty($user->data['session_oauth']))
{
  $session_oauth = json_decode($user->data['session_oauth'], true);
}
else
// initialize the session_oauth if it does not exist
{
  $session_oauth = array (
    'internal' => array(),  
    );
}

// The first part is to record / connect to provider and get user login & token

switch ($provider) 
{
  // Internal authentication is several steps
  // Get temporary token using Internal application credentials
  // Then reload the page catching an oauth_verifier parameter from Internal
  // Get permament token using temporary token
  // Then reload the page 

  case 'internal':
  $internalService = $serviceFactory->createService('internal', $credentials, $storage, array());

  if (!empty($_GET['code'])) {
        // This was a callback request from google, get the token
    $internalService->requestAccessToken($_GET['code']);

        // Send a request with it
    $result = json_decode($internalService->request('https://accounts.iiet.pl/appapi/v1/students/me'), true);
    $oauth_profile = array(
      'id' => $result['user_id'],
      );
  } else {
    $url = $internalService->getAuthorizationUri();
    header('Location: ' . $url);
  } 

  break;

  default:
  $message = $user->lang['OAUTH_UNKOWN_PROVIDER'];
  meta_refresh(3, $phpbb_root_path);    
  trigger_error($message);

  break;

} 

$oauth_column = 'pf_'.$provider.'_id';

switch ($action) {

  case 'login': 

    $config['auth_method'] = 'oauth'; // attempt oauth

    $auth->login($oauth_profile['id'], $provider);

    if ($user->data['is_registered']) 
    {
      //indicate that user was logged in by OAuth by registering id in session
      $session_oauth[$provider]['id'] = $oauth_profile['id'];
      $session_oauth[$provider]['username'] = $oauth_profile['username'];
      
      record_session_oauth($session_oauth);
      
      $message = sprintf($user->lang['OAUTH_MSG_LOGGED'], $user->data['username'], $oauth_profile['link'], $oauth_profile['name'], ucfirst($provider));

      meta_refresh(5, append_sid("{$phpbb_root_path}index.$phpEx"));

    }
    else 
    {      
      $message = sprintf($user->lang['OAUTH_MSG_NO_LINK'], $oauth_profile['link'], $oauth_profile['name'], $provider, append_sid($phpbb_root_path.'oauthorize.php?provider='.$provider.'&amp;action=register'));

      login_box(request_var('redirect', $phpbb_root_path.'oauthorize.php?provider='.$provider.'&amp;action=authorize'), $message);

    }
    trigger_error($message);

    break;

    default:

    $message = $user->lang['OAUTH_UNKOWN_ACTION'];
    meta_refresh(3, $phpbb_root_path);    
    trigger_error($message);  
  }