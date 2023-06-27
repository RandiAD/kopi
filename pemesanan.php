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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form")) {
  $insertSQL = sprintf("INSERT INTO pemesanan (meja, namapembeli, kodemenu, namamenu, jumlah) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['nomormeja'], "text"),
                       GetSQLValueString($_POST['namapembeli'], "text"),
                       GetSQLValueString($_POST['kodemenu'], "text"),
                       GetSQLValueString($_POST['namamenu'], "text"),
                       GetSQLValueString($_POST['jumlah'], "int"));

  mysql_select_db($database_koneksi_kopi, $koneksi_kopi);
  $Result1 = mysql_query($insertSQL, $koneksi_kopi) or die(mysql_error());

  $insertGoTo = "pemesanan-sukses.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

$maxRows_Recordset_tambah = 5;
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

mysql_select_db($database_koneksi_kopi, $koneksi_kopi);
$query_RecordsetTambah = "SELECT namakopi FROM tambah";
$RecordsetTambah = mysql_query($query_RecordsetTambah, $koneksi_kopi) or die(mysql_error());
$row_RecordsetTambah = mysql_fetch_assoc($RecordsetTambah);
$totalRows_RecordsetTambah = mysql_num_rows($RecordsetTambah);

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
        	<a href="index.php">Beranda</a>
   		  <a href="pemesanan.php">Pemesanan</a>
       	  <a href="#">Tentang Kami</a>
          <a href="login.php">Login</a>
    	</div>
    </div>
    <div id="content">
   	  <h1 id="judul_logo">Seruput kopi sejenak, tinggalkan masalah duniawi</h1>
      <div class="container">
      <h2>Silahkan isi pesananmu</h2>
      <h3>Daftar Menu</h3>
      <form action="" method="post">
      	<table width="80%" border="0" cellpadding="5" cellspacing="0" class="tabel_tegak">
          <tr>
            <th scope="col">Kode Menu</th>
            <th scope="col">Nama Kopi</th>
            <th scope="col">Deskripsi</th>
            <th scope="col">Harga</th>
          </tr>
          <?php do { ?>
            <tr>
              <td><?php echo $row_Recordset_tambah['kodemenu']; ?></td>
              <td><?php echo $row_Recordset_tambah['namakopi']; ?></td>
              <td><?php echo $row_Recordset_tambah['deskripsi']; ?></td>
              <td><?php echo $row_Recordset_tambah['harga']; ?></td>
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
        </table>
      </form><br />
      <h2>Pilih Pesananmu</h2>
      <form name="form" action="<?php echo $editFormAction; ?>" method="POST">
      	<table width="80%" border="0" cellpadding="5" cellspacing="0" class="standar_tabel">
          <tr>
            <th scope="row">Nomor Meja</th>
            <td><label for="nomormeja"></label>
            <input type="text" name="nomormeja" id="nomormeja" /></td>
          </tr>
          <tr>
            <th scope="row">Nama Kamu</th>
            <td><label for="namapembeli"></label>
            <input type="text" name="namapembeli" id="namapembeli" /></td>
          </tr>
          <tr>
            <th scope="row">Kode Menu</th>
            <td><label for="kodemenu"></label>
              <label for="kodemenu"></label>
              <input type="text" name="kodemenu" id="kodemenu" />
<label for="kodemenu"></label>
            <label for="kodemenu"></label></td>
          </tr>
          <tr>
            <th scope="row">Nama Menu</th>
            <td><label for="namamenu"></label>
            <label for="namamenu"></label>
            <select name="namamenu" id="namamenu">
              <?php
do {  
?>
              <option value="<?php echo $row_RecordsetTambah['namakopi']?>"><?php echo $row_RecordsetTambah['namakopi']?></option>
              <?php
} while ($row_RecordsetTambah = mysql_fetch_assoc($RecordsetTambah));
  $rows = mysql_num_rows($RecordsetTambah);
  if($rows > 0) {
      mysql_data_seek($RecordsetTambah, 0);
	  $row_RecordsetTambah = mysql_fetch_assoc($RecordsetTambah);
  }
?>
            </select></td>
          </tr>
          <tr>
            <th scope="row">Jumlah</th>
            <td><label for="jumlah"></label>
            <input type="text" name="jumlah" id="jumlah" /></td>
          </tr>
          <tr>
            <th scope="row">&nbsp;</th>
            <td><input name="submit" type="submit" class="btn" id="submit" value="Pesan" /></td>
          </tr>
        </table>
      	<input type="hidden" name="MM_insert" value="form" />

      </form>
      	
      </div>
    <div id="footer"></div>
    
</body>
</html>
<?php
mysql_free_result($Recordset_tambah);

mysql_free_result($RecordsetTambah);
?>
