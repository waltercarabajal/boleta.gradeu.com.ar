<?php
session_start();

if (isset($_POST["solicitud"])){
    $fsol=$_POST["solicitud"];
}else{
    $fsol=0;
}
if (isset($_POST["dni"])){
    $fdni=$_POST["dni"];
}else{
    $fdni=0;
}

if ($fdni==0 AND $fsol==0){
    $consu="ESPERANDO";
   // $consu="";
}else{
    $consu="BUSCANDO...";
}
include("conectorgb.inc");
$conexionBoleta= new mysqli($host_db,$user_db,$pass_db,$db_name,3306);
$strConsultaBoleta = "select * from boletas where idSuscripcion = ".$fsol." AND xDNI = ".$fdni;
$resultBoleta = $conexionBoleta->query($strConsultaBoleta);
//echo $strConsultaCred."<br>";
//if ($resultadoBoleta->num_rows === 0) {
if ($resultBoleta->num_rows === 0) {
     $vOK = 0;
     //echo "NO ES POR SOL";
}else{
while($fila = $resultBoleta->fetch_array()){
        $vOK = 1;
        $vTitulo = $fila["idTitulo"];
        $vPesos = $fila["xPesos"];
        $vNroSorteo = $fila["xNroSorteo"];
        $vApellido = $fila["xApellido"];
        $vNombres = $fila["xNombres"];
        $vIdSuscripcion = $fila["idSuscripcion"];
        $vCuota = $fila["xCta"];
        $vEstadoPago = $fila["xEstadoPago"];
        $Alertado2020 = true;
}
}

//FUNCION IP
function getRealIP() {

        if (!empty($_SERVER['HTTP_CLIENT_IP']))
            return $_SERVER['HTTP_CLIENT_IP'];
           
        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
       
        return $_SERVER['REMOTE_ADDR'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MultiPlan | Boletas ONLINE | Pagos</title>
    <!-- bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    
        <script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
   <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <!-- Font Awasome NO !-->
<script>
      $(document).ready(function()
      {
         $("#mostrarmodal").modal("show");
      });
    </script>
</head>
<body>
      <div class="modal fade" id="mostrarmodal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                 <div class="modal-header">
                     <h3>Novedadess</h3><img src="imagenes/codoacodo.jpeg" class="img-fluid" width=70px alt="Responsive image"><a href="#" data-dismiss="modal" class="btn btn-danger">Cerrar</a>
                 </div>
                 <div class="modal-body">
                    <ul class="list-group">
                        <li class="list-group-item active" aria-current="true">Metodos de Pago</li>
                        <li class="list-group-item">Cobranza Domiciliaria</li>
                        <li class="list-group-item">Efectivo en Sucursales</li>
                        <li class="list-group-item">Tarjetas de Credito</li>
                        <li class="list-group-item">Tarjetas de Debito</li>
                        <li class="list-group-item">PagoFacil, Rapipago y otros<br> desde <b>MercadoPago</b></li>
                    </ul>
                 </div>
            </div>
            </div>
        </div>
    <div class="container p-2">
        
        <div class="row">
            
            <div class="col-md-4">
                <div class="card">  
                <div class="card card-body">
                    <?php if(isset($Alertado2020) == true) {
                        echo "<img src='imagenes/codoacodo.jpeg' alt='Logo Codo a Codo' width='150'>";
                    }else{
                        echo "<img src='imagenes/codoacodo.jpeg' alt='Logo Codo a Codo' width='300'>";
                    }
                    ?>
                    
                </div>
            </div>
             
        </div>
        </div>
        <div class="row">
            
            <div class="col-md-4">
                <div class="card">  
                <div class="card card-body">
                    BOLETAS NO DISPONIBLES PARA PAGO ONLINE, SORTEO A REALIZARSE el 27/01
                </div>
            </div>
             
        </div>
            </div>
    </div>
    
<!--Scripts-->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>

</body>
</html>
    