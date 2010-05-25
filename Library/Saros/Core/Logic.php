<?php
/**
 * This is the base class for all logic pages
 *
 * @copyright Eli White & SaroSoftware 2010
 * @license http://www.gnu.org/licenses/gpl.html GNU GPL
 *
 * @package SarosFramework
 * @author Eli White
 * @link http://sarosoftware.com
 * @link http://github.com/TheSavior/Saros-Framework
 */
abstract Class Saros_Core_Logic
{
	// Registry Instance
	protected $registry;

	// The view for our controller
	protected $view;

	// Params from the URL
	protected $params;

	function __construct($registry)
	{
		$this->registry = $registry;

		// Call our init hook
		$this->init();
	}

	/**
	* This function is called right when the
	* logic file is created. This can be used
	* to set up refrences and instances used throughout
	* the logic file
	*
	*/
	protected function init()
	{
	}

	// Set the view
	public function setView($view)
	{
		$this->view = $view;
	}

	public function setParams($params)
	{
		$this->params = $params;
	}
	public function getParam($param)
	{
		if (array_key_exists($param, $this->params))
			return $this->params[$param];

		return null;
	}
}