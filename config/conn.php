
<?php
	$conn = mysqli_connect("localhost","root","","db_smart"); 
	if (mysqli_connect_errno()) {
		  trigger_error('Koneksi ke database gagal: '  . mysqli_connect_error(), E_USER_ERROR); 
	}

	function query($query) {
		global $conn;
		$result = mysqli_query($conn,$query);
		$rows = [];
		while ($row = mysqli_fetch_assoc($result)) {
			$rows[] = $row;
		}
		return $rows;
}
?>