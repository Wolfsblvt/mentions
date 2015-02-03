<?php
/**
 * 
 * '@Mention System
 * 
 * @copyright (c) 2015 Wolfsblvt ( www.pinkes-forum.de )
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 * @author Clemens Husung (Wolfsblvt)
 */

namespace wolfsblvt\mentions\migrations;

class v1_0_0_configs extends \phpbb\db\migration\migration
{
	public function update_data()
	{
		return array(
			// General settings
			array('config.add', array('wolfsblvt.mentions.active_bbcode',					true)),
			array('config.add', array('wolfsblvt.mentions.active_bbcode_text',				true)),
			array('config.add', array('wolfsblvt.mentions.active_at',						true)),
			array('config.add', array('wolfsblvt.mentions.replace_in_text',					true)),
			array('config.add', array('wolfsblvt.mentions.image_inline',					true)),

			// Autocomplete settings
			array('config.add', array('wolfsblvt.mentions.autocomplete_enabled',			true)),
			array('config.add', array('wolfsblvt.mentions.autocomplete_topic_posters',		true)),
			array('config.add', array('wolfsblvt.mentions.autocomplete_autoclose_bbcode',	true)),

			// Load settings
			array('config.add', array('wolfsblvt.mentions.min_posts_suggest',				0)),
			array('config.add', array('wolfsblvt.mentions.maximum_at_mentions_per_post',	50)),
			array('config.add', array('wolfsblvt.mentions.autocomplete_remote_load',		false)),
		);
	}
}
