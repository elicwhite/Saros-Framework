<?php
class Application_Main_Logic_Error extends Library_Core_Logic
{
	private $exception;
	public function setError(Library_Exception $exception)
	{
		$this->exception = $exception;
	}
	public function index()
	{
		$this->view->Exception = $this->exception;	
		$this->view->Traces = explode("\n",$this->exception->getTraceAsString());			
	}
}
?>