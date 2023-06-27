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

$maxRows_Recordset_pemesanan = 10;
$pageNum_Recordset_pemesanan = 0;
if (isset($_GET['pageNum_Recordset_pemesanan'])) {
  $pageNum_Recordset_pemesanan = $_GET['pageNum_Recordset_pemesanan'];
}
$startRow_Recordset_pemesanan = $pageNum_Recordset_pemesanan * $maxRows_Recordset_pemesanan;

mysql_select_db($database_koneksi_kopi, $koneksi_kopi);
$query_Recordset_pemesanan = "SELECT * FROM pemesanan";
$query_limit_Recordset_pemesanan = sprintf("%s LIMIT %d, %d", $query_Recordset_pemesanan, $startRow_Recordset_pemesanan, $maxRows_Recordset_pemesanan);
$Recordset_pemesanan = mysql_query($query_limit_Recordset_pemesanan, $koneksi_kopi) or die(mysql_error());
$row_Recordset_pemesanan = mysql_fetch_assoc($Recordset_pemesanan);

if (isset($_GET['totalRows_Recordset_pemesanan'])) {
  $totalRows_Recordset_pemesanan = $_GET['totalRows_Recordset_pemesanan'];
} else {
  $all_Recordset_pemesanan = mysql_query($query_Recordset_pemesanan);
  $totalRows_Recordset_pemesanan = mysql_num_rows($all_Recordset_pemesanan);
}
$totalPages_Recordset_pemesanan = ceil($totalRows_Recordset_pemesanan/$maxRows_Recordset_pemesanan)-1;

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

$queryString_Recordset_pemesanan = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_Recordset_pemesanan") == false && 
        stristr($param, "totalRows_Recordset_pemesanan") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_Recordset_pemesanan = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_Recordset_pemesanan = sprintf("&totalRows_Recordset_pemesanan=%d%s", $totalRows_Recordset_pemesanan, $queryString_Recordset_pemesanan);

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
   	  <h1 id="judul_logo">Data Kopi</h1>
      <div class="container">
      	<h2>Daftar Menu</h2>
      	<form action="" method="post">
        	<table width="80%" border="0" cellpadding="5" cellspacing="0" class="tabel_tegak">
              <tr>
                <th scope="col">Kode Menu</th>
                <th scope="col">Nama Menu</th>
                <th scope="col">Harga</th>
              </tr>
              <?php do { ?>
                <tr>
                  <td><?php echo $row_Recordset_tambah['kodemenu']; ?></td>
                  <td><?php echo $row_Recordset_tambah['namakopi']; ?></td>
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
        </form>
      	<br />
      	<h2>Daftar Pesanan</h2>
        <form action="" method="post">
        	<table width="80%" border="0" cellpadding="5" cellspacing="0" class="tabel_tegak">
              <tr>
                <th scope="col">No</th>
                <th scope="col">Meja</th>
                <th scope="col">Nama Pembeli</th>
                <th scope="col">Kode Menu</th>
                <th scope="col">Nama Menu</th>
                <th scope="col">Jumlah</th>
                <th scope="col">Aksi</th>
              </tr>
              <?php do { ?>
              <tr>
                <td><?php echo $row_Recordset_pemesanan['nomorpemesanan']; ?></td>
                <td><?php echo $row_Recordset_pemesanan['meja']; ?></td>
                <td><?php echo $row_Recordset_pemesanan['namapembeli']; ?></td>
                <td><?php echo $row_Recordset_pemesanan['kodemenu']; ?></td>
                <td><?php echo $row_Recordset_pemesanan['namamenu']; ?></td>
                <td><?php echo $row_Recordset_pemesanan['jumlah']; ?></td>
                <td align="center"><a href="admin-pesanan-selesai.php?nomorpemesanan=<?php echo $row_Recordset_pemesanan['nomorpemesanan']; ?>" class="btn_th">Selesai</a></td>
              </tr>
                <?php } while ($row_Recordset_pemesanan = mysql_fetch_assoc($Recordset_pemesanan)); ?>
            </table><br />
            <table border="0">
              <tr>
                <td><?php if ($pageNum_Recordset_pemesanan > 0) { // Show if not first page ?>
                    <a href="<?php printf("%s?pageNum_Recordset_pemesanan=%d%s", $currentPage, 0, $queryString_Recordset_pemesanan); ?>"><img src="First.gif" /></a>
                    <?php } // Show if not first page ?></td>
                <td><?php if ($pageNum_Recordset_pemesanan > 0) { // Show if not first page ?>
                    <a href="<?php printf("%s?pageNum_Recordset_pemesanan=%d%s", $currentPage, max(0, $pageNum_Recordset_pemesanan - 1), $queryString_Recordset_pemesanan); ?>"><img src="Previous.gif" /></a>
                    <?php } // Show if not first page ?></td>
                <td><?php if ($pageNum_Recordset_pemesanan < $totalPages_Recordset_pemesanan) { // Show if not last page ?>
                    <a href="<?php printf("%s?pageNum_Recordset_pemesanan=%d%s", $currentPage, min($totalPages_Recordset_pemesanan, $pageNum_Recordset_pemesanan + 1), $queryString_Recordset_pemesanan); ?>"><img src="Next.gif" /></a>
                    <?php } // Show if not last page ?></td>
                <td><?php if ($pageNum_Recordset_pemesanan < $totalPages_Recordset_pemesanan) { // Show if not last page ?>
                    <a href="<?php printf("%s?pageNum_Recordset_pemesanan=%d%s", $currentPage, $totalPages_Recordset_pemesanan, $queryString_Recordset_pemesanan); ?>"><img src="Last.gif" /></a>
                    <?php } // Show if not last page ?></td>
              </tr>
            </table><br />
Records <?php echo ($startRow_Recordset_pemesanan + 1) ?> to <?php echo min($startRow_Recordset_pemesanan + $maxRows_Recordset_pemesanan, $totalRows_Recordset_pemesanan) ?> of <?php echo $totalRows_Recordset_pemesanan ?>
        </form>
      </div>
    
</body>
</html>
<?php
mysql_free_result($Recordset_pemesanan);

mysql_free_result($Recordset_tambah);
?>
