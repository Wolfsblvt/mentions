<?php
/**
 * 
 * '@Mention System [English]
 * 
 * @copyright (c) 2015 Wolfsblvt ( www.pinkes-forum.de )
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 * @author InuYaksa
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
	'MENTIONS_SETTINGS_ACP'								=> 'Impostazioni',

	'MENTIONS_TITLE'									=> '@Mention System',
	'MENTIONS_TITLE_EXPLAIN'							=> 'Permetti agli utenti di citare gli altri utenti nei post. Quando un utente viene citato, riceverà una notifica, anche se lui ha disattivato le notifiche. Ogni nome di utente citato verrà colorato in base al suo gruppo di appartenenza. E\' attivo un sistema di suggerimento dei nomi utente.',                                            
	'MENTIONS_COPYRIGHT'								=> '© 2015 Wolfsblvt (www.pinkes-forum.de) + InuYaksa (3.2 port) [<a href="http://pinkes-forum.de/dev/find.php">More extensions of Wolfsblvt</a>]',

	// General settings
	'MENTIONS_SETTINGS_GENERAL'							=> 'Impostazioni generali',
	'MENTIONS_ACTIVE_BBCODE'							=> 'Attiva il BBCode [mention]',
	'MENTIONS_ACTIVE_BBCODE_EXPLAIN'					=> 'Attiva la possibilità di citare gli utenti tramite il BBCode [mention]Username[/mention].',
	'MENTIONS_ACTIVE_BBCODE_TEXT'						=> 'Attiva il BBCode [mention=]',
	'MENTIONS_ACTIVE_BBCODE_TEXT_EXPLAIN'				=> 'Attiva la possibilità di citare gli utenti tramite il BBCode [mention="Username"]Nickname[/mention]. Usando questo BBCode puoi scegliere qualsiasi nome venga visualizzato quando citi un utente. Per esempio scrivendo un altro nickname che lui utilizza oppure nomi più informali. Tu puoi vedere il vero username se ti posizione con il mouse sopra la citazione.',
	'MENTIONS_ACTIVE_AT'								=> 'Attiva la citazione tramite @',
	'MENTIONS_ACTIVE_AT_EXPLAIN'						=> 'Attiva la possibilità di citare un utente tramite il carattere &quot;@&quot;, seguito dallo username.',
	'MENTIONS_REPLACE_IN_TEXT'							=> 'Sostituisci le citazioni presnti nel testo',
	'MENTIONS_REPLACE_IN_TEXT_EXPLAIN'					=> 'Quando abilitato, le citazioni presenti nel testo vengono sostituiti con il link al profilo e con il colore del gruppo.',
	'MENTIONS_IMAGE_INLINE'								=> 'Inserisci l\'avatar davanti allo username',
	'MENTIONS_IMAGE_INLINE_EXPLAIN'						=> 'Quando abilitato, viene inserito l\'avatar davanti allo username.',

	// Autocomplete settings
	'MENTIONS_SETTINGS_AUTOCOMPLETE'					=> 'Impostazioni suggerimenti',
	'MENTIONS_ACT_VOTES_HIDE'							=> 'Attiva per nascondere i voti',
	'MENTIONS_AUTOCOMPLETE_ENABLED'						=> 'Autocompleta le citazioni',
	'MENTIONS_AUTOCOMPLETE_ENABLED_EXPLAIN'				=> 'Quando attivo, mentre si digita vengono suggeriti gli username.',
	'MENTIONS_AUTOCOMPLETE_TOPIC_POSTERS'				=> 'In cita i nomi di chi sta partecipando al topic',
	'MENTIONS_AUTOCOMPLETE_TOPIC_POSTERS_EXPLAIN'		=> 'Quando attivo, appaiono in cima all\'elenco gli utenti che hanno già postanto nel topic.',
	'MENTIONS_AUTOCOMPLETE_AUTOCLOSE_BBCODE'			=> 'Chiudi in automantico il codice BBCode',
	'MENTIONS_AUTOCOMPLETE_AUTOCLOSE_BBCODE_EXPLAIN'	=> 'Quando attivo, il codice BBCodes di mention viene chiuso in automatico.',

	// Load settings
	'MENTIONS_SETTINGS_LOAD'					=> 'Carica impostazioni',
	'MENTIONS_MIN_POSTS_SUGGEST'						=> 'Numero minimo di post per poter essere citato',
	'MENTIONS_MIN_POSTS_SUGGEST_EXPLAIN'				=> 'Il numero di post minimo che un utente deve raggiungere per poter essere citato. Impostalo a 0 per tutti gli utenti.<br />Fai attenzione al numero enorme di utenti che potrebbe rallentare il caricamento delle pagine. Su forum con tanti utenti, è consigliato utilizzare un numero minimo. <i>(Default: 1)</i>',
	'MENTIONS_MAXIMUM_AT_MENTIONS_PER_POST'				=> 'Limita il numero citazioni con &quot;@&quot; per post',
	'MENTIONS_MAXIMUM_AT_MENTIONS_PER_POST_EXPLAIN'		=> 'Il numero massimo di citazioni con &quot;@&quot; che verranno elaborate per ogni post. Impostalo con cautela in modo da non rallentare troppo il caricamento delle pagine. <i>(Default: 50)</i>',
	'MENTIONS_AUTOCOMPLETE_REMOTE_LOAD'					=> 'Caricamento remoto dell\'elenco di autocompletamento',
	'MENTIONS_AUTOCOMPLETE_REMOTE_LOAD_EXPLAIN'			=> 'Quando attivo, l\'elenco degli username non viene caricato una volta sola, non appena si comincia digitare una citazione. Questa opzione è utile per i forum con un grande numero di utenti e il caricamento dell\'elenco richiede troppo tempo. Fai attenzione perché l\'elenco viene ricaricato ogni volta, dove viene effettuata una richiesta al server per richiedere la lista.',
));
