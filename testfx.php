<?php

function print_result($success, $actual, $expected, $duration) {
  if($success) {
    echo "Success";
  }
  else {
    print_fail($actual, $expected);
  }
  print(" in ".substr($duration, 0, 4)." ms.\n\n");
}

function print_fail($actual, $expected) {
  $sane_expectation = var_export($expected, true);
  $actual_export = var_export($actual, true);

  print("Expected:\n");
  print($sane_expectation);
  print("\nBut got:\n");
  print($actual_export);
  print("\n");
}

function monitor($action) {
  $start = microtime(true);
  $action();
  $end = microtime(true);

  $duration = $end - $start;
  return $duration;
}

function expect($expected, $testCase) {
  $result = monitorTestCase($testCase);
  $actual = $result[0];
  $duration = $result[1];
  $success = ($actual == $expected);
  print_result($success, $actual, $expected, $duration);
}

function monitorTestCase($testCase) {
  // fuck scope
  $GLOBALS['testCase'] = $testCase;
  $duration = monitor(function() {
    $GLOBALS['actual'] = $GLOBALS['testCase']();
  });
  return [$GLOBALS['actual'], $duration];
}

?>
