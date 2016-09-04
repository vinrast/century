<?php
//Include Common Files @1-A9B91D9E
define("RelativePath", ".");
define("PathToCurrentPage", "/");
define("FileName", "propiedades.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

class clsGridvw_propiedades_caracas { //vw_propiedades_caracas class @75-C2AE744D

//Variables @75-6E51DF5A

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

//Class_Initialize Event @75-983C34B2
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
        $this->Navigator1 = new clsNavigator($this->ComponentName, "Navigator1", $FileName, 5, tpCentered, $this);
        $this->Navigator1->PageSizes = array("1", "5", "10", "25", "50");
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

//Initialize Method @75-90E704C5
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->DataSource->PageSize = & $this->PageSize;
        $this->DataSource->AbsolutePage = & $this->PageNumber;
        $this->DataSource->SetOrder($this->SorterName, $this->SorterDirection);
    }
//End Initialize Method

//Show Method @75-69BC994B
    function Show()
    {
        global $Tpl;
        global $CCSLocales;
        if(!$this->Visible) return;

        $this->RowNumber = 0;

        $this->DataSource->Parameters["urlzona"] = CCGetFromGet("zona", NULL);
        $this->DataSource->Parameters["urltipo_inmueble"] = CCGetFromGet("tipo_inmueble", NULL);
        $this->DataSource->Parameters["urltipo_negocio"] = CCGetFromGet("tipo_negocio", NULL);
        $this->DataSource->Parameters["urlhabitaciones"] = CCGetFromGet("habitaciones", NULL);
        $this->DataSource->Parameters["urlbanos"] = CCGetFromGet("banos", NULL);
        $this->DataSource->Parameters["urlestacionamientos"] = CCGetFromGet("estacionamientos", NULL);
        $this->DataSource->Parameters["urlmetros_construccion_1"] = CCGetFromGet("metros_construccion_1", NULL);
        $this->DataSource->Parameters["urlmetros_construccion_2"] = CCGetFromGet("metros_construccion_2", NULL);
        $this->DataSource->Parameters["urlmetros_terreno_1"] = CCGetFromGet("metros_terreno_1", NULL);
        $this->DataSource->Parameters["urlmetros_terreno_2"] = CCGetFromGet("metros_terreno_2", NULL);
        $this->DataSource->Parameters["urlprecio_1"] = CCGetFromGet("precio_1", NULL);
        $this->DataSource->Parameters["urlprecio_2"] = CCGetFromGet("precio_2", NULL);
        $this->DataSource->Parameters["urlcomercial"] = CCGetFromGet("comercial", NULL);

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
        $this->Navigator1->PageNumber = $this->DataSource->AbsolutePage;
        $this->Navigator1->PageSize = $this->PageSize;
        if ($this->DataSource->RecordsCount == "CCS not counted")
            $this->Navigator1->TotalPages = $this->DataSource->AbsolutePage + ($this->DataSource->next_record() ? 1 : 0);
        else
            $this->Navigator1->TotalPages = $this->DataSource->PageCount();
        if ($this->Navigator1->TotalPages <= 1) {
            $this->Navigator1->Visible = false;
        }
        $this->Navigator1->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

//GetErrors Method @75-243C9E39
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

} //End vw_propiedades_caracas Class @75-FCB6E20C

class clsvw_propiedades_caracasDataSource extends clsDBPrincipal {  //vw_propiedades_caracasDataSource Class @75-612483CE

//DataSource Variables @75-AE941ECC
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

//DataSourceClass_Initialize Event @75-BDB95569
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

//SetOrder Method @75-9E1383D1
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            "");
    }
//End SetOrder Method

//Prepare Method @75-BA030720
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urlzona", ccsText, "", "", $this->Parameters["urlzona"], "", false);
        $this->wp->AddParameter("2", "urltipo_inmueble", ccsText, "", "", $this->Parameters["urltipo_inmueble"], "", false);
        $this->wp->AddParameter("3", "urltipo_negocio", ccsText, "", "", $this->Parameters["urltipo_negocio"], "", false);
        $this->wp->AddParameter("4", "urlhabitaciones", ccsSingle, "", "", $this->Parameters["urlhabitaciones"], "", false);
        $this->wp->AddParameter("5", "urlbanos", ccsSingle, "", "", $this->Parameters["urlbanos"], "", false);
        $this->wp->AddParameter("6", "urlestacionamientos", ccsSingle, "", "", $this->Parameters["urlestacionamientos"], "", false);
        $this->wp->AddParameter("7", "urlmetros_construccion_1", ccsSingle, "", "", $this->Parameters["urlmetros_construccion_1"], "", false);
        $this->wp->AddParameter("8", "urlmetros_construccion_2", ccsSingle, "", "", $this->Parameters["urlmetros_construccion_2"], "", false);
        $this->wp->AddParameter("9", "urlmetros_terreno_1", ccsSingle, "", "", $this->Parameters["urlmetros_terreno_1"], "", false);
        $this->wp->AddParameter("10", "urlmetros_terreno_2", ccsSingle, "", "", $this->Parameters["urlmetros_terreno_2"], "", false);
        $this->wp->AddParameter("11", "urlprecio_1", ccsSingle, "", "", $this->Parameters["urlprecio_1"], "", false);
        $this->wp->AddParameter("12", "urlprecio_2", ccsSingle, "", "", $this->Parameters["urlprecio_2"], "", false);
        $this->wp->AddParameter("13", "urlcomercial", ccsInteger, "", "", $this->Parameters["urlcomercial"], "", false);
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "urbanizacion", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsText),false);
        $this->wp->Criterion[2] = $this->wp->Operation(opEqual, "tipo_inmueble", $this->wp->GetDBValue("2"), $this->ToSQL($this->wp->GetDBValue("2"), ccsText),false);
        $this->wp->Criterion[3] = $this->wp->Operation(opEqual, "tipo_negocio", $this->wp->GetDBValue("3"), $this->ToSQL($this->wp->GetDBValue("3"), ccsText),false);
        $this->wp->Criterion[4] = $this->wp->Operation(opEqual, "habitaciones", $this->wp->GetDBValue("4"), $this->ToSQL($this->wp->GetDBValue("4"), ccsSingle),false);
        $this->wp->Criterion[5] = $this->wp->Operation(opEqual, "banos", $this->wp->GetDBValue("5"), $this->ToSQL($this->wp->GetDBValue("5"), ccsSingle),false);
        $this->wp->Criterion[6] = $this->wp->Operation(opEqual, "estacionamientos", $this->wp->GetDBValue("6"), $this->ToSQL($this->wp->GetDBValue("6"), ccsSingle),false);
        $this->wp->Criterion[7] = $this->wp->Operation(opGreaterThanOrEqual, "metros_construccion", $this->wp->GetDBValue("7"), $this->ToSQL($this->wp->GetDBValue("7"), ccsSingle),false);
        $this->wp->Criterion[8] = $this->wp->Operation(opLessThanOrEqual, "metros_construccion", $this->wp->GetDBValue("8"), $this->ToSQL($this->wp->GetDBValue("8"), ccsSingle),false);
        $this->wp->Criterion[9] = $this->wp->Operation(opGreaterThanOrEqual, "metros_terreno", $this->wp->GetDBValue("9"), $this->ToSQL($this->wp->GetDBValue("9"), ccsSingle),false);
        $this->wp->Criterion[10] = $this->wp->Operation(opLessThanOrEqual, "metros_terreno", $this->wp->GetDBValue("10"), $this->ToSQL($this->wp->GetDBValue("10"), ccsSingle),false);
        $this->wp->Criterion[11] = $this->wp->Operation(opGreaterThanOrEqual, "precio", $this->wp->GetDBValue("11"), $this->ToSQL($this->wp->GetDBValue("11"), ccsSingle),false);
        $this->wp->Criterion[12] = $this->wp->Operation(opLessThanOrEqual, "precio", $this->wp->GetDBValue("12"), $this->ToSQL($this->wp->GetDBValue("12"), ccsSingle),false);
        $this->wp->Criterion[13] = $this->wp->Operation(opEqual, "comercial", $this->wp->GetDBValue("13"), $this->ToSQL($this->wp->GetDBValue("13"), ccsInteger),false);
        $this->Where = $this->wp->opAND(
             false, $this->wp->opAND(
             false, $this->wp->opAND(
             false, $this->wp->opAND(
             false, $this->wp->opAND(
             false, $this->wp->opAND(
             false, $this->wp->opAND(
             false, $this->wp->opAND(
             false, $this->wp->opAND(
             false, 
             $this->wp->Criterion[1], 
             $this->wp->Criterion[2]), 
             $this->wp->Criterion[3]), 
             $this->wp->Criterion[4]), 
             $this->wp->Criterion[5]), 
             $this->wp->Criterion[6]), $this->wp->opAND(
             true, 
             $this->wp->Criterion[7], 
             $this->wp->Criterion[8])), $this->wp->opAND(
             true, 
             $this->wp->Criterion[9], 
             $this->wp->Criterion[10])), $this->wp->opAND(
             true, 
             $this->wp->Criterion[11], 
             $this->wp->Criterion[12])), 
             $this->wp->Criterion[13]);
    }
//End Prepare Method

//Open Method @75-86F8365C
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM vw_propiedades_caracas";
        $this->SQL = "SELECT *,  (SELECT id_media FROM media WHERE target_id = id_mls LIMIT 1)  AS media\n\n" .
        "FROM vw_propiedades_caracas {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @75-81FE21C0
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

} //End vw_propiedades_caracasDataSource Class @75-FCB6E20C

class clsGridvw_tipos_inmuebles { //vw_tipos_inmuebles class @27-AA30675D

//Variables @27-6E51DF5A

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

//Class_Initialize Event @27-939E1CF5
    function clsGridvw_tipos_inmuebles($RelativePath, & $Parent)
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = "vw_tipos_inmuebles";
        $this->Visible = True;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Grid vw_tipos_inmuebles";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->DataSource = new clsvw_tipos_inmueblesDataSource($this);
        $this->ds = & $this->DataSource;
        $this->PageSize = CCGetParam($this->ComponentName . "PageSize", "");
        if(!is_numeric($this->PageSize) || !strlen($this->PageSize))
            $this->PageSize = 50;
        else
            $this->PageSize = intval($this->PageSize);
        if ($this->PageSize > 100)
            $this->PageSize = 100;
        if($this->PageSize == 0)
            $this->Errors->addError("<p>Form: Grid " . $this->ComponentName . "<br>Error: (CCS06) Invalid page size.</p>");
        $this->PageNumber = intval(CCGetParam($this->ComponentName . "Page", 1));
        if ($this->PageNumber <= 0) $this->PageNumber = 1;

        $this->tipo_inmueble1 = new clsControl(ccsLabel, "tipo_inmueble1", "tipo_inmueble1", ccsText, "", CCGetRequestParam("tipo_inmueble1", ccsGet, NULL), $this);
        $this->tipo_inmueble = new clsControl(ccsLabel, "tipo_inmueble", "tipo_inmueble", ccsText, "", CCGetRequestParam("tipo_inmueble", ccsGet, NULL), $this);
    }
//End Class_Initialize Event

//Initialize Method @27-90E704C5
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->DataSource->PageSize = & $this->PageSize;
        $this->DataSource->AbsolutePage = & $this->PageNumber;
        $this->DataSource->SetOrder($this->SorterName, $this->SorterDirection);
    }
//End Initialize Method

//Show Method @27-B214D61F
    function Show()
    {
        global $Tpl;
        global $CCSLocales;
        if(!$this->Visible) return;

        $this->RowNumber = 0;


        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeSelect", $this);


        $this->DataSource->Prepare();
        $this->DataSource->Open();
        $this->HasRecord = $this->DataSource->has_next_record();
        $this->IsEmpty = ! $this->HasRecord;
        $this->Attributes->Show();

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow", $this);
        if(!$this->Visible) return;

        $GridBlock = "Grid " . $this->ComponentName;
        $ParentPath = $Tpl->block_path;
        $Tpl->block_path = $ParentPath . "/" . $GridBlock;


        if (!$this->IsEmpty) {
            $this->ControlsVisible["tipo_inmueble1"] = $this->tipo_inmueble1->Visible;
            $this->ControlsVisible["tipo_inmueble"] = $this->tipo_inmueble->Visible;
            while ($this->ForceIteration || (($this->RowNumber < $this->PageSize) &&  ($this->HasRecord = $this->DataSource->has_next_record()))) {
                $this->RowNumber++;
                if ($this->HasRecord) {
                    $this->DataSource->next_record();
                    $this->DataSource->SetValues();
                }
                $Tpl->block_path = $ParentPath . "/" . $GridBlock . "/Row";
                $this->tipo_inmueble1->SetValue($this->DataSource->tipo_inmueble1->GetValue());
                $this->tipo_inmueble->SetValue($this->DataSource->tipo_inmueble->GetValue());
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->tipo_inmueble1->Show();
                $this->tipo_inmueble->Show();
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

//GetErrors Method @27-99467403
    function GetErrors()
    {
        $errors = "";
        $errors = ComposeStrings($errors, $this->tipo_inmueble1->Errors->ToString());
        $errors = ComposeStrings($errors, $this->tipo_inmueble->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

} //End vw_tipos_inmuebles Class @27-FCB6E20C

class clsvw_tipos_inmueblesDataSource extends clsDBPrincipal {  //vw_tipos_inmueblesDataSource Class @27-4CBAD278

//DataSource Variables @27-8C07F24E
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $CountSQL;
    public $wp;


    // Datasource fields
    public $tipo_inmueble1;
    public $tipo_inmueble;
//End DataSource Variables

//DataSourceClass_Initialize Event @27-4D5B70A5
    function clsvw_tipos_inmueblesDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid vw_tipos_inmuebles";
        $this->Initialize();
        $this->tipo_inmueble1 = new clsField("tipo_inmueble1", ccsText, "");
        
        $this->tipo_inmueble = new clsField("tipo_inmueble", ccsText, "");
        

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @27-20175544
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "tipo_inmueble";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            "");
    }
//End SetOrder Method

//Prepare Method @27-14D6CD9D
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
    }
//End Prepare Method

//Open Method @27-A5D32E4C
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM vw_tipos_inmuebles";
        $this->SQL = "SELECT * \n\n" .
        "FROM vw_tipos_inmuebles {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @27-A23E3064
    function SetValues()
    {
        $this->tipo_inmueble1->SetDBValue($this->f("tipo_inmueble"));
        $this->tipo_inmueble->SetDBValue($this->f("tipo_inmueble"));
    }
//End SetValues Method

} //End vw_tipos_inmueblesDataSource Class @27-FCB6E20C







//Initialize Page @1-C9B3D1A7
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
$TemplateFileName = "propiedades.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "./";
$Charset = $Charset ? $Charset : "windows-1252";
//End Initialize Page

//Include events file @1-3B09C3F1
include_once("./propiedades_events.php");
//End Include events file

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-D8BE1EEC
$DBPrincipal = new clsDBPrincipal();
$MainPage->Connections["Principal"] = & $DBPrincipal;
$Attributes = new clsAttributes("page:");
$MainPage->Attributes = & $Attributes;

// Controls
$vw_propiedades_caracas = new clsGridvw_propiedades_caracas("", $MainPage);
$lblZona = new clsControl(ccsLabel, "lblZona", "lblZona", ccsText, "", CCGetRequestParam("lblZona", ccsGet, NULL), $MainPage);
$lblHab = new clsControl(ccsLabel, "lblHab", "lblHab", ccsText, "", CCGetRequestParam("lblHab", ccsGet, NULL), $MainPage);
$lblHab->HTML = true;
$lblBanos = new clsControl(ccsLabel, "lblBanos", "lblBanos", ccsText, "", CCGetRequestParam("lblBanos", ccsGet, NULL), $MainPage);
$lblBanos->HTML = true;
$lblPuestos = new clsControl(ccsLabel, "lblPuestos", "lblPuestos", ccsText, "", CCGetRequestParam("lblPuestos", ccsGet, NULL), $MainPage);
$lblPuestos->HTML = true;
$lblTipo = new clsControl(ccsLabel, "lblTipo", "lblTipo", ccsText, "", CCGetRequestParam("lblTipo", ccsGet, NULL), $MainPage);
$lblMetrosConst = new clsControl(ccsLabel, "lblMetrosConst", "lblMetrosConst", ccsText, "", CCGetRequestParam("lblMetrosConst", ccsGet, NULL), $MainPage);
$lblMetrosConst->HTML = true;
$lblMetrosTerr = new clsControl(ccsLabel, "lblMetrosTerr", "lblMetrosTerr", ccsText, "", CCGetRequestParam("lblMetrosTerr", ccsGet, NULL), $MainPage);
$lblMetrosTerr->HTML = true;
$lblPrecio = new clsControl(ccsLabel, "lblPrecio", "lblPrecio", ccsText, "", CCGetRequestParam("lblPrecio", ccsGet, NULL), $MainPage);
$lblPrecio->HTML = true;
$hdnTipoInmueble = new clsControl(ccsLabel, "hdnTipoInmueble", "hdnTipoInmueble", ccsText, "", CCGetRequestParam("hdnTipoInmueble", ccsGet, NULL), $MainPage);
$hdnTipoNegocio = new clsControl(ccsLabel, "hdnTipoNegocio", "hdnTipoNegocio", ccsText, "", CCGetRequestParam("hdnTipoNegocio", ccsGet, NULL), $MainPage);
$hdnHabitaciones = new clsControl(ccsLabel, "hdnHabitaciones", "hdnHabitaciones", ccsText, "", CCGetRequestParam("hdnHabitaciones", ccsGet, NULL), $MainPage);
$hdnBanos = new clsControl(ccsLabel, "hdnBanos", "hdnBanos", ccsText, "", CCGetRequestParam("hdnBanos", ccsGet, NULL), $MainPage);
$hdnEstacionamientos = new clsControl(ccsLabel, "hdnEstacionamientos", "hdnEstacionamientos", ccsText, "", CCGetRequestParam("hdnEstacionamientos", ccsGet, NULL), $MainPage);
$hdnOrden = new clsControl(ccsLabel, "hdnOrden", "hdnOrden", ccsText, "", CCGetRequestParam("hdnOrden", ccsGet, NULL), $MainPage);
$hdnPage = new clsControl(ccsLabel, "hdnPage", "hdnPage", ccsText, "", CCGetRequestParam("hdnPage", ccsGet, NULL), $MainPage);
$vw_tipos_inmuebles = new clsGridvw_tipos_inmuebles("", $MainPage);
$txtZona = new clsControl(ccsLabel, "txtZona", "txtZona", ccsText, "", CCGetRequestParam("txtZona", ccsGet, NULL), $MainPage);
$txtMetrosc1 = new clsControl(ccsLabel, "txtMetrosc1", "txtMetrosc1", ccsText, "", CCGetRequestParam("txtMetrosc1", ccsGet, NULL), $MainPage);
$txtMetrosc2 = new clsControl(ccsLabel, "txtMetrosc2", "txtMetrosc2", ccsText, "", CCGetRequestParam("txtMetrosc2", ccsGet, NULL), $MainPage);
$txtMetrost1 = new clsControl(ccsLabel, "txtMetrost1", "txtMetrost1", ccsText, "", CCGetRequestParam("txtMetrost1", ccsGet, NULL), $MainPage);
$txtMetrost2 = new clsControl(ccsLabel, "txtMetrost2", "txtMetrost2", ccsText, "", CCGetRequestParam("txtMetrost2", ccsGet, NULL), $MainPage);
$chkComercial = new clsControl(ccsLabel, "chkComercial", "chkComercial", ccsText, "", CCGetRequestParam("chkComercial", ccsGet, NULL), $MainPage);
$txtPrecio1 = new clsControl(ccsLabel, "txtPrecio1", "txtPrecio1", ccsText, "", CCGetRequestParam("txtPrecio1", ccsGet, NULL), $MainPage);
$txtPrecio2 = new clsControl(ccsLabel, "txtPrecio2", "txtPrecio2", ccsText, "", CCGetRequestParam("txtPrecio2", ccsGet, NULL), $MainPage);
$MainPage->vw_propiedades_caracas = & $vw_propiedades_caracas;
$MainPage->lblZona = & $lblZona;
$MainPage->lblHab = & $lblHab;
$MainPage->lblBanos = & $lblBanos;
$MainPage->lblPuestos = & $lblPuestos;
$MainPage->lblTipo = & $lblTipo;
$MainPage->lblMetrosConst = & $lblMetrosConst;
$MainPage->lblMetrosTerr = & $lblMetrosTerr;
$MainPage->lblPrecio = & $lblPrecio;
$MainPage->hdnTipoInmueble = & $hdnTipoInmueble;
$MainPage->hdnTipoNegocio = & $hdnTipoNegocio;
$MainPage->hdnHabitaciones = & $hdnHabitaciones;
$MainPage->hdnBanos = & $hdnBanos;
$MainPage->hdnEstacionamientos = & $hdnEstacionamientos;
$MainPage->hdnOrden = & $hdnOrden;
$MainPage->hdnPage = & $hdnPage;
$MainPage->vw_tipos_inmuebles = & $vw_tipos_inmuebles;
$MainPage->txtZona = & $txtZona;
$MainPage->txtMetrosc1 = & $txtMetrosc1;
$MainPage->txtMetrosc2 = & $txtMetrosc2;
$MainPage->txtMetrost1 = & $txtMetrost1;
$MainPage->txtMetrost2 = & $txtMetrost2;
$MainPage->chkComercial = & $chkComercial;
$MainPage->txtPrecio1 = & $txtPrecio1;
$MainPage->txtPrecio2 = & $txtPrecio2;
$vw_propiedades_caracas->Initialize();
$vw_tipos_inmuebles->Initialize();

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

//Go to destination page @1-562EB8B3
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBPrincipal->close();
    header("Location: " . $Redirect);
    unset($vw_propiedades_caracas);
    unset($vw_tipos_inmuebles);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-1AAB74C2
$vw_propiedades_caracas->Show();
$vw_tipos_inmuebles->Show();
$lblZona->Show();
$lblHab->Show();
$lblBanos->Show();
$lblPuestos->Show();
$lblTipo->Show();
$lblMetrosConst->Show();
$lblMetrosTerr->Show();
$lblPrecio->Show();
$hdnTipoInmueble->Show();
$hdnTipoNegocio->Show();
$hdnHabitaciones->Show();
$hdnBanos->Show();
$hdnEstacionamientos->Show();
$hdnOrden->Show();
$hdnPage->Show();
$txtZona->Show();
$txtMetrosc1->Show();
$txtMetrosc2->Show();
$txtMetrost1->Show();
$txtMetrost2->Show();
$chkComercial->Show();
$txtPrecio1->Show();
$txtPrecio2->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-D15109E1
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBPrincipal->close();
unset($vw_propiedades_caracas);
unset($vw_tipos_inmuebles);
unset($Tpl);
//End Unload Page


?>
