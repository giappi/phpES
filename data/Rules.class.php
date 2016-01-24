<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Rules
 *
 * @author giappi
 */
class Rules
{
    
    public static function getById($id)
    {
        $rows = Database::query("SELECT nut_id, value as nut_value, nut_not, nut_type FROM (SELECT * FROM rules WHERE rule_id='" . $id . "') AS rules, nuts WHERE rules.nut_id=nuts.id;");
        $left = new Set();
        $right = new Set();
        
        foreach ($rows as $row)
        {
            $node = new Node($row["nut_id"], $row["nut_value"]);
            if ($row["nut_type"] == NodeType::LEFT)
            {
                $left  -> add($node);
            }
            else
            {
                $right -> add($node);
            }
        }
        
        return new Rule($left, $right->count() > 0 ? $right->get(0) : new Node(""));
    }
    
    /**
     * 
     * @return \Set Tập luật
     */
    public static function getAll()
    {
        $rows = Database::query("SELECT * FROM rule");
        $rules = new Set();
        foreach( $rows as $row)
        {
           $rule = self::getById($row["id"]);
           //if ($rule->GiaThuyet->count() > 0 && $rule->KetLuan->Id)
            {
                $rules->add($rule);
            }
        }
        
        return $rules;
    }
}

?>