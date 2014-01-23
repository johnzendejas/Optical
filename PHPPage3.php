<?php

$con=mysqli_connect("localhost","root","super99","optical");
// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }

$result = mysqli_query($con,"SELECT * FROM orders");

echo "<table border='1'>
<tr>
<th>OrderNumber</th>
<th>Name</th>
<th>Address</th>
<th>City</th>
</tr>";

while($row = mysqli_fetch_array($result))
  {
  echo "<tr>";
  echo "<td>" . $row['OrderNumber'] . "</td>";
  echo "<td>" . $row['Name'] . "</td>";
  echo "<td>" . $row['Address1'] . "</td>";
  echo "<td>" . $row['City'] . "</td>";
  echo "</tr>";
  }
echo "</table>";

mysqli_close($con);
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
