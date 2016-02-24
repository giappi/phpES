<?php

function System_notifyQueue($params=null)
{

    $from = $params['from'] ? $params['from'] : '0';
    $count = $params['count'] ? $params['count'] : '10';
    $keyword = $params['keyword'];
    $trangthai = $params['trangthai'];
    
    
    $acc = new Account( Client::getUserName());
    
    if(!$acc ->isLoggedIn())
    {
        return "Not Login!";
    }
    

    $db = new Database();
    $db ->open();
    $data = $db ->get("SELECT sukien FROM nguoidung WHERE manguoidung=".$acc->user->userId);
    
    $db ->close();
    
    $convs = json_decode($data[0]['sukien']);
    
    $conversations = Array();
    
    foreach($convs as $conv => $msgs)
    {
        if(count($msgs) > 0)
        {
            $db = new Database();
            $db ->open();
            $data1 = $db ->get("SELECT * FROM cuoctrochuyen WHERE macuoctrochuyen=".$conv);
            $db ->close();
            
            if(count($data1) > 0)
            {
                $danhsachnguoidung = $data1[0]['danhsachnguoidung'];
    			$danhsachnguoidung_trutoira = _removeElementByValue( _list_decode( $danhsachnguoidung ), $acc->user->userId);
    			$danhsachten = Conversation::ds_manguoidung2ds_tennguoidung( _list_encode($danhsachnguoidung_trutoira));
    			$conv_title = $danhsachten;
                
                $conversations[] = Array(
                    "id" => $conv,
                    "title" => $conv_title
                    );
            }
        }
        
    }
    
    return $conversations;
    
    
    
    
}

?>