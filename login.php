<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <!-- Meta, title, CSS, favicons, etc. -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <title>Login || DB TRANS</title>

  <!-- Bootstrap -->
  <link href="plugins/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link href="plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <!-- NProgress -->
  <link href="plugins/nprogress/nprogress.css" rel="stylesheet">
  <!-- Animate.css -->
  <!-- <link href="plugins/animate.css/animate.min.css" rel="stylesheet"> -->
  <!-- Custom Theme Style -->
  <link href="build/css/custom.min.css" rel="stylesheet">
  <!-- favicon -->
  <link rel="icon" href="./media/logo.png" type="image/x-icon" />
</head>

<body class="login">
  <div>


    <div class="login_wrapper">
      <div class="animate form login_form">
        <section class="login_content">
          <img src="build/images/user.png" width="18%">
          <h2 style="font-family: inter; font-size: 25px; font-weight: 800;color: #43a7ef;">Login</h2>
          </h2>

          <form action="cek_login.php" method="post" style="font-family: inter;">
            <p>Masukkan Username dan Password</p>
            <div>
              <input type="text" class="form-control" placeholder="Username" name="username" required="Masukkan Username" autocomplete="off" />
            </div>
            <div>
              <input type="password" class="form-control" placeholder="Password" name="password" required autocomplete="off" />
            </div>
            <div>
              <button type="submit" class="btn btn-primary btn-sm btn-block">Masuk</button>
            </div>
            <br><br>
            <p>Copyright © 2023 DB TRANS.All rights reserved.</p>
          </form>
        </section>
      </div>


    </div>
  </div>
</body>

</html>