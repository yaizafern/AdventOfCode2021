<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Dia4BisController extends AbstractController
{

    private array $tablaGanadora;
    private array $bingo = [];
    private array $bingoColumnas = [];
    private array $guardarGanadores = [];
    private int $ultimoNumero;

    #[Route('/dia4/bis', name: 'dia4_bis')]
    public function index(): Response
    {

        // Numeros:

        $fp = fopen("D:\AdventOfCode2021\Dia4\src\Controller\Numeros.txt", "r");
        while (!feof($fp)){
            $linea = fgets($fp);
            $linea = trim($linea);
            $numeros = explode(",", $linea);
        }
        fclose($fp);

        // Tablas:

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

                array_push($this->bingo, $tabla);
                $tabla = [];
                $contador = 0;
            }

        }
        fclose($fp);

        $this->bingoColumnas = $this->bingo;

        $aparece = false; // booleano que determina si un numero aparece en una tabla

        $solucion = 0;

        $contador = 0;

        for ($i = 0; $i < count($numeros); $i++) {

            $ganador = $this->comprobarTabla($numeros[$i]);

            if ($ganador === true && $contador < 1) {

                $solucion = $this->mostrarSolucion($this->tablaGanadora, $this->ultimoNumero);
                $contador++;
            }
        }

        echo $solucion;
        die();

        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/Dia4BisController.php',
        ]);
    }

    // Metodo que comprueba si un numero esta en la tabla

    public function comprobarTabla(string $num): bool {

        $ganador = false; // determina si la tabla es ganadora
        $sies = ['si', 'si', 'si', 'si', 'si']; // comparo si la fila/columna es igual a ese array

        for ($i = 0; $i < count($this->bingo); $i++) { // 100 veces, una por cada tabla

            for ($j = 0; $j < count($this->bingo[$i]); $j++) { // 5 veces, una vez por cada fila de la tabla

                for ($m = 0; $m < count($this->bingo[$i][$j]); $m++) { // 5 veces, una vez por cada valor de la fila

                    if ($num === $this->bingo[$i][$j][$m]) {

                        $this->bingo[$i][$j][$m] = 'si';

                        if ($this->bingo[$i][$j] === $sies) {

                            if (in_array($i, $this->guardarGanadores) === false) {

                                array_push($this->guardarGanadores, $i);
                            }

                            if (count($this->guardarGanadores) === 100 && $ganador === false) {

                                $this->tablaGanadora = $this->bingo[$i];

                                $this->ultimoNumero = intval($num);

                                $ganador = true;
                            }

                        } else {

                            $contadorSi = 0;

                            for ($z = 0; $z < count($this->bingo[$i][$j]); $z++) {

                                if ($this->bingo[$i][$z][$m] === 'si') {

                                    $contadorSi++;
                                }
                            }

                            if ($contadorSi === 5) {

                                if (in_array($i, $this->guardarGanadores) === false) {

                                    array_push($this->guardarGanadores, $i);
                                }

                                if (count($this->guardarGanadores) === 100 && $ganador === false) {

                                    $this->tablaGanadora = $this->bingo[$i];

                                    $this->ultimoNumero = intval($num);

                                    $ganador = true;
                                }
                            }
                        }
                    }


                }


            }
        }

        return $ganador;
    }

    // Metodo que muestra el resultado del problema en base a la tabla ganadora

    public function mostrarSolucion(array $tablaGanadora, int $ultimoNumero): int {

        $sum = 0;

        for ($i = 0; $i < count($tablaGanadora); $i++) {

            for ($j = 0; $j < count($tablaGanadora[$i]); $j++) {

                if ($tablaGanadora[$i][$j] != "si") {

                    $sum = $sum + intval($tablaGanadora[$i][$j]);
                }
            }
        }

        $solucion = $sum*$ultimoNumero;

        return $solucion;
    }
}
