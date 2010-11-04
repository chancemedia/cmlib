<?php

/**
 * @page manual_about_test 1.2. Full Test Output
 * 
 * <pre>
Require All
  (1/50) PASS: Require CMBetaClass.php
  (2/50) PASS: Require CMBox.php
  (3/50) PASS: Require CMClass.php
  (4/50) PASS: Require CMColor.php
  (5/50) PASS: Require CMConstant.php
  (6/50) PASS: Require CMDatabaseProtocol.php
  (7/50) PASS: Require CMDataModel.php
  (8/50) PASS: Require CMDataModelValidator.php
  (9/50) PASS: Require CMDecimal.php
  (10/50) PASS: Require CMEnum.php
  (11/50) PASS: Require CMError.php
  (12/50) PASS: Require CMErrorType.php
  (13/50) PASS: Require CMException.php
  (14/50) PASS: Require CMFile.php
  (15/50) PASS: Require CMFileCSV.php
  (16/50) PASS: Require CMFileICAL.php
  (17/50) PASS: Require CMFileMultiReader.php
  (18/50) PASS: Require CMFileMultiWriter.php
  (19/50) PASS: Require CMFileReader.php
  (20/50) PASS: Require CMFileType.php
  (21/50) PASS: Require CMFileVCF.php
  (22/50) PASS: Require CMFileWriter.php
  (23/50) PASS: Require CMFont.php
  (24/50) PASS: Require CMForm.php
  (25/50) PASS: Require CMFormatter.php
  (26/50) PASS: Require CMFutureClass.php
  (27/50) PASS: Require CMGraphic.php
  (28/50) PASS: Require CMGraphicDraw.php
  (29/50) PASS: Require CMHeader.php
  (30/50) PASS: Require CMHTML.php
  (31/50) PASS: Require CMLicense.php
  (32/50) PASS: Require CMMySQL.php
  (33/50) PASS: Require CMMySQLQuery.php
  (34/50) PASS: Require CMObject.php
  (35/50) PASS: Require CMOracle.php
  (36/50) PASS: Require CMOracleQuery.php
  (37/50) PASS: Require CMPostgreSQL.php
  (38/50) PASS: Require CMPostgreSQLQuery.php
  (39/50) PASS: Require CMQueryProtocol.php
  (40/50) PASS: Require CMSerialize.php
  (41/50) PASS: Require CMSLOC.php
  (42/50) PASS: Require CMSLOCResult.php
  (43/50) PASS: Require CMStyle.php
  (44/50) PASS: Require CMStyleValidator.php
  (45/50) PASS: Require CMTest.php
  (46/50) PASS: Require CMValidator.php
  (47/50) PASS: Require CMVCalendar.php
  (48/50) PASS: Require CMVCard.php
  (49/50) PASS: Require CMVersion.php
  (50/50) PASS: Require CMVItem.php
Done: 50 passed, 0 skipped, 0 failed

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
  (1/7) PASS: readFile() and readNext()
  (2/7) PASS: Field mapping
  (3/7) PASS: prepareWriteFile(), writeNext() and finishWriteFile()
  (4/7) PASS: readString() and readNext()
  (5/7) PASS: readFile() and read all
  (6/7) PASS: readString() and read all
  (7/7) PASS: isBinary()
Done: 7 passed, 0 skipped, 0 failed

CMFileICAL
  (1/4) PASS: readFile() and readNext()
  (2/4) PASS: prepareWriteFile(), writeNext() and finishWriteFile()
  (3/4) PASS: isBinary()
  (4/4) PASS: Integrity check
Done: 4 passed, 0 skipped, 0 failed

CMFileVCF
  (1/5) PASS: isBinary()
  (2/5) PASS: readFile() for version 2.1
  (3/5) PASS: readFile() for version 3.0
  (4/5) PASS: Integrity check with version 2.1
  (5/5) PASS: Integrity check with version 3.0
Done: 5 passed, 0 skipped, 0 failed

CMFormatter
  (1/8) PASS: Date formatting
  (2/8) PASS: Currency formatting
  (3/8) PASS: Percentage formatting
  (4/8) PASS: Bytes formatting 1
  (5/8) PASS: Bytes formatting 2
  (6/8) PASS: Bytes formatting 3
  (7/8) PASS: Multicolumn formatter
  (8/8) SKIP: Database formatter
Done: 7 passed, 1 skipped, 0 failed

CMGraphicDraw
  (1/1) PASS: new CMGraphicDraw()
Done: 1 passed, 0 skipped, 0 failed

CMMySQL
  (1/13) SKIP: isConnected()
  (2/13) SKIP: query(): CREATE TABLE
  (3/13) SKIP: eraseTable()
  (4/13) SKIP: truncateTable()
  (5/13) SKIP: getTableNames()
  (6/13) SKIP: insert()
  (7/13) SKIP: query(): SELECT
  (8/13) SKIP: totalRows()
  (9/13) SKIP: fetch()
  (10/13) SKIP: fetchAll()
  (11/13) SKIP: update()
  (12/13) SKIP: delete()
  (13/13) PASS: Fail connect
Done: 1 passed, 12 skipped, 0 failed

CMVCard
  (1/1) PASS: Create vCard
Done: 1 passed, 0 skipped, 0 failed

CMVersion
  (1/3) PASS: atLeast()
  (2/3) PASS: makeVersion()
  (3/3) PASS: over()
Done: 3 passed, 0 skipped, 0 failed

All Done: 93 passed, 13 skipped, 0 failed
 * </pre>
 */

?>
