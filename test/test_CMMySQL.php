<?php

include_once("../lib/CMMySQL.php");
include_once("config.php");

global $g_mysql_user, $g_mysql_pass, $g_mysql_host, $g_mysql_name;
$err = new CMError();
$err->setVerboseLevel(CMErrorType::Fatal);
$dbh = new CMMySQL("mysql://$g_mysql_user:$g_mysql_pass@$g_mysql_host/$g_mysql_name",
                   array('error' => $err));

function getTestUnits() {
	die(implode(';', array(
		'test1=isConnected()',
		'test2=query(): CREATE TABLE',
		'test3=eraseTable()',
		'test4=truncateTable()',
		'test5=getTableNames()',
		'test6=insert()',
		'test7=query(): SELECT',
		'test8=totalRows()',
		'test9=fetch()',
		'test10=fetchAll()',
		'test11=update()',
		'test12=delete()',
		'test13=Fail connect',
	)));
}

function test1() {
	global $dbh;
	if(!$dbh->isConnected())
		skip();
	
	pass($dbh->isConnected());
}

function test2() {
	global $dbh;
	if(!$dbh->isConnected())
		skip();
	
	$q = $dbh->query("CREATE TABLE IF NOT EXISTS cmlib_test (".
                     "id int auto_increment primary key,".
                     "name varchar(255),".
                     "num numeric(9,1) default 0".
	                 ")");
	pass($q->success());
}

function test3() {
	global $dbh;
	if(!$dbh->isConnected())
		skip();
	
	pass($dbh->eraseTable('cmlib_test'));
}

function test4() {
	global $dbh;
	if(!$dbh->isConnected())
		skip();
	
	pass($dbh->truncateTable('cmlib_test'));
}

function test5() {
	global $dbh;
	if(!$dbh->isConnected())
		skip();
	
	$tables = $dbh->getTableNames();
	pass(count($tables) > 0);
}

function test6() {
	global $dbh;
	if(!$dbh->isConnected())
		skip();
	
	pass($dbh->insert('cmlib_test',
		array('name' => 'Bob Smith', 'num' => 3.4)
	) !== false);
}

function test7() {
	global $dbh;
	if(!$dbh->isConnected())
		skip();
	
	$q = $dbh->query("SELECT * FROM cmlib_test");
	pass($q->success());
}

function test8() {
	global $dbh;
	if(!$dbh->isConnected())
		skip();
	
	$q = $dbh->query("SELECT * FROM cmlib_test");
	pass($q->totalRows() > 0);
}

function test9() {
	global $dbh;
	if(!$dbh->isConnected())
		skip();
	
	$q = $dbh->query("SELECT * FROM cmlib_test");
	pass(count($q->fetch()) > 0);
}

function test10() {
	global $dbh;
	if(!$dbh->isConnected())
		skip();
	
	$q = $dbh->query("SELECT * FROM cmlib_test");
	pass(count($q->fetchAll()) > 0);
}

function test11() {
	global $dbh;
	if(!$dbh->isConnected())
		skip();
	
	pass($dbh->update('cmlib_test',
		array('name' => 'John Smith', 'num' => 3.7),
		array('name' => 'Bob Smith', 'num' => 3.4)
	) > 0);
}

function test12() {
	global $dbh;
	if(!$dbh->isConnected())
		skip();
	
	pass($dbh->delete('cmlib_test',
		array('name' => 'John Smith', 'num' => 3.7)
	) > 0);
}

function test13() {
	$e = new CMError();
	$e->setVerboseLevel(CMErrorType::Fatal);
	$fail = new CMMySQL("mysql://blabla@localhost/blabla", array('error' => $e));
	$errors = $e->errors();
	pass($errors[0]['_reason'] != '');
}

include_once('tester.php');

?>
