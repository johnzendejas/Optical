<?php
	// Connect to the database
	require_once("_dbConfig.php");
	
	// Put the unique user id in a variable - the script know what record to pull from the database because of this variable, which comes to the script as a GET variable in this case. You could/should use a fancier, securer, less user-editable way of transmitting ids, like using a unique md5 hash for the id... again, this is just a simple example
	$id = $_GET['ID'];
	
	// Retrieve data from database
	$sql = "SELECT * FROM opticalrequest2 WHERE ID = '$id' LIMIT 1";
	$result = mysql_query($sql);
	
	if (!$result) {
		die('Could not query: ' . mysql_error());
	}
	
	if (mysql_num_rows($result) == 1) {
		// Include pdftk-php class
		require('pdftk-php.php');
		
		// Initiate the class
		$pdfmaker = new pdftk_php;
		
		// Define variables for all the data fields in the PDF form. You need to assign a column in the database to each field that you'll be using in the PDF. 
		// Example:
		// $pdf_column = $data['column'];
		
		// You can also format the MySQL data how you want here. One common example is formatting a date saved in the database. For example:
		// $pdf_date = date("l, F j, Y, g:i a", strtotime($data['date']));
		
		$data = mysql_fetch_array($result);
		$pdf_Name = $data['Name'];
		$pdf_City = $data['City'];
        $pdf_Address1 = $data['Address1'];
        $pdf_phone = $data['phone'];
        $pdf_address2 = $data['address2'];
        $pdf_zip = $data['zip'];
        $pdf_Accnt_Number = $data['Accnt_Number'];
        $pdf_Pickup_Notes = $data['Pickup_Notes'];
        $pdf__sfm_form_submision_time_ = $data['_sfm_form_submision_time_'];

		// $fdf_data_strings associates the names of the PDF form fields to the PHP variables you just set above. In order to work correctly the PDF form field name has to be exact. PDFs made in Acrobat generally have simpler names - just the name you assigned to the field. PDFs made in LiveCycle Designer nest their forms in other random page elements, creating a long and hairy field name. You can use pdftk to discover the real names of your PDF form fields: run "pdftk form.pdf dump_data_fields > form-fields.txt" to generate a report.

		// Example of field names from a PDF created in LiveCycle:
		// $fdf_data_strings= array('form1[0].#subform[0].#area[0].LastName[0]' => $pdf_lastname,  'form1[0].#subform[0].#area[0].FirstName[0]' => $pdf_firstname, 'form1[0].#subform[0].#area[0].EMail[0]' => $pdf_email, );
		$fdf_data_strings= array('Name' => $pdf_Name,  'City' => $pdf_City, 'Address1' => $pdf_Address1, 'address2' => $pdf_address2,
         'zip' => $pdf_zip, 'phone' => $pdf_phone, 'Pickup_Notes' => $pdf_Pickup_Notes, 'Accnt_Number' => $pdf_Accnt_Number, '_sfm_form_submision_time_' => $pdf__sfm_form_submision_time_);
		
		// See the documentation of pdftk-php.php for more explanation of these other variables.
		
		// Used for radio buttons and check boxes
		// Example: (For check boxes options are Yes and Off)
		// $pdf_checkbox1 = "Yes";
		// $pdf_checkbox2 = "Off";
		// $pdf_checkbox3 = "Yes";
		// $fdf_data_names = array('checkbox1' => $pdf_checkbox1,'checkbox2' => $pdf_checkbox2,'checkbox3' => $pdf_checkbox3,'checkbox4' => $pdf_checkbox4); 
		$fdf_data_names = array(); // Leave empty if there are no radio buttons or check boxes
		
		$fields_hidden = array(); // Used to hide form fields
		
		$fields_readonly = array(); // Used to make fields read only - however, flattening the output with pdftk will in effect make every field read only. If you don't want a flattened pdf and still want some read only fields, use this variable and remove the flatten flag near line 70 in pdftk-php.php
		
		// Take each REQUEST value and clean it up for fdf creation
		foreach( $_REQUEST as $key => $value ) {
		   // Translate tildes back to periods
		   $fdf_data_strings[strtr($key, '~', '.')]= $value;
		}
		
        

		// Name of file to be downloaded
		$pdf_filename = "Test PDF for $pdf_Name $pdf_City.pdf";
		
		// Name/location of original, empty PDF form
		$pdf_original = "\"C:\\temp\\file.pdf\"";

        //$passthu_command = "pdftk \"C:\Users\johnz\Documents\My Web Sites\WebSite1\pdftk-php\example\\$pdf_original\" fill_form \"$fdf_fn\" output - flatten";
		
		// Finally make the actual PDF file!
		$pdfmaker->make_pdf($fdf_data_strings, $fdf_data_names, $fields_hidden, $fields_readonly, $pdf_original, $pdf_filename);
		// The end!
	}
?> 