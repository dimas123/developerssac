<?php
/**
 * Created by PhpStorm.
 * User: tavo
 * Date: 13/04/2017
 * Time: 18:20 PM
 */

header('Content-Type: text/html; charset=utf-8');

class ChangeString
{
    /**
     * @param (string) $string
     */
    public static function build($string)
    {
        $alphabet = [
            'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'ñ', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z'
        ];

        $countAlphabet  = count($alphabet) - 1;
        $string         = trim($string);
        $count          = strlen($string);
        $newString      = null;

        for($i = 0; $i < $count ; $i++){
            $value = substr($string, $i, 1);

            if(in_array(strtolower($value), $alphabet)){
                $key        = array_search(strtolower($value), $alphabet) + 1;
                $newKey     = ($key > $countAlphabet)?  0 : $key;

                $newString .= (ctype_upper($value))? strtoupper($alphabet[$newKey]) : $alphabet[$newKey] ;
            } else {
                $newString .= $value;
            }
        }

        return $newString;
    }

}

//prueba
echo "Cadena entrada (123 abcd*3)";
echo "<br/>";
echo "Cadena respuesta (" . ChangeString::build('123 abcd*3') . ')';
echo "<br/>";echo "<br/>";


echo "Cadena entrada (**Casa 52)";
echo "<br/>";
echo "Cadena respuesta (" . ChangeString::build('**Casa 52') . ')';
echo "<br/>";echo "<br/>";


echo "Cadena entrada (**Casa 52Z)";
echo "<br/>";
echo "Cadena respuesta (" . ChangeString::build('**Casa 52Z') . ')';
echo "<br/>";echo "<br/>";





