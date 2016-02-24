<?php


function Conversation_getConversation($params=null)
{

    $from = $params['from'] ? $params['from'] : '0';
    $count = $params['count'] ? $params['count'] : '10';
    
    
    $result = Array();
    
    $_userName = Client::getUserName();
    $_account = new Account($_userName);
    if( $_account ->isLoggedIn())
    {
        return $_account -> user -> getConversation($from, $count);
    }
    else
    {
        return Array();
    }

    
    
}

?>