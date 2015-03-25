<?php
/**
 * 
 * '@Mention System [English]
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
	'MENTIONS_TITLE_ACP'								=> '@Mention System',
	'MENTIONS_SETTINGS_ACP'								=> 'Nastavení',
	'MENTIONS_TITLE'									=> '@Mention System',
	'MENTIONS_TITLE_EXPLAIN'							=> 'Umožňuje uživatelům zmínit v příspěvcích jiné uživatele. Pokud je uživatel zmíněn, obdrží oznámení (pokud ho nevypnul). Zmíněná uživatelská jména mohou být automaticky obarvena podle standardní uživatelské barvy. Zmínění uživatelé budou automaticky navrhováni.',
	'MENTIONS_COPYRIGHT'								=> '© 2015 Wolfsblvt (www.pinkes-forum.de) [<a href="http://pinkes-forum.de/dev/find.php">Další rozšíření od Wolfsblvt</a>], český překlad: <a href="mailto:regiprogi@gmail.com">R3gi</a>',
	// General settings
	'MENTIONS_SETTINGS_GENERAL'							=> 'Obecné nastavení',
	'MENTIONS_ACTIVE_BBCODE'							=> 'Aktivovat BBCode [mention]',
	'MENTIONS_ACTIVE_BBCODE_EXPLAIN'					=> 'Aktivace možnosti zmínit uživatele pomocí BBCodu [mention]Jméno[/mention] BBCode.',
	'MENTIONS_ACTIVE_BBCODE_TEXT'						=> 'Aktivovat BBCode [mention=]',
	'MENTIONS_ACTIVE_BBCODE_TEXT_EXPLAIN'				=> 'Aktivace možnosti zmínit uživatele pomocí BBCodu [mention="Jméno"]Přezdívka[/mention]. S tímto BBCodem je možné zobrazit libovolné jméno zmíněného uživatele. Umožňuje to tedy použít různé přezdívky či skloňovaná jména. Skutečné uživatelské jméno bude zobrazeno při přejetí zmínky v textu.',
	'MENTIONS_ACTIVE_AT'								=> 'Aktivovat možnost zmínění pomocí zavináče (@)',
	'MENTIONS_ACTIVE_AT_EXPLAIN'						=> 'Aktivace možnosti zmínit uživatele pomocí „@“, následovaném uživatelským jménem.',
	'MENTIONS_REPLACE_IN_TEXT'							=> 'Nahrazovat zmínky v textu',
	'MENTIONS_REPLACE_IN_TEXT_EXPLAIN'					=> 'Při povolení této volby budou zmínky v textu nahrazeny odkazem na uživatelské jméno v odpovídající barvě.',
	'MENTIONS_IMAGE_INLINE'								=> 'Avatar před nahrazenými jmény',
	'MENTIONS_IMAGE_INLINE_EXPLAIN'						=> 'Při povolení této volby bude před nahrazeným uživatelským jménem zobrazen uživatelův profilový obrázek.',
	// Autocomplete settings
	'MENTIONS_SETTINGS_AUTOCOMPLETE'					=> 'Nastavení našeptávání',
	'MENTIONS_ACT_VOTES_HIDE'							=> 'Povolit skrývání hlasů',
	'MENTIONS_AUTOCOMPLETE_ENABLED'						=> 'Návrhy uživatelských jmen',
	'MENTIONS_AUTOCOMPLETE_ENABLED_EXPLAIN'				=> 'Při povolení této volby budou během psaní navrhována uživatelská jména.',
	'MENTIONS_AUTOCOMPLETE_TOPIC_POSTERS'				=> 'Účastníci diskuze nahoře',
	'MENTIONS_AUTOCOMPLETE_TOPIC_POSTERS_EXPLAIN'		=> 'Při povolení této volby budou uživatelé, kteří se účastní aktuální diskuze zobrazeni v horní části seznamu navrhovaných uživatelů.',
	'MENTIONS_AUTOCOMPLETE_AUTOCLOSE_BBCODE'			=> 'Automaticky zavírat BBCode zmínky',
	'MENTIONS_AUTOCOMPLETE_AUTOCLOSE_BBCODE_EXPLAIN'	=> 'Při povolení této volby budou BBCody automaticky zavírány během psaní.',
	// Load settings
	'MENTIONS_SETTINGS_AUTOCOMPLETE'					=> 'Nastavení načítání',
	'MENTIONS_MIN_POSTS_SUGGEST'						=> 'Minimální počet příspěvků pro zmínění',
	'MENTIONS_MIN_POSTS_SUGGEST_EXPLAIN'				=> 'Počet příspěvků, kterého musí uživatel dosáhnout, aby mohl být zmíněn. Pro všechny uživatele zadejte hodnotu „0“.<br />Pamatujte, že velké množství uživatelů, které je možné zmínit, může zpomalit stránku během načítání příspěvků, které obsahují zmínky. Na fórech s velkým počtem uživatelů je doporučeno tuto hodnotu navýšit. <i>(Výchozí: 1)</i>',
	'MENTIONS_MAXIMUM_AT_MENTIONS_PER_POST'				=> 'Omezení „@“ zmínek na jeden příspěvek',
	'MENTIONS_MAXIMUM_AT_MENTIONS_PER_POST_EXPLAIN'		=> 'Maximální počet „@“, který bude zpracován pro zobrazení oznámení a konvertován na uživatelské jméno v jednom příspěvku. Pamatujte, že velké množství zmínek v jednom příspěvku může zpomalit stránku během načítání příspěvku. <i>(Výchozí: 50)</i>',
	'MENTIONS_AUTOCOMPLETE_REMOTE_LOAD'					=> 'Líné načítání návrhů uživatelských jmen',
	'MENTIONS_AUTOCOMPLETE_REMOTE_LOAD_EXPLAIN'			=> 'Při povolení této volby nebude seznam uživatelských jmen, která lze zmínit načten ihned, ale zobrazí se až s každým dalším písmenem zmínky. Tato funkce je vhodná pro fóra s velkým počtem uživatelů, u kterých může být seznam velmi rozsáhlý. Pamatujte, že aktivace této funkce zpomalí zobrazování návrhů, protože pro každé uživatelské jméno bude muset být zaslán požadavek na server.',
));
