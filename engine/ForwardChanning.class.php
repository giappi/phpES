<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ForwardChanning
 *
 * @author giappi
 */
class ForwardChanning
{
    /**
     *
     * @var Set(Node) Giả thuyết
     */
    public $GT;
    /**
     *
     * @var Node Kết luận
     */
    public $KL;
    
    /**
     * 
     * @param Set(Node) $GT Bộ giả thuyết
     * @param Node $KL Kết luận
     */
    public function ForwardChanning($GT, $KL)
    {
        $this->GT = $GT;
        $this->KL = $KL;
    }
    
    /**
     * Mỗi bước sẽ trả về node cần được xác định tính đúng sai
     */
    public function step()
    {
        
    }
    
    public function IsInferred()
    {
        
    }
}
