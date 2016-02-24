<?php



function User_online($params=null)
{
        $_userName = Client::getUserName();
        $acc = new Account($_userName);
	//Kiểm tra đăng nhập hợp lệ
	if( $acc ->isLoggedIn() )
	{
		//echo "Checked!\r\n";
		$u = $acc ->user;
                
		if($params['action']=='isOnline')
		{
			return $u -> isOnline();
		}
		if($params['action']=='updateOnline')
		{
			return $u -> updateOnline();
		}
		
	}
	else
	{
		return "Not Login!";
	}
}