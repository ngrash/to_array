<?php

function monitor($action) {
  $start = microtime(true);
  $action();
  $end = microtime(true);

  $duration = $end - $start;
  return $duration;
}

function print_result($testResult) {
  if($testResult->success) {
    echo "Success";
  }
  else {
    print_fail($testResult->actual, $testResult->expected);
  }
  print(" in ".format_duration($testResult->duration)." ms.\n\n");
}

function format_duration($duration) {
  return substr($duration, 0, 4);
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

class TestResult {
  public $actual;
  public $duration;
  public $expected;
  public $success;
}

function expect($expected, $testCase) {
  $result = monitorTestCase($testCase);
  $testResult = new TestResult();
  $testResult->expected = $expected;
  $testResult->duration = $result[1];
  $testResult->actual = $result[0];
  $testResult->success = ($testResult->actual == $expected);
  return $testResult;
}

function expect_times($expected, $times, $testCase) {
  $totalDuration = 0;
  for ($run=0; $run < $times; $run++) {
    $testResult = expect($expected, $testCase);
    if(!$testResult->success) {
      print("Run ".$run." failed");
      print_result($testResult);
      break;
    }
    $totalDuration += $testResult->duration;
  }

  $averageDuration = $totalDuration / $times;
  print("Average duration: ".format_duration($averageDuration)." \n");
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
