<?php
class SystemBuilder {

  function __construct($database, $systemDataStructure) {
    $this->db = $database;
    $this->systemDataStructure = $systemDataStructure;

    $this->title = $this->username = $this->password = "";
    $this->titleError = $this->usernameError = $this->passwordError = "";

    $isFormValid = $this->checkForm();

    $this->initializeTemplateEngine();
    if($isFormValid) {
      $this->buildSystem($systemDataStructure);
    } else {
      //show setup template
      $template = file_get_contents("../layout/setup/index.html");
      echo $this->templateEngine->build($template);
    }
  }

  function initializeTemplateEngine() {
    $this->tagEngine = new TagEngine();
    $this->templateEngine = new TemplateEngine($this->tagEngine, $this->db->getDatabaseObject());

    $this->tagEngine->registerData("databaseForm", file_get_contents("../layout/setup/form.html"));
    $this->tagEngine->registerData("databaseWarning", file_get_contents("../layout/setup/warning.html"));

    $this->tagEngine->registerData("title", $this->title);
    $this->tagEngine->registerData("titleError", $this->titleError);
    $this->tagEngine->registerData("username", $this->username);
    $this->tagEngine->registerData("usernameError", $this->usernameError);
    $this->tagEngine->registerData("password", $this->password);
    $this->tagEngine->registerData("passwordError", $this->passwordError);
  }

  function checkForm() {
    //if a post element is missing dont even bother checking
    if(!isset($_POST['title']) || !isset($_POST['username']) || !isset($_POST['password'])) {
      return false;
    }

    if(isset($_POST['title'])) {
      $this->title = $_POST['title'];

      if($this->title == "") {
        $this->titleError = "Please enter a title";
      }
    }

    if(isset($_POST['username'])) {
      $this->username = $_POST['username'];

      if(strlen($this->username) < 2) {
        $this->usernameError = "Username has to exist of atleast two characters";
      }
      elseif(!preg_match("/^[a-z0-9.]+$/i", $this->username)) {
        $this->usernameError = "Username can only exist out of letters and numbers";
      }
    }


    if(isset($_POST['password'])) {
      $this->password = $_POST['password'];
      if(strlen($this->password)<5) {
        $this->passwordError = "Password should exist out of atleast 5 characters";
      }
    }

    //if no error message is filled form is correct.
    if($this->titleError == "" && $this->usernameError == "" && $this->passwordError == "") {
      return true;
    }

    return false;
  }

  function buildSystem($struct) {
    $this->db->purgeDatabase();
    $this->db->helper->buildDataStructure($struct);

    $this->db->insert->user($this->username, $this->password, 5);
    $this->db->insert->tag("title", $this->title);

    header("location:/");
  }
}
?>
