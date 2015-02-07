<?php
/**
 * 
 * '@Mention System [Spanish]
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
	'MENTIONS_TITLE_ACP'								=> 'Sistema de @Mención',
	'MENTIONS_SETTINGS_ACP'								=> 'Ajustes',

	'MENTIONS_TITLE'									=> 'Sistema de @Mención',
	'MENTIONS_TITLE_EXPLAIN'							=> 'Permite a los usuarios mencionar otros usuarios en los mensajes. Si se menciona a un usuario este recibirá notificaciones a menos que desactive su notificación. Los nombres de usuario mencionados pueden ser del color y forma automática que su color de nombre de usuario. Los usuarios mencionados serán automáticamente sugeridos.',
	'MENTIONS_COPYRIGHT'								=> '© 2015 Wolfsblvt (www.pinkes-forum.de) [<a href="http://pinkes-forum.de/dev/find.php">Más extensiones de Wolfsblvt</a>]',

	// General settings
	'MENTIONS_SETTINGS_GENERAL'							=> 'Ajustes generales',
	'MENTIONS_ACTIVE_BBCODE'							=> 'Activar BBCode [mention]',
	'MENTIONS_ACTIVE_BBCODE_EXPLAIN'					=> 'Activar la posibilidad de mencionar usuarios con el BBCode [mention]Nombre[/mention].',
	'MENTIONS_ACTIVE_BBCODE_TEXT'						=> 'Activar BBCode [mention=]',
	'MENTIONS_ACTIVE_BBCODE_TEXT_EXPLAIN'				=> 'Activar la posibilidad de mencionar usuarios con el BBCode [mention="Nombre"]Nick[/mention]. Con este BBCode puede elegir cualquier nombre para mostrar al mencionar a un usuario. Por ejemplo, para apodos o declinación. Usted puede ver el verdadero nombre del usuario si se pasa la mención en el texto.',
	'MENTIONS_ACTIVE_AT'								=> 'Activar la opción de mención @',
	'MENTIONS_ACTIVE_AT_EXPLAIN'						=> 'Activar la posibilidad menciona usuarios simplemente escribiendo &quot;@&quot;, seguido del nombre de usuario.',
	'MENTIONS_REPLACE_IN_TEXT'							=> 'Reemplazar Menciones en texto',
	'MENTIONS_REPLACE_IN_TEXT_EXPLAIN'					=> 'Si se activa, la mención en el texto será reemplazado por el enlace de nombre de usuario y el color correcto.',
	'MENTIONS_IMAGE_INLINE'								=> 'Avatar delante de nombres de usuario reemplazados',
	'MENTIONS_IMAGE_INLINE_EXPLAIN'						=> 'Si se activa, el nombre de usuario reemplazado primero se antepondrá el avatar del usuario.',

	// Autocomplete settings
	'MENTIONS_SETTINGS_AUTOCOMPLETE'					=> 'Autocompletar ajustes',
	'MENTIONS_ACT_VOTES_HIDE'							=> 'Activar votos ocultos',
	'MENTIONS_AUTOCOMPLETE_ENABLED'						=> 'Autocomplete mentions',
	'MENTIONS_AUTOCOMPLETE_ENABLED_EXPLAIN'				=> 'Si se activa, los nombres de usuario serán sugeridos para autocompletar mientras se escribe.',
	'MENTIONS_AUTOCOMPLETE_TOPIC_POSTERS'				=> 'Escritores del tema en la parte superior',
	'MENTIONS_AUTOCOMPLETE_TOPIC_POSTERS_EXPLAIN'		=> 'Si se activa, los usuarios que han publicado ya en el tema se ordenarán en la parte superior de la lista de autocompletado.',
	'MENTIONS_AUTOCOMPLETE_AUTOCLOSE_BBCODE'			=> 'Cerrar automáticamente BBCodes de mención',
	'MENTIONS_AUTOCOMPLETE_AUTOCLOSE_BBCODE_EXPLAIN'	=> 'Si se activa, los BBCodes de mención se cerrarán automáticamente mientras se escribe la mención.',

	// Load settings
	'MENTIONS_SETTINGS_AUTOCOMPLETE'					=> 'Ajustes de carga',
	'MENTIONS_MIN_POSTS_SUGGEST'						=> 'Mensajes mínimos destinados para ser mencionable',
	'MENTIONS_MIN_POSTS_SUGGEST_EXPLAIN'				=> 'El número de mensajes que un usuario necesita para que pueda ser mencionado. Se establece en 0 para todos los usuarios.<br />Tenga en cuenta que una gran cantidad de usuarios que se pueden mencionar puede retardar el sitio durante la carga de los mensajes con menciones. En los foros con muchos usuarios, se recomienda aumentar este número. <i>(Por defecto: 1)</i>',
	'MENTIONS_MAXIMUM_AT_MENTIONS_PER_POST'				=> 'Límite de &quot;@&quot; menciones por mensaje',
	'MENTIONS_MAXIMUM_AT_MENTIONS_PER_POST_EXPLAIN'		=> 'Número máximo de &quot;@&quot; que se procesarán para la notificación y que se conviertán en el nombre de usuario en un solo mensaje. Tenga en cuenta que muchas menciones en un mensaje puede retardar el sitio mientras se carga el mensaje. <i>(Por defecto: 50)</i>',
	'MENTIONS_AUTOCOMPLETE_REMOTE_LOAD'					=> 'Cargar autocompletar remoto',
	'MENTIONS_AUTOCOMPLETE_REMOTE_LOAD_EXPLAIN'			=> 'Si se activa, la lista de nombres de usuario que se pueden mencionar no se cargará a la vez, pero si cada vez que escriba un carácter para la mención. Esta opción es para foros con una gran cantidad de usuarios, donde la carga de toda la lista sería demasiado largo. Tenga en cuenta que esto se ralentizará auto sugerencia, hacen que los nombres de usuario deben ser consultados desde el servidor cada vez.',
));
