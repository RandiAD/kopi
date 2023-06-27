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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form")) {
  $updateSQL = sprintf("UPDATE jenis SET namakopi=%s WHERE jeniskopi=%s",
                       GetSQLValueString($_POST['namakopi'], "text"),
                       GetSQLValueString($_POST['jeniskopi'], "text"));

  mysql_select_db($database_koneksi_kopi, $koneksi_kopi);
  $Result1 = mysql_query($updateSQL, $koneksi_kopi) or die(mysql_error());

  $updateGoTo = "admin-jenis-update.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form")) {
  $updateSQL = sprintf("UPDATE jenis SET namakopi=%s WHERE jeniskopi=%s",
                       GetSQLValueString($_POST['namakopi'], "text"),
                       GetSQLValueString($_POST['jeniskopi'], "text"));

  mysql_select_db($database_koneksi_kopi, $koneksi_kopi);
  $Result1 = mysql_query($updateSQL, $koneksi_kopi) or die(mysql_error());

  $updateGoTo = "admin-jenis-update.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
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
   	  <h1 id="judul_logo">Data Jenis Kopi</h1>
      <div class="container">
      	<h2>Update Jenis Kopi</h2>
      	<form name="form" action="<?php echo $editFormAction; ?>" method="POST">
        	<table width="80%" border="0" cellpadding="5" cellspacing="0" class="standar_tabel">
              <tr>
                <th scope="row">Jenis Kopi</th>
                <td><input name="jeniskopi" type="text" id="jeniskopi" value="<?php echo $row_Recordset_jenis['jeniskopi']; ?>" /></td>
              </tr>
              <tr>
                <th scope="row">Nama Kopi</th>
                <td><input name="namakopi" type="text" id="namakopi" value="<?php echo $row_Recordset_jenis['namakopi']; ?>" /></td>
              </tr>
              <tr>
                <th scope="row">&nbsp;</th>
                <td><input name="submit" type="submit" class="btn" id="submit" value="Update Jenis Kopi" /></td>
              </tr>
            </table>
        	<input type="hidden" name="MM_update" value="form" />
        </form><br />
        <p><a href="admin-jenis.php" class="btn_th">Kembali</a></p>
        
      </div>
      
    <div id="footer"></div>
    
</body>
</html>
<?php
mysql_free_result($Recordset_jenis);
?>
