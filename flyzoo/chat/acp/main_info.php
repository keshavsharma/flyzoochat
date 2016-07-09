<?php
/**
*
* Pages extension for the phpBB Forum Software package.
*
* @copyright (c) 2014 phpBB Limited <https://www.phpbb.com>
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

namespace flyzoo\chat\acp;

class main_info
{
	public function module()
	{
		 
		return array(
			'filename'	=> '\flyzoo\chat\acp\main_module',
			'title'		=> 'FLYZOO_EXT_TITLE',
			'version'	=> '1.0.0',
			'modes'         => array(
                'main' => array(
                    'title' => 'FLYZOO_EXT',
                    'auth'  => 'ext_flyzoo/chat && acl_a_user',
                    'cat'   => array('ACP_CAT_USERS'),
                ),
            ),
		);
	}
}
