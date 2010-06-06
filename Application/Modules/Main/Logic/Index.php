<?php
class Application_Modules_Main_Logic_Index extends Saros_Core_Logic
{
	public function indexAction()
	{
		$this->view->Version = Saros_Version::getVersion();

	}

	public function formAction()
	{
		$form = new Application_Modules_Main_Forms_Test();

		// If the form was posted
		if($_SERVER['REQUEST_METHOD'] == "POST" && $form->validate())
		{
			// The form is valid, do actions!
			echo "the form is valid";
		}

		$this->view->form = $form;
	}
}