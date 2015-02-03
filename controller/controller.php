<?php
/**
 * 
 * '@Mention System
 * 
 * @copyright (c) 2015 Wolfsblvt ( www.pinkes-forum.de )
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 * @author Clemens Husung (Wolfsblvt)
 */

namespace wolfsblvt\mentions\controller;

class controller
{
	/** @var \wolfsblvt\mentions\core\mentions */
	protected $mentions;

	/** @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\db\driver\driver_interface */
	protected $db;

	/** @var \phpbb\controller\helper */
	protected $helper;

	/** @var \phpbb\path_helper */
	protected $path_helper;

	/** @var \phpbb\request\request */
	protected $request;

	/** @var \phpbb\user */
	protected $user;

	/**
	* Constructor
	*
	* @param \wolfsblvt\mentions\core\mentions   $mentions       Mentions core object
	* @param \phpbb\config\db_text               $config_text    DB text object
	* @param \phpbb\db\driver\driver_interface   $db             Database object
	* @param \phpbb\controller\helper            $helper         Controller helper object
	* @param \phpbb\path_helper                  $path_helper    Path helper object
	* @param \phpbb\request\request              $request        Request object
	* @param \phpbb\user                         $user           User object
	* @return \wolfsblvt\mentions\controller\controller
	* @access public
	*/
	public function __construct(\wolfsblvt\mentions\core\mentions $mentions, \phpbb\config\config $config, \phpbb\db\driver\driver_interface $db, \phpbb\controller\helper $helper, \phpbb\path_helper $path_helper, \phpbb\request\request $request, \phpbb\user $user)
	{
		$this->mentions = $mentions;
		$this->config = $config;
		$this->db = $db;
		$this->helper = $helper;
		$this->path_helper = $path_helper;
		$this->request = $request;
		$this->user = $user;

		$this->ext_root_path = 'ext/wolfsblvt/mentions';
	}

	/**
	* Mentions controller accessed from the URL /mentions/user_list
	*
	* @return null
	* @access public
	*/
	public function get_userlist()
	{
		// Send a JSON response if an AJAX request was used
		if ($this->request->is_ajax())
		{
			// If we have a query_string, we just get those usernames
			$query_string = ($this->request->variable('term', '')) ? $this->request->variable('term', '') : false;

			$user_list = $this->mentions->get_userlist($query_string);
			$user_list = array_values($user_list);

			$json_response = new \phpbb\json_response;
			$json_response->send($user_list);
		}
	}
}
