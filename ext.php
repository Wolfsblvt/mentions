<?php
/**
 * 
 * '@Mention System
 * 
 * @copyright (c) 2015 Wolfsblvt ( www.pinkes-forum.de )
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 * @author Clemens Husung (Wolfsblvt)
 */

namespace wolfsblvt\mentions;

/**
 *
 * Extension class for custom enable/disable/purge actions
 *
 */
class ext extends \phpbb\extension\base
{
	/**
	 * A self-written function that checks the php version in the requirement section of this extension.
	 * 
	 * @return bool TRUE, if the version is matching, otherwise FALSE.
	 */
	function check_php_version()
	{
		$this->manager = $this->container->get('ext.manager');
		$this->metadata_manager = $this->manager->create_extension_metadata_manager($this->extension_name, $this->container->get('template'));
		$meta_data = $this->metadata_manager->get_metadata();
		$require_fields = $meta_data['require'];

		// If the PHP field exists, we check the version
		if ($require_fields && isset($require_fields['php']))
		{
			$php_require_field = $this->split_version_and_operator(html_entity_decode($require_fields['php']));
			return $php_require_field && (phpbb_version_compare(PHP_VERSION, $php_require_field['version'], $php_require_field['operator']));
		}
		return true;
	}

	/**
	 * Splits a string where an operator is combined with a version number. Operator comes first, followed by the version number without a space.
	 * For example the version strings from composer.json: ">=1.0.0"
	 * Returns assoziative array with 'version' and 'operator' or FALSE.
	 * 
	 * NOTE: valid operators are the ones used in phpbb_version_compare(). These are:
	 *		array("<", "lt", "<=", "le", ">", "gt", ">=", "ge", "==", "=", "eq", "!=", "<>", "ne")
	 * 
	 * @param string $version_string The string containing the operator and version number.
	 * @return array|bool Assoziative array with 'version' and 'operator' as key. If string is not valid, then FALSE.
	 */
	public function split_version_and_operator($version_string)
	{
		if (!isset($version_string) || !is_string($version_string))
			return false;

		$operators = array(">=", ">", "ge", "gt", "==", "=", "eq", "!=", "<>", "ne", "<=", "<", "le", "lt");

		foreach ($operators as $op)
		{
			if (strpos($version_string, $op) === 0)
			{
				$ret = array(
					'version'	=> substr($version_string, strlen($op)),
					'operator'	=> $op,
					);
				return $ret;
			}
		}
		return false;
	}

	/**
	 * Overwrite enable_step to enable mentions notifications
	 * before any included migrations are installed.
	 *
	 * @param mixed $old_state State returned by previous call of this method
	 * @return mixed Returns false after last step, otherwise temporary state
	 */
	function is_enableable()
	{
		// We check requirement PHP version first. That is needed for everything from that step on.
		$php_version_chek = $this->check_php_version();
		if (!$php_version_chek)
		{
			return false;
		}

		$phpbb_db = $this->container->get("dbal.conn");

		$sql = 'SELECT bbcode_id
				FROM ' . BBCODES_TABLE . '
				WHERE bbcode_tag = "mention" OR bbcode_tag = "mention="';
		$result = $phpbb_db->sql_query($sql);
		$row = $phpbb_db->sql_fetchrow($result);
		$bbcode_exists = ($row['bbcode_id']) ? true : false;
		$phpbb_db->sql_freeresult($result);

		// If BBCode already exists, we cannot activate this extension. But we are friendly and tell why (:
		if ($bbcode_exists)
		{
			$phpbb_template = $this->container->get("template");
			$phpbb_user = $this->container->get("user");

			// We need the language file here
			$phpbb_user->add_lang_ext('wolfsblvt/mentions', 'mentions');

			// Okay, let's overwrite the error message so the reason is explained
			$phpbb_user->lang['EXTENSION_NOT_ENABLEABLE'] .= '<br />' . $phpbb_user->lang['MENTION_EXTENSION_NOT_ENABLEABLE_REASON'];
			return false;
		}

		return true;
	}

	/**
	 * Overwrite enable_step to enable mentions notifications
	 * before any included migrations are installed.
	 *
	 * @param mixed $old_state State returned by previous call of this method
	 * @return mixed Returns false after last step, otherwise temporary state
	 */
	function enable_step($old_state)
	{
		switch ($old_state)
		{
			case '': // Empty means nothing has run yet

				// Enable mentions notifications
				$phpbb_notifications = $this->container->get('notification_manager');
				$phpbb_notifications->enable_notifications('wolfsblvt.mentions.notification.type.mention');
				return 'notifications';

				break;

			default:

				// Run parent enable step method
				return parent::enable_step($old_state);

				break;
		}
	}

	/**
	 * Overwrite disable_step to disable mentions notifications
	 * before the extension is disabled.
	 *
	 * @param mixed $old_state State returned by previous call of this method
	 * @return mixed Returns false after last step, otherwise temporary state
	 */
	function disable_step($old_state)
	{
		switch ($old_state)
		{
			case '': // Empty means nothing has run yet

				// Disable mentions notifications
				$phpbb_notifications = $this->container->get('notification_manager');
				$phpbb_notifications->disable_notifications('wolfsblvt.mentions.notification.type.mention');
				return 'notifications';

				break;

			default:

				// Run parent disable step method
				return parent::disable_step($old_state);

				break;
		}
	}

	/**
	 * Overwrite purge_step to purge mentions notifications before
	 * any included and installed migrations are reverted.
	 *
	 * @param mixed $old_state State returned by previous call of this method
	 * @return mixed Returns false after last step, otherwise temporary state
	 */
	function purge_step($old_state)
	{
		switch ($old_state)
		{
			case '': // Empty means nothing has run yet

				// Purge mentions notifications
				$phpbb_notifications = $this->container->get('notification_manager');
				$phpbb_notifications->purge_notifications('wolfsblvt.mentions.notification.type.mention');
				return 'notifications';

				break;

			default:

				// Run parent purge step method
				return parent::purge_step($old_state);

				break;
		}
	}
}
