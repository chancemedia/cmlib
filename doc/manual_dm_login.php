<?php

/**
 * @page manual_dm_login 6.3. Handling Logins
 * 
 * @section manual_dm_login_contents Contents
 * -# \ref manual_dm_login_example
 * -# \ref manual_dm_login_logout
 * -# \ref manual_dm_login_access
 * 
 * 
 * @section manual_dm_login_example Example
 * @code
 * <?php
 * include_once("cmlib/lib/CMDataModel.php");
 * 
 * // get the default data model
 * $dm = CMDataModel::GetDataModel();
 * 
 * // attach a database if this hasn't already been done, lets use MySQL
 * if(!$dm->hasDatabase())
 *   $dm->setDatabase(new CMMySQL("mysql://root:abcd1234@localhost/test"));
 * 
 * // if the login form was submitted
 * if($dm->request('submit')) {
 * 	
 *   // force the reset of a 'login' pool
 *   $dm->addPool('login', true);
 *   
 *   // set the login credentials, the name of the pool variables must match the login data table
 *   $dm->set('username', $dm->request('user'), 'login');
 *   $dm->set('password', $dm->request('pass'), 'login');
 * }
 * 
 * // the above if statement is only performed when they need to login, after which point we only need
 * // the following code on top of each protected page
 * // the name of the table is 'account' and the fields are 'username' and 'password' to validate
 * // against. it is important the variable names in the pool match the field names in the pool.
 * // if there login isn't valid we bounce them back to the login.php page.
 * if(!$dm->recordExists('login', 'account'))
 *   $dm->redirect("login.php");
 *   
 * // the rest of your script will flow on from here ...
 * 
 * @endcode
 * 
 * 
 * @section manual_dm_login_logout Issuing a Logout
 * In most cases issuing a logout is as easy as resetting the pool that contains the authentication
 * information. Your script should be checking every page if the login credentials are correct, therefore if
 * they are reset the next page will be able to throw them back to the login page.
 * 
 * For example if your pool that contains the login information is called \c login :
 * @code
 * // to issue a logout, simply drain the pool
 * $dm->drainPool('login');
 * 
 * // optional, throw them out right now
 * $dm->redirect("login.php");
 * @endcode
 * 
 * 
 * @section manual_dm_login_access Pages That Require Special Levels of Access
 * It is common for some pages to require either different or higher level access. An example of this is to
 * have a website where each client can login, but only the boss can reach the admin section of the site.
 * 
 * For the normal pages we can use the login method in the above example. For the admin pages we add an extra
 * attribute that will not modify teh values inside the pool.
 * @code
 * if(!$dm->recordExists('login', 'account', array('level' => 'admin')))
 *   $dm->redirect("login.php?needsadmin=1");
 * @endcode
 * 
 */

?>
