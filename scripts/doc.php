<?php

// make sure we are on the master branch
system("git checkout master");

// generate the documentation
system("rm -rf doc_temp");
system("/Applications/Doxygen.app/Contents/Resources/doxygen Doxyfile", $error);
if($error != 0)
	die("FAILED: Doxygen\n");

// because doc/ is not being tracked by master we can switch branches and keep doc/ intact
system("git checkout gh-pages", $error);
if($error != 0)
	die("FAILED: git checkout gh-pages\n");

// remove old doc/
system("rm -rf doc");

// we copy rather than move because we want to keep doc_temp/ for browsing on the master branch
system("cp -R doc_temp doc");

// commit changes
system("git add . && git commit -a -m \"Docs - `date`\"");

// push changes
system("git push", $error);
if($error != 0)
	die("FAILED: git push\n");

// switch back to master branch
system("git checkout master");

?>
