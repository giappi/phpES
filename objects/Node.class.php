<?php

class Node
{
	
   public $Id;
   public $Text;
   public $Value;
   public $Not;
   
   /**
    * Một nút trong mạng suy diễn
    * @param String $id Định danh của Node
    * @param String $text Tên của Node
    */
   public function Node($id, $text="")
   {
       $this -> Id = $id;
       $this -> Text = $text;
	   $this -> Value = -1;
	   $this -> Not = false;
       if($id == "")
       {
           $this -> Text = "--";
       }
       if($this -> Text == "")
       {
           $this -> Text = $id;
       }
   }
   
	public static function compare($a, $b)
	{
		if ($a->Id == $b->Id && $a->Not == $b->Not)
		{
			return true;
		}
		return false;
	}
	
	public function equals($obj)
	{
		if ($obj == null)
		{
			return false;
		}
		return self::compare($this, $obj);
	}
	/**
     * 
     * @return String
     */
	public function toString()
	{
		return ($this->Not == true ? "~" : "") . $this->Text;
	}
    
    public function __toString()
    {
        return $this->toString();
    }
	
    
	

}

