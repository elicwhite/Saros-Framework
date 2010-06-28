<?php
class Application_Modules_Main_Controllers_Auth extends Saros_Core_Controller
{
	private $test;
	private $auth;

	protected function init()
	{
		$this->test = new Application_Mappers_Users($this->registry->dbAdapter);
		$this->test->migrate();
		$this->test->truncateDatasource();

		$user = $this->test->get();
		$user->username = "Eli";
		$user->salt = "3aca";
		$user->password = sha1($user->salt."whee");
		$this->test->save($user);

		$this->auth = Saros_Auth::getInstance();

		$authAdapter = new Application_Classes_Auth_Adapter_Spot($this->test, "username", "password", "salt");

		$this->auth->setAdapter($authAdapter);
	}

	public function indexAction()
	{
		$this->view->showView(false);
		//$this->test->migrate();

		$this->auth->getAdapter()->setCredential("Eli", "whee");

		$result = $this->auth->authenticate();

		var_dump($this->auth->hasIdentity());
		//$this->auth->clearIdentity();
		//var_dump($result);


	}
}