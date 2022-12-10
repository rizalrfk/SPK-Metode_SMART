<?php
include '../../config/conn.php';
if ($_GET['aksi'] == '') { ?>
  <div class="col" role="main">
    <div class="">
      <div class="clearfix"></div>
      <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
            <div class="x_title" style="text-transform: capitalize;">
              <h2> <b>Data <?php echo $_GET['module']; ?></b> <small></small></h2>
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
                    <th class="text-center" width="80">ID alternatif</th>
                    <th class="text-center">Nama Alternatif</th>

                    <?php if ($_SESSION['leveluser'] == 'admin') { ?>
                      <th class="text-center" width="130">Aksi</th>
                    <?php } ?>
                  </tr>
                </thead>

                <tbody>
                  <?php
                  $no = 0;
                  $query = mysqli_query($conn, "SELECT * FROM tab_alternatif");
                  while ($row = mysqli_fetch_assoc($query)) {
                    $no++;
                  ?>
                    <tr>
                      <td><?php echo $no; ?></td>
                      <td><?php echo $row['id_alternatif']; ?></td>
                      <td class="text-left"><?php echo $row['nama_alternatif']; ?></td>


                      <?php if ($_SESSION['leveluser'] == 'admin') { ?>
                        <td style="text-align: center;">
                          <a class="btn btn-warning  btn-xs" data-toggle="modal" data-target="#modalEdit<?php echo $row['id_alternatif']; ?>"><i class="glyphicon glyphicon-edit"></i> Edit</a>

                          <a class="btn  btn-danger btn-xs" onclick="confirm_modal('?module=<?php echo $_GET['module']; ?>&aksi=hapus&id=<?php echo encrypt($row[id_alternatif]); ?>');"><i class="glyphicon glyphicon-trash"></i> Hapus</a>
                        </td>
                      <?php } ?>
                    </tr>
                    <!-- edit data     -->
                    <div class="modal fade" id="modalEdit<?php echo $row['id_alternatif']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">Edit Data <?php echo $_GET['module']; ?></h4>
                          </div>

                          <div class="modal-body text-left">
                            <form role="form" action="?module=<?php echo $_GET['module']; ?>&aksi=simpan_edit" enctype="multipart/form-data" method="POST">

                              <?php
                              $id = $row['id_alternatif'];
                              $query_edit = mysqli_query($conn, "SELECT * FROM tab_alternatif WHERE id_alternatif='$id'");
                              while ($r = mysqli_fetch_array($query_edit)) {
                              ?>
                                <label for="id_alternatif">ID alternatif * :</label>
                                <input type="text" class="form-control" disabled value="<?php echo $r['id_alternatif']; ?>" />
                                <input type="hidden" class="form-control" name="id_alternatif" value="<?php echo $r['id_alternatif']; ?>" />

                                <label for="alternatif">alternatif * :</label>
                                <input type="text" class="form-control" name="nama_alternatif" value="<?php echo $r['nama_alternatif']; ?>" />

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

  <!-- Tambah data -->
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
            $query = "SELECT max(id_alternatif) as maxID FROM tab_alternatif ";
            $hasil = mysqli_query($conn, $query);
            $data = @mysqli_fetch_array($hasil);
            $idMax = $data['maxID'];

            $noUrut = (int) substr($idMax, 1, 9);
            $noUrut++;
            $char = "A";
            $newID = $char . sprintf("%02s", $noUrut);

            ?>
            <label for="id_alternatif">ID Alternatif * :</label>
            <input type="text" class="form-control" disabled value="<?php echo $newID; ?>" />
            <input type="hidden" class="form-control" name="id_alternatif" value="<?php echo $newID; ?>" />

            <label for="nama_alternatif">Alternatif * :</label>
            <input type="text" class="form-control" autocomplete="off" name="nama_alternatif" placeholder="Nama Alternatif" required />

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

<?php } elseif ($_GET['aksi'] == 'simpan') {
  $module = $_GET['module'];
  mysqli_query($conn, "INSERT INTO tab_alternatif(id_alternatif,
                                  nama_alternatif) VALUES ('$_POST[id_alternatif]',
                                                 '$_POST[nama_alternatif]')");
  echo "<script language='javascript'>document.location='?module=" . $module . "';</script>";
  
} elseif ($_GET['aksi'] == 'simpan_edit') {
  $module = $_GET['module'];
  $password   = md5($_POST['password']);
  if (empty($_POST['password'])) {
    mysqli_query($conn, "UPDATE tab_alternatif SET nama_alternatif = '$_POST[nama_alternatif]'
                                    WHERE id_alternatif = '$_POST[id_alternatif]'");
  } else {

    mysqli_query($conn, "UPDATE tab_alternatif SET nama_alternatif = '$_POST[nama_alternatif]',
                                    password = '$password'
                                    WHERE id_alternatif = '$_POST[id_alternatif]'");
  }
  echo "<script language='javascript'>document.location='?module=" . $module . "';</script>";

} elseif ($_GET['aksi'] == 'hapus') {
  $module = $_GET['module'];
  $idd = $_GET[id];
  $id = decrypt($idd);
  $query = mysqli_query($conn, "DELETE FROM tab_alternatif WHERE id_alternatif='$id'");
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