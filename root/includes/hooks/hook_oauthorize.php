<?php

/**
*
* @package MOD oauthorize
* @version $Id
* @copyright (c) 2007 phpBB Group
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

class OauthLogin
{
  // Loading on each page
  
  function before_template_display(&$hook, $handle, $include_once = true)
	{
		global $template, $user, $phpbb_root_path, $phpEx, $config;
    
    // We get the content from the normal display function 
    // and modify/enrich it
    
    $result = $hook->previous_hook_result(array('template','display'));
    
    // MOD dictionnary may be alreay loaded
    // No need to do it twice
    
    if (!isset($user->lang['OAUTH_UNKOWN_ACTION']))
    {
      $user->add_lang('mods/oauthorize');
    }   
    
    if ($user->data['user_id'] != ANONYMOUS)
    {
      // This loads the cutom fields in $user object but does not return them
      $user->get_profile_fields($user->data['user_id']);

      if (empty($user->profile_fields['pf_oauth_internal_id']))
      {
        $u_oauth_internal_connect = append_sid("{$phpbb_root_path}oauthorize.$phpEx", 'provider=internal&amp;action=authorize', true, $user->session_id);
        $s_oauth_internal = false;
      }
      else
		  {
        $u_oauth_internal_connect = append_sid("{$phpbb_root_path}oauthorize.$phpEx", 'provider=internal&amp;action=deauthorize', true, $user->session_id);
        $s_oauth_internal = true;
      }
    }
    else
    {
      $u_oauth_internal_connect = append_sid("{$phpbb_root_path}oauthorize.$phpEx", 'provider=internal');
      $s_oauth_internal = false;
    }
    
    $template->assign_vars(array(
      'U_OAUTH_INTERNAL_CONNECT'	=> $u_oauth_internal_connect,
      'S_OAUTH_INTERNAL' => $s_oauth_internal,
    ));
  }
  
  // // Loaded before all the code of include/ucp/ucp_register.php
  // // It disables captcha if the user is already 
  // // authenticated on Facebook or Internal
  
  // function before_main_register(&$hook)
  // {
  //   global $template, $user, $phpbb_root_path, $phpEx, $config;
    
  //   $reg_type = request_var('type', '');
		// $reg_provider = request_var('provider', '');

		// if ($reg_type == 'oauth')
		// {
  // 		$session_oauth = json_decode($user->data['session_oauth'], true);
      
  //     if (!empty($session_oauth[$reg_provider]['id']))
  //     {
  //       $config['enable_confirm'] = false;  
  //     }	
		// }      
  // }
  
//   // Loaded after all the code of include/ucp/ucp_register.php
  
//   function after_main_register(&$hook)
//   {
//     global $template, $user, $phpbb_root_path, $phpEx, $config;
    
//     // We get the content from the normal 'ucp_register->main()' function
//     // and modify/enrich it
    
//     $result = $hook->previous_hook_result(array('ucp_register', 'ucp_register_handler'));
    
//     $agreed			= (empty($_POST['agreed'])) ? false : true;
// 		$submit			= (isset($_POST['submit'])) ? true : false;
//     $coppa			= (isset($_REQUEST['coppa'])) ? ((!empty($_REQUEST['coppa'])) ? 1 : 0) : false;
//     $change_lang	= request_var('change_lang', '');
    
//     $user->add_lang('mods/oauthorize');
    
//     $reg_type = request_var('type', '');
// 		$reg_provider = request_var('provider', '');
// 		$add_reg_type ='';

// 		if ($reg_type == 'oauth')
// 		{
//       $session_oauth = json_decode($user->data['session_oauth'], true);
      
//       if (!empty($session_oauth[$reg_provider]['id']))
//       {
//         $add_reg_type = '&amp;type='.$reg_type.'&amp;provider='. $reg_provider;
//         if ($agreed)
//         {
//           if ($submit)
//           {
//             meta_refresh(3, $phpbb_root_path.'oauthorize.php?provider='.$reg_provider.'&action=login&after=registration');
//           }
//           else
//           {    
//             $template->assign_vars(array(
// 				      'S_OAUTH_REGISTRATION'      => true,				
// 				      'L_OAUTH_PROVIDER'          => $reg_provider,				
// 				      'L_OAUTH_ID'                => $session_oauth[$reg_provider]['id'],				
// 				      'L_OAUTH_USERNAME'          => $session_oauth[$reg_provider]['username'],
// 				      'L_OAUTH_ID_FORM_INPUT_KEY' => 'pf_oauth_'. $reg_provider .'_id',
//               'S_UCP_ACTION'		=> append_sid("{$phpbb_root_path}ucp.$phpEx", 'mode=register' . $add_reg_type),
// 			      ));
//           }
//         }
//         else
//         {
//           if ($config['coppa_enable'])
//           {
//             $add_lang = ($change_lang) ? '&amp;change_lang=' . urlencode($change_lang) : '';
//             $add_coppa = ($coppa !== false) ? '&amp;coppa=' . $coppa : '';
        
//             if ($coppa === false)
//             {                
//               $template->assign_vars(array(
//                 'U_COPPA_NO'		=> append_sid("{$phpbb_root_path}ucp.$phpEx", 'mode=register&amp;coppa=0' . $add_reg_type . $add_lang),
//                 'U_COPPA_YES'		=> append_sid("{$phpbb_root_path}ucp.$phpEx", 'mode=register&amp;coppa=1' . $add_reg_type . $add_lang),
//               ));
//             }
//             else
//             {
//               $template->assign_vars(array(
//                 'S_UCP_ACTION'		=> append_sid("{$phpbb_root_path}ucp.$phpEx", 'mode=register'. $add_reg_type . $add_lang . $add_coppa),
//                 ));
//             }
//           }
//           else
//           {
//             $template->assign_vars(array(
//               'S_UCP_ACTION'		=> append_sid("{$phpbb_root_path}ucp.$phpEx", 'mode=register' . $add_reg_type),
//               ));
//           }
//           $template->assign_vars(array(
// 				    'S_OAUTH_REGISTRATION'      => true,				
// 				    'L_OAUTH_PROVIDER'          => $reg_provider,				           
// 			    ));
//         }
//       }	
// 		}
//     elseif (!$agreed)
//     {        
//       $template->assign_vars(array(
// 				  'S_OAUTH_REGISTRATION'      => false,
//           'U_OAUTH_INTERNAL_REGISTER' => $phpbb_root_path.'oauthorize.php?provider=internal&amp;action=register',
//         ));
//     } 
//   }
}

// ucp_register_after_handler and ucp_register_before_handler
// are unofficial hooks added in include/ucp/ucp_register.php
// and which need to be registered

// $phpbb_hook->add_hook(array('ucp_register', 'ucp_register_after_handler'));
// $phpbb_hook->add_hook(array('ucp_register', 'ucp_register_before_handler'));

// we associate the new hooks with the functions after_main_register 
// and before_main_register defined here

// $phpbb_hook->register(array('ucp_register', 'ucp_register_before_handler'), array('OauthLogin', 'before_main_register'));
// $phpbb_hook->register(array('ucp_register', 'ucp_register_after_handler'), array('OauthLogin', 'after_main_register'));

// ptemplate display is an official hook in phpbb 3.0.x
// which just need to be associated with the function page_header defined here
// We limit usage to normal pages

if (!defined('ADMIN_START'))
{
  $phpbb_hook->register(array('template','display'), array('OauthLogin', 'before_template_display'));
}
?>