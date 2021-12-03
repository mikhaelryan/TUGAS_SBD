<?php
include 'konek.php';

$NamaCustomer      = "";
$Alamat     = "";
$Telp ="";


if(isset($_GET['op'])){
  $op=$_GET['op'];
}else{
  $op='';
}

if($op =='Edit'){
  $IdCustomer = $_GET['IdCustomer'];
  $sql2= "select * from customer where IdCustomer = '$IdCustomer'";
  $q1 = mysqli_query($con,$sql2);
  $r=mysqli_fetch_array($q1);
  $NamaCustomer = $r['NamaCustomer'];
  $Alamat = $r['Alamat'];
  $Telp = $r['telp'];
}

if($op == 'Delete'){
  $IdCustomer = $_GET['IdCustomer'];
  $sql1       = "delete from customer where idcustomer = '$IdCustomer'";
  $q2         = mysqli_query($con,$sql1);
  }

if(isset($_POST['submit'])){
    $NamaCustomer=$_POST['NamaCustomer'];
    $Alamat=$_POST['Alamat'];
    $Telp=$_POST['Telp'];
    if ($op=='Edit'){
      $sql3="update customer set NamaCustomer='$NamaCustomer', Alamat='$Alamat', Telp='$Telp' where IdCustomer='$IdCustomer'";
      $result2=mysqli_query($con,$sql3);
    }else{
      $sql="insert into customer (namacustomer, alamat, telp) values ('$NamaCustomer','$Alamat','$Telp')";
      $result=mysqli_query($con,$sql);
    }
    
}
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>
    
<div class='container'>
<button class='btn btn-primary my-5'><a href='display.php' class='text-light'> Menu </a> </button> <button class="btn btn-primary"><a href="customer.php" class="text-light">Add</a></button>
<form method="post">
            <div class="form-group">
                <label>NamaCustomer</label>
                <input type="text" class="form-control" 
                name="NamaCustomer" autocomplete='off' value="<?php echo $NamaCustomer ?>">
            </div>
            <div class="form-group">
                <label>Alamat</label>
                <input type="text" class="form-control" 
                name="Alamat" autocomplete='off' value="<?php echo $Alamat ?>">
            </div>
            <div class="form-group">
                <label>Telp</label>
                <input type="text" class="form-control" 
                name="Telp" autocomplete='off' value="<?php echo $Telp ?>">
            </div>
            <button type="submit" class="btn btn-primary my-5" name="submit">Save</button>
</form>
<table class="table">
  <thead>
    <tr>
      <th scope="col">IdCustomer</th>
      <th scope="col">Nama Customer</th>
      <th scope="col">Alamat</th>
      <th scope="col">Telp</th>
      <th scope="col">Action</th>

          
    </tr>
  </thead>
  <tbody>
  
  <?php

$sql='select * from customer';
$result=mysqli_query($con,$sql);
if($result){
  while($row=mysqli_fetch_assoc($result)){
    $IdCustomer=$row['IdCustomer'];
    $NamaCustomer=$row['NamaCustomer'];
    $Alamat=$row['Alamat'];
    $Telp=$row['telp'];
    echo '<tr>
    <th scope="row">'.$IdCustomer.'</th>
    <td>'.$NamaCustomer.'</td>
    <td>'.$Alamat.'</td>
    <td>'.$Telp.'</td>
    <td>
    <button class="btn btn-warning"><a href="customer.php?op=Edit&IdCustomer='.$IdCustomer.'" class="text-dark">Edit</a></button>
    <button class="btn btn-danger"><a href="customer.php?op=Delete&IdCustomer='.$IdCustomer.'" class="text-dark">Delete</a></button>
    </td>
  </tr>';
  }  
}
?>
  </tbody>
</table>
  </tbody>
</table>
</body>
</html>