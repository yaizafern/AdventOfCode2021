<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Dia3Controller extends AbstractController
{
    #[Route('/dia3', name: 'dia3')]
    public function index(): Response
    {
        $binarios = [];

        $fp = fopen("D:\AdventOfCode2021\Dia3\src\Controller\Datos.txt", "r");
        while (!feof($fp)){
            $linea = fgets($fp);
            $linea = trim($linea);
            array_push($binarios, $linea);
        }
        fclose($fp);

        // Todas las posiciones tienen la misma longitud asi que cojo la del 0 por ejemplo

        $longitud = strlen($binarios[0]);

        $oxigeno = $binarios;

        // Obteniendo OXIGENO

        for ($j = $longitud; $j > 0 ; $j--) {

            $contadorUnos = 0;
            $contadorCeros = 0;
            $size = count($oxigeno);

            for ($i = 0; $i < count($oxigeno); $i++) {

                if (substr($oxigeno[$i], -($j), 1) === '1') {

                    $contadorUnos++;

                } else if (substr($oxigeno[$i], -($j), 1) === '0') {

                    $contadorCeros++;
                }
            }

            if ($contadorCeros > $contadorUnos) {

                for ($m = 0; $m < $size; $m++) {

                    if (substr($oxigeno[$m], -($j), 1) === '1') {

                        unset($oxigeno[$m]);
                    }
                }

            } else if ($contadorCeros < $contadorUnos) {

                for ($m = 0; $m < $size; $m++) {

                    if (substr($oxigeno[$m], -($j), 1) === '0') {

                        unset($oxigeno[$m]);
                    }
                }
            }

            else {

                for ($m = 0; $m < $size; $m++) {

                    if (substr($oxigeno[$m], -($j), 1) === '0') {

                        unset($oxigeno[$m]);
                    }
                }
            }

            $oxigeno = array_values($oxigeno);

            if (count($oxigeno) === 1)
                break;
        }

        $ox = bindec($oxigeno[0]);

        // Obteniendo CO2

        $co2 = $binarios;

        for ($j = $longitud; $j > 0 ; $j--) {

            $contadorUnos = 0;
            $contadorCeros = 0;
            $size = count($co2);

            for ($i = 0; $i < count($co2); $i++) {

                if (substr($co2[$i], -($j), 1) === '1') {

                    $contadorUnos++;

                } else if (substr($co2[$i], -($j), 1) === '0') {

                    $contadorCeros++;
                }
            }

            if ($contadorCeros < $contadorUnos) {

                for ($m = 0; $m < $size; $m++) {

                    if (substr($co2[$m], -($j), 1) === '1') {

                        unset($co2[$m]);
                    }
                }

            } else if ($contadorCeros > $contadorUnos) {

                for ($m = 0; $m < $size; $m++) {

                    if (substr($co2[$m], -($j), 1) === '0') {

                        unset($co2[$m]);
                    }
                }
            }

            else {

                for ($m = 0; $m < $size; $m++) {

                    if (substr($co2[$m], -($j), 1) === '1') {

                        unset($co2[$m]);
                    }
                }
            }

            $co2 = array_values($co2);

            if (count($co2) === 1)
                break;
        }

        $co = bindec($co2[0]);

        echo $co*$ox;
        die();

        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/Dia3Controller.php',
        ]);
    }
}
