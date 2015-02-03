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

class parser
{
	/** @var \wolfsblvt\mentions\core\mentions */
	protected $mentions;

	/** @var \phpbb\db\driver\driver_interface */
	protected $db;

	/** @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\template\template */
	protected $template;

	/** @var \phpbb\user */
	protected $user;

	/**
	 * Constructor
	 *
	 * @param \wolfsblvt\mentions\core\mentions		$mentions		Mentions core object
	 * @param \phpbb\db\driver\driver_interface		$db				Database
	 * @param \phpbb\config\config					$config			Config helper
	 * @param \phpbb\template\template				$template		Template object
	 * @param \phpbb\user							$user			User object
	 */
	public function __construct(\wolfsblvt\mentions\core\mentions $mentions, \phpbb\db\driver\driver_interface $db, \phpbb\config\config $config, \phpbb\template\template $template, \phpbb\user $user)
	{
		$this->mentions = $mentions;
		$this->db = $db;
		$this->config = $config;
		$this->template = $template;
		$this->user = $user;

		$this->ext_root_path = 'ext/wolfsblvt/mentions';
	}

	/**
	 * Replace all mentions inside of a text with full username_string and mention name
	 * 
	 * @param string $text the original text
	 * @return string the text with replaced mentions
	 */
	public function replace_mentions_for_display($text)
	{
		global $request;
		$is_debug = $request->variable('measure_time', 0);
		$start_time = time();

		$i = 0;

		if ($is_debug)
		{
			$start_text = $text;
		}

		for($i; $i < 100; $i++)
		{
			// Get mentioned users ordered by position descending, so that we can safely replace without conflict
			$mentions = $this->mentions->get_mentioned_users($text, true);

			foreach ($mentions as $id => $mention_data)
			{
				if ($is_debug)
				{
					$text = $start_text;
				}

				$replace_string = $mention_data['username_full'];

				// If we used a custom text for the mention, we take this as username
				if ($mention_data['type'] == mentions::MENTION_BBCODE_TEXT)
				{
					$written_username = htmlentities(substr($text, $mention_data['start'], $mention_data['length']));
					$replace_string = str_replace($mention_data['name'], $written_username, $replace_string);
				}

				// We add the username as title, so that we can see that someone is mentioned and who is mentioned on hover
				$a_title = htmlentities($this->user->lang['MENTIONS_MENTION'] . $this->user->lang['COLON'] . ' ' . $mention_data['name']);
				$replace_string = preg_replace('#<a#', "<a title=\"$a_title\"", $replace_string, 1);

				// Add image if it is enabled
				if ($this->config['wolfsblvt.mentions.image_inline'])
				{
					$img = "<div class=\"mentions-avatar mentions-avatar-inline\">" . $mention_data['avatar'] . '</div> ';
					$pos_end_of_a_tag = strpos($replace_string, '>') + 1;
					$replace_string = substr_replace($replace_string, $img, $pos_end_of_a_tag, 0);
				}

				// We should cut the bbcodes as well, so we have to look now how long they are
				$len_before = $len_after = 0;
				switch ($mention_data['type'])
				{
					case mentions::MENTION_AT:
						break;

					case mentions::MENTION_BBCODE:
						$len_before = strlen('[mention]');
						$len_after = strlen('[/mention]');
						break;

					case mentions::MENTION_BBCODE_TEXT:
						$len_before = strlen("[mention=&quot;{$mention_data['name']}&quot;]");
						$len_after = strlen('[/mention]');
				}

				$text = substr_replace($text, $replace_string, $mention_data['start'] - $len_before, $mention_data['length'] + $len_before + $len_after);
			}

			if ($is_debug)
			{
				// max 5 seconds for measuring
				if ((time() - $start_time) > 5)
				{
					$i++;
					break;
				}
			}
			else
			{
				$i++;
				break;
			}
		}

		if ($is_debug)
		{
			echo "Runtime of function ({$i}x): " . (time() - $start_time) . " seconds. Average: " . (floatval(time() - $start_time) / $i) . " seconds.<br />";
		}

		return $text;
	}
}
