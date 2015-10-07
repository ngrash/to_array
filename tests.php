<?php

require 'testfx.php';
require 'to_array.php';

expect([1, 2, 3], function() {
  return to_array([1, 2, 3]);
});

expect([1, 2, 3], function() {
  return to_array(1, 2, 3);
});

expect([1], function() {
  return to_array(1);
});

?>
