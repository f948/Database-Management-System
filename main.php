
<?php
	
		$conn = mysqli_connect("localhost","root","","sql");
	
		$command="SELECT * FROM `dbs`";
		$query = mysqli_query($conn,$command);
		
		$rows=mysqli_fetch_all($query);

		
		echo'<label for="databases">Databases</label>';
		echo'<br>';
		echo'<select>';
		
		foreach($rows as $row){
			echo'<option id="databases" name="databases"value='.$row[0].'>'.$row[0].'</option>';
		}
		
		echo'</select>'.'<br>';
		
		$command2="SELECT * FROM `tabs`";
		$query2 = mysqli_query($conn,$command2);
		
		$rows2=mysqli_fetch_all($query2);

		
		echo'<label for="tables">Tables</label>';
		echo'<br>';
		echo'<select>';
		
		foreach($rows2 as $row2){
			echo'<option id="tables" name="tables"value='.$row2[0].'>'.$row2[0].'</option>';
		}
		
		echo'</select>';
	

	
	if(isset($_POST["query"])){
		
         // define variables and set to empty values
		 $command=trim($_POST["entry"]);
		 $database=trim($_POST["database"]);
		 $table=trim($_POST["table"]);
		 $error_messages="";
		 
		 // form validation 
		 if(empty($database)){
			 $error_messages.="Database must not be empty"."<br>";
		 }
		 
		 if(empty($table)){
			 $error_messages.="Table must not be empty"."<br>";
		 }
		 
		 if(!strpos($command,$database)){
			 $error_messages.="Your command must operate on the database entered"."<br>";
		 }
		 
		 if(!strpos($command,$table)){
			 $error_messages.="Your command must operate on the table entered"."<br>";
		 }
		 
		 //connect to database
		 
		 if($error_messages == ""){
			 
			// CREATE DATABASE database_name;
			if(strpos($command,"DATABASE") !==false ){
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
		}
		
		else{
			print($error_messages);
		}
	}
	
	if(isset($_POST["search"])){
		$conn = mysqli_connect("localhost","root","","sql");
	
		$command="SELECT * FROM `dbs`";
		$query = mysqli_query($conn,$command);
		
		$rows=mysqli_fetch_all($query);

		
		echo'<label for="databases">Databases</label>';
		echo'<br>';
		echo'<select>';
		
		foreach($rows as $row){
			echo'<option id="databases" name="databases"value='.$row[0].'>'.$row[0].'</option>';
		}
		
		echo'</select>'.'<br>';
		
		$command2="SELECT * FROM `tabs`";
		$query2 = mysqli_query($conn,$command2);
		
		$rows2=mysqli_fetch_all($query2);

		
		echo'<label for="tables">Tables</label>';
		echo'<br>';
		echo'<select>';
		
		foreach($rows2 as $row2){
			echo'<option id="tables" name="tables"value='.$row2[0].'>'.$row2[0].'</option>';
		}
		
		echo'</select>';
	}
	
	if(isset($_POST["search"])){
		
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
	}
?>

<html>
	<head>
		<form method="POST"action="main.php">
			<label for="database">Enter the database name</label>
			<br>
			<input type="text" id="database" name="database"></input>
			<br>
			<label for="table">Enter the table name</label>
			<br>
			<input type="text" id="table" name="table"></input>
			<br>
			<label for="queries">Choose a command</label>
			<br>
			<select name="queries" id="queries" onchange="addQuery()">
				<option value="SELECT FROM">SELECT FROM</option>
				<option value="SELECT DISTINCT FROM">SELECT DISTINCT FROM</option>
				<option value="WHERE">WHERE</option>
				<option value="AND">AND</option>
				<option value="OR">OR</option>
				<option value="NOT">NOT</option>
				<option value="ORDER BY ASC">ORDER BY ASC</option>
				<option value="ORDER BY DESC">ORDER BY DESC</option>
				<option value="INSERT INTO VALUES">INSERT INTO VALUES</option>
				<option value="UPDATE SET">UPDATE SET</option>
				<option value="DELETE FROM WHERE">DELETE FROM WHERE</option>
				<option value="SELECT MAX FROM WHERE">SELECT MAX FROM</option>
				<option value="SELECT MIN FROM WHERE">SELECT MIN FROM</option>
				<option value="SELECT COUNT FROM WHERE">SELECT COUNT FROM</option>
				<option value="SELECT AVG FROM WHERE">SELECT AVG FROM</option>
				<option value="SELECT SUM FROM WHERE">SELECT SUM FROM</option>
				<option value="AS TABLE">AS TABLE</option>
				<option value="AS COLUMN">AS COLUMN</option>
				<option value="LIKE">LIKE</option>
				<option value="IN">IN</option>
				<option value="BETWEEN AND">BETWEEN AND</option>
				<option value="INNER JOIN">INNER JOIN</option>
				<option value="LEFT JOIN">LEFT JOIN</option>
				<option value="RIGHT JOIN">RIGHT JOIN</option>
				<option value="FULL OUTER JOIN">FULL OUTER JOIN</option>
				<option value="UNION">UNION</option>
				<option value="GROUP BY">GROUP BY</option>
				<option value="HAVING">HAVING</option>
				<option value="EXISTS">EXISTS</option>
				<option value="ANY">ANY</option>
				<option value="ALL">ALL</option>
				<option value="SELECT INTO">SELECT INTO</option>
				<option value="INSERT INTO SELECT">INSERT INTO SELECT</option>
				<option value="CASE">CASE</option>
				<option value="CREATE PROCEDURE">CREATE PROCEDURE</option>
				<option value="EXECUTE PROCEDURE">EXECUTE PROCEDURE</option>
				<option value="CREATE TABLE">CREATE TABLE</option>
				<option value="CREATE TABLE WITH CONSTRAINTS">CREATE TABLE WITH CONSTRAINTS</option>
				<option value="DROP TABLE">DROP TABLE</option>
				<option value="ALTER TABLE ADD">ALTER TABLE ADD</option>
				<option value="ALTER TABLE DROP">ALTER TABLE DROP</option>
				<option value="CREATE DATABASE">CREATE DATABASE</option>
				<option value="DROP DATABASE">DROP DATABASE</option>
				<option value="BACKUP DATABASE">BACKUP DATABASE</option>
				<option value="BACKUP DATABASE WITH DIFFERENTIAL">BACKUP DATABASE WITH DIFFERENTIAL</option>
			</select>
			<br>
			<label for="entry">Enter Query</label>
			<br>
			<textarea style="width:300px;height: 300px"id="entry" name="entry"value=""></textarea>
			<br>
			<input type="submit" id="query" name="query" value="Execute Query">
		</form> 
		
		<form method="POST" action="main.php">
			<label for="enter_database">Enter a database</label>
			<br>
			<input type="text" id="enter_database" name="enter_database"></input>
			<br>
			<label for="enter_table">Enter a table</label>
			<br>
			<input type="text" id="enter_table" name="enter_table"></input>
			<br>
			<input type="submit" id="search" name="search" value="Search">
		</form>
	</head>
	
	<body>
		<script>
		
			// elements 
			const selectBox = document.getElementById("queries");
			const queryBox = document.getElementById("entry");
			
			
			function addQuery(){
				
				//SELECT column1, column2, ...
				//FROM table_name;
				if(selectBox.value == "SELECT FROM"){
					queryBox.value="SELECT column1, column2, ..."+"\n"+"FROM table_name;";
				}
				
				//SELECT DISTINCT column1, column2, ...
				//FROM table_name;
				else if(selectBox.value == "SELECT DISTINCT FROM"){
					queryBox.value="SELECT DISTINCT column1, column2, ..."+"\n"+"FROM table_name;";
				} 
				
				//SELECT column1, column2, ...
				//FROM table_name
				//WHERE condition;
				else if(selectBox.value =="WHERE" ){
					queryBox.value="SELECT column1, column2, ..."+"\n"+"FROM table_name"+"\n"+"WHERE condition;";
				} 
				
				//SELECT column1, column2, ...
				//FROM table_name
				//WHERE condition1 AND condition2 AND condition3 ...;
				else if(selectBox.value =="AND" ){
					queryBox.value="SELECT column1, column2, ..."+"\n"+"FROM table_name"+"\n"+"WHERE condition1 AND condition2 AND condition3 ...;";
				} 
				
				//SELECT column1, column2, ...
				//FROM table_name
				//WHERE condition1 OR condition2 OR condition3 ...;
				else if(selectBox.value =="OR" ){
					queryBox.value="SELECT column1, column2, ..."+"\n"+"FROM table_name"+"\n"+"WHERE condition1 OR condition2 OE condition3 ...;";
				} 
				
				//SELECT column1, column2, ...
				//FROM table_name
				//WHERE NOT condition;
				else if(selectBox.value =="NOT" ){
					queryBox.value="SELECT column1, column2, ..."+"\n"+"FROM table_name"+"\n"+"WHERE NOT condition;";
				} 
				
				//SELECT column1, column2, ...
				//FROM table_name
				//ORDER BY column1, column2, ... ASC;
				else if(selectBox.value =="ORDER BY ASC" ){
					queryBox.value="SELECT column1, column2, ..."+"\n"+"FROM table_name"+"\n"+"ORDER BY column1, column2, ... ASC";
				}
				
				//SELECT column1, column2, ...
				//FROM table_name
				//ORDER BY column1, column2, ... DESC;
				else if(selectBox.value =="ORDER BY DESC" ){
					queryBox.value="SELECT column1, column2, ..."+"\n"+"FROM table_name"+"\n"+"ORDER BY column1, column2, ... DESC";
				}
				
				// INSERT INTO table_name (column1, column2, column3, ...)
				//VALUES (value1, value2, value3, ...);
				else if(selectBox.value =="INSERT INTO VALUES" ){
					queryBox.value="INSERT INTO table_name (column1, column2, column3, ...)"+"\n"+"VALUES (value1, value2, value3, ...);";
				}
				
				//UPDATE table_name
				//SET column1 = value1, column2 = value2, ...
				else if(selectBox.value =="UPDATE SET" ){
					queryBox.value="UPDATE table_name"+"\n"+"SET column1 = value1, column2 = value2, ...";
				}
				
				//DELETE FROM table_name 
				//WHERE condition;
				else if(selectBox.value =="DELETE FROM WHERE" ){
					queryBox.value="DELETE FROM table_name"+"\n"+" WHERE condition;";
				}
				
				//SELECT MIN(column_name)
				//FROM table_name
				//WHERE condition;
				else if(selectBox.value =="SELECT MIN FROM WHERE" ){
					queryBox.value="SELECT MIN(column_name)"+"\n"+"FROM table_name"+"\n"+"WHERE condition;";
				}
				
				//SELECT MAX(column_name)
				//FROM table_name
				//WHERE condition;
				else if(selectBox.value =="SELECT MAX FROM WHERE" ){
					queryBox.value="SELECT MAX(column_name)"+"\n"+"FROM table_name"+"\n"+"WHERE condition;";
				}
				
				//SELECT COUNT(column_name)
				//FROM table_name
				//WHERE condition;
				else if(selectBox.value =="SELECT COUNT FROM WHERE" ){
					queryBox.value="SELECT COUNT(column_name)"+"\n"+"FROM table_name"+"\n"+"WHERE condition;";
				}
				
				//SELECT AVG(column_name)
				//FROM table_name
				//WHERE condition;
				else if(selectBox.value =="SELECT AVG FROM WHERE" ){
					queryBox.value="SELECT AVG(column_name)"+"\n"+"FROM table_name"+"\n"+"WHERE condition;";
				}
				
				//SELECT SUM(column_name)
				//FROM table_name
				//WHERE condition;
				else if(selectBox.value =="SELECT SUM FROM WHERE" ){
					queryBox.value="SELECT SUM(column_name)"+"\n"+"FROM table_name"+"\n"+"WHERE condition;";
				}
				
				//SELECT column_name(s)
				//FROM table_name AS alias_name;
				else if(selectBox.value =="AS TABLE" ){
					queryBox.value="SELECT column_name(s)"+"\n"+"FROM table_name AS alias_name;";
				}
				
				//SELECT column_name AS alias_name
				//FROM table_name;
				else if(selectBox.value =="AS COLUMN" ){
					queryBox.value="SELECT column_name AS alias_name"+"\n"+"FROM table_name;";
				}
				
				//SELECT column1, column2, ...
				//FROM table_name
				//WHERE columnN LIKE pattern;
				else if(selectBox.value =="LIKE" ){
					queryBox.value="SELECT column1, column2, ..."+"\n"+"FROM table_name"+"\n"+"WHERE columnN LIKE pattern;";
				}
				
				//SELECT column_name(s)
				//FROM table_name
				//WHERE column_name IN (value1, value2, ...);
				else if(selectBox.value =="IN" ){
					queryBox.value="SELECT column1, column2, ..."+"\n"+"FROM table_name"+"\n"+"WHERE column_name IN (value1, value2, ...);";
				}
				
				//SELECT column_name(s)
				//FROM table_name
				//WHERE column_name BETWEEN value1 AND value2;
				else if(selectBox.value =="BETWEEN AND" ){
					queryBox.value="SELECT column1, column2, ..."+"\n"+"FROM table_name"+"\n"+"WHERE column_name BETWEEN value1 AND value2;";
				}
				
				
				//SELECT column_name(s)
				//FROM table1
				//INNER JOIN table2
				//ON table1.column_name = table2.column_name;
				else if(selectBox.value =="INNER JOIN" ){
					queryBox.value="SELECT column_name(s)"+"\n"+"FROM table1"+"\n"+"INNER JOIN table2"+"\n"+"ON table1.column_name = table2.column_name;";
				}
				
				//SELECT column_name(s)
				//FROM table1
				//LEFT JOIN table2
				//ON table1.column_name = table2.column_name;
				else if(selectBox.value =="LEFT JOIN" ){
					queryBox.value="SELECT column_name(s)"+"\n"+"FROM table1"+"\n"+"LEFT JOIN table2"+"\n"+"ON table1.column_name = table2.column_name;";
				}
				
				//SELECT column_name(s)
				//FROM table1
				//RIGHT JOIN table2
				//ON table1.column_name = table2.column_name;
				else if(selectBox.value =="RIGHT JOIN" ){
					queryBox.value="SELECT column_name(s)"+"\n"+"FROM table1"+"\n"+"RIGHT JOIN table2"+"\n"+"ON table1.column_name = table2.column_name;";
				}
				
				//SELECT column_name(s)
				//FROM table1
				//FULL OUTER JOIN table2
				//ON table1.column_name = table2.column_name
				//WHERE condition;
				else if(selectBox.value =="FULL OUTER JOIN" ){
					queryBox.value="SELECT column_name(s)"+"\n"+"FROM table1"+"\n"+"FULL OUTER JOIN table2"+"\n"+"ON table1.column_name = table2.column_name"+"\n"+"WHERE condition;";
				}
				
				//SELECT column_name(s) FROM table1
				//UNION ALL
				//SELECT column_name(s) FROM table2;
				else if(selectBox.value =="UNION" ){
					queryBox.value="SELECT column_name(s) FROM table1"+"\n"+"UNION ALL"+"\n"+"SELECT column_name(s) FROM table2;";
				}
				
				//SELECT column_name(s)
				//FROM table_name
				//WHERE condition
				//GROUP BY column_name(s)
				//ORDER BY column_name(s);
				else if(selectBox.value =="GROUP BY" ){
					queryBox.value="SELECT column_name(s)"+"\n"+"FROM table_name"+"\n"+"GROUP BY column_name(s)"+"\n"+"ORDER BY column_name(s);";
				}
				
				//SELECT column_name(s)
				//FROM table_name
				//WHERE condition
				//GROUP BY column_name(s)
				//HAVING condition
				//ORDER BY column_name(s);
				else if(selectBox.value =="HAVING" ){
					queryBox.value="SELECT column_name(s)"+"\n"+"FROM table_name"+"\n"+"WHERE condition"+"\n"+"GROUP BY column_name(s)"+"\n"+" HAVING condition"+"\n"+"ORDER BY column_name(s);";
				}
				
				//SELECT column_name(s)
				//FROM table_name
				//WHERE EXISTS
				//(SELECT column_name FROM table_name WHERE condition);
				else if(selectBox.value =="EXISTS" ){
					queryBox.value="SELECT column_name(s)"+"\n"+"FROM table_name"+"\n"+"WHERE EXISTS"+"\n"+"(SELECT column_name FROM table_name WHERE condition);";
				}
				
				//SELECT column_name(s)
				//FROM table_name
				//WHERE column_name operator ANY
				//(SELECT column_name FROM table_name WHERE condition);
				else if(selectBox.value =="ANY" ){
					queryBox.value="SELECT column_name(s)"+"\n"+"FROM table_name"+"\n"+"WHERE column_name operator ANY"+"\n"+"(SELECT column_name FROM table_name WHERE condition);";
				}
				
				//SELECT column_name(s)
				//FROM table_name
				//WHERE column_name operator ALL
				//(SELECT column_name FROM table_name WHERE condition);
				else if(selectBox.value =="ALL" ){
					queryBox.value="SELECT column_name(s)"+"\n"+"FROM table_name"+"\n"+"WHERE column_name operator ALL"+"\n"+"(SELECT column_name FROM table_name WHERE condition);";
				}
				
				//SELECT column1, column2, column3, ...
				//INTO newtable [IN externaldb]
				//FROM oldtable
				//WHERE condition;
				else if(selectBox.value =="SELECT INTO" ){
					queryBox.value="SELECT column1, column2, column3, ..."+"\n"+"INTO newtable [IN externaldb]"+"\n"+"FROM oldtable"+"\n"+"WHERE condition;";
				}
				
				//INSERT INTO table2 (column1, column2, column3, ...)
				//SELECT column1, column2, column3, ...
				//FROM table1
				//WHERE condition;
				else if(selectBox.value =="INSERT INTO SELECT" ){
					queryBox.value="INSERT INTO table2 (column1, column2, column3, ...)"+"\n"+"SELECT column1, column2, column3, ..."+"\n"+"FROM table1"+"\n"+"WHERE condition;";
				}
				
				//CASE
					//WHEN condition1 THEN result1
					//WHEN condition2 THEN result2
					//WHEN conditionN THEN resultN
					//ELSE result
				//END;
				else if(selectBox.value =="CASE" ){
					queryBox.value="CASE"+"\n"+"SELECT column1, column2, column3, ..."+"\n"+"\t"+"WHEN condition1 THEN result1"+"\n"+"\t"+"WHEN condition2 THEN result2"+"\n"+"\t"+"ELSE result"+"\n"+"END;";
				}
				
				//CREATE PROCEDURE procedure_name
				//AS
				//sql_statement
				//GO;
				else if(selectBox.value =="CREATE PROCEDURE" ){
					queryBox.value="CREATE PROCEDURE procedure_name"+"\n"+"AS"+"\n"+"sql_statement"+"\n"+"GO;";
				}
				
				//EXEC procedure_name;
				else if(selectBox.value =="EXECUTE PROCEDURE" ){
					queryBox.value="EXEC procedure_name;";
				}
				
				//CREATE TABLE table_name (
				//column1 datatype,
				//column2 datatype,
				//....
				//);
				else if(selectBox.value =="CREATE TABLE" ){
					queryBox.value="CREATE TABLE table_name ("+"\n"+"column1 datatype,"+"\n"+"column2 datatype,"+"\n"+"...."+"\n"+");";
				}
				
				//CREATE TABLE table_name (
				//column1 datatype constraint,
				//column2 datatype constraint,
				//column3 datatype constraint,
				//....
				//);
				else if(selectBox.value =="CREATE TABLE WITH CONSTRAINTS" ){
					queryBox.value="CREATE TABLE table_name ("+"\n"+"column1 datatype constraint,"+"\n"+"column2 datatype constraint,"+"\n"+"...."+"\n"+");";
				}
				
				//DROP TABLE table_name;
				else if(selectBox.value=="DROP TABLE"){
					queryBox.value="DROP TABLE table_name;";
				}
				
				//ALTER TABLE table_name
				//ADD column_name datatype;
				else if(selectBox.value=="ALTER TABLE ADD"){
					queryBox.value="ALTER TABLE table_name"+"\n"+"ADD column_name datatype;";
				}
				
				//ALTER TABLE table_name
				//DROP COLUMN column_name
				else if(selectBox.value=="ALTER TABLE DROP"){
					queryBox.value="ALTER TABLE table_name"+"\n"+"DROP COLUMN column_name";
				}
				
				//CREATE DATABASE databasename;
				else if(selectBox.value=="CREATE DATABASE"){
					queryBox.value="CREATE DATABASE databasename;";
				}
				
				//CREATE DATABASE databasename;
				else if(selectBox.value=="CREATE DATABASE"){
					queryBox.value="CREATE DATABASE databasename;";
				}
				
				//DROP DATABASE databasename;
				else if(selectBox.value=="DROP DATABASE"){
					queryBox.value="DROP DATABASE databasename;";
				}
				
				//BACKUP DATABASE databasename
				//TO DISK = 'filepath';
				else if(selectBox.value=="BACKUP DATABASE"){
					queryBox.value="BACKUP DATABASE databasename"+"\n"+"TO DISK = filepath;";
				}
				
				//BACKUP DATABASE databasename
				//TO DISK = 'filepath'
				//WITH DIFFERENTIAL;
				else if(selectBox.value=="BACKUP DATABASE WITH DIFFERENTIAL"){
					queryBox.value="BACKUP DATABASE databasename"+"\n"+"TO DISK = filepath"+"\n"+"WITH DIFFERENTIAL;";
				}
			}
			
		</script>
	</body>
</html>