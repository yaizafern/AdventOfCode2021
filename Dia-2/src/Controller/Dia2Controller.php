<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Dia2Controller extends AbstractController
{
    #[Route('/dia2', name: 'dia2')]
    public function index(): Response
    {
        $lineas = [];
        $fp = fopen("/home/yaiza/Escritorio/AdventOfCode/Dia2/src/Controller/Datos.txt", "r");
        while (!feof($fp)){
            $linea = fgets($fp);
            array_push($lineas, $linea);
        }
        fclose($fp);

        $posicion = 0;
        $profundidad = 0;
        $aim = 0;

        foreach ($lineas as $linea) {

            $linea = trim($linea);

            if (preg_match("/forward/", $linea)) {

                $i = substr($linea, -1);
                $i = intval($i);

                $posicion = $posicion + $i;

                $profundidad = $profundidad + ($aim * $i);

            } else if (preg_match("/down/", $linea)) {

                $i = substr($linea, -1);
                $i = intval($i);

                $aim = $aim + $i;

            } else if (preg_match("/up/", $linea)) {

                $i = substr($linea, -1);
                $i = intval($i);

                $aim = $aim - $i;
            }
        }

        echo $posicion.'<br/>';
        echo $profundidad.'<br/>';
        echo $posicion * $profundidad;
        die();

        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/Dia2Controller.php',
        ]);
    }
}
