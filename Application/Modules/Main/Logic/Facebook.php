<?php
class Application_Modules_Main_Controllers_Facebook extends Saros_Core_Controller
{
	private $facebook;

	protected function init()
	{
		/*
		Application ID	1079899225
		API Key			3f21bfe5ab4fb4bd8c0ec93b83748e96
		Secret			3ac90f12793a69a9002392152007599e
		*/
		//$this->test = new Application_Mappers_TestAdj($this->registry->dbAdapter);
		$this->facebook = new Saros_Facebook_Api
			(
				array
				(
					'appId' => '107989922580485',
					'secret' => '3ac90f12793a69a9002392152007599e',
					'cookie' => true,
				)
			);
	}

	public function index()
	{
		$this->view->showView(false);

		if ($this->facebook->getSession())
		{
	  		$me = $this->facebook->api('/me');
	  		echo "Welcome ".$me["name"]."<br />";

			echo '<a href="' . $this->facebook->getLogoutUrl() . '">Logout</a>';
		}
		else
		{
			echo '<a href="' . $this->facebook->getLoginUrl() . '">Login</a>';
		}


	}
	public function checkStatus()
	{
		$this->view->showView(false);
		if ($this->facebook->getUser())
			echo "yes";
		else
			echo "no";
	}
}