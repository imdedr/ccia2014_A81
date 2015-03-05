<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Project CCIA</title>

    <!-- Bootstrap core CSS -->
    <link href="<?=base_url('css/bootstrap.min.css'); ?>" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="<?=base_url('css/main.css'); ?>" rel="stylesheet">
    <script src="<?=base_url('js/jquery-1.11.2.min.js'); ?>"></script>
    <script src="<?=base_url('js/bootstrap.min.js'); ?>"></script>
  </head>

  <body>

    <!-- Static navbar -->
    <nav class="navbar navbar-default navbar-static-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="<?=base_url('teacher'); ?>">Project CCIA</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li><a href="<?=base_url('teacher/logout'); ?>">登出</a></li>
          </ul>
        </div>
      </div>
    </nav>


