<?php
include '../../config/conn.php';

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
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cetak PDF</title>
</head>

<body>
  <table border="0" cellpadding="4" style="text-align:center;">
    <thead>
      <tr>
        <td style="font-size: 14px;"><b>Laporan Data Kelayakan Kendaraan Pada DB TRANS</b></td>
      </tr>
    </thead>
  </table>

  <br> <br>

  <table border="1" cellpadding="5" style="text-align:center;">
    <thead>
      <tr>
        <th colspan="6">
          <h2>Menampilkan Data Hasil Nilai Akhir</h2>
          <?php for ($i = $n_alternatif - 1; $i >= $n_alternatif - 1; $i--) { ?>
            <text>Dari hasil perhitungan dipilih <b> <?php echo $Q[$i][1] ?></b> sebagai alternatif Terbaik dengan <b>nilai akhir</b> sebesar <b><?php echo round($Q[$i][0], 3); ?></b>.</text><br>
          <?php } ?>
        </th>
      </tr>
      <tr>
        <th width="25px">No.</th>
        <th width="80px">ID Alternatif</th>
        <th width="118px">Nama Alternatif</th>
        <th width="110px">Nilai Akhir</th>
        <th>Ranking</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $no = 0;
      for ($i = $n_alternatif - 1; $i >= 0; $i--) {
        $no++;
      ?>
        <tr style="text-align:center;">
          <td width="25px"><?= $no;  ?></td>
          <td width="80px"><?php echo $Q[$i][2]; ?></td>
          <td width="118px"><?php echo $Q[$i][1]; ?></td>
          <td width="110px"><?php echo round($Q[$i][0], 3); ?></td>
          <td><?php echo $n_alternatif - $i; ?></td>
        </tr>
      <?php } ?>
    </tbody>
  </table>

  <br> <br> <br> <br>
  <table style=" text-align: right;">
    <tr>
      <td>
        <p>Kudus, <?php echo date("d-m-Y"); ?></p>
        <text>Penanggung jawab</text>
      </td>
    </tr>
    <br> <br> <br> <br>
    <tr>
      <td>
        <p>Admin Staff DB TRANS</p>
      </td>
    </tr>
  </table>

</body>

</html>