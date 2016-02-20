<?php


    function loadClasses($dir)
    {
        $classes = scandir($dir);
        echo "<div class='console'>";
        foreach ($classes as $class)
        {
            if(preg_match("/.class.php$/is", $class))
            {
                require_once $dir . "/" . $class;
                echo "<small><b>" . $dir . "/" . $class . "</b><span class='description'> is loaded.</span></small><br />";
            }
        }
        echo "</div>";
    }
    
    require_once 'data/sqlite3.php';
    loadClasses("objects");
    loadClasses("data");
    

  

?>