<?php
include "config/conn.php";
include 'lib/function.php';

// fungsi untuk menghindari injeksi dari user yang jahil
function anti_injection($data){
	$filter  = stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES)));
	return $filter;
}

$username = anti_injection($_POST['username']);
$password = anti_injection($_POST['password']);

// menghindari sql injection
$injeksi_username = mysqli_real_escape_string($conn, $username);
$injeksi_password = mysqli_real_escape_string($conn, $password);
	
// pastikan username dan password adalah berupa huruf atau angka.
if (!ctype_alnum($injeksi_username) OR !ctype_alnum($injeksi_password)){
  echo "Sekarang loginnya tidak bisa di injeksi lho.";
}
else{
	$login = mysqli_query($conn,"SELECT * FROM user WHERE username='$username' AND password='$password' AND status='Y'");
	// if (mysqli_num_rows($login) == 0){
	//  $login = mysqli_query($conn,"SELECT * FROM nasabah WHERE username='$username' AND password='$password' AND status='Y'");
	// }

	$ketemu = mysqli_num_rows($login);
	$r      = mysqli_fetch_array($login);

	// Apabila username dan password ditemukan (benar)
	if ($ketemu > 0){
		session_start();

    $_SESSION['namauser']    = $r['username'];
    $_SESSION['passuser']    = $r['password'];
    $_SESSION['namalengkap'] = $r['nama'];
    $_SESSION['leveluser']   = $r['level'];

    login_validate();
      
   // bikin id_session yang unik dan mengupdatenya agar slalu berubah 
    // agar user biasa sulit untuk mengganti password Administrator 
    $sid_lama = session_id();
	  session_regenerate_id();
    $sid_baru = session_id();

    if ($r['level'] == 'admin'){

    mysqli_query($conn, "UPDATE user SET id_session='$sid_baru' WHERE username='$username'");

	}else{
	mysqli_query($conn, "UPDATE user SET id_session='$sid_baru' WHERE username='$username'");	
	}

    header("location:index.php");
	}
	else{
		echo "<script>alert('Gagal Login.'); window.location = 'index.php'</script>";
	}
}
?>