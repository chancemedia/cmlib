<?php

// make sure we are on the master branch
system("git checkout master");

// generate the documentation
system("/Applications/Doxygen.app/Contents/Resources/doxygen Doxyfile");

// because doc/ is not being tracked by master we can switch branches and keep doc/ intact
system("git checkout gh-pages", $error);
if($error != 0)
	die("FAILED: git checkout gh-pages\n");

// copy doc_temp/ over doc/
system("rm -rf doc");
system("mv doc_temp doc");

// commit changes
system("git add . && git commit -a -m \"Docs - `date`\"");

// push changes
system("git push");

// switch back to master branch
system("git checkout master");

?>
