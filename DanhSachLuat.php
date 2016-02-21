
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
    //var_dump($rules[0]->GiaThuyet->contains(new Set(array("b", "a"))));
    //var_dump($rules[0]->GiaThuyet->contains(new Set(array( new Node(1, "a"), new Node(2, "b")))));
    
    echo "<br />";
    $gt = new Set( array( new Node(1, "a"), new Node(2, "b")));
    $kl = new Node(12, "m");
    $tw = new ForwardChanning($gt, $kl, $rules);

    var_dump($tw->IsInferred());



?>
    </pre>
    <br />
    </body>
</html>
