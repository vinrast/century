<?php
//BindEvents Method @1-DA0C1251
function BindEvents()
{
    global $Label4;
    $Label4->CCSEvents["BeforeShow"] = "Label4_BeforeShow";
}
//End BindEvents Method

//DEL  // -------------------------
//DEL      $orden = CCGetParam("orden","id_mls DESC");
//DEL  	$vw_propiedades_caracas->DataSource->Order = $orden;
//DEL  
//DEL  // -------------------------

//Label4_BeforeShow @121-2739B8DB
function Label4_BeforeShow(& $sender)
{
    $Label4_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $Label4; //Compatibility
//End Label4_BeforeShow

//Retrieve Value for Control @122-CD645705
    $Container->Label4->SetValue(CCGetFromGet("p", ""));
//End Retrieve Value for Control

//Close Label4_BeforeShow @121-302E9739
    return $Label4_BeforeShow;
}
//End Close Label4_BeforeShow

function curl_get($url) 
 {    
     $defaults = array( 
         CURLOPT_URL => $url, 
         CURLOPT_HEADER => 0, 
         CURLOPT_RETURNTRANSFER => TRUE, 
     ); 
     
     $ch = curl_init(); 
     curl_setopt_array($ch, $defaults); 
     if( ! $result = curl_exec($ch)) 
     { 
         //trigger_error(curl_error($ch)); 
     } 
     curl_close($ch); 
     return $result; 
 } 
?>
