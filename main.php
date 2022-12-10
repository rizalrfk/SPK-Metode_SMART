<?php 
// file pintasanmodule
if ($_GET['module']=='') {
	include 'component/home.php';
}elseif ($_GET['module'] == 'pegawai') {
	if ($_SESSION['leveluser']=='admin'){
	include 'component/com_pegawai/pegawai.php';
	}else{
		echo '<meta http-equiv="refresh" content="0; url=index.php">';
	}

}elseif ($_GET['module'] == 'kriteria') {
	include 'component/com_kriteria/kriteria.php';

}elseif ($_GET['module'] == 'alternatif') {
	include 'component/com_alternatif/alternatif.php';

}elseif ($_GET['module'] == 'nilai') {
	include 'component/com_nilai/nilai.php';

}elseif ($_GET['module'] == 'perhitungan') {
	include 'component/com_perhitungan/perhitungan.php';

}elseif ($_GET['module'] == 'pengaturan') {
	 if ($_SESSION['leveluser']=='admin'){
	include 'component/com_pengaturan/pengaturan.php';
	}else{
		echo '<meta http-equiv="refresh" content="0; url=index.php">';
	}
}else{
	echo '<meta http-equiv="refresh" content="0; url=?module=beranda">';
}


?>