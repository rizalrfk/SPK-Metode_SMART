<?php
  error_reporting(0);
  include "../../config/conn.php";
  $id_pegawai= $_GET['id_pegawai'];
  $query=mysqli_query($conn,"SELECT * FROM pegawai WHERE id_pegawai='$id_pegawai'");
  $r=mysqli_fetch_array($query);

  $aksi = "component/com_pegawai/pegawai_aksi.php";
?>
<div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Edit Data</h4>
      </div>
      <div class="modal-body">
      <!-- start form for validation -->
      <form action="<?php echo $aksi;?>?module=pegawai&act=edit"  enctype="multipart/form-data" method="POST">
                      <label for="id">ID Pegawai :</label>
                      <input type="text"  class="form-control" disabled value="<?php echo $r['id_pegawai'];?>"  />
                      <input type="hidden"  class="form-control" name="id" value="<?php echo $r['id_pegawai'];?>"  />

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
                            <?php if ($row[level] == '1'){?>
                            <option value=1 selected >User</option>
                            <option value=2 >Admin</option>
                            <?php }else{?>
                            <option value=1  >User</option>
                            <option value=2 selected>Admin</option>
                            <?php }?>
                        </select>

                      <label>Status :</label>
                      <select id="heard" class="form-control" required name="status">
                            <?php if ($row[level] == 'Y'){?>
                            <option value=Y selected >Aktif</option>
                            <option value=T >Tidak Aktif</option>
                             <?php }else{?>
                            <option value=Y  >Aktif</option>
                            <option value=T selected >Tidak Aktif</option>
                             <?php }?>
                      </select>
                      <br>
                      
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-success btn-sm">Simpan</button>
      </div>
      </form>

      <!-- end form for validations --> 
    </div>
  </div>

