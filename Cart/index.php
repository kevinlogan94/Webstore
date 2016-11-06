<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" type="text/css" href="../style.css">
    <script src="//code.jquery.com/jquery-1.10.2.js"></script> 
    <script> 
    $(function(){
      $("#header").load("../header.php");
      $("#footer").load("../footer.php"); 
    });
    </script> 
    <title>CS405 Project</title>
  </head>
  <body>
     <div id="header"></div>
     <h1>Cart</h1>
     <table>
     <thead>
       <th>Product</th>
       <th>Class</th>
       <th>Amount</th>
     </thead>
     <tbody>
     <?php
        include '../databaselogin.php';

        // Create connection
        $conn = new mysqli($servername, $username, $password, $db);

        // Check connection
        if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
        }

        $sql = "select * from order where OrderID='" . $_COOKIE[$cookie_name] . "';";
	echo $sql;
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
        // output data of each row
         while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["Product"] . "</td>";
                echo "<td>" . $row["Class"] . "</td>";
		echo "<td>" . $row["Amount"] . "</td>";
                echo "</tr>";
        }
        } else {
           echo "<br>Your Cart is empty<br>";
        }

        $conn->close();
     ?>
     </tbody>
     </table>
     <form action="/CS405/Cart/checkout.php">
      <input type="submit" value="Checkout" />
     </form>
     


     <p>Available accounts to sign into:</p>
     <table>
     <thead>
       <th>Username</th>
       <th>Password</th>
     </thead>
     <tbody>
     <?php
        include '../databaselogin.php';

        // Create connection
        $conn = new mysqli($servername, $username, $password, $db);

        // Check connection
        if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
        }

        $sql = "select * from user;";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
        // output data of each row
         while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["Username"] . "</td>";
                echo "<td>" . $row["Password"] . "</td>";
                echo "</tr>";
        }
        } else {
           echo "0 results";
	}

        $conn->close();
     ?>
     </tbody>
     </table>
     <div id="footer"></div>
  </body>
</html>



