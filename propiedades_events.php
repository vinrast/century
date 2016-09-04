<?php
//BindEvents Method @1-42CE3F7C
function BindEvents()
{
    global $vw_propiedades_caracas;
    global $lblZona;
    global $lblHab;
    global $lblBanos;
    global $lblPuestos;
    global $lblTipo;
    global $lblMetrosConst;
    global $lblMetrosTerr;
    global $lblPrecio;
    global $hdnTipoInmueble;
    global $CCSEvents;
    $vw_propiedades_caracas->CCSEvents["BeforeShowRow"] = "vw_propiedades_caracas_BeforeShowRow";
    $vw_propiedades_caracas->ds->CCSEvents["BeforeBuildSelect"] = "vw_propiedades_caracas_ds_BeforeBuildSelect";
    $lblZona->CCSEvents["BeforeShow"] = "lblZona_BeforeShow";
    $lblHab->CCSEvents["BeforeShow"] = "lblHab_BeforeShow";
    $lblBanos->CCSEvents["BeforeShow"] = "lblBanos_BeforeShow";
    $lblPuestos->CCSEvents["BeforeShow"] = "lblPuestos_BeforeShow";
    $lblTipo->CCSEvents["BeforeShow"] = "lblTipo_BeforeShow";
    $lblMetrosConst->CCSEvents["BeforeShow"] = "lblMetrosConst_BeforeShow";
    $lblMetrosTerr->CCSEvents["BeforeShow"] = "lblMetrosTerr_BeforeShow";
    $lblPrecio->CCSEvents["BeforeShow"] = "lblPrecio_BeforeShow";
    $hdnTipoInmueble->CCSEvents["BeforeShow"] = "hdnTipoInmueble_BeforeShow";
    $CCSEvents["BeforeShow"] = "Page_BeforeShow";
}
//End BindEvents Method

//vw_propiedades_caracas_BeforeShowRow @75-B6F74D5D
function vw_propiedades_caracas_BeforeShowRow(& $sender)
{
    $vw_propiedades_caracas_BeforeShowRow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $vw_propiedades_caracas; //Compatibility
//End vw_propiedades_caracas_BeforeShowRow

//Gallery Layout @77-6715D311
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

//Close vw_propiedades_caracas_BeforeShowRow @75-0E2D2C05
    return $vw_propiedades_caracas_BeforeShowRow;
}
//End Close vw_propiedades_caracas_BeforeShowRow

//vw_propiedades_caracas_ds_BeforeBuildSelect @75-B4C26964
function vw_propiedades_caracas_ds_BeforeBuildSelect(& $sender)
{
    $vw_propiedades_caracas_ds_BeforeBuildSelect = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $vw_propiedades_caracas; //Compatibility
//End vw_propiedades_caracas_ds_BeforeBuildSelect

//Custom Code @147-2A29BDB7
// -------------------------
    $orden = CCGetParam("orden","id_mls DESC");
	$vw_propiedades_caracas->DataSource->Order = $orden;

// -------------------------
//End Custom Code

//Close vw_propiedades_caracas_ds_BeforeBuildSelect @75-964929C9
    return $vw_propiedades_caracas_ds_BeforeBuildSelect;
}
//End Close vw_propiedades_caracas_ds_BeforeBuildSelect

//lblZona_BeforeShow @129-9EE0CC94
function lblZona_BeforeShow(& $sender)
{
    $lblZona_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $lblZona; //Compatibility
//End lblZona_BeforeShow

//Retrieve Value for Control @130-011CF857
    $Container->lblZona->SetValue(CCGetFromGet("zona", ""));
//End Retrieve Value for Control

//Close lblZona_BeforeShow @129-D0C35845
    return $lblZona_BeforeShow;
}
//End Close lblZona_BeforeShow

//lblHab_BeforeShow @131-6A154D65
function lblHab_BeforeShow(& $sender)
{
    $lblHab_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $lblHab; //Compatibility
//End lblHab_BeforeShow

//Custom Code @132-2A29BDB7
// -------------------------
    if(CCGetParam("habitaciones","")!="")
	{
		$lblHab->Visible = true;
		$lblHab->SetText(CCGetParam("habitaciones","")." Habitacion(es)<br />");
	}
	else
		$lblHab->Visible = false;
// -------------------------
//End Custom Code

//Close lblHab_BeforeShow @131-80BA0FDA
    return $lblHab_BeforeShow;
}
//End Close lblHab_BeforeShow

//lblBanos_BeforeShow @133-C60B7067
function lblBanos_BeforeShow(& $sender)
{
    $lblBanos_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $lblBanos; //Compatibility
//End lblBanos_BeforeShow

//Custom Code @134-2A29BDB7
// -------------------------
    if(CCGetParam("banos","")!="")
	{
		$lblBanos->Visible = true;
		$lblBanos->SetText(CCGetParam("banos","")." Bao(s)<br />");
	}
	else
		$lblBanos->Visible = false;
// -------------------------
//End Custom Code

//Close lblBanos_BeforeShow @133-04401304
    return $lblBanos_BeforeShow;
}
//End Close lblBanos_BeforeShow

//lblPuestos_BeforeShow @135-22D1943B
function lblPuestos_BeforeShow(& $sender)
{
    $lblPuestos_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $lblPuestos; //Compatibility
//End lblPuestos_BeforeShow

//Custom Code @136-2A29BDB7
// -------------------------
    if(CCGetParam("estacionamientos","")!="")
	{
		$lblPuestos->Visible = true;
		$lblPuestos->SetText(CCGetParam("estacionamientos","")." Puesto(s)<br />");
	}
	else
		$lblPuestos->Visible = false;
// -------------------------
//End Custom Code

//Close lblPuestos_BeforeShow @135-E818A411
    return $lblPuestos_BeforeShow;
}
//End Close lblPuestos_BeforeShow

//lblTipo_BeforeShow @137-86554BE8
function lblTipo_BeforeShow(& $sender)
{
    $lblTipo_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $lblTipo; //Compatibility
//End lblTipo_BeforeShow

//Custom Code @138-2A29BDB7
// -------------------------
    $lblTipo->SetText(CCGetParam("tipo_inmueble","")." en ".CCGetParam("tipo_negocio",""));
// -------------------------
//End Custom Code

//Close lblTipo_BeforeShow @137-A0FC1B8D
    return $lblTipo_BeforeShow;
}
//End Close lblTipo_BeforeShow

//lblMetrosConst_BeforeShow @139-3CB6C63F
function lblMetrosConst_BeforeShow(& $sender)
{
    $lblMetrosConst_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $lblMetrosConst; //Compatibility
//End lblMetrosConst_BeforeShow

//Custom Code @140-2A29BDB7
// -------------------------
    $value1 = CCGetParam("metros_construccion_1","");
	$value2 = CCGetParam("metros_construccion_2","");

	$value1 = ($value1!="")?$value1:"0";
	$value2 = ($value2!="")?$value2:"Mx";

	if($value1!="0"||$value2!="Mx")
	{
		$lblMetrosConst->Visible = true;
		$lblMetrosConst->SetText($value1." - ".$value2." m de Construccin");
	}
	else
		$lblMetrosConst->Visible = false;

// -------------------------
//End Custom Code

//Close lblMetrosConst_BeforeShow @139-E6578CC8
    return $lblMetrosConst_BeforeShow;
}
//End Close lblMetrosConst_BeforeShow

//lblMetrosTerr_BeforeShow @141-0F07AD8F
function lblMetrosTerr_BeforeShow(& $sender)
{
    $lblMetrosTerr_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $lblMetrosTerr; //Compatibility
//End lblMetrosTerr_BeforeShow

//Custom Code @142-2A29BDB7
// -------------------------
    $value1 = CCGetParam("metros_terreno_1","");
	$value2 = CCGetParam("metros_terreno_2","");

	$value1 = ($value1!="")?$value1:"0";
	$value2 = ($value2!="")?$value2:"Mx";

	if($value1!="0"||$value2!="Mx")
	{
		$lblMetrosTerr->Visible = true;
		$lblMetrosTerr->SetText($value1." - ".$value2." m de Terreno");
	}
	else
		$lblMetrosTerr->Visible = false;
// -------------------------
//End Custom Code

//Close lblMetrosTerr_BeforeShow @141-47E57BDB
    return $lblMetrosTerr_BeforeShow;
}
//End Close lblMetrosTerr_BeforeShow

//lblPrecio_BeforeShow @143-FEBE6393
function lblPrecio_BeforeShow(& $sender)
{
    $lblPrecio_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $lblPrecio; //Compatibility
//End lblPrecio_BeforeShow

//Custom Code @144-2A29BDB7
// -------------------------
    $value1 = CCGetParam("precio_1","");
	$value2 = CCGetParam("precio_2","");
	
	$value1 = ($value1!="")?CCFormatNumber($value1,array(False, 0, ",", ".", False, "", "", 1, True, ""),ccsInteger):"0";
	$value2 = ($value2!="")?CCFormatNumber($value2,array(False, 0, ",", ".", False, "", "", 1, True, ""),ccsInteger):"Mx";

	if($value1!="0"||$value2!="Mx")
	{
		$lblPrecio->Visible = true;
		$lblPrecio->SetText("Precio entre Bs. ".$value1." - ".$value2);
	}
	else
		$lblPrecio->Visible = false;
// -------------------------
//End Custom Code

//Close lblPrecio_BeforeShow @143-4EBBC7F5
    return $lblPrecio_BeforeShow;
}
//End Close lblPrecio_BeforeShow

//DEL  // -------------------------
//DEL      $Container->lblOrden->SetValue(CCGetFromGet("orden", "id_mls DESC"));
//DEL  // -------------------------

//hdnTipoInmueble_BeforeShow @149-1535A979
function hdnTipoInmueble_BeforeShow(& $sender)
{
    $hdnTipoInmueble_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $hdnTipoInmueble; //Compatibility
//End hdnTipoInmueble_BeforeShow

//Custom Code @151-2A29BDB7
// -------------------------
    
// -------------------------
//End Custom Code

//Close hdnTipoInmueble_BeforeShow @149-CD00DFC6
    return $hdnTipoInmueble_BeforeShow;
}
//End Close hdnTipoInmueble_BeforeShow

//Page_BeforeShow @1-EAF70085
function Page_BeforeShow(& $sender)
{
    $Page_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $propiedades; //Compatibility
//End Page_BeforeShow

//Custom Code @152-2A29BDB7
// -------------------------
    $Container->hdnOrden->SetValue(CCGetFromGet("orden", "id_mls DESC"));
	$Container->hdnTipoInmueble->SetValue(CCGetFromGet("tipo_inmueble", "Apartamento"));
	$Container->hdnTipoNegocio->SetValue(CCGetFromGet("tipo_negocio", "Venta"));
	$Container->hdnHabitaciones->SetValue(CCGetFromGet("habitaciones", ""));
	$Container->hdnBanos->SetValue(CCGetFromGet("banos", ""));
	$Container->hdnEstacionamientos->SetValue(CCGetFromGet("estacionamientos", ""));
	$Container->hdnPage->SetValue(CCGetFromGet("vw_propiedades_caracasPage", ""));
	$Container->txtZona->SetValue(CCGetFromGet("zona", ""));
	$Container->txtMetrosc1->SetValue(CCGetFromGet("metros_construccion_1", ""));
	$Container->txtMetrosc2->SetValue(CCGetFromGet("metros_construccion_2", ""));
	$Container->txtMetrost1->SetValue(CCGetFromGet("metros_terreno_1", ""));
	$Container->txtMetrost2->SetValue(CCGetFromGet("metros_terreno_2", ""));
	$Container->chkComercial->SetValue((CCGetFromGet("comercial", "")!="1")?"":"checked");
	$Container->txtPrecio1->SetValue(CCGetFromGet("precio_1", ""));
	$Container->txtPrecio2->SetValue(CCGetFromGet("precio_2", ""));
// -------------------------
//End Custom Code

//Close Page_BeforeShow @1-4BC230CD
    return $Page_BeforeShow;
}
//End Close Page_BeforeShow


?>
