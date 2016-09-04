<?php
//Include Common Files @1-F4E1D333
define("RelativePath", ".");
define("PathToCurrentPage", "/");
define("FileName", "inmueble_old.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

class clsRecordpropiedades { //propiedades Class @18-915B4767

//Variables @18-9E315808

    // Public variables
    public $ComponentType = "Record";
    public $ComponentName;
    public $Parent;
    public $HTMLFormAction;
    public $PressedButton;
    public $Errors;
    public $ErrorBlock;
    public $FormSubmitted;
    public $FormEnctype;
    public $Visible;
    public $IsEmpty;

    public $CCSEvents = "";
    public $CCSEventResult;

    public $RelativePath = "";

    public $InsertAllowed = false;
    public $UpdateAllowed = false;
    public $DeleteAllowed = false;
    public $ReadAllowed   = false;
    public $EditMode      = false;
    public $ds;
    public $DataSource;
    public $ValidatingControls;
    public $Controls;
    public $Attributes;

    // Class variables
//End Variables

//Class_Initialize Event @18-C850E18E
    function clsRecordpropiedades($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record propiedades/Error";
        $this->DataSource = new clspropiedadesDataSource($this);
        $this->ds = & $this->DataSource;
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "propiedades";
            $this->Attributes = new clsAttributes($this->ComponentName . ":");
            $CCSForm = explode(":", CCGetFromGet("ccsForm", ""), 2);
            if(sizeof($CCSForm) == 1)
                $CCSForm[1] = "";
            list($FormName, $FormMethod) = $CCSForm;
            $this->EditMode = ($FormMethod == "Edit");
            $this->FormEnctype = "application/x-www-form-urlencoded";
            $this->FormSubmitted = ($FormName == $this->ComponentName);
            $Method = $this->FormSubmitted ? ccsPost : ccsGet;
            $this->habitaciones = new clsControl(ccsLabel, "habitaciones", "Habitaciones", ccsSingle, "", CCGetRequestParam("habitaciones", $Method, NULL), $this);
            $this->banos = new clsControl(ccsLabel, "banos", "Banos", ccsSingle, "", CCGetRequestParam("banos", $Method, NULL), $this);
            $this->estacionamientos = new clsControl(ccsLabel, "estacionamientos", "Estacionamientos", ccsSingle, "", CCGetRequestParam("estacionamientos", $Method, NULL), $this);
            $this->metros_construccion = new clsControl(ccsLabel, "metros_construccion", "Metros Construccion", ccsSingle, "", CCGetRequestParam("metros_construccion", $Method, NULL), $this);
            $this->metros_terreno = new clsControl(ccsLabel, "metros_terreno", "Metros Terreno", ccsSingle, "", CCGetRequestParam("metros_terreno", $Method, NULL), $this);
            $this->estado = new clsControl(ccsLabel, "estado", "Estado", ccsText, "", CCGetRequestParam("estado", $Method, NULL), $this);
            $this->ciudad = new clsControl(ccsLabel, "ciudad", "Ciudad", ccsText, "", CCGetRequestParam("ciudad", $Method, NULL), $this);
            $this->urbanizacion = new clsControl(ccsLabel, "urbanizacion", "Urbanizacion", ccsText, "", CCGetRequestParam("urbanizacion", $Method, NULL), $this);
            $this->tipo_inmueble = new clsControl(ccsLabel, "tipo_inmueble", "Tipo Inmueble", ccsText, "", CCGetRequestParam("tipo_inmueble", $Method, NULL), $this);
            $this->lblCodigo = new clsControl(ccsLabel, "lblCodigo", "lblCodigo", ccsText, "", CCGetRequestParam("lblCodigo", $Method, NULL), $this);
            $this->tipo_negocio = new clsControl(ccsLabel, "tipo_negocio", "tipo_negocio", ccsText, "", CCGetRequestParam("tipo_negocio", $Method, NULL), $this);
            $this->precio = new clsControl(ccsLabel, "precio", "precio", ccsSingle, array(False, 0, ",", ".", False, "", "", 1, True, ""), CCGetRequestParam("precio", $Method, NULL), $this);
            $this->preciom2 = new clsControl(ccsLabel, "preciom2", "preciom2", ccsSingle, array(False, 0, ",", ".", False, "", "", 1, True, ""), CCGetRequestParam("preciom2", $Method, NULL), $this);
            if(!is_array($this->preciom2->Value) && !strlen($this->preciom2->Value) && $this->preciom2->Value !== false)
                $this->preciom2->SetText(0);
        }
    }
//End Class_Initialize Event

//Initialize Method @18-392739A8
    function Initialize()
    {

        if(!$this->Visible)
            return;

        $this->DataSource->Parameters["urlp"] = CCGetFromGet("p", NULL);
    }
//End Initialize Method

//Validate Method @18-367945B8
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @18-F4FBFE05
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->habitaciones->Errors->Count());
        $errors = ($errors || $this->banos->Errors->Count());
        $errors = ($errors || $this->estacionamientos->Errors->Count());
        $errors = ($errors || $this->metros_construccion->Errors->Count());
        $errors = ($errors || $this->metros_terreno->Errors->Count());
        $errors = ($errors || $this->estado->Errors->Count());
        $errors = ($errors || $this->ciudad->Errors->Count());
        $errors = ($errors || $this->urbanizacion->Errors->Count());
        $errors = ($errors || $this->tipo_inmueble->Errors->Count());
        $errors = ($errors || $this->lblCodigo->Errors->Count());
        $errors = ($errors || $this->tipo_negocio->Errors->Count());
        $errors = ($errors || $this->precio->Errors->Count());
        $errors = ($errors || $this->preciom2->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        $errors = ($errors || $this->DataSource->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//MasterDetail @18-ED598703
function SetPrimaryKeys($keyArray)
{
    $this->PrimaryKeys = $keyArray;
}
function GetPrimaryKeys()
{
    return $this->PrimaryKeys;
}
function GetPrimaryKey($keyName)
{
    return $this->PrimaryKeys[$keyName];
}
//End MasterDetail

//Operation Method @18-17DC9883
    function Operation()
    {
        if(!$this->Visible)
            return;

        global $Redirect;
        global $FileName;

        $this->DataSource->Prepare();
        if(!$this->FormSubmitted) {
            $this->EditMode = $this->DataSource->AllParametersSet;
            return;
        }

        $Redirect = $FileName . "?" . CCGetQueryString("QueryString", array("ccsForm"));
        if ($Redirect)
            $this->DataSource->close();
    }
//End Operation Method

//Show Method @18-57FDFD57
    function Show()
    {
        global $CCSUseAmp;
        global $Tpl;
        global $FileName;
        global $CCSLocales;
        $Error = "";

        if(!$this->Visible)
            return;

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeSelect", $this);


        $RecordBlock = "Record " . $this->ComponentName;
        $ParentPath = $Tpl->block_path;
        $Tpl->block_path = $ParentPath . "/" . $RecordBlock;
        $this->EditMode = $this->EditMode && $this->ReadAllowed;
        if($this->EditMode) {
            if($this->DataSource->Errors->Count()){
                $this->Errors->AddErrors($this->DataSource->Errors);
                $this->DataSource->Errors->clear();
            }
            $this->DataSource->Open();
            if($this->DataSource->Errors->Count() == 0 && $this->DataSource->next_record()) {
                $this->DataSource->SetValues();
                $this->habitaciones->SetValue($this->DataSource->habitaciones->GetValue());
                $this->banos->SetValue($this->DataSource->banos->GetValue());
                $this->estacionamientos->SetValue($this->DataSource->estacionamientos->GetValue());
                $this->metros_construccion->SetValue($this->DataSource->metros_construccion->GetValue());
                $this->metros_terreno->SetValue($this->DataSource->metros_terreno->GetValue());
                $this->estado->SetValue($this->DataSource->estado->GetValue());
                $this->ciudad->SetValue($this->DataSource->ciudad->GetValue());
                $this->urbanizacion->SetValue($this->DataSource->urbanizacion->GetValue());
                $this->tipo_inmueble->SetValue($this->DataSource->tipo_inmueble->GetValue());
                $this->lblCodigo->SetValue($this->DataSource->lblCodigo->GetValue());
                $this->tipo_negocio->SetValue($this->DataSource->tipo_negocio->GetValue());
                $this->precio->SetValue($this->DataSource->precio->GetValue());
                $this->preciom2->SetValue($this->DataSource->preciom2->GetValue());
            } else {
                $this->EditMode = false;
            }
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->habitaciones->Errors->ToString());
            $Error = ComposeStrings($Error, $this->banos->Errors->ToString());
            $Error = ComposeStrings($Error, $this->estacionamientos->Errors->ToString());
            $Error = ComposeStrings($Error, $this->metros_construccion->Errors->ToString());
            $Error = ComposeStrings($Error, $this->metros_terreno->Errors->ToString());
            $Error = ComposeStrings($Error, $this->estado->Errors->ToString());
            $Error = ComposeStrings($Error, $this->ciudad->Errors->ToString());
            $Error = ComposeStrings($Error, $this->urbanizacion->Errors->ToString());
            $Error = ComposeStrings($Error, $this->tipo_inmueble->Errors->ToString());
            $Error = ComposeStrings($Error, $this->lblCodigo->Errors->ToString());
            $Error = ComposeStrings($Error, $this->tipo_negocio->Errors->ToString());
            $Error = ComposeStrings($Error, $this->precio->Errors->ToString());
            $Error = ComposeStrings($Error, $this->preciom2->Errors->ToString());
            $Error = ComposeStrings($Error, $this->Errors->ToString());
            $Error = ComposeStrings($Error, $this->DataSource->Errors->ToString());
            $Tpl->SetVar("Error", $Error);
            $Tpl->Parse("Error", false);
        }
        $CCSForm = $this->EditMode ? $this->ComponentName . ":" . "Edit" : $this->ComponentName;
        $this->HTMLFormAction = $FileName . "?" . CCAddParam(CCGetQueryString("QueryString", ""), "ccsForm", $CCSForm);
        $Tpl->SetVar("Action", !$CCSUseAmp ? $this->HTMLFormAction : str_replace("&", "&amp;", $this->HTMLFormAction));
        $Tpl->SetVar("HTMLFormName", $this->ComponentName);
        $Tpl->SetVar("HTMLFormEnctype", $this->FormEnctype);

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow", $this);
        $this->Attributes->Show();
        if(!$this->Visible) {
            $Tpl->block_path = $ParentPath;
            return;
        }

        $this->habitaciones->Show();
        $this->banos->Show();
        $this->estacionamientos->Show();
        $this->metros_construccion->Show();
        $this->metros_terreno->Show();
        $this->estado->Show();
        $this->ciudad->Show();
        $this->urbanizacion->Show();
        $this->tipo_inmueble->Show();
        $this->lblCodigo->Show();
        $this->tipo_negocio->Show();
        $this->precio->Show();
        $this->preciom2->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

} //End propiedades Class @18-FCB6E20C

class clspropiedadesDataSource extends clsDBPrincipal {  //propiedadesDataSource Class @18-0647ED0C

//DataSource Variables @18-8CCF78CA
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $wp;
    public $AllParametersSet;


    // Datasource fields
    public $habitaciones;
    public $banos;
    public $estacionamientos;
    public $metros_construccion;
    public $metros_terreno;
    public $estado;
    public $ciudad;
    public $urbanizacion;
    public $tipo_inmueble;
    public $lblCodigo;
    public $tipo_negocio;
    public $precio;
    public $preciom2;
//End DataSource Variables

//DataSourceClass_Initialize Event @18-70C26161
    function clspropiedadesDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Record propiedades/Error";
        $this->Initialize();
        $this->habitaciones = new clsField("habitaciones", ccsSingle, "");
        
        $this->banos = new clsField("banos", ccsSingle, "");
        
        $this->estacionamientos = new clsField("estacionamientos", ccsSingle, "");
        
        $this->metros_construccion = new clsField("metros_construccion", ccsSingle, "");
        
        $this->metros_terreno = new clsField("metros_terreno", ccsSingle, "");
        
        $this->estado = new clsField("estado", ccsText, "");
        
        $this->ciudad = new clsField("ciudad", ccsText, "");
        
        $this->urbanizacion = new clsField("urbanizacion", ccsText, "");
        
        $this->tipo_inmueble = new clsField("tipo_inmueble", ccsText, "");
        
        $this->lblCodigo = new clsField("lblCodigo", ccsText, "");
        
        $this->tipo_negocio = new clsField("tipo_negocio", ccsText, "");
        
        $this->precio = new clsField("precio", ccsSingle, "");
        
        $this->preciom2 = new clsField("preciom2", ccsSingle, "");
        

    }
//End DataSourceClass_Initialize Event

//Prepare Method @18-363811F1
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlp", ccsInteger, "", "", $this->Parameters["urlp"], "", false);
        $this->AllParametersSet = $this->wp->AllParamsSet();
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "id_mls", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @18-C2D42ACC
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->SQL = "SELECT * \n\n" .
        "FROM propiedades {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        $this->PageSize = 1;
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @18-15839048
    function SetValues()
    {
        $this->habitaciones->SetDBValue(trim($this->f("habitaciones")));
        $this->banos->SetDBValue(trim($this->f("banos")));
        $this->estacionamientos->SetDBValue(trim($this->f("estacionamientos")));
        $this->metros_construccion->SetDBValue(trim($this->f("metros_construccion")));
        $this->metros_terreno->SetDBValue(trim($this->f("metros_terreno")));
        $this->estado->SetDBValue($this->f("estado"));
        $this->ciudad->SetDBValue($this->f("ciudad"));
        $this->urbanizacion->SetDBValue($this->f("urbanizacion"));
        $this->tipo_inmueble->SetDBValue($this->f("tipo_inmueble"));
        $this->lblCodigo->SetDBValue($this->f("id_mls"));
        $this->tipo_negocio->SetDBValue($this->f("tipo_negocio"));
        $this->precio->SetDBValue(trim($this->f("precio")));
        $this->preciom2->SetDBValue(trim($this->f("precio")));
    }
//End SetValues Method

} //End propiedadesDataSource Class @18-FCB6E20C

class clsGridmedia { //media class @2-DCA9DE6A

//Variables @2-6E51DF5A

    // Public variables
    public $ComponentType = "Grid";
    public $ComponentName;
    public $Visible;
    public $Errors;
    public $ErrorBlock;
    public $ds;
    public $DataSource;
    public $PageSize;
    public $IsEmpty;
    public $ForceIteration = false;
    public $HasRecord = false;
    public $SorterName = "";
    public $SorterDirection = "";
    public $PageNumber;
    public $RowNumber;
    public $ControlsVisible = array();

    public $CCSEvents = "";
    public $CCSEventResult;

    public $RelativePath = "";
    public $Attributes;

    // Grid Controls
    public $StaticControls;
    public $RowControls;
//End Variables

//Class_Initialize Event @2-5788B04C
    function clsGridmedia($RelativePath, & $Parent)
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = "media";
        $this->Visible = True;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Grid media";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->DataSource = new clsmediaDataSource($this);
        $this->ds = & $this->DataSource;
        $this->PageSize = CCGetParam($this->ComponentName . "PageSize", "");
        if(!is_numeric($this->PageSize) || !strlen($this->PageSize))
            $this->PageSize = 30;
        else
            $this->PageSize = intval($this->PageSize);
        if ($this->PageSize > 100)
            $this->PageSize = 100;
        if($this->PageSize == 0)
            $this->Errors->addError("<p>Form: Grid " . $this->ComponentName . "<br>Error: (CCS06) Invalid page size.</p>");
        $this->PageNumber = intval(CCGetParam($this->ComponentName . "Page", 1));
        if ($this->PageNumber <= 0) $this->PageNumber = 1;

        $this->RowOpenTag = new clsPanel("RowOpenTag", $this);
        $this->RowComponents = new clsPanel("RowComponents", $this);
        $this->id_media = new clsControl(ccsLabel, "id_media", "id_media", ccsInteger, "", CCGetRequestParam("id_media", ccsGet, NULL), $this);
        $this->id_media3 = new clsControl(ccsLabel, "id_media3", "id_media3", ccsInteger, "", CCGetRequestParam("id_media3", ccsGet, NULL), $this);
        $this->id_media1 = new clsControl(ccsLabel, "id_media1", "id_media1", ccsInteger, "", CCGetRequestParam("id_media1", ccsGet, NULL), $this);
        $this->id_media2 = new clsControl(ccsLabel, "id_media2", "id_media2", ccsInteger, "", CCGetRequestParam("id_media2", ccsGet, NULL), $this);
        $this->RowCloseTag = new clsPanel("RowCloseTag", $this);
        $this->RowComponents->AddComponent("id_media", $this->id_media);
        $this->RowComponents->AddComponent("id_media3", $this->id_media3);
        $this->RowComponents->AddComponent("id_media1", $this->id_media1);
        $this->RowComponents->AddComponent("id_media2", $this->id_media2);
    }
//End Class_Initialize Event

//Initialize Method @2-90E704C5
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->DataSource->PageSize = & $this->PageSize;
        $this->DataSource->AbsolutePage = & $this->PageNumber;
        $this->DataSource->SetOrder($this->SorterName, $this->SorterDirection);
    }
//End Initialize Method

//Show Method @2-5188D1E2
    function Show()
    {
        global $Tpl;
        global $CCSLocales;
        if(!$this->Visible) return;

        $this->RowNumber = 0;

        $this->DataSource->Parameters["urlp"] = CCGetFromGet("p", NULL);

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeSelect", $this);


        $this->DataSource->Prepare();
        $this->DataSource->Open();
        $this->HasRecord = $this->DataSource->has_next_record();
        $this->IsEmpty = ! $this->HasRecord;
        $this->Attributes->SetValue("numberOfColumns", 4);
        $this->Attributes->Show();

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow", $this);
        if(!$this->Visible) return;

        $GridBlock = "Grid " . $this->ComponentName;
        $ParentPath = $Tpl->block_path;
        $Tpl->block_path = $ParentPath . "/" . $GridBlock;


        if (!$this->IsEmpty) {
            $this->ControlsVisible["RowOpenTag"] = $this->RowOpenTag->Visible;
            $this->ControlsVisible["RowComponents"] = $this->RowComponents->Visible;
            $this->ControlsVisible["id_media"] = $this->id_media->Visible;
            $this->ControlsVisible["id_media3"] = $this->id_media3->Visible;
            $this->ControlsVisible["id_media1"] = $this->id_media1->Visible;
            $this->ControlsVisible["id_media2"] = $this->id_media2->Visible;
            $this->ControlsVisible["RowCloseTag"] = $this->RowCloseTag->Visible;
            while ($this->ForceIteration || (($this->RowNumber < $this->PageSize) &&  ($this->HasRecord = $this->DataSource->has_next_record()))) {
                $this->RowNumber++;
                if ($this->HasRecord) {
                    $this->DataSource->next_record();
                    $this->DataSource->SetValues();
                }
                $Tpl->block_path = $ParentPath . "/" . $GridBlock . "/Row";
                $this->id_media->SetValue($this->DataSource->id_media->GetValue());
                $this->id_media3->SetValue($this->DataSource->id_media3->GetValue());
                $this->id_media1->SetValue($this->DataSource->id_media1->GetValue());
                $this->id_media2->SetValue($this->DataSource->id_media2->GetValue());
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->RowOpenTag->Show();
                $this->RowComponents->Show();
                $this->RowCloseTag->Show();
                $Tpl->block_path = $ParentPath . "/" . $GridBlock;
                $Tpl->parse("Row", true);
            }
        }

        $errors = $this->GetErrors();
        if(strlen($errors))
        {
            $Tpl->replaceblock("", $errors);
            $Tpl->block_path = $ParentPath;
            return;
        }
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

//GetErrors Method @2-3D4A4D1D
    function GetErrors()
    {
        $errors = "";
        $errors = ComposeStrings($errors, $this->id_media->Errors->ToString());
        $errors = ComposeStrings($errors, $this->id_media3->Errors->ToString());
        $errors = ComposeStrings($errors, $this->id_media1->Errors->ToString());
        $errors = ComposeStrings($errors, $this->id_media2->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

} //End media Class @2-FCB6E20C

class clsmediaDataSource extends clsDBPrincipal {  //mediaDataSource Class @2-151B7052

//DataSource Variables @2-49D63F9D
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $CountSQL;
    public $wp;


    // Datasource fields
    public $id_media;
    public $id_media3;
    public $id_media1;
    public $id_media2;
//End DataSource Variables

//DataSourceClass_Initialize Event @2-571D3FFB
    function clsmediaDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid media";
        $this->Initialize();
        $this->id_media = new clsField("id_media", ccsInteger, "");
        
        $this->id_media3 = new clsField("id_media3", ccsInteger, "");
        
        $this->id_media1 = new clsField("id_media1", ccsInteger, "");
        
        $this->id_media2 = new clsField("id_media2", ccsInteger, "");
        

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @2-9E1383D1
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            "");
    }
//End SetOrder Method

//Prepare Method @2-CE58A4C7
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlp", ccsInteger, "", "", $this->Parameters["urlp"], "", false);
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "target_id", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsInteger),false);
        $this->Where = 
             $this->wp->Criterion[1];
    }
//End Prepare Method

//Open Method @2-2840BD3A
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM media";
        $this->SQL = "SELECT * \n\n" .
        "FROM media {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @2-5DA31CC2
    function SetValues()
    {
        $this->id_media->SetDBValue(trim($this->f("id_media")));
        $this->id_media3->SetDBValue(trim($this->f("id_media")));
        $this->id_media1->SetDBValue(trim($this->f("id_media")));
        $this->id_media2->SetDBValue(trim($this->f("id_media")));
    }
//End SetValues Method

} //End mediaDataSource Class @2-FCB6E20C

class clsGridvw_propiedades_caracas { //vw_propiedades_caracas class @46-C2AE744D

//Variables @46-6E51DF5A

    // Public variables
    public $ComponentType = "Grid";
    public $ComponentName;
    public $Visible;
    public $Errors;
    public $ErrorBlock;
    public $ds;
    public $DataSource;
    public $PageSize;
    public $IsEmpty;
    public $ForceIteration = false;
    public $HasRecord = false;
    public $SorterName = "";
    public $SorterDirection = "";
    public $PageNumber;
    public $RowNumber;
    public $ControlsVisible = array();

    public $CCSEvents = "";
    public $CCSEventResult;

    public $RelativePath = "";
    public $Attributes;

    // Grid Controls
    public $StaticControls;
    public $RowControls;
//End Variables

//Class_Initialize Event @46-313A0EC0
    function clsGridvw_propiedades_caracas($RelativePath, & $Parent)
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = "vw_propiedades_caracas";
        $this->Visible = True;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Grid vw_propiedades_caracas";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->DataSource = new clsvw_propiedades_caracasDataSource($this);
        $this->ds = & $this->DataSource;
        $this->PageSize = CCGetParam($this->ComponentName . "PageSize", "");
        if(!is_numeric($this->PageSize) || !strlen($this->PageSize))
            $this->PageSize = 12;
        else
            $this->PageSize = intval($this->PageSize);
        if ($this->PageSize > 100)
            $this->PageSize = 100;
        if($this->PageSize == 0)
            $this->Errors->addError("<p>Form: Grid " . $this->ComponentName . "<br>Error: (CCS06) Invalid page size.</p>");
        $this->PageNumber = intval(CCGetParam($this->ComponentName . "Page", 1));
        if ($this->PageNumber <= 0) $this->PageNumber = 1;

        $this->RowOpenTag = new clsPanel("RowOpenTag", $this);
        $this->RowComponents = new clsPanel("RowComponents", $this);
        $this->precio = new clsControl(ccsLabel, "precio", "precio", ccsSingle, array(False, 0, ",", ".", False, "", "", 1, True, ""), CCGetRequestParam("precio", ccsGet, NULL), $this);
        $this->tipo_inmueble = new clsControl(ccsLabel, "tipo_inmueble", "tipo_inmueble", ccsText, "", CCGetRequestParam("tipo_inmueble", ccsGet, NULL), $this);
        $this->tipo_negocio = new clsControl(ccsLabel, "tipo_negocio", "tipo_negocio", ccsText, "", CCGetRequestParam("tipo_negocio", ccsGet, NULL), $this);
        $this->ciudad = new clsControl(ccsLabel, "ciudad", "ciudad", ccsText, "", CCGetRequestParam("ciudad", ccsGet, NULL), $this);
        $this->ciudad1 = new clsControl(ccsLabel, "ciudad1", "ciudad1", ccsText, "", CCGetRequestParam("ciudad1", ccsGet, NULL), $this);
        $this->habitaciones = new clsControl(ccsLabel, "habitaciones", "habitaciones", ccsSingle, "", CCGetRequestParam("habitaciones", ccsGet, NULL), $this);
        $this->banos = new clsControl(ccsLabel, "banos", "banos", ccsSingle, "", CCGetRequestParam("banos", ccsGet, NULL), $this);
        $this->estacionamientos = new clsControl(ccsLabel, "estacionamientos", "estacionamientos", ccsSingle, "", CCGetRequestParam("estacionamientos", ccsGet, NULL), $this);
        $this->media = new clsControl(ccsLabel, "media", "media", ccsText, "", CCGetRequestParam("media", ccsGet, NULL), $this);
        $this->urbanizacion = new clsControl(ccsLabel, "urbanizacion", "urbanizacion", ccsText, "", CCGetRequestParam("urbanizacion", ccsGet, NULL), $this);
        $this->urbanizacion1 = new clsControl(ccsLabel, "urbanizacion1", "urbanizacion1", ccsText, "", CCGetRequestParam("urbanizacion1", ccsGet, NULL), $this);
        $this->lblIdMls = new clsControl(ccsLabel, "lblIdMls", "lblIdMls", ccsText, "", CCGetRequestParam("lblIdMls", ccsGet, NULL), $this);
        $this->RowCloseTag = new clsPanel("RowCloseTag", $this);
        $this->RowComponents->AddComponent("precio", $this->precio);
        $this->RowComponents->AddComponent("tipo_inmueble", $this->tipo_inmueble);
        $this->RowComponents->AddComponent("tipo_negocio", $this->tipo_negocio);
        $this->RowComponents->AddComponent("ciudad", $this->ciudad);
        $this->RowComponents->AddComponent("ciudad1", $this->ciudad1);
        $this->RowComponents->AddComponent("habitaciones", $this->habitaciones);
        $this->RowComponents->AddComponent("banos", $this->banos);
        $this->RowComponents->AddComponent("estacionamientos", $this->estacionamientos);
        $this->RowComponents->AddComponent("media", $this->media);
        $this->RowComponents->AddComponent("urbanizacion", $this->urbanizacion);
        $this->RowComponents->AddComponent("urbanizacion1", $this->urbanizacion1);
        $this->RowComponents->AddComponent("lblIdMls", $this->lblIdMls);
    }
//End Class_Initialize Event

//Initialize Method @46-90E704C5
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->DataSource->PageSize = & $this->PageSize;
        $this->DataSource->AbsolutePage = & $this->PageNumber;
        $this->DataSource->SetOrder($this->SorterName, $this->SorterDirection);
    }
//End Initialize Method

//Show Method @46-EE1A104E
    function Show()
    {
        global $Tpl;
        global $CCSLocales;
        if(!$this->Visible) return;

        $this->RowNumber = 0;

        $this->DataSource->Parameters["urlp"] = CCGetFromGet("p", NULL);

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeSelect", $this);


        $this->DataSource->Prepare();
        $this->DataSource->Open();
        $this->HasRecord = $this->DataSource->has_next_record();
        $this->IsEmpty = ! $this->HasRecord;
        $this->Attributes->SetValue("numberOfColumns", 6);
        $this->Attributes->Show();

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow", $this);
        if(!$this->Visible) return;

        $GridBlock = "Grid " . $this->ComponentName;
        $ParentPath = $Tpl->block_path;
        $Tpl->block_path = $ParentPath . "/" . $GridBlock;


        if (!$this->IsEmpty) {
            $this->ControlsVisible["RowOpenTag"] = $this->RowOpenTag->Visible;
            $this->ControlsVisible["RowComponents"] = $this->RowComponents->Visible;
            $this->ControlsVisible["precio"] = $this->precio->Visible;
            $this->ControlsVisible["tipo_inmueble"] = $this->tipo_inmueble->Visible;
            $this->ControlsVisible["tipo_negocio"] = $this->tipo_negocio->Visible;
            $this->ControlsVisible["ciudad"] = $this->ciudad->Visible;
            $this->ControlsVisible["ciudad1"] = $this->ciudad1->Visible;
            $this->ControlsVisible["habitaciones"] = $this->habitaciones->Visible;
            $this->ControlsVisible["banos"] = $this->banos->Visible;
            $this->ControlsVisible["estacionamientos"] = $this->estacionamientos->Visible;
            $this->ControlsVisible["media"] = $this->media->Visible;
            $this->ControlsVisible["urbanizacion"] = $this->urbanizacion->Visible;
            $this->ControlsVisible["urbanizacion1"] = $this->urbanizacion1->Visible;
            $this->ControlsVisible["lblIdMls"] = $this->lblIdMls->Visible;
            $this->ControlsVisible["RowCloseTag"] = $this->RowCloseTag->Visible;
            while ($this->ForceIteration || (($this->RowNumber < $this->PageSize) &&  ($this->HasRecord = $this->DataSource->has_next_record()))) {
                $this->RowNumber++;
                if ($this->HasRecord) {
                    $this->DataSource->next_record();
                    $this->DataSource->SetValues();
                }
                $Tpl->block_path = $ParentPath . "/" . $GridBlock . "/Row";
                $this->precio->SetValue($this->DataSource->precio->GetValue());
                $this->tipo_inmueble->SetValue($this->DataSource->tipo_inmueble->GetValue());
                $this->tipo_negocio->SetValue($this->DataSource->tipo_negocio->GetValue());
                $this->ciudad->SetValue($this->DataSource->ciudad->GetValue());
                $this->ciudad1->SetValue($this->DataSource->ciudad1->GetValue());
                $this->habitaciones->SetValue($this->DataSource->habitaciones->GetValue());
                $this->banos->SetValue($this->DataSource->banos->GetValue());
                $this->estacionamientos->SetValue($this->DataSource->estacionamientos->GetValue());
                $this->media->SetValue($this->DataSource->media->GetValue());
                $this->urbanizacion->SetValue($this->DataSource->urbanizacion->GetValue());
                $this->urbanizacion1->SetValue($this->DataSource->urbanizacion1->GetValue());
                $this->lblIdMls->SetValue($this->DataSource->lblIdMls->GetValue());
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->RowOpenTag->Show();
                $this->RowComponents->Show();
                $this->RowCloseTag->Show();
                $Tpl->block_path = $ParentPath . "/" . $GridBlock;
                $Tpl->parse("Row", true);
            }
        }
        else { // Show NoRecords block if no records are found
            $this->Attributes->Show();
            $Tpl->parse("NoRecords", false);
        }

        $errors = $this->GetErrors();
        if(strlen($errors))
        {
            $Tpl->replaceblock("", $errors);
            $Tpl->block_path = $ParentPath;
            return;
        }
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

//GetErrors Method @46-243C9E39
    function GetErrors()
    {
        $errors = "";
        $errors = ComposeStrings($errors, $this->precio->Errors->ToString());
        $errors = ComposeStrings($errors, $this->tipo_inmueble->Errors->ToString());
        $errors = ComposeStrings($errors, $this->tipo_negocio->Errors->ToString());
        $errors = ComposeStrings($errors, $this->ciudad->Errors->ToString());
        $errors = ComposeStrings($errors, $this->ciudad1->Errors->ToString());
        $errors = ComposeStrings($errors, $this->habitaciones->Errors->ToString());
        $errors = ComposeStrings($errors, $this->banos->Errors->ToString());
        $errors = ComposeStrings($errors, $this->estacionamientos->Errors->ToString());
        $errors = ComposeStrings($errors, $this->media->Errors->ToString());
        $errors = ComposeStrings($errors, $this->urbanizacion->Errors->ToString());
        $errors = ComposeStrings($errors, $this->urbanizacion1->Errors->ToString());
        $errors = ComposeStrings($errors, $this->lblIdMls->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

} //End vw_propiedades_caracas Class @46-FCB6E20C

class clsvw_propiedades_caracasDataSource extends clsDBPrincipal {  //vw_propiedades_caracasDataSource Class @46-612483CE

//DataSource Variables @46-AE941ECC
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $CountSQL;
    public $wp;


    // Datasource fields
    public $precio;
    public $tipo_inmueble;
    public $tipo_negocio;
    public $ciudad;
    public $ciudad1;
    public $habitaciones;
    public $banos;
    public $estacionamientos;
    public $media;
    public $urbanizacion;
    public $urbanizacion1;
    public $lblIdMls;
//End DataSource Variables

//DataSourceClass_Initialize Event @46-BDB95569
    function clsvw_propiedades_caracasDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid vw_propiedades_caracas";
        $this->Initialize();
        $this->precio = new clsField("precio", ccsSingle, "");
        
        $this->tipo_inmueble = new clsField("tipo_inmueble", ccsText, "");
        
        $this->tipo_negocio = new clsField("tipo_negocio", ccsText, "");
        
        $this->ciudad = new clsField("ciudad", ccsText, "");
        
        $this->ciudad1 = new clsField("ciudad1", ccsText, "");
        
        $this->habitaciones = new clsField("habitaciones", ccsSingle, "");
        
        $this->banos = new clsField("banos", ccsSingle, "");
        
        $this->estacionamientos = new clsField("estacionamientos", ccsSingle, "");
        
        $this->media = new clsField("media", ccsText, "");
        
        $this->urbanizacion = new clsField("urbanizacion", ccsText, "");
        
        $this->urbanizacion1 = new clsField("urbanizacion1", ccsText, "");
        
        $this->lblIdMls = new clsField("lblIdMls", ccsText, "");
        

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @46-9E1383D1
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            "");
    }
//End SetOrder Method

//Prepare Method @46-F87A244A
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlp", ccsText, "", "", $this->Parameters["urlp"], "", false);
    }
//End Prepare Method

//Open Method @46-66A0A425
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*) FROM vw_propiedades_caracas \n" .
        "WHERE\n" .
        "	id_tipo_inmueble = (select id_tipo_inmueble from propiedades where id_mls = " . $this->SQLValue($this->wp->GetDBValue("1"), ccsText) . ") and\n" .
        "	precio between (select precio from propiedades where id_mls = " . $this->SQLValue($this->wp->GetDBValue("1"), ccsText) . ")*0.90 and (select precio from propiedades where id_mls = " . $this->SQLValue($this->wp->GetDBValue("1"), ccsText) . ")*1.10 and\n" .
        "	id_mls <> " . $this->SQLValue($this->wp->GetDBValue("1"), ccsText) . "";
        $this->SQL = "SELECT *,  \n" .
        "	(SELECT id_media FROM media WHERE target_id = id_mls LIMIT 1)  AS media\n" .
        "FROM vw_propiedades_caracas \n" .
        "WHERE\n" .
        "	id_tipo_inmueble = (select id_tipo_inmueble from propiedades where id_mls = " . $this->SQLValue($this->wp->GetDBValue("1"), ccsText) . ") and\n" .
        "	precio between (select precio from propiedades where id_mls = " . $this->SQLValue($this->wp->GetDBValue("1"), ccsText) . ")*0.90 and (select precio from propiedades where id_mls = " . $this->SQLValue($this->wp->GetDBValue("1"), ccsText) . ")*1.10 and\n" .
        "	id_mls <> " . $this->SQLValue($this->wp->GetDBValue("1"), ccsText) . "";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @46-81FE21C0
    function SetValues()
    {
        $this->precio->SetDBValue(trim($this->f("precio")));
        $this->tipo_inmueble->SetDBValue($this->f("tipo_inmueble"));
        $this->tipo_negocio->SetDBValue($this->f("tipo_negocio"));
        $this->ciudad->SetDBValue($this->f("ciudad"));
        $this->ciudad1->SetDBValue($this->f("ciudad"));
        $this->habitaciones->SetDBValue(trim($this->f("habitaciones")));
        $this->banos->SetDBValue(trim($this->f("banos")));
        $this->estacionamientos->SetDBValue(trim($this->f("estacionamientos")));
        $this->media->SetDBValue($this->f("media"));
        $this->urbanizacion->SetDBValue($this->f("urbanizacion"));
        $this->urbanizacion1->SetDBValue($this->f("urbanizacion"));
        $this->lblIdMls->SetDBValue($this->f("id_mls"));
    }
//End SetValues Method

} //End vw_propiedades_caracasDataSource Class @46-FCB6E20C



class clsRecordpropiedades1 { //propiedades1 Class @83-CC044F0A

//Variables @83-9E315808

    // Public variables
    public $ComponentType = "Record";
    public $ComponentName;
    public $Parent;
    public $HTMLFormAction;
    public $PressedButton;
    public $Errors;
    public $ErrorBlock;
    public $FormSubmitted;
    public $FormEnctype;
    public $Visible;
    public $IsEmpty;

    public $CCSEvents = "";
    public $CCSEventResult;

    public $RelativePath = "";

    public $InsertAllowed = false;
    public $UpdateAllowed = false;
    public $DeleteAllowed = false;
    public $ReadAllowed   = false;
    public $EditMode      = false;
    public $ds;
    public $DataSource;
    public $ValidatingControls;
    public $Controls;
    public $Attributes;

    // Class variables
//End Variables

//Class_Initialize Event @83-F79E510B
    function clsRecordpropiedades1($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record propiedades1/Error";
        $this->DataSource = new clspropiedades1DataSource($this);
        $this->ds = & $this->DataSource;
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "propiedades1";
            $this->Attributes = new clsAttributes($this->ComponentName . ":");
            $CCSForm = explode(":", CCGetFromGet("ccsForm", ""), 2);
            if(sizeof($CCSForm) == 1)
                $CCSForm[1] = "";
            list($FormName, $FormMethod) = $CCSForm;
            $this->EditMode = ($FormMethod == "Edit");
            $this->FormEnctype = "application/x-www-form-urlencoded";
            $this->FormSubmitted = ($FormName == $this->ComponentName);
            $Method = $this->FormSubmitted ? ccsPost : ccsGet;
            $this->nombre = new clsControl(ccsLabel, "nombre", "nombre", ccsText, "", CCGetRequestParam("nombre", $Method, NULL), $this);
            $this->celular = new clsControl(ccsLabel, "celular", "celular", ccsText, "", CCGetRequestParam("celular", $Method, NULL), $this);
            $this->telefono = new clsControl(ccsLabel, "telefono", "telefono", ccsText, "", CCGetRequestParam("telefono", $Method, NULL), $this);
            $this->media = new clsControl(ccsLabel, "media", "media", ccsText, "", CCGetRequestParam("media", $Method, NULL), $this);
        }
    }
//End Class_Initialize Event

//Initialize Method @83-392739A8
    function Initialize()
    {

        if(!$this->Visible)
            return;

        $this->DataSource->Parameters["urlp"] = CCGetFromGet("p", NULL);
    }
//End Initialize Method

//Validate Method @83-367945B8
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @83-6E954573
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->nombre->Errors->Count());
        $errors = ($errors || $this->celular->Errors->Count());
        $errors = ($errors || $this->telefono->Errors->Count());
        $errors = ($errors || $this->media->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        $errors = ($errors || $this->DataSource->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//MasterDetail @83-ED598703
function SetPrimaryKeys($keyArray)
{
    $this->PrimaryKeys = $keyArray;
}
function GetPrimaryKeys()
{
    return $this->PrimaryKeys;
}
function GetPrimaryKey($keyName)
{
    return $this->PrimaryKeys[$keyName];
}
//End MasterDetail

//Operation Method @83-17DC9883
    function Operation()
    {
        if(!$this->Visible)
            return;

        global $Redirect;
        global $FileName;

        $this->DataSource->Prepare();
        if(!$this->FormSubmitted) {
            $this->EditMode = $this->DataSource->AllParametersSet;
            return;
        }

        $Redirect = $FileName . "?" . CCGetQueryString("QueryString", array("ccsForm"));
        if ($Redirect)
            $this->DataSource->close();
    }
//End Operation Method

//Show Method @83-33725FCE
    function Show()
    {
        global $CCSUseAmp;
        global $Tpl;
        global $FileName;
        global $CCSLocales;
        $Error = "";

        if(!$this->Visible)
            return;

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeSelect", $this);


        $RecordBlock = "Record " . $this->ComponentName;
        $ParentPath = $Tpl->block_path;
        $Tpl->block_path = $ParentPath . "/" . $RecordBlock;
        $this->EditMode = $this->EditMode && $this->ReadAllowed;
        if($this->EditMode) {
            if($this->DataSource->Errors->Count()){
                $this->Errors->AddErrors($this->DataSource->Errors);
                $this->DataSource->Errors->clear();
            }
            $this->DataSource->Open();
            if($this->DataSource->Errors->Count() == 0 && $this->DataSource->next_record()) {
                $this->DataSource->SetValues();
                $this->nombre->SetValue($this->DataSource->nombre->GetValue());
                $this->celular->SetValue($this->DataSource->celular->GetValue());
                $this->telefono->SetValue($this->DataSource->telefono->GetValue());
                $this->media->SetValue($this->DataSource->media->GetValue());
            } else {
                $this->EditMode = false;
            }
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->nombre->Errors->ToString());
            $Error = ComposeStrings($Error, $this->celular->Errors->ToString());
            $Error = ComposeStrings($Error, $this->telefono->Errors->ToString());
            $Error = ComposeStrings($Error, $this->media->Errors->ToString());
            $Error = ComposeStrings($Error, $this->Errors->ToString());
            $Error = ComposeStrings($Error, $this->DataSource->Errors->ToString());
            $Tpl->SetVar("Error", $Error);
            $Tpl->Parse("Error", false);
        }
        $CCSForm = $this->EditMode ? $this->ComponentName . ":" . "Edit" : $this->ComponentName;
        $this->HTMLFormAction = $FileName . "?" . CCAddParam(CCGetQueryString("QueryString", ""), "ccsForm", $CCSForm);
        $Tpl->SetVar("Action", !$CCSUseAmp ? $this->HTMLFormAction : str_replace("&", "&amp;", $this->HTMLFormAction));
        $Tpl->SetVar("HTMLFormName", $this->ComponentName);
        $Tpl->SetVar("HTMLFormEnctype", $this->FormEnctype);

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow", $this);
        $this->Attributes->Show();
        if(!$this->Visible) {
            $Tpl->block_path = $ParentPath;
            return;
        }

        $this->nombre->Show();
        $this->celular->Show();
        $this->telefono->Show();
        $this->media->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

} //End propiedades1 Class @83-FCB6E20C

class clspropiedades1DataSource extends clsDBPrincipal {  //propiedades1DataSource Class @83-89DF3DCD

//DataSource Variables @83-08B1EF12
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $wp;
    public $AllParametersSet;


    // Datasource fields
    public $nombre;
    public $celular;
    public $telefono;
    public $media;
//End DataSource Variables

//DataSourceClass_Initialize Event @83-667A62CA
    function clspropiedades1DataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Record propiedades1/Error";
        $this->Initialize();
        $this->nombre = new clsField("nombre", ccsText, "");
        
        $this->celular = new clsField("celular", ccsText, "");
        
        $this->telefono = new clsField("telefono", ccsText, "");
        
        $this->media = new clsField("media", ccsText, "");
        

    }
//End DataSourceClass_Initialize Event

//Prepare Method @83-F7AE0A89
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlp", ccsInteger, "", "", $this->Parameters["urlp"], 0, false);
        $this->AllParametersSet = $this->wp->AllParamsSet();
    }
//End Prepare Method

//Open Method @83-2D00CF95
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->SQL = "SELECT * FROM asesores\n" .
        "WHERE id = \n" .
        "	(\n" .
        "		SELECT id_asesor \n" .
        "		FROM propiedades\n" .
        "		WHERE id_mls = " . $this->SQLValue($this->wp->GetDBValue("1"), ccsInteger) . " \n" .
        "	)";
        $this->Order = "";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        $this->PageSize = 1;
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @83-251C86CF
    function SetValues()
    {
        $this->nombre->SetDBValue($this->f("nombre"));
        $this->celular->SetDBValue($this->f("celular"));
        $this->telefono->SetDBValue($this->f("telefono"));
        $this->media->SetDBValue($this->f("media"));
    }
//End SetValues Method

} //End propiedades1DataSource Class @83-FCB6E20C















//Initialize Page @1-C03ABEBB
// Variables
$FileName = "";
$Redirect = "";
$Tpl = "";
$TemplateFileName = "";
$BlockToParse = "";
$ComponentName = "";
$Attributes = "";

// Events;
$CCSEvents = "";
$CCSEventResult = "";

$FileName = FileName;
$Redirect = "";
$TemplateFileName = "inmueble_old.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "./";
$Charset = $Charset ? $Charset : "windows-1252";
//End Initialize Page

//Include events file @1-29727A8D
include_once("./inmueble_old_events.php");
//End Include events file

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-826A183E
$DBPrincipal = new clsDBPrincipal();
$MainPage->Connections["Principal"] = & $DBPrincipal;
$Attributes = new clsAttributes("page:");
$MainPage->Attributes = & $Attributes;

// Controls
$propiedades = new clsRecordpropiedades("", $MainPage);
$media = new clsGridmedia("", $MainPage);
$lblComentarios = new clsControl(ccsLabel, "lblComentarios", "lblComentarios", ccsText, "", CCGetRequestParam("lblComentarios", ccsGet, NULL), $MainPage);
$vw_propiedades_caracas = new clsGridvw_propiedades_caracas("", $MainPage);
$propiedades1 = new clsRecordpropiedades1("", $MainPage);
$Label1 = new clsControl(ccsLabel, "Label1", "Label1", ccsText, "", CCGetRequestParam("Label1", ccsGet, NULL), $MainPage);
$Label2 = new clsControl(ccsLabel, "Label2", "Label2", ccsText, "", CCGetRequestParam("Label2", ccsGet, NULL), $MainPage);
$Panel1 = new clsPanel("Panel1", $MainPage);
$Label3 = new clsControl(ccsLabel, "Label3", "Label3", ccsText, "", CCGetRequestParam("Label3", ccsGet, NULL), $MainPage);
$Label4 = new clsControl(ccsLabel, "Label4", "Label4", ccsText, "", CCGetRequestParam("Label4", ccsGet, NULL), $MainPage);
$MainPage->propiedades = & $propiedades;
$MainPage->media = & $media;
$MainPage->lblComentarios = & $lblComentarios;
$MainPage->vw_propiedades_caracas = & $vw_propiedades_caracas;
$MainPage->propiedades1 = & $propiedades1;
$MainPage->Label1 = & $Label1;
$MainPage->Label2 = & $Label2;
$MainPage->Panel1 = & $Panel1;
$MainPage->Label3 = & $Label3;
$MainPage->Label4 = & $Label4;
$propiedades->Initialize();
$media->Initialize();
$vw_propiedades_caracas->Initialize();
$propiedades1->Initialize();

BindEvents();

$CCSEventResult = CCGetEvent($CCSEvents, "AfterInitialize", $MainPage);

if ($Charset) {
    header("Content-Type: " . $ContentType . "; charset=" . $Charset);
} else {
    header("Content-Type: " . $ContentType);
}
//End Initialize Objects

//Initialize HTML Template @1-E710DB26
$CCSEventResult = CCGetEvent($CCSEvents, "OnInitializeView", $MainPage);
$Tpl = new clsTemplate($FileEncoding, $TemplateEncoding);
$Tpl->LoadTemplate(PathToCurrentPage . $TemplateFileName, $BlockToParse, "CP1252");
$Tpl->block_path = "/$BlockToParse";
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeShow", $MainPage);
$Attributes->SetValue("pathToRoot", "");
$Attributes->Show();
//End Initialize HTML Template

//Execute Components @1-11FACFD2
$propiedades->Operation();
$propiedades1->Operation();
//End Execute Components

//Go to destination page @1-E6D44E90
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBPrincipal->close();
    header("Location: " . $Redirect);
    unset($propiedades);
    unset($media);
    unset($vw_propiedades_caracas);
    unset($propiedades1);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-4166F97E
$propiedades->Show();
$media->Show();
$vw_propiedades_caracas->Show();
$propiedades1->Show();
$lblComentarios->Show();
$Label1->Show();
$Label2->Show();
$Panel1->Show();
$Label3->Show();
$Label4->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-20839485
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBPrincipal->close();
unset($propiedades);
unset($media);
unset($vw_propiedades_caracas);
unset($propiedades1);
unset($Tpl);
//End Unload Page


?>
