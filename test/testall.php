<?php

require_once('../lib/CMTest.php');

$tests = array(
	new CMTest('Require All', "test_require_all.php"),
	new CMTest('CMConstant', "test_CMConstant.php"),
	new CMTest('CMDecimal', "test_CMDecimal.php"),
	new CMTest('CMError', "test_CMError.php"),
	new CMTest('CMFileCSV', "test_CMFileCSV.php"),
	new CMTest('CMFormatter', "test_CMFormatter.php"),
	new CMTest('CMMySQL', "test_CMMySQL.php"),
	new CMTest('CMVCard', "test_CMVCard.php"),
	new CMTest('CMVersion', "test_CMVersion.php")
);
$focus_test = '';

// run the tests
$fail = 0;
$pass = 0;
$skip = 0;
foreach($tests as $t) {
	if($focus_test != '' && $t->name != $focus_test)
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
