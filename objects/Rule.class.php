<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Rule
 *
 * @author giappi
 */
class Rule
{

    /**
     * Set of Nodes
     * @var Set
     */
    public $GiaThuyet;
    /**
     *
     * @var Node
     */
    public $KetLuan;

    public function Rule($left, $right)
    {
        $this->GiaThuyet = $left;
        $this->KetLuan = $right;
    }
    
    public function equals($rule2)
    {
        return $this == $rule2;
    }
    /**
     * 
     * @return String
     */
    public function toString()
    {
        return $this->GiaThuyet . " → " . "\"" . $this->KetLuan . "\"";
    }
    
    public function __toString()
    {
        return $this->toString();
    }
}
