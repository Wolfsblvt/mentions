<?php
/**
 * 
 * '@Mention System
 * 
 * @copyright (c) 2015 Wolfsblvt ( www.pinkes-forum.de )
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 * @author Clemens Husung (Wolfsblvt)
 */

namespace wolfsblvt\mentions\acp;

class mentions_info
{
	function module()
	{
		return array(
			'filename'	=> '\wolfsblvt\mentions\acp\mentions_module',
			'title'		=> 'MENTIONS_TITLE_ACP',
			'modes'		=> array(
				'settings'	=> array('title' => 'MENTIONS_SETTINGS_ACP', 'auth' => 'ext_wolfsblvt/mentions && acl_a_board', 'cat' => array('MENTIONS_TITLE_ACP')),
			),
		);
	}
}
