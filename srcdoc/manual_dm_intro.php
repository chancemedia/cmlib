<?php

/**
 * @page manual_dm_intro 6.1. Introduction
 * 
 * @section manual_dm_intro_contents Contents
 * -# \ref manual_dm_intro_desc
 * -# \ref manual_dm_intro_whatdoesitdo
 * -# \ref manual_dm_intro_example1
 * 
 * @section manual_dm_intro_desc Description
 * The data model provides a way to use data between the backend server, the database and the front
 * end HTML objects in a way that is non-ambiguous, safe and easy.
 * 
 * @section manual_dm_intro_whatdoesitdo What Does It Do?
 *  - A session (that is, a discreet bond between a given user and the server) can have multiple
 *    CMDataModels, each of which remain completely separate from each other.
 *  - In each CMDataModel has a set of data pools where each data pool may contain fields specific
 *    to a view, database table, screen or other groupable entity. This not only eliminates the
 *    ambiguity of duplicate field names or database tables with the same column names, but also 
 *    creates a discreet pool of only-relevant content to send to a database or external script.
 *  - Each CMDataModel has a 'get' and 'post' pool that are automatically maintained with the
 *    $_GET and $_POST submissions.
 *  - CMDataModel can retain large amounts of text and binary information that does not have to be
 *    passed through the browser, but also accessed at any time.
 *  - A global storage pool that allows information to be safely shared between CMDataModels without
 *    crossing the boundaries of a user.
 *  - CMDataModel automatically tracks URL history to allow submitting backwards one or more steps.
 *  - No JavaScript to implement any features. All code, including forward and backward form
 *    submission is done server side so it's not browser inderpendant.
 *  - Higher security. Information in a CMDataModel can not be altered by simply changing posted
 *    values in the HTML. On top of that, pools can be locked so no outside entity can change their
 *    values, this is ideal for storing passwords and other authentication.
 *    
 *  Native (built-in) support for:
 *  - CMDatabaseProtocol to be able to interact with any database engine (such as MySQL, PostgreSQL
 *    or Oracle) without the need to change any code.
 *  - CMDataModelValidator to validate posted or sent information with a variety of automatic and
 *    pattern matching options. Human-readable messages are generated.
 *  - CMForm to build HTML form objects from a pool. This eliminates the need to manually program in
 *    the returning of fields to a page.
 *  - Serialisation allows an instant consistent snapshot of an entire CMDataModel to save in a
 *    a database or file.
 *    
 * 
 * @section manual_dm_intro_example1 Example: A Guest Book
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
 * // if the form was submitted
 * if($dm->request('submit')) {
 *   // validate the submitted page
 *   // the '+' means the field is mandatory, the '@' means it must be a valid email address
 *   $dm->setValidator(new CMDataModelValidator('+person[firstname] +person[lastname] +@person[email]'));
 *   
 *   // if the validate failed, we can submit them back to the previous page, the information
 *   // they have already put in will automatically be loaded in
 *   if(!$dm->validate())
 *     $dm->submitBackwards();
 * 	
 *   // insert record into the database, returning the record ID
 *   $id = $dm->databaseInsert('person');
 * 
 *   // optional, but this is so when the person returns they get a new blank form
 *   $dm->drainPool('person');
 * 	
 *   die("Thanks for your submission! There is now $id guest records.");
 * }
 * 
 * ?>
 * <html>
 * <head><title>CMDataModel demo</title></head>
 * 
 * <body>
 * <form method="post">
 * 
 * First name: <?= $dm->textBox('person[firstname]') ?>
 *             <?= $dm->fieldError('person[firstname]') ?><br/>
 *             
 * Last name:  <?= $dm->textBox('person[lastname]') ?>
 *             <?= $dm->fieldError('person[lastname]') ?><br/>
 *             
 * Email:      <?= $dm->textBox('person[email]') ?>
 *             <?= $dm->fieldError('person[email]') ?><br/>
 *             
 * <?= CMForm::SubmitButton(array('value' => "Next step")) ?>
 * 
 * </form>
 * </body>
 * </html>
 * @endcode
 * 
 */

?>
