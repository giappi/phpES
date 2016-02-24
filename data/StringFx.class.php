<?php

    class StringFx
    {
        public static $unicode = array( "á", "à", "ả", "ã", "ạ", "ă", "ắ", "ằ", "ẳ", "ẵ", "ặ", "â", "ấ", "ầ", "ẩ", "ẫ", "ậ", "ê", "ế", "ể", "ễ", "ệ", "ó", "ò", "ỏ", "õ", "ọ", "ô", "ố", "ồ", "ổ", "ỗ", "ộ", "ơ", "ớ", "ờ", "ở", "ỡ", "ợ", "ú", "ù", "ủ", "ũ", "ụ", "ư", "ữ", "ừ", "ử", "ữ", "ự", "đ" );
        public static $cp1258  = array( "á", "à", "ả", "ã", "ạ", "ă", "ắ", "ằ", "ẳ", "ẵ", "ặ", "â", "ấ", "ầ", "ẩ", "ẫ", "ậ", "ê", "ế", "ể", "ễ", "ệ", "ó", "ò", "ỏ", "õ", "ọ", "ô", "ố", "ồ", "ổ", "ỗ", "ộ", "ơ", "ớ", "ờ", "ở", "ỡ", "ợ", "ú", "ù", "ủ", "ũ", "ụ", "ư", "ữ", "ừ", "ử", "ữ", "ự", "đ" );
        public static $kodau   = array( "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "e", "e", "e", "e", "e", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "u", "u", "u", "u", "u", "u", "u", "u", "u", "u", "u", "d" );
        
        public static function khongDau($text)
        {
            $text = self::cp12582uni($text);
            $text = self::uni2kodau($text);
            //Console::log($text);
            return $text;
        }

        public static function chuThuong($text)
        {
            return $text.ToLower();
        }

        public static function uni2cp1258($text)
        {
            return str_replace(self::$unicode, self::$cp1258, $text);
        }

        public static function cp12582uni($text)
        {
            return str_replace(self::$cp1258, self::$unicode, $text);
        }
        public static function uni2kodau($text)
        {
            return str_replace(self::$unicode, self::$kodau,  $text);
        }
    }