<?php
$con=mysqli_connect("localhost","root","super99","optical");
// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }

$sql="INSERT INTO orders (Name, Address1, City)
VALUES
('$_POST[Name]','$_POST[Address1]','$_POST[City]')";

if (!mysqli_query($con,$sql))
  {
  die('Error: ' . mysqli_error($con));
  }
echo "1 record added";

mysqli_close($con);
?>