<?php
error_reporting(0);
include '../../config/conn.php';
$module = $_GET['module'];
$act    = $_GET['act'];	

  if ( $module = 'pegawai' AND $act =='simpan') {
  $password = md5($_POST[password]);  
    mysqli_query($conn,"INSERT INTO pegawai(id_pegawai,
                                  nama,
                                  alamat,
                                  no_telp,
                                  username,
                                  password,
                                  level,
                                  status) VALUES('$_POST[id]',
                                                 '$_POST[nama]',
                                                 '$_POST[username]',
                                                 '$password',
                                                 '$_POST[level]',
                                                 '$_POST[status]')");

    echo "<script language='javascript'>document.location='../../?module=".$module."';</script>";
  }elseif ($module = 'pegawai' AND $act =='edit') {
  	$password   = md5($_POST[password]);
    if (empty($_POST['password'])) {
    mysqli_query($conn,"UPDATE pegawai SET nama = '$_POST[nama]',
                                    username = '$_POST[username]',
                                    level = '$_POST[level]',
                                    status = '$_POST[status]' 
                                    WHERE id_pegawai = '$_POST[id]'");

    }else{
    mysqli_query($conn,"UPDATE pegawai SET nama = '$_POST[nama]',
                                    username = '$_POST[username]',
                                    password = '$_POST[password]',
                                    level = '$_POST[level]',
                                    status = '$_POST[status]' 
                                    WHERE id_pegawai = '$_POST[id]'");  
    }  
    echo "<script language='javascript'>
        document.location='../../?module=".$module."';
        </script>";
  }
?>