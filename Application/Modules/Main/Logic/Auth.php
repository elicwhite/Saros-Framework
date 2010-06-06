<?php
class Application_Modules_Main_Logic_Auth extends Saros_Core_Logic
{
	private $test;
	private $auth;

	protected function init()
	{
		$this->test = new Application_Mappers_Users($this->registry->dbAdapter);

		$this->auth = Saros_Auth::getInstance();

		$authAdapter = new Saros_Auth_Adapter_Spot($this->test, "username", "password");

		$this->auth->setAdapter($authAdapter);
	}

	public function indexAction()
	{
		$this->view->showView(false);
		//$this->test->migrate();

		$this->auth->getAdapter()->setCredential("Eli", "whee");

		//$result = $this->auth->authenticate();

		var_dump($this->auth->hasIdentity());
		//$this->auth->clearIdentity();
		//var_dump($result);


	}
}