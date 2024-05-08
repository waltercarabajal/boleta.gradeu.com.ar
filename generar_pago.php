<?php
$access_token = 'APP_USR-3172480243458215-032513-da79342c11ef0c70c891aced723ee718-538711713'; // Reemplaza con tu access_token

// Si estás usando Checkout Pro, también necesitas el id de la preferencia
$preference_id = 'TU_PREFERENCE_ID'; // Reemplaza con tu preference_id

require 'vendor/autoload.php'; // Asegúrate de tener instalada la librería de MercadoPago

MercadoPago\SDK::setAccessToken($access_token);

// Si estás usando Checkout Pro, obtén la preferencia
$preference = MercadoPago\Preference::find_by_id($preference_id);

// Si estás usando la API para generar un pago
$preference = new MercadoPago\Preference();
$item = new MercadoPago\Item();
$item->title = "Producto Ejemplo";
$item->quantity = 1;
$item->unit_price = 10.00;
$preference->items = array($item);
$preference->save();

// Imprime el botón de pago
echo "<a href='" . $preference->sandbox_init_point . "' name='MP-Checkout' class='orange-L-Rn-RoRn_Button'>Pagar</a>";
?>
