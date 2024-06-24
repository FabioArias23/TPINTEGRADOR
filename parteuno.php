<?php
/*Una Feria
•	Abre todos los días de 15 a 2.
•	Cuenta con 15 juegos, 3 grandes, 5 medianos y 7 pequeños 
•	Todos los juegos deben funcionar el fin de semana, el mantenimiento se realiza después de 5 días de uso, y en 
    los juegos grandes dura 3 días, en los medianos 2 y los pequeños 1.
•	Cada juego tiene un límite de usuarios por ejecución, los grandes tienen un límite de entre 20 y 30, los medianos entre 10 y 20 y los pequeños entre 5 y 10.
•	El uso de los juegos dura 5 minutos para los grandes, 7 para los medianos y 10 para los pequeños, al ingresar y 
salir del juego se demoran entre 1 y 3 minutos por cada 5 personas.
•	Las personas tienen una preferencia del 50% por los juegos grandes, 30% por los medianos y 20% por los pequeños.
Por lo que las colas se limitan a 3 veces la capacidad por cada tipo de juego.
•	Cada persona tiene un presupuesto entre $30 y $200.
•	El precio de los juegos grandes es de $20, de los medianos de $15 y los pequeños $10.
•	Una vez que se termina su dinero se retira o después de subir a al menos 5 juegos.
•	Puede subirse al mismo juego varias veces.
•	Las personas llegan en grupos de entre 0 y 5 entre las 15 y las 20 cada 10 minutos, de 3 a 8 entre las 20 y las 23 y de entre 1 a 4 entre las 23 y las 2
•	A fin de mes, pagar el sueldo a los 25 empleados, el sueldo de cada empleado es de $700.
*/ 



class Parque_Diversiones{
    public $juegosGrandes = []; //tengo 3
    public $juegosMedianos = []; // tengo 5
    public $juegosChicos = []; //tengo 7
    public $personas = [];
    public $empleados = [];
    public $ingresodia;
    public $caja;
    public $colaGrande = [];
    public $colaMediano= [];
    public $colaChico = [];
    
    public function agreagar_juego_grande($nombre){
        $this->juegosGrandes []= new JuegosGrandes($nombre);

    }
    public function agreagar_juego_mediano($nombre){
        $this->juegosMedianos []= new JuegosMedianos($nombre);
    }
    public function agreagar_juego_pequeños($nombre){
        $this->juegosChicos []= new JuegosPequeños($nombre);
    }

    //funcion para mantenimiento de juegos
    
    public function mantenimiento($diaActual) {
        $this->verificarMantenimiento($this->juegosGrandes, 5, 3, $diaActual);
        $this->verificarMantenimiento($this->juegosMedianos, 5, 2, $diaActual);
        $this->verificarMantenimiento($this->juegosChicos, 5, 1, $diaActual);
    }

    private function verificarMantenimiento(&$juegos, $diasUso, $diasMantenimiento, $diaActual) {
        foreach ($juegos as $juego) {
            if ($juego->enMantenimiento) {
                if ($juego->diaFinMantenimiento <= $diaActual) {
                    $juego->enMantenimiento = false;
                }
            } else {
                if ($juego->diasUso >= $diasUso) {
                    $juego->enMantenimiento = true;
                    $juego->diaFinMantenimiento = $diaActual + $diasMantenimiento;
                    $juego->diasUso = 0;
                }
            }
        }
    }
/*

El método correrJuegos($tipo) realiza las siguientes acciones:

Selecciona el tipo de juego a ejecutar basado en el argumento $tipo.
Itera sobre los juegos seleccionados y verifica si no están en mantenimiento.
Asigna a las personas al juego hasta la capacidad máxima del juego.
Verifica si las personas tienen suficiente dinero para pagar el juego y
 actualiza sus estados (platita y juegosUsados).
Actualiza los ingresos del parque (ingresodia) y los días de uso del juego (diasUso).
Marca a las personas como no disponibles si han usado al menos 5 juegos o si no tienen
 suficiente dinero para pagar el juego más barato disponible.

*/ 
  //correr juego con tu cola
    public function correrJuegos($tipo) {
        $juegos = [];
        switch ($tipo) {
            case 'grandes':
                $juegos = $this->juegosGrandes;
                $cola = &$this->colaGrande;
                break;
            case 'medianos':
                $juegos = $this->juegosMedianos;
                $cola = &$this->colaMediano;
                break;
            case 'chicos':
                $juegos = $this->juegosChicos;
                $cola = &$this->colaChico;
                break;
        }
        foreach ($juegos as $juego) {
            if (!$juego->enMantenimiento) {
                $personasEnJuego = array_splice($this->personas, 0, $juego->capacidadmax);
                foreach ($personasEnJuego as $persona) {
                    if ($persona->platita >= $juego->precio) {
                        $persona->platita -= $juego->precio;
                        $this->ingresodia += $juego->precio;
                        $juego->diasUso++;
                        $persona->juegosUsados++;
                        if ($persona->juegosUsados >= 5 || $persona->platita < min($this->juegosGrandes[0]->precio, $this->juegosMedianos[0]->precio, $this->juegosChicos[0]->precio)) {
                            $persona->disponible = false;
                        }else{
                            //si la persona tiene platita y no ha subido a 5 juegos,
                            $cola[] = $persona;
                        }
                    }else {
                        //si la persona no tiene mas platita, puede intentar con otro jueguito
                        $persona->disponible = false;
                    }
                }
            }
        }
    
    }

    public function correrJuegosGrandes(){

        foreach ($this->juegosGrandes as $JuegoG) {
            for ($i=0; $i < count($this->personas); $i++) { 
                if($this->personas[$i]->platita >= $JuegoG->precio){
                    $this->ingresodia += $JuegoG->precio;

                }
            }
        }
    }

        
    public function agregarPersonas(){
        $this->personas []= new Persona();
    }

    public function cola() {
       foreach ($this->personas as $persona) {
        if ($persona->disponible) {
            $preferencia = random_int(1,10);
        if($preferencia <= 5){
            $this->colaGrande [] = $persona;
        }
        if($preferencia > 5 && $preferencia <=8){
            $this->colaMediano [] = $persona;
        }
        if($preferencia > 8){
            $this->colaChico [] = $persona;
        }
       }
    }
    }
    public function agregarEmpleado ($cantidad){
        for($i = 0; $i<$cantidad; $i++){ 
            $this->empleados [] =  new Empleado();
        }
       
    }

      // metodo para pagar tu cola con sueldos
      public function pagarSueldos() {
        $totalSueldos = count($this->empleados) * 700;
        $this->caja -= $totalSueldos;
    }
    //metodo para darte el fin del dia por la cola
    public function finDia() {
        $this->caja += $this->ingresodia;
        $this->ingresodia = 0;
    }
}
/* for ($i=0; $i < count($LinkinPark->personas); $i++) { 
    if ($LinkinPark->personas[$i]->disponible) {
        $preferencia = random_int(1,10);
        if($preferencia <= 5){
            $LinkinPark->personas[$i]->disponible = false;
        }
        if($preferencia > 5 && $preferencia <=8){
            $LinkinPark->personas[$i]->disponible = false;
        }
        if($preferencia > 8){
            $LinkinPark->personas[$i]->disponible = false;
        }
        $LinkinPark->cola($LinkinPark->personas[$i],$preferencia,$colachica,$colamediana,$colagrande);
    }
    
} */


class JuegosGrandes {
    public $nombre;
    public $duracion = 5;
    public $capacidadmin = 20;
    public $capacidadmax = 30;
    public $diasUso = 0;
    public $enMantenimiento = false;
    public $diaFinMantenimiento;
    public $precio = 20;
    function __construct($nombres){
        $this->nombre = $nombres;
    }

}
   
class JuegosMedianos {
    public $nombre;
    public $duracion = 7;
    public $capacidadmin = 10;
    public $capacidadmax = 20;
    public $precio = 15;
    public $diasUso = 0;
    public $enMantenimiento = false;
    public $diaFinMantenimiento;
    function __construct($nombres){
        $this->nombre = $nombres;
    }
}

class JuegosPequeños {
    public $nombre;
    public $duracion = 10;
    public $capacidadmin = 5;
    public $capacidadmax = 10;
    public $precio = 10;
    public $diasUso = 0;
    public $enMantenimiento = false;
    public $diaFinMantenimiento;
    function __construct($nombres){
        $this->nombre = $nombres;
    }
}
class Persona{
    public $platita;
    public $disponible = true;
    public $juegosUsados = 0;
    function __construct(){
        $this->platita = random_int(30,200);
    }
}

class Empleado{
    public $sueldos = 700;

}
//instanciacion de nuestro Parque
$LinkinPark = new Parque_Diversiones;
$fechaInicio = new DateTime('2024-06-01 15:00:00');
//Establecer la fecha final (agregamos 1 mes a la fecha de inicio)
$fechaFinal = clone $fechaInicio;
$fechaFinal->modify('+1 day');
$Apertura = 15;
$Cierre = 2;
$dado;

//Simulamos el tiempo minuto a minuto
while ($fechaInicio < $fechaFinal) {

    $horaActual = (int) $fechaInicio->format('H'); //(int) operador de casting 
    $minutos =  (int) $fechaInicio->format('i');

    

    //condicion para ver si estamos dentro de la franja horaria o sea cuando nuestro parque esta abierto
    if ($horaActual >= $Apertura || $horaActual <= $Cierre) {

        //Simulamos la llegada de personas en la primera tanda de 0 a 5 cada 10 min
        if ($horaActual >= 15 && $horaActual <= 20 && $minutos % 10 == 0) {
            $dado = random_int(0, 5);
            for ($i=0; $i < $dado; $i++) { 
                $LinkinPark->agregarpersonas();
            }
        }elseif($horaActual > 20 && $horaActual <= 23 && $minutos % 10 == 0){
            $dado = random_int(3, 8);
            for ($i=0; $i < $dado; $i++) {
                $LinkinPark->agregarpersonas();
            }
        }elseif($horaActual > 23 && $minutos % 10 == 0){
            $dado = random_int(1, 4);
            for ($i=0; $i < $dado; $i++) { 
                $LinkinPark->agregarpersonas();
            }
        }

    }

        for ($i=0; $i < count($LinkinPark->personas); $i++) { 
            if ($LinkinPark->personas[$i]->disponible) {
                $preferencia = random_int(1,10);
                if($preferencia <= 5){
                    $LinkinPark->personas[$i]->disponible = false;
                }
                if($preferencia > 5 && $preferencia <=8){
                    $LinkinPark->personas[$i]->disponible = false;
                }
                if($preferencia > 8){
                    $LinkinPark->personas[$i]->disponible = false;
                }
                $LinkinPark->cola($LinkinPark->personas[$i],$preferencia,$colachica,$colamediana,$colagrande);
            }
            
        }

      // Correr los juegos y verificar mantenimiento
      if(count($colagrande)> 19 && count($colagrande) < 31){
        $LinkinPark->correrJuegos('grandes');
      }
      if(count($colagrande) > 9 && count($colagrande) < 21){
       $LinkinPark->correrJuegos('chicos');
      }
      if(count($colagrande)> 4 && count($colagrande) < 11){
        $LinkinPark->correrJuegos('medianos');
      }
      
      $LinkinPark->mantenimiento($fechaInicio->format('d'));

      $LinkinPark->agregarPersonas();
      $LinkinPark->cola();

  
     // Correr los juegos y verificar mantenimiento
    /*  $LinkinPark->correrJuego();
     $LinkinPark->mantenimiento($diasUso); */
 
     // Incrementar el día de uso cada 24 horas
     /* if ($fechaInicio->format('H:i') == '02:00') {
         $diasUso++;
     } */
 

    // Incrementa 1 minuto
    $fechaInicio->modify('+1 minute');

}
$LinkinPark->agreagar_juego_grande("Montania Rusa");
$LinkinPark->agreagar_juego_grande("Rueda De La Fortuna");
$LinkinPark->agreagar_juego_grande("EVOLUTION");
$LinkinPark->agreagar_juego_mediano("Carrusel");
$LinkinPark->agreagar_juego_mediano("Sillas Voladoras");
$LinkinPark->agreagar_juego_mediano("Tazas Locas");
$LinkinPark->agreagar_juego_mediano("Barco Pirata");
$LinkinPark->agreagar_juego_mediano("Tren de la Mina");
$LinkinPark->agreagar_juego_pequeños("Mini-Carrusel");
$LinkinPark->agreagar_juego_pequeños("Saltamontes");
$LinkinPark->agreagar_juego_pequeños("Caballitos");
$LinkinPark->agreagar_juego_pequeños("Tren Infantil");
$LinkinPark->agreagar_juego_pequeños("MiniNoria");
$LinkinPark->agreagar_juego_pequeños("Rueditas");
$LinkinPark->agreagar_juego_pequeños("Autitos Chocadores");
$LinkinPark->agregarEmpleado(25);
$LinkinPark->mantenimiento($fechaInicio->format('d'));
 var_dump($LinkinPark->personas);
?>