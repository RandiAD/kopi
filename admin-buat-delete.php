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

if ((isset($_GET['kodemenu'])) && ($_GET['kodemenu'] != "") && (isset($_GET['Confirm']))) {
  $deleteSQL = sprintf("DELETE FROM tambah WHERE kodemenu=%s",
                       GetSQLValueString($_GET['kodemenu'], "text"));

  mysql_select_db($database_koneksi_kopi, $koneksi_kopi);
  $Result1 = mysql_query($deleteSQL, $koneksi_kopi) or die(mysql_error());

  $deleteGoTo = "admin-buat.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $deleteGoTo));
}

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
      	<h2>Delete Menu</h2>
        <form action="" method="post">
        	<table width="80%" border="0" cellpadding="5" cellspacing="0" class="standar_tabel">
              <tr>
                <th scope="row">Kode Menu</th>
                <td><?php echo $row_Recordset_tambah['kodemenu']; ?></td>
              </tr>
              <tr>
                <th scope="row">Jenis Kopi</th>
                <td><?php echo $row_Recordset_tambah['jeniskopi']; ?></td>
              </tr>
              <tr>
                <th scope="row">Kode Kopi</th>
                <td><?php echo $row_Recordset_tambah['kodekopi']; ?></td>
              </tr>
              <tr>
                <th scope="row">Nama Kopi</th>
                <td><?php echo $row_Recordset_tambah['namakopi']; ?></td>
              </tr>
              <tr>
                <th scope="row">Deskripsi</th>
                <td><?php echo $row_Recordset_tambah['deskripsi']; ?></td>
              </tr>
              <tr>
                <th scope="row">Harga</th>
                <td><?php echo $row_Recordset_tambah['harga']; ?></td>
              </tr>
            </table><br />
            <p>Ingin hapus data ini?</p><br />
            <p>
            	<a href="admin-buat-delete.php?kodemenu=<?php echo $row_Recordset_tambah['kodemenu']; ?>&amp;Confirm=Yes" class="btn_th">Hapus</a> - <a href="admin-buat.php" class="btn_th">Tidak</a> 
            </p>

        </form>
      </div>
    <div id="footer"></div>
    
</body>
</html>
<?php
mysql_free_result($Recordset_tambah);
?>
