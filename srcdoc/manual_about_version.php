<?php

/**
 * @page manual_about_version 1.3. Version Log
 * 
 * @section manual_about_version_contents Contents
 * -# \ref manual_about_version_1_0a1
 * -# \ref manual_about_version_1_0a2
 * 
 * 
 * @section manual_about_version_1_0a1 v1.0a1 (28112d16dfd93318361ce95fdd15c1e3e6c81fd0)
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
 * CMBox
 * - <a href="http://github.com/chancemedia/cmlib/commit/6671a10a6760f8cf4e65af16cf03b34a44b65d5e">6671a10a6760f8cf4e65</a>
 *   Added CMBox class for drawing HTML container boxes.
 * 
 * CMColor
 * - <a href="http://github.com/chancemedia/cmlib/commit/7c6c485351d1e50dd18e739233b663d0e21873f4">7c6c485351d1e50dd18e</a>
 *   Added CMColor class.
 *   
 * CMDatabaseProtocol
 * - <a href="http://github.com/chancemedia/cmlib/commit/ef45465473002df8006d6747cc15066a7c4687a5">ef45465473002df8006d</a>
 *   Added CMDatabaseProtocol::escapeEntity().
 * - <a href="http://github.com/chancemedia/cmlib/commit/7aa1a64d8f4c69b62a23e32226f1294dd9f05ea6">7aa1a64d8f4c69b62a23</a>
 *   Fixed bug when not using CMConstant in some CMDatabaseProtocol::insert() situations.
 * - <a href="http://github.com/chancemedia/cmlib/commit/ae2cd49422b4f41577ade3e56def01532803feee">ae2cd49422b4f41577ad</a>
 *   Added CMDatabaseProtocol::describeTable(). Closes #96.
 * - <a href="http://github.com/chancemedia/cmlib/commit/c84214053cce5213d80ac5c9b097f9514853c53a">c84214053cce5213d80a</a>
 *   loadSQLFile() is now standard. Closes #83.
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
 * CMDecimal
 * - <a href="http://github.com/chancemedia/cmlib/commit/da0cee008eb3e777868abf551acbc11978c48434">da0cee008eb3e777868a</a>
 *   CMDecimal should now work nativly with databases. Closes #65.
 *   
 * CMError
 * - <a href="http://github.com/chancemedia/cmlib/commit/f6fde46ca810113280a6d73b19f4dc802dbccbbf">f6fde46ca810113280a6</a>
 *   The error messages that are printed from CMError are now much easier to read and more detailed.
 * - <a href="http://github.com/chancemedia/cmlib/commit/531dc73bcd90fa47deccd3bd07d5dc8505dc4728">531dc73bcd90fa47deccd3bd07d5dc8505dc4728</a>
 *   Even better error reporting from CMError that is now HTML friendly.
 * - <a href="http://github.com/chancemedia/cmlib/commit/283fdcac7b69b78a5231580e15fbad027ede0c37">283fdcac7b69b78a5231580e15fbad027ede0c37</a>
 *   Proper error backtrace printing. Closes #95.
 * 
 * CMFont
 * - <a href="http://github.com/chancemedia/cmlib/commit/1b5eade87aae5c2e4ba5ae31d5c67092ff4f039a">1b5eade87aae5c2e4ba5</a>
 *   Added CMFont and the ability to draw strings with that set font.
 *   
 * CMForm
 * - <a href="http://github.com/chancemedia/cmlib/commit/91ed5f2ffcbd0c6dd4b12302018c2a918a8eaa85">91ed5f2ffcbd0c6dd4b12302018c2a918a8eaa85</a>
 *   Added CMForm::FileBox(), CMForm::CatchUpload(), CMForm::SaveUploadFile(), CMForm::UploadFileExtension().
 *   
 * CMFormatter
 * - <a href="http://github.com/chancemedia/cmlib/commit/65e80e36df4fbc46c7b5dd9154c1a8ce9dfc3d6a">65e80e36df4fbc46c7b5</a>
 *   CMFormatter support HTML now. Closes #92.
 *   
 * CMGraphic
 * - <a href="http://github.com/chancemedia/cmlib/commit/640f894bbdb5d21780ea8eb6869a754a2b663053">640f894bbdb5d21780ea</a>
 *   Added CMGraphic. Closes #85.
 * - <a href="http://github.com/chancemedia/cmlib/commit/ab53cf5f544c46e54a18775f714b9bfb1fcfa6a3">ab53cf5f544c46e54a18</a>
 *   Added static methods CMGraphic::ImageHeight() and CMGraphic::ImageWidth() for easier finding of file resolution.
 *   
 * CMGraphicDraw
 * - <a href="http://github.com/chancemedia/cmlib/commit/854e2aa7babf9f26c9664715eae855d53ae6c66f">854e2aa7babf9f26c966</a>
 *   Added CMGraphicDraw class.
 *   
 * CMHTML
 * - <a href="http://github.com/chancemedia/cmlib/commit/a4a535fb8ba9558ffae7d8e0dfd2b55004d2fb27">a4a535fb8ba9558ffae7</a>
 *   CMHTML::Table will now calculate and add in colspan's
 * - <a href="http://github.com/chancemedia/cmlib/commit/d84443f4fe0a4f20eb1fcd2d6daa6f0fa3d841ca">d84443f4fe0a4f20eb1f</a>
 *   Major changes to CMHTML::Table(). There has been a new manual page written on the new changes at manual_html_table.
 * - <a href="http://github.com/chancemedia/cmlib/commit/538580b98c6fe67f5533e86d42b1029279cb2a38">538580b98c6fe67f5533</a>
 *   Added the data replacer to CMHTML, it has been documented.
 *   
 * CMSerialize
 * - <a href="http://github.com/chancemedia/cmlib/commit/b5f5d789b0c29073525ea4ccae087aba19a6ed50">b5f5d789b0c29073525ea4ccae087aba19a6ed50</a>
 *   Added CMSerialize for packing and unpacking arrays in JSON format. This is made to be partnered with the javascript
 *   module cmSerialize.
 *   
 * CMStyle
 * - <a href="http://github.com/chancemedia/cmlib/commit/58fa0a97f9917fb465221a168ffb8b5adfc04adb">58fa0a97f9917fb46522</a>
 *   Added CMStyle class for handling CSS styles in an object-orientated way.
 *   
 * CMStyleValidator
 * - <a href="http://github.com/chancemedia/cmlib/commit/17d6e10404c56d44eabcb554c53523aedbd3c457">17d6e10404c56d44eabc</a>
 *   Added CMStyleValidator which is an abstract class for validating the member variables of CMStyle.
 *
 * CMPostgreSQL
 * - <a href="http://github.com/chancemedia/cmlib/commit/8049c2381ce87f3021c7b5c6f19c8483264681a7">8049c2381ce87f3021c7</a>
 *   Less warnings when connecting to postgres without all the options.
 * - <a href="http://github.com/chancemedia/cmlib/commit/c992cd62bd871f41a67f28565e01f90fb58d61f7">c992cd62bd871f41a67f</a>
 *   Added CMPostgreSQL::loadSQLFile().
 * - <a href="http://github.com/chancemedia/cmlib/commit/90b0de008a3466a49ffa5f11581c28d292e00a78">90b0de008a3466a49ffa</a>
 *   Added CMPostgreSQL::dropTable(). Added CMPostgreSQL::dropAllTables().
 * - <a href="http://github.com/chancemedia/cmlib/commit/f76fa13556c1863dd594f1f1b35464ba4f1118d3">f76fa13556c1863dd594</a>
 *   Host parameter for CMPostgreSQL now defaults to '' rather than 'localhost'.
 * - <a href="http://github.com/chancemedia/cmlib/commit/70c1a20e2500ad558b28839f8e205e58e674ed1c">70c1a20e2500ad558b28</a>
 *   CMPostgreSQL::castSafeType() is now array aware for type casting. Added CMPostgreSQL::Arrayify() to convert an array
 *   from the database into a PHP array. Arrayify() may become part of the database standard for all engines that support
 *   array data types, or even the use of strings as if they were stored database arrays.
 * - <a href="http://github.com/chancemedia/cmlib/commit/7a351726f973b9db0aebceb89fc0a532651ea916">7a351726f973b9db0aebceb89fc0a532651ea916</a>
 *   CMPostgreSQL will treat empty int's as NULL values now.
 * - <a href="http://github.com/chancemedia/cmlib/commit/633d6f5daadcffd0990190dc321cfbb5e2de3922">633d6f5daadcffd0990190dc321cfbb5e2de3922</a>
 *   Fixed bug with CMPostgreSQL::update().
 *   
 * JavaScript
 * - <a href="http://github.com/chancemedia/cmlib/commit/ad229d099c6cc3532c149c0953ba0cbbc6c9f697">ad229d099c6cc3532c14</a>
 *   New js/ui.js that allow smooth and instant dimming and undimming of the window.
 * - <a href="http://github.com/chancemedia/cmlib/commit/106092f0cfe05e85ca74092bb216c35f0abae897">106092f0cfe05e85ca74</a>
 *   cmTableAddRow() now uses correct JSON parsing to apply tr and td attributes.
 * - <a href="http://github.com/chancemedia/cmlib/commit/610b3fe2e352657d820b1ed7336376b62380ea66">610b3fe2e352657d820b1ed7336376b62380ea66</a>
 *   Added cmAjaxUploadFile().
 * - <a href="http://github.com/chancemedia/cmlib/commit/10a6133f20941da1ce1cf0572a9125ae5c3715b5">10a6133f20941da1ce1cf0572a9125ae5c3715b5</a>
 *   MAJOR: JavaScript for cmlib has been split into dynamically loadable modules. Use cmLoadModule() or cmLoadModules().
 * - <a href="http://github.com/chancemedia/cmlib/commit/79aa63302e8550d79549e3306b18b12a9ba9ff3f">79aa63302e8550d79549e3306b18b12a9ba9ff3f</a>
 *   Added submitAjaxForm() and submitAjax().
 * 
 */

?>
