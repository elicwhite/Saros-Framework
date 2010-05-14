<?php
/**
 * Copyright Eli White & SaroSoftware 2010
 * Last Modified: 3/26/2010
 * 
 * This file is part of Saros Framework.
 * 
 * Saros Framework is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * Saros Framework is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with Saros Framework.  If not, see <http://www.gnu.org/licenses/>.
 * 
 * This is the base class for all logic pages
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

	/**
	 * All logic controllers have to contain an index method
	 */
	abstract public function index();
}

?>