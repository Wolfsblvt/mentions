<?php
/**
 * 
 * '@Mention System
 * 
 * @copyright (c) 2015 Wolfsblvt ( www.pinkes-forum.de )
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 * @author Clemens Husung (Wolfsblvt)
 */

namespace wolfsblvt\mentions\core;

class mentions
{
	/**
	 * CONSTANTS SECTION
	 * 
	 * To access them, you need to use the class.
	 * 
	 */
	const MENTION_AT = 1;
	const MENTION_BBCODE = 2;
	const MENTION_BBCODE_TEXT = 3;
	/**
	 * End of constants
	 */

	/** @var \phpbb\db\driver\driver_interface */
	protected $db;

	/** @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\template\template */
	protected $template;

	/** @var \phpbb\controller\helper */
	protected $helper;

	/** @var \phpbb\user */
	protected $user;

	/** @var \phpbb\auth\auth */
	protected $auth;

	/** @var \phpbb\request\request */
	protected $request;

	/** @var \phpbb\event\dispatcher_interface */
	protected $dispatcher;

	/** @var \phpbb\path_helper */
	protected $path_helper;

	/** @var \phpbb\notification\manager */
	protected $notification_manager;

	/**
	 * An Array containing all users that could be mentioned.
	 * It is cached here for further use with this class.
	 * 
	 * @var array user data
	 */
	protected static $user_list;

	/**
	 * Constructor
	 *
	 * @param \phpbb\db\driver\driver_interface		$db				Database
	 * @param \phpbb\config\config					$config			Config helper
	 * @param \phpbb\template\template				$template		Template object
	 * @param \phpbb\user							$user			User object
	 * @param \phpbb\auth\auth						$auth			Auth object
	 * @param \phpbb\request\request				$request		Request object
	 * @param \phpbb\event\dispatcher_interface		$dispatcher		The dispatcher object
	 * @param \phpbb\path_helper					$path_helper	The path helper object
	 * @param \phpbb\notification\manager			$notification_manager	The notification manager object
	 */
	public function __construct(\phpbb\db\driver\driver_interface $db, \phpbb\config\config $config, \phpbb\template\template $template, \phpbb\controller\helper $helper, \phpbb\user $user, \phpbb\auth\auth $auth, \phpbb\request\request $request, \phpbb\event\dispatcher_interface $dispatcher, \phpbb\path_helper $path_helper, \phpbb\notification\manager $notification_manager)
	{
		$this->db = $db;
		$this->config = $config;
		$this->template = $template;
		$this->helper = $helper;
		$this->user = $user;
		$this->auth = $auth;
		$this->request = $request;
		$this->dispatcher = $dispatcher;
		$this->path_helper = $path_helper;
		$this->notification_manager = $notification_manager;

		$this->ext_root_path = 'ext/wolfsblvt/mentions';

		// Add language vars
		$this->user->add_lang_ext('wolfsblvt/mentions', 'mentions');
	}

	/**
	 * Adds the json data we need in javascript to the template
	 * 
	 * @param int $topic_id The topic id of the topic we are in
	 * @return void
	 */
	public function add_json_data_to_template($topic_id = false)
	{
		$javascript_vars = array(
			// General Information
			'ajax_path'						=> $this->helper->route('wolfsblvt_mentions_controller'),
			'searchKey'						=> 'name',
			'max_length'					=> $this->config['max_name_chars'],

			// ACP Settings
			'active_bbcode'					=> (bool)$this->config['wolfsblvt.mentions.active_bbcode'],
			'active_bbcode_text'			=> (bool)$this->config['wolfsblvt.mentions.active_bbcode_text'],
			'active_at'						=> (bool)$this->config['wolfsblvt.mentions.active_at'],
			'autocomplete_enabled'			=> (bool)$this->config['wolfsblvt.mentions.autocomplete_enabled'],
			'autocomplete_topic_posters'	=> (bool)$this->config['wolfsblvt.mentions.autocomplete_topic_posters'],
			'autocomplete_autoclose_bbcode'	=> (bool)$this->config['wolfsblvt.mentions.autocomplete_autoclose_bbcode'],
			'autocomplete_remote_load'		=> (bool)$this->config['wolfsblvt.mentions.autocomplete_remote_load'],
		);

		// Get posters in this topic, if required
		if ($topic_id && $this->config['wolfsblvt.mentions.autocomplete_topic_posters'])
		{
			// We need the revers order to have latest posters sorted on top
			$javascript_vars['poster_ids'] = $this->get_posters_of_topic($topic_id, true);
		}

		// Okay, lets push this information to the template
		$this->template->assign_vars(array(
			'MENTIONS_JSON_DATA'		=> 'var wolfsblvt_mentions_json_data = ' . json_encode($javascript_vars) . ';',
		));
	}

	/**
	 * Adds the notifications during submitting a post.
	 * We've rebuild the if/else switch/case constructs here the same way there are in
	 * submit_post() function, so we should achieve the same notifications as "notification.type.quote".
	 * 
	 * @param string $mode The mode of this submit
	 * @param int $post_visibility Post visibility state as number (see constants)
	 * @param string $username The real username for this post (including guest things)
	 * @param array $data The post data
	 * @param mixed $subject The real post subject
	 */
	public function submit_post_notifications($mode, $post_visibility, $username, $data, $subject)
	{
		$poster_id = ($mode == 'edit') ? $data['poster_id'] : (int) $this->user->data['user_id'];
		$current_time = ($data['post_time'] > 0) ? $data['post_time'] : time();

		// Send Notifications
		$notification_data = array_merge($data, array(
			'topic_title'		=> (isset($data['topic_title'])) ? $data['topic_title'] : $subject,
			'post_username'		=> $username,
			'poster_id'			=> $poster_id,
			'post_text'			=> $data['message'],
			'post_time'			=> $current_time,
			'post_subject'		=> $subject,
		));

		if ($post_visibility == ITEM_APPROVED)
		{
			switch ($mode)
			{
				case 'post':
				case 'reply':
				case 'quote':
					$this->notification_manager->add_notifications(array(
						'wolfsblvt.mentions.notification.type.mention',
					), $notification_data);
					break;

				case 'edit_topic':
				case 'edit_first_post':
				case 'edit':
				case 'edit_last_post':
					$this->notification_manager->update_notifications(array(
						'wolfsblvt.mentions.notification.type.mention',
					), $notification_data);
					break;
			}
		}
	}

	/**
	 * Identical portrayal of markread() function to handle the custom notification for mark reads.
	 * Most code is copy'n'pasted.
	 *
	 * @param string $mode (all, topics, topic, post)
	 * @param int|bool $forum_id Used in all, topics, and topic mode
	 * @param int|bool $topic_id Used in topic and post mode
	 * @param int $post_time 0 means current time(), otherwise to set a specific mark time
	 * @param int $user_id can only be used with $mode == 'post'
	 */
	public function markread_notifications($mode, $forum_id = false, $topic_id = false, $post_time = 0, $user_id = 0)
	{
		$post_time = ($post_time === 0 || $post_time > time()) ? time() : (int) $post_time;

		if ($mode == 'all')
		{
			if ($forum_id === false || !sizeof($forum_id))
			{
				// Mark all forums read (index page)
				// Mark all topic notifications read for this user
				$this->notification_manager->mark_notifications_read(array(
					'wolfsblvt.mentions.notification.type.mention',
				), false, $this->user->data['user_id'], $post_time);
			}
			else if ($mode == 'topics')
			{
				// Mark all topics in forums read
				if (!is_array($forum_id))
				{
					$forum_id = array($forum_id);
				}

				// Mark all mention notifications read for this user in this forum
				$topic_ids = array();
				$sql = 'SELECT topic_id
					FROM ' . TOPICS_TABLE . '
					WHERE ' . $this->db->sql_in_set('forum_id', $forum_id);
				$result = $this->db->sql_query($sql);
				while ($row = $this->db->sql_fetchrow($result))
				{
					$topic_ids[] = $row['topic_id'];
				}
				$this->db->sql_freeresult($result);

				$this->notification_manager->mark_notifications_read_by_parent(array(
					'wolfsblvt.mentions.notification.type.mention',
				), $topic_ids, $this->user->data['user_id'], $post_time);
			}
			else if ($mode == 'topic')
			{
				if ($topic_id === false || $forum_id === false)
				{
					return;
				}

				$this->notification_manager->mark_notifications_read_by_parent(array(
					'wolfsblvt.mentions.notification.type.mention',
				), $topic_id, $this->user->data['user_id'], $post_time);
			}
		}
	}

	/**
	 * Sends notifications for approved posts
	 * 
	 * @param array $post_info Array containing the post_info (post_id => post_id) that is approved
	 */
	public function approve_posts_notifications($post_info)
	{
		foreach ($post_info as $post_id => $post_data)
		{
			$this->notification_manager->add_notifications(array('wolfsblvt.mentions.notification.type.mention'), $post_data);

			$this->notification_manager->mark_notifications_read(array(
				'wolfsblvt.mentions.notification.type.mention',
			), $post_data['post_id'], $this->user->data['user_id']);
		}
	}

	/**
	 * Sends notifications for approved topics
	 * 
	 * @param array $topic_info Array containing the topic_info (topic_id => topic_data) that is approved
	 */
	public function approve_topics_notifications($topic_info)
	{
		foreach ($topic_info as $topic_id => $topic_data)
		{
			if ($topic_data['topic_visibility'] == ITEM_UNAPPROVED)
			{
				$this->notification_manager->add_notifications(array(
					'wolfsblvt.mentions.notification.type.mention',
				), $topic_data);
			}

			$this->notification_manager->mark_notifications_read('wolfsblvt.mentions.notification.type.mention', $topic_data['post_id'], $this->user->data['user_id']);
		}
	}

	/**
	 * Searches post text for all mentions and returns them as an array
	 * 
	 * Values of the array are the following:
	 *		'name'			Username
	 *		'user_id'		Users id
	 *		'posts'			Post count
	 *		'colour'		Color of username
	 *		'avatar'		User avatar as full html img element
	 *		'username_full'	Username as html element with color and link
	 *		'type'			Type of the mention
	 *		'start'			Startposition of the username inside the text
	 *		'end'			Endposition of the username inside the text
	 * 
	 * @param string $post_text The post text
	 * @param bool $sort_by_position_desc If the returned array should be sorted by position, descending
	 * @return array Array of all mentioned users and the start position of their name in text
	 */
	public function get_mentioned_users($post_text, $sort_by_position_desc = false)
	{
		$mentioned = array();

		$user_list = $this->get_userlist();

		// At first, the easy part. Let's get the one posted in [mention="{username}"]{text}[/mention]
		if ($this->config['wolfsblvt.mentions.active_bbcode_text'])
		{
			$regular_expression_match = '#\[mention=&quot;(.+?)&quot;\](.*?)\[/mention\]#';
			$matches = false;
			preg_match_all($regular_expression_match, $post_text, $matches, PREG_OFFSET_CAPTURE);

			for ($i = 0, $len = count($matches[1]); $i < $len; $i++)
			{
				$username_clean = utf8_clean_string($matches[1][$i][0]);
				if (array_key_exists($username_clean, $user_list))
				{
					$startpos = $matches[2][$i][1];
					$length = strlen($matches[2][$i][0]);
					$user_data = $user_list[$username_clean];

					$mentioned[] = array_merge($user_data, array(
						'type'			=> self::MENTION_BBCODE_TEXT,
						'start'			=> $startpos,
						'length'		=> $length,
					));
				}
			}
		}

		// Second we get the one posted in [mention]{username}[/mention]
		if ($this->config['wolfsblvt.mentions.active_bbcode'])
		{
			$regular_expression_match = '#\[mention\](.*?)\[/mention\]#';
			$matches = false;
			preg_match_all($regular_expression_match, $post_text, $matches, PREG_OFFSET_CAPTURE);

			for ($i = 0, $len = count($matches[1]); $i < $len; $i++)
			{
				$username_clean = utf8_clean_string($matches[1][$i][0]);
				if (array_key_exists($username_clean, $user_list))
				{
					$startpos = $matches[1][$i][1];
					$length = strlen($matches[1][$i][0]);
					$user_data = $user_list[$username_clean];

					$mentioned[] = array_merge($user_data, array(
						'type'			=> self::MENTION_BBCODE,
						'start'			=> $startpos,
						'length'		=> $length,
					));
				}
			}
		}

		// Now the difficult part. Let's see if we can get the correct usernames for the @{username} mentions
		if ($this->config['wolfsblvt.mentions.active_at']) // ACP config will come later
		{
			$regular_expression_match = '#(?:^|\\s)@(.+?)(?:\n|$)#';
			$matches = false;
			$offset = 0;
			$maximum_at_mentions = $this->config['wolfsblvt.mentions.maximum_at_mentions_per_post'];
			$at_mentions = 0;

			while (preg_match($regular_expression_match, $post_text, $matches, PREG_OFFSET_CAPTURE, $offset)
				&& ($maximum_at_mentions == 0 || $at_mentions < $maximum_at_mentions))
			{
				$line = utf8_clean_string($matches[1][0]);
				$search_string = substr($line, 0, $this->config['max_name_chars']);
				$matched_username = false;

				// We have the line behind the @ now, and search from the max length till min length of a username
				// if this is an existing username wich could be mentioned.
				$len = strlen($search_string);
				while ($len >= $this->config['min_name_chars'])
				{
					if(isset($user_list[$search_string]))
					{
						$matched_username = $search_string;
						break;
					}
					$search_string = substr($search_string, 0, -1);
					$len--;
				}

				// We can assume that $matched_username is the longest matching username we have found due to searching from longest name to shortest.
				// So we use it now as the only match (Even if there are maybe shorter usernames matching too. But this is nothing we can solve here,
				// This needs to be handled by the user, honestly. There is a autocomplete popup which tells the other, longer fitting name if the user is still typing,
				// and if he continues to enter the full name, I think it is okay to choose the longer name as the chosen one.)
				if ($matched_username)
				{
					$startpos = $matches[1][1];

					// We need to get the endpos, cause the username is cleaned and the real string might be longer
					$full_username = substr($post_text, $startpos, strlen($matched_username));
					while (utf8_clean_string($full_username) != $matched_username)
					{
						$full_username = substr($post_text, $startpos, strlen($full_username) + 1);
					}

					$user_data = $user_list[$matched_username];

					$mentioned[] = array_merge($user_data, array(
						'type'			=> self::MENTION_AT,
						'start'			=> $startpos,
						'length'		=> strlen($full_username),
					));
				}

				$offset = $matches[0][1] + (($matched_username) ? strlen($full_username) : 1);
				$at_mentions += 1;
			}
		}

		// Sort the array by descending position so that replacing can be done with correct position values
		if ($sort_by_position_desc)
		{
			usort($mentioned, function ($a, $b) {
				return $b['start'] - $a['start'];
			});
		}

		return $mentioned;
	}

	/**
	 * Get a list of all users on the board that can be mentioned. Keys are the usernames utf8_cleaned.
	 * Data is cached after the first call.
	 * 
	 * @param string|bool $query_string False, if all users should be retrieved. Otherwise a string wich should be searched for.
	 * @return array Array containing data of all users
	 */
	public function get_userlist($query_string = false)
	{
		// If we need the complete list and it is cached, we can return it.
		if ($query_string == false && self::$user_list)
		{
			return self::$user_list;
		}

		$cache_time = 300;

		$sql_ary = array(
			'SELECT'	=> '*',
			'FROM'		=> array(USERS_TABLE => 'u'),
			'WHERE'		=> 'user_posts >= ' . $this->config['wolfsblvt.mentions.min_posts_suggest'] . '
											AND user_type <> ' . USER_IGNORE,
			'ORDER_BY'	=> 'username',
		);

		if ($query_string)
		{
			$escaped_query_string_clean = $this->db->sql_escape(utf8_clean_string($query_string));
			$query_string['WHERE'] .= ' username_clean ' . $this->db->sql_like_expression($escaped_query_string_clean . $this->db->get_any_char());
		}

		$sql = $this->db->sql_build_query('SELECT', $sql_ary);
		$result = $this->db->sql_query($sql, $cache_time);

		$user_list = array();
		while ($row = $this->db->sql_fetchrow($result))
		{
			$user_data = array(
				'name'				=> $row['username'],
				'user_id'			=> $row['user_id'],
				'posts'				=> $row['user_posts'],
				'colour'			=> $row['user_colour'],
				'avatar'			=> phpbb_get_user_avatar($row),
				'username_full'		=> get_username_string('full', $row['user_id'], $row['username'], $row['user_colour']),
				'username_no_profile'	=> get_username_string('no_profile', $row['user_id'], $row['username'], $row['user_colour']),
			);

			if ($user_data['avatar'] == '')
			{
				$default_avatar_url = $this->path_helper->get_web_root_path() . $this->ext_root_path . '/styles/' . $this->user->style['style_path'] . '/theme' . '/images/no_avatar.gif';

				// Check if file exists, otherwise take from "/all" folder. The administrator hasn't chosen a specific no_avatar avatar for this style then
				if (!file_exists($default_avatar_url))
				{
					$default_avatar_url = $this->path_helper->get_web_root_path() . $this->ext_root_path . '/styles/all/theme' . '/images/no_avatar.gif';
				}

				$user_data['avatar'] = '<img src="' . $default_avatar_url . '" width="100" height="100" alt="' . $this->user->lang['USER_AVATAR'] . '">';
			}

			$user_list[$row['username_clean']] = $user_data;
		}
		$this->db->sql_freeresult($result);

		// If we have the complete list, we can cache it.
		if ($query_string == false)
		{
			self::$user_list = $user_list;
		}

		return $user_list;
	}

	/**
	 * Adds the given bbcodes to the list of existing core bbcodes right before the custom bbcodes, when listening to 'core.display_custom_bbcodes_modify_sql' event.
	 * $num_predefined_bbcodes is increased automatically.
	 * 
	 * @param array $bbcodes Assoziative array containing the name of the bbcode and the bbcode_tag of the bbcode to add. Helpline for the bbcode will be 'MENTIONS_BBCODENAME_HELPLINE'
	 * @param int $num_predefined_bbcodes Number of predefined bbcodes
	 * @return int Count of added bbcodes
	 */
	public function add_bbcodes_to_display($bbcodes, &$num_predefined_bbcodes)
	{
		foreach ($bbcodes as $bbcode_name => $bbcode_tag)
		{
			if ($bbcode_tag == false)
			{
				continue;
			}

			$bbcode_helpline = strtoupper($bbcode_name) . '_BBCODE_HELPLINE';
			$custom_tags = array(
				'BBCODE_NAME'		=> "'[{$bbcode_tag}]', '[/" . str_replace('=', '', $bbcode_tag) . "]'",
				'BBCODE_ID'			=> $num_predefined_bbcodes + 0,
				'BBCODE_TAG'		=> $bbcode_tag,
				'BBCODE_TAG_CLEAN'	=> str_replace(array('=', '_'), '-', $bbcode_name),
				'BBCODE_HELPLINE'	=> $this->user->lang[$bbcode_helpline],
				'A_BBCODE_HELPLINE'	=> str_replace(array('&amp;', '&quot;', "'", '&lt;', '&gt;'), array('&', '"', "\'", '<', '>'), $this->user->lang[$bbcode_helpline]),
			);
			$this->template->assign_block_vars('custom_tags', $custom_tags);

			$num_predefined_bbcodes += 2;
		}
	}

	/**
	 * Returns a list of all user ids of users who have posted in given topic
	 * 
	 * @param int $topic_id The id of the topic
	 * @param bool $look_for_last_post_time If true, user_ids are sorted from the last post timne of this user
	 * @return array List of user ids
	 */
	protected function get_posters_of_topic($topic_id, $look_for_last_post_time = false)
	{
		$sql_ary = array(
			'SELECT'	=> 'poster_id, ' . (($look_for_last_post_time) ? 'MAX(post_time)' : 'MIN(post_time)') . ' as relevant_time',
			'FROM'				=> array(
				USERS_TABLE => 'u',
				POSTS_TABLE => 'p',
			),
			'WHERE'				=> 'u.user_id = p.poster_id
										AND topic_id = ' . (int) $topic_id . '
										AND user_type <> ' . USER_IGNORE,
			'GROUP_BY'			=> 'poster_id',
			'ORDER_BY'			=> 'relevant_time ASC',
		);

		$sql = $this->db->sql_build_query('SELECT', $sql_ary);
		$result = $this->db->sql_query($sql);

		$poster_list = array();
		while ($row = $this->db->sql_fetchrow($result))
		{
			$poster_list[] = $row['poster_id'];
		}
		$this->db->sql_freeresult($result);

		return $poster_list;
	}
}
