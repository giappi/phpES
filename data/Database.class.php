<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Cơ sở dữ liệu
 *
 * @author giappi
 */
class Database
{
    /**
     *
     * @var String Đường dẫn để file SQLite
     */
    public static $location = "he_chuyen_gia.sqlite";
    
    /**
     * 
     * @param String $sql Câu lệnh truy vấn SQL
     * @return Object ví dụ: Array( "id" => 1, "name" => "It's rains", ...);
     */
    public static function query($sql)
    {
        $db = sqlite3_open(self::$location, 0);
        $result = sqlite3_query($db, $sql);
        $rows = sqlite3_fetch_all($result);
        sqlite3_close($db);
        return $rows;
    }
    
    
    /**
     * 
     * @param String $str_table Tên bảng dữ liệu
     * @param String $str_columns Danh sách các cột cần lấy, tách nhau bởi ","
     * @param Object $obj_conditions Ví dụ: Array( "id" => 1, "name" => "It's rains", ...);
     * @return Object ví dụ: Array( "id" => 1, "name" => "It's rains", ...);
     */
    public static function get($str_table, $str_columns, $obj_conditions)
    {
        $list_columns = $str_columns;

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
        
        return self::query($sql);
    
    }
    
    public static function filter($sql_value)
    {
        $new_value = "";

        for ($i = 0; $i < strlen($sql_value); $i++)
        {
            //Thêm dấu "\" vào trước kí tự đặc biệt
            if ($sql_value[$i] == '\\' || $sql_value[$i] == '\'')
                $new_value .= '\\';
            $new_value .= $sql_value[$i];
        }
        return $new_value;
    }

    public static function khongdau($sql_value)
    {
        return StringFx::khongDau($sql_value);
    }
}
