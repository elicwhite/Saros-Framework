<?php
class Application_Main_Logic_Mptt extends Library_Core_Logic
{
	public function index()
	{
	
		$db = $this->registry->db;	
		
		$test = $db->testMptt;
		
		$home = $test->get();
		$home->name = "Home";
		$test->add($home);
		
		$sports = $test->get();
		$sports->name = "Sports";
		$test->add($sports, $home);
		
		echo $sports->parent;
		
		$tools = $test->get();
		$tools->name = "Tools";
		$test->add($tools, $home, 0);
		
		
		$bball = $test->get();
		$bball->name = "Basket Ball";
		$test->add($bball, $sports);
		
		
		
	}
	public function working()
	{
		
		
		
	}
	
	public function setup()
	{
		$db = $this->registry->db;
		$test = $db->testMptt->migrate();	
	}

}
?>