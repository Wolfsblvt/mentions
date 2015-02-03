<?php
/**
 * 
 * '@Mention System
 * 
 * @copyright (c) 2015 Wolfsblvt ( www.pinkes-forum.de )
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 * @author Clemens Husung (Wolfsblvt)
 */

namespace wolfsblvt\mentions\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Event listener
 */
class listener implements EventSubscriberInterface
{
	/** @var \wolfsblvt\mentions\core\mentions */
	protected $mentions;

	/** @var \wolfsblvt\mentions\core\parser */
	protected $parser;

	/** @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\path_helper */
	protected $path_helper;

	/** @var \phpbb\template\template */
	protected $template;

	/** @var \phpbb\user */
	protected $user;

	/**
	 * Constructor of event listener
	 *
	 * @param \wolfsblvt\mentions\core\mentions		$mentions		Mentions core object
	 * @param \wolfsblvt\mentions\core\parser		$parser			Mentions parser for bbcodes
	 * @param \phpbb\config\config					$config			Config helper
	 * @param \phpbb\path_helper					$path_helper	phpBB path helper
	 * @param \phpbb\template\template				$template		Template object
	 * @param \phpbb\user							$user			User object
	 */
	public function __construct(\wolfsblvt\mentions\core\mentions $mentions, \wolfsblvt\mentions\core\parser $parser, \phpbb\config\config $config, \phpbb\path_helper $path_helper, \phpbb\template\template $template, \phpbb\user $user)
	{
		$this->mentions = $mentions;
		$this->parser = $parser;
		$this->config = $config;
		$this->path_helper = $path_helper;
		$this->template = $template;
		$this->user = $user;

		$this->ext_root_path = 'ext/wolfsblvt/mentions';
	}

	/**
	 * Assign functions defined in this class to event listeners in the core
	 *
	 * @return array
	 */
	static public function getSubscribedEvents()
	{
		return array(
			// General stuff
			'core.page_header'								=> 'assign_template_vars',
			'core.posting_modify_template_vars'				=> 'add_json_data',

			// Handling notifications
			'core.submit_post_end'							=> 'submit_post_notifications',
			'core.markread_before'							=> 'markread_notifications',
			'core.delete_posts_before'						=> 'delete_posts_notifications',
			'core.approve_posts_after'						=> 'approve_posts_notifications',
			'core.approve_topics_after'						=> 'approve_topics_notifications',

			// Message parsing
			'core.modify_text_for_display_before'			=> 'replace_mentions_for_display',
			'core.modify_text_for_display_before'			=> 'replace_mentions_for_display',

			// Display of custom BBCodes
			'core.display_custom_bbcodes_modify_sql'		=> 'custom_bbcodes_display',
			'core.acp_bbcodes_modify_create'				=> 'forbid_name_of_mention_bbcode',
		);
	}

	/**
	 * Adds the json data we need to the template
	 * 
	 * @param object $event The event object
	 * @return void
	 */
	public function add_json_data($event)
	{
		$this->mentions->add_json_data_to_template($event['topic_id']);
	}

	/**
	 * Adds the notifications during submitting a post
	 * 
	 * @param object $event The event object
	 * @return void
	 */
	public function submit_post_notifications($event)
	{
		$mode = $event['mode'];
		$data = $event['data'];

		$this->mentions->submit_post_notifications($mode, $event['post_visibility'], $event['username'], $data, $event['subject']);
	}

	/**
	 * Marks notifications as read when a parent (topic, post, forum) is marked as read.
	 * 
	 * @param object $event The event object
	 * @return void
	 */
	public function markread_notifications($event)
	{
		$this->mentions->markread_notifications($event['mode'], $event['forum_id'], $event['topic_id'], $event['post_time'], $event['user_id']);
	}

	/**
	 * Deletes the notification when post is deleted
	 * 
	 * @param object $event The event object
	 * @return void
	 */
	public function delete_posts_notifications($event)
	{
		$delete_notifications_types = $event['delete_notifications_types'];
		$delete_notifications_types = array_merge($delete_notifications_types, array(
			'wolfsblvt.mentions.notification.type.mention'
		));
		$event['delete_notifications_types'] = $delete_notifications_types;
	}

	/**
	 * Adds the notifications during post approval
	 * 
	 * @param object $event The event object
	 * @return void
	 */
	public function approve_posts_notifications($event)
	{
		if ($event['action'] == 'approve')
		{
			$this->mentions->approve_posts_notifications($event['post_info']);
		}
	}

	/**
	 * Adds the notifications during topic approval
	 * 
	 * @param object $event The event object
	 * @return void
	 */
	public function approve_topics_notifications($event)
	{
		if ($event['action'] == 'approve')
		{
			$this->mentions->approve_topics_notifications($event['topic_info']);
		}
	}

	/**
	 * Replaces all mentions in a post with the correct username link.
	 * 
	 * @param object $event The event object
	 * @return void
	 */
	public function replace_mentions_for_display($event)
	{
		if ($this->config['wolfsblvt.mentions.replace_in_text'])
		{
			$text = $this->parser->replace_mentions_for_display($event['text']);
			$event['text'] = $text;
		}
	}

	/**
	 * Add the mention bbcode to the custom bbcodes of bbcode box for posts.
	 * 
	 * @param object $event The event object
	 * @return void
	 */
	public function custom_bbcodes_display($event)
	{
		$num_predefined_bbcodes = $event['num_predefined_bbcodes'];
		$bbcodes = array(
			'mention'			=> ($this->config['wolfsblvt.mentions.active_bbcode']) ? 'mention' : false,
			'mention_text'		=> ($this->config['wolfsblvt.mentions.active_bbcode_text']) ? 'mention=' : false,
		);

		$this->mentions->add_bbcodes_to_display($bbcodes, $num_predefined_bbcodes);

		// We have more bbcodes that does not count as a custom bbcode, take the increased number
		$event['num_predefined_bbcodes'] = $num_predefined_bbcodes;
	}

	/**
	 * Prevents user creating a custom bbcode with 'mention' or 'mention='
	 * 
	 * @param object $event The event object
	 * @return void
	 */
	public function forbid_name_of_mention_bbcode($event)
	{
		$hard_coded = array('mention', 'mention=');
		$bbcode_tag = preg_replace('/.*?\[([a-z0-9_-]+=?).*/i', '$1', $event['bbcode_match']);

		// Similar to check in acp_bbcodes.php we need to check if we have no conflict with our new tags
		if (in_array(strtolower($bbcode_tag), $hard_coded) || (preg_match('#\[/([^[]*)]$#', $event['bbcode_match'], $regs) && in_array(strtolower($regs[1]), $hard_coded)))
		{
			// Helper does not work here in ACP, dunno why.
			//$this->helper->error($this->user->lang['BBCODE_INVALID_TAG_NAME']);
			trigger_error($this->user->lang['BBCODE_INVALID_TAG_NAME'], E_USER_WARNING);
		}
	}

	/**
	 * Assigns the global template vars
	 * 
	 * @return void
	 */
	public function assign_template_vars()
	{
		$this->template->assign_vars(array(
			'T_EXT_MENTIONS_PATH'				=> $this->path_helper->get_web_root_path() . $this->ext_root_path,
			'T_EXT_MENTIONS_THEME_PATH'			=> $this->path_helper->get_web_root_path() . $this->ext_root_path . '/styles/' . $this->user->style['style_path'] . '/theme',
		));
	}
}
