<?php
/**
 * 
 * @Mention System [Czech]
 * 
 * @copyright (c) 2015 Wolfsblvt ( www.pinkes-forum.de )
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 * @author Clemens Husung (Wolfsblvt)
 * @translation R3gi
 */
if (!defined('IN_PHPBB'))
{
	exit;
}
if (empty($lang) || !is_array($lang))
{
	$lang = array();
}
$lang = array_merge($lang, array(
	'MENTIONS_EXT_NAME'						=> '@Mention System',
	'MENTIONS_MENTION'						=> 'Zmínka',
	'MENTION_BBCODE_HELPLINE'				=> 'Zmínění uživatele: @Jméno, [mention]Jméno[/mention] nebo [mention=&quot;Jméno&quot;]Přezdívka[/mention]',
	'MENTION_TEXT_BBCODE_HELPLINE'			=> 'Zmínění uživatele: @Jméno, [mention]Jméno[/mention] nebo [mention=&quot;Jméno&quot;]Přezdívka[/mention]',
	'NOTIFICATION_TYPE_MENTION'				=> 'Někdo vás zmínil v příspěvku',
	'NOTIFICATION_MENTION'					=> array(
		1	=> '<strong>Zmínka</strong> od %1$s v:',
	),
	'MENTION_EXTENSION_NOT_ENABLEABLE_REASON'	=> 'BBCode [mention] nebo [mention=] je již definovaný. Pro aktivaci tohoto rozšíření je nutné stávající BBCode přejmenovat či odstranit.',
));
