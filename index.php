<!DOCTYPE html>
<?php

class FormValidator {
    const NAME = 1<<0;
    const LAST_NAME = 1<<1;
    const BIRTH_DATE = 1<<2;
    const GENDER = 1<<3;

    public static $GENDERVALUES = array(
        "1" => "Masculino",
        "2" => "Femenino",
        "3" => "Otro"
    );

    public static function validString($str)
    {
      return strlen($str) > 0 ? true : false;
    }

    public static function validDate($str)
    {
      list($y, $m, $d) = array_pad(explode('-', $str, 3), 3, 0);
      return ctype_digit("$y$m$d") && checkdate(intval($m), intval($d), intval($y));
    }
}

$formsent = isset($_POST['sent']);
//$formvalues = array();
$errors = 0;

if($formsent)
{
  if(!FormValidator::validString($_POST['name']))
    $errors |= FormValidator::NAME;

  if(!FormValidator::validString($_POST['lastname']))
    $errors |= FormValidator::LAST_NAME;

  if(!FormValidator::validDate($_POST['birthdate']))
    $errors |= FormValidator::BIRTH_DATE;

  if(!FormValidator::validString($_POST['gender']))
    $errors |= FormValidator::GENDER;

  if($errors)
    $formsent = false;
  //else
  //  $formvalues = $_POST;
}

?>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SWExperiencia02 - Desarrollo Web</title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template -->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>

    <!-- Custom styles for this template -->
    <link href="css/clean-blog.css" rel="stylesheet">
    <link href="css/additional.css" rel="stylesheet">

  </head>

  <body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
      <div class="container">
        <a class="navbar-brand" href="index.php">Bienvenido</a>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          Menu
          <i class="fa fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item"> 
              <a class="nav-link" href="index.php">Inicio</a>
            </li>            
          </ul>
        </div>
      </div>
    </nav>

    <!-- Page Header -->
    <header class="masthead" style="background-image: url('img/contact-bg.jpg')">
      <div class="container">
        <div class="row">
          <div class="col-lg-8 col-md-10 mx-auto">
            <div class="page-heading">
              <h1>Subscríbete</h1>
              <span class="subheading">No demorarás más de unos minutos</span>
            </div>
          </div>
        </div>
      </div>
    </header>

    <!-- Main Content -->
    <div class="container">
      <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">

<?php
function formatItem($str, $type)
{
  return '<li class="list-group-item list-group-item-'.$type.'">'.$str.'</li>';
}
?>

<?php if($formsent): ?>
          <p>¡Muchas gracias, <?php echo $_POST['name']." ".$_POST["lastname"] ?></p>
          <p class="text-success">La siguiente información ha sido registrada:</p>
          <ul class="list-group">
          <?php
          echo formatItem("Fecha de Nacimiento: {$_POST['birthdate']}", "info");
          echo formatItem("Sexo: ".FormValidator::$GENDERVALUES[$_POST['gender']], "info");
          echo formatItem("Región: {$_POST['region']}", "info");
          echo formatItem("Áreas de Interes: {$_POST['interests']}", "info");
          echo formatItem("Pagina Personal: {$_POST['webpage']}", "info");
          echo formatItem("Correo electrónico: {$_POST['email']}", "info");
          echo formatItem("Color Favorito: {$_POST['color']}", "info");
          ?>
          </ul>

          <hr>
<?php elseif($errors): ?>
          <p class="text-danger">Has enviado tu formulario con datos incorrectos o sin llenar:</p>

          <ul class="list-group">
          <?php
            if($errors & FormValidator::NAME)
              echo formatItem("Nombre", "danger");
            if($errors & FormValidator::LAST_NAME)
              echo formatItem("Apellido", "danger");
            if($errors & FormValidator::BIRTH_DATE)
              echo formatItem("Fecha de Nacimiento", "danger");
            if($errors & FormValidator::GENDER)
              echo formatItem("Sexo", "danger");
          ?>
          </ul>
          <hr>
<?php endif; ?>
          <p>Rellena el siguiente formulario</p>
          <!-- Contact Form - Enter your email address on line 19 of the mail/contact_me.php file to make this form work. -->
          <!-- WARNING: Some web hosts do not allow emails to be sent through forms to common mail hosts like Gmail or Yahoo. It's recommended that you use a private domain email address! -->
          <!-- NOTE: To use the contact form, your site must be on a live web host with PHP! The form will not work locally! -->
          <form action="index.php" method="post" name="sentMessage" id="contactForm" validate>
            <div class="control-group">
              <div class="form-group">
                <label>Nombre</label>
                <input type="text" class="form-control" placeholder="Nombre" name="name" id="name" required data-validation-required-message="Debes ingresar tu Nombre.">
                <p class="help-block text-danger"></p>
              </div>
            </div>            

            <div class="control-group">
              <div class="form-group">
                <label>Apellido</label>
                <input type="text" class="form-control" placeholder="Apellido" name="lastname" id="lastname" required data-validation-required-message="Debes ingresar tu Apellido.">
                <p class="help-block text-danger"></p>
              </div>
            </div>

            <div class="control-group">
              <div class="form-group">
                <label>Fecha de Nacimiento</label>
                <input type="date" class="form-control" name="birthdate" id="birthdate" required data-validation-required-message="Debes ingresar tu Fecha de Nacimiento.">
                <p class="help-block text-danger"></p>
              </div>
            </div>

            <div class="control-group">
              <div class="form-group">
                <label for="gender">Sexo</label>
                <select class="form-control" name="gender" id="gender" required>
                  <option value="">Indefinido</option>
                  <option value="1">Masculino</option>
                  <option value="2">Femenino</option>
                  <option value="3">Otro</option>
                </select>
                <p class="help-block text-danger"></p>
              </div>
            </div>

            <div class="control-group">
              <div class="form-group">
                <label for="region">Region</label>
                <select class="form-control" name="region" id="region" required>
                  <option value="1">Región Metropolitana</option>
                  <option value="2">XV Arica y Parinacota</option>
                  <option value="3">I Tarapacá</option>
                  <option value="4">II Antofagasta</option>
                  <option value="5">III Atacama</option>
                  <option value="6">IV Coquimbo</option>
                  <option value="7">V Valparaíso</option>
                  <option value="8">VI O'Higgins</option>
                  <option value="9">VII Maule</option>
                  <option value="10">VIII Biobío</option>
                  <option value="11">IX La Araucanía</option>
                  <option value="12">XIV Los Ríos</option>
                  <option value="13">X Los Lagos</option>
                  <option value="14">XI Aysén</option>
                  <option value="15">XII Magallanes y Antártica</option>
                </select>
                <p class="help-block text-danger"></p>
              </div>
            </div>

            <div class="control-group">
              <div class="form-group">
                <label for="interests">Intereses</label>
                <select multiple class="form-control" name="interests" id="interests" minchecked=1 required>
                  <option value="1">Ciencia</option>
                  <option value="2">Música</option>
                  <option value="3">Deportes</option>
                  <option value="4">Memes</option>
                  <option value="5">Momasos</option>
                </select>
                <p class="help-block text-danger"></p>
              </div>
            </div>

            <div class="control-group">
              <div class="form-group">
                <label>Email</label>
                <input type="email" class="form-control" placeholder="Email" name="email" id="email" required data-validation-required-message="Debes ingresar un Email" data-validation-validemail-message="EMail Invalido"> <!-- La Documentacion dice "validator-validemail" cuando es "validation-validemail"-->
                <p class="help-block text-danger"></p>
              </div>
            </div>

            <div class="control-group">
              <div class="form-group">
                <label>Pagina Personal</label>
                <input type="url" class="form-control" placeholder="URL" name="webpage" id="webpage" value="http://" required data-validation-required-message="Debes ingresar tu Página Web">
                <p class="help-block text-danger"></p>
              </div>
            </div>

            <div class="control-group">
              <div class="form-group">
                <label>Color Favorito</label>
                <input type="color" class="form-control" name="color" id="color" required data-validation-required-message="Debes seleccionar un Color">
                <p class="help-block text-danger"></p>
              </div>
            </div>

            <div class="control-group">
              <div class="form-group">
                <label>Mensaje</label>
                <textarea rows="5" class="form-control" placeholder="Mensaje" id="message" required data-validation-required-message="Debes ingresar un mensaje"></textarea>
                <p class="help-block text-danger"></p>
              </div>
            </div>

            <br>

            <div id="success"></div>
            <div class="form-group">
              <input type="hidden" value="1" name="sent">
              <button type="submit" class="btn btn-success" id="sendMessageButton">Enviar</button>
              <button type="submit" class="btn btn-info" id="emptyForm" onclick="$('#contactForm').trigger('reset')">Resetear</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <hr>

    <!-- Footer -->
    <footer>
      <div class="container">
        <div class="row">
          <div class="col-lg-8 col-md-10 mx-auto">
            <ul class="list-inline text-center">
              <li class="list-inline-item">
                <a href="https://www.facebook.com/zuck">
                  <span class="fa-stack fa-lg">
                    <i class="fa fa-circle fa-stack-2x"></i>
                    <i class="fa fa-facebook fa-stack-1x fa-inverse"></i>
                  </span>
                </a>
              </li>
              <li class="list-inline-item">
                <a href="https://www.github.com/PM32">
                  <span class="fa-stack fa-lg">
                    <i class="fa fa-circle fa-stack-2x"></i>
                    <i class="fa fa-github fa-stack-1x fa-inverse"></i>
                  </span>
                </a>
              </li>
            </ul>
            <p class="copyright text-muted">Copyright &copy; GitHub 2017</p>
          </div>
        </div>
      </div>
    </footer>

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/popper/popper.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Contact Form JavaScript -->
    <script src="js/jqBootstrapValidation.js"></script>

    <!-- Custom scripts for this template -->
    <script src="js/clean-blog.min.js"></script>

  </body>

</html>
