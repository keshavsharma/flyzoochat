<?php
/**
*
* Pages extension for the phpBB Forum Software package.
*
* @copyright (c) 2014 phpBB Limited <https://www.phpbb.com>
* @license GNU General Public License, version 2 (GPL-2.0)
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
//
// Some characters you may want to copy&paste:
// ’ » “ ” …
//

/*
* These are errors which can be triggered by sending invalid data to the
* pages extension API.
*
* These errors will never show to a user unless they are either modifying
* the core pages extension code OR unless they are writing an extension
* which makes calls to this extension.
*
* Translators: Feel free to not translate these language strings
*/
$lang = array_merge($lang, array(
	 
	'FLYZOO_EXT_TITLE' => 'Flyzoo Module',
	'FLYZOO_EXT' => 'Flyzoo Chat',
	'FLYZOO_EXT_SETTING_SAVED' => 'Settings have been saved successfully!',
	 
	'FLYZOO_CHAT_APPID' => 'Enter your Flyzoo Application ID',
	'FLYZOO_CHAT_API_SECRET' => 'Enter your API Secret Key',
	'FLYZOO_CHAT_API_SECRET_NOTE' => '(<strong>NOTE:</strong> this is currently optional. <strong>Starting from December, 1st 2015 API Secret Key  will be mandatory to enable SSO</strong>! Please
               take a moment to log into the dashboard and get your Secret Key from SETUP &gt; INSTALLATION).',
	'FLYZOO_CHAT_SSO_NOTE' => ' <strong>Enable Single Sign On</strong> - check this to allow users log into the chat with their existing PHPBB Account.',
	'FLYZOO_CHAT_BPRESS_NOTE' => '<strong>Sync User Data</strong> - check this to integrate Flyzoo with BuddyPress/Ultimate Member/Users Ultra and others (sync friends, profile url, avatar)',
	'FLYZOO_CHAT_HIDEINADMIN_NOTE' => '<strong>Hide in PHPBB Admin</strong> - check this to hide the widget on the PHPBB Admin. ',
	'FLYZOO_CHAT_HIDEONMOB_NOTE' => '<strong>Hide on Mobile Devices</strong> - check this to hide the widget on mobile devices',
	
	
	'EXCEPTION_FIELD_MISSING'		=> 'Required field missing',
	'EXCEPTION_INVALID_ARGUMENT'	=> 'Invalid argument specified for `%1$s`. Reason: %2$s',
	'EXCEPTION_OUT_OF_BOUNDS'		=> 'The field `%1$s` received data beyond its bounds',
	'EXCEPTION_TOO_LONG'			=> 'The input was longer than the maximum length.',
	'EXCEPTION_NOT_UNIQUE'			=> 'The input was not unique.',
	'EXCEPTION_UNEXPECTED_VALUE'	=> 'The field `%1$s` received unexpected data. Reason: %2$s',
	'EXCEPTION_ILLEGAL_CHARACTERS'	=> 'The input contained illegal characters.',
	
	
));
