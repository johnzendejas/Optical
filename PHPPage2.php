<?php
        $con=mysqli_connect("localhost","root","super99","optical");
// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
$sql = "ALTER TABLE opticalrequest2 AUTO_INCREMENT = 5001;";
// Execute query
if (mysqli_query($con,$sql))
  {
  echo "Table orders created successfully";
  }
else
  {
  echo "Error creating table: " . mysqli_error($con);
  }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title></title>
    </head>
    <body>
        
    </body>
</html>
