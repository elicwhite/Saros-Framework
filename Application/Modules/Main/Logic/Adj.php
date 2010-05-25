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
		$home->name = "Node1";
		$this->test->save($home);

		$sports = $this->test->get();
		$sports->name = "Node2";
		$sports->tree_parent = $home->id;
		$this->test->save($sports);

        $path = $this->test->getPath($sports);
        foreach($path as $node)
        {
            echo $node->name." -> ";
        }

        /*
		$home = $this->test->get();
		$home->name = "Home";
		$this->test->save($home);


		$sports = $this->test->get();
		$sports->name = "Sports";
		$sports->tree_parent = $home->id;
		$this->test->save($sports);



		$tools = $this->test->get();
		$tools->name = "Tools";
		$tools->tree_parent = $home->id;
		$this->test->save($tools, 0);

		//echo "Parent of Tools is: ".$tools->parent->name."<br />";

		$bball = $this->test->get();
		$bball->name = "Basket Ball";
		$bball->tree_parent = $sports->id;
		$this->test->save($bball);

		/*
		echo "<br /><br />";
		echo "Children of Home<br />";

		foreach($home->children as $child)
			echo $child->name."<br />";

		$this->test->delete($sports, false);

		echo "<br />";
		foreach($home->children as $child)
			echo $child->name."<br />";

        $path = $this->test->getPath($bball);
        echo "Size of Path: ".count($path);
        echo "Path to basketball: <br />";
        foreach($path as $node)
        {
            echo $node->name." -> ";
        }
        */
		//echo "Path to BasketBall: ".print_r($this->test->getPath($bball), true);

	}
	public function path()
	{
        $this->view->showView(false);

        $coll = new Spot_Entity_Collection();
        $coll->add(new Spot_Entity(array("name" => "Obj 1")));
        $coll->add(new Spot_Entity(array("name" => "Obj 2")));
        $coll->add(new Spot_Entity(array("name" => "Obj 3")));
        $coll->add(new Spot_Entity(array("name" => "Obj 4")));

        $reversed = $coll->run("array_reverse");
        foreach($reversed as $node)
        {
            echo $node->name." -> ";
        }
	}

	public function setup()
	{
		$this->view->showView(false);
		//$this->test->dropDatasource();
        $this->test->migrate();
	}
}