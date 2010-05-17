<?php
class Application_Modules_Main_Logic_Adj extends Saros_Core_Logic
{
	private $test;

	protected function init()
	{
		$this->test = new Application_Mappers_TestAdj($this->registry->dbAdapter);
	}

	public function index()
	{
		$this->view->showView(false);
        $this->test->truncateDatasource();

		$home = $this->test->get();
		$home->name = "Home";
		$this->test->add($home);

		$sports = $this->test->get();
		$sports->name = "Sports";
		$sports->adj_parent = $home->id;
		$this->test->add($sports);

		$tools = $this->test->get();
		$tools->name = "Tools";
		$tools->adj_parent = $home->id;
		$this->test->add($tools, 0);

		$bball = $this->test->get();
		$bball->name = "Basket Ball";
		$bball->adj_parent = $sports->id;
		$this->test->add($bball);

	}
	public function working()
	{

	}

	public function setup()
	{
		$this->view->showView(false);
        $this->test->migrate();
	}

}
?>