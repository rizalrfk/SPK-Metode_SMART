 <?php session_start();?>
            <div id="sidebar-menu" class="main_menu_side main_menu" style=" /*border: 2px solid yellow*/;">
              <div class="menu_section" style=" /*border: 2px solid blue*/;">

                <ul class="nav side-menu">
                  <?php if ($_SESSION['leveluser'] == 'admin'){ ?>
                  <li><a href="?module="><i class="fa fa-home"></i>Beranda </a></li>
                  <?php }?>
                  <?php if ($_SESSION['leveluser'] == 'user'){ ?>
                  <li><a href="?module="><i class="fa fa-home"></i>Beranda </a></li>
                  <?php }?>

                  <?php if ($_SESSION['leveluser'] == 'admin'){ ?>
                  <li ><a><i class="fa fa-book"></i>Data<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="?module=kriteria">Data Kriteria</a></li>
                      <li><a href="?module=alternatif">Data Alternatif</a></li>
                      <li><a href="?module=nilai">Data Nilai</a></li>
                    </ul>
                  </li>
                  <?php } ?>

                  <li><a><i class="fa fa-calculator"></i>Hasil<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="?module=perhitungan">Perhitungan</a></li>
                  <?php if ($_SESSION['leveluser'] == 'admin'){ ?>
                      <li><a href="component/com_perhitungan/print.php">Cetak PDF</a></li>
                      <!-- <li><a href="component/com_perhitungan/cetak.php">Cetak PDF</a></li> -->
                  <?php } ?>
                    </ul>
                  </li>

                  <?php if ($_SESSION['leveluser'] == 'admin'){ ?>
                  <li><a><i class="fa fa-cog"></i>Setting<span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="?module=pegawai">Data Akun</a></li>
                    </ul>
                  </li>
                  <?php }?>

                  <li><a href="logout.php"><i class="fa fa-sign-out"></i>Keluar</a></li>
              </ul>
              </div>
            </div>
