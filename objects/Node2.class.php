<?php

/**
 * Description of Node2
 *
 * @author giappaig
 */

    class Node2
    {

        public $Node;
        public $Index;


        public function Node2($node, $index)
        {
            $this -> Node = $node;
            $this -> Index = $index;
        }
		
        public function toString()
        {
            return "(" . $this->Node . ", " . $this->Index . ")";
        }
	}

?>