<?php
//Include Common Files @1-9758F9CE
define("RelativePath", ".");
define("PathToCurrentPage", "/");
define("FileName", "nosotros.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

class clsGridofertas_propiedades { //ofertas_propiedades class @2-5570AE6D

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

//Class_Initialize Event @2-56105962
    function clsGridofertas_propiedades($RelativePath, & $Parent)
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = "ofertas_propiedades";
        $this->Visible = True;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Grid ofertas_propiedades";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->DataSource = new clsofertas_propiedadesDataSource($this);
        $this->ds = & $this->DataSource;
        $this->PageSize = CCGetParam($this->ComponentName . "PageSize", "");
        if(!is_numeric($this->PageSize) || !strlen($this->PageSize))
            $this->PageSize = 4;
        else
            $this->PageSize = intval($this->PageSize);
        if ($this->PageSize > 100)
            $this->PageSize = 100;
        if($this->PageSize == 0)
            $this->Errors->addError("<p>Form: Grid " . $this->ComponentName . "<br>Error: (CCS06) Invalid page size.</p>");
        $this->PageNumber = intval(CCGetParam($this->ComponentName . "Page", 1));
        if ($this->PageNumber <= 0) $this->PageNumber = 1;

        $this->media = new clsControl(ccsLabel, "media", "media", ccsText, "", CCGetRequestParam("media", ccsGet, NULL), $this);
        $this->precio = new clsControl(ccsLabel, "precio", "precio", ccsSingle, array(False, 0, ",", ".", False, "", "", 1, True, ""), CCGetRequestParam("precio", ccsGet, NULL), $this);
        $this->tipo_inmueble = new clsControl(ccsLabel, "tipo_inmueble", "tipo_inmueble", ccsText, "", CCGetRequestParam("tipo_inmueble", ccsGet, NULL), $this);
        $this->tipo_negocio = new clsControl(ccsLabel, "tipo_negocio", "tipo_negocio", ccsText, "", CCGetRequestParam("tipo_negocio", ccsGet, NULL), $this);
        $this->habitaciones = new clsControl(ccsLabel, "habitaciones", "habitaciones", ccsSingle, "", CCGetRequestParam("habitaciones", ccsGet, NULL), $this);
        $this->banos = new clsControl(ccsLabel, "banos", "banos", ccsSingle, "", CCGetRequestParam("banos", ccsGet, NULL), $this);
        $this->estacionamientos = new clsControl(ccsLabel, "estacionamientos", "estacionamientos", ccsSingle, "", CCGetRequestParam("estacionamientos", ccsGet, NULL), $this);
        $this->ciudad = new clsControl(ccsLabel, "ciudad", "ciudad", ccsText, "", CCGetRequestParam("ciudad", ccsGet, NULL), $this);
        $this->urbanizacion = new clsControl(ccsLabel, "urbanizacion", "urbanizacion", ccsText, "", CCGetRequestParam("urbanizacion", ccsGet, NULL), $this);
        $this->codigo = new clsControl(ccsLabel, "codigo", "codigo", ccsText, "", CCGetRequestParam("codigo", ccsGet, NULL), $this);
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

//Show Method @2-CCA64A57
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
            $this->ControlsVisible["media"] = $this->media->Visible;
            $this->ControlsVisible["precio"] = $this->precio->Visible;
            $this->ControlsVisible["tipo_inmueble"] = $this->tipo_inmueble->Visible;
            $this->ControlsVisible["tipo_negocio"] = $this->tipo_negocio->Visible;
            $this->ControlsVisible["habitaciones"] = $this->habitaciones->Visible;
            $this->ControlsVisible["banos"] = $this->banos->Visible;
            $this->ControlsVisible["estacionamientos"] = $this->estacionamientos->Visible;
            $this->ControlsVisible["ciudad"] = $this->ciudad->Visible;
            $this->ControlsVisible["urbanizacion"] = $this->urbanizacion->Visible;
            $this->ControlsVisible["codigo"] = $this->codigo->Visible;
            while ($this->ForceIteration || (($this->RowNumber < $this->PageSize) &&  ($this->HasRecord = $this->DataSource->has_next_record()))) {
                // Parse Separator
                if($this->RowNumber) {
                    $this->Attributes->Show();
                    $Tpl->parseto("Separator", true, "Row");
                }
                $this->RowNumber++;
                if ($this->HasRecord) {
                    $this->DataSource->next_record();
                    $this->DataSource->SetValues();
                }
                $Tpl->block_path = $ParentPath . "/" . $GridBlock . "/Row";
                $this->media->SetValue($this->DataSource->media->GetValue());
                $this->precio->SetValue($this->DataSource->precio->GetValue());
                $this->tipo_inmueble->SetValue($this->DataSource->tipo_inmueble->GetValue());
                $this->tipo_negocio->SetValue($this->DataSource->tipo_negocio->GetValue());
                $this->habitaciones->SetValue($this->DataSource->habitaciones->GetValue());
                $this->banos->SetValue($this->DataSource->banos->GetValue());
                $this->estacionamientos->SetValue($this->DataSource->estacionamientos->GetValue());
                $this->ciudad->SetValue($this->DataSource->ciudad->GetValue());
                $this->urbanizacion->SetValue($this->DataSource->urbanizacion->GetValue());
                $this->codigo->SetValue($this->DataSource->codigo->GetValue());
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->media->Show();
                $this->precio->Show();
                $this->tipo_inmueble->Show();
                $this->tipo_negocio->Show();
                $this->habitaciones->Show();
                $this->banos->Show();
                $this->estacionamientos->Show();
                $this->ciudad->Show();
                $this->urbanizacion->Show();
                $this->codigo->Show();
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

//GetErrors Method @2-62C4A4F3
    function GetErrors()
    {
        $errors = "";
        $errors = ComposeStrings($errors, $this->media->Errors->ToString());
        $errors = ComposeStrings($errors, $this->precio->Errors->ToString());
        $errors = ComposeStrings($errors, $this->tipo_inmueble->Errors->ToString());
        $errors = ComposeStrings($errors, $this->tipo_negocio->Errors->ToString());
        $errors = ComposeStrings($errors, $this->habitaciones->Errors->ToString());
        $errors = ComposeStrings($errors, $this->banos->Errors->ToString());
        $errors = ComposeStrings($errors, $this->estacionamientos->Errors->ToString());
        $errors = ComposeStrings($errors, $this->ciudad->Errors->ToString());
        $errors = ComposeStrings($errors, $this->urbanizacion->Errors->ToString());
        $errors = ComposeStrings($errors, $this->codigo->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

} //End ofertas_propiedades Class @2-FCB6E20C

class clsofertas_propiedadesDataSource extends clsDBPrincipal {  //ofertas_propiedadesDataSource Class @2-93ECD1B6

//DataSource Variables @2-B6D51A89
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $CountSQL;
    public $wp;


    // Datasource fields
    public $media;
    public $precio;
    public $tipo_inmueble;
    public $tipo_negocio;
    public $habitaciones;
    public $banos;
    public $estacionamientos;
    public $ciudad;
    public $urbanizacion;
    public $codigo;
//End DataSource Variables

//DataSourceClass_Initialize Event @2-FCC61527
    function clsofertas_propiedadesDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid ofertas_propiedades";
        $this->Initialize();
        $this->media = new clsField("media", ccsText, "");
        
        $this->precio = new clsField("precio", ccsSingle, "");
        
        $this->tipo_inmueble = new clsField("tipo_inmueble", ccsText, "");
        
        $this->tipo_negocio = new clsField("tipo_negocio", ccsText, "");
        
        $this->habitaciones = new clsField("habitaciones", ccsSingle, "");
        
        $this->banos = new clsField("banos", ccsSingle, "");
        
        $this->estacionamientos = new clsField("estacionamientos", ccsSingle, "");
        
        $this->ciudad = new clsField("ciudad", ccsText, "");
        
        $this->urbanizacion = new clsField("urbanizacion", ccsText, "");
        
        $this->codigo = new clsField("codigo", ccsText, "");
        

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @2-DC6D1E98
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "id";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            "");
    }
//End SetOrder Method

//Prepare Method @2-14D6CD9D
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
    }
//End Prepare Method

//Open Method @2-8ADB8424
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM ofertas INNER JOIN propiedades ON\n\n" .
        "ofertas.id_mls = propiedades.id_mls";
        $this->SQL = "SELECT propiedades.id_mls AS propiedades_id_mls, ofertas.*, tipo_inmueble, tipo_negocio, precio, habitaciones, banos, estacionamientos,\n\n" .
        "ciudad, urbanizacion, (SELECT id_media FROM media WHERE target_id = propiedades.id_mls LIMIT 1) AS media \n\n" .
        "FROM ofertas INNER JOIN propiedades ON\n\n" .
        "ofertas.id_mls = propiedades.id_mls {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @2-58C094EC
    function SetValues()
    {
        $this->media->SetDBValue($this->f("media"));
        $this->precio->SetDBValue(trim($this->f("precio")));
        $this->tipo_inmueble->SetDBValue($this->f("tipo_inmueble"));
        $this->tipo_negocio->SetDBValue($this->f("tipo_negocio"));
        $this->habitaciones->SetDBValue(trim($this->f("habitaciones")));
        $this->banos->SetDBValue(trim($this->f("banos")));
        $this->estacionamientos->SetDBValue(trim($this->f("estacionamientos")));
        $this->ciudad->SetDBValue($this->f("ciudad"));
        $this->urbanizacion->SetDBValue($this->f("urbanizacion"));
        $this->codigo->SetDBValue($this->f("id_mls"));
    }
//End SetValues Method

} //End ofertas_propiedadesDataSource Class @2-FCB6E20C

//DEL      function Show()
//DEL      {
//DEL          global $Tpl;
//DEL          global $CCSLocales;
//DEL          if(!$this->Visible) return;
//DEL  
//DEL          $this->RowNumber = 0;
//DEL  
//DEL          $this->DataSource->Parameters["urlp"] = CCGetFromGet("p", NULL);
//DEL  
//DEL          $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeSelect", $this);
//DEL  
//DEL  
//DEL          $this->DataSource->Prepare();
//DEL          $this->DataSource->Open();
//DEL          $this->HasRecord = $this->DataSource->has_next_record();
//DEL          $this->IsEmpty = ! $this->HasRecord;
//DEL          $this->Attributes->SetValue("numberOfColumns", 4);
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
//DEL              $this->ControlsVisible["RowComponents"] = $this->RowComponents->Visible;
//DEL              $this->ControlsVisible["id_media"] = $this->id_media->Visible;
//DEL              $this->ControlsVisible["id_media3"] = $this->id_media3->Visible;
//DEL              $this->ControlsVisible["id_media1"] = $this->id_media1->Visible;
//DEL              $this->ControlsVisible["id_media2"] = $this->id_media2->Visible;
//DEL              $this->ControlsVisible["RowCloseTag"] = $this->RowCloseTag->Visible;
//DEL              while ($this->ForceIteration || (($this->RowNumber < $this->PageSize) &&  ($this->HasRecord = $this->DataSource->has_next_record()))) {
//DEL                  $this->RowNumber++;
//DEL                  if ($this->HasRecord) {
//DEL                      $this->DataSource->next_record();
//DEL                      $this->DataSource->SetValues();
//DEL                  }
//DEL                  $Tpl->block_path = $ParentPath . "/" . $GridBlock . "/Row";
//DEL                  $this->id_media->SetValue($this->DataSource->id_media->GetValue());
//DEL                  $this->id_media3->SetValue($this->DataSource->id_media3->GetValue());
//DEL                  $this->id_media1->SetValue($this->DataSource->id_media1->GetValue());
//DEL                  $this->id_media2->SetValue($this->DataSource->id_media2->GetValue());
//DEL                  $this->Attributes->SetValue("rowNumber", $this->RowNumber);
//DEL                  $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
//DEL                  $this->Attributes->Show();
//DEL                  $this->RowOpenTag->Show();
//DEL                  $this->RowComponents->Show();
//DEL                  $this->RowCloseTag->Show();
//DEL                  $Tpl->block_path = $ParentPath . "/" . $GridBlock;
//DEL                  $Tpl->parse("Row", true);
//DEL              }
//DEL          }
//DEL  
//DEL          $errors = $this->GetErrors();
//DEL          if(strlen($errors))
//DEL          {
//DEL              $Tpl->replaceblock("", $errors);
//DEL              $Tpl->block_path = $ParentPath;
//DEL              return;
//DEL          }
//DEL          $Tpl->parse();
//DEL          $Tpl->block_path = $ParentPath;
//DEL          $this->DataSource->close();
//DEL      }



















//Initialize Page @1-B9687E74
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
$TemplateFileName = "nosotros.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "./";
$Charset = $Charset ? $Charset : "windows-1252";
//End Initialize Page

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-D30FDD61
$DBPrincipal = new clsDBPrincipal();
$MainPage->Connections["Principal"] = & $DBPrincipal;
$Attributes = new clsAttributes("page:");
$MainPage->Attributes = & $Attributes;

// Controls
$ofertas_propiedades = new clsGridofertas_propiedades("", $MainPage);
$MainPage->ofertas_propiedades = & $ofertas_propiedades;
$ofertas_propiedades->Initialize();

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

//Go to destination page @1-E7B6475B
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBPrincipal->close();
    header("Location: " . $Redirect);
    unset($ofertas_propiedades);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-78331891
$ofertas_propiedades->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-91EFC280
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBPrincipal->close();
unset($ofertas_propiedades);
unset($Tpl);
//End Unload Page


?>
