
<?php

	require('API.php');
    header("Content-Type: text/html; charset=utf-8");
	
?>
<html>
    <head>
        <meta charset="utt-8" />
        <title>Chuyên gia chuẩn đoán bệnh</title>
        <link rel="stylesheet" href="web/css/common.css" />
    </head>
    <body>    
    <pre>
<?php


    $rules = Rules::getAll();

    //echo $rules;

    foreach($rules as $rule)
    {
        printf("%s<br />", $rule);
    }
    
    echo "<br />";
    var_dump($rules[0]->GiaThuyet->contains(new Set(array("b", "a"))));



?>
    </pre>
    <br />
    </body>
</html>
