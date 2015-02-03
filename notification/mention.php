<?php
/**
 * 
 * '@Mention System
 * 
 * @copyright (c) 2015 Wolfsblvt ( www.pinkes-forum.de )
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 * @author Clemens Husung (Wolfsblvt)
 */

namespace wolfsblvt\mentions\notification;

class mention extends \phpbb\notification\type\post
{

	/**
	 * Get notification type name
	 *
	 * @return string
	 */
	public function get_type()
	{
		return 'wolfsblvt.mentions.notification.type.mention';
	}

	/**
	 * Language key used to output the text
	 *
	 * @var string
	 */
	protected $language_key = 'NOTIFICATION_MENTION';

	/**
	 * Notification option data (for outputting to the user)
	 *
	 * @var bool|array False if the service should use it's default data
	 * 					Array of data (including keys 'id', 'lang', and 'group')
	 */
	public static $notification_option = array(
		'lang'	=> 'NOTIFICATION_TYPE_MENTION',
		'group'	=> 'NOTIFICATION_GROUP_POSTING',
	);

	/** @var \wolfsblvt\mentions\core\mentions */
	protected $mentions;

	/**
	 * Notification Mention Constructor
	 *
	 * @param \wolfsblvt\mentions\core\mentions $mentions
	 * @param \phpbb\user_loader $user_loader
	 * @param \phpbb\db\driver\driver_interface $db
	 * @param \phpbb\cache\driver\driver_interface $cache
	 * @param \phpbb\user $user
	 * @param \phpbb\auth\auth $auth
	 * @param \phpbb\config\config $config
	 * @param string $phpbb_root_path
	 * @param string $php_ext
	 * @param string $notification_types_table
	 * @param string $notifications_table
	 * @param string $user_notifications_table
	 * @return \phpbb\notification\type\base
	 */
	public function __construct(\wolfsblvt\mentions\core\mentions $mentions, \phpbb\user_loader $user_loader, \phpbb\db\driver\driver_interface $db, \phpbb\cache\driver\driver_interface $cache, \phpbb\user $user, \phpbb\auth\auth $auth, \phpbb\config\config $config, $phpbb_root_path, $php_ext, $notification_types_table, $notifications_table, $user_notifications_table)
	{
		$this->mentions = $mentions;
		$this->user_loader = $user_loader;
		$this->db = $db;
		$this->cache = $cache;
		$this->user = $user;
		$this->auth = $auth;
		$this->config = $config;

		$this->phpbb_root_path = $phpbb_root_path;
		$this->php_ext = $php_ext;

		$this->notification_types_table = $notification_types_table;
		$this->notifications_table = $notifications_table;
		$this->user_notifications_table = $user_notifications_table;
	}

	/**
	 * Is this type available to the current user (defines whether or not it will be shown in the UCP Edit notification options)
	 *
	 * @return bool True/False whether or not this is available to the user
	 */
	public function is_available()
	{
		return true;
	}

	/**
	 * Find the users who want to receive notifications
	 *
	 * @param array $post Data from submit_post
	 * @param array $options Options for finding users for notification
	 *
	 * @return array
	 */
	public function find_users_for_notification($post, $options = array())
	{
		$options = array_merge(array(
			'ignore_users'		=> array(),
		), $options);

		$users = $this->mentions->get_mentioned_users($post['post_text']);
		$user_ids = array_map(function ($value) { return $value['user_id']; }, $users);

		return $this->get_authorised_recipients($user_ids, $post['forum_id'], $options, true);
	}

	/**
	 * Update a notification
	 *
	 * @param array $post Data specific for this type that will be updated
	 */
	public function update_notifications($post)
	{
		$old_notifications = array();
		$sql = 'SELECT n.user_id
			FROM ' . $this->notifications_table . ' n, ' . $this->notification_types_table . ' nt
			WHERE n.notification_type_id = ' . (int) $this->notification_type_id . '
				AND n.item_id = ' . self::get_item_id($post) . '
				AND nt.notification_type_id = n.notification_type_id
				AND nt.notification_type_enabled = 1';
		$result = $this->db->sql_query($sql);
		while ($row = $this->db->sql_fetchrow($result))
		{
			$old_notifications[] = $row['user_id'];
		}
		$this->db->sql_freeresult($result);

		// Find the new users to notify
		$notifications = $this->find_users_for_notification($post);

		// Find the notifications we must delete
		$remove_notifications = array_diff($old_notifications, array_keys($notifications));

		// Find the notifications we must add
		$add_notifications = array();
		foreach (array_diff(array_keys($notifications), $old_notifications) as $user_id)
		{
			$add_notifications[$user_id] = $notifications[$user_id];
		}

		// Add the necessary notifications
		$this->notification_manager->add_notifications_for_users($this->get_type(), $post, $add_notifications);

		// Remove the necessary notifications
		if (!empty($remove_notifications))
		{
			$sql = 'DELETE FROM ' . $this->notifications_table . '
				WHERE notification_type_id = ' . (int) $this->notification_type_id . '
					AND item_id = ' . self::get_item_id($post) . '
					AND ' . $this->db->sql_in_set('user_id', $remove_notifications);
			$this->db->sql_query($sql);
		}

		// return true to continue with the update code in the notifications service (this will update the rest of the notifications)
		return true;
	}

	/**
	 * {inheritDoc}
	 */
	public function get_redirect_url()
	{
		return $this->get_url();
	}

	/**
	 * Get email template
	 *
	 * @return string|bool
	 */
	public function get_email_template()
	{
		return '@wolfsblvt_mentions\mention';
	}

	/**
	 * Get email template variables
	 *
	 * @return array
	 */
	public function get_email_template_variables()
	{
		$user_data = $this->user_loader->get_user($this->get_data('poster_id'));

		return array_merge(parent::get_email_template_variables(), array(
			'AUTHOR_NAME'		=> htmlspecialchars_decode($user_data['username']),
		));
	}
}
