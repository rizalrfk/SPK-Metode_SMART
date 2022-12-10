<!-- page content -->
<div class="col" role="main">
  <div class="">
    <div class="clearfix"></div>

    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">

        <div class="x_panel">
          <div class="x_title" style="text-transform: capitalize;">
            <h4>Selamat datang, <?php echo $_SESSION['namalengkap']; ?></h4>
            <div class="clearfix"></div>
          </div>

          <!-- table kolom -->
          <div class="x_content" style="/*border: 2px solid red*/;">
            <?php if ($_SESSION['leveluser'] == 'admin') { ?>
              <h3>ALUR SISTEM PENDUKUNG KEPUTUSAN <br> Menentukan Kendaraan layak jalan dengan Metode SMART</h3>
            <?php } ?>
            <?php if ($_SESSION['leveluser'] == 'user') { ?>
              <h3 style="color: #363535;">SISTEM PENDUKUNG KEPUTUSAN <br> Menentukan Kendaraan layak jalan dengan Metode SMART</h3>
            <?php } ?>

            <div class="divider-dashed"></div>
            <div class="y_content">
              <?php if ($_SESSION['leveluser'] == 'admin') { ?>

                <div style=" margin-left: 15%; width: 70%;">
                  <br>
                  <h5 style="color: #363535;">
                    SISTEM PENDUKUNG KEPUTUSAN KELAYAKAN ARMADA BUS MENGGUNAKAN METODE SMART adalah sistem yang dibuat untuk kelayakan armada bus dengan tujuan agar mempermudah pihak pengelola dalam memanajemen bus yang layak jalan demi meningkatkan pelayanan hingga kenyaman pelanggan</>
                  </h5>
                  <!-- <img src="build/images/beranda_admin.png" alt="img_error in home.php/30"> -->
                  <img src="media/img.jpg" alt="img_error in home.php/31">
                </div>
              <?php } ?>

              <?php if ($_SESSION['leveluser'] == 'user') { ?>

                <div style=" margin-left: 15%; width: 70%;">
                  <br>
                  <h5 style="color: #363535;">
                    SISTEM PENDUKUNG KEPUTUSAN KELAYAKAN ARMADA BUS MENGGUNAKAN METODE SMART adalah sistem yang dibuat untuk kelayakan armada bus dengan tujuan agar mempermudah pihak pengelola dalam memanajemen bus yang layak jalan demi meningkatkan pelayanan hingga kenyaman pelanggan</>
                  </h5>
                  <!-- <img src="build/images/beranda_admin.png" alt="img_error in home.php/30"> -->
                  <img src="media/img.jpg" alt="img_error in home.php/31">
                </div>
              <?php } ?>
            </div>
          </div>
        </div>

      </div>
    </div>

  </div>
</div>
<!-- /page content -->