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
		$this->test->save($home);

		echo "Num Parents: ".count($home->parent);

		/*
		$sports = $this->test->get();
		$sports->name = "Sports";
		$sports->tree_parent = $home->id;
		$this->test->save($sports);


		$tools = $this->test->get();
		$tools->name = "Tools";
		$tools->tree_parent = $home->id;
		$this->test->save($tools, 0);

		echo "Parent of Tools is: ".$tools->parent->name."<br />";

		$bball = $this->test->get();
		$bball->name = "Basket Ball";
		$bball->tree_parent = $sports->id;
		$this->test->save($bball);

		echo "<br /><br />";
		echo "Children of Home<br />";

		foreach($home->children as $child)
			echo $child->name."<br />";

		$this->test->delete($sports, true);

		echo "<br />";
		foreach($home->children as $child)
			echo $child->name."<br />";
*/


	}
	public function working()
	{

	}

	public function setup()
	{
		$this->view->showView(false);
		//$this->test->dropDatasource();
        $this->test->migrate();
	}

}
?>