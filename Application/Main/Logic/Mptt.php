<?php
class Application_Main_Logic_Mptt extends Saros_Core_Logic
{
	public function index()
	{

		$this->view->showView(false);

        $adapter = new Spot_Adapter_Mysql();
        $test = new Application_Mappers_TestMptt($adapter);

		$home = $test->get();
		$home->name = "Home";
		$test->add($home);

		$sports = $test->get();
		$sports->name = "Sports";
		$sports->mptt_parent = $home->id;
		$test->add($sports);

		echo $sports->parent;

		$tools = $test->get();
		$tools->name = "Tools";
		$tools->mptt_parent = $home->id;
		$test->add($tools, 0);


		$bball = $test->get();
		$bball->name = "Basket Ball";
		$bball->mptt_parent = $sports->id;
		$test->add($bball);



	}
	public function working()
	{



	}

	public function setup()
	{
		$this->view->showView(false);

        $adapter = new Spot_Adapter_Mysql();
        $test = new Application_Mappers_TestMptt($adapter);

        $test->migrate();
	}

}
?>