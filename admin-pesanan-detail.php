<?php require_once('Connections/koneksi_kopi.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

mysql_select_db($database_koneksi_kopi, $koneksi_kopi);
$query_Recordset_pemesanan = "SELECT * FROM pemesanan";
$Recordset_pemesanan = mysql_query($query_Recordset_pemesanan, $koneksi_kopi) or die(mysql_error());
$row_Recordset_pemesanan = mysql_fetch_assoc($Recordset_pemesanan);
$totalRows_Recordset_pemesanan = mysql_num_rows($Recordset_pemesanan);

mysql_select_db($database_koneksi_kopi, $koneksi_kopi);
$query_Recordset_tambah = "SELECT harga FROM tambah";
$Recordset_tambah = mysql_query($query_Recordset_tambah, $koneksi_kopi) or die(mysql_error());
$row_Recordset_tambah = mysql_fetch_assoc($Recordset_tambah);
$totalRows_Recordset_tambah = mysql_num_rows($Recordset_tambah);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Warung Kopi</title>
<link href="style.css" rel="stylesheet" type="text/css" />
</head>
<body>
	<div id='header'>
        <h1 id="judul_logo"> Warung Kopi </h1>
    </div>
    <div id="menubar">
    	<div id="menubar_left">
        	<?php echo date("l d-m-y"); ?>
		</div>
        <div id="menubar_right">
       		<a href="admin-pesanan.php">Pesanan</a>
        	<a href="admin-kopi.php">Data Kopi</a>
          	<a href="admin-jenis.php">Jenis Kopi</a>
			<a href="admin-buat.php">Buat Kopi</a>
            <a href="logout.php">Logout</a>
    	</div>
    </div>
    <div id="content">
   	  <h1 id="judul_logo">Data Pesanan</h1>
      <div class="container">
      	<h2>Detail Pemesanan</h2>
        <form action="" method="post">
        	<table width="80%" border="0" cellpadding="5" cellspacing="0" class="standar_tabel">
              <tr>
                <th scope="row">Nomor Pemesanan</th>
                <td><?php echo $row_Recordset_pemesanan['nomorpemesanan']; ?></td>
              </tr>
              <tr>
                <th scope="row">Meja</th>
                <td><?php echo $row_Recordset_pemesanan['meja']; ?></td>
              </tr>
              <tr>
                <th scope="row">Nama Pembeli</th>
                <td><?php echo $row_Recordset_pemesanan['namapembeli']; ?></td>
              </tr>
              <tr>
                <th scope="row">Kode Menu</th>
                <td><?php echo $row_Recordset_pemesanan['kodemenu']; ?></td>
              </tr>
              <tr>
                <th scope="row">Nama Menu</th>
                <td><?php echo $row_Recordset_pemesanan['namamenu']; ?></td>
              </tr>
              <tr>
                <th scope="row">Jumlah</th>
                <td><?php echo $row_Recordset_pemesanan['jumlah']; ?></td>
              </tr>
              <tr>
                <th scope="row">Total Harga</th>
                <td><?php echo $row_Recordset_pemesanan['totalharga']*$row_Recordset_tambah['harga']; ?></td>
              </tr>
              <tr>
                <th scope="row">&nbsp;</th>
                <td><input name="cetak" type="submit" class="btn" id="cetak" value="Cetak" /></td>
              </tr>
            </table>

        </form>
      </div>
    <div id="footer"></div>
    
</body>
</html>
<?php
mysql_free_result($Recordset_pemesanan);

mysql_free_result($Recordset_tambah);
?>
