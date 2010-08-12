<?php

require_once('../lib/CMTest.php');

$tests = array(
	new CMTest('Require All', "test_require_all.php"),
	new CMTest('CMConstant', "test_CMConstant.php"),
	new CMTest('CMDecimal', "test_CMDecimal.php"),
	new CMTest('CMError', "test_CMError.php"),
	new CMTest('CMFileCSV', "test_CMFileCSV.php"),
	new CMTest('CMFileICAL', "test_CMFileICAL.php"),
	new CMTest('CMFileVCF', "test_CMFileVCF.php"),
	new CMTest('CMFormatter', "test_CMFormatter.php"),
	new CMTest('CMGraphicDraw', "test_CMGraphicDraw.php"),
	new CMTest('CMMySQL', "test_CMMySQL.php"),
	new CMTest('CMVCard', "test_CMVCard.php"),
	new CMTest('CMVersion', "test_CMVersion.php")
);

// get the list of tests to run
$focus_tests = array();
if($argc == 1) {
	foreach($tests as $t)
		$focus_tests[] = $t->name;
}
else
	$focus_tests = $argv;

// run the tests
$fail = 0;
$pass = 0;
$skip = 0;
foreach($tests as $t) {
	if(!in_array($t->name, $focus_tests))
		continue;
		
	$t->run();
	$fail += $t->fail;
	$pass += $t->pass;
	$skip += $t->skip;
	// collect overall stats here
}

// final results
echo "All Done: $pass passed, $skip skipped, $fail failed\n\n";

?>
