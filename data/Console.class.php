<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Console
 *
 * @author giappi
 */
class Console
{
    public static function log($text)
    {
        $content = @file_get_contents("log.txt");
        file_put_contents("log.txt", $content . $text . "\n");
    }
}
