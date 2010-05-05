<?php
class Application_Main_Logic_Mptt extends Library_Core_Logic
{
	public function index()
	{
	
		$db = $this->registry->db;	
		
		$test = $db->testMptt;
		
		$home = $test->get(2);
		
		$sports = $test->get();
		$sports->name = "Sports";
		$test->add($sports, $home);
				
		$clothing = $test->get();
		$clothing->name = "Clothing";
		$test->add($clothing, $home, 0);
		
		$bball = $test->get();
		$bball->name = "Basket Ball";
		$test->add($bball, $sports);
		
		$tools = $test->get();
		$tools->name = "Tools";
		$test->add($tools, $home, 1);
		
	}

}
?>