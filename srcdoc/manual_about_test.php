<?php

/**
 * @page manual_about_test 1.2. Full Test Output
 * 
 * <pre>
#================================================
#  Running tests
#================================================
Require All
  (1/36) PASS: Require CMBetaClass.php
  (2/36) PASS: Require CMClass.php
  (3/36) PASS: Require CMConstant.php
  (4/36) PASS: Require CMDatabaseProtocol.php
  (5/36) PASS: Require CMDataModel.php
  (6/36) PASS: Require CMDataModelValidator.php
  (7/36) PASS: Require CMEnum.php
  (8/36) PASS: Require CMError.php
  (9/36) PASS: Require CMErrorType.php
  (10/36) PASS: Require CMException.php
  (11/36) PASS: Require CMFileCSV.php
  (12/36) PASS: Require CMFileICAL.php
  (13/36) PASS: Require CMFileParser.php
  (14/36) PASS: Require CMFileType.php
  (15/36) PASS: Require CMFileVCF.php
  (16/36) PASS: Require CMForm.php
  (17/36) PASS: Require CMFormatter.php
  (18/36) PASS: Require CMFutureClass.php
  (19/36) PASS: Require CMHeader.php
  (20/36) PASS: Require CMHTML.php
  (21/36) PASS: Require CMICalendar.php
  (22/36) PASS: Require CMLicense.php
  (23/36) PASS: Require CMMySQL.php
  (24/36) PASS: Require CMMySQLQuery.php
  (25/36) PASS: Require CMObject.php
  (26/36) PASS: Require CMOracle.php
  (27/36) PASS: Require CMOracleQuery.php
  (28/36) PASS: Require CMPostgreSQL.php
  (29/36) PASS: Require CMPostgreSQLQuery.php
  (30/36) PASS: Require CMQueryProtocol.php
  (31/36) PASS: Require CMSLOC.php
  (32/36) PASS: Require CMSLOCResult.php
  (33/36) PASS: Require CMTest.php
  (34/36) PASS: Require CMValidator.php
  (35/36) PASS: Require CMVCard.php
  (36/36) PASS: Require CMVersion.php
Done: 36 passed, 0 skipped, 0 failed

CMConstant
  (1/2) PASS: Integrity
  (2/2) PASS: Mutability
Done: 2 passed, 0 skipped, 0 failed

CMError
  (1/4) PASS: isErrors()
  (2/4) PASS: countErrors()
  (3/4) PASS: useErrorStack()
  (4/4) PASS: SetGlobalStack()
Done: 4 passed, 0 skipped, 0 failed

CMFileCSV
  (1/3) PASS: iterateFile() and next()
  (2/3) PASS: Field mapping
  (3/3) PASS: prepareWriteFile(), add() and finishWriteFile()
Done: 3 passed, 0 skipped, 0 failed

CMFormatter
  (1/8) PASS: Date formatting
  (2/8) PASS: Currency formatting
  (3/8) PASS: Percentage formatting
  (4/8) PASS: Bytes formatting 1
  (5/8) PASS: Bytes formatting 2
  (6/8) PASS: Bytes formatting 3
  (7/8) PASS: Multicolumn formatter
  (8/8) PASS: Database formatter
Done: 8 passed, 0 skipped, 0 failed

CMMySQL
  (1/13) PASS: isConnected()
  (2/13) PASS: query(): CREATE TABLE
  (3/13) PASS: eraseTable()
  (4/13) PASS: truncateTable()
  (5/13) PASS: getTableNames()
  (6/13) PASS: insert()
  (7/13) PASS: query(): SELECT
  (8/13) PASS: totalRows()
  (9/13) PASS: fetch()
  (10/13) PASS: fetchAll()
  (11/13) PASS: update()
  (12/13) PASS: delete()
  (13/13) PASS: Fail connect
Done: 13 passed, 0 skipped, 0 failed

CMVCard
  (1/1) PASS: Create vCard
Done: 1 passed, 0 skipped, 0 failed

CMVersion
  (1/3) PASS: atLeast()
  (2/3) PASS: makeVersion()
  (3/3) PASS: over()
Done: 3 passed, 0 skipped, 0 failed

All Done: 70 passed, 0 skipped, 0 failed
 * </pre>
 */

?>
