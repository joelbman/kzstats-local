 <?php 

  spl_autoload_extensions('.php, .class.php');

  function classLoader($class) {
    require('class/'.$class.'.class.php');
  }
  
  spl_autoload_register('classLoader');