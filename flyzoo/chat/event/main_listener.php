<?php
/**
 *
 * This file is part of the phpBB Forum Software package.
 *
 * @copyright (c) phpBB Limited <https://www.phpbb.com>
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 * For full copyright and license information, please see
 * the docs/CREDITS.txt file.
 *
 */

namespace flyzoo\chat\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Event listener
 */
class main_listener implements EventSubscriberInterface
{
    public function __construct(\phpbb\controller\helper $helper, \phpbb\template\template $template, \phpbb\user $user)
   {
       $this->helper = $helper;
       $this->template = $template;
       $this->user = $user;
	   
   }
	static public function getSubscribedEvents()
	{
		return array(
			'core.page_header'	=> 'add_page_header_link',
			'core.adm_page_header' => 'add_page_header_link',
			'core.user_setup' => 'load_language_on_setup',
		);
	}
	 
	public function add_page_header_link()
	{
		global $config;
		$data=array('C_FLYZOO_CHAT_APPID'=> '', 'C_FLYZOO_CHAT_API_SECRET'=> '', 'C_FLYZOO_CHAT_USER_ID'=> '', 'C_FLYZOO_CHAT_USER_NAME'=> '', 'C_FLYZOO_CHAT_EMAIL'=> '', 'C_FLYZOO_CHAT_SIGNATURE'=> '', 'C_FLYZOO_CHAT_ACCESS_ROLES'=> '', 'C_FLYZOO_CHAT_LANG'=> '', 'C_FLYZOO_CHAT_FRIENDS'=> "''", 'C_FLYZOO_CHAT_AVATAR'=> '', 'C_FLYZOO_CHAT_PROFILE'=> '', 'C_FLYZOO_CHAT_HIDEINADMIN'=> false, 'C_FLYZOO_CHAT_ENABLESSO'=> false, 'C_FLYZOO_CHAT_HIDEONMOB'=> false );
		$d = $this->user->data;
		 
		$site_url = generate_board_url(true)."/";
		if(!empty($config['FLYZOO_CHAT_SITESUBDIRECTORY'])){
			$site_url .= $config['FLYZOO_CHAT_SITESUBDIRECTORY']."/";
		}
		 
		 
		 
		// if user is login
		if($d["user_id"] != 1)
		{
			if(!empty($d['user_avatar']) ){
				$data['C_FLYZOO_CHAT_AVATAR'] = $site_url."download/file.php?avatar=".$d['user_avatar'];
			}
			$data['C_FLYZOO_CHAT_PROFILE'] = $site_url.'memberlist.php?mode=viewprofile&u='.$d["user_id"];
			$data['C_FLYZOO_CHAT_USER_ID'] = $d["user_id"]; 
			$data['C_FLYZOO_CHAT_USER_NAME'] = $d["username"];
			$data['C_FLYZOO_CHAT_EMAIL'] = $d["user_email"]; 
			$data['C_FLYZOO_CHAT_FRIENDS'] = json_encode($this->getFriends($d["user_id"]));
			$data['C_FLYZOO_CHAT_ACCESS_ROLES'] = $this->getGroup($d["group_id"]);
		}
		$data['C_FLYZOO_CHAT_HIDEONMOB'] = empty($config['FLYZOO_CHAT_HIDEONMOB']) ? '' : $config['FLYZOO_CHAT_HIDEONMOB'];
		$data['C_FLYZOO_CHAT_ENABLESSO'] = empty($config['FLYZOO_CHAT_ENABLESSO']) ? '' : $config['FLYZOO_CHAT_ENABLESSO'];
		$data['C_FLYZOO_CHAT_APPID'] = empty($config['FLYZOO_CHAT_APPID']) ? '' : $config['FLYZOO_CHAT_APPID'];
		$secret = empty($config['FLYZOO_CHAT_API_SECRET']) ? '' : $config['FLYZOO_CHAT_API_SECRET'];
		$data['C_FLYZOO_CHAT_API_SECRET'] = $secret;
		$data['C_FLYZOO_CHAT_LANG'] = empty($config['FLYZOO_CHAT_LANG']) ? '' : $config['FLYZOO_CHAT_LANG'];
		 
		
		$customLoader = empty($config['FLYZOO_CHAT_CUSTOMLOADER']) ? '' : trim( $config['FLYZOO_CHAT_CUSTOMLOADER'] );
		 
        $loaderScript = empty($customLoader) ? "flyzoo.start.js" : $customLoader ;
		$data['C_FLYZOO_CHAT_LOADER_SCRIPT'] = 	$loaderScript;
		$payload = trim(strtolower($data['C_FLYZOO_CHAT_USER_ID'])).trim(strtolower($data['C_FLYZOO_CHAT_EMAIL']));
		if( !empty($secret ) ) {
		   $fzsig = hash_hmac("sha256", $payload, $secret);
		   $data['C_FLYZOO_CHAT_SIGNATURE'] = $fzsig;
		}
		$chat_allowed = true;
		if(isset($config["FLYZOO_CHAT_FITERMODE"])){
			$chat_allowed = $this->is_page_allowed($config["FLYZOO_CHAT_FITERMODE"], $config["FLYZOO_CHAT_PAGEFITERLIST"]);
		}
		$data['C_ALLOW'] = $chat_allowed;
		 
		$this->template->assign_vars($data);
		 
	}
	public function load_language_on_setup($event)
    {
        $lang_set_ext = $event['lang_set_ext'];
        $lang_set_ext[] = array(
            'ext_name' => 'flyzoo/chat',
            'lang_set' => 'lang',
        );
        $event['lang_set_ext'] = $lang_set_ext;
    }
	 
	private function is_page_allowed( $mode,  $pagelist) {
		global $request, $config;
		$matched = FALSE;
		$req_uri  = $request->server('SERVER_NAME') .htmlspecialchars_decode($request->server('REQUEST_URI'));

		$req_uri  = 'http' . ( $request->server('HTTPS') !="" ? 's' : '') . '://' . $request->server('HTTP_HOST').  $request->server('REQUEST_URI');

		if ($mode == "0" || $mode =="") return TRUE;
		if ( $pagelist != '') {
		if(function_exists('mb_strtolower')) {
			$pagelist = mb_strtolower($pagelist);
			$currentpath = mb_strtolower($req_uri);
		}
		else {
			$pagelist = strtolower( $pagelist);
			$currentpath = strtolower($req_uri);
		}
		if ($this->flyzoo_check_regex($currentpath, 'http' . ( $request->server('HTTPS') !="" ? 's' : '') . '://' . $request->server('HTTP_HOST').$config['FLYZOO_CHAT_SITESUBDIRECTORY']."/adm/*")) {
			return TRUE;
		}
		$matched = $this->flyzoo_check_regex($currentpath, $pagelist);
		$matched = ($mode == '2')?(!$matched):$matched;
		}
		else if($mode == '2'){
			$matched = TRUE;
		}
		return $matched;
    }
	private function flyzoo_check_regex($path, $patterns) {
      $to_replace = array(
        '/(\r\n?|\n)/',
        '/\\\\\*/',
      );
      $replacements = array('|','.*');
      $patterns_fixed = preg_quote($patterns, '/');
      $regexps[$patterns] = '/^(' . preg_replace($to_replace, $replacements, $patterns_fixed) . ')$/';
	  
      return (bool) preg_match($regexps[$patterns], $path);
    }
	
	private function getFriends($id){
		global $db;
		if( !(defined("USERS_TABLE") && defined("ZEBRA_TABLE"))){
			return array();
		}
		// Are there any friends & foes?
		$sql = 'SELECT z.zebra_id as user_id FROM '.USERS_TABLE.' u JOIN '.ZEBRA_TABLE.' z ON u.user_id = z.zebra_id WHERE z.friend = 1 and z.user_id='.$id;
		 
		$result			= $db->sql_query($sql);
		$u = array();
		while ($row = $db->sql_fetchrow($result))
		{
			$u[] = $row['user_id'];
		}
		return $u;
	}
	private function getGroup($id){
		global $db;
		$u = array();
		// Are there any friends & foes?
		$sql = 'SELECT group_name FROM '.GROUPS_TABLE.' WHERE group_id='.$id;
		 
		$result			= $db->sql_query($sql);
		
		while ($row = $db->sql_fetchrow($result))
		{
			$u[] = $row['group_name'];
		}
		return implode(",", $u);
	}
}