
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
    echo $rules->get(6)->GiaThuyet;



?>
    </pre>
    <br />
    </body>
</html>
