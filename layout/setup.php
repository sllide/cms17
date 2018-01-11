<?php
  //system builder!
  $title = $username = $password = "";
  $titleError = $usernameError = $passwordError = "";
  $error = false;
  if(isset($_POST['title'])) {
    $title = $_POST['title'];
    //title has to exist
    if($title == "") {
      $titleError = "Please enter a title";
      $error = true;
    }
  }
  if(isset($_POST['username'])) {
    $username = $_POST['username'];

    if(strlen($username) < 2) {
      $usernameError = "Username has to exist of atleast two characters";
      $error = true;
    }
    elseif(!preg_match("/^[a-z0-9.]+$/i", $username)) {
      $usernameError = "Username can only exist out of letters and numbers";
      $error = true;
    }
  }
  if(isset($_POST['password'])) {
    $password = $_POST['password'];
    if(strlen($password)<5) {
      $passwordError = "Password should exist out of atleast 5 characters";
      $error = true;
    }
  }

  //all checks passed, build database :)
  if($title!=""&&$username!=""&&$password!=""&&!$error) {
    $systemWatcher->buildSystem($title,$username,$password);
    header("location:/");
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <title>CMS17 setup</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.6.2/css/bulma.min.css">
  </head>
  <body>

    <section class="hero">
      <div class="hero-body">
        <div class="container">
          <h1 class="title is-1">
            CMS17
          </h1>
          <h2 class="subtitle">
            A <strong>amazing</strong> content management system!
          </h2>
        </div>
      </div>
    </section>

    <div class="container">
      <section class="section">
        <div class="columns">
          <div class="column is-three-fifths is-primary">
            <p>
              CMS17 is a content management system geared towards <strong>easy extension</strong>.
              Because of this the CMS itself is pretty barebones and requires plugins to be written.
              The page and navigation plugin do allow a basic website to start building upon! <strong>Good luck!</strong>
            </p>
            <?php
              if(count($database->getAllTables())>0) {
                ?>
                  <div class="notification is-danger">
                    <h1 class="title">DANGER</h1>
                    <p>
                      There is data found in the database wich means most of it is still there, its just broken.
                      Clicking on create will <strong>destroy</strong> all data that currently resides in the database. Continue at your own risk.
                    </p>
                  </div>
                <?php
              }
            ?>
          </div>
          <div class="column">
            <form method="post">

            <div class="field">
              <label class="label">Website title</label>
              <div class="control">
                <input name="title" class="input" type="text" placeholder="title" value="<?=$title?>" />
              </div>
              <p class="help is-danger"><?=$titleError?></p>
            </div>

            <div class="field">
              <label class="label">Admin username</label>
              <div class="control">
                <input name="username" class="input" type="text" placeholder="username" value="<?=$username?>" />
              </div>
              <p class="help is-danger"><?=$usernameError?></p>
            </div>

            <div class="field">
              <label class="label">Admin password</label>
              <div class="control">
                <input name="password" class="input" type="text" placeholder="password" value="<?=$password?>" />
              </div>
              <p class="help is-danger"><?=$passwordError?></p>
            </div>

            <div class="control">
              <input type="submit" class="button is-link" value="Create" />
              <p class="help">Admin panel will be available at /?admin</p>
            </div>

            </form>
          </div>
        </div>
      </section>
    </div>

  </body>
</html>
