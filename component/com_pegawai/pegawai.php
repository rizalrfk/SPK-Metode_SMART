<?php 
include '../../config/conn.php';
$aksi = "component/com_pegawai/pegawai_aksi.php";
if ($_GET['aksi']==''){
?>
        <div class="col" role="main">
          <div class="">
            <div class="clearfix"></div>
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title" style="text-transform: capitalize;">
                    <h2 >Data Akun <small></small></h2>
                    <div class="clearfix"></div>
                  </div>
                  <a  class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalAdd"><i class="glyphicon glyphicon-plus"></i>Tambah</a>
                  <!-- <div class="divider-dashed"></div> -->
                  <div class="x_content">
                    
                    <table id="datatable" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th class="text-center" width="10">No</th>
                          <th class="text-center">ID Akun</th>
                          <th class="text-center">Nama</th>
                          <th class="text-center">Level</th>
                          <th class="text-center" width="50">Aksi</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php 
                          $no = 0;
                          $query=mysqli_query($conn,"SELECT * FROM user ORDER BY id asc");
                          while($row=mysqli_fetch_array($query)){
                          $no++;
                      ?>
                        <tr>
                          <td><?php echo $no;?></td>
                          <td><?php echo $row['id'];?></td>
                          <td><?php echo $row['nama'];?></td>
                          <td><?php echo $row['level'];?></td>
                          <td>
                            <a  class="btn btn-warning  btn-xs" data-toggle="modal" data-target="#modalEdit<?php echo $row['id']; ?>"><i class="glyphicon glyphicon-edit"></i> Edit</a>
                               <!-- <a class="btn  btn-danger btn-xs"  onclick="confirm_modal('?module=<?php echo $_GET['module'];?>&aksi=hapus&id=<?php echo encrypt($row[id]);?>');"><i class="glyphicon glyphicon-trash"></i> Hapus</a> -->
                          </td>
                        </tr>
<!-- edit -->
  <div class="modal fade" id="modalEdit<?php echo $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Edit Data Akun</h4>
      </div>

      <div class="modal-body text-left">
      <form role="form" action="?module=user&aksi=simpan_edit"  enctype="multipart/form-data" method="POST">

      <?php 
        $id = $row['id'];
        $query_edit=mysqli_query($conn,"SELECT * FROM user WHERE id='$id'");
        while($r=mysqli_fetch_array($query_edit)){
      ?>
          <label for="id">ID Pegawai :</label>
          <input type="text"  class="form-control" disabled value="<?php echo $r['id'];?>"  />
          <input type="hidden"  class="form-control" name="id" value="<?php echo $r['id'];?>"  />

          <label for="nama">Nama :</label>
          <input type="text"  class="form-control" name="nama"  value="<?php echo $r['nama'];?>" />

          <label for="username">Username :</label>
          <input type="text"  class="form-control"  value="<?php echo $r['username'];?>" disabled />
          <input type="hidden"  class="form-control" name="username" value="<?php echo $r['username'];?>" />

          <label for="password">Password :</label>
          <input type="password"  class="form-control"  value="<?php echo $r['password'];?>" disabled  />

          <label for="password">Ganti Password :</label>
          <input type="password"  class="form-control" name="password"    />
          <p>*) Kosongkan apabila password tidak diganti</p>

          <label for="heard">Level :</label>
            <select id="heard" class="form-control" required name="level">
                <?php if ($r[level] == 'user'){?>
                <option value='user' selected >User</option>
                <option value='admin' >Admin</option>
                <?php }else{?>
                <option value='user'  >User</option>
                <option value='admin' selected>Admin</option>
                <?php }?>
            </select>

          <label>Status :</label>
          <select id="heard" class="form-control" required name="status">
                <?php if ($r[status] == 'Y'){?>
                <option value=Y selected >Aktif</option>
                <option value=N >Tidak Aktif</option>
                 <?php }else{?>
                <option value=Y  >Aktif</option>
                <option value=N selected >Tidak Aktif</option>
                 <?php }?>
          </select>
 
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

<!-- Modal -->
<div class="modal fade" id="modalAdd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title text-center" id="myModalLabel">Tambah Data Akun</h4>
      </div>
      <div class="modal-body text-left">
      <!-- start form for validation -->
      <form action="?module=<?php echo $_GET['module'];?>&aksi=simpan"  enctype="multipart/form-data" method="POST">
        <?php
          $query = "SELECT max(id) as maxID FROM user ";
          $hasil = mysqli_query($conn,$query);
          $data = @mysqli_fetch_array($hasil);
          $idMax = $data['maxID'];

          $noUrut = (int) substr($idMax, 1, 9);
          $noUrut++;
          $char = "P";
          $newID = $char.sprintf("%04s", $noUrut); 
        ?>
          <label for="id">ID Username * :</label>
          <input type="text"  class="form-control" disabled value="<?php echo $newID;?>"  />
          <input type="hidden"  class="form-control" name="id" value="<?php echo $newID;?>"  />

          <label for="nama">Nama * :</label>
          <input type="text"  class="form-control" name="nama" autocomplete="off" required />

          <label for="username">Username * :</label>
          <input type="text"  class="form-control" name="username" autocomplete="off"  required />

          <label for="password">Password * :</label>
          <input type="password"  class="form-control" name="password" autocomplete="off"  required />

          <label for="heard">Level *:</label>
            <select id="heard" class="form-control" required name="level">
                <option value="">- Pilih Level -</option>
                <option value="user">User</option>
                <option value="admin">Admin</option>
            </select>

          <label>Status *:</label>
          <select id="heard" class="form-control" required autocomplete="off"  name="status">
                <option value="">- Pilih Status -</option>
                <option value="Y">Aktif</option>
                <option value="N">Tidak Aktif</option>
          </select>
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


<?php } elseif ($_GET['aksi'] == 'simpan_edit'){
  $module = $_GET['module'];
  $password   = $_POST[password];
  if (empty($_POST['password'])) {
      mysqli_query($conn,"UPDATE user SET nama = '$_POST[nama]',
                                    username = '$_POST[username]',
                                    level = '$_POST[level]',
                                    status = '$_POST[status]' 
                                    WHERE id = '$_POST[id]'");

    }else{
      mysqli_query($conn,"UPDATE user SET nama = '$_POST[nama]',
                                    username = '$_POST[username]',
                                    password = '$password',
                                    level = '$_POST[level]',
                                    status = '$_POST[status]' 
                                    WHERE id = '$_POST[id]'");  
    }  
      echo "<script language='javascript'>document.location='?module=".$module."';</script>";

} elseif ($_GET['aksi'] == 'simpan'){
    $module = $_GET['module']; 
    $password = $_POST[password];  
    mysqli_query($conn,"INSERT INTO user(id,
                                  nama,
                                  username,
                                  password,
                                  level,
                                  status) VALUES('$_POST[id]',
                                                 '$_POST[nama]',
                                                 '$_POST[username]',
                                                 '$password',
                                                 '$_POST[level]',
                                                 '$_POST[status]')");

    echo "<script language='javascript'>document.location='?module=".$module."';</script>";

} elseif ($_GET['aksi'] == 'hapus'){
    $module = $_GET['module'];  
    $idd= $_GET[id];
    $id = decrypt($idd);
    $query=mysqli_query($conn,"Delete FROM user WHERE id='$id'");
    echo "<script language='javascript'>document.location='?module=".$module."';</script>";
}
?>

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


