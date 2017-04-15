<?php
/**
 * Created by PhpStorm.
 * User: tavo
 * Date: 13/04/2017
 * Time: 21:32 PM
 */

class ClearPar
{
    /**
     * @param (string) $string
     */
    public static function build($string)
    {
        $evaluate   = '()';
        $num        = substr_count(trim($string), $evaluate);
        $newString  = null;

        for ($i = 0;$i < $num;$i++){
            $newString .= $evaluate;
        }

        return $newString;
    }

}


echo 'valor de entrada ----> "()())()"';
echo '====> filtro:' . ClearPar::build("()())()");
echo "<br/>";
echo "<br/>";

echo 'valor de entrada ----> "()(()"';
echo '====> filtro:' . ClearPar::build("()(()");
echo "<br/>";
echo "<br/>";

echo 'valor de entrada ----> ")("';
echo '====> filtro:' . ClearPar::build(")(");
echo "<br/>";
echo "<br/>";

echo 'valor de entrada ----> "((()"';
echo '====> filtro:' . ClearPar::build("((()");
echo "<br/>";
echo "<br/>";