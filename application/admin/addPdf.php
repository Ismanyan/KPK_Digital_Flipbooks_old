<?php
    require "../config/connection.php";
    if(!isset($_SESSION['login'])) {
        header("Location: ./login.php");
        exit;
    }
    $kategori = query("SELECT * FROM kategori");
    $sub_kategori = query("SELECT * FROM sub_kategori");



?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <title>Buku Antikorupsi | List Buku</title>
    <!-- favicon  -->
    <link rel="shortcut icon" href="../images/Logo KPK/favicon.png">

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <!-- icon -->
    <link rel="stylesheet" href="../css/fontawesome/css/all.min.css">
    <style media="screen">
      body{
        background-color: #f8f9fa;
      }
    </style>
  </head>
  <body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
      <div class="container">
        <a class="navbar-brand" href="#">
          <img src="../images/logo.png" alt="KPK Logo" width="150">
        </a>
        <div class="collapse navbar-collapse">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item mx-4">
              <a class="nav-link text-dark" href="admin_kontak.php">Pesan</a>
            </li>
            <li class="nav-item mx-4 ">
              <a class="nav-link text-dark" href="admin_buku.php">Daftar Buku</a>
            </li>
            <li class="nav-item mx-4 ">
              <a class="nav-link text-dark" href="logout.php">Logout</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <!-- End Of Navbar -->

    <!-- Nav -->
    <div class="container mt-5">
      <div class="card">
        <ul class="nav">
          <li class="nav-item">
            <a class="nav-link active" href="admin_buku.php"><i class="fas fa-arrow-left"></i></a>
          </li>
        </ul>
      </div>
    </div>
    <!-- End Nav -->

    <!-- Progress -->
    <div class="container">
      <div class="progress mb-3 mt-5" style="display:none;">
        <div id="progressBar" class="progress-bar progress-bar-striped bg-danger" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
          <span class="sr-only">0%</span>
        </div>
      </div>
      <div class="msg alert alert-info text-left" style="display:none;"></div>
    </div>
    <!-- End Progress -->

    <!-- Add Form -->
    <div class="container mt-5">
      <div class="card p-4 shadow">
        <form class="formUpload" method="post" enctype="multipart/form-data">
          <div class="input-group mb-2">
            <label class="input-group-btn">
              <span class="btn btn-danger">
                Upload Cover Buku&hellip; <input type="file" id="media" name="gambar" style="display: none;" required>
              </span>
            </label>
            <input type="text" class="form-control input-lg" size="40" readonly required>
          </div>
          <div class="input-group">
            <label class="input-group-btn">
              <span class="btn btn-danger">
                Upload Buku&hellip; <input type="file" id="media" name="media" style="display: none;" required>
              </span>
            </label>
            <input type="text" class="form-control input-lg" size="40" readonly required>
          </div>
          <div class="form-group">
            <label for="title">Judul Buku</label>
            <input type="text" class="form-control" id="title" required name="pdf_title">
          </div>
          <div class="form-group">
            <label for="kategori">Kategori Buku</label>
            <select class="form-control" id="kategori" name="kategori_id" required>
              <option disabled selected>-- Kategori Buku --</option>
              <?php foreach ($kategori as $row): ?>
              <option value="<?= $row['id'] ?>"><?= $row['name'] ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="form-group sub_kategori">
            <label for="kategori">Sub Kategori</label>

            <select class="form-control" id="kategori" name="sub_kategori_id">
              <option disabled selected>-- Sub Kategori Buku --</option>
              <?php foreach ($sub_kategori as $row): ?>
                <?php if ($row['id'] != 1): ?>
                  <option value="<?= $row['id'] ?>" selected><?= $row['name'] ?></option>
                <?php endif; ?>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="form-group">
            <label for="deskripsi">Deskripsi Buku</label>
            <textarea class="form-control" id="deskripsi" rows="10" name="pdf_desc" required></textarea>
          </div>
          <div class="input-group">
            <input type="submit" class="btn btn-danger w-100" value="Tambah Buku">
          </div>
        </form>
      </div>
    </div>

    <script src="js/jquery-3.4.1.js" charset="utf-8"></script>
    <script src="js/image.js"></script>
    <script src="js/upload.js"></script>
    <script type="text/javascript">
    $(document).ready(function(){
        $('.sub_kategori').hide();
      $("#kategori").change(function(){
        if ( $(this).val() == 3 ) {
          $('.sub_kategori').show();
        } else {
          $('.sub_kategori').hide();
        }
      });
    });
    $(function() {
      $(document).on('change', ':file', function() {
      var input = $(this),
        numFiles = input.get(0).files ? input.get(0).files.length : 1,
        label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
      input.trigger('fileselect', [numFiles, label]);
      });

      $(document).ready( function() {
        $(':file').on('fileselect', function(event, numFiles, label) {

          var input = $(this).parents('.input-group').find(':text'),
            log = numFiles > 1 ? numFiles + ' files selected' : label;

          if( input.length ) {
            input.val(log);
          } else {
            if( log ) alert(log);
          }

        });
      });

    });
    </script>
  </body>
</html>
