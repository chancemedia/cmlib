<?php

/**
 * @page manual_about_test 1.2. Full Test Output
 * 
 * <pre>
#================================================
#  Running tests
#================================================
Require All
  (1/37) PASS: Require CMBetaClass.php
  (2/37) PASS: Require CMClass.php
  (3/37) PASS: Require CMConstant.php
  (4/37) PASS: Require CMDatabaseProtocol.php
  (5/37) PASS: Require CMDataModel.php
  (6/37) PASS: Require CMDataModelValidator.php
  (7/37) PASS: Require CMDecimal.php
  (8/37) PASS: Require CMEnum.php
  (9/37) PASS: Require CMError.php
  (10/37) PASS: Require CMErrorType.php
  (11/37) PASS: Require CMException.php
  (12/37) PASS: Require CMFileCSV.php
  (13/37) PASS: Require CMFileICAL.php
  (14/37) PASS: Require CMFileParser.php
  (15/37) PASS: Require CMFileType.php
  (16/37) PASS: Require CMFileVCF.php
  (17/37) PASS: Require CMForm.php
  (18/37) PASS: Require CMFormatter.php
  (19/37) PASS: Require CMFutureClass.php
  (20/37) PASS: Require CMHeader.php
  (21/37) PASS: Require CMHTML.php
  (22/37) PASS: Require CMICalendar.php
  (23/37) PASS: Require CMLicense.php
  (24/37) PASS: Require CMMySQL.php
  (25/37) PASS: Require CMMySQLQuery.php
  (26/37) PASS: Require CMObject.php
  (27/37) PASS: Require CMOracle.php
  (28/37) PASS: Require CMOracleQuery.php
  (29/37) PASS: Require CMPostgreSQL.php
  (30/37) PASS: Require CMPostgreSQLQuery.php
  (31/37) PASS: Require CMQueryProtocol.php
  (32/37) PASS: Require CMSLOC.php
  (33/37) PASS: Require CMSLOCResult.php
  (34/37) PASS: Require CMTest.php
  (35/37) PASS: Require CMValidator.php
  (36/37) PASS: Require CMVCard.php
  (37/37) PASS: Require CMVersion.php
Done: 37 passed, 0 skipped, 0 failed

CMConstant
  (1/2) PASS: Integrity
  (2/2) PASS: Mutability
Done: 2 passed, 0 skipped, 0 failed

CMDecimal
  (1/8) PASS: Create
  (2/8) PASS: Create 2
  (3/8) PASS: add()
  (4/8) PASS: subtract()
  (5/8) PASS: multiply()
  (6/8) PASS: divide()
  (7/8) PASS: zero()
  (8/8) PASS: one()
Done: 8 passed, 0 skipped, 0 failed

CMError
  (1/4) PASS: isErrors()
  (2/4) PASS: countErrors()
  (3/4) PASS: useErrorStack()
  (4/4) PASS: SetGlobalStack()
Done: 4 passed, 0 skipped, 0 failed

CMFileCSV
  (1/6) PASS: iterateFile() and next()
  (2/6) PASS: Field mapping
  (3/6) PASS: prepareWriteFile(), add() and finishWriteFile()
  (4/6) PASS: iterateString() and next()
  (5/6) PASS: readFile()
  (6/6) PASS: readString()
Done: 6 passed, 0 skipped, 0 failed

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

All Done: 82 passed, 0 skipped, 0 failed
 * </pre>
 */

?>
