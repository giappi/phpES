<?php

function User_getFriendList($params=null)
{
    return getFriendList(  Client::getUserName() );
}
