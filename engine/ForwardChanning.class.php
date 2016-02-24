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
        $this->inferred = $GT;
        $this->KL = $KL;
        $this->rules = $rules;
    }
    
    /**
     * Mỗi bước sẽ trả về node cần được xác định tính đúng sai
     */
    public function step()
    {
        echo "- Tìm các luật mà tập vế trái của nó, nằm trọn trong tập đã suy diễn:\n";
        $inferring = new Set();
        foreach($this->rules as $rule)
        {
            //Không xét luật đã được sử dụng
            if($used_rule->exists($rule) == false)
            {
                //Nếu vế trái của luật tìm thấy nằm trọn trong giả thuyết, thì suy diễn được
                if($this->GT->contains($rule->GiaThuyet))
                {
                    echo $rule . "\n";
                    $inferring->add($rule->KetLuan);
                    printf("Thêm %s vào cái đang suy diễn.\n", $rule->KetLuan);
                    $used_rule->add($rule);
                }
                else
                {
                    
                }
            }
        }
        echo "\n";
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
        $used_rule = new Set();
        $inferred = $this->GT;
        printf("Luật đã sử dụng: %s\n", $used_rule);
        printf("Đã suy diễn: %s\n", $inferred);
        while(true)
        {
            echo "- Tìm các luật mà tập vế trái của nó, nằm trọn trong tập đã suy diễn:\n";
            $inferring = new Set();
            foreach($this->rules as $rule)
            {
                //Không xét luật đã được sử dụng
                if($used_rule->exists($rule) == false)
                {
                    //Nếu vế trái của luật tìm thấy nằm trọn trong giả thuyết, thì suy diễn được
                    if($this->GT->contains($rule->GiaThuyet))
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
                if($inferred->exists($this->KL) == true)
                {
                    echo "Ngừng suy diễn vì không gian suy diễn có chứa kết luận : " . $this->KL . " ⊆ " . $inferred . "\n";
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
        return $inferred->exists($this->KL);
    }
}
