<?php
class Application_Main_Logic_Adj extends Saros_Core_Logic
{
	public function index()
	{
		$this->view->showView(false);

		//echo "hello";

        $adapter = new Spot_Adapter_Mysql();
        $test = new Application_Mappers_TestAdj($adapter);

        $test->truncateDatasource();

		$home = $test->get();
		$home->name = "Home";
		$test->add($home);

		$sports = $test->get();
		$sports->name = "Sports";
		$sports->adj_parent = $home->id;
		$test->add($sports);

		$tools = $test->get();
		$tools->name = "Tools";
		$tools->adj_parent = $home->id;
		$test->add($tools, 0);

		$bball = $test->get();
		$bball->name = "Basket Ball";
		$bball->adj_parent = $sports->id;
		$test->add($bball);

	}
	public function working()
	{



	}

	public function setup()
	{
		$this->view->showView(false);
		$adapter = new Spot_Adapter_Mysql('mysql1038.servage.net', 'sarosframework', 'sarosframework', 'framework_');
        $test = new Application_Mappers_TestAdj($adapter);
        $test->migrate();
	}

}
?>