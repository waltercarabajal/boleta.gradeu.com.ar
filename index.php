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

//--SACAR--
/*$fsol=0;
$fdni=0;*/
//--SACAR--


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
      //  $('#mostrarmodal').modal({backdrop: 'static', keyboard: false})
      });
    </script>
</head>
<body>
      <div class="modal fade" id="mostrarmodal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                 <div class="modal-header">
                     <h2 class='h5'>Novedades</h2><img src="imagenes/2402codoacodo.png" class="img-fluid" width=70px alt="Responsive image">
                    <!-- <a href="#" data-dismiss="modal" class="btn btn-danger">Cerrar</a> -->
                 </div>
                 <div class="modal-body">
                     
                     <!-- <div class="alert alert-danger" role="alert">
                        <p class="text-start">Estimado usuario:</p>
                        <p class="text-center">Le informamos que la pagina se encuentra inhabilitada hasta el 02/05/2024. </p>
                        <p class="text-center">Disculpe, las molestias ocasionadas</p>
                     </div>-->
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
                    
                                       <!-- <div class="alert alert-danger" role="alert">
                                            Pagina inhabilitada  hasta el 04/04/2024
                                        </div>-->
                                      <!--  <div class="alert alert-info" role="alert">
                                            Proximo sorteo 30/03/2024
                                        </div> -->

                    <?php if(isset($Alertado2020) == true) {
                        echo "<img src='imagenes/2402codoacodo.png' alt='Logo Codo a Codo' width='150'>";
                    }else{
                        echo "<img src='imagenes/2402codoacodo.png' alt='Logo Codo a Codo' width='300'>";
                    }
                    ?>
                    <form name="busqueda" action="index.php" method="post">
                    <label for="dni">N° D.N.I.</label>
                    <input class="form-control" type="number" id="dni" name="dni" required>
                    <label for="solicitud">N° Sorteo o Solicitud</label>
                    <input class="form-control" type="number" id="solicitud" name="solicitud" required>
                    <button class="btn btn-primary mb-2" type="submit">Boleta</button>
                    <?php if(isset($Alertado2020) == true) {
                echo '
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                Boleta Encontrada Presione Pagar más abajo
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
                </div>
                ';
            session_unset();}
            ?>
                    </form>
                </div>
                </div>
                <div class="col-md-8">
                    <?php
            if ($consu=="ESPERANDO"){
                echo "<br>".$consu;
            }else{
                //echo "<br>".$consu;
                //echo "<br>".$vTitulo."-".$vPesos."-".$vNroSorteo."-".$vApellido."-".$vNombres;
                
                //$descriptor = "Solicitud ".str_pad($fsol, 7, "0", STR_PAD_LEFT)." Cuota Junio 2020 |N°Sorteo ".$vNroSorteo." (".$vApellido." ".$vNombres.")";
                
                if ($vOK==1){
                $descriptor = "Solicitud ".str_pad($vIdSuscripcion, 7, "0", STR_PAD_LEFT)." Cuota Marzo 2024 (".str_pad($vCuota, 3, "0", STR_PAD_LEFT).")|N°Sorteo ".str_pad($vNroSorteo, 3, "0", STR_PAD_LEFT)." (".$vApellido." ".$vNombres.")";
                echo "<fieldset name='resultado'>
		<legend><b>Datos del Cliente</b></legend>";  
                echo "<b>".$vApellido." ".$vNombres."</b> | DNI: <b>".$fdni."</b><br>";
                echo "Solicitud N°<b>".$vIdSuscripcion."</b> con N° de Sorteo <b>".$vNroSorteo."</b>";
                echo "MONTO A PAGAR2: <b>$".$vPesos.".- </b>N°Cuota Marzo: <b>".$vCuota."</b>";
                //echo "MONTO A PAGAR: <b>$".$vPesos.".- </b>";
                                    // SDK de Mercado Pago
                require __DIR__ .  '/vendor/autoload.php';

                // Agrega credenciales
                MercadoPago\SDK::setAccessToken('APP_USR-3172480243458215-032513-da79342c11ef0c70c891aced723ee718-538711713');

                // Crea un objeto de preferencia
                $preference = new MercadoPago\Preference();

                // Crea un ítem en la preferencia
                $item = new MercadoPago\Item();
                //$item->title = 'Plan Norteño Solicitu 123456 | Sorteo 999';
                $item->title = $descriptor;
                $item->quantity = 1;
                $item->unit_price = $vPesos;
                //$item->date_of_expiration = "2020-05-27T10:47:58.000-04:00";
                $preference->items = array($item);
                $preference->save();
                //IngresaBoton
                echo "<form action='/procesar-pago' method='POST'>
                  <script
                   src='https://www.mercadopago.com.ar/integrations/v1/web-payment-checkout.js'
                   data-preference-id='".$preference->id."'>
                  </script>
                </form>";
                echo "</fieldset>";                    
                }else{
                    //echo "CLIENTE NO ENCONTRADO <br>";
                    //include("conectorgb.inc");
                    $conexionBoleta2= new mysqli($host_db,$user_db,$pass_db,$db_name,3306);
                    $strConsultaBoleta2 = "select * from boletas where xNroSorteo = '".$fsol."' AND xDNI = ".$fdni;
                    //echo $strConsultaBoleta2."<br>";
                    $resultBoleta2 = $conexionBoleta2->query($strConsultaBoleta2);
                    if ($resultBoleta2->num_rows === 0) {
                         $vOK = 0;
                    echo "CLIENTE NO ENCONTRADO<br>";
                    }else{
                        while($fila2 = $resultBoleta2->fetch_array()){
                                $vOK = 1;
                                $vTitulo = $fila2["idTitulo"];
                                $vPesos = $fila2["xPesos"];
                                $vEndozo = $fila2["xEndozo"];
                                $vNroSorteo = $fila2["xNroSorteo"];
                                $vApellido = $fila2["xApellido"];
                                $vNombres = $fila2["xNombres"];
                                $vIdSuscripcion = $fila2["idSuscripcion"];
                                $vCuota = $fila2["xCta"];
                                $vEstadoPago = $fila2["xEstadoPago"];
                                $Alertado2020 = true;
                        }
                        echo "<fieldset name='resultado'>
		<legend><b>Datos del Cliente</b></legend>";  
                //echo "<b>".$vApellido." ".$vNombres."</b> | DNI: <b>".$fdni."</b>";
                echo "<b>".$vApellido." ".$vNombres."</b>";
                echo " Solicitud <b>".$vIdSuscripcion."</b><br>con N° Sorteo <b>".$vNroSorteo."</b>";
                echo " Cta:<b>".$vCuota."</b> MONTO Actual: <b>$".$vPesos."</b>";
                if ($vEstadoPago==0){
                $descriptor = "Solicitud ".str_pad($vIdSuscripcion, 7, "0", STR_PAD_LEFT)." Cuota Marzo 2024 (".str_pad($vCuota, 3, "0", STR_PAD_LEFT).")|N°Sorteo ".str_pad($vNroSorteo, 3, "0", STR_PAD_LEFT)." (".$vApellido." ".$vNombres.")";
                                    // SDK de Mercado Pago
                require __DIR__ .  '/vendor/autoload.php';

                // Agrega credenciales
                //MercadoPago\SDK::setAccessToken('TEST-3172480243458215-032513-96061b20c3315ed1a532dfe277b2c86d-538711713');
                MercadoPago\SDK::setAccessToken('APP_USR-3172480243458215-032513-da79342c11ef0c70c891aced723ee718-538711713');

                // Crea un objeto de preferencia
                $preference = new MercadoPago\Preference();

                // Crea un ítem en la preferencia
                $item = new MercadoPago\Item();
                //$item->title = 'Plan Norteño Solicitu 123456 | Sorteo 999';
                $item->title = $descriptor;
                $item->quantity = 1;
                $item->unit_price = $vPesos;
                //$item->date_of_expiration = "2020-05-27T10:47:58.000-04:00";
                $preference->items = array($item);
                $preference->save();
                //IngresaBoton
                echo "<form action='/procesar-pago' method='POST'>
                <script
                src='https://www.mercadopago.com.ar/integrations/v1/web-payment-checkout.js'
                data-preference-id='".$preference->id."'>
                </script>
                </form>";
                }else{
                echo "<small style='color: red;'><b>CUPON ".$vCuota." NO DISPONIBLE PARA GENERAR ONLINE</b></small>";
                }
                if ($vEndozo==0){    
                    echo "</fieldset>";
                }else{
                    echo "<div class='card-footer'>";
                    echo "<b>Endozo</b> de apliacion $ <b>".$vEndozo."</b>";
                    
                    //Primer Endozo
                    
                        if ($vEstadoPago==0){
                        $descriptor = "CtaEndoso ".str_pad($vIdSuscripcion, 7, "0", STR_PAD_LEFT)." Cuota Marzo 2024 (".str_pad($vCuota, 3, "0", STR_PAD_LEFT).")|N°Sorteo ".str_pad($vNroSorteo, 3, "0", STR_PAD_LEFT)." (".$vApellido." ".$vNombres.")";
                                            // SDK de Mercado Pago
                        require __DIR__ .  '/vendor/autoload.php';

                        // Agrega credenciales
                        //MercadoPago\SDK::setAccessToken('TEST-3172480243458215-032513-96061b20c3315ed1a532dfe277b2c86d-538711713');
                        MercadoPago\SDK::setAccessToken('APP_USR-3172480243458215-032513-da79342c11ef0c70c891aced723ee718-538711713');

                        // Crea un objeto de preferencia
                        $preference = new MercadoPago\Preference();

                        // Crea un ítem en la preferencia
                        $item = new MercadoPago\Item();
                        //$item->title = 'Plan Norteño Solicitu 123456 | Sorteo 999';
                        $item->title = $descriptor;
                        $item->quantity = 1;
                        $item->unit_price = $vEndozo;
                        //$item->date_of_expiration = "2020-05-27T10:47:58.000-04:00";
                        $preference->items = array($item);
                        $preference->save();
                        //IngresaBoton
                        echo "<form action='/procesar-pago' method='POST'>
                        <script
                        src='https://www.mercadopago.com.ar/integrations/v1/web-payment-checkout.js'
                        data-preference-id='".$preference->id."'>
                        </script>
                        </form>";
                        }else{
                        echo "<small style='color: red;'><b>CUPON ".$vCuota." NO DISPONIBLE PARA GENERAR ONLINE</b></small>";
                        }
                    
                    //FIN Primer Endozo
                    
                    
                    
                    echo "</div>";
                    echo "</fieldset>";
                    
                    
                    
                }
                
                }
            }}
            ?>
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
    