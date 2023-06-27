<?php require_once('Connections/koneksi_kopi.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && true) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "index.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
  $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
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
  $updateSQL = sprintf("UPDATE tambah SET jeniskopi=%s, kodekopi=%s, namakopi=%s, deskripsi=%s, harga=%s WHERE kodemenu=%s",
                       GetSQLValueString($_POST['jeniskopi'], "text"),
                       GetSQLValueString($_POST['kodekopi'], "text"),
                       GetSQLValueString($_POST['namakopi'], "text"),
                       GetSQLValueString($_POST['deskripsi'], "text"),
                       GetSQLValueString($_POST['harga'], "text"),
                       GetSQLValueString($_POST['kodemenu'], "text"));

  mysql_select_db($database_koneksi_kopi, $koneksi_kopi);
  $Result1 = mysql_query($updateSQL, $koneksi_kopi) or die(mysql_error());

  $updateGoTo = "admin-buat-update.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

mysql_select_db($database_koneksi_kopi, $koneksi_kopi);
$query_Recordset_jenis = "SELECT * FROM jenis";
$Recordset_jenis = mysql_query($query_Recordset_jenis, $koneksi_kopi) or die(mysql_error());
$row_Recordset_jenis = mysql_fetch_assoc($Recordset_jenis);
$totalRows_Recordset_jenis = mysql_num_rows($Recordset_jenis);

mysql_select_db($database_koneksi_kopi, $koneksi_kopi);
$query_Recordset_kopi = "SELECT * FROM kopi";
$Recordset_kopi = mysql_query($query_Recordset_kopi, $koneksi_kopi) or die(mysql_error());
$row_Recordset_kopi = mysql_fetch_assoc($Recordset_kopi);
$totalRows_Recordset_kopi = mysql_num_rows($Recordset_kopi);

$colname_Recordset_tambah = "-1";
if (isset($_GET['kodemenu'])) {
  $colname_Recordset_tambah = $_GET['kodemenu'];
}
mysql_select_db($database_koneksi_kopi, $koneksi_kopi);
$query_Recordset_tambah = sprintf("SELECT * FROM tambah WHERE kodemenu = %s", GetSQLValueString($colname_Recordset_tambah, "text"));
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
        	<a href="admin.php">Beranda</a>
       	  	<a href="admin-pesanan.php">Pesanan</a>
        	<a href="admin-kopi.php">Data Kopi</a>
          	<a href="admin-jenis.php">Jenis Kopi</a>
			<a href="admin-buat.php">Buat Kopi</a>
            <a href="logout.php">Logout</a>    	
        </div>
    </div>
    <div id="content">
   	  <h1 id="judul_logo">Data Menu</h1>
      <div class="container">
      	<h2>Update List Menu</h2>
        <form name="form" action="<?php echo $editFormAction; ?>" method="POST">
        	<table width="80%" border="0" cellpadding="5" cellspacing="0" class="standar_tabel">
              <tr>
                <th scope="row">Kode Menu</th>
                <td><label for="kodemenu"></label>
                <input name="kodemenu" type="text" id="kodemenu" value="<?php echo $row_Recordset_tambah['kodemenu']; ?>" /></td>
              </tr>
              <tr>
                <th scope="row">Jenis Kopi</th>
                <td><label for="jeniskopi"></label>
                  <select name="jeniskopi" id="jeniskopi">
                    <?php
do {  
?>
                    <option value="<?php echo $row_Recordset_jenis['jeniskopi']?>"<?php if (!(strcmp($row_Recordset_jenis['jeniskopi'], $row_Recordset_tambah['jeniskopi']))) {echo "selected=\"selected\"";} ?>><?php echo $row_Recordset_jenis['jeniskopi']?></option>
                    <?php
} while ($row_Recordset_jenis = mysql_fetch_assoc($Recordset_jenis));
  $rows = mysql_num_rows($Recordset_jenis);
  if($rows > 0) {
      mysql_data_seek($Recordset_jenis, 0);
	  $row_Recordset_jenis = mysql_fetch_assoc($Recordset_jenis);
  }
?>
                </select></td>
              </tr>
              <tr>
                <th scope="row">Kode Kopi</th>
                <td><label for="kodekopi"></label>
                  <select name="kodekopi" id="kodekopi">
                    <?php
do {  
?>
                    <option value="<?php echo $row_Recordset_kopi['kodekopi']?>"<?php if (!(strcmp($row_Recordset_kopi['kodekopi'], $row_Recordset_tambah['kodekopi']))) {echo "selected=\"selected\"";} ?>><?php echo $row_Recordset_kopi['kodekopi']?></option>
                    <?php
} while ($row_Recordset_kopi = mysql_fetch_assoc($Recordset_kopi));
  $rows = mysql_num_rows($Recordset_kopi);
  if($rows > 0) {
      mysql_data_seek($Recordset_kopi, 0);
	  $row_Recordset_kopi = mysql_fetch_assoc($Recordset_kopi);
  }
?>
                </select></td>
              </tr>
              <tr>
                <th scope="row">Nama Kopi</th>
                <td><label for="namakopi"></label>
                  <select name="namakopi" id="namakopi">
                    <?php
do {  
?>
                    <option value="<?php echo $row_Recordset_kopi['namakopi']?>"<?php if (!(strcmp($row_Recordset_kopi['namakopi'], $row_Recordset_tambah['namakopi']))) {echo "selected=\"selected\"";} ?>><?php echo $row_Recordset_kopi['namakopi']?></option>
                    <?php
} while ($row_Recordset_kopi = mysql_fetch_assoc($Recordset_kopi));
  $rows = mysql_num_rows($Recordset_kopi);
  if($rows > 0) {
      mysql_data_seek($Recordset_kopi, 0);
	  $row_Recordset_kopi = mysql_fetch_assoc($Recordset_kopi);
  }
?>
                </select></td>
              </tr>
              <tr>
                <th scope="row">Deskripsi</th>
                <td><label for="deskripsi"></label>
                <textarea name="deskripsi" id="deskripsi" cols="45" rows="5"><?php echo $row_Recordset_tambah['deskripsi']; ?></textarea></td>
              </tr>
              <tr>
                <th scope="row">Harga</th>
                <td><label for="harga"></label>
                <input name="harga" type="text" id="harga" value="<?php echo $row_Recordset_tambah['harga']; ?>" /></td>
              </tr>
              <tr>
                <th scope="row">&nbsp;</th>
                <td><input name="submit" type="submit" class="btn" id="submit" value="Update Menu" /></td>
              </tr>
            </table>
        	<input type="hidden" name="MM_update" value="form" />

        </form><br />
        <p><a href="admin-buat.php" class="btn_th">Kembali</a></p>
      </div>
    <div id="footer"></div>
    
</body>
</html>
<?php
mysql_free_result($Recordset_jenis);

mysql_free_result($Recordset_kopi);

mysql_free_result($Recordset_tambah);
?>
