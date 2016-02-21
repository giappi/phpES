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
    }
    
    /**
     * Mỗi bước sẽ trả về node cần được xác định tính đúng sai
     */
    public function step()
    {
        
    }
    
    public function IsInferred()
    {
        $used_rule = new Set();
        $inferred = $this->GT;
        printf("Luật đã sử dụng: %s\n", $used_rule);
        printf("Đã suy diễn: %s\n", $inferred);
        while(true)
        {
            $inferring = new Set();
            
            foreach($this->rules as $rule)
            {
                //Không xét luật đã được sử dụng
                if($used_rule->exists($rule) == false)
                {
                    //Nếu vế trái của luật tìm thấy nằm trọn trong giả thuyết, thì suy diễn được
                    if($rule->GiaThuyet->count() > 0 && $this->GT->contains($rule->GiaThuyet))
                    {
                        echo $rule . "\n";
                        $inferring->add($rule->KetLuan);
                        printf("Thêm %s vào cái đang suy diễn.\n", $rule->KetLuan);
                        $used_rule->add($rule);
                    }
                }
            }
            
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
                echo "Gộp những cái vừa suy diễn được vào tập đã suy diễn: " . $inferred . "\n";
                if($inferred->exists($this->KL) == true)
                {
                    echo "Ngừng suy diễn do đã tìm thấy cái cần tìm.\n";
                    break;
                }
            }
        }
        
        echo $this->KL . " in " . $inferred;
        //Nếu KL ở trong tập đã suy ra được thì trả về true, không thì false
        return $inferred->exists($this->KL);
    }
}
