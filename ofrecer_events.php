<?php
//BindEvents Method @1-5B56375D
function BindEvents()
{
    global $hdnTipoInmueble;
    $hdnTipoInmueble->CCSEvents["BeforeShow"] = "hdnTipoInmueble_BeforeShow";
}
//End BindEvents Method

//hdnTipoInmueble_BeforeShow @31-1535A979
function hdnTipoInmueble_BeforeShow(& $sender)
{
    $hdnTipoInmueble_BeforeShow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $hdnTipoInmueble; //Compatibility
//End hdnTipoInmueble_BeforeShow

//Custom Code @32-2A29BDB7
// -------------------------
    
// -------------------------
//End Custom Code

//Close hdnTipoInmueble_BeforeShow @31-CD00DFC6
    return $hdnTipoInmueble_BeforeShow;
}
//End Close hdnTipoInmueble_BeforeShow


?>
