<?php
class Application_Modules_Main_Logic_AdjAuth extends Saros_Core_Logic
{
	private $test;

	protected function init()
	{
		$this->test = new Application_Mappers_Users($this->registry->dbAdapter);
	}

	public function index()
	{
		$this->view->showView(false);

	}
}