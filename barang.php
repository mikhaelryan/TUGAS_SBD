<?php
include 'konek.php';

$IdBarang        = "";
$NamaBarang       = "";
$HargaBarang     = "";
$Size='';
$Stok='';

if (isset($_GET['op'])) {
  $op = $_GET['op'];
} else {
  $op = "";
}

if($op =='Edit'){
  $IdBarang = $_GET['IdBarang'];
  $sql2= "select * from barang where IdBarang = '$IdBarang'";
  $q1 = mysqli_query($con,$sql2);
  $r=mysqli_fetch_array($q1);
  $NamaBarang = $r['NamaBarang'];
  $HargaBarang = $r['HargaBarang'];
  $Size = $r['Size'];
  $Stok = $r['Stok'];
}

if($op == 'Delete'){
  $IdBarang = $_GET['IdBarang'];
  $sql1       = "delete from barang where idbarang = '$IdBarang'";
  $q2         = mysqli_query($con,$sql1);
  }

if(isset($_POST['submit'])){
    $IdBarang=$_POST['IdBarang'];
    $NamaBarang=$_POST['NamaBarang'];
    $HargaBarang=$_POST['HargaBarang'];
    $Size=$_POST['Size'];
    $Stok=$_POST['Stok'];
    if ($op=='Edit'){
      $sql3="update barang set IdBarang='$IdBarang', NamaBarang='$NamaBarang', HargaBarang='$HargaBarang', Size='$Size', Stok='$Stok' where IdBarang='$IdBarang'";
      $result2=mysqli_query($con,$sql3);
    }else{
      $sql="insert into barang (idbarang, namabarang, hargabarang, Size, Stok) values ('$IdBarang','$NamaBarang','$HargaBarang','$Size','$Stok')";
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
<button class='btn btn-primary my-5'><a href='display.php' class='text-light'> Menu </a> </button> <button class="btn btn-primary"><a href="barang.php" class="text-light">Add</a></button>
<form method="post">
            <div class="form-group">
                <label>IdBarang</label>
                <input type="text" class="form-control" 
                name="IdBarang" autocomplete='off' value="<?php echo $IdBarang ?>">
            </div>
            <div class="form-group">
                <label>NamaBarang</label>
                <input type="text" class="form-control" 
                name="NamaBarang" autocomplete='off' value="<?php echo $NamaBarang ?>">
            </div>
            <div class="form-group">
                <label>Harga</label>
                <input type="text" class="form-control" 
                name="HargaBarang" autocomplete='off' value="<?php echo $HargaBarang ?>">
            </div>
            <div class="form-group">  
                <label>Size</label>
                <select class='form-control' name='Size'>
                <?php
                  if($op == 'Edit'){
                    ?><option value='<?php echo $Size ?>'><?php echo $Size ?></option>;
                    <?php
                  }
                  else{
                    ?><option value=''>-- SELECT --</option>
                  <?php
                  }?>
                    <option value='s'> Small </option>
                    <option value='m'> Medium </option>
                    <option value='l'> Large </option>
              </select>
              <div class="form-group">
                <label>Stok</label>
                <input type="text" class="form-control" 
                name="Stok" autocomplete='off' value="<?php echo $Stok ?>">
            </div>     
            </div>    
            <button type="submit" class="btn btn-primary my-5" name="submit">Save</button>
</form>
<table class="table">
  <thead>
    <tr>
      <th scope="col">IdBarang</th>
      <th scope="col">Nama Barang</th>
      <th scope="col">Harga</th>
      <th scope="col">Size</th>
      <th scope="col">Stok</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
  
  <?php

$sql='select * from barang';
$result=mysqli_query($con,$sql);
if($result){
  while($row=mysqli_fetch_assoc($result)){
    $IdBarang=$row['IdBarang'];
    $NamaBarang=$row['NamaBarang'];
    $HargaBarang=$row['HargaBarang'];
    $Size=$row['Size'];
    $Stok=$row['Stok'];
    echo '<tr>
    <th scope="row">'.$IdBarang.'</th>
    <td>'.$NamaBarang.'</td>
    <td>'.$HargaBarang.'</td>
    <td>'.$Size.'</td>
    <td>'.$Stok.'</td>
    <td>
    <button class="btn btn-warning"><a href="barang.php?op=Edit&IdBarang='.$IdBarang.'" class="text-dark">Edit</a></button>
    <button class="btn btn-danger"><a href="barang.php?op=Delete&IdBarang='.$IdBarang.'" class="text-dark">Delete</a></button>
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