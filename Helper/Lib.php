<?php 

class Lib{
    static public function convertListToString($array) : string{

        $s = "";
        foreach($array as $value){
            $s = $s."".$value.",";
        }
        return $s = substr($s, 0 ,-1);
    }
}