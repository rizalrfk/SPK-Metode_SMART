
<?php
	error_reporting(0);
  	include "conn.php";

  	if ($_GET['aksi'] == 'pegawai') {
  	$id=$_GET['id_pegawai'];
	$query=mysqli_query($conn,"Delete FROM pegawai WHERE id_pegawai='$id'");
	echo "<script language='javascript'>document.location='../?module=pegawai';</script>";
  	}

	
?>