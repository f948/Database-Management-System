<?php
         // define variables and set to empty values
		 $command=trim($_POST["entry"]);
		 $database=trim($_POST["database"]);
		 $table=trim($_POST["table"]);
		 
		 //connect to database
		 
		 // CREATE DATABASE database_name;
		 if(strpos($command,"DATABASE") !=false ){
			 $conn=mysqli_connect("localhost","root","");
		 }
		 else{
			$conn=mysqli_connect("localhost","root","",$database);
		 }
		 
		// connection failed 
		if(!$conn){
			die("Could not connect to database: " . mysqli_error($conn)."<br>");
		}
		else{
			print("Connected to database"."<br>");
		}

		$query = mysqli_query($conn,$command);
		

		
		// query failed 
		if(! $query ) {
			die('Query failed: ' . mysqli_error($conn)."<br>");
		}
		else{
			
			if(!strpos($command,"DATABASE") && !strpos($command,"TABLE")){
				print("Query suceussful"."<br>");
				print($command."<br>"."executed suceussfully"."<br>"."<br>");
			
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
		
		mysqli_close($conn);
		
		// drop database
		if(strpos($command,"DROP")!==false && strpos($command,"DATABASE")!==false){
			
			$conn2=mysqli_connect("localhost","root","","sql");
			$database=mysqli_real_escape_string($conn2,$database);
			
			$query2=mysqli_query($conn2,"DELETE FROM `dbs`WHERE `db`='$database'");
			
		}
		
		// create database
		else if(strpos($command,"CREATE")!==false && strpos($command,"DATABASE")!==false){
			
			$conn2=mysqli_connect("localhost","root","","sql");
			$database=mysqli_real_escape_string($conn2,$database);
			
			$query2=mysqli_query($conn2,"INSERT INTO `dbs`(`db`) VALUES('$database')");
			
		}
		
		// drop table
		else if(strpos($command,"DROP")!==false && strpos($command,"TABLE")!==false){
			
			$conn2=mysqli_connect("localhost","root","","sql");
			$table=mysqli_real_escape_string($conn2,$table);
			
			$query2=mysqli_query($conn2,"DELETE FROM `tabs`WHERE `tab`='$table'");
		
		}
		
		// create table 
		else if(strpos($command,"CREATE")!==false && strpos($command,"TABLE")!==false){
			
			$conn2=mysqli_connect("localhost","root","","sql");
			$table=mysqli_real_escape_string($conn2,$table);
			
			$query2=mysqli_query($conn2,"INSERT INTO `tabs`(`tab`) VALUES('$table')");
			
		}
		
		// query failed 
		if(! $query2 ) {
			die('Query failed: ' . mysqli_error($conn2)."<br>");
		}
		else{
			print("Table created suceussfully");
		}
			
		mysqli_close($conn2);
?>

