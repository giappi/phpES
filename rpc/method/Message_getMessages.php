<?php

function Message_getMessages($params=null)
{
    $conv_id = $params['conversation'];
    $new = $params['new'];
    
    $conv = new Conversation();
    $conv -> conversation_id = $conv_id;
    if($new == true)
    {
        $u = new User( Client::getUserName());
        $db = new Database();
        $db ->open();
        
        //Lay data
        $data = $db ->get("SELECT sukien FROM nguoidung WHERE manguoidung='".$u->userId."';");

        
        //Reset bien $m
        $m = $db ->get("SELECT * FROM tinnhan WHERE matinnhan='-1';");


        $sukien = json_decode($data[0]['sukien'], true);

        $conversation_id = $conv_id;

        $message_ids = $sukien[$conversation_id];
        
        if(count($message_ids) != 0)
        {
                    //echo "SELECT message FROM message WHERE id IN("._list_encode($message_ids).");";
                  $m = $db ->get("SELECT * FROM tinnhan WHERE matinnhan IN("._list_encode($message_ids).");");

        }

        //var_dump($sukien);
        //Đanh dau la da doc
        $sukien[$conversation_id] = Array();
        //var_dump($sukien);
        $sukien = _removeEmptyElement($sukien);
        //var_dump($sukien);
        $db ->put("UPDATE nguoidung SET sukien = '".  json_encode($sukien)."' WHERE manguoidung='".$u->userId."'");
        $db ->close();

    }
    else
    {
        $m = $conv ->getMessages( $params );
    }
    $result = Array();
    //Càng nhiều tin nhắn, thời gian của vòng for càng lâu
    for($i = count($m) - 1; $i >= 0; $i--)
    {
        $u = new User( User::id2username($m[$i]['manguoidung']));

        $message = $m[$i][tinnhan];
        $message = "".htmlspecialchars($message)."";
        $smiley = new Smiley();
        $message = $smiley  ->insert($message);
        //$message = base64_encode($message);
        $date = new Date($m[$i]['thoigiangui']);
        
        $result[] = 
                Array
                (
                    "user_link" => $u->getProfileLink($u->userName),
                    "message" => $message,
                    "time" => $date ->getDate()
                );

    }
    
    return $result;
}

?>