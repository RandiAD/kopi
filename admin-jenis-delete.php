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

if ((isset($_GET['jeniskopi'])) && ($_GET['jeniskopi'] != "") && (isset($_GET['Confirm']))) {
  $deleteSQL = sprintf("DELETE FROM jenis WHERE jeniskopi=%s",
                       GetSQLValueString($_GET['jeniskopi'], "text"));

  mysql_select_db($database_koneksi_kopi, $koneksi_kopi);
  $Result1 = mysql_query($deleteSQL, $koneksi_kopi) or die(mysql_error());

  $deleteGoTo = "admin-jenis.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $deleteGoTo));
}

$colname_Recordset_jenis = "-1";
if (isset($_GET['jeniskopi'])) {
  $colname_Recordset_jenis = $_GET['jeniskopi'];
}
mysql_select_db($database_koneksi_kopi, $koneksi_kopi);
$query_Recordset_jenis = sprintf("SELECT * FROM jenis WHERE jeniskopi = %s", GetSQLValueString($colname_Recordset_jenis, "text"));
$Recordset_jenis = mysql_query($query_Recordset_jenis, $koneksi_kopi) or die(mysql_error());
$row_Recordset_jenis = mysql_fetch_assoc($Recordset_jenis);
$totalRows_Recordset_jenis = mysql_num_rows($Recordset_jenis);
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
        	<a href="admin.php">Beranda</a>
       	  	<a href="admin-pesanan.php">Pesanan</a>
        	<a href="admin-kopi.php">Data Kopi</a>
          	<a href="admin-jenis.php">Jenis Kopi</a>
			<a href="admin-buat.php">Buat Kopi</a>
            <a href="logout.php">Logout</a>
    	</div>
    </div>
    <div id="content">
   	  <h1 id="judul_logo">Data Kopi</h1>
      <div class="container">
      	<h2>Delete Data Kopi</h2>
        <form action="" method="post">
        	<table width="80%" border="0" cellpadding="5" cellspacing="0" class="standar_tabel">
              <tr>
                <th scope="row">Jenis Kopi</th>
                <td><?php echo $row_Recordset_jenis['jeniskopi']; ?></td>
              </tr>
              <tr>
                <th scope="row">Nama Kopi</th>
                <td><?php echo $row_Recordset_jenis['namakopi']; ?></td>
              </tr>
            </table>
        </form><br />
        <p>Ingin Hapus Data Ini?</p><br />
        <p>
        <a href="admin-jenis-delete.php?jeniskopi=<?php echo $row_Recordset_jenis['jeniskopi']; ?>&amp;Confirm=Yes" class="btn_th">Hapus</a> - <a href="admin-jenis.php" class="btn_th">Tidak</a> 
        </p>
      </div>
    <div id="footer"></div>
    
</body>
</html>
<?php
mysql_free_result($Recordset_jenis);
?>
