<?php
include 'konek.php';

$IdNota        = "";
$IdBarang ='';
$IdCustomer     ='';
$TglSewa       = "";
$TglKembali     = "";
$TipePembayaran   = "";
$Jumlah='';


if(isset($_GET['op'])){
  $op=$_GET['op'];
}else{
  $op='';
}

if($op =='Edit'){
  $IdNota = $_GET['IdNota'];
  $TipePembayaran = $_GET['TipePembayaran'];
  $Qty=$_GET['Jumlah'];
  $sql2= "select * from nota where IdNota = '$IdNota'";
  $q1 = mysqli_query($con,$sql2);
  $r=mysqli_fetch_array($q1);
  $IdCustomer=$r['IdCustomer'];
  $TglSewa = $r['TglSewa'];
  $TglKembali = $r['TglKembali'];
  $IdNota = $_GET['IdNota'];
  $IdBarang = $_GET['IdBarang'];
  $sql3= "select * from detailnota where IdNota = '$IdNota' and IdBarang='$IdBarang'";
  $q3 = mysqli_query($con,$sql3);
  $r=mysqli_fetch_array($q3);
  $Jumlah = $r['Qty'];
  $IdCustomer = $_GET['IdCustomer'];
  $sql4= "select * from customer where IdCustomer = '$IdCustomer'";
  $q4 = mysqli_query($con,$sql4);
  $r=mysqli_fetch_array($q4);
  $NamaCustomer = $r['NamaCustomer'];
  $Alamat = $r['Alamat'];
  $Telp = $r['telp'];
}

if($op == 'Delete'){
  $IdNota = $_GET['IdNota'];
  $IdBarang = $_GET["IdBarang"];
  $Qty=$_GET['Jumlah'];
  $sql5       ="delete from detailnota where IdNota = '$IdNota' and IdBarang='$IdBarang'";
  $upd3       = mysqli_query($con,"update barang set stok=stok+$Qty where IdBarang='$IdBarang'");
  $q3         = mysqli_query($con,$sql5);
  $ins=mysqli_query($con,"select count(idnota) as count from detailnota where idnota='$IdNota'");
  $row2=mysqli_fetch_array($ins);
  $count=$row2['count'];
  if ($count==0) {
    $query = mysqli_query($con,"delete from nota where idnota='$IdNota'");
  }else{}
  ?><a href=<?php echo "transaksi.php"?>></a>;<?php
  }
  
if(isset($_POST['submit'])){
  $Idnota=$_POST['IdNota'];
  $IdCustomer=$_POST['IdCustomer'];
  $IdBarang=$_POST['IdBarang'];
  $TglSewa=$_POST['TglSewa'];
  $TglKembali=$_POST['TglKembali'];
  $TipePembayaran=$_POST['TipePembayaran'];
  $Jumlah=$_POST['Jumlah'];
  if ($op=='Edit'){
    $sqlstok=mysqli_query($con,"Select Stok-$Jumlah as Stok from barang where Idbarang='$IdBarang'");
    $rows=mysqli_fetch_array($sqlstok);
    $stock=$rows['Stok'];
    if($stock>=0){
      $sql3="update nota set IdCustomer='$IdCustomer',TglSewa='$TglSewa', TglKembali='$TglKembali',TipePembayaran='$TipePembayaran' where IdNota='$IdNota'";
      $sql4="update detailnota set qty='$Jumlah' where IdNota='$IdNota' and IdBarang='$IdBarang'";
      $upd2=mysqli_query($con,"update barang set stok=stok+$Qty-$Jumlah where IdBarang='$IdBarang'");
      $result2=mysqli_query($con,$sql3);
      $result3=mysqli_query($con,$sql4);}
  }elseif ($op=="Delete") {
  }else{
    $sqlstok=mysqli_query($con,"Select Stok-$Jumlah as Stok from barang where Idbarang='$IdBarang'");
    $rows=mysqli_fetch_array($sqlstok);
    $stock=$rows['Stok'];
    $sqls=mysqli_query($con,"Select COUNT(*) as tot from detailnota where idnota='$Idnota' and idbarang='$IdBarang'");
    $rows2=mysqli_fetch_array($sqls);
    $tot=$rows2['tot'];
    if($stock>=0 and $tot==0) {
        mysqli_query($con,"begin transaction");
        $sql=mysqli_query($con,"insert into nota (idnota, IdCustomer, tglsewa, tglkembali, tipepembayaran) values ('$Idnota','$IdCustomer', '$TglSewa','$TglKembali','$TipePembayaran')");
        $sql2=mysqli_query($con,"Insert into detailnota (IdNota,idbarang,Qty) values('$Idnota','$IdBarang','$Jumlah')");
        $upd=mysqli_query($con,"update barang set Stok=Stok-$Jumlah where idbarang='$IdBarang'");
        mysqli_query($con,"COMMIT;");
  }
    else{
    }
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
<button class='btn btn-primary my-5'><a href='display.php' class='text-light'> Menu </a> </button> <button class="btn btn-primary"><a href="transaksi.php" class="text-light">Add</a></button>
<form method="post">
            <div class="form-group">
                <label>IdNota</label>
                <input type="text" class="form-control" 
                name="IdNota" autocomplete='off' value="<?php echo $IdNota ?>">
            </div>
            <div class="form-group">
                <label>IdCustomer</label>
                <select class="form-control" name="IdCustomer">
                  <?php
                  if($op == 'Edit'){
                    $res=mysqli_query($con,"Select IdCustomer from customer where idcustomer='$IdCustomer'");
                  }
                  else{
                    $res=mysqli_query($con,"Select IdCustomer from customer");
                    ?><option value=''>-- SELECT --</option>
                  <?php
                  }
                   while ($row=mysqli_fetch_array($res)) {
                  ?>
                  <option value=<?php echo $row['IdCustomer'];?>><?php echo $row['IdCustomer'];?></option>
                  <?php
                  }
                  ?>
                </select>
            </div>
            <div class="form-group">
                <label>IdBarang</label>
                <select class="form-control" name="IdBarang" >
                  <?php
                  if($op == 'Edit'){
                    $res2=mysqli_query($con,"Select IdBarang from barang");
                    ?><option value='<?php echo $IdBarang?>'><?php echo $IdBarang ?></option>
                  <?php
                  }
                  else{
                    $res2=mysqli_query($con,"Select IdBarang from barang");
                    ?><option value=''>-- SELECT --</option>
                  <?php
                  }
                   while ($row=mysqli_fetch_array($res2)) {
                  ?>
                  <option value=<?php echo $row['IdBarang'];?>><?php echo $row['IdBarang'];?></option>
                  <?php
                      }
                  ?>
                </select>
            </div>
            <div class="form-group">
                <label>Jumlah</label>
                <input type="text" name="Jumlah" class="form-control" 
                 value="<?php echo $Jumlah ?>">
            </div>
            <div class="form-group">
                <label>TglSewa</label>
                <input type="date" class="form-control" 
                name="TglSewa" value="<?php echo $TglSewa ?>">
            </div>
            <div class="form-group">
                <label>TglKembali</label>
                <input type="date" class="form-control" 
                name="TglKembali" value="<?php echo $TglKembali ?>">
            </div>
            <div class="form-group">
                <label>TipePembayaran</label>
                <select class='form-control' name='TipePembayaran'>
                <?php
                  if($op == 'Edit'){
                    ?><option value=<?php echo $TipePembayaran ?>><?php echo $TipePembayaran ?></option>;
                    <?php
                  }
                  else{
                    ?><option value=''>-- SELECT --</option>
                  <?php
                  }?>
                    <option value='Cash'> Cash </option>
                    <option value='Credit'> Credit </option>
                    <option value='Debit'> Debit </option>
                    <option value='Transfer'> Transfer </option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary my-5" name="submit">Save</button>
</form>
<table class="table">
  <thead>
    <tr>
      <th scope="col">IdNota</th>
      <th scope="col">IdCustomer</th>
      <th scope="col">IdBarang</th>
      <th scope="col">Jumlah</th>
      <th scope="col">Size</th>
      <th scope="col">TglSewa</th>
      <th scope="col">TglKembali</th>
      <th scope="col">TipePembayaran</th>
      <th scope="col">Harga</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
  
  <?php

$sql='select nota.IdNota, barang.IdBarang, customer.IdCustomer,detailnota.qty, barang.Size, nota.TglSewa, nota.TglKembali, nota.TipePembayaran, detailnota.qty*barang.hargabarang as Harga from nota
inner join detailnota on detailnota.IdNota=nota.IdNota
inner join barang on barang.IdBarang=detailnota.IdBarang
inner join customer on customer.IdCustomer=nota.idcustomer
order by nota.IdNota';
$result=mysqli_query($con,$sql);
if($result){
  while($row=mysqli_fetch_assoc($result)){
    $IdNota=$row['IdNota'];
    $IdCustomer=$row['IdCustomer'];
    $IdBarang=$row['IdBarang'];
    $Jumlah=$row['qty'];
    $Size=$row['Size'];
    $TglSewa=$row['TglSewa'];
    $TglKembali=$row['TglKembali'];
    $TipePembayaran=$row['TipePembayaran'];
    $Harga=$row['Harga'];
    echo '<tr>
    <th scope="row">'.$IdNota.'</th>
    <td>'.$IdCustomer.'</td>
    <td>'.$IdBarang.'</td>
    <td>'.$Jumlah.'</td>
    <td>'.$Size.'</td>
    <td>'.$TglSewa.'</td>
    <td>'.$TglKembali.'</td>
    <td>'.$TipePembayaran.'</td>
    <td>'.$Harga.'</td>
    <td>
    <button class="btn btn-warning"><a href="transaksi.php?op=Edit&IdNota='.$IdNota.'&IdBarang='.$IdBarang.'&IdCustomer='.$IdCustomer.'&TipePembayaran='.$TipePembayaran.'&Jumlah='.$Jumlah.'" class="text-dark" class="text-dark">Edit</a></button>
    <button class="btn btn-danger"><a href="transaksi.php?op=Delete&IdNota='.$IdNota.'&IdBarang='.$IdBarang.'&Jumlah='.$Jumlah.'" class="text-light">Delete</a></button>
    <button class="btn btn-primary"><a href="invoice.php?IdNota='.$IdNota.'" class="text-light">Invoice</a></button>
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