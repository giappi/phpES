<?php


function Message_sendMessage($params=null)
{
    /*
     * Conversation: conversation
     * Message: message
     */
    $conv_id = $params['conversation'];
    $message = $params['message'];
    
    
    
    $result = Array();
    
    $u = new User( Client::getUserName());

    if($conv_id)
    {
        
        if(trim($message) != '')
        {
            
                $result[] = $u ->sendMessage($params);

        }
            
            
    }
    
    return $result;

    
    
}

?>