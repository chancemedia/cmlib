<?php

/**
 * @page manual_about_version 1.3. Version Log
 * 
 * @section manual_about_version_contents Contents
 * -# \ref manual_about_version_1_0a1
 * -# \ref manual_about_version_1_0a2
 * -# \ref manual_about_version_1_0a3
 * -# \ref manual_about_version_1_0
 * -# \ref manual_about_version_1_1
 * -# \ref manual_about_version_1_2
 * 
 * 
 * @section manual_about_version_1_0a1 v1.0a1
 * First release, includes stand out classes:
 * <ul>
 *   <li>CMConstant</li>
 *   <li>CMDatabaseProtocol</li>
 *   <li>CMDataModel</li>
 *   <li>CMDecimal</li>
 *   <li>CMError</li>
 *   <li>CMFileCSV</li>
 *   <li>CMFileICAL</li>
 *   <li>CMFileVCF</li>
 *   <li>CMForm</li>
 *   <li>CMFormatter</li>
 *   <li>CMHTML</li>
 *   <li>CMMySQL</li>
 *   <li>CMPostgreSQL</li>
 *   <li>CMQueryProtocol</li>
 *   <li>CMSLOC</li>
 *   <li>CMTest</li>
 *   <li>CMValidator</li>
 *   <li>CMVersion</li>
 * </ul>
 * 
 * 
 * @section manual_about_version_1_0a2 v1.0a2 (unreleased)
 *
 * CMPostgreSQL
 * - <a href="http://github.com/chancemedia/cmlib/commit/8049c2381ce87f3021c7b5c6f19c8483264681a7">8049c2381ce87f3021c7</a>
 *   Less warnings when connecting to postgres without all the options.
 * - <a href="http://github.com/chancemedia/cmlib/commit/c992cd62bd871f41a67f28565e01f90fb58d61f7">c992cd62bd871f41a67f</a>
 *   Added CMPostgreSQL::loadSQLFile().
 * - <a href="http://github.com/chancemedia/cmlib/commit/90b0de008a3466a49ffa5f11581c28d292e00a78">90b0de008a3466a49ffa</a>
 *   Added CMPostgreSQL::dropTable(). Added CMPostgreSQL::dropAllTables().
 *   
 * CMGraphic
 * - <a href="http://github.com/chancemedia/cmlib/commit/640f894bbdb5d21780ea8eb6869a754a2b663053">640f894bbdb5d21780ea</a>
 *   Added CMGraphic. Closes #85.
 *   
 * CMGraphicDraw
 * - <a href="http://github.com/chancemedia/cmlib/commit/854e2aa7babf9f26c9664715eae855d53ae6c66f">854e2aa7babf9f26c966</a>
 *   Added CMGraphicDraw class.
 * 
 * CMColor
 * - <a href="http://github.com/chancemedia/cmlib/commit/7c6c485351d1e50dd18e739233b663d0e21873f4">7c6c485351d1e50dd18e</a>
 *   Added CMColor class.
 * 
 * CMFont
 * - <a href="http://github.com/chancemedia/cmlib/commit/1b5eade87aae5c2e4ba5ae31d5c67092ff4f039a">1b5eade87aae5c2e4ba5</a>
 *   Added CMFont and the ability to draw strings with that set font.
 *   
 * CMHTML
 * - <a href="http://github.com/chancemedia/cmlib/commit/a4a535fb8ba9558ffae7d8e0dfd2b55004d2fb27">a4a535fb8ba9558ffae7</a>
 *   CMHTML::Table will now calculate and add in colspan's
 * - <a href="http://github.com/chancemedia/cmlib/commit/d84443f4fe0a4f20eb1fcd2d6daa6f0fa3d841ca">d84443f4fe0a4f20eb1f</a>
 *   Major changes to CMHTML::Table(). There has been a new manual page written on the new changes at manual_html_table.
 * - <a href="http://github.com/chancemedia/cmlib/commit/538580b98c6fe67f5533e86d42b1029279cb2a38">538580b98c6fe67f5533</a>
 *   Added the data replacer to CMHTML, it has been documented.
 *   
 * CMDatabaseProtocol
 * - <a href="http://github.com/chancemedia/cmlib/commit/ef45465473002df8006d6747cc15066a7c4687a5">ef45465473002df8006d</a>
 *   Added CMDatabaseProtocol::escapeEntity().
 * - <a href="http://github.com/chancemedia/cmlib/commit/7aa1a64d8f4c69b62a23e32226f1294dd9f05ea6">7aa1a64d8f4c69b62a23</a>
 *   Fixed bug when not using CMConstant in some CMDatabaseProtocol::insert() situations.
 * - <a href="http://github.com/chancemedia/cmlib/commit/ae2cd49422b4f41577ade3e56def01532803feee">ae2cd49422b4f41577ad</a>
 *   Added CMDatabaseProtocol::describeTable(). Closes #96.
 *   
 * CMDataModel
 * - <a href="http://github.com/chancemedia/cmlib/commit/5c0dc3440fc71fadc32e586bad8d53854fee2c74">5c0dc3440fc71fadc32e</a>
 *   Minor bug fix for CMDataModel so now it uses escapeEntity() for recordExists().
 * - <a href="http://github.com/chancemedia/cmlib/commit/4a00e75295665d02ea7894681720c6e74cc492bc">4a00e75295665d02ea78</a>
 *   All form objects generated from CMDataModel have default names now so you not required to provide any arguments to
 *   generate basic form objects.
 * - <a href="http://github.com/chancemedia/cmlib/commit/36d3ceca17a43230d0258c2f1e2942e7a233ef9d">36d3ceca17a43230d025</a>
 *   Fixed bug in CMDataModel with 'pools' instead of 'pool'
 * - <a href="http://github.com/chancemedia/cmlib/commit/156409481a7db1eb5e15a6e1cf36f0f3a8318777">156409481a7db1eb5e15</a>
 *   CMDataModel::get() now has a third parameter that allows a default value to be returned if the pool variable doesn't
 *   exist and also supresses related error.
 * - <a href="http://github.com/chancemedia/cmlib/commit/5e8deadef0d85421e41b907c05ff8277ca504a62">5e8deadef0d85421e41b</a>
 *   Added CMDataModel::setDefault() - set a variable if it does not exist.
 * - <a href="http://github.com/chancemedia/cmlib/commit/6edf328e59caa7949872c2556a1749d78925e4c6">6edf328e59caa7949872</a>
 *   Fixed a bug in CMDataModel::extractNameValue() that would cause 'value' attribute to be always overridden on form
 *   buttons.
 *   
 * CMStyle
 * - <a href="http://github.com/chancemedia/cmlib/commit/58fa0a97f9917fb465221a168ffb8b5adfc04adb">58fa0a97f9917fb46522</a>
 *   Added CMStyle class for handling CSS styles in an object-orientated way.
 *   
 * CMStyleValidator
 * - <a href="http://github.com/chancemedia/cmlib/commit/17d6e10404c56d44eabcb554c53523aedbd3c457">17d6e10404c56d44eabc</a>
 *   Added CMStyleValidator which is an abstract class for validating the member variables of CMStyle.
 *   
 * CMBox
 * - <a href="http://github.com/chancemedia/cmlib/commit/6671a10a6760f8cf4e65af16cf03b34a44b65d5e">6671a10a6760f8cf4e65</a>
 *   Added CMBox class for drawing HTML container boxes.
 *   
 * CMError
 * - <a href="http://github.com/chancemedia/cmlib/commit/f6fde46ca810113280a6d73b19f4dc802dbccbbf">f6fde46ca810113280a6</a>
 *   The error messages that are printed from CMError are now much easier to read and more detailed.
 *   
 * JavaScript
 * - <a href="http://github.com/chancemedia/cmlib/commit/ad229d099c6cc3532c149c0953ba0cbbc6c9f697">ad229d099c6cc3532c14</a>
 *   New js/ui.js that allow smooth and instant dimming and undimming of the window.
 * 
 * 
 * @section manual_about_version_1_0a3 v1.0a3 (unreleased)
 * This release is focuses on minor changes to the existing classes. More extensive testing suite and a few
 * more minor features throughout the existing classes.
 * 
 * 
 * @section manual_about_version_1_0 v1.0 (unreleased)
 * Clean build of the first major release.
 * 
 * 
 * @section manual_about_version_1_1 v1.1 (unreleased)
 * Added functionality for SQLite3.
 * 
 * 
 * @section manual_about_version_1_2 v1.2 (unreleased)
 * Graphics framework for manipulating and processing images.
 * 
 */

?>
