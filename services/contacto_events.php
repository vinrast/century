<?php
//BindEvents Method @1-D40060DD
function BindEvents()
{
    global $CCSEvents;
    $CCSEvents["BeforeShow"] = "Page_BeforeShow";
}
//End BindEvents Method

//Page_BeforeShow @1-2B6AC3E9
function Page_BeforeShow(& $sender)
{
    $Page_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $contacto; //Compatibility
//End Page_BeforeShow

//Custom Code @126-2A29BDB7
// -------------------------
	$to_email = "info@century21caracas.com";

	$from_email = CCGetParam("e","");
	$from_name = CCGetParam("n","");

	$headers = "From: ".$from_name."<".$from_email.">;\r\n";
	$headers .= "Content-Type: text/html; charset=utf-8";
	$subject  = "Contacto desde century21caracas.com";
	$message  = CCGetParam("m","");

	if(CCGetParam("t","")!="")
		$message .= "<br /><br />Mi número telefónico es:".CCGetParam("t","");

	mail ($to_email,$subject,$message,$headers);
// -------------------------
//End Custom Code

//Close Page_BeforeShow @1-4BC230CD
    return $Page_BeforeShow;
}
//End Close Page_BeforeShow


?>
