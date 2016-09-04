<?php
//BindEvents Method @1-45949696
function BindEvents()
{
    global $propiedades;
    global $vw_propiedades_caracas;
    $propiedades->CCSEvents["BeforeShowRow"] = "propiedades_BeforeShowRow";
    $vw_propiedades_caracas->CCSEvents["BeforeShowRow"] = "vw_propiedades_caracas_BeforeShowRow";
}
//End BindEvents Method

//propiedades_BeforeShowRow @31-67E075E3
function propiedades_BeforeShowRow(& $sender)
{
    $propiedades_BeforeShowRow = true;
    $Component = & $sender;
    $Container = & CCGetParentContainer($sender);
    global $propiedades; //Compatibility
//End propiedades_BeforeShowRow

//Gallery Layout @39-6715D311
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

//Close propiedades_BeforeShowRow @31-E06366FE
    return $propiedades_BeforeShowRow;
}
//End Close propiedades_BeforeShowRow

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


?>
