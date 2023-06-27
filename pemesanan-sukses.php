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

$colname_Recordset_pemesanan = "-1";
if (isset($_GET['nomorpemesanan'])) {
  $colname_Recordset_pemesanan = $_GET['nomorpemesanan'];
}
mysql_select_db($database_koneksi_kopi, $koneksi_kopi);
$query_Recordset_pemesanan = sprintf("SELECT * FROM pemesanan WHERE nomorpemesanan = %s", GetSQLValueString($colname_Recordset_pemesanan, "int"));
$Recordset_pemesanan = mysql_query($query_Recordset_pemesanan, $koneksi_kopi) or die(mysql_error());
$row_Recordset_pemesanan = mysql_fetch_assoc($Recordset_pemesanan);
$totalRows_Recordset_pemesanan = mysql_num_rows($Recordset_pemesanan);
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
        	<a href="index.php">Beranda</a>
       		<a href="pemesanan.php">Pemesanan</a>
        	<a href="#">Tentang Kami</a>
            <a href="login.php">Login</a>
    	</div>
    </div>
    <div id="content">
   	  <h1 id="judul_logo">Pesananmu Dikonfirmasi</h1>
      <div class="container">
        <h2>Pesananmu akan segera diproses.</h2>
        <h2>Sembari menunggu, kamu bisa melakukan apapun di sini.</h2>
        <h2>Asal jangan curi hatiku XD</h2>
        <h2>Salam Seruput</h2><br />
        <p>
        	<a href="pemesanan.php" class="btn_th">Kembali ke pemesanan</a> 
            - 
            <a href="index.php" class="btn_th">Kembali ke utama</a> 
        </p>
</div>
    
</body>
</html>
<?php
mysql_free_result($Recordset_pemesanan);
?>
