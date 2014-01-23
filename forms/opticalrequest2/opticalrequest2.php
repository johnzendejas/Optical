<?PHP
/*
Simfatic Forms Main Form processor script

This script does all the server side processing. 
(Displaying the form, processing form submissions,
displaying errors, making CAPTCHA image, and so on.) 

All pages (including the form page) are displayed using 
templates in the 'templ' sub folder. 

The overall structure is that of a list of modules. Depending on the 
arguments (POST/GET) passed to the script, the modules process in sequence. 

Please note that just appending  a header and footer to this script won't work.
To embed the form, use the 'Copy & Paste' code in the 'Take the Code' page. 
To extend the functionality, see 'Extension Modules' in the help.

*/

@ini_set("display_errors", 1);//the error handler is added later in FormProc
error_reporting(E_ALL & ~((defined('E_STRICT')?E_STRICT:0)|E_NOTICE));

require_once(dirname(__FILE__)."/includes/opticalrequest2-lib.php");
$formproc_obj =  new SFM_FormProcessor('opticalrequest2');
$formproc_obj->initTimeZone('default');
$formproc_obj->setFormID('06e4da04-6419-479e-bcb9-8e99884f04e6');
$formproc_obj->setFormKey('ae88bce2-350a-4a47-bcb6-313bb8227c2a');
$formproc_obj->setLocale('en-US','M/d/yyyy');
$formproc_obj->setEmailFormatHTML(true);
$formproc_obj->EnableLogging(false);
$formproc_obj->SetDebugMode(false);
$formproc_obj->setIsInstalled(true);
$formproc_obj->SetPrintPreviewPage(sfm_readfile(dirname(__FILE__)."/templ/opticalrequest2_print_preview_file.txt"));
$formproc_obj->SetSingleBoxErrorDisplay(true);
$formproc_obj->setFormPage(0,sfm_readfile(dirname(__FILE__)."/templ/opticalrequest2_form_page_0.txt"));
$formproc_obj->AddElementInfo('Name','text','');
$formproc_obj->AddElementInfo('Address1','text','');
$formproc_obj->AddElementInfo('address2','text','');
$formproc_obj->AddElementInfo('City','text','');
$formproc_obj->AddElementInfo('zip','text','');
$formproc_obj->AddElementInfo('phone','text','');
$formproc_obj->AddElementInfo('lab','listbox','');
$formproc_obj->AddElementInfo('Accnt_Number','text','');
$formproc_obj->AddElementInfo('Pickup_Notes','multiline','');
$formproc_obj->setIsInstalled(true);
$formproc_obj->setFormFileFolder('./formdata');
$formproc_obj->setFormDBLogin('localhost','root','0C493891F8E85919','optical');
$formproc_obj->SetHiddenInputTrapVarName('t5c7dcc7e1742bd216af1');
$page_renderer =  new FM_FormPageDisplayModule();
$formproc_obj->addModule($page_renderer);

$validator =  new FM_FormValidator();
$validator->addValidation("Name","required","Please fill in Name");
$validator->addValidation("Address1","required","Please fill in Address1");
$validator->addValidation("City","required","Please fill in City");
$validator->addValidation("City","alpha_s","The input for City should be a valid alphabetic value");
$validator->addValidation("zip","required","Please fill in zip");
$validator->addValidation("zip","numeric","The input for zip should be a valid numeric value");
$validator->addValidation("zip","minlen=5","The length of the input for zip should be at least 5.");
$validator->addValidation("zip","maxlen=10","The length of the input for zip should not exceed 10");
$validator->addValidation("phone","required","Please fill in phone number (10 digit)");
$validator->addValidation("phone","maxlen=16","The length of the input for phone should not exceed 16");
$validator->addValidation("phone","minlen=10","The length of the input for phone should be at least 10.");
$validator->addValidation("phone","alnum_s","The input for phone should be a valid alpha-numeric value");
$validator->addValidation("Accnt_Number","maxlen=30","The length of the input for Accnt_Number should not exceed 30");
$validator->addValidation("Pickup_Notes","maxlen=155","The length of the input for Pickup_Notes should not exceed 155");
$formproc_obj->addModule($validator);

$csv_maker =  new FM_FormDataCSVMaker(1024);
$csv_maker->AddCSVVariable(array('_sfm_form_submision_time_','_sfm_visitor_ip_','_sfm_unique_id_','Name','Address1','address2','City','zip','phone','lab','Accnt_Number','Pickup_Notes'));
$formproc_obj->addModule($csv_maker);

$s_db_handler =  new FM_SimpleDB('opticalrequest2');
$s_db_handler->AddField('_sfm_form_submision_time_','DATETIME','FormSubmissionTime');
$s_db_handler->AddField('_sfm_visitor_ip_','VARCHAR(45)','VisitorsIP');
$s_db_handler->AddField('_sfm_unique_id_','VARCHAR(35)','UniqueID');
$s_db_handler->AddField('Name','VARCHAR(100)');
$s_db_handler->AddField('Address1','VARCHAR(100)');
$s_db_handler->AddField('address2','VARCHAR(100)');
$s_db_handler->AddField('City','VARCHAR(100)');
$s_db_handler->AddField('zip','VARCHAR(100)');
$s_db_handler->AddField('phone','VARCHAR(100)');
$s_db_handler->AddField('lab','VARCHAR(100)');
$s_db_handler->AddField('Accnt_Number','VARCHAR(30)');
$s_db_handler->AddField('Pickup_Notes','MEDIUMTEXT');
$formproc_obj->addModule($s_db_handler);

$tupage =  new FM_ThankYouPage(sfm_readfile(dirname(__FILE__)."/templ/opticalrequest2_thank_u.txt"));
$formproc_obj->addModule($tupage);

$uniqueid_s =  new FM_ShortUniqueID('opticalrequest2');
$formproc_obj->AddExtensionModule($uniqueid_s);
$page_renderer->SetFormValidator($validator);
$formproc_obj->ProcessForm();

?>