<?php

    function Nodes_find($params = null)
    {

        //var_dump($params);
        
        $keyword = $params['keyword'] ? $params['keyword'] : '';
        $offset = $params['offset'] ? $params['offset'] : '0';
        $limit = $params['limit'] ? $params['limit'] : '50';
        
        $nodes = Nodes::find($keyword, $offset, $limit);
        
        //var_dump($nodes);
        
        $arr = array();
        foreach ($nodes as $node)
        {
            $arr[] = array( "id" => $node->Id, "text" => $node->Text);
        }
        
        return $arr;

    }
