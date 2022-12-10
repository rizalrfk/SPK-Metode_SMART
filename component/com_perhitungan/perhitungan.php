<?php
include '../../config/conn.php';
if ($_GET['aksi'] == '') {

  //-- inisialisasi variabel array alternatif
  $alternatif = array();
  $sql = 'SELECT * FROM tab_alternatif';
  $data = $conn->query($sql);
  while ($row = $data->fetch_object()) {
    $alternatif[] = $row->nama_alternatif;
    $id_alternatif[] = $row->id_alternatif;
  }
  $n_alternatif = count($alternatif);
  // echo $n_alternatif;

  //-- inisialisasi variabel array kriteria dan bobot (W)
  $kriteria = array();
  $sql = 'SELECT * FROM tab_kriteria';
  $data = $conn->query($sql);
  while ($row = $data->fetch_object()) {
    $id_kriteria[] = $row->id_kriteria;
    $kriteria[] = $row->nama_kriteria;
    $type[] = $row->attribute;
    $w[] = $row->bobot;
  }
  $n_kriteria = count($kriteria);
  // echo $n_kriteria;

  //-- inisialisasi variabel array matriks keputusan X
  //-- ambil nilai dari tabel
  $sql = 'SELECT a.id_alternatif,b.id_kriteria,
  IFNULL((SELECT nilai FROM tab_evaluation WHERE id_alternatif=a.id_alternatif AND id_kriteria=b.id_kriteria),0) nilai
FROM tab_alternatif a CROSS JOIN tab_kriteria b
ORDER BY a.id_alternatif,b.id_kriteria';
  $data = $conn->query($sql);
  while ($row = $data->fetch_object()) {
    $value[] = $row->nilai;
    $X[] = $row->nilai;
  }

  // Normalisasi bobot
  $nw = array();
  for ($i = 0; $i < count($w); $i++) {
    $nw[] = $w[$i] / array_sum($w);
  }

  // normalisasi Matriks
  // normalisasi atribut
  for ($i = 0; $i < $n_kriteria; $i++) {
    // nilai max/benefit
    $max =  $value[$i];
    for ($j = 0; $j < $n_alternatif * $n_kriteria; $j += $n_kriteria) {
      $index = $j + $i;
      if ($max < $value[$index]) {
        $max = $value[$index];
      }
    }
    $limit_max[$i] = $max;
    // nilai min/cost
    $min =  $value[$i];
    for ($j = 0; $j < $n_alternatif * $n_kriteria; $j += $n_kriteria) {
      $index = $j + $i;
      if ($min > $value[$index]) {
        $min = $value[$index];
      }
    }
    $limit_min[$i] = $min;
  }
  // normalisasi R
  for ($i = 0; $i < $n_kriteria; $i++) {
    if ($type[$i] == "benefit") {
      for ($j = 0; $j < $n_alternatif * $n_kriteria; $j += $n_kriteria) {
        $index = $j + $i;
        $value[$index] = (($value[$index] - $limit_min[$i]) / ($limit_max[$i] - $limit_min[$i]) * 1);
      }
    } else if ($type[$i] == "cost") {
      for ($j = 0; $j < $n_alternatif * $n_kriteria; $j += $n_kriteria) {
        $index = $j + $i;
        $value[$index] = (($limit_max[$i] - $value[$index]) / ($limit_max[$i] - $limit_min[$i]) * 1);
      }
    }

    // Nilai akhir
    for ($j = 0; $j < $n_alternatif * $n_kriteria; $j += $n_kriteria) {
      $index = $j + $i;
      $value[$index] *= $nw[$i];
    }
  }

  // Hasil nilai akhir
  $result = array();
  for ($i = 0; $i < $n_alternatif; $i++) {
    $row = 0;
    for ($j = 0; $j < $n_kriteria; $j++) {
      $index = $j + ($i * $n_kriteria);
      $row += $value[$index];
    }
    // $result[] = $row;
    $Q[$i] = $row;
  }

  // Mengurutkan berdasarkan nilai terbesar
  for ($i = 0; $i < $n_alternatif; $i++) {
    $Q[$i] = array($Q[$i], $alternatif[$i], $id_alternatif[$i]);
  }
  sort($Q);


  // -------------------------------------------------------------------------------
  // -rumus untuk matriks keputusan
  //-- inisialisasi variabel array id_alternatif+alternatif untuk matriks keputusan
  $alternatif1 = array();
  $sql = 'SELECT * FROM tab_alternatif';
  $data = $conn->query($sql);
  while ($row = $data->fetch_object()) {
    $alternatif1[$row->id_alternatif] = $row->nama_alternatif;
  }
  //-- inisialisasi variabel array id_kriteria+kriteria untuk matriks keputusan
  $kriteria1 = array();
  $sql = 'SELECT * FROM tab_kriteria';
  $data = $conn->query($sql);
  while ($row = $data->fetch_object()) {
    $kriteria1[$row->id_kriteria] = array($row->nama_kriteria, $row->attribute);
  }
  //-- ambil nilai dari tabel_nilai untuk matriks keputusan
  $nilai1 = array();
  $sql = 'SELECT * FROM tab_evaluation ORDER BY id_alternatif, id_kriteria';
  $data = $conn->query($sql);
  while ($row = $data->fetch_object()) {
    $i = $row->id_alternatif;
    $j = $row->id_kriteria;
    $aij = $row->nilai;

    $nilai1[$i][$j] = $aij;
  }

?>

  <div class="col" role="main">
    <div class="">
      <div class="clearfix"></div>
      <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
            <div class="x_title" style="text-transform: capitalize;">
              <h2> <b>Data <?php echo $_GET['module']; ?></b> <small></small></h2>
              <div class="clearfix"></div>
            </div> <br>

            <div class="x_content">

              <!-- matrik keputusan -->
              <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab"><b>Matriks Keputusan</b></a></li>
              </ul>
              <div class="panel panel-default">
                <div class="panel-heading">
                  <h4>Menampilkan Data Matriks Keputusan</h4>
                  <p>Matriks keputusan merupakan kumpulan data kriteria, dan alternatif yang disusun dalam bentuk tabel matriks</p>
                </div>
                <div class="panel-body">

                  <p class="text-left">Tabel data matriks keputusan</p>

                  <table id="datatable" class="table table-striped table-bordered table-hover">
                    <thead>
                      <!-- row1 -->
                      <tr>
                        <th colspan="2" class="text-center">Kategori</th>
                        <?php for ($i = 0; $i < $n_kriteria; $i++) { ?>
                          <th class="text-center"><?= $type[$i]; ?></th>
                        <?php } ?>
                      </tr>
                      <!-- row1 -->
                      <!-- row2 -->
                      <tr>
                        <th colspan="2" class="text-center">Bobot</th>
                        <?php for ($i = 0; $i < $n_kriteria; $i++) { ?>
                          <th class="text-center"><?= $w[$i]; ?></th>
                        <?php } ?>
                      </tr>
                      <!-- row2 -->
                      <!-- row3 -->
                      <tr>
                        <th class="text-center" style="width: 20px;">No.</th>
                        <th class="text-center">Alternatif</th>
                        <?php for ($i = 0; $i < $n_kriteria; $i++) { ?>
                          <th class="text-center"><?= $id_kriteria[$i] . "<br> (" . $kriteria[$i] . ")"; ?></th>
                        <?php } ?>
                      </tr>
                      <!-- row3 -->
                    </thead>
                    <tbody>
                      <?php
                      $no = 0;
                      foreach ($alternatif1 as $key => $values) :
                        $no++;
                      ?>
                        <tr style="text-align:center;">
                          <td><?= $no; ?></td>
                          <td><?= $values; ?></td>
                          <?php foreach ($kriteria1 as $key2 => $values2) :  ?>
                            <td><?= @$nilai1[$key][$key2]; ?></td>
                          <?php endforeach ?>
                        </tr>
                      <?php endforeach ?>
                    </tbody>
                  </table>
                </div>
              </div>
              <!-- matrik keputusan -->

              <!-- Matriks normalisasi -->
              <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab"><b>Matriks Normalisasi</b></a></li>
              </ul>
              <div class="panel panel-default">
                <div class="panel-heading">
                  <h4>Menampilkan Data Matriks Hasil Normalisasi</h4>
                  <p>Matriks hasil normalisasi memuat hasil perhitungan normalisasi dari data matriks keputusan</p>
                </div>
                <div class="panel-body">

                  <p class="text-left">Tabel data normalisasi</p>

                  <table id="datatable" class="table table-striped table-bordered table-hover">
                    <thead>
                      <tr>
                        <th rowspan="3" class="text-center" style="width: 20px;">No.</th>
                        <th class="text-center">Kategori</th>
                        <?php for ($i = 0; $i < $n_kriteria; $i++) { ?>
                          <th class="text-center"><?= $type[$i]; ?></th>
                        <?php } ?>
                      </tr>
                      <tr>
                        <th class="text-center">Bobot</th>
                        <?php for ($i = 0; $i < $n_kriteria; $i++) { ?>
                          <th class="text-center"><?= round($nw[$i], 2); ?></th>
                        <?php } ?>
                      </tr>
                      <tr>
                        <th class="text-center">Nama </th>
                        <?php for ($i = 0; $i < $n_kriteria; $i++) { ?>
                          <th class="text-center"><?= $id_kriteria[$i] . "<br> (" . $kriteria[$i] . ")"; ?></th>
                        <?php } ?>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $no = 0;
                      for ($i = 0; $i < $n_alternatif; $i++) {
                        $no++;
                      ?>
                        <tr style="text-align:center;">
                          <td><?= $no; ?></td>
                          <td><?= $alternatif[$i]; ?></td>
                          <?php
                          for ($j = 0; $j < $n_kriteria; $j++) {
                            $index = $j + ($i * $n_kriteria);
                          ?>
                            <td><?= round($value[$index], 3); ?></td>
                          <?php } ?>
                        </tr>
                      <?php } ?>
                    </tbody>
                  </table>
                </div>
              </div>
              <!-- Matriks normalisasi -->

              <!-- WSM,WPM,Qi -->
              <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab"><b>Nilai Akhir & Ranking</b></a></li>
              </ul>
              <div class="panel panel-default">
                <div class="panel-heading">
                  <h4>Menampilkan Data Hasil Nilai Akhir</h4>
                  <p>Data alternatif dengan nilai utilitas (Qi) terbesar merupakan <b> Alternatif Terbaik </b></p>
                </div>
                <div class="panel-body">

                  <?php for ($i = $n_subject - 1; $i >= $n_subject - 1; $i--) { ?>
                    <p>Dari hasil perhitungan dipilih <b> <?php echo $Q[$i][1] ?></b> sebagai Alternatif Terbaik dengan <b>nilai utilitas (Qi)</b> sebesar <b><?php echo round($Q[$i][0], 3); ?></b>.</p><br>
                  <?php } ?>

                  <table id="datatable" class="table table-striped table-bordered table-hover">
                    <thead>
                      <tr>
                        <th class="text-center">No.</th>
                        <th class="text-center">ID Alternatif</th>
                        <th class="text-center">Nama Alternatif</th>
                        <th class="text-center">Nilai Akhir</th>
                        <th class="text-center">Rangking</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $no = 0;
                      for ($i = $n_alternatif - 1; $i >= 0; $i--) {
                        $no++;
                      ?>
                        <tr style="text-align:center;">
                          <td><?= $no;  ?></td>
                          <td><?php echo $Q[$i][2]; ?></td>
                          <td><?php echo $Q[$i][1]; ?></td>
                          <td><?php echo round($Q[$i][0], 3); ?></td>
                          <td><?php echo $n_alternatif - $i; ?></td>
                        </tr>
                      <?php } ?>
                    </tbody>
                  </table>
                </div>
              </div>
              <!-- WSM,WPM,QI -->

              <!-- button cetak pdf -->
              <!-- <?php if ($_SESSION['leveluser'] == 'admin') { ?>
  <a  class="btn btn-success btn-sm" href="component/com_perhitungan/print.php" style="width: 15%;"><i class="glyphicon glyphicon-print"></i> Cetak PDF</a>
<?php } ?> -->
              <!-- button cetak pdf -->


            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php } ?>