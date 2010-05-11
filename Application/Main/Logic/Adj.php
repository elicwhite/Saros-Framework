<?php
class Application_Main_Logic_Adj extends Library_Core_Logic
{
	public function index()
	{
	
		$db = $this->registry->db;	
		
		$test = $db->testAdj;
		
		$home = $test->get();
		$home->name = "Home";
		$test->save($home);
		
		$sports = $test->get();
		$sports->name = "Sports";
		$test->save($sports, $home);
		
		echo $sports->parent;
		
		$tools = $test->get();
		$tools->name = "Tools";
		$test->save($tools, $home, 0);
		
		
		$bball = $test->get();
		$bball->name = "Basket Ball";
		$test->save($bball, $sports);
		
		
		
	}
	public function working()
	{
		
		
		
	}
	
	public function setup()
	{
		$db = $this->registry->db;
		$test = $db->testAdj->migrate();
	}

}
?>