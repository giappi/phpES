<?php
function Session_delete($params=null)
{
    
    $result = Array();
    
    $_userName = Client::getUserName();
    $_account = new Account($_userName);
    
    if( $_account ->isLoggedIn())
    {
        return Session::delete($params);
    }
    else
    {
        return Array();
    } 
}

?>