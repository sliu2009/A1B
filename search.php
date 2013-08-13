<?php

function showerror() {
	die("Error " . mysql_errno() . " : " . mysql_error());
}

require_once('db.php');

// (1) Open the database connection
if(!$dbconn = mysql_connect(DB_HOST, DB_USER, DB_PW)) {
	echo 'Could not connect to mysql on ' . DB_HOST . '\n';
	exit;
}
echo 'Connected to mysql <br />';

// (2) select the winestore database
if(!mysql_select_db(DB_NAME, $dbconn)) {
	echo 'Could not use database ' . DB_NAME . '\n';
	showerror();
	exit;
}
echo 'Connected to database ' . DB_NAME . '\n';

// (3) Run the query on the winestore through the connection
$query_region = "SELECT region_name FROM winestore.region ORDER BY region_name";
if (!($result_region = @ mysql_query ($query_region, $dbconn))) {
	showerror();
	exit;
}

?>
<form action="answer.php" method="GET">
	<br>Enter a wine name : <input type="text" name="wineName" value=""> 
	<br>Enter a winery name : <input type="text" name="wineryName" value=""> 
	<br>Select a region : 
		<select name="region">
			<?php 
			// While there are still rows in the result set,
			// fetch the current row into $row
			while ($row = @ mysql_fetch_array($result_region)) {
				echo "<option value=".$row["region_name"].">".$row["region_name"]."</option>";
			}
			?>
		</select> 
	<br>Select a grape variety : 
		<select name="grapeVariety">
			<option value="volvo">Volvo</option>
			<option value="saab">Saab</option>
			<option value="opel">Opel</option>
			<option value="audi">Audi</option>
		</select>
	<br>Select a range of years : 
		between year
		<select name="fromYear">
			<option value="volvo">Volvo</option>
			<option value="saab">Saab</option>
			<option value="opel">Opel</option>
			<option value="audi">Audi</option>
		</select>  
		and year
		<select name="toYear">
			<option value="volvo">Volvo</option>
			<option value="saab">Saab</option>
			<option value="opel">Opel</option>
			<option value="audi">Audi</option>
		</select>
	<br>Enter a minimum number of wines in stock, per wine : <input type="text" name="minStock" value=""> 
	<br>Enter a minimum number of wines ordered, per wine : <input type="text" name="minOrdered" value=""> 
	<br>Enter a dollar cost range : 
		minimum cost <input type="text" name="minCost" value=""> 
		maximum cost <input type="text" name="maxCost" value=""> 
	<br> <input type="submit" value="Search">
</form>
