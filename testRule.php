<?php

	require('API.php');
    header("Content-Type: text/html; charset=utf-8");
	
?>
<pre>

<?php

$gt = new Set(array(new Node(1, "a"), new Node(2, "b")));
$kl = new Node(3, "c");
$rule = new Rule($gt, $kl);
var_dump($rule);
echo $rule;

echo "<br />";
echo "<br />";

$rule1 = Rules::getById(2);
echo $rule1;


?>
</pre>
<br />
