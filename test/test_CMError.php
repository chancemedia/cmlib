<?php

include_once("../lib/CMError.php");

function getTestUnits() {
	die(implode(';', array(
		'test1=isErrors()',
		'test2=countErrors()',
		'test3=useErrorStack()',
		'test4=SetGlobalStack()'
	)));
}

// create a new error stack
$e = new CMError();
$e->setVerboseLevel(CMErrorType::Fatal);
	
// a function that simply divides 2 numbers safely
function divide($a, $b) {
	global $e;
	if($b == 0) {
		$e->throwError("Cannot divide by zero!");
		return 0;
	}
	return $a / $b;
}

function test1() {
	global $e;
	
	// now do some work
	divide(15, 3);
	divide(7, 0);
	divide(3, 0);
	divide(10, 2);
	
	// lets see if anything we wrong
	pass($e->isErrors());
}

function test2() {
	global $e;
	
	// now do some work
	divide(15, 3);
	divide(7, 0);
	divide(3, 0);
	divide(10, 2);
	
	// lets see if anything we wrong
	pass($e->countErrors() == 2);
}

function test3() {
	// create 2 error stacks
	$e1 = new CMError();
	$e2 = new CMError();
	$e1->setVerboseLevel(CMErrorType::Fatal);
	$e2->setVerboseLevel(CMErrorType::Fatal);
	
	// tell $e1 to direct all its error messages to $e2
	$e1->useErrorStack($e2);
	
	// throw an error message to each
	$e1->throwError("First error");
	$e2->throwError("Second error");
	
	// be careful here: this will look like 4 errors because both errors have been sent to $e2
	// aswell as $e1 pointing to $e2, so $e1 will actually return $e2's errors.
	
	// lets see if anything we wrong
	pass($e2->countErrors() == 2);
}

function test4() {
	// create a stack and define it as the stack for ALL objects created after or before this point
	$allErrors = new CMError();
	$allErrors->setVerboseLevel(CMErrorType::Fatal);
	CMError::SetGlobalStack($allErrors);
	
	// create two new stacks, which will automatially have their stack changed to $allErrors
	$e1 = new CMError();
	$e2 = new CMError();
	$e1->setVerboseLevel(CMErrorType::Fatal);
	$e2->setVerboseLevel(CMErrorType::Fatal);
	
	// throw an error message to each
	$e1->throwError("First error");
	$e2->throwError("Second error");
	
	// now lets check out global stack
	pass($allErrors->countErrors() == 2);
}

include_once('tester.php');

?>
