<?php
    require_once 'data/sqlite3.php';
    
    $dir_objects = "objects";
	$classes = scandir($dir_objects);
	foreach ($classes as $class)
	{
		if(preg_match("/.class.php$/is", $class))
		{
			require $dir_objects . "/" . $class;
		}
	}
    


?>