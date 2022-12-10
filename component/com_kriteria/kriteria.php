<?php
include '../../config/conn.php';
if ($_GET['aksi'] == '') {
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
            </div>

            <?php if ($_SESSION['leveluser'] == 'admin') { ?>
              <a class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalAdd"><i class="glyphicon glyphicon-plus"></i> Tambah</a>
            <?php } ?>

            <div class="x_content">
              <table id="datatable" class="table table-striped table-bordered">
                <thead>
                  <tr>
                    <th class="text-center" width="10">No</th>
                    <th class="text-center" width="80">ID Kriteria</th>
                    <th class="text-center">Jenis Kriteria</th>
                    <th class="text-center">attribute</th>
                    <th class="text-center">Bobot</th>

                    <?php if ($_SESSION['leveluser'] == 'admin') { ?>
                      <th class="text-center" width="130">Aksi</th>
                    <?php } ?>
                  </tr>
                </thead>

                <tbody>
                  <?php
                  $no = 0;
                  $query = mysqli_query($conn, "SELECT * FROM tab_kriteria");
                  while ($row = mysqli_fetch_assoc($query)) {
                    $no++;
                  ?>
                    <tr>
                      <td><?php echo $no; ?></td>
                      <td><?php echo $row['id_kriteria']; ?></td>
                      <td class="text-left"><?php echo $row['nama_kriteria']; ?></td>
                      <td><?php echo $row['attribute']; ?></td>
                      <td><?php echo $row['bobot']; ?></td>

                      <?php if ($_SESSION['leveluser'] == 'admin') { ?>
                        <td style="text-align: center;">

                          <a class="btn btn-warning  btn-xs" data-toggle="modal" data-target="#modalAdd<?php echo $row['id_kriteria']; ?>"><i class="glyphicon glyphicon-edit"></i> Edit</a>

                          <a class="btn  btn-danger btn-xs" onclick="confirm_modal('?module=<?php echo $_GET['module']; ?>&aksi=hapus&id=<?php echo encrypt($row[id_kriteria]); ?>');"><i class="glyphicon glyphicon-trash"></i> Hapus</a>
                        </td>
                      <?php } ?>
                    </tr>
                    <!-- edit data     -->
                    <div class="modal fade" id="modalAdd<?php echo $row['id_kriteria']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">Edit Data <?php echo $_GET['module']; ?></h4>
                          </div>

                          <div class="modal-body">
                            <form role="form" action="?module=kriteria&aksi=simpan_edit" enctype="multipart/form-data" method="POST">

                              <?php
                              $id = $row['id_kriteria'];
                              $query_edit = mysqli_query($conn, "SELECT * FROM tab_kriteria WHERE id_kriteria='$id'");
                              while ($r = mysqli_fetch_array($query_edit)) {
                              ?>
                                <label for="id_kriteria">ID kriteria * :</label>
                                <input type="text" class="form-control" disabled value="<?php echo $r['id_kriteria']; ?>" />
                                <input type="hidden" class="form-control" name="id_kriteria" value="<?php echo $r['id_kriteria']; ?>" />

                                <label for="nama_kriteria">Kriteria * :</label>
                                <input type="text" class="form-control" name="nama_kriteria" value="<?php echo $r['nama_kriteria']; ?>" />

                                <label for="attribute">attribute * :</label>
                                <select name="attribute" class="form-control custom-select" value="<?php echo $r['attribute']; ?>">
                                  <option value="<?php echo $r['attribute']; ?>" selected>----Pilih ulang attribute----</option>
                                  <option value="benefit">Benefit</option>
                                  <option value="cost">Cost</option>
                                </select>
                                <input type="text" disabled class="form-control" name="attribute" value="<?php echo $r['attribute']; ?>" />

                                <label for="bobot">Bobot * :</label>
                                <input type="text" class="form-control bobot" name="bobot" value="<?php echo $r['bobot']; ?>" />

                                <script>
                                  $(".bobot").on("keyup", function() {
                                    var valid = /^d{0,15}(.d{0,2})?$/.test(this.value),
                                      al = this.value;
                                    if (!valid) {
                                      console.log("Invalid input!");
                                      this.value = val.substring(0, val.length - 1);
                                    }
                                  });
                                </script>


                                <div class="modal-footer">
                                  <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Batal</button>
                                  <button type="submit" class="btn btn-success btn-sm">Simpan</button>
                                </div>
                              <?php } ?>
                            </form>
                          </div>
                        </div>
                      </div>
                      <!-- edit data -->
                    <?php } ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- tambah data -->
  <div class="modal fade" id="modalAdd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title text-center" id="myModalLabel">Tambah Data <?php echo $_GET['module']; ?></h4>
        </div>

        <div class="modal-body">
          <form action="?module=<?php echo $_GET['module']; ?>&aksi=simpan" enctype="multipart/form-data" method="POST">
            <?php
            $query = "SELECT max(id_kriteria) as maxID FROM tab_kriteria ";
            $hasil = mysqli_query($conn, $query);
            $data = @mysqli_fetch_array($hasil);
            $idMax = $data['maxID'];

            $noUrut = (int) substr($idMax, 1, 9);
            $noUrut++;
            $char = "C";
            $newID = $char . sprintf("%01s", $noUrut);

            ?>
            <label for="id_kriteria">ID Kriteria * :</label>
            <input type="text" class="form-control" disabled value="<?php echo $newID; ?>" />
            <input type="hidden" class="form-control" name="id_kriteria" value="<?php echo $newID; ?>" />

            <label for="kriteria">Kriteria * :</label>
            <input type="text" class="form-control" autocomplete="off" name="nama_kriteria" placeholder="Jenis kriteria" required />

            <label for="attribute">attribute * :</label>
            <select name="attribute" class="form-control custom-select">
              <option value="" selected>----Pilih ulang attribute----</option>
              <option value="benefit">Benefit</option>
              <option value="cost">Cost</option>
            </select>
            <input type="text" disabled class="form-control" name="attribute" value="<?php echo $r['attribute']; ?>" />

            <label for="bobot">Bobot * :</label>
            <input type="text" class="form-control bobot" autocomplete="off" name="bobot" placeholder="Jumlah Bobot" required />

            <br>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-success btn-sm">Simpan</button>
        </div>
        </form>
      </div>
    </div>
  </div>
  <!-- tambah data -->

<?php } elseif ($_GET['aksi'] == 'simpan') {
  $module = $_GET['module'];
  mysqli_query($conn, "INSERT INTO tab_kriteria(id_kriteria,
                                  nama_kriteria,
                                  attribute,
                                  bobot) VALUES('$_POST[id_kriteria]',
                                                 '$_POST[nama_kriteria]',
                                                 '$_POST[attribute]',
                                                 '$_POST[bobot]')");

  echo "<script language='javascript'>document.location='?module=" . $module . "';</script>";
} elseif ($_GET['aksi'] == 'simpan_edit') {
  $module = $_GET['module'];
  $password   = md5($_POST[password]);
  if (empty($_POST['password'])) {
    mysqli_query($conn, "UPDATE tab_kriteria SET nama_kriteria = '$_POST[nama_kriteria]',
                                    attribute = '$_POST[attribute]',
                                    bobot = '$_POST[bobot]' 
                                    WHERE id_kriteria = '$_POST[id_kriteria]'");
  } else {

    mysqli_query($conn, "UPDATE tab_kriteria SET nama_kriteria = '$_POST[nama_kriteria]',
                                    attribute = '$_POST[attribute]',
                                    password = '$password',
                                    bobot = '$_POST[bobot]'
                                    WHERE id_kriteria = '$_POST[id_kriteria]'");
  }
  echo "<script language='javascript'>document.location='?module=" . $module . "';</script>";
} elseif ($_GET['aksi'] == 'hapus') {
  $module = $_GET['module'];
  $idd = $_GET[id];
  $id = decrypt($idd);
  $query = mysqli_query($conn, "DELETE FROM tab_kriteria WHERE id_kriteria='$id'");
  echo "<script language='javascript'>document.location='?module=" . $module . "';</script>";
} ?>

<div class="modal fade" id="modal_delete">
  <div class="modal-dialog">
    <div class="modal-content" style="margin-top:100px;">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" style="text-align:center;">Apakah anda yakin menghapus data ini ?</h4>
      </div>

      <div class="modal-footer" style="margin:0px; border-top:0px; text-align:center;">
        <a href="#" class="btn btn-danger btn-sm" id="delete_link">Hapus</a>
        <button type="button" class="btn btn-success btn-sm" data-dismiss="modal">Batal</button>
      </div>
    </div>
  </div>
</div>