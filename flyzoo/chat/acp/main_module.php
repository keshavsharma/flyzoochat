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

class main_module
{
    public $u_action;
    public $tpl_name;
    public $page_title;

    public function main($id, $mode)
    {
        global $user, $template, $request, $config;

        $this->tpl_name = 'acp_config_input';
        $this->page_title = $user->lang('FLYZOO_EXT_TITLE');

        add_form_key('flyzoo/chat');

        if ($request->is_set_post('submit'))
        {
            if (!check_form_key('flyzoo/chat'))
            {
                $user->add_lang('acp/common');
                trigger_error('FORM_INVALID');
            }

            $config->set('FLYZOO_CHAT_APPID', $request->variable('FlyzooApplicationID', ''));
			$config->set('FLYZOO_CHAT_API_SECRET', $request->variable('FlyzooAPISecretKey', ''));
			$config->set('FLYZOO_CHAT_ENABLESSO', $request->variable('FlyzooApiEnabled', false));
			 
			 
			$config->set('FLYZOO_CHAT_HIDEONMOB', $request->variable('FlyzooHideOnMobile', false));
			$config->set('FLYZOO_CHAT_FITERMODE', $request->variable('FlyzooPageFilterMode', 0));
			$config->set('FLYZOO_CHAT_PAGEFITERLIST', $request->variable('FlyzooPageFilterList', ''));
			$config->set('FLYZOO_CHAT_LANG', $request->variable('FlyzooLanguage', 'auto'));
			$config->set('FLYZOO_CHAT_CUSTOMLOADER', $request->variable('FlyzooCustomLoader', ''));
			$config->set('FLYZOO_CHAT_SITESUBDIRECTORY', $request->variable('SubDirectory', ''));
			
            trigger_error($user->lang('FLYZOO_EXT_SETTING_SAVED') . adm_back_link($this->u_action));
        }
		
        $template->assign_vars(array(
            'U_ACTION'                              => $this->u_action,
			'FLYZOO_CHAT_APPID' => $config['FLYZOO_CHAT_APPID'],
			'FLYZOO_CHAT_API_SECRET' => $config['FLYZOO_CHAT_API_SECRET'],
			'FLYZOO_CHAT_ENABLESSO' => $config['FLYZOO_CHAT_ENABLESSO'],
			'FLYZOO_CHAT_HIDEONMOB' => $config['FLYZOO_CHAT_HIDEONMOB'],
			'FLYZOO_CHAT_FITERMODE' => $config['FLYZOO_CHAT_FITERMODE'],
			'FLYZOO_CHAT_PAGEFITERLIST' => $config['FLYZOO_CHAT_PAGEFITERLIST'],
			'FLYZOO_CHAT_LANG' => $config['FLYZOO_CHAT_LANG'],
			'FLYZOO_CHAT_CUSTOMLOADER' => $config['FLYZOO_CHAT_CUSTOMLOADER'],
			'FLYZOO_CHAT_SITESUBDIRECTORY' => $config['FLYZOO_CHAT_SITESUBDIRECTORY'],
        ));
    }
}