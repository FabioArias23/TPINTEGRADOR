
<?php
/* $fechaInicio = new DateTime('2024-06-01 15:00:00');
//Establecer la fecha final (agregamos 1 mes a la fecha de inicio)
$fechaFinal = clone $fechaInicio;
$fechaFinal->modify('+1 day');
$cont=0;
while($fechaInicio < $fechaFinal){
$minutos =  (int) $fechaInicio->format('i');
if($minutos % 10 == 0 ){
echo 'Hola';
$cont++;
}
$fechaInicio->modify('+1 minute');
}
echo "$cont"; */

abstract class clase2 {

    abstract public function despedirse();
}

class clase3 extends clase2 {
    public function despedirse() {
        parent::despedirse();
        echo 'adios';
    }
}

(new clase3)->despedirse();
?>