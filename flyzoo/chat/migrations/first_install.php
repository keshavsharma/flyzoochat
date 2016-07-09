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

namespace flyzoo\chat\migrations;

use phpbb\db\migration\migration;

class first_install extends migration
{
    public function effectively_installed()
    {
        $r = isset($this->config['adduser_version']) && version_compare($this->config['adduser_version'], '1.0.0', '>=');
		 
		return $r;
		//return isset($this->config['acme_demo_goodbye']);
		 
    }

    static public function depends_on()
    {
       // return array('\phpbb\db\migration\data\v31x\v319');
	   return array('\phpbb\db\migration\data\v310\gold');
    }

    public function update_data()
    {
        return array(
            array('config.add', array('acme_demo_goodbye', 0, true)),
			array('config.add', array('adduser_version', '1.0.0')),
            array('module.add', array(
                'acp',
                'ACP_CAT_USERS',
                array(
                    'module_basename'       => '\flyzoo\chat\acp\main_module',
					'auth'				=> 'ext_flyzoo/chat && acl_a_user',
					'modes'				=> array('main'),
                ),
            )),
        );
    }
	public function revert_data()
	{
		return array(
			array('config.remove', array('acme_demo_goodbye')),

			array('module.remove', array(
				'acp',
				'ACP_CAT_USERS',
				array(
					'module_basename'	=> '\flyzoo\chat\acp\main_module',
				),
			)),
		);
	}
} 