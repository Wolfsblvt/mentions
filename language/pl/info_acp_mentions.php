<?php
/**
 * 
 * '@Mention System [Polish]
 * 
 * @copyright (c) 2015 Wolfsblvt ( www.pinkes-forum.de )
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 * @author Clemens Husung (Wolfsblvt)
 * @translation Serge Victor <phpbb@random.re>
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
	'MENTIONS_TITLE_ACP'					=> 'System @wzmianek',
	'MENTIONS_SETTINGS_ACP'					=> 'Ustawienia',

	'MENTIONS_TITLE'					=> 'System @wzmianek',
	'MENTIONS_TITLE_EXPLAIN'				=> 'Pozwala na wspomnienie innych użytkowników forum w postach. Wzmiankowany użytkownik otrzyma powiadomienie w przypadku, w którym powiadomień nie zdezaktywował. Allows users to mention other users in posts. Ksywka użytkownika na forum zostanie napisana w kolorze grupy użytkownika. System @wzmianek potrafi sugerować nazwy użytkowników.',
	'MENTIONS_COPYRIGHT'					=> '© 2015 Wolfsblvt (www.pinkes-forum.de) [<a href="http://pinkes-forum.de/dev/find.php">Więcej rozszerzeń napisanych przez Wolfsblvta</a>]',

	// General settings
	'MENTIONS_SETTINGS_GENERAL'				=> 'Ustawienia główne',
	'MENTIONS_ACTIVE_BBCODE'				=> 'Aktywuj BBCode [mention]',
	'MENTIONS_ACTIVE_BBCODE_EXPLAIN'			=> 'Aktywuj możliwość wspomnienia użykowników z kodem BBcode [mention]Nazwa_użykownika[/mention].',
	'MENTIONS_ACTIVE_BBCODE_TEXT'				=> 'Aktywuj BBCode [mention]',
	'MENTIONS_ACTIVE_BBCODE_TEXT_EXPLAIN'			=> 'Aktywuj możliwość wspomnienia użykowników z kodem BBcode [mention]Nazwa_użykownika[/mention]. With this BBCode you can choose whatever display name you want for mentioning a user. For example for nicknames or declension. You can see the real username if you hover the mention in the text.',
	'MENTIONS_ACTIVE_AT'					=> 'Aktywuj opcję @ wzmianek',
	'MENTIONS_ACTIVE_AT_EXPLAIN'				=> 'Aktywuj możliwość wspomnienia użykowników po prostu poprzez napisanie &quot;@&quot;, a później nazwę użytkownika.',
	'MENTIONS_REPLACE_IN_TEXT'				=> 'Zastąp zmianki w tekście',
	'MENTIONS_REPLACE_IN_TEXT_EXPLAIN'			=> 'Po włączeniu, wspomnienia w tekście zostaną zastąpione linkiem do profilu użytkownika w kolorze jego grupy.',
	'MENTIONS_IMAGE_INLINE'					=> 'Umieść miniaturowy awatar przed wspomnianą nazwą użytkownika',
	'MENTIONS_IMAGE_INLINE_EXPLAIN'				=> 'Po włączeniu, miniaturowy awaratar pojawi się dodatkowo przed nazwą wspomnianego użytkownika.',

	// Autocomplete settings
	'MENTIONS_SETTINGS_AUTOCOMPLETE'			=> 'Ustawienia autouzupełniania',
	'MENTIONS_ACT_VOTES_HIDE'				=> 'Aktywuj ukrywanie głosów.',
	'MENTIONS_AUTOCOMPLETE_ENABLED'				=> 'Autouzupełnianie wzmianek',
	'MENTIONS_AUTOCOMPLETE_ENABLED_EXPLAIN'			=> 'Po włączeniu, system będzie sugerował nazwy użytkowników do autouzupełnienia podczas pisania.',
	'MENTIONS_AUTOCOMPLETE_TOPIC_POSTERS'			=> 'Autorzy aktywni w temacie znajdą się na górze listy',
	'MENTIONS_AUTOCOMPLETE_TOPIC_POSTERS_EXPLAIN'		=> 'Po włączeniu, użytkownicy którzy już zabrali głos w wątku, znajdą się na szczycie listy sugestii autouzupełnienia.',
	'MENTIONS_AUTOCOMPLETE_AUTOCLOSE_BBCODE'		=> 'Automatycznie zamykaj kod wzmianek w BBCodes.',
	'MENTIONS_AUTOCOMPLETE_AUTOCLOSE_BBCODE_EXPLAIN'	=> 'Po włączeniu, kod BBCodes wzmianek zostanie automatycznie zamykany po wpisaniu nazwy użytkownika.',

	// Load settings
	'MENTIONS_SETTINGS_AUTOCOMPLETE'			=> 'Załaduj ustawienia',
	'MENTIONS_MIN_POSTS_SUGGEST'				=> 'Minimalna ilość postów użykownika, aby mógł zostać sugerowany w autouzupełnianiu.',
	'MENTIONS_MIN_POSTS_SUGGEST_EXPLAIN'			=> 'Minimalna ilość postów użykownika, aby mógł zostać sugerowany w autouzupełnianiu. Ustaw na 0 do objęcia wszystkich użytkowników. <br />Miej na uwadze, że ogromna ilość użytkowników do wspomnienia może znacząco zwolnić działanie całego forum, zwiększając czas ładowania postów ze wzmiankami. Na forach z dużą ilością użytkowników zdecydowanie rekomendujemy zwiększenie tej wartości. <i>(Domyślnie: 1)</i>',
	'MENTIONS_MAXIMUM_AT_MENTIONS_PER_POST'			=> 'Ogranicz ilość &quot;@&quot; wzmianek na jeden post',
	'MENTIONS_MAXIMUM_AT_MENTIONS_PER_POST_EXPLAIN'		=> 'Maksymalna liczba &quot;@&quot; wzmianek, które zostaną przetworzone w jednym poście. Miej na uwadzę, że duża liczba przetwarzanych wzmianek może znacząco zwolnić działanie forum. <i>(Domyślnie:50)</i>',
	'MENTIONS_AUTOCOMPLETE_REMOTE_LOAD'			=> 'Włacz zdalne autouzupełnianie',
	'MENTIONS_AUTOCOMPLETE_REMOTE_LOAD_EXPLAIN'		=> 'Po włączeniu, lista sugerowanych do wspomnienia użytkowników nie będzie ładowana naraz, a po wpisaniu każdego kolejnego znaku. Ta opcja przeznaczona jest dla forów, które posiadają dużą ilość użytkowników, gdzie ładowanie od razu wszystkich nazw zajmowałoby zbyt dużo czasu. Miej na uwadze, że to nieco spowalnia działanie mechanizmu sugerowania nazw użytkowników do autouzupełnienia, gdyż serwer musi być wielokrotnie konsultowany.',
));
