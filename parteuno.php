<?php
/*Un Parque de Diversiones
•	Abre todos los días de 15 a 2.
•	Cuenta con 15 juegos, 3 grandes, 5 medianos y 7 pequeños 
•	Todos los juegos deben funcionar el fin de semana, el mantenimiento se realiza después de 5 días de uso, y en 
•	los juegos grandes dura 3 días, en los medianos 2 y los pequeños 1.
•	Cada juegos tiene un límite de usuarios por ejecución, los grandes tienen un límite de entre 20 y 30, los medianos entre 10 y 20 y los pequeños entre 5 y 10.
•	El uso de los juegos dura 5 minutos para los grandes, 7 para los medianos y 10 para los pequeños, al ingresar y 
salir del juegos se demoran entre 1 y 3 minutos por cada 5 personas.
•	Las personas tienen una preferencia del 50% por los juegos grandes, 30% por los medianos y 20% por los pequeños.
Por lo que las colas se limitan a 3 veces la capacidad por cada tipo de juegos.
•	Cada persona tiene un presupuesto entre $30 y $200.
•	El precio de los juegos grandes es de $20, de los medianos de $15 y los pequeños $10.
•	Una vez que se termina su dinero se retira o después de subir a al menos 5 juegos.
•	Puede subirse al mismo juegos varias veces.
•	Las personas llegan en grupos de entre 0 y 5 entre las 15 y las 20 cada 10 minutos, de 3 a 8 entre las 20 y las 23 y de entre 1 a 4 entre las 23 y las 2
•	A fin de mes, pagar el sueldo a los 25 empleados, el sueldo de cada empleado es de $700.
•	Elaborar una lista de ingresos diarios. Realizar un balance semanal y uno mensual.
*/
class Parque_Diversiones{
    public $juegosGrandes = []; //tengo 3
    public $juegosMedianos = []; // tengo 5
    public $juegosChicos = []; //tengo 7
    public $personas = [];
    public $empleados = [];
    public $ingresodia;
    public $caja;
    public $cajaSemanal;
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
    public function mantenimiento($diaActual,$indice){
    /*  $this->verificarMantenimiento($this->juegosGrandes[$indice],$this->juegosGrandes[$indice]->diasUso, $this->juegosGrandes[$indice]->diasdemantenimiento, $diaActual);
        $this->verificarMantenimiento($this->juegosMedianos[$indice],$this->juegosMedianos[$indice]->diasUso, $this->juegosMedianos[$indice]->diasdemantenimiento, $diaActual);
        $this->verificarMantenimiento($this->juegosChicos[$indice],$this->juegosChicos[$indice]->diasUso, $this->juegosChicos[$indice]->diasdemantenimiento, $diaActual); */
    }
    private function verificarMantenimiento($juegos,$diasUso, $diasMantenimiento, $diaActual) {
            if ($juegos->enMantenimiento) {
                if ($juegos->diaFinMantenimiento <= $diaActual) {
                    $juegos->enMantenimiento = false;
                }
            } else {
                if ($juegos->diasUso >= $diasUso) {
                    $juegos->enMantenimiento = true;
                    $juegos->diaFinMantenimiento = $diaActual + $diasMantenimiento;
                    $juegos->diasUso = 0;
                }
            }
    }
/*
El método correrJuegos($tipo) realiza las siguientes acciones:
Selecciona el tipo de juegos a ejecutar basado en el argumento $tipo.
Itera sobre los juegos seleccionados y verifica si no están en mantenimiento.

*/ 
  //correr juegos con tu cola
    public function correrJuegos($tipo,$indice) {
        switch ($tipo) {
            case 'grandes':
                for ($i=0; $i < count($this->juegosGrandes[$indice]->cola); $i++) { 
                    $this->juegosGrandes[$indice]->cola[$i]->platita -= $this->juegosGrandes[$indice]->precio;
                    $this->ingresodia += $this->juegosGrandes[0]->precio;
                    $this->juegosGrandes[$indice]->cola[$i]->juegosUsados++; 
                    $this->juegosGrandes[$indice]->seuso = true;
                    $this->juegosGrandes[$indice]->cola[$i]->disponible = true;
                }
                $this->juegosGrandes[$indice]->cola = [];
                break;
            case 'medianos':
                for ($i=0; $i < count($this->juegosMedianos[$indice]->cola); $i++) { 
                    $this->juegosMedianos[$indice]->cola[$i]->platita -= $this->juegosMedianos[$indice]->precio;
                    $this->ingresodia += $this->juegosMedianos[0]->precio;
                    $this->juegosMedianos[$indice]->cola[$i]->juegosUsados++;
                    $this->juegosMedianos[$indice]->seuso = true;
                    $this->juegosMedianos[$indice]->cola[$i]->disponible = true;
                }
                $this->juegosMedianos[$indice]->cola = [];
                break;
            case 'chicos':
                for ($i=0; $i < count($this->juegosChicos[$indice]->cola); $i++) { 
                    $this->juegosChicos[$indice]->cola[$i]->platita -= $this->juegosChicos[$indice]->precio;
                    $this->ingresodia += $this->juegosChicos[0]->precio;
                    $this->juegosChicos[$indice]->cola[$i]->juegosUsados++;
                    $this->juegosChicos[$indice]->seuso = true;
                    $this->juegosChicos[$indice]->cola[$i]->disponible = true;
                }
                $this->juegosChicos[$indice]->cola = [];
                break;
        }

                
    }
    public function agregarPersonas(){
        $this->personas []= new Persona();
    }
//recorremos el arreglo de personas y verificamos si se encuentra disponible y si tiene suficiente dinero para entrar a algun juego
    public function asignar_personas_cola() {
    for ($i=0; $i < count($this->personas); $i++) { 
        if ($this->personas[$i]->disponible) {
            $preferencia = random_int(1,10);
        if($preferencia <= 5 && $this->personas[$i]->platita >= 20){
            $indicejuego = random_int(0,2);
            while ($this->juegosGrandes[$indicejuego]->enMantenimiento) {
                $indicejuego = random_int(0,2);
            }
            $this->juegosGrandes[$indicejuego]->cola [] = &$this->personas[$i];
            $this->personas[$i]->disponible = false;
        }
        if($preferencia >= 6 && $preferencia <=8 && $this->personas[$i]->platita >= 15){
            $indicejuego = random_int(0,4);
            while ($this->juegosMedianos[$indicejuego]->enMantenimiento) {
                $indicejuego = random_int(0,4);
            }
            $this->juegosMedianos[$indicejuego]->cola []= &$this->personas[$i];
            $this->personas[$i]->disponible = false;
        }
        if($preferencia >= 9 && $this->personas[$i]->platita >= 10){
            $indicejuego = random_int(0,6);
            while ($this->juegosChicos[$indicejuego]->enMantenimiento) {
                $indicejuego = random_int(0,6);
            }
            $this->juegosChicos[$indicejuego]->cola []= &$this->personas[$i];
            $this->personas[$i]->disponible = false;
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
        for($i = 0; $i < 25; $i++){
            $this->empleados[$i]->sueldos [] = 700; 
    }
}   public function cronometro(){

}
    //metodo para darte el fin del dia por la cola
    public function finDia() {
        $this->caja += $this->ingresodia;
        $this->cajaSemanal += $this->ingresodia;
        $this->ingresodia = 0;
        $this->personas = [];
        for ($i=0; $i < 3; $i++) { 
            if ($this->juegosGrandes[$i]->seuso) {
                $this->juegosGrandes[$i]->diasUso++;
                $this->juegosGrandes[$i]->seuso = false;
            }
        }
        for ($i=0; $i < 5; $i++) { 
            if ($this->juegosMedianos[$i]->seuso) {
                $this->juegosMedianos[$i]->diasUso++;
                $this->juegosMedianos[$i]->seuso = false;
            }
        }
        for ($i=0; $i < 7; $i++) { 
            if ($this->juegosChicos[$i]->seuso) {
                $this->juegosChicos[$i]->diasUso++;
                $this->juegosChicos[$i]->seuso = false;
            }
        }
    }
}
class JuegosGrandes {
    public $cola = [];
    public $nombre;
    
    public $duracion = 5;
    public $diasdemantenimiento = 3;
    public $capacidadmin = 20;
    public $capacidadmax = 30;
    public $diasUso = 0;
    public $enMantenimiento = false;
    public $En_uso = false;
    public $seuso = false;
    public $precio = 20;
    function __construct($nombres){
        $this->nombre = $nombres;
    }
}
class JuegosMedianos {
    public $cola = [];
    public $nombre;
    
    public $diasdemantenimiento = 2;
    public $duracion = 7;
    public $capacidadmin = 10;
    public $capacidadmax = 20;
    public $precio = 15;
    public $diasUso = 0;
    public $seuso = false;
    public $enMantenimiento = false;
    public $En_uso = false;
    function __construct($nombres){
        $this->nombre = $nombres;
    }
}
class JuegosPequeños {
    public $cola = [];
    public $nombre;
    public $mantenimiento = 1;
    public $duracion = 10;
    public $capacidadmin = 5;
    public $capacidadmax = 10;
    public $precio = 10;
    public $diasUso = 0;
    public $seuso = false;
    public $enMantenimiento = false;
    public $En_uso = false;
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
    public $sueldos = [];
}
//instanciacion de nuestro Parque
$LinkinPark = new Parque_Diversiones;
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
//Instaciamos un objeto DateTime donde le pasamos como argumento una fecha y una hora. Ese sera el momento
//donde inicia nuestro tiempo
$fechaInicio = new DateTime('2024-06-01 15:00:00');
//Establecer la fecha final (agregamos 1 mes a la fecha de inicio)
$fechaFinal = clone $fechaInicio;
$findemes = clone $fechaInicio;
$findemes->modify('1 month');
$ParaActualizarMantenimiento = clone $fechaInicio;
$fechaFinal->modify('+1 year');
$Apertura = 15;
$Cierre = 2;
$dado;
$cont = 0;
$tiempotardanzapersonas = null;
//Simulamos el tiempo minuto a minuto
while ($fechaInicio < $fechaFinal) {
    $horaActual = (int) $fechaInicio->format('H');//(int) operador de casting 
    $minutos =  (int) $fechaInicio->format('i');
    //condicion para ver si estamos dentro de la franja horaria o sea cuando nuestro parque esta abierto
    if ($horaActual >= $Apertura || $horaActual <= $Cierre) {
        //Simulamos la llegada de personas en la primera tanda de 0 a 5 cada 10 min
        if ($horaActual >= 15 && $horaActual <= 20 && $minutos % 10 == 0) {
             //operador de modulo "%", nos devuelve el resto de una division.
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
    

         // Correr los juegos grandes
    for ($i=0; $i < 3; $i++) { 
        if(count($LinkinPark->juegosGrandes[$i]->cola) >= 20 && count($LinkinPark->juegosGrandes[$i]->cola) <= 30){
            if(empty($tiempotardanzapersonas)){
            $tiempotardanzapersonas = clone $fechaInicio;
            $tiempoaleatorio = intval((((count($LinkinPark->juegosGrandes[$i]->cola)/5))*random_int(1,3))*2)+5;
            $tiempotardanzapersonas->modify("+$tiempoaleatorio minutes");
            }
            if($fechaInicio >= $tiempotardanzapersonas){
                    $LinkinPark->correrJuegos('grandes',$i);
                    $tiempotardanzapersonas = null;
                }
            
    }     
    if ($LinkinPark->juegosGrandes[$i]->diasUso == 5){
                        $fechaMantenimientoFinal = clone $fechaInicio;
                        $fechaMantenimientoFinal->modify('+3 day');
                    if ($fechaInicio >= $fechaMantenimientoFinal) {
                        $LinkinPark->juegosGrandes[$i]->enMantenimiento = false;
                            $LinkinPark->juegosGrandes[$i]->diasUso = 0; 
                }
    }
}
if(!empty($LinkinPark->personas)){
    $LinkinPark->asignar_personas_cola();
}
    //juegos medianos
    for ($i=0; $i < 5; $i++) { 
    if(count($LinkinPark->juegosMedianos[$i]->cola) >= 10 && count($LinkinPark->juegosMedianos[$i]->cola) <= 20){
        if(empty($tiempotardanzapersonas)){
            $tiempotardanzapersonas = clone $fechaInicio;
            $tiempoaleatorio = intval((((count($LinkinPark->juegosMedianos[$i]->cola)/5))*random_int(1,3))*2)+7;
            $tiempotardanzapersonas->modify("+$tiempoaleatorio minutes");
            }
            if($fechaInicio >= $tiempotardanzapersonas){
                    $LinkinPark->correrJuegos('medianos',$i);
                    $tiempotardanzapersonas = null;
                }
    }
    if ($LinkinPark->juegosMedianos[$i]->diasUso == 5){
            $fechaMantenimientoFinal = clone $fechaInicio;
            $fechaMantenimientoFinal->modify('+2 day');
        if ($fechaInicio >= $fechaMantenimientoFinal) {
            $LinkinPark->juegosMedianos[$i]->enMantenimiento = false;
                    $LinkinPark->juegosMedianos[$i]->diasUso = 0; 
        }
}
    //juegos pequeños
    for ($i=0; $i < 7; $i++) { 
    if(count($LinkinPark->juegosChicos[$i]->cola) >= 5 && count($LinkinPark->juegosChicos[$i]->cola) <= 10){

        if(empty($tiempotardanzapersonas)){
            $tiempotardanzapersonas = clone $fechaInicio;
            $tiempoaleatorio = intval((((count($LinkinPark->juegosChicos[$i]->cola)/5))*random_int(1,3))*2)+10;
            $tiempotardanzapersonas->modify("+$tiempoaleatorio minutes");
            }
            if($fechaInicio >= $tiempotardanzapersonas){
                    $LinkinPark->correrJuegos('chicos',$i);
                    $tiempotardanzapersonas = null;
                }
    }
    if ($LinkinPark->juegosChicos[$i]->diasUso == 5){
            $fechaMantenimientoFinal = clone $fechaInicio;
            $fechaMantenimientoFinal->modify('+2 day');
        if ($fechaInicio >= $fechaMantenimientoFinal) {
            $LinkinPark->juegosChicos[$i]->enMantenimiento = false;
                    $LinkinPark->juegosChicos[$i]->diasUso = 0; 
        }
    
    }
}   
    
    //finalizar dia dejando los ingresos del dia en 0 y el arreglo de personas en 0 y verificando que juego se ejecuto asi sumarle un dia de uso
    if($fechaInicio->format('H:i') == '02:00'){
        echo "<br>"."caja diaria: " . $LinkinPark->ingresodia . "<br>";
    $LinkinPark->finDia();
    } 
    //caja semanal 
    if($fechaInicio->format('w') == 6){
        if($fechaInicio->format('H:i') == '02:00'){ 
        echo "<br>".'la Caja semanal es: ' . $LinkinPark->cajaSemanal . '<br>';
        $LinkinPark->cajaSemanal = 0;
            } 
        } 
     //verficamos si el arreglo de personas no esta vacio e invocamos el metodo asignar personas donde se evalua si la persona esta disponible 
     //y si la persona tiene suficiente platita para entrar al algun juego
    if($fechaInicio >= $findemes){
        $LinkinPark->pagarSueldos();
        echo '<br>' . "El balance mensual es:" . $LinkinPark->caja . '<br>';
        $findemes->modify('+1 month');
        var_dump($LinkinPark->empleados[0]);
    }
    // Incrementa 1 minuto
    $fechaInicio->modify('+1 minute');
    }
}
var_dump($LinkinPark->caja);
?>