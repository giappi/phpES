<?php

    session_start();
    
	require('API.php');
    header("Content-Type: text/html; charset=utf-8");
	
?>

<?php
    /* GLOBALS */
    $__nodes = Nodes::get(0, 200);
    $__rules = Rules::getAll();
    $__target = Nodes::getTarget(0, 200);

?>

<?php
    /* POSTED DATA */
    // get list of node that user post

    $posted_nodes = $_POST["nodes"] ? $_POST["nodes"] : array();
    
    $GT = new Set();
    foreach($posted_nodes as $e)
    {
        $GT->add( Nodes::getNodeByID($e));
    }
    
    /**    **/
    
    $gt = $GT;// new Set( array( new Node(1, "a"), new Node(2, "b")));
    $kl = new Node(12, "m");
   
    //Submit form
    if($_POST["submit"])
    {
        //Create new
        $fw = new ForwardChanning($gt, $kl, $__rules);
        $_SESSION['fw'] = serialize($fw);
    }
    else
    {
        //Transfer session pass web pages
        if(!unserialize($_SESSION['fw']))
        {
            $fw = new ForwardChanning($gt, $kl, $__rules);
            $_SESSION['fw'] = serialize($fw);
        }
        else
        {
            $fw = unserialize($_SESSION['fw']);
        }
    }
    
    /* Inference */
    $fw->IsInferred();
    /* Set */ $result = $__target->getIntersection($fw->getInferred());
 
    //Find node to ask
    $max = 0;
    foreach($__target as $node)
    {
        //$common = 
    }

            

    
    

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Chuyên gia chuẩn đoán bệnh</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width">
        <script type="text/javascript" src="web/js/gSelect.js" ></script>
        <script type="text/javascript" src="web/js/jquery/jquery.js" ></script>
        <script type="text/javascript" src="web/js/API.js" ></script>       
        <link rel="stylesheet" href="web/css/gSelect.css" />
        <link rel="stylesheet" href="web/css/gui.css" />
        <style>
            body
            {
                padding: 5px;
            }
            .select_container
            {
                border: 1px #ff0000 dotted;
                padding: 5px;
            }
        </style>
    </head>
    <body>
    <h1>Chuyên gia chuẩn đoán bệnh</h1>
    
<?php
    if($result->count() < 1)
    {
        echo "Không đủ triệu chứng để chuẩn đoán. Hoặc bệnh bạn mắc phải chưa có trong hệ thống.<br />";
    }
        
    foreach($result as $node)
    {
        $fw->KL = $node;
        echo "<b>Bạn bị $node .</b><br />";
    }
        
?>
    
    <br />
    <form method="post" action="">

        <div class="select_container" style="margin: 5px;" >
        Nhập các triệu chứng bệnh: <br />
        <select id="myid" placeholder="Hãy viết gì đó ..́" name="nodes[]" multiple >
<?php


    if($fw->GT->count() < 1)
    {
?>
            <option value="-1" >Nhập các triệu chứng bệnh</option>
<?php
    }
    else
    {
        foreach ($fw->getInferred() as $node)
        {
            if($node->Id > -1)
            {
            ?>
            <option selected="selected" value="<?=$node->Id?>"><?=$node->Text?></option>
            <?php
            }
        }
    }
 
?>
  
        </select>
        </div>
        <input class="button button_dlg button_selected shadow" type="submit" name="submit" value="Chuẩn đoán" />
        <br />
        </form>
        <br />
        
        <div id="console" >
        <b>Quá trình suy diễn:</b><br />
        <pre style="background: #FFEEEE; padding: 5px;"><?=$fw ->log;?></pre>
        </div>
        
        
        <script type="text/javascript">
            window.onload = function()
            {
                
                mySelect = new gSelect();
                mySelect.replaceById("myid");
                //Set false to custom search
                mySelect.setEnableSearch(false);
                mySelect.setOnTextChanged(function()
                {
                    postClientApi("Nodes.find", {"keyword" : mySelect.getSearchText()},
                        (json)=>
                        {
                            var a = JSON.parse(json)[0].result;
                            mySelect.setData(a);
                        }, () => {alert("Search error !");});
                });
                
            };
        </script>
    </body>
</html>