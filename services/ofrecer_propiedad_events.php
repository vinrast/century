<?php
//BindEvents Method @1-D40060DD
function BindEvents()
{
    global $CCSEvents;
    $CCSEvents["BeforeShow"] = "Page_BeforeShow";
}
//End BindEvents Method

//Page_BeforeShow @1-E777E0DC
function Page_BeforeShow(& $sender)
{
    $Page_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $ofrecer_propiedad; //Compatibility
//End Page_BeforeShow

//Custom Code @126-2A29BDB7
// -------------------------
   	$DBPrincipal = new clsDBPrincipal();

    $from_name = CCGetParam("nombre","");
	$from_email = CCGetParam("email","");
	$telefono = CCGetParam("telefono","");
	$tipo_inmueble = CCGetParam("tipo_inmueble","");
	$tipo_negocio = CCGetParam("tipo_negocio","");
	$zona = CCGetParam("zona","");
	$habitaciones = CCGetParam("habitaciones","0");
	$banos = CCGetParam("banos","0");
	$estacionamientos = CCGetParam("estacionamientos","0");
	$metros_construccion = CCGetParam("metros_construccion","0");
	$metros_terreno = CCGetParam("metros_terreno","0");
	$precio = CCGetParam("precio","");
	$observaciones = CCGetParam("observaciones","");

	$to_email = "info@century21caracas.com";

	$headers = "From: ".$from_name."<".$from_email.">;\r\n";
	$headers .= "Content-Type: text/html; charset=utf-8";
	$subject  = "Tengo interés en $tipo_negocio una propiedad";
	$message  = "Tipo de Inmueble: $tipo_inmueble<br />
				 Zona: $zona<br />
				 Habitaciones: $habitaciones<br />
				 Banos: $banos<br />
				 Puestos Est.: $estacionamientos<br />
				 Metros Const.: $metros_construccion m2<br />
				 Metros Terr.: $metros_terreno m2<br />
				 Precio: $precio<br /><br />
				 Observaciones:<br />
				 $observaciones
				 ";

	if($telefono!="")
		$message .= "<br /><br />Mi número telefónico es:".$telefono;

	mail ($to_email,$subject,$message,$headers);
// -------------------------
//End Custom Code

//Close Page_BeforeShow @1-4BC230CD
    return $Page_BeforeShow;
}
//End Close Page_BeforeShow


?>
