<?php

function to_array($args) {
  if(gettype($args) == 'array') {
    $array = $args;
  }
  else {
    $argc = func_num_args();
    $argv = func_get_args();

    if($argc == 1) {
      $array = [$argv[0]];
    }
    else {
      $array = $argv;
    }
  }

  return $array;
}

?>
