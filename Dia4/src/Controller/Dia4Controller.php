<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Dia4Controller extends AbstractController
{
    #[Route('/dia4', name: 'dia4')]
    public function index(): Response
    {

        $fp = fopen("D:\AdventOfCode2021\Dia4\src\Controller\Numeros.txt", "r");
        while (!feof($fp)){
            $linea = fgets($fp);
            $linea = trim($linea);
            $numeros = explode(",", $linea);
        }
        fclose($fp);

        // Variables:

        $tabla = [];
        $bingo = [];
        $contador = 0;

        $fp = fopen("D:\AdventOfCode2021\Dia4\src\Controller\Tablas.txt", "r");
        while (!feof($fp)){
            $lin = fgets($fp);

            if (strlen($lin) > 2) {

                $lin = trim(preg_replace('/\s\s+/', ' ', $lin));

                $linea = explode(" ", $lin);

                array_push($tabla, $linea);

                $contador++;

            }

            if ($contador === 5) {

                array_push($bingo, $tabla);
                $tabla = [];
                $contador = 0;
            }

        }
        fclose($fp);

        $bingoFalso = $bingo;

        $sies = ["si", "si", "si", "si", "si"];

        $tablaGanadora = [];

        $entra = true;

        $ultimoNumero = 0;

        $ganadoras = 0;

        $tablas = $bingo;

        for ($k = 0; $k < count($numeros); $k++) { // recorro los numeros cantados

            for ($i = 0; $i < count($bingoFalso); $i++) { // recorro cada tabla de bingo

                for ($j = 0; $j < count($bingoFalso[$i]); $j++) { // recorro cada fila de bingo

                    $columna = [];

                    for ($m = 0; $m < count($bingoFalso[$i][$j]); $m++) { // recorro cada valor de fila de bingo

                        if ($numeros[$k] === $bingoFalso[$i][$j][$m]) {

                            $bingoFalso[$i][$j][$m] = "si";
                        }

                        array_push($columna, $bingoFalso[$i][$m][$j]); // añado valor a columna
                    }

                    if (($bingoFalso[$i][$j] === $sies || $columna === $sies)) {

                        $tablaGanadora = $bingoFalso[$i];
                        $ultimoNumero = $numeros[$k];

                        if (count($tablas) > 1) {

                            unset($tablas[$i]);
                        }

                    }

                }

                $columnas = [];
                $tablaColumnas = [];


            }
        }

        $tablas = array_values($tablas);

        $tablaGanadora = $tablas[0];

        $tablaFinal = [];


        for ($k = 0; $k < count($numeros); $k++) { // recorro numeros

            for ($i = 0; $i < count($tablaGanadora); $i++) { // recorro filas tabla

                $columna = [];

                for ($j = 0; $j < count($tablaGanadora[$i]); $j++) { // recorro valores fila tabla

                    if ($numeros[$k] === $tablaGanadora[$i][$j]) {

                        $tablaGanadora[$i][$j] = "si";
                    }

                    array_push($columna, $tablaGanadora[$j][$i]); // añado valor a columna
                }

                if (($tablaGanadora[$i] === $sies || $columna === $sies) && $entra === true) {

                    $tablaFinal = $tablaGanadora;
                    $ultimoNumero = $numeros[$k];
                    $entra = false;
                }
            }
        }

        // mostrando solucion

        $sum = 0;

        for ($i = 0; $i < count($tablaFinal); $i++) {

            for ($j = 0; $j < count($tablaFinal[$i]); $j++) {

                if ($tablaFinal[$i][$j] != "si") {

                    $sum = $sum + intval($tablaFinal[$i][$j]);
                }
            }
        }

        echo $sum*$ultimoNumero;
        die();


        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/Dia4Controller.php',
        ]);
    }
}
