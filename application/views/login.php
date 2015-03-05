
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Login</title>

    <!-- Bootstrap core CSS -->
    <link href="<?=base_url('css/bootstrap.min.css'); ?>" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="<?=base_url('css/signin.css'); ?>" rel="stylesheet">

  </head>

  <body>

    <div class="container">

      <form class="form-signin" method="POST">
        <input type="hidden" name="do" value="login">
        <h2 class="form-signin-heading">Project CCIA</h2>
        <input type="text" id="inputEmail" name="username" class="form-control" placeholder="Username" required autofocus>
        <input type="password" id="inputPassword" name="password" class="form-control" placeholder="Password" required>
        <button class="btn btn-lg btn-primary btn-block" type="submit">登入</button>
      </form>

    </div> <!-- /container -->

  </body>
</html>
