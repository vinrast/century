<?php
//Include Common Files @1-DFC04426
define("RelativePath", ".");
define("PathToCurrentPage", "/");
define("FileName", "propiedades2.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

//DEL      function clsGridpropiedades($RelativePath, & $Parent)
//DEL      {
//DEL          global $FileName;
//DEL          global $CCSLocales;
//DEL          global $DefaultDateFormat;
//DEL          $this->ComponentName = "propiedades";
//DEL          $this->Visible = True;
//DEL          $this->Parent = & $Parent;
//DEL          $this->RelativePath = $RelativePath;
//DEL          $this->Errors = new clsErrors();
//DEL          $this->ErrorBlock = "Grid propiedades";
//DEL          $this->Attributes = new clsAttributes($this->ComponentName . ":");
//DEL          $this->DataSource = new clspropiedadesDataSource($this);
//DEL          $this->ds = & $this->DataSource;
//DEL          $this->PageSize = CCGetParam($this->ComponentName . "PageSize", "");
//DEL          if(!is_numeric($this->PageSize) || !strlen($this->PageSize))
//DEL              $this->PageSize = 40;
//DEL          else
//DEL              $this->PageSize = intval($this->PageSize);
//DEL          if ($this->PageSize > 100)
//DEL              $this->PageSize = 100;
//DEL          if($this->PageSize == 0)
//DEL              $this->Errors->addError("<p>Form: Grid " . $this->ComponentName . "<br>Error: (CCS06) Invalid page size.</p>");
//DEL          $this->PageNumber = intval(CCGetParam($this->ComponentName . "Page", 1));
//DEL          if ($this->PageNumber <= 0) $this->PageNumber = 1;
//DEL  
//DEL          $this->RowOpenTag = new clsPanel("RowOpenTag", $this);
//DEL  		$this->RowComponents = new clsPanel("RowComponents", $this);
//DEL          $this->precio = new clsControl(ccsLabel, "precio", "precio", ccsSingle, array(False, 0, ",", ".", False, "", "", 1, True, ""), CCGetRequestParam("precio", ccsGet, NULL), $this);
//DEL          $this->tipo_inmueble = new clsControl(ccsLabel, "tipo_inmueble", "tipo_inmueble", ccsText, "", CCGetRequestParam("tipo_inmueble", ccsGet, NULL), $this);
//DEL          $this->tipo_negocio = new clsControl(ccsLabel, "tipo_negocio", "tipo_negocio", ccsText, "", CCGetRequestParam("tipo_negocio", ccsGet, NULL), $this);
//DEL          $this->ciudad = new clsControl(ccsLabel, "ciudad", "ciudad", ccsText, "", CCGetRequestParam("ciudad", ccsGet, NULL), $this);
//DEL          $this->urbanizacion = new clsControl(ccsLabel, "urbanizacion", "urbanizacion", ccsText, "", CCGetRequestParam("urbanizacion", ccsGet, NULL), $this);
//DEL          $this->ciudad1 = new clsControl(ccsLabel, "ciudad1", "ciudad1", ccsText, "", CCGetRequestParam("ciudad1", ccsGet, NULL), $this);
//DEL          $this->urbanizacion1 = new clsControl(ccsLabel, "urbanizacion1", "urbanizacion1", ccsText, "", CCGetRequestParam("urbanizacion1", ccsGet, NULL), $this);
//DEL          $this->habitaciones = new clsControl(ccsLabel, "habitaciones", "habitaciones", ccsSingle, "", CCGetRequestParam("habitaciones", ccsGet, NULL), $this);
//DEL          $this->banos = new clsControl(ccsLabel, "banos", "banos", ccsSingle, "", CCGetRequestParam("banos", ccsGet, NULL), $this);
//DEL          $this->estacionamientos = new clsControl(ccsLabel, "estacionamientos", "estacionamientos", ccsSingle, "", CCGetRequestParam("estacionamientos", ccsGet, NULL), $this);
//DEL          $this->media = new clsControl(ccsLabel, "media", "media", ccsText, "", CCGetRequestParam("media", ccsGet, NULL), $this);
//DEL          $this->RowCloseTag = new clsPanel("RowCloseTag", $this);
//DEL          $this->Navigator = new clsNavigator($this->ComponentName, "Navigator", $FileName, 5, tpCentered, $this);
//DEL          $this->Navigator->PageSizes = array("1", "5", "10", "25", "50");
//DEL      }

//DEL      function Show()
//DEL      {
//DEL          global $Tpl;
//DEL          global $CCSLocales;
//DEL          if(!$this->Visible) return;
//DEL  
//DEL          $this->RowNumber = 0;
//DEL  
//DEL  
//DEL          $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeSelect", $this);
//DEL  
//DEL  
//DEL          $this->DataSource->Prepare();
//DEL          $this->DataSource->Open();
//DEL          $this->HasRecord = $this->DataSource->has_next_record();
//DEL          $this->IsEmpty = ! $this->HasRecord;
//DEL          $this->Attributes->SetValue("numberOfColumns", 6);
//DEL          $this->Attributes->Show();
//DEL  
//DEL          $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow", $this);
//DEL          if(!$this->Visible) return;
//DEL  
//DEL          $GridBlock = "Grid " . $this->ComponentName;
//DEL          $ParentPath = $Tpl->block_path;
//DEL          $Tpl->block_path = $ParentPath . "/" . $GridBlock;
//DEL  
//DEL  
//DEL          if (!$this->IsEmpty) {
//DEL              $this->ControlsVisible["RowOpenTag"] = $this->RowOpenTag->Visible;
//DEL  			$this->ControlsVisible["RowComponents"] = $this->RowComponents->Visible;
//DEL              $this->ControlsVisible["precio"] = $this->precio->Visible;
//DEL              $this->ControlsVisible["tipo_inmueble"] = $this->tipo_inmueble->Visible;
//DEL              $this->ControlsVisible["tipo_negocio"] = $this->tipo_negocio->Visible;
//DEL              $this->ControlsVisible["ciudad"] = $this->ciudad->Visible;
//DEL              $this->ControlsVisible["urbanizacion"] = $this->urbanizacion->Visible;
//DEL              $this->ControlsVisible["ciudad1"] = $this->ciudad1->Visible;
//DEL              $this->ControlsVisible["urbanizacion1"] = $this->urbanizacion1->Visible;
//DEL              $this->ControlsVisible["habitaciones"] = $this->habitaciones->Visible;
//DEL              $this->ControlsVisible["banos"] = $this->banos->Visible;
//DEL              $this->ControlsVisible["estacionamientos"] = $this->estacionamientos->Visible;
//DEL              $this->ControlsVisible["media"] = $this->media->Visible;
//DEL              $this->ControlsVisible["RowCloseTag"] = $this->RowCloseTag->Visible;
//DEL              while ($this->ForceIteration || (($this->RowNumber < $this->PageSize) &&  ($this->HasRecord = $this->DataSource->has_next_record()))) {
//DEL                  $this->RowNumber++;
//DEL                  if ($this->HasRecord) {
//DEL                      $this->DataSource->next_record();
//DEL                      $this->DataSource->SetValues();
//DEL                  }
//DEL                  $Tpl->block_path = $ParentPath . "/" . $GridBlock . "/Row";
//DEL                  $this->precio->SetValue($this->DataSource->precio->GetValue());
//DEL                  $this->tipo_inmueble->SetValue($this->DataSource->tipo_inmueble->GetValue());
//DEL                  $this->tipo_negocio->SetValue($this->DataSource->tipo_negocio->GetValue());
//DEL                  $this->ciudad->SetValue($this->DataSource->ciudad->GetValue());
//DEL                  $this->urbanizacion->SetValue($this->DataSource->urbanizacion->GetValue());
//DEL                  $this->ciudad1->SetValue($this->DataSource->ciudad1->GetValue());
//DEL                  $this->urbanizacion1->SetValue($this->DataSource->urbanizacion1->GetValue());
//DEL                  $this->habitaciones->SetValue($this->DataSource->habitaciones->GetValue());
//DEL                  $this->banos->SetValue($this->DataSource->banos->GetValue());
//DEL                  $this->estacionamientos->SetValue($this->DataSource->estacionamientos->GetValue());
//DEL                  $this->media->SetValue($this->DataSource->media->GetValue());
//DEL                  $this->Attributes->SetValue("rowNumber", $this->RowNumber);
//DEL                  $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
//DEL                  $this->Attributes->Show();
//DEL                  $this->RowOpenTag->Show();
//DEL  				$this->RowComponents->Show();
//DEL                  $this->precio->Show();
//DEL                  $this->tipo_inmueble->Show();
//DEL                  $this->tipo_negocio->Show();
//DEL                  $this->ciudad->Show();
//DEL                  $this->urbanizacion->Show();
//DEL                  $this->ciudad1->Show();
//DEL                  $this->urbanizacion1->Show();
//DEL                  $this->habitaciones->Show();
//DEL                  $this->banos->Show();
//DEL                  $this->estacionamientos->Show();
//DEL                  $this->media->Show();
//DEL                  $this->RowCloseTag->Show();
//DEL                  $Tpl->block_path = $ParentPath . "/" . $GridBlock;
//DEL                  $Tpl->parse("Row", true);
//DEL              }
//DEL          }
//DEL          else { // Show NoRecords block if no records are found
//DEL              $this->Attributes->Show();
//DEL              $Tpl->parse("NoRecords", false);
//DEL          }
//DEL  
//DEL          $errors = $this->GetErrors();
//DEL          if(strlen($errors))
//DEL          {
//DEL              $Tpl->replaceblock("", $errors);
//DEL              $Tpl->block_path = $ParentPath;
//DEL              return;
//DEL          }
//DEL          $this->Navigator->PageNumber = $this->DataSource->AbsolutePage;
//DEL          $this->Navigator->PageSize = $this->PageSize;
//DEL          if ($this->DataSource->RecordsCount == "CCS not counted")
//DEL              $this->Navigator->TotalPages = $this->DataSource->AbsolutePage + ($this->DataSource->next_record() ? 1 : 0);
//DEL          else
//DEL              $this->Navigator->TotalPages = $this->DataSource->PageCount();
//DEL          if ($this->Navigator->TotalPages <= 1) {
//DEL              $this->Navigator->Visible = false;
//DEL          }
//DEL          $this->Navigator->Show();
//DEL          $Tpl->parse();
//DEL          $Tpl->block_path = $ParentPath;
//DEL          $this->DataSource->close();
//DEL      }



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

//Class_Initialize Event @75-DDB7BC5E
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
        $this->urbanizacion = new clsControl(ccsLabel, "urbanizacion", "urbanizacion", ccsText, "", CCGetRequestParam("urbanizacion", ccsGet, NULL), $this);
        $this->ciudad1 = new clsControl(ccsLabel, "ciudad1", "ciudad1", ccsText, "", CCGetRequestParam("ciudad1", ccsGet, NULL), $this);
        $this->urbanizacion1 = new clsControl(ccsLabel, "urbanizacion1", "urbanizacion1", ccsText, "", CCGetRequestParam("urbanizacion1", ccsGet, NULL), $this);
        $this->habitaciones = new clsControl(ccsLabel, "habitaciones", "habitaciones", ccsSingle, "", CCGetRequestParam("habitaciones", ccsGet, NULL), $this);
        $this->banos = new clsControl(ccsLabel, "banos", "banos", ccsSingle, "", CCGetRequestParam("banos", ccsGet, NULL), $this);
        $this->estacionamientos = new clsControl(ccsLabel, "estacionamientos", "estacionamientos", ccsSingle, "", CCGetRequestParam("estacionamientos", ccsGet, NULL), $this);
        $this->media = new clsControl(ccsLabel, "media", "media", ccsText, "", CCGetRequestParam("media", ccsGet, NULL), $this);
        $this->RowCloseTag = new clsPanel("RowCloseTag", $this);
        $this->Navigator1 = new clsNavigator($this->ComponentName, "Navigator1", $FileName, 5, tpCentered, $this);
        $this->Navigator1->PageSizes = array("1", "5", "10", "25", "50");
        $this->RowComponents->AddComponent("precio", $this->precio);
        $this->RowComponents->AddComponent("tipo_inmueble", $this->tipo_inmueble);
        $this->RowComponents->AddComponent("tipo_negocio", $this->tipo_negocio);
        $this->RowComponents->AddComponent("ciudad", $this->ciudad);
        $this->RowComponents->AddComponent("urbanizacion", $this->urbanizacion);
        $this->RowComponents->AddComponent("ciudad1", $this->ciudad1);
        $this->RowComponents->AddComponent("urbanizacion1", $this->urbanizacion1);
        $this->RowComponents->AddComponent("habitaciones", $this->habitaciones);
        $this->RowComponents->AddComponent("banos", $this->banos);
        $this->RowComponents->AddComponent("estacionamientos", $this->estacionamientos);
        $this->RowComponents->AddComponent("media", $this->media);
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

//Show Method @75-B2F7821D
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
            $this->ControlsVisible["urbanizacion"] = $this->urbanizacion->Visible;
            $this->ControlsVisible["ciudad1"] = $this->ciudad1->Visible;
            $this->ControlsVisible["urbanizacion1"] = $this->urbanizacion1->Visible;
            $this->ControlsVisible["habitaciones"] = $this->habitaciones->Visible;
            $this->ControlsVisible["banos"] = $this->banos->Visible;
            $this->ControlsVisible["estacionamientos"] = $this->estacionamientos->Visible;
            $this->ControlsVisible["media"] = $this->media->Visible;
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
                $this->urbanizacion->SetValue($this->DataSource->urbanizacion->GetValue());
                $this->ciudad1->SetValue($this->DataSource->ciudad1->GetValue());
                $this->urbanizacion1->SetValue($this->DataSource->urbanizacion1->GetValue());
                $this->habitaciones->SetValue($this->DataSource->habitaciones->GetValue());
                $this->banos->SetValue($this->DataSource->banos->GetValue());
                $this->estacionamientos->SetValue($this->DataSource->estacionamientos->GetValue());
                $this->media->SetValue($this->DataSource->media->GetValue());
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

//GetErrors Method @75-6927A61A
    function GetErrors()
    {
        $errors = "";
        $errors = ComposeStrings($errors, $this->precio->Errors->ToString());
        $errors = ComposeStrings($errors, $this->tipo_inmueble->Errors->ToString());
        $errors = ComposeStrings($errors, $this->tipo_negocio->Errors->ToString());
        $errors = ComposeStrings($errors, $this->ciudad->Errors->ToString());
        $errors = ComposeStrings($errors, $this->urbanizacion->Errors->ToString());
        $errors = ComposeStrings($errors, $this->ciudad1->Errors->ToString());
        $errors = ComposeStrings($errors, $this->urbanizacion1->Errors->ToString());
        $errors = ComposeStrings($errors, $this->habitaciones->Errors->ToString());
        $errors = ComposeStrings($errors, $this->banos->Errors->ToString());
        $errors = ComposeStrings($errors, $this->estacionamientos->Errors->ToString());
        $errors = ComposeStrings($errors, $this->media->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

} //End vw_propiedades_caracas Class @75-FCB6E20C

class clsvw_propiedades_caracasDataSource extends clsDBPrincipal {  //vw_propiedades_caracasDataSource Class @75-612483CE

//DataSource Variables @75-3DFA919E
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
    public $urbanizacion;
    public $ciudad1;
    public $urbanizacion1;
    public $habitaciones;
    public $banos;
    public $estacionamientos;
    public $media;
//End DataSource Variables

//DataSourceClass_Initialize Event @75-8CEEFC0A
    function clsvw_propiedades_caracasDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid vw_propiedades_caracas";
        $this->Initialize();
        $this->precio = new clsField("precio", ccsSingle, "");
        
        $this->tipo_inmueble = new clsField("tipo_inmueble", ccsText, "");
        
        $this->tipo_negocio = new clsField("tipo_negocio", ccsText, "");
        
        $this->ciudad = new clsField("ciudad", ccsText, "");
        
        $this->urbanizacion = new clsField("urbanizacion", ccsText, "");
        
        $this->ciudad1 = new clsField("ciudad1", ccsText, "");
        
        $this->urbanizacion1 = new clsField("urbanizacion1", ccsText, "");
        
        $this->habitaciones = new clsField("habitaciones", ccsSingle, "");
        
        $this->banos = new clsField("banos", ccsSingle, "");
        
        $this->estacionamientos = new clsField("estacionamientos", ccsSingle, "");
        
        $this->media = new clsField("media", ccsText, "");
        

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @75-68DFE939
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "id_mls";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            "");
    }
//End SetOrder Method

//Prepare Method @75-14D6CD9D
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
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

//SetValues Method @75-8589DD55
    function SetValues()
    {
        $this->precio->SetDBValue(trim($this->f("precio")));
        $this->tipo_inmueble->SetDBValue($this->f("tipo_inmueble"));
        $this->tipo_negocio->SetDBValue($this->f("tipo_negocio"));
        $this->ciudad->SetDBValue($this->f("ciudad"));
        $this->urbanizacion->SetDBValue($this->f("urbanizacion"));
        $this->ciudad1->SetDBValue($this->f("ciudad"));
        $this->urbanizacion1->SetDBValue($this->f("urbanizacion"));
        $this->habitaciones->SetDBValue(trim($this->f("habitaciones")));
        $this->banos->SetDBValue(trim($this->f("banos")));
        $this->estacionamientos->SetDBValue(trim($this->f("estacionamientos")));
        $this->media->SetDBValue($this->f("media"));
    }
//End SetValues Method

} //End vw_propiedades_caracasDataSource Class @75-FCB6E20C





//Initialize Page @1-1E242B73
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
$TemplateFileName = "propiedades2.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "./";
$Charset = $Charset ? $Charset : "windows-1252";
//End Initialize Page

//Include events file @1-7CA71AC7
include_once("./propiedades2_events.php");
//End Include events file

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-8F5450AB
$DBPrincipal = new clsDBPrincipal();
$MainPage->Connections["Principal"] = & $DBPrincipal;
$Attributes = new clsAttributes("page:");
$MainPage->Attributes = & $Attributes;

// Controls
$vw_propiedades_caracas = new clsGridvw_propiedades_caracas("", $MainPage);
$MainPage->vw_propiedades_caracas = & $vw_propiedades_caracas;
$vw_propiedades_caracas->Initialize();

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

//Go to destination page @1-D8E8E44E
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBPrincipal->close();
    header("Location: " . $Redirect);
    unset($vw_propiedades_caracas);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-FB355256
$vw_propiedades_caracas->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-8ECCB7BA
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBPrincipal->close();
unset($vw_propiedades_caracas);
unset($Tpl);
//End Unload Page


?>
