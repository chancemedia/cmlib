<?php

include_once('CMClass.php');
include_once('CMForm.php');
include_once('CMValidator.php');
include_once('CMError.php');
include_once('CMHeader.php');

// we need to load these otherwise the session variables can't deal with the database objects
include_once('CMMySQL.php');
include_once('CMOracle.php');
include_once('CMPostgreSQL.php');

/**
 * @brief Data model provides above-session data modeling.
 * 
 * @section description Description
 * The data model provides a way to use data between the backend server, the database and the front
 * end HTML objects in a way that is non-ambiguous, safe and easy.
 * 
 * @author Elliot Chance
 * @since 1.0
 */
class CMDataModel extends CMError implements CMClass {
	
	/**
	 * @brief The version of this class.
	 * @return String version.
	 * @see CMVersion
	 */
	public static function Version() {
		return "1.0";
	}
	
	/**
	 * @brief The version this class was introduced to the library.
	 * @return String version.
	 * @see CMVersion
	 */
	public static function Since() {
		return "1.0";
	}
	
	/**
	 * @brief Database handle.
	 * 
	 * @see getDatabase()
	 * @see hasDatabase()
	 * @see setDatabase()
	 */
	private $dbh = false;
	
	/**
	 * @brief CMValidator handle.
	 * 
	 * @see getValidator()
	 * @see hasValidator()
	 * @see setValidator()
	 */
	private $vh = false;
	
	/**
	 * @brief Storage pools.
	 * 
	 * By default there are three pools called 'public', 'get' and 'post' where the last two are
	 * automatically filled and maintained by the $_GET and $_POST data respectivly.
	 * 
	 * @see set()
	 * @see get()
	 * @see addPool()
	 * @see deletePool()
	 * @see renamePool()
	 */
	private $pool = array();
	
	/**
	 * @brief Values that will always be determined to be \false (unchecked) with checkboxes.
	 */
	public $falseValues = array();
	
	/**
	 * @brief Values that will always be determined to be \true (checked) with checkboxes.
	 */
	public $trueValues = array();
	
	/**
	 * @brief The global pool.
	 * 
	 * @see setGlobal()
	 * @see getGlobal()
	 */
	private static $GlobalPool = array();
	
	/**
	 * @brief The data model name.
	 */
	private $name = 'default';
	
	/**
	 * @brief Keeps track of the URL history.
	 * @see submitBackwards()
	 */
	public $history = array();
	
	/**
	 * @brief Create or restore a data model.
	 * 
	 * If the data model does not exist it will be created.
	 * 
	 * @param $name The model name attached to this session, if this is not provided it will
	 * use/create a pool named <tt>default</tt>.
	 */
	public function CMDataModel($name = 'default') {
		$this->name = $name;
		
		// setup default pools
		$this->addPool('get');
		$this->addPool('post');
		$this->addPool('public');
	}
	
	/**
	 * @brief Check if a data model exists.
	 * 
	 * @param $name An optional data model name, if no $name is provided 'default' is used.
	 * @return \true or \false
	 */
	public static function DataModelExists($name = 'default') {
		return isset($_SESSION["datamodel_$name"]);
	}
	
	/**
	 * @brief Get a data model by name.
	 * 
	 * If the data model does not exist, it is created.
	 * 
	 * @param $name An optional data model name, if no $name is provided 'default' is used.
	 * @return CMDataModel object.
	 */
	public static function GetDataModel($name = 'default') {
		// create it if needed
		if(!isset($_SESSION["datamodel_$name"]))
			$_SESSION["datamodel_$name"] = new CMDataModel($name);
		$dm = $_SESSION["datamodel_$name"];
		
		// load the $_GET and $_POST
		$dm->addPool('get', true);
		$dm->addPool('post', true);
		$dm->fillPool(CMForm::StripSlashesRecursive($_GET), 'get');
		$dm->fillPool(CMForm::StripSlashesRecursive($_POST), 'post');
		
		// fill custom pools
		foreach($_POST as $k => $v) {
			if(is_array($v)) {
				// create the pool if needed
				if(!$dm->poolExists($k))
					$dm->addPool($k);
				$dm->fillPool($v, $k);
			}
		}
		
		// append history information
		array_push($dm->history, array(
			'url' => $_SERVER['PHP_SELF'],
			'ts' => time()
		));
		
		return $dm;
	}
	
	/**
	 * @brief Get this data model's name.
	 * 
	 * If no model name was set when creating this data model object, the default name of
	 * <tt>'default'</tt> would of been used.
	 * 
	 * @return String name.
	 */
	public function getDataModelName() {
		return $this->name;
	}
	
	/**
	 * @brief Get a variable from a pool.
	 * 
	 * @throwsWarning If the pool does not exist.
	 *
	 * @note If you provide a value for \p $default you will not get an error, instead it will return
	 *       the value of \p $default.
	 * 
	 * @param $name The name of the variable.
	 * @param $pool An optional argument to specify the pool name, if no argument is given then the
	 *        <tt>'public</tt> pool will be used.
	 * @param $default Return this value if the variable does not exist.
	 * @return If the variable exists in the pool the value will be returned, if the variable does
	 *         not exist NULL is returned.
	 *         
	 * @see set()
	 * @see request()
	 */
	public function get($name, $pool = 'public', $default = NULL) {
		// if the pool doesn't exist we'll chuck an error
		if(!$this->poolExists($pool)) {
			if($default == NULL)
				$this->throwWarning("Pool '$pool' does not exist.");
			return $default;
		}
		
		if(!isset($this->pool[$pool][$name]))
			return $default;
		
		return $this->pool[$pool][$name];
	}
	
	/**
	 * @brief Set a variable in a pool.
	 * 
	 * If the variable does not exist it will be created, if it does exist the value will be
	 * replaced. If the pool does not exist, NULL will be returned and the variable will be
	 * discarded.
	 * 
	 * @throwsWarning If the pool doesn't exist.
	 * 
	 * @param $name The name of the variable.
	 * @param $value The value of any type. If this is not specified \false will be used.
	 * @param $pool The pool name. If this is not specified the default <tt>'public'</tt> pool will
	 *        be used.
	 * @return If the assignment was successful the same valeu will be returned. If the assignment
	 *         failed, NULL is returned.
	 *         
	 * @see get()
	 * @see request()
	 */
	public function set($name, $value = false, $pool = 'public') {
		// make sure the pool exists
		if(!$this->poolExists($pool)) {
			$this->throwWarning("Pool '$pool' does not exist.");
			return NULL;
		}
		
		// set the variable
		$this->pool[$pool][$name] = $value;
		return $this->pool[$pool][$name];
	}
	
	/**
	 * @brief Request a variable from the $_GET or $_POST.
	 * 
	 * This method makes it easier to return $_GET and $_POST values by returning the $_GET if
	 * available, if not the $_POST if available, if not NULL.
	 * 
	 * @param $name The name of the variable.
	 * @return The value if it can be found, otherwise NULL.
	 */
	public function request($name) {
		if($this->exists($name, 'get'))
			return $this->get($name, 'get');
		if($this->exists($name, 'post'))
			return $this->get($name, 'post');
		return NULL;
	}
	
	/**
	 * @brief Get the CMValidator
	 * 
	 * @return \false if no validator has been set, otherwise the validator object.
	 * 
	 * @see setValidator()
	 * @see hasValidator()
	 */
	public function getValidator() {
		return $this->vh;
	}
	
	/**
	 * @brief Has the validator been set?
	 * 
	 * @return \true or \false if the validator has been set.
	 * 
	 * @see setValidator()
	 * @see getValidator()
	 */
	public function hasValidator() {
		return $this->vh !== false;
	}
	
	/**
	 * @brief Has the database handle been set?
	 * 
	 * @return \true or \false if the database handle has been set.
	 * 
	 * @see setDatabase()
	 * @see getDatabase()
	 */
	public function hasDatabase() {
		return $this->dbh !== false;
	}
	
	/**
	 * @brief Redirect page location.
	 * 
	 * This method will only work if no data has been written to the page. This method is a
	 * convienient alias for CMHeader::Location().
	 * 
	 * @param $url The location do direct the user to.
	 * @param $values Substitute values passed directly to CMHeader::Location().
	 * @return Nothing.
	 * @see CMHeader::Location()
	 */
	public function redirect($url, $values = array()) {
		CMHeader::Location($url, $values);
	}
	
	/**
	 * @brief Check if a variable exists in a pool.
	 * 
	 * @param $name The name of the variable.
	 * @param $pool The name of the pool.
	 * @return \true or \false.
	 */
	public function exists($name, $pool = 'public') {
		// check if the pool exists
		if(!isset($this->pool[$pool]))
			return false;
			
		return isset($this->pool[$pool][$name]);
	}
	
	/**
	 * @brief Set a variable in the global pool.
	 * 
	 * @param $name The name of the variable.
	 * @param $value The value of any type. If this is not specified, \false will be used.
	 * @return The same $value provided.
	 * 
	 * @see getGlobal()
	 */
	public function setGlobal($name, $value = false) {
		CMDataModel::$GlobalPool[$name] = $value;
		return CMDataModel::$GlobalPool[$name];
	}

	/**
	 * @brief Get a variable from the global pool.
	 * 
	 * @param $name The name of the variable.
	 * @return The value of the variable if it exists, otherwise NULL.
	 * 
	 * @see setGlobal()
	 */
	public function getGlobal($name) {
		if(!isset(CMDataModel::$GlobalPool[$name]))
			return NULL;
			
		return CMDataModel::$GlobalPool[$name];
	}
	
	/**
	 * @brief Check if a pool exists.
	 * 
	 * @param $name The name of the pool.
	 * @return \true or \false.
	 */
	public function poolExists($name = 'public') {
		return isset($this->pool[$name]);
	}
	
	/**
	 * @brief Set the database handle.
	 * 
	 * @param $database Active database handle.
	 * @return \true
	 * 
	 * @see getDatabase()
	 * @see hasDatabase()
	 */
	public function setDatabase(CMDatabaseProtocol $database) {
		$this->dbh = $database;
		return true;
	}
	
	/**
	 * @brief Delete a pool.
	 * 
	 * @note You are not allowed to delete the <tt>'public'</tt> pool. If you wish to reset it
	 *       use <code>drainPool('public')</code>.
	 * 
	 * @param $name The pool name.
	 * @return \true.
	 */
	public function deletePool($name) {
		unset($_SESSION["datamodel_$name"]);
		return true;
	}
	
	/**
	 * @brief Return the database handle.
	 * 
	 * If the database handle has not been set, \false is returned.
	 * 
	 * @return The database handle or \false.
	 * 
	 * @see setDatabase()
	 * @see hasDatabase()
	 */
	public function getDatabase() {
		return $this->dbh;
	}
	
	/**
	 * @brief Drain (reset, wipe, clear) a pool or pools of all its variables.
	 * 
	 * This will also drain the validator of the fields that apply to this pool(s).
	 * 
	 * @throwsNotice For each pool that doesn't exist.
	 * 
	 * @param $name The name of the pool or and array of pool names.
	 */
	public function drainPool($name = 'public') {
		// recurse if needed
		if(is_array($name)) {
			foreach($name as $n) {
				if(!$this->drainPool($n))
					return false;
			}
			return true;
		}
		
		// make sure the pool exists
		if(!$this->poolExists($name)) {
			$this->throwNotice("Pool '$name' does not exist.");
			return false;
		}
		
		// drain pool
		$this->pool[$name] = array();
		
		// drain validator
		if($this->vh !== false) {
			foreach($this->vh->invalidFields as $k => $v) {
				$pos = strpos($k, '[');
				if($pos !== false && substr($k, 0, $pos) == $name)
					unset($this->vh->invalidFields[$k]);
			}
		}
		
		return true;
	}
	
	/**
	 * @brief Validate
	 * 
	 * Using the CMValidator provided by setValidator(). If there is not validator set this function
	 * will return \true.
	 * 
	 * @return \true or \false.
	 * 
	 * @see setValidator()
	 * @see getValidator()
	 * @see hetValidator()
	 */
	public function validate() {
		// make sure we have a validating object
		if($this->vh === false)
			return true;
		
		return $this->vh->validate($this);
	}
	
	/**
	 * @brief Set the validator object.
	 * 
	 * @param $validator CMValidator object.
	 * @return \true
	 * 
	 * @see getValidator()
	 * @see hasValidator()
	 */
	public function setValidator(CMValidator $validator) {
		$this->vh = $validator;
		return true;
	}
	
	/**
	 * @brief Get a pool as an array.
	 * 
	 * @throwsWarning If the pool doesn't exist.
	 * 
	 * @param $name The name of the pool. If not specified, the 'default' pool is selected. If the
	 *        pool doesn't exists, \false is returned.
	 */
	public function getPool($name = 'public') {
		// make sure the pool exists
		if(!$this->poolExists($name)) {
			$this->throwWarning("Pool '$name' does not exist.");
			return false;
		}
		
		return $this->pool[$name];
	}
	
	/**
	 * @brief Perform a database \c INSERT.
	 * 
	 * This method simply provides a bridge between a pool or an associative array of data and the
	 * CMDatabaseProtocol::insert() method. This means that all the fields in the pool or array
	 * provided by \p $fields will be passed to the insert(). If there are any fields in the pool or
	 * array keys that do no directly match fields in the table the result SQL will most likely fail.
	 * 
	 * @throwsWarning If the database handle is invalid.
	 * 
	 * @param $tableName The name of the table to \c INSERT into.
	 * @param $fields If the \p $fields are 'auto' (or not supplied) we use the pool that is the
	 *        same name as the table.
	 * @param $a Extra options passed to CMDatabaseProtocol::insert().
	 * @return On success the return value from the insert() will be passed on. This will be the
	 *         newly created primary key. But be careful since \c 0 is a possible generated primary
	 *         key. Use \false to exact compare against or check the error stack to make sure the
	 *         statement didn't fail.
	 * @see databaseUpdate()
	 * @see databaseDelete()
	 */
	public function databaseInsert($tableName, $fields = 'auto', $a = false) {
		// if the $fields are 'auto' we use the pool that is the same name as the table
		if($fields == 'auto') {
			if(!$this->poolExists($tableName))
				return $this->throwWarning("Pool '$tableName' does not exist.");
			$fields = $this->pool[$tableName];
		}
			
		// we need a database handle
		if(!$this->dbh)
			return $this->throwWarning("No database handle.");
		
		// perform the insert
		return $this->dbh->insert($tableName, $fields, $a);
	}
	
	/**
	 * @brief Perform a database \c UPDATE.
	 * 
	 * This method works in the same way as databaseInsert() with the difference it performs an
	 * equivilent \c UPDATE using CMDatabaseProtocol::update().
	 * 
	 * See databaseInsert() for more information.
	 * 
	 * @throwsWarning If the database handle is invalid.
	 * 
	 * @param $tableName The name of the table to update.
	 * @param $filter An associative array to be used in the \c WHERE clause.
	 * @param $fields Field data.
	 * @param $a Extra options passed to CMDatabaseProtocol::update().
	 * @see databaseInsert()
	 * @see databaseDelete()
	 */
	public function databaseUpdate($tableName, $filter, $fields = 'auto', $a = false) {
		// if the $fields are 'auto' we use the pool that is the same name as the table
		if($fields == 'auto') {
			if(!$this->poolExists($tableName))
				return $this->throwWarning("Pool '$tableName' does not exist.");
			$fields = $this->pool[$tableName];
		}
			
		// we need a database handle
		if(!$this->dbh)
			return $this->throwWarning("No database handle.");
		
		// perform the update
		return $this->dbh->update($tableName, $fields, $filter, $a);
	}
	
	/**
	 * @brief Perform a database \c DELETE.
	 * 
	 * This method works in the same way as databaseInsert() with the difference it performs an
	 * equivilent \c DELETE using CMDatabaseProtocol::delete().
	 * 
	 * See databaseInsert() for more information.
	 * 
	 * @throwsWarning If the database handle is invalid.
	 * 
	 * @param $tableName The name of the table to update.
	 * @param $filter An associative array to be used in the \c WHERE clause.
	 * @param $a Extra options passed to CMDatabaseProtocol::delete().
	 * @see databaseInsert()
	 * @see databaseUpdate()
	 */
	public function databaseDelete($tableName, $filter, $a = false) {
		// we need a database handle
		if(!$this->dbh)
			return $this->throwWarning("No database handle.");
		
		// perform the delete
		return $this->dbh->delete($tableName, $filter, $a);
	}
	
	/**
	 * @brief Add a new pool.
	 * 
	 * @param $name The name of the new pool.
	 * @param $replace If \true and the pool already exists it will be replaced with a blank pool.
	 *        The default is \false - the pool will not be modified if it already exists.
	 * @return Always \true.
	 */
	public function addPool($name, $replace = false) {
		// if $replace is off and the pool exists we take no action
		if(!$replace && $this->poolExists($name))
			return true;
		
		$this->pool[$name] = array();
		return true;
	}
	
	/**
	 * @brief Fill (but not wipe) a pool from an array.
	 * 
	 * @throwsWarning If the pool doesn't exist.
	 * 
	 * @param $values Associative array of objects to append/replace in the pool.
	 * @param $name An optional name of the pool, if this is not supplied the 'default' pool will
	 *        will be used.
	 * @see setPool()
	 */
	public function fillPool(array $values, $name = 'public') {
		// make sure the pool exists
		if(!$this->poolExists($name))
			return $this->throwWarning("Pool '$name' does not exist.");
		
		// add items to the pool
		foreach($values as $k => $v)
			$this->pool[$name][$k] = $v;
		
		return true;
	}
	
	/**
	 * @brief Get the names of all the data models connected with this session.
	 * 
	 * @return Simple array of data model names.
	 */
	public static function GetDataModelNames() {
		$r = array();
		foreach(array_keys($_SESSION) as $k) {
			if(substr($k, 0, 10) == 'datamodel_')
				array_push($r, substr($k, 10));
		}
		return $r;
	}
	
	/**
	 * @brief Create a new data model.
	 * 
	 * @param $name Name of the new data model.
	 * @param $force If this is true and a data model of $name already exists then it will be
	 *        replaced with a new data model.
	 * @return The newly created data model object.
	 */
	public static function CreateDataModel($name = 'default', $force = false) {
		// check if the data model already exists
		if(isset($_SESSION["datamodel_$name"])) {
			if($force)
				$_SESSION["datamodel_$name"] = new CMDataModel($name);
		} else $_SESSION["datamodel_$name"] = new CMDataModel($name);
		
		return $_SESSION["datamodel_$name"];
	}
	
	/**
	 * @brief Delete a data model.
	 * 
	 * @param $name The name of the data model to delete.
	 * @return Always \true.
	 */
	public static function DeleteDataModel($name = 'default') {
		unset($_SESSION["datamodel_$name"]);
		return true;
	}
	
	/**
	 * @brief Get history URLs.
	 * 
	 * @see submitBackwards()
	 */
	public function getHistory() {
		return $this->history;
	}
	
	/**
	 * @brief Submit to a previous location.
	 * 
	 * @param $length How many pages to go back where the previous page is 1, the page before that
	 *        is 2 etc. If not supplied this will default to 1.
	 */
	public function submitBackwards($length = 1) {
		$this->redirect($this->history[count($this->history) - $length - 1]['url']);
	}
	
	/**
	 * @brief Extract the bare name and real value from a variable.
	 * 
	 * This is mostly and internal method, it is public because other classes need to use it.
	 * 
	 * @param $name The variable unspecific to any pool.
	 * @return A two element array of the bare name and value. If the variable doesn't exist in the
	 *         pool NULL is returned for the second array element.
	 */
	public function extractNameValue($name) {
		$pos = strpos($name, '[');
		if($pos !== false) {
			$pool = substr($name, 0, $pos);
			$newname = substr($name, $pos + 1, strlen($name) - $pos - 2);
			
			if(isset($this->pool[$pool][$newname]))
				return array($name, $this->pool[$pool][$newname]);
			return array($name, NULL);
		}
		
		if(isset($this->pool['public'][$name]))
			return array($name, $this->pool['public'][$name]);
		return array($name, NULL);
	}
	
	/**
	 * @brief Render a text box.
	 * 
	 * This function is an alias of CMForm::TextBox with the only difference being that the the HTML
	 * object value is supplied from the pool.
	 * 
	 * @note If $a['name'] or $a['value'] is provided it will be replaced before rendering the
	 *       object.
	 * 
	 * @param $name The name of the text box that also determines the pool and variable of where the
	 *        data comes from.
	 * @param $a The options to be passed directly to CMForm.
	 */
	public function textBox($name = 'textbox', $a = false) {
		list($a['name'], $a['value']) = $this->extractNameValue($name);
		return CMForm::TextBox($a);
	}
	
	/**
	 * @brief Render a password box.
	 * 
	 * This function is an alias of CMForm::PasswordBox with the only difference being that the the HTML
	 * object value is supplied from the pool.
	 * 
	 * @note If $a['name'] or $a['value'] is provided it will be replaced before rendering the
	 *       object.
	 * 
	 * @param $name The name of the password box that also determines the pool and variable of where the
	 *        data comes from.
	 * @param $a The options to be passed directly to CMForm.
	 */
	public function passwordBox($name = 'password', $a = false) {
		list($a['name'], $a['value']) = $this->extractNameValue($name);
		return CMForm::PasswordBox($a);
	}
	
	/**
	 * @brief Render a form submit button.
	 * 
	 * This function is an alias of CMForm::SubmitButton with the only difference being that the the
	 * HTML object value is supplied from the pool.
	 * 
	 * @note If $a['name'] or $a['value'] is provided it will be replaced before rendering the
	 *       object.
	 * 
	 * @param $name The name of the submit button that also determines the pool and variable of where
	 *        the data comes from.
	 * @param $a The options to be passed directly to CMForm.
	 */
	public function submitButton($name = 'submit', $a = false) {
		list($a['name'], $a['value']) = $this->extractNameValue($name);
		return CMForm::SubmitButton($a);
	}
	
	/**
	 * @brief Render a form reset button.
	 * 
	 * This function is an alias of CMForm::ResetButton with the only difference being that the the
	 * HTML object value is supplied from the pool.
	 * 
	 * @note If $a['name'] or $a['value'] is provided it will be replaced before rendering the
	 *       object.
	 * 
	 * @param $name The name of the reset button that also determines the pool and variable of where
	 *        the data comes from.
	 * @param $a The options to be passed directly to CMForm.
	 */
	public function resetButton($name = 'reset', $a = false) {
		list($a['name'], $a['value']) = $this->extractNameValue($name);
		return CMForm::ResetButton($a);
	}
	
	/**
	 * @brief Render a non-submit form button.
	 * 
	 * This function is an alias of CMForm::Button with the only difference being that the the
	 * HTML object value is supplied from the pool.
	 * 
	 * @note If $a['name'] or $a['value'] is provided it will be replaced before rendering the
	 *       object.
	 * 
	 * @param $name The name of the button that also determines the pool and variable of where
	 *        the data comes from.
	 * @param $a The options to be passed directly to CMForm.
	 */
	public function button($name = 'button', $a = false) {
		list($a['name'], $a['value']) = $this->extractNameValue($name);
		return CMForm::Button($a);
	}
	
	/**
	 * @brief Render a hidden field.
	 * 
	 * This function is an alias of CMForm::Hidden with the only difference being that the the HTML
	 * object value is supplied from the pool.
	 * 
	 * @note If $a['name'] or $a['value'] is provided it will be replaced before rendering the
	 *       object.
	 * 
	 * @param $name The name of the hidden field that also determines the pool and variable of where the
	 *        data comes from.
	 * @param $a The options to be passed directly to CMForm.
	 */
	public function hidden($name = 'hidden', $a = false) {
		list($a['name'], $a['value']) = $this->extractNameValue($name);
		return CMForm::Hidden($a);
	}
	
	/**
	 * @brief Render a drop down menu.
	 * 
	 * This function is an alias of CMForm::Menu with the only difference being that the the HTML
	 * object value is supplied from the pool.
	 * 
	 * @note The value is transalated into the selected value, rather than the values of the menu
	 *       items. You are expected to also provide an array of menu items.
	 * 
	 * @note If $a['name'] or $a['value'] is provided it will be replaced before rendering the
	 *       object.
	 * 
	 * @param $name The name of the hidden field that also determines the pool and variable of where the
	 *        data comes from.
	 * @param $a The options to be passed directly to CMForm.
	 */
	public function menu($name = 'menu', $a = false) {
		list($a['name'], $a['value']) = $this->extractNameValue($name);
		return CMForm::Menu($a);
	}
	
	/**
	 * @brief Render a checkbox.
	 * 
	 * This function is an alias of CMForm::Checkbox with the only difference being that the the HTML
	 * object value is supplied from the pool.
	 * 
	 * @note If $a['name'] or $a['value'] is provided it will be replaced before rendering the
	 *       object.
	 * 
	 * @param $name The name of the checkbox that also determines the pool and variable of where the
	 *        data comes from.
	 * @param $a The options to be passed directly to CMForm.
	 */
	public function checkbox($name = 'checkbox', $a = false) {
		list($a['name'], $a['value']) = $this->extractNameValue($name);
		$a['checked'] = $this->determineChecked($a['value']);
		return CMForm::Checkbox($a);
	}
	
	/**
	 * @brief Render a list.
	 * 
	 * This function is an alias of CMForm::ListBox with the only difference being that the the HTML
	 * object value is supplied from the pool.
	 * 
	 * @note The value is transalated into the selected value, rather than the values of the list box
	 *       items. You are expected to also provide an array of list box items.
	 * 
	 * @note If $a['name'] or $a['value'] is provided it will be replaced before rendering the
	 *       object.
	 * 
	 * @param $name The name of the list box that also determines the pool and variable of where the
	 *        data comes from.
	 * @param $a The options to be passed directly to CMForm.
	 */
	public function listBox($name = 'listbox', $a = false) {
		list($a['name'], $a['value']) = $this->extractNameValue($name);
		return CMForm::ListBox($a);
	}
	
	/**
	 * @brief Render a group of radio buttons.
	 * 
	 * This function is an alias of CMForm::RadioGroup with the only difference being that the the HTML
	 * object value is supplied from the pool.
	 * 
	 * @note The value is transalated into the selected value, rather than the values of the radio 
	 *       buttons. You are expected to also provide an array of radio items.
	 * 
	 * @note If $a['name'] or $a['value'] is provided it will be replaced before rendering the
	 *       object.
	 * 
	 * @param $name The name of the radio group that also determines the pool and variable of where the
	 *        data comes from.
	 * @param $a The options to be passed directly to CMForm.
	 */
	public function radioGroup($name = 'radiogroup', $a = false) {
		list($a['name'], $a['value']) = $this->extractNameValue($name);
		return CMForm::RadioGroup($a);
	}
	
	/**
	 * @brief Render a group of checkboxes.
	 * 
	 * This function is an alias of CMForm::CheckboxGroup with the only difference being that the the
	 * HTML object value is supplied from the pool.
	 * 
	 * @note The value is transalated into the selected value, rather than the values of the checkboxes.
	 *       You are expected to also provide an array of radio items.
	 * 
	 * @note If $a['name'] or $a['value'] is provided it will be replaced before rendering the
	 *       object.
	 * 
	 * @param $name The name of the checkbox group that also determines the pool and variable of where
	 *        the data comes from.
	 * @param $a The options to be passed directly to CMForm.
	 */
	public function checkboxGroup($name = 'checkboxgroup', $a = false) {
		list($a['name'], $a['value']) = $this->extractNameValue($name);
		return CMForm::CheckboxGroup($a);
	}
	
	/**
	 * @brief Render a text area.
	 * 
	 * This function is an alias of CMForm::TextArea with the only difference being that the the HTML
	 * object value is supplied from the pool.
	 * 
	 * @note If $a['name'] or $a['value'] is provided it will be replaced before rendering the
	 *       object.
	 * 
	 * @param $name The name of the text area that also determines the pool and variable of where the
	 *        data comes from.
	 * @param $a The options to be passed directly to CMForm.
	 */
	public function textArea($name = 'textarea', $a = false) {
		list($a['name'], $a['value']) = $this->extractNameValue($name);
		return CMForm::TextArea($a);
	}
	
	/**
	 * @brief Get an array of the invalid fields.
	 * 
	 * @see validate()
	 * @see fieldError()
	 */
	public function getInvalidFields() {
		return $this->vh->getInvalidFields();
	}
	
	/**
	 * @brief A human-readable explanation of why the validation failed.
	 * 
	 * @param $name The name of the field. If the field did validate "" is returned, otherwise the
	 *        short human-readable error message.
	 */
	public function fieldError($name) {
		if(is_array($this->vh->invalidFields[$name]))
			return implode(', ', $this->vh->invalidFields[$name]);
		return "";
	}
	
	/**
	 * @brief Replace a pool with an array.
	 * 
	 * If the pool does not exist it will created, if it does exist it will be replaced by the
	 * content in \p $values.
	 * 
	 * @param $values An associative array of values to set the pool to.
	 * @param $name The name of the pool.
	 * @return Always \true.
	 */
	public function setPool(array $values, $name = 'default') {
		$this->pool[$name] = $values;
		return true;
	}
	
	/**
	 * @brief Set multiple pools.
	 * 
	 * If any of the pools do not exist they will be created.
	 * 
	 * @param $pools An associative array of pool names as keys.
	 * @return Always \true.
	 */
	public function setPools(array $pools) {
		foreach($pools as $k => $v)
			$this->setPool($k, $v);
		return true;
	}
	
	/**
	 * @brief Check if a table contains one or more records where all the values in a pool match a
	 *        single databse row.
	 *        
	 * For example if the pool was;
	 * @code
	 * (
	 *   'username' => 'bobsmith',
	 *   'password' => 'abc123',
	 *   'type' => 5
	 * )
	 * @endcode
	 * 
	 * The result SQL would be:
	 * @code
	 * SELECT COUNT(1) FROM mytable WHERE username='bobsmith' AND password='abc123' AND type=5;
	 * @endcode
	 * 
	 * @param $pool The name of the pool.
	 * @param $tableName The database table name. This is optional, if not supplied the table name
	 *        will be the same as the pool name.
	 * @param $extra An associative array of extra fields to add to the WHERE clause.
	 * @return \true if count() returns 1 record or more, otherwise \false. If the pool does not exist
	 *         \false will also be returned. If there is no database handle \false will also be returned.
	 */
	public function recordExists($pool, $tableName = false, $extra = array()) {
		// we need a table name
		if($tableName === false)
			$tableName = $pool;
			
		// the pool must exist
		if(!$this->poolExists($pool))
			return false;
			
		// we must have a database
		if($this->dbh === false)
			return false;
		
		// create SQL
		$sql = "SELECT COUNT(1) FROM $tableName WHERE ";
		$first = true;
		foreach($this->pool[$pool] as $k => $v) {
			if(!$first)
				$sql .= " AND ";
			else
				$first = false;
			
			$sql .= $this->dbh->escapeEntity($k) . "='$v'";
		}
		foreach($extra as $k => $v) {
			if(!$first)
				$sql .= " AND ";
			else
				$first = false;
			
			$sql .= $this->dbh->escapeEntity($k) . "='$v'";
		}
		
		// perform lookup
		return $this->dbh->query($sql)->fetch('cell') > 0;
	}
	
	/**
	 * @brief Determine the boolean value based on falseValues and trueValues.
	 * 
	 * @param $value The value to test.
	 * @return \true or \false.
	 */
	private function determineChecked($value) {
		// first check the falseValues
		foreach($this->falseValues as $v) {
			if($value == $v)
				return false;
		}
	
		// first check the trueValues
		foreach($this->trueValues as $v) {
			if($value == $v)
				return true;
		}
		
		// if its neither then use PHP rules to cast
		return (boolean) $value;
	}
	
	/**
	 * @brief Return the string value of this object.
	 */
	public function __toString() {
		return "<" . get_class($this) . ">";
	}
	
	/**
	 * @brief Get all pools.
	 * @return Multidimentional array of pools.
	 */
	public function getPools() {
		return $this->pool;
	}
	
}

// make sure the session is started
// WARNING: this line must be after the class definition
session_start();

?>
