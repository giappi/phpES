<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Nodes
 *
 * @author giappi
 */
class Nodes
{
    public static function get($ofset, $limit)
    {
        $rows = Database::query("SELECT * FROM nuts ORDER BY value LIMIT " . $ofset . ", " . $limit . "");
        
        $ns = new Set();
        foreach ($rows as $row)
        {
            $ns->add(new Node($row["id"], $row["value"]));
        }
        return $ns;
    }
    
    
    public static function XuLyTuKhoa($keyword)
    {
        return str_replace(" ", "%", $keyword);
    }
    
    
    public static function find($valueOfNode, $ofset, $limit)
    {
        
        
        
        $valueOfNode = self::XuLyTuKhoa($valueOfNode);
        
        
        $ns = new Set();
        //Ưu tiên: Tìm theo dạng 'keyword...' trước
        $t = Database::query("SELECT * FROM nuts_khongdau WHERE value_khongdau LIKE '" . Database::khongdau( Database::filter($valueOfNode)) . "%' ORDER BY value LIMIT " . $ofset . ", " . $limit . "");
        foreach ($t as $tr)
        {
            $ns->add(new Node($tr["id"], $tr["value"]));
        }

        
        //Nếu kết quả ít quá, tìm theo dạng '...keyword...', đến khi nào đủ số lượng hoặc không thấy kết quả
        if (count($t) < $limit)
        {
            $t = Database::query("SELECT * FROM nuts_khongdau WHERE value_khongdau LIKE '_%" . Database::khongdau( Database::filter($valueOfNode)) . "%' ORDER BY value LIMIT " . $ofset . ", " . $limit . "");
            foreach ($t as $tr)
            {
                if (count($t) > 0 && $ns->count() <= $limit)
                {
                    $ns->add(new Node($tr["id"], $tr["value"]));
                }
                else
                {
                    break;
                }
            }

        }

        return $ns;
    }

}
