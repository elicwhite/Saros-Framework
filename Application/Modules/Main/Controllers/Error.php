<?php
class Application_Modules_Main_Controllers_Error extends Saros_Application_Controller
{
	private $exception;
	public function setError(Saros_Exception $exception)
	{
		$this->exception = $exception;
	}
	public function index()
	{
		$this->view->Exception = $this->exception;
		$this->view->Traces = explode("\n",$this->exception->getTraceAsString());
	}
}