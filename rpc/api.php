<?php

$d = scandir('method');
foreach($d as $f)
{
    if(!is_dir('method/'.$f) && preg_match('/\.php$/', $f))
    require_once('method/'.$f);
}
    

?>