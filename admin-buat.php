<?php require_once('Connections/koneksi_kopi.php'); ?>
<?php require_once('Connections/koneksi_kopi.php'); ?>
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

$currentPage = $_SERVER["PHP_SELF"];

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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form")) {
  $insertSQL = sprintf("INSERT INTO tambah (kodemenu, jeniskopi, kodekopi, namakopi, deskripsi, harga) VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['kodemenu'], "text"),
                       GetSQLValueString($_POST['jeniskopi'], "text"),
                       GetSQLValueString($_POST['kodekopi'], "text"),
                       GetSQLValueString($_POST['namakopi'], "text"),
                       GetSQLValueString($_POST['deskripsi'], "text"),
                       GetSQLValueString($_POST['harga'], "text"));

  mysql_select_db($database_koneksi_kopi, $koneksi_kopi);
  $Result1 = mysql_query($insertSQL, $koneksi_kopi) or die(mysql_error());

  $insertGoTo = "admin-buat.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

$maxRows_Recordset_jenis = 10;
$pageNum_Recordset_jenis = 0;
if (isset($_GET['pageNum_Recordset_jenis'])) {
  $pageNum_Recordset_jenis = $_GET['pageNum_Recordset_jenis'];
}
$startRow_Recordset_jenis = $pageNum_Recordset_jenis * $maxRows_Recordset_jenis;

mysql_select_db($database_koneksi_kopi, $koneksi_kopi);
$query_Recordset_jenis = "SELECT * FROM jenis";
$query_limit_Recordset_jenis = sprintf("%s LIMIT %d, %d", $query_Recordset_jenis, $startRow_Recordset_jenis, $maxRows_Recordset_jenis);
$Recordset_jenis = mysql_query($query_limit_Recordset_jenis, $koneksi_kopi) or die(mysql_error());
$row_Recordset_jenis = mysql_fetch_assoc($Recordset_jenis);

if (isset($_GET['totalRows_Recordset_jenis'])) {
  $totalRows_Recordset_jenis = $_GET['totalRows_Recordset_jenis'];
} else {
  $all_Recordset_jenis = mysql_query($query_Recordset_jenis);
  $totalRows_Recordset_jenis = mysql_num_rows($all_Recordset_jenis);
}
$totalPages_Recordset_jenis = ceil($totalRows_Recordset_jenis/$maxRows_Recordset_jenis)-1;

mysql_select_db($database_koneksi_kopi, $koneksi_kopi);
$query_Recordset_kopi = "SELECT * FROM kopi";
$Recordset_kopi = mysql_query($query_Recordset_kopi, $koneksi_kopi) or die(mysql_error());
$row_Recordset_kopi = mysql_fetch_assoc($Recordset_kopi);
$totalRows_Recordset_kopi = mysql_num_rows($Recordset_kopi);

$maxRows_Recordset_tambah = 10;
$pageNum_Recordset_tambah = 0;
if (isset($_GET['pageNum_Recordset_tambah'])) {
  $pageNum_Recordset_tambah = $_GET['pageNum_Recordset_tambah'];
}
$startRow_Recordset_tambah = $pageNum_Recordset_tambah * $maxRows_Recordset_tambah;

mysql_select_db($database_koneksi_kopi, $koneksi_kopi);
$query_Recordset_tambah = "SELECT * FROM tambah";
$query_limit_Recordset_tambah = sprintf("%s LIMIT %d, %d", $query_Recordset_tambah, $startRow_Recordset_tambah, $maxRows_Recordset_tambah);
$Recordset_tambah = mysql_query($query_limit_Recordset_tambah, $koneksi_kopi) or die(mysql_error());
$row_Recordset_tambah = mysql_fetch_assoc($Recordset_tambah);

if (isset($_GET['totalRows_Recordset_tambah'])) {
  $totalRows_Recordset_tambah = $_GET['totalRows_Recordset_tambah'];
} else {
  $all_Recordset_tambah = mysql_query($query_Recordset_tambah);
  $totalRows_Recordset_tambah = mysql_num_rows($all_Recordset_tambah);
}
$totalPages_Recordset_tambah = ceil($totalRows_Recordset_tambah/$maxRows_Recordset_tambah)-1;

$queryString_Recordset_tambah = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_Recordset_tambah") == false && 
        stristr($param, "totalRows_Recordset_tambah") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_Recordset_tambah = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_Recordset_tambah = sprintf("&totalRows_Recordset_tambah=%d%s", $totalRows_Recordset_tambah, $queryString_Recordset_tambah);
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
      	<h2>Tambah List Menu</h2>
        <form name="form" action="<?php echo $editFormAction; ?>" method="POST">
        	<table width="80%" border="0" cellpadding="5" cellspacing="0" class="standar_tabel">
              <tr>
                <th scope="row">Kode Menu</th>
                <td><label for="kodemenu2"></label>
                <input type="text" name="kodemenu" id="kodemenu2" /></td>
              </tr>
              <tr>
                <th scope="row">Jenis Kopi</th>
                <td><label for="jeniskopi"></label>
                  <select name="jeniskopi" id="jeniskopi">
                    <?php
do {  
?>
                    <option value="<?php echo $row_Recordset_jenis['jeniskopi']?>"><?php echo $row_Recordset_jenis['jeniskopi']?></option>
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
                    <option value="<?php echo $row_Recordset_kopi['kodekopi']?>"><?php echo $row_Recordset_kopi['kodekopi']?></option>
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
                    <option value="<?php echo $row_Recordset_kopi['namakopi']?>"><?php echo $row_Recordset_kopi['namakopi']?></option>
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
                <textarea name="deskripsi" id="deskripsi" cols="45" rows="5"></textarea></td>
              </tr>
              <tr>
                <th scope="row">Harga</th>
                <td><label for="harga"></label>
                <input type="text" name="harga" id="harga" /></td>
              </tr>
              <tr>
                <th scope="row">&nbsp;</th>
                <td><input name="submit" type="submit" class="btn" id="submit" value="Submit" /></td>
              </tr>
            </table>
        	<input type="hidden" name="MM_insert" value="form" />

        </form><br />
        <h2>Daftar Menu</h2>
        <form action="" method="post">
        	<table width="80%" border="0" cellpadding="5" cellspacing="0" class="tabel_tegak">
              <tr>
                <th scope="col">Kode Menu</th>
                <th scope="col">Nama Kopi</th>
                <th scope="col">Aksi</th>
              </tr>
              <?php do { ?>
                <tr>
                  <td><?php echo $row_Recordset_tambah['kodemenu']; ?></td>
                  <td><?php echo $row_Recordset_tambah['namakopi']; ?></td>
                  <td><a href="admin-buat-update.php?kodemenu=<?php echo $row_Recordset_tambah['kodemenu']; ?>" class="btn_th">Update</a> - <a href="admin-buat-delete.php?kodemenu=<?php echo $row_Recordset_tambah['kodemenu']; ?>" class="btn_th">Delete</a></td>
                </tr>
                <?php } while ($row_Recordset_tambah = mysql_fetch_assoc($Recordset_tambah)); ?>
            </table><br />
            <table border="0">
              <tr>
                <td><?php if ($pageNum_Recordset_tambah > 0) { // Show if not first page ?>
                    <a href="<?php printf("%s?pageNum_Recordset_tambah=%d%s", $currentPage, 0, $queryString_Recordset_tambah); ?>"><img src="First.gif" /></a>
                    <?php } // Show if not first page ?></td>
                <td><?php if ($pageNum_Recordset_tambah > 0) { // Show if not first page ?>
                    <a href="<?php printf("%s?pageNum_Recordset_tambah=%d%s", $currentPage, max(0, $pageNum_Recordset_tambah - 1), $queryString_Recordset_tambah); ?>"><img src="Previous.gif" /></a>
                    <?php } // Show if not first page ?></td>
                <td><?php if ($pageNum_Recordset_tambah < $totalPages_Recordset_tambah) { // Show if not last page ?>
                    <a href="<?php printf("%s?pageNum_Recordset_tambah=%d%s", $currentPage, min($totalPages_Recordset_tambah, $pageNum_Recordset_tambah + 1), $queryString_Recordset_tambah); ?>"><img src="Next.gif" /></a>
                    <?php } // Show if not last page ?></td>
                <td><?php if ($pageNum_Recordset_tambah < $totalPages_Recordset_tambah) { // Show if not last page ?>
                    <a href="<?php printf("%s?pageNum_Recordset_tambah=%d%s", $currentPage, $totalPages_Recordset_tambah, $queryString_Recordset_tambah); ?>"><img src="Last.gif" /></a>
                    <?php } // Show if not last page ?></td>
              </tr>
            </table><br />
Records <?php echo ($startRow_Recordset_tambah + 1) ?> to <?php echo min($startRow_Recordset_tambah + $maxRows_Recordset_tambah, $totalRows_Recordset_tambah) ?> of <?php echo $totalRows_Recordset_tambah ?>
        </form>

</div>
    <div id="footer"></div>
    
</body>
</html>
<?php


mysql_free_result($Recordset_kopi);

mysql_free_result($Recordset_tambah);
?>
