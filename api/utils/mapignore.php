<?php

  // Returns a string of ignored maps wrapped in double quotes and separated by commas
  function ignoredMaps() {
    include('ignored_maps.php');

    if (count($mapignore) == 0)
      return '" "';

    for ($i = 0; $i < count($mapignore); $i++) {
      $ignored .= '"'.$mapignore[$i].'"';

      if ($i != count($mapignore) - 1)
        $ignored .= ', ';
    }

    return $ignored;
  }
