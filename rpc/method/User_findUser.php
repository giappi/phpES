<?php

function User_findUser($params=null)
{

    $from = $params['from'] ? $params['from'] : '0';
    $count = $params['count'] ? $params['count'] : '10';
    $keyword = $params['keyword'];
    $trangthai = $params['trangthai'];
    
    return find_user($keyword, $from, $trangthai);
}

?>