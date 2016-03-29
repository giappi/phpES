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
     * @var Set (Node) Giả thuyết
     */
    public $GT;
    /**
     *
     * @var Node Kết luận
     */
    public $KL;
    /**
     *
     * @var Set Tập hợp luật
     */
    public $rules;
    
    public $log;
    
    /**
     *
     * @var Set Luật đã xét rồi
     */
    public $used_rule;
    
    /**
     *
     * @var Set (Node) Tập có được trong quá trình suy diễn
     */
    private $inferred;


    /**
     * 
     * @param Set (Node) $GT Bộ giả thuyết
     * @param Node $KL Kết luận
     * @param Set $rules
     */
    public function ForwardChanning($GT, $KL, $rules)
    {
        if (is_null($GT) || is_null($KL) || is_null($rules))
        {
            throw new Exception("one of three arguments is null.");
        }
        $this->GT = $GT;
        $this->KL = $KL;
        $this->rules = $rules;
        $this->used_rule = new Set();
        $this->inferred = unserialize(serialize($this->GT));
        
        $this->log = "";
    }
    
    /**
     * 
     */
    public function findNodeToAsk()
    {
    }
    
    /**
     * set of node that was inferred
     * @return Set
     */
    public function getInferred()
    {
        return $this->inferred;
    }
    
    /**
     * 
     * @param Node $node
     */
    public function addInferred($node)
    {
        $this->inferred->add($node);
    }


    public function IsInferred()
    {
        $this->log = "";
        if($this->GT->count() < 1)
        {
            $this->log .= "Không có gì để suy diễn.";
            return false;
        }

        $this->log .= "Luật đã sử dụng: $used_rule\n";
        $this->log .= "Đã suy diễn: $this->inferred\n";
        
        while(true)
        {
            $this->log .= "- Tìm các luật mà tập vế trái của nó, nằm trọn trong tập đã suy diễn:\n";
            $inferring = new Set();
            foreach($this->rules as $rule)
            {
                //Không xét luật đã được sử dụng
                if($this->used_rule->exists($rule) == false)
                {
                    //Nếu vế trái của luật tìm thấy nằm trọn trong giả thuyết, thì suy diễn được
                    if($this->inferred->contains($rule->GiaThuyet))
                    {
                        $this->log .= $rule . "\n";
                        $inferring->add($rule->KetLuan);
                        $this->log .= "Thêm " . $rule->KetLuan ." vào cái đang suy diễn.\n";
                        $this->used_rule->add($rule);
                    }
                }
            }
            $this->log .= "\n";
            
            $this->log .= "Vừa suy diễn được: " . $inferring . "\n";
            
            //Nếu không duy diễn được tiếp
            if($inferring->count() == 0)
            {
                $this->log .= "Không thể suy diễn được tiếp.\n";
                break;
            }
            else
            {
                //gộp cái mới suy diễn vào cái đã duy diễn được
                $this->inferred = $this->inferred->merge($inferring);
                $this->log .= "Gộp những cái vừa suy diễn được vào tập đã suy diễn được: " . $this->inferred . "\n";
                if($this->inferred->exists($this->KL) == true)
                {
                    $this->log .= "Ngừng suy diễn vì không gian suy diễn có chứa kết luận : " . $this->KL . " ⊆ " . $this->inferred . "\n";
                    $this->log .= "Suy diễn thành công.\n";
                    break;
                }
                else
                {
                    $this->log .= "Tiếp tục lặp lại các bước để mở rộng thêm không gian suy diễn.\n";
                }
            }
            $this->log .= "\n";
        }
        
        //Nếu KL ở trong tập đã suy ra được thì trả về true, không thì false
        return $this->inferred->exists($this->KL);
    }
    
    
    public static function BeInferred($rules, $event, $target)
    {
        $used_rule = new Set();
        $inferred = $event;
        printf("Luật đã sử dụng: %s\n", $used_rule);
        printf("Đã suy diễn: %s\n", $inferred);
        while(true)
        {
            echo "- Tìm các luật mà tập vế trái của nó, nằm trọn trong tập đã suy diễn:\n";
            $inferring = new Set();
            foreach($rules as $rule)
            {
                //Không xét luật đã được sử dụng
                if($used_rule->exists($rule) == false)
                {
                    //Nếu vế trái của luật tìm thấy nằm trọn trong giả thuyết, thì suy diễn được
                    if($event->contains($rule->GiaThuyet))
                    {
                        echo $rule . "\n";
                        $inferring->add($rule->KetLuan);
                        printf("Thêm %s vào cái đang suy diễn.\n", $rule->KetLuan);
                        $used_rule->add($rule);
                    }
                }
            }
            echo "\n";
            
            printf("Vừa suy diễn được: %s\n", $inferring);
            
            //Nếu không duy diễn được tiếp
            if($inferring->count() == 0)
            {
                echo "Không thể suy diễn được tiếp.\n";
                break;
            }
            else
            {
                //gộp cái mới suy diễn vào cái đã duy diễn được
                $inferred = $inferred->merge($inferring);
                echo "Gộp những cái vừa suy diễn được vào tập đã suy diễn được: " . $inferred . "\n";
                if($inferred->exists($target) == true)
                {
                    echo "Ngừng suy diễn vì không gian suy diễn có chứa kết luận : " . $target . " ⊆ " . $inferred . "\n";
                    echo "Suy diễn thành công.\n";
                    break;
                }
                else
                {
                    echo "Tiếp tục lặp lại các bước để mở rộng thêm không gian suy diễn.\n";
                }
            }
            echo "\n";
        }
        
        //Nếu KL ở trong tập đã suy ra được thì trả về true, không thì false
        return $inferred->exists($target);
    }
    
}
