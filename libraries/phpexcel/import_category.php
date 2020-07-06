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
			$item_category_name = strtolower(trim($Name));
			
			$Spreadsheet -> ChangeSheet($Index);

			foreach ($Spreadsheet as $Key => $Row)
			{
				if ($Row)
				{
					$item_subcategory_name = strtolower(trim($Row[0]));
					//echo $item_category_name."->".$item_subcategory_name."<br/>";
					
			$table = "item_category_master";
			$query = "SELECT
					  * 
					  FROM 
					  ".$table."
					  WHERE
					  item_category_name = '".$item_category_name."' AND
					  item_category_active = 1";
			$result = mysqli_query($conn, $query);			  
			if(mysqli_num_rows($result)==0)
			{
				$query = "insert into ".$table."
						  (item_category_name, item_category_description) 
						  values 
						  ('".$item_category_name."','')";
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
					$id = $row['item_category_id'];	
				}
			}
			
			
			$table = "item_subcategory_master";
			$query = "SELECT
					  * 
					  FROM 
					  ".$table."
					  WHERE
					  item_subcategory_name = '".$item_subcategory_name."' AND
					  item_category_id = ".$id." AND
					  item_subcategory_active = 1";
			if(mysqli_num_rows(mysqli_query($conn, $query))==0)
			{
				$query = "insert into ".$table."
						  (item_subcategory_name, item_subcategory_description, item_category_id) 
						  values 
						  ('".$item_subcategory_name."','',".$id.")";
						  
				if(mysqli_query($conn, $query))		  
					echo "Added Sub Category:".$subcategory_count++."<br/>";		  
				else
					$subcategory_failed++;
			}
			
				}
				
			}
		}
		
	}
	catch (Exception $E)
	{
		echo $E -> getMessage();
	}
?>
