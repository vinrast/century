<?php
//BindEvents Method @1-9AFA953A
function BindEvents()
{
    global $propiedades;
    global $media;
    global $lblComentarios;
    global $vw_propiedades_caracas;
    global $Label1;
    global $Label2;
    global $Label4;
    global $CCSEvents;
    $propiedades->urbanizacion->CCSEvents["BeforeShow"] = "propiedades_urbanizacion_BeforeShow";
    $propiedades->preciom2->CCSEvents["BeforeShow"] = "propiedades_preciom2_BeforeShow";
    $media->CCSEvents["BeforeShowRow"] = "media_BeforeShowRow";
    $lblComentarios->CCSEvents["BeforeShow"] = "lblComentarios_BeforeShow";
    $vw_propiedades_caracas->CCSEvents["BeforeShowRow"] = "vw_propiedades_caracas_BeforeShowRow";
    $vw_propiedades_caracas->ds->CCSEvents["BeforeBuildSelect"] = "vw_propiedades_caracas_ds_BeforeBuildSelect";
    $Label1->CCSEvents["BeforeShow"] = "Label1_BeforeShow";
    $Label2->CCSEvents["BeforeShow"] = "Label2_BeforeShow";
    $Label4->CCSEvents["BeforeShow"] = "Label4_BeforeShow";
    $CCSEvents["BeforeShow"] = "Page_BeforeShow";
}
//End BindEvents Method

//propiedades_urbanizacion_BeforeShow @22-EC35F5BD
function propiedades_urbanizacion_BeforeShow(& $sender)
{
    $propiedades_urbanizacion_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $propiedades; //Compatibility
//End propiedades_urbanizacion_BeforeShow

//Custom Code @35-2A29BDB7
// -------------------------
    if($propiedades->urbanizacion->GetText()!="")
		$propiedades->urbanizacion->SetText(" - ".$propiedades->urbanizacion->GetText());
// -------------------------
//End Custom Code

//Close propiedades_urbanizacion_BeforeShow @22-42969A2D
    return $propiedades_urbanizacion_BeforeShow;
}
//End Close propiedades_urbanizacion_BeforeShow

//propiedades_preciom2_BeforeShow @37-17AEBEFF
function propiedades_preciom2_BeforeShow(& $sender)
{
    $propiedades_preciom2_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $propiedades; //Compatibility
//End propiedades_preciom2_BeforeShow

//Custom Code @38-2A29BDB7
// -------------------------
    if(substr($propiedades->tipo_inmueble->GetText(), 0, 1)=="T")
	{
		if($propiedades->metros_terreno->GetValue()>0)
			$propiedades->preciom2->SetValue($propiedades->preciom2->GetValue()/$propiedades->metros_terreno->GetValue());
	}
	else
	{
		if($propiedades->metros_construccion->GetValue()>0)
			$propiedades->preciom2->SetValue($propiedades->preciom2->GetValue()/$propiedades->metros_construccion->GetValue());
	}
// -------------------------
//End Custom Code

//Close propiedades_preciom2_BeforeShow @37-0CF5875B
    return $propiedades_preciom2_BeforeShow;
}
//End Close propiedades_preciom2_BeforeShow

//media_BeforeShowRow @2-459E02E7
function media_BeforeShowRow(& $sender)
{
    $media_BeforeShowRow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $media; //Compatibility
//End media_BeforeShowRow

//Gallery Layout @7-6715D311
    $NumberOfColumns = $Component->Attributes->GetText("numberOfColumns");
    if (isset($Component->RowOpenTag))
        $Component->RowOpenTag->Visible = ($Component->RowNumber % $NumberOfColumns) == 1;
    if (isset($Component->AltRowOpenTag))
        $Component->AltRowOpenTag->Visible = ($Component->RowNumber % $NumberOfColumns) == 1;
    if (isset($Component->RowCloseTag))
        $Component->RowCloseTag->Visible = (($Component->RowNumber % $NumberOfColumns) == 0);
    if (isset($Component->AltRowCloseTag))
        $Component->AltRowCloseTag->Visible = (($Component->RowNumber % $NumberOfColumns) == 0);
    if (isset($Component->RowComponents))
        $Component->RowComponents->Visible = !$Component->ForceIteration;
    if (isset($Component->AltRowComponents))
        $Component->AltRowComponents->Visible = !$Component->ForceIteration;
    $Component->ForceIteration = (($Component->RowNumber >= $Component->PageSize) || !$Component->DataSource->has_next_record()) && ($Component->RowNumber % $NumberOfColumns);
//End Gallery Layout

//Close media_BeforeShowRow @2-FA0FFE1E
    return $media_BeforeShowRow;
}
//End Close media_BeforeShowRow

//lblComentarios_BeforeShow @31-5EE85440
function lblComentarios_BeforeShow(& $sender)
{
    $lblComentarios_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $lblComentarios; //Compatibility
//End lblComentarios_BeforeShow

//DLookup @32-E73FCD51
    global $DBPrincipal;
    $Page = CCGetParentPage($sender);
    $ccs_result = CCDLookUp("comentarios", "propiedades", "id_mls=".CCGetParam("p",""), $Page->Connections["Principal"]);
    $ccs_result = strval($ccs_result);
    $Container->lblComentarios->SetValue($ccs_result);
//End DLookup

//Close lblComentarios_BeforeShow @31-A750D313
    return $lblComentarios_BeforeShow;
}
//End Close lblComentarios_BeforeShow

//vw_propiedades_caracas_BeforeShowRow @46-B6F74D5D
function vw_propiedades_caracas_BeforeShowRow(& $sender)
{
    $vw_propiedades_caracas_BeforeShowRow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $vw_propiedades_caracas; //Compatibility
//End vw_propiedades_caracas_BeforeShowRow

//Gallery Layout @63-6715D311
    $NumberOfColumns = $Component->Attributes->GetText("numberOfColumns");
    if (isset($Component->RowOpenTag))
        $Component->RowOpenTag->Visible = ($Component->RowNumber % $NumberOfColumns) == 1;
    if (isset($Component->AltRowOpenTag))
        $Component->AltRowOpenTag->Visible = ($Component->RowNumber % $NumberOfColumns) == 1;
    if (isset($Component->RowCloseTag))
        $Component->RowCloseTag->Visible = (($Component->RowNumber % $NumberOfColumns) == 0);
    if (isset($Component->AltRowCloseTag))
        $Component->AltRowCloseTag->Visible = (($Component->RowNumber % $NumberOfColumns) == 0);
    if (isset($Component->RowComponents))
        $Component->RowComponents->Visible = !$Component->ForceIteration;
    if (isset($Component->AltRowComponents))
        $Component->AltRowComponents->Visible = !$Component->ForceIteration;
    $Component->ForceIteration = (($Component->RowNumber >= $Component->PageSize) || !$Component->DataSource->has_next_record()) && ($Component->RowNumber % $NumberOfColumns);
//End Gallery Layout

//Close vw_propiedades_caracas_BeforeShowRow @46-0E2D2C05
    return $vw_propiedades_caracas_BeforeShowRow;
}
//End Close vw_propiedades_caracas_BeforeShowRow

//vw_propiedades_caracas_ds_BeforeBuildSelect @46-B4C26964
function vw_propiedades_caracas_ds_BeforeBuildSelect(& $sender)
{
    $vw_propiedades_caracas_ds_BeforeBuildSelect = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $vw_propiedades_caracas; //Compatibility
//End vw_propiedades_caracas_ds_BeforeBuildSelect

//Custom Code @64-2A29BDB7
// -------------------------
    $orden = CCGetParam("orden","id_mls DESC");
	$vw_propiedades_caracas->DataSource->Order = $orden;

// -------------------------
//End Custom Code

//Close vw_propiedades_caracas_ds_BeforeBuildSelect @46-964929C9
    return $vw_propiedades_caracas_ds_BeforeBuildSelect;
}
//End Close vw_propiedades_caracas_ds_BeforeBuildSelect

//Label1_BeforeShow @106-62EBFD0A
function Label1_BeforeShow(& $sender)
{
    $Label1_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $Label1; //Compatibility
//End Label1_BeforeShow

//DLookup @107-D432F43F
    global $DBPrincipal;
    $Page = CCGetParentPage($sender);
    $ccs_result = CCDLookUp("tipo_inmueble", "propiedades", "id_mls = ".CCGetParam("p",""), $Page->Connections["Principal"]);
    $ccs_result = strval($ccs_result);
    $Container->Label1->SetValue($ccs_result);
//End DLookup

//Close Label1_BeforeShow @106-B48DF954
    return $Label1_BeforeShow;
}
//End Close Label1_BeforeShow

//Label2_BeforeShow @108-5E5A3E45
function Label2_BeforeShow(& $sender)
{
    $Label2_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $Label2; //Compatibility
//End Label2_BeforeShow

//Retrieve Value for Control @109-1669B1B1
    $Container->Label2->SetValue(CCGetFromGet("p", ""));
//End Retrieve Value for Control

//Close Label2_BeforeShow @108-C8ECDC8F
    return $Label2_BeforeShow;
}
//End Close Label2_BeforeShow

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

//Page_BeforeShow @1-8F5CB11E
function Page_BeforeShow(& $sender)
{
    $Page_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $inmueble; //Compatibility
//End Page_BeforeShow

//Custom Code @110-2A29BDB7
// -------------------------
    global $DBPrincipal,$propiedades1,$Panel1,$Label3;
    $Page = CCGetParentPage($sender);
    $ccs_result = CCDLookUp("id_oficina", "propiedades", "id_mls = ".CCGetParam("p",""), $Page->Connections["Principal"]);
    $ccs_result = strval($ccs_result);
	
	$propiedades1->Visible = ($ccs_result=="23646");
	$Panel1->Visible = !($ccs_result=="23646");
	$Label3->SetText(($ccs_result=="23646")?"l Asesor":" la Oficina");
// -------------------------
//End Custom Code

//Close Page_BeforeShow @1-4BC230CD
    return $Page_BeforeShow;
}
//End Close Page_BeforeShow

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
