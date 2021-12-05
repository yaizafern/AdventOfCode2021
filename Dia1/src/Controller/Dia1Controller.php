<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Dia1Controller extends AbstractController
{
    #[Route('/dia1', name: 'dia1')]
    public function index(): Response
    {
        $profundidades = [];
        $fp = fopen("/home/yaiza/Escritorio/AdventOfCode/Dia1/Dia1/Datos.txt", "r");
        while (!feof($fp)){
            $linea = fgets($fp);
            array_push($profundidades, $linea);
        }
        fclose($fp);

        $contador = 0;
        $suma = 0;
        $sumaAnterior = 0;

        $trios = count($profundidades) / 3;
        $trios = intval($trios);

        for ($i = 0; $i < ($trios*3); $i++) {

            $suma = $profundidades[$i] + $profundidades[$i+1] + $profundidades[$i+2];
            if ($i > 0)
                $sumaAnterior = $profundidades[$i-1] + $profundidades[$i] + $profundidades[$i+1];

            if ($i > 0 && $suma > $sumaAnterior) {

                $contador++;
            }
        }
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/Dia1Controller.php',
        ]);
    }
}
