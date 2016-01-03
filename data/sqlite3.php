<?php


function sqlite3_open($location, $mode)
{
    $handle = new SQLite3($location);
    return $handle;
}
function sqlite3_close($handle)
{
    $handle -> close();
}
function sqlite3_query($handle, $query)
{
    $array['dbhandle'] = $handle;
    $array['query'] = $query;
    $result = $handle->query($query);
    return $result;
}



function sqlite3_fetch_array(&$result)
{ 
    $resx = $result->fetchArray(SQLITE3_ASSOC);
    return $resx;
}
function sqlite3_fetch_all(&$result)
{ 
    $rows = Array();

    while($res = $result->fetchArray(SQLITE3_ASSOC))
    {
        $rows[] = $res;
    }
    return $rows;
}

function candy_query($query)
{
	$db = sqlite3_open("../giappi/candy_crush_saga.sqlite", 0);
	$result = sqlite3_query($db,$query);
	$rows = sqlite3_fetch_all($result);
	sqlite3_close($db);
	return $rows;
}
function candy_put($query)
{
	$db = sqlite3_open("../giappi/candy_crush_saga.sqlite", 0);
	$result = sqlite3_query($db,$query);
	sqlite3_close($db);
	return true;
}


function sqlite3_insert($dbhandle, $table, $data)
{
    $list_key = "";
    $list_value = "";
    //Đếm số phần tử
    $i = 0;
    foreach ($data as $key => $value)
    {
        $i++;
    }
    $count = $i;
    $i = 0;
    //Tạo danh sách các trường để chèn
    foreach( $data as $key => $value)
    {
        $i++;
        $list_key .= $key;
        $list_value .= "'" . $value . "'";
        if($i < $count)
        {
            $list_key .= ",";
            $list_value .= ",";
        }
    }

    $sql = "INSERT INTO " . $table . "(" . $list_key . ")  VALUES(" . $list_value . ");";
    //file_put_contents("a.txt", $sql);
    
    sqlite3_query($dbhandle,$sql);
}


function sqlite3_get($handle, $str_table, $str_columns, $obj_conditions)
{
    $list_columns = $str_columns;
    
    //
    //Đếm số phần tử
    $count = 0;
    foreach( $obj_conditions as $key => $value)
    {
        $count++;
    }

    $list_condition = "";
    $i = 0;
    foreach( $obj_conditions as $key => $value)
    {
        $i++;
        $list_condition .= $key. "='" . $value."'";
        if($i < $count)
        {
            $list_condition .= " AND ";
        }
    }
    

    $sql = "SELECT " . $list_columns . " FROM ".$str_table." WHERE ".$list_condition.";";
    
    
    file_put_contents("sqlite3_get.txt", $sql);
    
	$result = sqlite3_query($handle,$sql);
	$rows = sqlite3_fetch_all($result);
    return $rows;
}



function sqlite3_set($dbhandle, $table, $data, $pkey)
{
    $list = "";
    //Đếm số phần tử
    $i = 0;
    foreach ($data as $key => $value)
    {
        $i++;
    }
    $count = $i;
    $i = 0;
    //Tạo danh sách các trường để thay đổi
    foreach( $data as $key => $value)
    {
        $i++;
        $list .= "" . $key. "='" . $value . "'";
        if($i < $count)
        {
            $list .= ",";
        }
    }
    
    //
    //Đếm số phần tử
    $i = 0;
    foreach( $pkey as $key => $value) $i++;
    $count = $i;
    $list_pkey = "";
    $i = 0;
    foreach( $pkey as $key => $value)
    {
        $i++;
        $list_pkey .= $value. "='" . $data[$value]."'";
        if($i < $count)
        {
            $list_pkey .= " AND ";
        }
    }
    

    $sql = "UPDATE " . $table . " SET ".$list." WHERE ".$list_pkey.";";
    
    
    file_put_contents("debug.txt", $sql);
    
    sqlite3_query($dbhandle,$sql);
}

function sqlite3_set2($handle, $table, $data, $cond)
{
    $list_data = "";
    //Đếm số phần tử
    $i = 0;
    foreach ($data as $key => $value)
    {
        $i++;
    }
    $count = $i;
    $i = 0;
    //Tạo danh sách các trường để thay đổi
    foreach( $data as $key => $value)
    {
        $i++;
        $list_data .= "" . $key. "='" . $value . "'";
        if($i < $count)
        {
            $list_data .= ",";
        }
    }
    
    //
    //Đếm số phần tử
    $i = 0;
    foreach ($cond as $key => $value)
    {
        $i++;
    }
    $count = $i;
    $list_condition = "";
    $i = 0;
    foreach( $cond as $key => $value)
    {
        $i++;
        $list_condition .= $key. "='" . $value."'";
        if($i < $count)
        {
            $list_condition .= " AND ";
        }
    }
    

    $sql = "UPDATE " . $table . " SET ".$list_data." WHERE ".$list_condition.";";
    
    
    //file_put_contents("debug.txt", $sql);
    
    sqlite3_query($handle,$sql);
}

function candy_insert($table, $data)
{
	$db = sqlite3_open("../giappi/candy_crush_saga.sqlite", 0);
	sqlite3_insert($db, $table, $data);
	sqlite3_close($db);
}

function candy_set($table, $data, $pkey)
{
	$db = sqlite3_open("../giappi/candy_crush_saga.sqlite", 0);
	sqlite3_set($db, $table, $data, $pkey);
	sqlite3_close($db);
}

function candy_get($table, $data, $cond)
{
	$db = sqlite3_open("../giappi/candy_crush_saga.sqlite", 0);
	$data = sqlite3_get($db, $table, $data, $cond);
	sqlite3_close($db);
	return $data;
	
}

?> 