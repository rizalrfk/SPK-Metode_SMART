<?php
include '../../config/conn.php';
if ($_GET['aksi'] == '') {
  //koneksi
  session_start();

  //-- inisialisasi variabel array alternatif
  $alternatif = array();
  $sql = 'SELECT * FROM tab_alternatif';
  $data = $conn->query($sql);
  while ($row = $data->fetch_object()) {
    $alternatif[$row->id_alternatif] = $row->nama_alternatif;
  }

  //-- inisialisasi variabel array kriteria dan bobot (W)
  $kriteria = array();
  $sql = 'SELECT * FROM tab_kriteria';
  $data = $conn->query($sql);
  while ($row = $data->fetch_object()) {
    $kriteria[$row->id_kriteria] = array($row->nama_kriteria, $row->atribut);
  }

  //-- ambil nilai dari tabel
  $nilai = array();
  $sql = 'SELECT * FROM tab_evaluation ORDER BY id_alternatif, id_kriteria';
  $data = $conn->query($sql);
  while ($row = $data->fetch_object()) {
    $i = $row->id_alternatif;
    $j = $row->id_kriteria;
    $aij = $row->nilai;

    $nilai[$i][$j] = $aij;
  }

?>

  <div class="col" role="main">
    <div class="">
      <div class="clearfix"></div>
      <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
            <div class="x_title" style="text-transform: capitalize;">
              <h2><b>Data <?php echo $_GET['module']; ?></b> <small></small></h2>
              <div class="clearfix"></div>
            </div><br>

            <div class="x_content">
              <form method="POST" action="?module=<?php echo $_GET['module']; ?>&aksi=simpan_edit">
                <table id="datatable" class="table table-striped table-bordered">
                  <thead>
                    <tr style="vertical-align : middle;text-align:center;">
                      <th class="text-center" width="10">No</th>
                      <th class="text-center">Alternatif</th>
                      <?php foreach ($kriteria as $key => $value) : ?>
                        <th style="text-align:center;"><?php echo $key . "<br>(" . $value[0] . ")" ?></th>
                      <?php endforeach ?>
                      <?php if ($_SESSION['leveluser'] == 'admin') { ?>
                      <?php } ?>
                    </tr>
                  </thead>

                  <tbody>
                    <?php
                    $no = 0;
                    foreach ($alternatif as $key => $value) :
                      $no++;
                    ?>
                      <tr>
                        <td><?php echo $key ?></td>
                        <td><?php echo $value ?></td>
                        <?php foreach ($kriteria as $key2 => $value2) : ?>
                          <td><input type="number" min="1" max="5" name="nilai[<?php echo $key ?>][<?php echo $key2 ?>]" class="form-control" value="<?php echo @$nilai[$key][$key2] ?>"></td>
                        <?php endforeach ?>
                      </tr>
                    <?php endforeach ?>
                  </tbody>
                </table>
                <button class="btn btn-success btn-block text-center" type="submit"><i class="glyphicon glyphicon-save"> </i> Simpan</button>
              </form>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>

<?php } elseif ($_GET['aksi'] == 'simpan_edit') {
  $module = $_GET['module'];
  $password   = md5($_POST[password]);

  $nilai = $_POST['nilai'];
  $count_nilai = count($nilai);

  // Delete Semua Data
  $sql = "TRUNCATE TABLE tab_evaluation";
  $hapus = $conn->query($sql);

  // Bulk Insert
  $query = "INSERT INTO tab_evaluation (id_alternatif, id_kriteria, nilai) VALUES ";
  $values = '';
  $koma = ',';
  foreach ($nilai as $key => $value) {
    foreach ($value as $key2 => $value2) {
      // Jika data yg terakhir maka koma berubah menjadi titik koma
      if ($key === array_key_last($nilai) && $key2 === array_key_last($value)) {
        $koma = ';';
      }
      $value2 = (int) empty($value2) ? 0 : $value2;
      $values .= "('$key','$key2','$value2')$koma";
    }
  }
  $sql = $query . $values;
  $insert = $conn->query($sql);

  // echo "<script>alert('Data Berhasil di Simpan') </script>";
  echo "<script language='javascript'>document.location='?module=" . $module . "';</script>";
}
?>