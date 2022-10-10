<?php
session_start();
date_default_timezone_set('Asia/Bangkok');
$date = date("d-m-Y");
$time = date("H:i:s");
$fname= $_POST["fname"];
$lname= $_POST["lname"];
$address= $_POST["address"];
$mobile= $_POST["mobile"];
$servername="localhost";
$username="root";
$password="Anz31135!";
$dbname="shop";
$con=mysqli_connect($servername,$username,$password,$dbname);
if(!$con) die("Connnect mysql database fail!!".mysqli_connect_error());
//echo "Connect mysql successfully!";
$sql="INSERT INTO order_product (fname, lname,address,mobile)";
$sql.="VALUES ('$fname', '$lname', '$address','$mobile');";
//echo $sql;
if (mysqli_query($con, $sql)) {
    $last_id = mysqli_insert_id($con);
    //echo "New record created successfully. Last inserted ID is: " . $last_id;
    // loop in session cart and insert each item to database
    $sql1="INSERT INTO order_details (order_id,product_id) VALUES ";
    for($i=0;$i<count($_SESSION["cart"]);$i++){
        $item_id=$_SESSION["cart"][$i]['id'];
        $sql1.="('$last_id','$item_id')";
        if($i<count($_SESSION["cart"])-1)
         $sql1.=",";
        else
         $sql.=";";
    }
    //echo $sql1;
    if(mysqli_query($con,$sql1)){
      echo "<h1>บันทึกข้อมูลการสั่งซื้อเรียบร้อยแล้ว</h1>";
      if(isset($_SESSION["cart"])){
        echo "<h2>รายการสินค้า</h2>";
        $total=0;
        echo "<table border=1 borderColor ='#04d9ff'><tr><th>ลำดับ</th><th>id</th><th>name</th><th>description</th><th>price</th></tr>";
            for($i=0;$i<count($_SESSION["cart"]);$i++)
            {
                $item=$_SESSION["cart"][$i];
                echo "<tr><td>".($i+1)."</td>";
                echo "<td>".$item['id']."</td>";
                echo "<td>".$item['name']."</td>";
                echo "<td>".$item['description']."</td>";
                echo "<td>".$item['price']."</td>";
                
                $total+=$item['price'];
            }
        echo "</table>";
        echo "<h2>ราคาสินค้า $total บาท</h2>";}
      echo "คุณ ".$fname." ".$lname."<br>";
      echo "ที่อยู่ ".$address."<br>";
      echo "เบอร์โทรศัพท์ ".$mobile."<br>";
      echo "สั่งซื้อวันที่ ".$date." เวลา ".$time;
      
    } 
    else "เกิดข้อผิดพลาดในการสั่งซื้อ";
  } else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
  }
  
  mysqli_close($conn);
//$result=mysqli_query($con,$sql);
//$numrow=mysqli_num_rows($result);
?>