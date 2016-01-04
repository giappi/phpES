<?php


    function loadClasses($dir)
    {
        $classes = scandir($dir);
        foreach ($classes as $class)
        {
            if(preg_match("/.class.php$/is", $class))
            {
                require_once $dir . "/" . $class;
                echo $dir . "/" . $class . " is loaded <br />";
            }
        }
    }
    
    require_once 'data/sqlite3.php';
    loadClasses("objects");
    loadClasses("data");
    

    


?>