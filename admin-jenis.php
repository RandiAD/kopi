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

$currentPage = $_SERVER["PHP_SELF"];

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form")) {
  $insertSQL = sprintf("INSERT INTO jenis (jeniskopi, namakopi) VALUES (%s, %s)",
                       GetSQLValueString($_POST['jeniskopi'], "text"),
                       GetSQLValueString($_POST['namakopi'], "text"));

  mysql_select_db($database_koneksi_kopi, $koneksi_kopi);
  $Result1 = mysql_query($insertSQL, $koneksi_kopi) or die(mysql_error());

  $insertGoTo = "admin-jenis.php";
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

$queryString_Recordset_jenis = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_Recordset_jenis") == false && 
        stristr($param, "totalRows_Recordset_jenis") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_Recordset_jenis = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_Recordset_jenis = sprintf("&totalRows_Recordset_jenis=%d%s", $totalRows_Recordset_jenis, $queryString_Recordset_jenis);
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
   	  <h1 id="judul_logo">Jenis Kopi</h1>
      <div class="container">
      <h2>Tambah Jenis Kopi</h2>
      	<form name="form" action="<?php echo $editFormAction; ?>" method="POST">
        	<table width="80%" border="0" cellpadding="5" cellspacing="0" class="standar_tabel">
              <tr>
                <th scope="row">Jenis Kopi</th>
                <td><input name="jeniskopi" type="text" id="jeniskopi" size="30" /></td>
              </tr>
              <tr>
                <th scope="row">Nama Kopi</th>
                <td><input name="namakopi" type="text" id="namakopi" size="50" /></td>
              </tr>
              <tr>
                <th scope="row">&nbsp;</th>
                <td><input name="submit" type="submit" class="btn" id="submit" value="Tambah Jenis Kopi" /></td>
              </tr>
            </table>
        	<input type="hidden" name="MM_insert" value="form" />
        </form><br />
        
        <h2>List Jenis Kopi</h2>
        <form action="" method="post">
        	
       	    <table width="80%" border="0" cellpadding="5" cellspacing="0" class="tabel_tegak">
        	    <tr>
        	      <th scope="col">Jenis Kopi</th>
        	      <th scope="col">Nama Kopi</th>
        	      <th scope="col">Aksi</th>
       	        </tr>
                <?php do { ?>
        	    <tr>
        	      <td><?php echo $row_Recordset_jenis['jeniskopi']; ?></td>
        	      <td><?php echo $row_Recordset_jenis['namakopi']; ?></td>
        	      <td><a href="admin-jenis-update.php?jeniskopi=<?php echo $row_Recordset_jenis['jeniskopi']; ?>" class="btn_th">Update</a> - <a href="admin-jenis-delete.php?jeniskopi=<?php echo $row_Recordset_jenis['jeniskopi']; ?>" class="btn_th">Delete</a></td>
       	        </tr>
                 <?php } while ($row_Recordset_jenis = mysql_fetch_assoc($Recordset_jenis)); ?>
   	      </table><br />
          <table border="0">
            <tr>
              <td><?php if ($pageNum_Recordset_jenis > 0) { // Show if not first page ?>
                  <a href="<?php printf("%s?pageNum_Recordset_jenis=%d%s", $currentPage, 0, $queryString_Recordset_jenis); ?>"><img src="First.gif" /></a>
                  <?php } // Show if not first page ?></td>
              <td><?php if ($pageNum_Recordset_jenis > 0) { // Show if not first page ?>
                  <a href="<?php printf("%s?pageNum_Recordset_jenis=%d%s", $currentPage, max(0, $pageNum_Recordset_jenis - 1), $queryString_Recordset_jenis); ?>"><img src="Previous.gif" /></a>
                  <?php } // Show if not first page ?></td>
              <td><?php if ($pageNum_Recordset_jenis < $totalPages_Recordset_jenis) { // Show if not last page ?>
                  <a href="<?php printf("%s?pageNum_Recordset_jenis=%d%s", $currentPage, min($totalPages_Recordset_jenis, $pageNum_Recordset_jenis + 1), $queryString_Recordset_jenis); ?>"><img src="Next.gif" /></a>
                  <?php } // Show if not last page ?></td>
              <td><?php if ($pageNum_Recordset_jenis < $totalPages_Recordset_jenis) { // Show if not last page ?>
                  <a href="<?php printf("%s?pageNum_Recordset_jenis=%d%s", $currentPage, $totalPages_Recordset_jenis, $queryString_Recordset_jenis); ?>"><img src="Last.gif" /></a>
                  <?php } // Show if not last page ?></td>
            </tr>
          </table>
<br />
Records <?php echo ($startRow_Recordset_jenis + 1) ?> to <?php echo min($startRow_Recordset_jenis + $maxRows_Recordset_jenis, $totalRows_Recordset_jenis) ?> of <?php echo $totalRows_Recordset_jenis ?>
        </form>
        
      </div>
    <div id="footer"></div>
    
</body>
</html>
<?php
mysql_free_result($Recordset_jenis);
?>
