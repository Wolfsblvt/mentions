<?php
/**
 * 
 * '@Mention System [English]
 * 
 * @copyright (c) 2015 Wolfsblvt ( www.pinkes-forum.de )
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 * @author Clemens Husung (Wolfsblvt)
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

$lang = array_merge($lang, array(
	'MENTIONS_TITLE_ACP'								=> '@Mention System',
	'MENTIONS_SETTINGS_ACP'								=> 'Settings',

	'MENTIONS_TITLE'									=> '@Mention System',
	'MENTIONS_TITLE_EXPLAIN'							=> 'Allows users to mention other users in posts. If a user is mentioned, he will recieve a notification unless he deactivated this notification. Meantioned usernames can be automatically colored in their username color. Mentioned users will be autosuggested.',
	'MENTIONS_COPYRIGHT'								=> '© 2015 Wolfsblvt (www.pinkes-forum.de) [<a href="http://pinkes-forum.de/dev/find.php">More extensions of Wolfsblvt</a>]',

	// General settings
	'MENTIONS_SETTINGS_GENERAL'							=> 'General Settings',
	'MENTIONS_ACTIVE_BBCODE'							=> 'Activate [mention] BBCode',
	'MENTIONS_ACTIVE_BBCODE_EXPLAIN'					=> 'Activate the possibility to mention users with the [mention]Username[/mention] BBCode.',
	'MENTIONS_ACTIVE_BBCODE_TEXT'						=> 'Activate [mention=] BBCode',
	'MENTIONS_ACTIVE_BBCODE_TEXT_EXPLAIN'				=> 'Activate the possibility to mention users with the [mention="Username"]Nickname[/mention] BBCode. With this BBCode you can choose whatever display name you want for mentioning a user. For example for nicknames or declension. You can see the real username if you hover the mention in the text.',
	'MENTIONS_ACTIVE_AT'								=> 'Activate @ mention option',
	'MENTIONS_ACTIVE_AT_EXPLAIN'						=> 'Activate the possibility to mentions users by simply typing &quot;@&quot;, followed by the username.',
	'MENTIONS_REPLACE_IN_TEXT'							=> 'Replace Mentions in Text',
	'MENTIONS_REPLACE_IN_TEXT_EXPLAIN'					=> 'If enabled, mentions in the text will be replaced with the username link in the correct color.',
	'MENTIONS_IMAGE_INLINE'								=> 'Avator in front of replaced usernames',
	'MENTIONS_IMAGE_INLINE_EXPLAIN'						=> 'If enabled, the replaced username will be prepended by the user avatar.',

	// Autocomplete settings
	'MENTIONS_SETTINGS_AUTOCOMPLETE'					=> 'Autocomplete Settings',
	'MENTIONS_ACT_VOTES_HIDE'							=> 'Activate hide votes',
	'MENTIONS_AUTOCOMPLETE_ENABLED'						=> 'Autocomplete mentions',
	'MENTIONS_AUTOCOMPLETE_ENABLED_EXPLAIN'				=> 'If enabled, usernames will be suggested for autocomplete while typing.',
	'MENTIONS_AUTOCOMPLETE_TOPIC_POSTERS'				=> 'Topic posters on top',
	'MENTIONS_AUTOCOMPLETE_TOPIC_POSTERS_EXPLAIN'		=> 'If enabled, users who have posted already in the topic will be ordered on top of the autocomplete list.',
	'MENTIONS_AUTOCOMPLETE_AUTOCLOSE_BBCODE'			=> 'Automatically close mention BBCodes',
	'MENTIONS_AUTOCOMPLETE_AUTOCLOSE_BBCODE_EXPLAIN'	=> 'If enabled, mention BBCodes will be closed automatically while typing the mention.',

	// Load settings
	'MENTIONS_SETTINGS_AUTOCOMPLETE'					=> 'Load Settings',
	'MENTIONS_MIN_POSTS_SUGGEST'						=> 'Minimum posts to be mentionable',
	'MENTIONS_MIN_POSTS_SUGGEST_EXPLAIN'				=> 'The post count a user need to reach so that he can be mentioned. Set to 0 for all users.<br />Be aware that a huge amount of users that can be mentioned may slow the site down while loading the posts with mentions. On boards with many users, it is recommended to increase this number. <i>(Default: 1)</i>',
	'MENTIONS_MAXIMUM_AT_MENTIONS_PER_POST'				=> 'Limit &quot;@&quot; mentions per post',
	'MENTIONS_MAXIMUM_AT_MENTIONS_PER_POST_EXPLAIN'		=> 'Maximum number of &quot;@&quot; that will be parsed for notification and converted to the username in one post. Be aware that many mentions in one post may slow the site down while loading the post. <i>(Default: 50)</i>',
	'MENTIONS_AUTOCOMPLETE_REMOTE_LOAD'					=> 'Load Autocomplete remote',
	'MENTIONS_AUTOCOMPLETE_REMOTE_LOAD_EXPLAIN'			=> 'If enabled, the list of usernames that can be mentioned will not be loaded at once, but each time you type a character for the mention. This option is for boards with a huge amount of users where loading the whole list would take too long. Be aware that this will slow down autosuggest, cause the usernames need to be queried from the server each time.',
));
