<?php

	require('API.php');
    header("Content-Type: text/html; charset=utf-8");
	
?>

<?php
    /* GLOBALS */
    $__nodes = Nodes::get("0", "100");

?>

<?php
    /* POSTED DATA */
    // get list of node that user post
    $posted_nodes = $_POST["nodes"] ? $_POST["nodes"] : array();
    
    var_dump($posted_nodes);
    
    

?>

<!DOCTYPE html>
<html>
    <head>
        <title>TODO supply a title</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width">
        <script type="text/javascript" src="web/js/gSelect.js" ></script>
        <script type="text/javascript" src="web/js/jquery/jquery.js" ></script>
        <script type="text/javascript" src="web/js/API.js" ></script>       
        <link rel="stylesheet" href="web/css/gSelect.css" />
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
    <h1>gSelect</h1>
    <form method="post" action="">

        <div class="select_container" >
        Multiple Select: <br />
        <select id="myid" placeholder="Hãy viết gì đó ..́" name="nodes[]" multiple >
          <option value="" >Nhập các triệu chứng bệnh</option>
        </select>
        </div>
        <input type="submit" />
        <br />
        </form>
        <br />
        
        <script>
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