<?php
include 'konek.php';
?>
<!doctype html>
<html lang="en">
<div class="container-fluid">
  <head>

  <title>Invoice</title>
		<style type="text/css">
		body {		
			font-family: Verdana;
		}
		
		div.invoice {
		padding:10px;
		height:740pt;
		width:1200pt;
		}

    div.company {
			float:left;
		}

    div.cust{
      border:2px solid #ccc;
      float:right;
      width:200pt;
    }
		
		div.customer-address {
			margin-left:900px;
			width:300pt;
		}
		
		div.clear-fix {
			clear:both;
			float:none;
		}
				
		th {
			text-align: left;
		}
		
		td {
		}
		
		.text-left {
			text-align:left;
		}
		
		.text-center {
			text-align:center;
		}
		
		.text-right {
			text-align:right;
		}
		
		</style>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <div class='invoice'>
      <div class='company'>
        <h1><img id="image" src="KEBAYA.jpg" alt="logo" />       
        </h1>
        </br>
        <?php
        $IdNota = $_GET['IdNota'];
        echo '<b>Nota No. '.$IdNota.'</b>'
        ?>
        
      </div>
      <div class='cust my-4'>
        <?php
        $IdNota = $_GET['IdNota'];
        $sql4="select TglSewa,TglKembali, customer.NamaCustomer, customer.telp from nota inner join customer On customer.IdCustomer=nota.IdCustomer where idnota='$IdNota'";
        $result4=mysqli_query($con,$sql4);
        $row4=mysqli_fetch_assoc($result4);
        $TglSewa=$row4['TglSewa'];
        $TglKembali=$row4['TglKembali'];
        $NamaCustomer=$row4['NamaCustomer'];
        $telp=$row4['telp'];
        echo 'Nama: '.$NamaCustomer.'</br>NoTelp: '.$telp.'</br>Tgl Sewa: '.$TglSewa.'</br> Tgl Kembali: '.$TglKembali


        ?>
        </div>
      <div class='customer-address'>
        <div class='text-right'>
          <b>
  </br>
        Ruko Yap Square No.2, Jl. C. Simanjuntak
  </br>
        +628 211 6611 886
  </br>
        Line: linneva
  </br>
        thekebaya.id@gmail.com</b>
  </div>
      
  </div>
  </head>
  <body>
  <table class="table my-5" style="width: 81rem;">
  <thead>
    <tr>
       
      <th scope="col">Barang</th>
      <th scope="col">Jumlah</th>
      <th scope="col">Harga</th>
    </tr>
  </thead>
  <tbody>
  <?php
    $IdNota = $_GET['IdNota'];
    $sql="select detailnota.qty as Qty, NamaBarang, qty*barang.hargabarang as Harga, barang.Size from barang inner join detailnota on detailnota.IdBarang=barang.IdBarang where IdNota='$IdNota'";
    $result=mysqli_query($con,$sql);
    if($result){
    while($row=mysqli_fetch_assoc($result)){
        $NamaBarang=$row['NamaBarang'];
        $Size=$row['Size'];
        $Qty=$row['Qty'];
        $Harga=$row['Harga'];
        echo '<tr>
        <th scope="row">'.$NamaBarang.' '.$Size.'</th>
        <td>'.$Qty.'</td>
        <td>Rp. '.$Harga.'</td>
    </tr>';
    }
}
?>

<?php
$sql2="select SUM(qty*barang.hargabarang) as Total from barang inner join detailnota on detailnota.IdBarang=barang.IdBarang where IdNota='$IdNota'";
    $result2=mysqli_query($con,$sql2);
    $row2=mysqli_fetch_assoc($result2);
    $Total=$row2['Total'];
    echo "<tr>
    <th scope='row'></th>
    <td><b>Pembayaran</b></td>
    <td><b>Rp. $Total</b></td>
  </tr>";
?>
  </tbody>
</table>
</div>


</body>
</html>