<?php

	require('API.php');
    header("Content-Type: text/html; charset=utf-8");
	
?>
<?php



//load classes

    function loadClasses($dir)
    {
        $classes = scandir($dir);
        //echo "<div class='console'>";
        foreach ($classes as $class)
        {
            if(preg_match("/.class.php$/is", $class))
            {
                require_once $dir . "/" . $class;
                //echo "<small><b>" . $dir . "/" . $class . "</b><span class='description'> is loaded.</span></small><br />";
            }
        }
        //echo "</div>";
    }
    
    require_once '../data/sqlite3.php';
    loadClasses("../objects");
    loadClasses("../data");
    loadClasses("../engine");

    Database::$location = "../he_chuyen_gia.sqlite";


require_once('api.php');



function c($s)
{
    return str_replace('.', '_', $s);
}

function jd($json)
{
    return json_decode($json, true);
}



if ($_POST['json'])
{
    //echo $json;
    $json = stripslashes($_POST['json']);

}
else
{
    $json = $HTTP_RAW_POST_DATA;
}

$djson = json_decode($json, true);



function responde($id, $method, $params)
{
    $responde = Array(
                    "jsonrpc" => "1.2.1",
                    "id" => $id,
                    "result" => $method($params)
    
    );
    return $responde;
}




if($json)
{
    $respondes = Array();
    for( $i = 0; $i < count($djson); $i++)
    {
       $id = $djson[$i]['id'];

       $method = $djson[$i]['method'];
       //require_once('method/'.c($method).'.php');
       
       $params = $djson[$i]['params'];
       //print_r($params);
      $respones[] = responde($id, c($method), $params);
    }
    
    header("Content-Type: text/plain; charset=utf-8");
    echo json_encode($respones);
}
else
{
?>
<form method="post" action="clientApi.php">
    <textarea cols="100" rows="20" name="json">
[
    {
        "id" : 0,
        "method" : "Nodes.find",
        "params" : {"keyword": ""}
    }
]
</textarea>
<br />
<input type="submit" />
</form>
<?php
}

?>