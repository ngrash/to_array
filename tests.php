<?php

require 'testfx.php';
require 'to_array.php';

expect_times([1, 2, 3], 1000, function() {
  return to_array([1, 2, 3]);
});

expect_times([1, 2, 3], 1000, function() {
  return to_array(1, 2, 3);
});

expect_times([1], 1000, function() {
  return to_array(1);
});

?>
