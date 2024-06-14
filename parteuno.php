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

class Feria{
    public $juegosGrandes = [];
    public $juegosMedianos = [];
    public $juegosChicos = [];
    public $horarioapertura = Datetime::__set_state("15:00");
    
    CONST NOMBRESJUEGOS = [
        "JuegosGrandes" => ["MontañaRusa", "RuedaDeLaFortuna", "EVOLUTION"],
        "JuegosMedianos" => ["Carrusel", "SillasVoladoras", "TazasLocas", "BarcoPirata", "TrendelaMina", "CasadelTerror"],
        "JuegosPequeños" => ["MiniCarrusel", "Saltamontes", "Caballitos", "TrenInfantil","Mini Noria", "Rueditas","Coches de Choque"]
        ];

    /*function __construct($dias){
        $this->dias = $dias;
    }*/

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
    public function mantenimiento(){

    }
   
    //limites de persona
    public function limitesdeusuarios(){

    }

    // para la cola o espera
    public function espera(){

    }

    //funcion para correr juegos
    public function correrJuego(){

    }
   
    //para terminar el juego
    public function terminarjuego(){

    }
}



class JuegosGrandes {
    public $nombre;
    public $duracion = 5;
    public $capacidadmin = 20;
    public $capacidadmax = 30;
    function __construct($nombres){
        array_push($this->nombre,$nombres);
    }

}
class JuegosMedianos {
    public $nombre;
    public $duracion = 7;
    public $capacidadmin = 10;
    public $capacidadmax = 20;
    function __construct($nombres){
        array_push($this->nombre,$nombres);
    }
}

class JuegosPequeños {
    public $nombre;
    public $duracion = 10;
    public $capacidadmin = 5;
    public $capacidadmax = 10;
    function __construct($nombres){
        array_push($this->nombre,$nombres);
    }
}
class persona{
    public $platita = random_int(30,200);
}
?>