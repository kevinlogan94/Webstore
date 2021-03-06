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
    <title>Order History</title>
  </head>
  <body>
     <div id="header"></div>
     <h1>Your Order History</h1>
     <table>
     <thead>
       <th>OrderID</th>
       <th>OrderStatus</th>
       <th>Purchased(Amount)</th>
       <th>OrderTotal</th>
       <th>Created</th>
       <th>Ship Date</th>
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

	$productSql = "select product.ProductName, orders.OrderID, o.Amount 
                       from product, orderContainProduct as o, userOrder, orders
                       where OrderStatus<>'UnCheckout'
                       and orders.OrderID=o.OrderID
		       and orders.OrderID=userOrder.OrderID
                       and product.ProductID=o.ProductID
		       and UserID=" . $_COOKIE['login'] . "
                       order by orders.OrderID;";

        $productResult = $conn->query($productSql);
        $prodData = $productResult->fetch_assoc();
	
        $sql = "select * from userOrder, orders 
		where userOrder.OrderID=orders.OrderID
		and OrderStatus <> 'UnCheckout' 
		and UserID=" . $_COOKIE['login'] . ";";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
        // output data of each row
         while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["OrderID"] . "</td>";
                echo "<td>" . $row["OrderStatus"] . "</td>";
		echo "<td>";
                while($prodData["OrderID"] == $row["OrderID"]){
                        echo $prodData["ProductName"] . " (" . $prodData["Amount"] . ") <br>";
                        $prodData = $productResult->fetch_assoc();
                }
                echo "</td>";
		echo "<td>" . $row["OrderTotal"] . "</td>";
                echo "<td>" . $row["OrderDate"] . "</td>";
		echo "<td>" . $row["ShipDate"] . "</td>";
                echo "</tr>";
        }
        } else {
           echo "You don't have any Orders";
        }

        $conn->close();
     ?>
     </tbody>
     </table>
     <div id="footer"></div>
  </body>
</html>




