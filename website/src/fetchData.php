<?php 

  include("dbconnect.php");

  // Fetch the data

  $row = array();
  $query = array();
  $result = array();
  // Ordered by ascending data (start from earliest date)
  $query = "SELECT event, windspeed, temperature, rpm FROM sensor_data";
  $result = mysql_query( $query );


  // Print out rows of tables, produce JSON output

  header('Content-Type: application/json');
  
  $prefix = '';
  echo "[\n";
  while ( $row = mysql_fetch_assoc( $result ) ) {
    echo $prefix . " {\n";
    echo '  "event": "' . $row['event'] . '",' . "\n";
    echo '  "windspeed": ' . $row['windspeed'] . ',' . "\n";
    echo '  "temperature": ' . $row['temperature'] . ',' . "\n";
    echo '  "rpm": ' . $row['rpm'] . '' . "\n";
    echo " }";
    $prefix = ",\n";
  }
  echo "\n]";

  mysql_close($dbh);
  
?>
