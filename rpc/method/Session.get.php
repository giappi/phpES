<?php
function Session_get($params=null)
{
    
    $result = Array();
    
    $_userName = Client::getUserName();
    $_account = new Account($_userName);
    
    if( $_account ->isLoggedIn())
    {
        return Session::get($params);
    }
    else
    {
        return Array();
    } 
}

?>