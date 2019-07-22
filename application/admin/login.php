<?php
  require "../config/connection.php";
  use voku\helper\AntiXSS;
  require_once __DIR__ . '/vendor/autoload.php';
  $antiXss = new AntiXSS();

  if(isset($_SESSION['login'])) {
      header("Location: admin_kontak.php");
      exit;
  }

  if(isset($_POST['login']))
  {
      $username_xss = mysqli_real_escape_string( $conn, stripslashes( htmlspecialchars($_POST['username']) ));
      $password_xss = mysqli_real_escape_string( $conn, stripslashes( htmlspecialchars($_POST['password']) ));
      $captcha_xss = mysqli_real_escape_string( $conn, stripslashes( htmlspecialchars($_POST['captcha']) ));

      //xss clear
      $username = $antiXss->xss_clean($username_xss);
      $password = $antiXss->xss_clean($password_xss);
      $captcha = $antiXss->xss_clean($captcha_xss);

      if (isset($_SESSION["code"])) {
        $true_captcha_xss = mysqli_real_escape_string( $conn, stripslashes( htmlspecialchars($_SESSION["code"]) ));
        $true_captcha = $antiXss->xss_clean($true_captcha_xss);
        if ($true_captcha != $captcha) {
          echo "
      			<script>
      				alert('Kode Captha Salah');
      				document.location.href='login.php';
      			</script>
      		";
          exit;
        }
        else {
          $res = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");

          if (mysqli_num_rows($res) === 1) {
            //cek password
            $row = mysqli_fetch_assoc($res);
            if (password_verify($password, $row["password"])) {
              //set session
              $_SESSION['login'] = true;
              $_SESSION['data'] = $row;
              header("Location: ./admin_buku.php");
              exit;
            }
          }
          $error = true;
        }
      }
  }
?>

<!doctype html>
<html lang="en">
  <head>
    <title>Buku Antikorupsi | Login Admin</title>
    <!-- favicon  -->
    <link rel="shortcut icon" href="../images/Logo KPK/favicon.png">

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <!-- Costume Css -->
    <link rel="stylesheet" href="css/index.css">
    <!-- icon -->
    <link rel="stylesheet" href="../css/fontawesome/css/all.min.css">
  </head>
  <body>

    <!-- Alert Error -->
    <?php if(isset($error)) :?>
    <div class="container">
      <div class="alert alert-danger" role="alert">
        <strong>Username / Password Salah</strong>
        <p>Perhatikan huruf besar dan kecil</p>
      </div>
    </div>
    <?php endif;?>
    <!-- End Of Alaert Error -->


    <div class="container h-100">
      <div class="d-flex justify-content-center h-100">
        <div class="user_card">
          <div class="d-flex justify-content-center">
            <div class="brand_logo_container">
              <img src="../images/Logo KPK/Logo BJH.png" class="brand_logo" alt="Logo">
            </div>
          </div>
          <div class="d-flex justify-content-center form_container">
            <form method="post">
              <div class="input-group mb-3">
                <div class="input-group-append">
                  <span class="input-group-text"><i class="fas fa-user"></i></span>
                </div>
                <input type="text" name="username" class="form-control input_user validate" placeholder="username" required>
              </div>
              <div class="input-group mb-2">
                <div class="input-group-append">
                  <span class="input-group-text"><i class="fas fa-key"></i></span>
                </div>
                <input type="password" name="password" class="form-control input_pass" placeholder="password">
              </div>
              <img class="w-100" src="vendor/captcha/captcha.php" alt="captcha" />
              <div class="input-group my-2">
                <div class="input-group-append">
                  <span class="input-group-text"><i class="fas fa-shield-alt"></i></span>
                </div>
                <input type="text" name="captcha" class="form-control input_pass" placeholder="captcha code" maxlength="5" required>
              </div>
              <div class="d-flex justify-content-center mt-3 login_containe">
                <button type="submit" name="login" class="btn login_btn">Login</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

  </body>
</html>
