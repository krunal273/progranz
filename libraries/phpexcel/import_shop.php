<?php
/**
 * XLS parsing uses php-excel-reader from http://code.google.com/p/php-excel-reader/
 */
	include_once("../include/config.php"); 
	include_once("../include/functions.php");

	include_once("../include/config.php"); 
	
	date_default_timezone_set('UTC');

	$Filepath = "list.xlsx";
	
	// Excel reader from http://code.google.com/p/php-excel-reader/
	require('php-excel-reader/excel_reader2.php');
	require('SpreadsheetReader.php');

	try
	{
		$Spreadsheet = new SpreadsheetReader($Filepath);
		
		$Sheets = $Spreadsheet -> Sheets();

		foreach ($Sheets as $Index => $Name)
		{
			$shop_category_name = strtolower(trim($Name));
					
			$Spreadsheet -> ChangeSheet($Index);

					
					$table = "shop_category_master";
			$query = "SELECT
					  * 
					  FROM 
					  ".$table."
					  WHERE
					  shop_category_name = '".$shop_category_name."' AND
					  shop_category_active = 1";
			$result = mysqli_query($conn, $query);			  
			if(mysqli_num_rows($result)==0)
			{
				$query = "insert into ".$table."
						  (shop_category_name, shop_category_description) 
						  values 
						  ('".$shop_category_name."','')";
				if(mysqli_query($conn, $query))		  
				{
					echo "Added Category:".$category_count++."<br/>";		  		  
					$id = mysqli_insert_id($conn);	
				}
				else
					$category_failed++;
			}
			else
			{
				while($row = mysqli_fetch_assoc($result))
				{
					$id = $row['shop_category_id'];	
				}
			}
			
		}
		
	}
	catch (Exception $E)
	{
		echo $E -> getMessage();
	}
?>
