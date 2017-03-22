<?php
	// Connect to MySQL
    include("dbconnect.php");

    // Prepare the SQL statement
    $SQL = "INSERT INTO windeng.sensor_data (windspeed, temperature, rpm) 
    	    VALUES ('".$_GET["windspeed"]."','".$_GET["temperature"]."','".$_GET["rpm"]."')";   

    echo $SQL;
    
    // Execute SQL statement
    mysql_query($SQL);
    

    mysql_close($dbh);
    // Go to the review_data.php (optional)
    // header("Location: review_data.php");

?>
