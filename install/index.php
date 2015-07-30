<?php

  error_reporting(E_ALL & ~E_NOTICE);

  // Check for existing settings file
  if (file_exists('../api/settings.php'))
    die('Settings file already exists.');

  if (@$_POST['submit']) {

    // Check if all the fields have values
    foreach ($_POST as $key => $value) {
      if ($key != 'apikey' && !$value)
        $error = 'Please fill out all the fields.';
    }

    if (!$error) {

      // Behold the mighty string
      $settings = '<?php' . PHP_EOL . PHP_EOL;
      $settings .= '$server["ip"] = "'.$_POST['serverip'].'";'.PHP_EOL;
      $settings .= '$server["port"] = "'.$_POST['serverport'].'";'.PHP_EOL;
      $settings .= '$server["name"] = "'.$_POST['servername'].'";'.PHP_EOL.PHP_EOL;
      $settings .= '$dbhost = "'.$_POST['dbhost'].'";'.PHP_EOL;
      $settings .= '$dbport = "'.$_POST['dbport'].'";'.PHP_EOL;
      $settings .= '$dbname = "'.$_POST['dbname'].'";'.PHP_EOL;
      $settings .= '$dbuser = "'.$_POST['dbuser'].'";'.PHP_EOL;
      $settings .= '$dbpass = "'.$_POST['dbpass'].'";'.PHP_EOL;
      $settings .= '$dbcharset = "'.$_POST['dbcharset'].'";'.PHP_EOL.PHP_EOL;
      $settings .= '$apikey = "'.$_POST['apikey'].'";'.PHP_EOL;

      $f = fopen('../api/settings.php', 'w');

      if (fwrite($f, $settings))
        $success = true;
      else
        $error = 'Could not write file. Check the permissions of the api directory.';

      fclose($f);

    }

  }

?>
<!DOCTYPE html>
<html>
  <head>
    <title>KZStats Local installer</title>
    <link rel='stylesheet' type='text/css' href='../css/bootstrap.min.css'>
    <link rel='stylesheet' type='text/css' href='style.css'>
    <link rel='stylesheet' type='text/css' href='http://fonts.googleapis.com/css?family=Oxygen'>
  </head>
  <body>
    <div class='container'>
      <div class='col-md-8'>
        <?php

          if ($success) {
            $str = '<h1>Success</h1>Settings file was successfully created.<br>';
            $str .= 'If you need to re-run the installer, please delete the "api/settings.php" file.<br>';
            $str .= 'You can also delete this folder after confirming that everything works as expected.';
            echo $str;
          }
          if ($error)
            echo '<div class="error"><h1>Error</h1>'.$error.'</div>';

          if (!$success) {

        ?>
        <h1>KZStats Local - Install</h1>
        Please fill out all the fields.<br><br>
        Note that this installer does not work if your "api/" directory isn't writable.<br>
        Change it's mode to 644 before executing this installer.<br><br>
        If the installer doesn't work for some reason, you can just edit in the correct values in "api/settings.example.php" file and rename it to "settings.php".
        <form role='form' action='index.php' method='post' class='form'>
          <div class='input-group'>
            <h2>Server info</h2>

            <label>Server name</label>
            <input type='text' class='form-control' maxlength='25' name='servername'>
            <div class='help-block'>
              CS:GO server's name.<br>
              This will be shown in the navbar.<br>
              Recommended size is below 20 characters.
            </div>

            <label>Server ip</label>
            <input type='text' class='form-control' maxlength='25' name='serverip'>
            <span class='help-block'>Your CS:GO server's ip.</span>

            <label>Server port</label>
            <input type='text' class='form-control' value='27015' maxlength='8' name='serverport'>
            <span class='help-block'>CS:GO server's port. Default is 27015.</span> 
          </div>
          <div class='input-group'>
            <h2>MySQL info</h2>

            <label>Database host</label>
            <input type='text' class='form-control' value='localhost' maxlength='25' name='dbhost'>
            <span class='help-block'>
              MySQL server's hostname/ip.
              <br>Default is localhost, which works if you run your MySQL on the same server as your CS:GO server.
            </span>

            <label>Database port</label>
            <input type='text' class='form-control' value='3306' maxlength='8' name='dbport'>
            <span class='help-block'>MySQL server port. Default is 3306.</span>

            <label>Database name</label>
            <input type='text' class='form-control' name='dbname'>
            <span class='help-block'>MySQL database name.</span>

            <label>Database username</label>
            <input type='text' class='form-control' name='dbuser'>
            <span class='help-block'>MySQL user name.</span>

            <label>Database password</label>
            <input type='password' class='form-control' name='dbpass'>
            <span class='help-block'>MySQL database password.</span>

            <label>Database charset</label>
            <input type='text' class='form-control' value='utf8' maxlength='15' name='dbcharset'>
            <span class='help-block'>MySQL database charset.<br>Default is utf8, which should work in most cases.</span>
          </div>
          <div class='input-group'>
            <h2>Misc</h2>

            <label>Steam API key</label>
            <input type='text' class='form-control' name='apikey'>
            <span class='help-block'>Steam API key. If you don't have one yet, you can get one <a href='http://steamcommunity.com/dev/apikey'>here</a>.</span>

            <div class='note'>
              <label>Note</label>
              You can change these settings at any time you like, they are stored in the api/settings.php file.
            </div>

            <input class='btn btn-primary btn-lg' name='submit' type='submit' value='Install'>
          </div>
        </form>
      </div>
    </div>
    <?php } ?>
  </body>
</html>