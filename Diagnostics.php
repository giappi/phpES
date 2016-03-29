<?php

    session_start();
    
	require('API.php');
    header("Content-Type: text/html; charset=utf-8");
	
?>

<?php
    /* GLOBALS */
    //Danh sách các triệu chứng, nạp từ CSDL
    $__nodes = Nodes::get(0, 200);
    //Danh sách các luật. nạp từ CSDL
    $__rules = Rules::getAll();
    //Dánh sách các bệnh, nạp từ CSDL
    $__node_targets = Nodes::getTarget(0, 200);
    //Danh sách các triệu chứng của các bệnh, nạp từ CSDL
    $__rule_targets = Rules::getTarget();
    
    
    // Bắt đầu lại phiên làm việc mới
    if($_GET['restart'])
    {
        $_SESSION['fw'] = null;
        $_SESSION['blacklist'] = null;
    }
    
    //Danh sách các bệnh rõ ràng không mắc phải, tạo mới nếu chưa có, truyền từ trang này sang trang khác
    if(!unserialize($_SESSION['blacklist']))
    {
        $__blacklist = new Set();
        $_SESSION['blacklist'] = serialize($__blacklist);
    }
    else
    {
        $__blacklist = unserialize($_SESSION['blacklist']);
    }
    
    //Bộ máy suy diễn tiến, truyền từ trang này sang trang khác
    if(!unserialize($_SESSION['fw']))
    {
        $__fw = new ForwardChanning(new Set(), new Node(-1), $__rules);
        $_SESSION['fw'] = serialize($__fw);
    }
    else
    {
        $__fw = unserialize($_SESSION['fw']);
    }

    

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
    
    $getted_blacknode = $_GET["blacknode"] ? $_GET["blacknode"] : null;
    if($getted_blacknode)
    {
        $__blacklist->add( Nodes::getNodeByID($getted_blacknode));
    }
    
    /**    **/
    
    $gt = $GT;// new Set( array( new Node(1, "a"), new Node(2, "b")));
    $kl = new Node(12, "m");
   
    //Submit form
    if($_POST["submit"])
    {
        //Create new
        $_SESSION['fw'] = null;
        $_SESSION['blacklist'] = null;
        $__fw = new ForwardChanning($gt, $kl, $__rules);
        $__blacklist = new Set();

    }

    
    /* Inference */
    $__fw->IsInferred();
    /* Lấy phần chung của tập "bệnh" và tập đã suy diễn được  */
    /* Set */ $result = $__node_targets->getIntersection($__fw->getInferred());
 
    //var_dump($__rule_targets);
    
    /* Find node to ask */
    /* int */ $max = 0;
    /* Rule */ $most_rule = null; // Luật nghi ngờ nhất
    foreach($__rule_targets as $rule)
    {
        //Không xét laautj này nếu như chứa trong danh sách đen
        if ($__blacklist->exists($rule->KetLuan))
        {
            continue;
        }
    //tìm phân chung của các triệu chứng đang có với các triệu chứng trong các bệnh
        $r = $rule->GiaThuyet->getIntersection($__fw->getInferred());
        $ratio = $r->count() / $rule->GiaThuyet->count();
        if($ratio > $max)
        {
            $max = $ratio;
            $most_rule = $rule;
        }
    }
    
    if($most_rule)
    {
        // Trừ đi những node đã biết giá trị trong luật này
        $unknown_nodes = $most_rule->GiaThuyet->subtract($__fw->getInferred());
    }


    // Lưu lại phiên làm việc, luôn luôn để ở cuối
    
    $_SESSION['blacklist'] = serialize($__blacklist);
    $_SESSION['fw'] = serialize($__fw);
    
    
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
        <link rel="stylesheet" href="web/css/common.css" />
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
        
        
        if($unknown_nodes)
        {
            echo "Không đủ triệu chứng để chuẩn đoán.<br />";
            echo "<b>Gợi ý một số triệu chứng:</b><br />";
            echo "<ul>";
            foreach($unknown_nodes as $node)
            {
?>
                <li>+ <a onclick="mySelect.addSelectedItem({id : '<?=$node->Id?>', text : '<?=$node->Text?>'});" href='#node<?=$node->Id?>'><?=$node?></a></li>
<?php
            }
            echo "</ul>";
            echo "<br />";
            echo "<a href='?blacknode=" .$most_rule->KetLuan->Id . "'>Tôi không có triệu chứng nào trong các triệu chứng trên ?</a><br/>";
        }
        else
        {
            if($__fw->getInferred()->count() > 0)
            {
                echo "Bệnh bạn mắc phải chưa có trong hệ thống";
            }
        }
    }
        
    foreach($result as $node)
    {
        echo "<b><font color='green'>Bạn bị $node .</font></b><br />";
    }
    //echo "<pre>" . Rules::getTarget() . "</pre>";

?>
    
    <br />
    <form method="post" action="<?= $_SERVER["PHP_SELF"] ?>">

        <div class="select_container" style="margin: 5px;" >
        Nhập các triệu chứng bệnh: <br />
        <select id="myid" placeholder="Hãy viết gì đó ..́" name="nodes[]" multiple >
<?php


    if($__fw->GT->count() < 1)
    {
?>
            <option value="-1" >Nhập các triệu chứng bệnh</option>
<?php
    }
    else
    {
        foreach ($__fw->getInferred() as $node)
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
        <div style="padding-top: 10px;">
        <input class="button button_dlg button_selected shadow" type="submit" name="submit" value="Chuẩn đoán" />
        </div>
        </div>

        </form>
        <br />
        <a class="" href="?restart=true" >Làm lại</a>
        <br />
        <br />
        <div id="console" >
        <b>Quá trình suy diễn:</b><br />
        <pre style="background: #FFEEEE; padding: 5px;"><?=$__fw ->log;?></pre>
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