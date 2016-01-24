
<?php

	require('API.php');
    header("Content-Type: text/html; charset=utf-8");
	
?>
<pre>

<?php


$rules = Rules::getAll();

//echo $rules;

foreach($rules as $rule)
{
    echo $rule . "<br />";
}



?>
</pre>
<br />
