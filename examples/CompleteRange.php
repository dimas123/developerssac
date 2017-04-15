<?php
/**
 * Created by PhpStorm.
 * User: tavo
 * Date: 13/04/2017
 * Time: 20:25 PM
 */

class CompleteRange
{
    /**
     * @param (array) $data
     */
    public static function build($data)
    {
        $max = max($data);
        $min = min($data);

        $newData = [];

        for($i = $min; $i <= $max; $i++){
            $newData[] = $i;
        }

        return $newData;
    }

}

//prueba
echo "Se toma los indices por default del array ingresado al metodo ---> build()";
echo "<br>";
echo "<br>";

$dOne   = [1, 2, 4, 5];
$dTwo   = [2, 4, 9];
$dThree = [55, 58, 60];

echo "Inicio array [1, 2, 4, 5]:";
echo "<br>";

echo "Salida :";
echo '<pre>';
    print_r(CompleteRange::build($dOne));
echo '</pre>';

echo "Inicio array [2, 4, 9]:";
echo "<br>";

echo "Salida :";
echo '<pre>';
print_r(CompleteRange::build($dTwo));
echo '</pre>';

echo "Inicio array [55, 58, 60]:";
echo "<br>";

echo "Salida :";
echo '<pre>';
print_r(CompleteRange::build($dThree));
echo '</pre>';








