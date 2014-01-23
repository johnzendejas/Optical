<?php
    $con=mysqli_connect("localhost","root","super99","optical");
// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
$sql = "CREATE TABLE orders 
(
OrderNumber INT NOT NULL AUTO_INCREMENT, 
PRIMARY KEY(OrderNumber),
Id INT,
Name VARCHAR(50),
CompanyName VARCHAR(50),
Address1 VARCHAR(50),
Address2 VARCHAR(50),
City VARCHAR(50),
State VARCHAR(2),
Zip INT,
Phone VARCHAR(50),
Notes VARCHAR(50),
CustomerId VARCHAR(50),
OrderDate DATETIME
)";

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
