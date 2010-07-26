<?php

// make sure we are on the master branch
system("git checkout master");

// generate the documentation
system("rm -rf doc_temp");
system("/Applications/Doxygen.app/Contents/Resources/doxygen Doxyfile", $error);
if($error != 0)
	die("FAILED: Doxygen\n");

?>
