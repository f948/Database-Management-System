

<?php
         // define variables and set to empty values
		 $database=trim($_POST["enter_database"]);
		 $table=trim($_POST["enter_table"]);
		 
		 $error_message="";
		 
		 // form validation 
		 if(empty($database) || empty($table)){
			 $error_message="You must select a database and a table";
		 }
		 
		if($error_message ==""){
			 
			//connect to database
			$conn=mysqli_connect("localhost","root","",$database);
		 
			// connection failed 
			if(!$conn){
				die("Could not connect to database: " . mysqli_error($conn)."<br>");
			}
			else{
				print("Connected to database"."<br>");
			}

			$query = mysqli_query($conn,"SELECT * FROM ".$table);
		
			// query failed 
			if(! $query ) {
				die('Query failed: ' . mysqli_error($conn)."<br>");
			}
			else{
				print("Table found"."<br>"."<br>");
			

				$rows = mysqli_fetch_all($query);
				$numCols = mysqli_field_count($conn);
			
				echo"<table"."id=".strval("table").">";
				foreach($rows as $row){
	
					echo'<tr>'.'[';
						for($index=0;$index<=$numCols-1;$index++){
							echo","."<td".">".strval($row[$index])."</td>".",";
						}
					
					echo'</tr>';
					echo']'.'<br>';
				}
	
				echo'</table>';
			}
		}
		
		// show error messages 
		else{
			print("<p>".$error_message."</p>");
		}
			
?>

