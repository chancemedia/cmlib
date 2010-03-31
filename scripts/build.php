<?php

// Create release folder


// Compile
/*echo "#================================================\n";
echo "#  Compiling\n";
echo "#================================================\n";

system("php bencoder.php -f -o bin -s src/lib");
system("wc -l src/lib/*.php");
echo "\n";*/

// Test
echo "#================================================\n";
echo "#  Running tests\n";
echo "#================================================\n";

system("cd ../test && php testall.php");

// SLOC count
echo "#================================================\n";
echo "#  SLOC Result (includes library, docs and tests)\n";
echo "#================================================\n";

include_once('../lib/CMSLOC.php');

$sloc = new CMSLOC();
$sloc->processPath('../src');
$sloc->processPath('../doc');
$sloc->processPath('../test');

$sloc->result->printResults();

echo "\n";

?>
