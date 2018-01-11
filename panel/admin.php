<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>CMS17 control panel</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha256-eZrrJcwDc/3uDhsdt61sL2oOBY362qM3lon1gyExkL0=" crossorigin="anonymous" />
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
  <!-- Bulma Version 0.6.0 -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.6.0/css/bulma.min.css" integrity="sha256-HEtF7HLJZSC3Le1HcsWbz1hDYFPZCqDhZa9QsCgVUdw=" crossorigin="anonymous" />
  <link rel="stylesheet" type="text/css" href="../css/admin.css">
</head>
<body>

  <nav class="navbar is-white">
    <div class="container">
      <div class="navbar-brand">
        <div class="navbar-item brand-text">
          CMS17 control panel
        </div>
        <a class="navbar-item">Logout</a>
      </div>
    </div>
  </nav>

  <div class="container">
    <div class="columns">
      <div class="column is-3">
        <?php require_once("panel/sidebar.php") ?>
      </div>
      <div class="column is-9">
        <?php
          $page = "dashboard";
          if(isset($_GET['page'])) {
            if(file_exists("panel/".$_GET['page'].".php")) {
              $page = $_GET['page'];
            }
          }
          require_once("panel/$page.php");
        ?>
      </div>
    </div>
  </div>
</body>
</html>
