<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Tập hợp
 *
 * @author giappi
 */
class Set implements Iterator
{

    private $Items;
    private $Index;

    public function Set($items =  array())
    {
        $this -> Items = $items;
        $this -> Index = 0;
    }
    
    /**
     * Thêm một phần tử vào một tập hợp
     */
    public function add($object)
    {
        array_push($this -> Items, $object);
    }
    /**
     * Loại bỏ một phần tử khỏi một tập hợp
     * 
     * @param Object $object
     */
    public function remove($object)
    {
        $this->Items =  array_diff($this->Items, array($object));
    }
    /**
     * Lấy ra và loại bỏ phần tử cuối cùng trong tập hợp
     * @return Object
     */
    public function pop()
    {
        return array_pop($this->Items);
    }
    /**
     * Kiểm tra sự tồn tại của một phần tử trong tập hợp
     * @param Object $object
     * @return Boolean
     */
    public function exists($object)
    {
        return in_array($object, $this->Items);
    }
    /**
     * Đếm số phần tử có trong tập hợp
     * @return Integer
     */
    public function count()
    {
        return count($this->Items);
    }
    /**
     * Lấy một phần tử ở vị trí chỉ định
     * @param type $index Vị trí của phần tử cần lấy trong tập hợp
     * @return Object
     */
    public function get($index)
    {
        return $this->Items[$index];
    }
    /**
     * Lấy toàn bộ các phần tử của tập hợp
     * @return Array
     */
    public function getAll()
    {
        return $this->Items;
    }
    
    
    /**
     * Trừ hai tập hợp
     * @param Set $set2 Tập hợp bị trừ
     * @return Set Tập hợp kết quả
     */
    public function subtract($set2)
    {
        $a = $this->Items;
        $b = $set2->Items;
        $c = new Set();

        for ($i = 0; $i < count($a); $i++)
        {
            $exist = false;
            for ($j = 0; $j < count($b); $j++)
            {
                if ($b[$j] == $a[$i] )
                {
                    $exist = true;
                    break;
                }
            }
            if (!$exist)
            {
                $c->add($a[$i]);
            }
        }
        return $c;
    }
    
    public function __toString()
    {
        return $this ->toString();
    }
    /**
     * 
     * @return String
     */
    public function toString()
    {
        $t = "{";
        for ($i = 0; $i < $this->count(); $i++ )
        {
            $t .= $this->Items[$i];
            if ($i < $this->count() - 1)
            {
                $t .= ", ";
            }
        }
        $t .= "}";
        return $t;
    }

    
    /*
     * 
     * Cài đặt chức năng có thể duyệt: foreach
     */
    public function current()
    {
        return $this->Items[$this->Index];
    }

    public function key()
    {
        return $this->Index;
    }

    public function next()
    {
        $this->Index++;
    }

    public function rewind()
    {
        $this->Index = 0;
    }

    public function valid()
    {
        return isset($this->Items[$this->key()]);
    }

}