<?php
//Include Common Files @1-94F247C2
define("RelativePath", ".");
define("PathToCurrentPage", "/");
define("FileName", "tests.php");
include_once(RelativePath . "/Common.php");
include_once(RelativePath . "/Template.php");
include_once(RelativePath . "/Sorter.php");
include_once(RelativePath . "/Navigator.php");
//End Include Common Files

class clsGridpropiedades { //propiedades class @2-9DCFE072

//Variables @2-2000C003

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
    public $Sorter_id_mls;
    public $Sorter_tipo_inmueble;
//End Variables

//Class_Initialize Event @2-8E5A230F
    function clsGridpropiedades($RelativePath, & $Parent)
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = "propiedades";
        $this->Visible = True;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Grid propiedades";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->DataSource = new clspropiedadesDataSource($this);
        $this->ds = & $this->DataSource;
        $this->PageSize = CCGetParam($this->ComponentName . "PageSize", "");
        if(!is_numeric($this->PageSize) || !strlen($this->PageSize))
            $this->PageSize = 40;
        else
            $this->PageSize = intval($this->PageSize);
        if ($this->PageSize > 100)
            $this->PageSize = 100;
        if($this->PageSize == 0)
            $this->Errors->addError("<p>Form: Grid " . $this->ComponentName . "<br>Error: (CCS06) Invalid page size.</p>");
        $this->PageNumber = intval(CCGetParam($this->ComponentName . "Page", 1));
        if ($this->PageNumber <= 0) $this->PageNumber = 1;
        $this->SorterName = CCGetParam("propiedadesOrder", "");
        $this->SorterDirection = CCGetParam("propiedadesDir", "");

        $this->Sorter_id_mls = new clsSorter($this->ComponentName, "Sorter_id_mls", $FileName, $this);
        $this->Sorter_tipo_inmueble = new clsSorter($this->ComponentName, "Sorter_tipo_inmueble", $FileName, $this);
        $this->RowOpenTag = new clsPanel("RowOpenTag", $this);
        $this->RowComponents = new clsPanel("RowComponents", $this);
        $this->id_mls = new clsControl(ccsLabel, "id_mls", "id_mls", ccsInteger, "", CCGetRequestParam("id_mls", ccsGet, NULL), $this);
        $this->tipo_inmueble = new clsControl(ccsLabel, "tipo_inmueble", "tipo_inmueble", ccsText, "", CCGetRequestParam("tipo_inmueble", ccsGet, NULL), $this);
        $this->RowCloseTag = new clsPanel("RowCloseTag", $this);
        $this->Navigator = new clsNavigator($this->ComponentName, "Navigator", $FileName, 10, tpCentered, $this);
        $this->Navigator->PageSizes = array("1", "5", "10", "25", "50");
        $this->RowComponents->AddComponent("id_mls", $this->id_mls);
        $this->RowComponents->AddComponent("tipo_inmueble", $this->tipo_inmueble);
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

//Show Method @2-111FE0C3
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
        $this->Attributes->SetValue("numberOfColumns", 4);
        $this->Attributes->Show();

        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShow", $this);
        if(!$this->Visible) return;

        $GridBlock = "Grid " . $this->ComponentName;
        $ParentPath = $Tpl->block_path;
        $Tpl->block_path = $ParentPath . "/" . $GridBlock;


        if (!$this->IsEmpty) {
            while ($this->ForceIteration || (($this->RowNumber < $this->PageSize) &&  ($this->HasRecord = $this->DataSource->has_next_record()))) {
                $this->RowNumber++;
                if ($this->HasRecord) {
                    $this->DataSource->next_record();
                    $this->DataSource->SetValues();
                }
                $Tpl->block_path = $ParentPath . "/" . $GridBlock . "/Row";
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
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
        $this->id_mls->SetValue($this->DataSource->id_mls->GetValue());
        $this->tipo_inmueble->SetValue($this->DataSource->tipo_inmueble->GetValue());
        $this->Navigator->PageNumber = $this->DataSource->AbsolutePage;
        $this->Navigator->PageSize = $this->PageSize;
        if ($this->DataSource->RecordsCount == "CCS not counted")
            $this->Navigator->TotalPages = $this->DataSource->AbsolutePage + ($this->DataSource->next_record() ? 1 : 0);
        else
            $this->Navigator->TotalPages = $this->DataSource->PageCount();
        if ($this->Navigator->TotalPages <= 1) {
            $this->Navigator->Visible = false;
        }
        $this->Sorter_id_mls->Show();
        $this->Sorter_tipo_inmueble->Show();
        $this->RowOpenTag->Show();
        $this->RowComponents->Show();
        $this->id_mls->Show();
        $this->tipo_inmueble->Show();
        $this->RowCloseTag->Show();
        $this->Navigator->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

//GetErrors Method @2-580C33D7
    function GetErrors()
    {
        $errors = "";
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

} //End propiedades Class @2-FCB6E20C

class clspropiedadesDataSource extends clsDBPrincipal {  //propiedadesDataSource Class @2-0647ED0C

//DataSource Variables @2-9F499D02
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $CountSQL;
    public $wp;


    // Datasource fields
    public $id_mls;
    public $tipo_inmueble;
//End DataSource Variables

//DataSourceClass_Initialize Event @2-2A474935
    function clspropiedadesDataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid propiedades";
        $this->Initialize();
        $this->id_mls = new clsField("id_mls", ccsInteger, "");
        
        $this->tipo_inmueble = new clsField("tipo_inmueble", ccsText, "");
        

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @2-0116F4C4
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            array("Sorter_id_mls" => array("id_mls", ""), 
            "Sorter_tipo_inmueble" => array("tipo_inmueble", "")));
    }
//End SetOrder Method

//Prepare Method @2-14D6CD9D
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
    }
//End Prepare Method

//Open Method @2-D54E1BC3
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM propiedades";
        $this->SQL = "SELECT * \n\n" .
        "FROM propiedades {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @2-1FD36136
    function SetValues()
    {
        $this->id_mls->SetDBValue(trim($this->f("id_mls")));
        $this->tipo_inmueble->SetDBValue($this->f("tipo_inmueble"));
    }
//End SetValues Method

} //End propiedadesDataSource Class @2-FCB6E20C

class clsGridpropiedades1 { //propiedades1 class @13-A1D53F46

//Variables @13-B119F36E

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
    public $Sorter_id_mls;
    public $Sorter_tipo_inmueble;
    public $Sorter_tipo_negocio;
//End Variables

//Class_Initialize Event @13-4218CC95
    function clsGridpropiedades1($RelativePath, & $Parent)
    {
        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->ComponentName = "propiedades1";
        $this->Visible = True;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Grid propiedades1";
        $this->Attributes = new clsAttributes($this->ComponentName . ":");
        $this->DataSource = new clspropiedades1DataSource($this);
        $this->ds = & $this->DataSource;
        $this->PageSize = CCGetParam($this->ComponentName . "PageSize", "");
        if(!is_numeric($this->PageSize) || !strlen($this->PageSize))
            $this->PageSize = 10;
        else
            $this->PageSize = intval($this->PageSize);
        if ($this->PageSize > 100)
            $this->PageSize = 100;
        if($this->PageSize == 0)
            $this->Errors->addError("<p>Form: Grid " . $this->ComponentName . "<br>Error: (CCS06) Invalid page size.</p>");
        $this->PageNumber = intval(CCGetParam($this->ComponentName . "Page", 1));
        if ($this->PageNumber <= 0) $this->PageNumber = 1;
        $this->SorterName = CCGetParam("propiedades1Order", "");
        $this->SorterDirection = CCGetParam("propiedades1Dir", "");

        $this->id_mls = new clsControl(ccsLabel, "id_mls", "id_mls", ccsInteger, "", CCGetRequestParam("id_mls", ccsGet, NULL), $this);
        $this->tipo_inmueble = new clsControl(ccsLabel, "tipo_inmueble", "tipo_inmueble", ccsText, "", CCGetRequestParam("tipo_inmueble", ccsGet, NULL), $this);
        $this->tipo_negocio = new clsControl(ccsLabel, "tipo_negocio", "tipo_negocio", ccsText, "", CCGetRequestParam("tipo_negocio", ccsGet, NULL), $this);
        $this->Sorter_id_mls = new clsSorter($this->ComponentName, "Sorter_id_mls", $FileName, $this);
        $this->Sorter_tipo_inmueble = new clsSorter($this->ComponentName, "Sorter_tipo_inmueble", $FileName, $this);
        $this->Sorter_tipo_negocio = new clsSorter($this->ComponentName, "Sorter_tipo_negocio", $FileName, $this);
        $this->Navigator = new clsNavigator($this->ComponentName, "Navigator", $FileName, 10, tpCentered, $this);
        $this->Navigator->PageSizes = array("1", "5", "10", "25", "50");
    }
//End Class_Initialize Event

//Initialize Method @13-90E704C5
    function Initialize()
    {
        if(!$this->Visible) return;

        $this->DataSource->PageSize = & $this->PageSize;
        $this->DataSource->AbsolutePage = & $this->PageNumber;
        $this->DataSource->SetOrder($this->SorterName, $this->SorterDirection);
    }
//End Initialize Method

//Show Method @13-A657AC12
    function Show()
    {
        global $Tpl;
        global $CCSLocales;
        if(!$this->Visible) return;

        $this->RowNumber = 0;

        $this->DataSource->Parameters["urls_habitaciones"] = CCGetFromGet("s_habitaciones", NULL);
        $this->DataSource->Parameters["urls_banos"] = CCGetFromGet("s_banos", NULL);
        $this->DataSource->Parameters["urls_tipo_inmueble"] = CCGetFromGet("s_tipo_inmueble", NULL);
        $this->DataSource->Parameters["urls_tipo_negocio"] = CCGetFromGet("s_tipo_negocio", NULL);

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
            $this->ControlsVisible["id_mls"] = $this->id_mls->Visible;
            $this->ControlsVisible["tipo_inmueble"] = $this->tipo_inmueble->Visible;
            $this->ControlsVisible["tipo_negocio"] = $this->tipo_negocio->Visible;
            while ($this->ForceIteration || (($this->RowNumber < $this->PageSize) &&  ($this->HasRecord = $this->DataSource->has_next_record()))) {
                $this->RowNumber++;
                if ($this->HasRecord) {
                    $this->DataSource->next_record();
                    $this->DataSource->SetValues();
                }
                $Tpl->block_path = $ParentPath . "/" . $GridBlock . "/Row";
                $this->id_mls->SetValue($this->DataSource->id_mls->GetValue());
                $this->tipo_inmueble->SetValue($this->DataSource->tipo_inmueble->GetValue());
                $this->tipo_negocio->SetValue($this->DataSource->tipo_negocio->GetValue());
                $this->Attributes->SetValue("rowNumber", $this->RowNumber);
                $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeShowRow", $this);
                $this->Attributes->Show();
                $this->id_mls->Show();
                $this->tipo_inmueble->Show();
                $this->tipo_negocio->Show();
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
        $this->Navigator->PageNumber = $this->DataSource->AbsolutePage;
        $this->Navigator->PageSize = $this->PageSize;
        if ($this->DataSource->RecordsCount == "CCS not counted")
            $this->Navigator->TotalPages = $this->DataSource->AbsolutePage + ($this->DataSource->next_record() ? 1 : 0);
        else
            $this->Navigator->TotalPages = $this->DataSource->PageCount();
        if ($this->Navigator->TotalPages <= 1) {
            $this->Navigator->Visible = false;
        }
        $this->Sorter_id_mls->Show();
        $this->Sorter_tipo_inmueble->Show();
        $this->Sorter_tipo_negocio->Show();
        $this->Navigator->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
        $this->DataSource->close();
    }
//End Show Method

//GetErrors Method @13-0BFF137A
    function GetErrors()
    {
        $errors = "";
        $errors = ComposeStrings($errors, $this->id_mls->Errors->ToString());
        $errors = ComposeStrings($errors, $this->tipo_inmueble->Errors->ToString());
        $errors = ComposeStrings($errors, $this->tipo_negocio->Errors->ToString());
        $errors = ComposeStrings($errors, $this->Errors->ToString());
        $errors = ComposeStrings($errors, $this->DataSource->Errors->ToString());
        return $errors;
    }
//End GetErrors Method

} //End propiedades1 Class @13-FCB6E20C

class clspropiedades1DataSource extends clsDBPrincipal {  //propiedades1DataSource Class @13-89DF3DCD

//DataSource Variables @13-2F73DC08
    public $Parent = "";
    public $CCSEvents = "";
    public $CCSEventResult;
    public $ErrorBlock;
    public $CmdExecution;

    public $CountSQL;
    public $wp;


    // Datasource fields
    public $id_mls;
    public $tipo_inmueble;
    public $tipo_negocio;
//End DataSource Variables

//DataSourceClass_Initialize Event @13-83ACD718
    function clspropiedades1DataSource(& $Parent)
    {
        $this->Parent = & $Parent;
        $this->ErrorBlock = "Grid propiedades1";
        $this->Initialize();
        $this->id_mls = new clsField("id_mls", ccsInteger, "");
        
        $this->tipo_inmueble = new clsField("tipo_inmueble", ccsText, "");
        
        $this->tipo_negocio = new clsField("tipo_negocio", ccsText, "");
        

    }
//End DataSourceClass_Initialize Event

//SetOrder Method @13-D73EAFA2
    function SetOrder($SorterName, $SorterDirection)
    {
        $this->Order = "";
        $this->Order = CCGetOrder($this->Order, $SorterName, $SorterDirection, 
            array("Sorter_id_mls" => array("id_mls", ""), 
            "Sorter_tipo_inmueble" => array("tipo_inmueble", ""), 
            "Sorter_tipo_negocio" => array("tipo_negocio", "")));
    }
//End SetOrder Method

//Prepare Method @13-A0B6F36A
    function Prepare()
    {
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->wp = new clsSQLParameters($this->ErrorBlock);
        $this->wp->AddParameter("1", "urls_habitaciones", ccsSingle, "", "", $this->Parameters["urls_habitaciones"], "", false);
        $this->wp->AddParameter("2", "urls_banos", ccsSingle, "", "", $this->Parameters["urls_banos"], "", false);
        $this->wp->AddParameter("3", "urls_tipo_inmueble", ccsText, "", "", $this->Parameters["urls_tipo_inmueble"], "", false);
        $this->wp->AddParameter("4", "urls_tipo_negocio", ccsText, "", "", $this->Parameters["urls_tipo_negocio"], "", false);
        $this->wp->Criterion[1] = $this->wp->Operation(opEqual, "habitaciones", $this->wp->GetDBValue("1"), $this->ToSQL($this->wp->GetDBValue("1"), ccsSingle),false);
        $this->wp->Criterion[2] = $this->wp->Operation(opEqual, "banos", $this->wp->GetDBValue("2"), $this->ToSQL($this->wp->GetDBValue("2"), ccsSingle),false);
        $this->wp->Criterion[3] = $this->wp->Operation(opContains, "tipo_inmueble", $this->wp->GetDBValue("3"), $this->ToSQL($this->wp->GetDBValue("3"), ccsText),false);
        $this->wp->Criterion[4] = $this->wp->Operation(opContains, "tipo_negocio", $this->wp->GetDBValue("4"), $this->ToSQL($this->wp->GetDBValue("4"), ccsText),false);
        $this->Where = $this->wp->opAND(
             false, $this->wp->opAND(
             false, $this->wp->opAND(
             false, 
             $this->wp->Criterion[1], 
             $this->wp->Criterion[2]), 
             $this->wp->Criterion[3]), 
             $this->wp->Criterion[4]);
    }
//End Prepare Method

//Open Method @13-D54E1BC3
    function Open()
    {
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeBuildSelect", $this->Parent);
        $this->CountSQL = "SELECT COUNT(*)\n\n" .
        "FROM propiedades";
        $this->SQL = "SELECT * \n\n" .
        "FROM propiedades {SQL_Where} {SQL_OrderBy}";
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "BeforeExecuteSelect", $this->Parent);
        if ($this->CountSQL) 
            $this->RecordsCount = CCGetDBValue(CCBuildSQL($this->CountSQL, $this->Where, ""), $this);
        else
            $this->RecordsCount = "CCS not counted";
        $this->query($this->OptimizeSQL(CCBuildSQL($this->SQL, $this->Where, $this->Order)));
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "AfterExecuteSelect", $this->Parent);
    }
//End Open Method

//SetValues Method @13-1372A756
    function SetValues()
    {
        $this->id_mls->SetDBValue(trim($this->f("id_mls")));
        $this->tipo_inmueble->SetDBValue($this->f("tipo_inmueble"));
        $this->tipo_negocio->SetDBValue($this->f("tipo_negocio"));
    }
//End SetValues Method

} //End propiedades1DataSource Class @13-FCB6E20C

class clsRecordpropiedadesSearch { //propiedadesSearch Class @14-4F50A3E6

//Variables @14-9E315808

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

//Class_Initialize Event @14-9E35B823
    function clsRecordpropiedadesSearch($RelativePath, & $Parent)
    {

        global $FileName;
        global $CCSLocales;
        global $DefaultDateFormat;
        $this->Visible = true;
        $this->Parent = & $Parent;
        $this->RelativePath = $RelativePath;
        $this->Errors = new clsErrors();
        $this->ErrorBlock = "Record propiedadesSearch/Error";
        $this->ReadAllowed = true;
        if($this->Visible)
        {
            $this->ComponentName = "propiedadesSearch";
            $this->Attributes = new clsAttributes($this->ComponentName . ":");
            $CCSForm = explode(":", CCGetFromGet("ccsForm", ""), 2);
            if(sizeof($CCSForm) == 1)
                $CCSForm[1] = "";
            list($FormName, $FormMethod) = $CCSForm;
            $this->FormEnctype = "application/x-www-form-urlencoded";
            $this->FormSubmitted = ($FormName == $this->ComponentName);
            $Method = $this->FormSubmitted ? ccsPost : ccsGet;
            $this->ClearParameters = new clsControl(ccsLink, "ClearParameters", "ClearParameters", ccsText, "", CCGetRequestParam("ClearParameters", $Method, NULL), $this);
            $this->ClearParameters->Parameters = CCGetQueryString("QueryString", array("s_habitaciones", "s_banos", "s_tipo_inmueble", "s_tipo_negocio", "propiedades1Order", "propiedades1Dir", "ccsForm"));
            $this->ClearParameters->Page = "tests.php";
            $this->Button_DoSearch = new clsButton("Button_DoSearch", $Method, $this);
            $this->s_habitaciones = new clsControl(ccsTextBox, "s_habitaciones", "s_habitaciones", ccsSingle, "", CCGetRequestParam("s_habitaciones", $Method, NULL), $this);
            $this->s_banos = new clsControl(ccsTextBox, "s_banos", "s_banos", ccsSingle, "", CCGetRequestParam("s_banos", $Method, NULL), $this);
            $this->s_tipo_inmueble = new clsControl(ccsListBox, "s_tipo_inmueble", "s_tipo_inmueble", ccsText, "", CCGetRequestParam("s_tipo_inmueble", $Method, NULL), $this);
            $this->s_tipo_negocio = new clsControl(ccsListBox, "s_tipo_negocio", "s_tipo_negocio", ccsText, "", CCGetRequestParam("s_tipo_negocio", $Method, NULL), $this);
            $this->propiedades1Order = new clsControl(ccsListBox, "propiedades1Order", "propiedades1Order", ccsText, "", CCGetRequestParam("propiedades1Order", $Method, NULL), $this);
            $this->propiedades1Order->DSType = dsListOfValues;
            $this->propiedades1Order->Values = array(array("", "Seleccionar Campo"), array("Sorter_id_mls", "Id Mls"), array("Sorter_tipo_inmueble", "Tipo Inmueble"), array("Sorter_tipo_negocio", "Tipo Negocio"));
            $this->propiedades1Dir = new clsControl(ccsListBox, "propiedades1Dir", "propiedades1Dir", ccsText, "", CCGetRequestParam("propiedades1Dir", $Method, NULL), $this);
            $this->propiedades1Dir->DSType = dsListOfValues;
            $this->propiedades1Dir->Values = array(array("", "Seleccionar Orden"), array("ASC", "Ascendente"), array("DESC", "Descendente"));
        }
    }
//End Class_Initialize Event

//Validate Method @14-CED4D835
    function Validate()
    {
        global $CCSLocales;
        $Validation = true;
        $Where = "";
        $Validation = ($this->s_habitaciones->Validate() && $Validation);
        $Validation = ($this->s_banos->Validate() && $Validation);
        $Validation = ($this->s_tipo_inmueble->Validate() && $Validation);
        $Validation = ($this->s_tipo_negocio->Validate() && $Validation);
        $Validation = ($this->propiedades1Order->Validate() && $Validation);
        $Validation = ($this->propiedades1Dir->Validate() && $Validation);
        $this->CCSEventResult = CCGetEvent($this->CCSEvents, "OnValidate", $this);
        $Validation =  $Validation && ($this->s_habitaciones->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_banos->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_tipo_inmueble->Errors->Count() == 0);
        $Validation =  $Validation && ($this->s_tipo_negocio->Errors->Count() == 0);
        $Validation =  $Validation && ($this->propiedades1Order->Errors->Count() == 0);
        $Validation =  $Validation && ($this->propiedades1Dir->Errors->Count() == 0);
        return (($this->Errors->Count() == 0) && $Validation);
    }
//End Validate Method

//CheckErrors Method @14-B2CD58BF
    function CheckErrors()
    {
        $errors = false;
        $errors = ($errors || $this->ClearParameters->Errors->Count());
        $errors = ($errors || $this->s_habitaciones->Errors->Count());
        $errors = ($errors || $this->s_banos->Errors->Count());
        $errors = ($errors || $this->s_tipo_inmueble->Errors->Count());
        $errors = ($errors || $this->s_tipo_negocio->Errors->Count());
        $errors = ($errors || $this->propiedades1Order->Errors->Count());
        $errors = ($errors || $this->propiedades1Dir->Errors->Count());
        $errors = ($errors || $this->Errors->Count());
        return $errors;
    }
//End CheckErrors Method

//MasterDetail @14-ED598703
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

//Operation Method @14-9895D6D2
    function Operation()
    {
        if(!$this->Visible)
            return;

        global $Redirect;
        global $FileName;

        if(!$this->FormSubmitted) {
            return;
        }

        if($this->FormSubmitted) {
            $this->PressedButton = "Button_DoSearch";
            if($this->Button_DoSearch->Pressed) {
                $this->PressedButton = "Button_DoSearch";
            }
        }
        $Redirect = "tests.php";
        if($this->Validate()) {
            if($this->PressedButton == "Button_DoSearch") {
                $Redirect = "tests.php" . "?" . CCMergeQueryStrings(CCGetQueryString("Form", array("Button_DoSearch", "Button_DoSearch_x", "Button_DoSearch_y")));
                if(!CCGetEvent($this->Button_DoSearch->CCSEvents, "OnClick", $this->Button_DoSearch)) {
                    $Redirect = "";
                }
            }
        } else {
            $Redirect = "";
        }
    }
//End Operation Method

//Show Method @14-14576516
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

        $this->s_tipo_inmueble->Prepare();
        $this->s_tipo_negocio->Prepare();
        $this->propiedades1Order->Prepare();
        $this->propiedades1Dir->Prepare();

        $RecordBlock = "Record " . $this->ComponentName;
        $ParentPath = $Tpl->block_path;
        $Tpl->block_path = $ParentPath . "/" . $RecordBlock;
        $this->EditMode = $this->EditMode && $this->ReadAllowed;
        if (!$this->FormSubmitted) {
        }

        if($this->FormSubmitted || $this->CheckErrors()) {
            $Error = "";
            $Error = ComposeStrings($Error, $this->ClearParameters->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_habitaciones->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_banos->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_tipo_inmueble->Errors->ToString());
            $Error = ComposeStrings($Error, $this->s_tipo_negocio->Errors->ToString());
            $Error = ComposeStrings($Error, $this->propiedades1Order->Errors->ToString());
            $Error = ComposeStrings($Error, $this->propiedades1Dir->Errors->ToString());
            $Error = ComposeStrings($Error, $this->Errors->ToString());
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

        $this->ClearParameters->Show();
        $this->Button_DoSearch->Show();
        $this->s_habitaciones->Show();
        $this->s_banos->Show();
        $this->s_tipo_inmueble->Show();
        $this->s_tipo_negocio->Show();
        $this->propiedades1Order->Show();
        $this->propiedades1Dir->Show();
        $Tpl->parse();
        $Tpl->block_path = $ParentPath;
    }
//End Show Method

} //End propiedadesSearch Class @14-FCB6E20C

//Initialize Page @1-A505746A
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
$TemplateFileName = "tests.html";
$BlockToParse = "main";
$TemplateEncoding = "CP1252";
$ContentType = "text/html";
$PathToRoot = "./";
$Charset = $Charset ? $Charset : "windows-1252";
//End Initialize Page

//Include events file @1-CF1E5708
include_once("./tests_events.php");
//End Include events file

//Before Initialize @1-E870CEBC
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeInitialize", $MainPage);
//End Before Initialize

//Initialize Objects @1-92D4A348
$DBPrincipal = new clsDBPrincipal();
$MainPage->Connections["Principal"] = & $DBPrincipal;
$Attributes = new clsAttributes("page:");
$MainPage->Attributes = & $Attributes;

// Controls
$propiedades = new clsGridpropiedades("", $MainPage);
$propiedades1 = new clsGridpropiedades1("", $MainPage);
$propiedadesSearch = new clsRecordpropiedadesSearch("", $MainPage);
$MainPage->propiedades = & $propiedades;
$MainPage->propiedades1 = & $propiedades1;
$MainPage->propiedadesSearch = & $propiedadesSearch;
$propiedades->Initialize();
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

//Execute Components @1-C9D7CA9C
$propiedadesSearch->Operation();
//End Execute Components

//Go to destination page @1-0135063F
if($Redirect)
{
    $CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
    $DBPrincipal->close();
    header("Location: " . $Redirect);
    unset($propiedades);
    unset($propiedades1);
    unset($propiedadesSearch);
    unset($Tpl);
    exit;
}
//End Go to destination page

//Show Page @1-6A9E5778
$propiedades->Show();
$propiedades1->Show();
$propiedadesSearch->Show();
$Tpl->block_path = "";
$Tpl->Parse($BlockToParse, false);
if (!isset($main_block)) $main_block = $Tpl->GetVar($BlockToParse);
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeOutput", $MainPage);
if ($CCSEventResult) echo $main_block;
//End Show Page

//Unload Page @1-043419D9
$CCSEventResult = CCGetEvent($CCSEvents, "BeforeUnload", $MainPage);
$DBPrincipal->close();
unset($propiedades);
unset($propiedades1);
unset($propiedadesSearch);
unset($Tpl);
//End Unload Page


?>
