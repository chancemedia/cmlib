<?php

/**
 * @page manual_html_form 3.1. Form Objects
 * 
 * @section manual_html_form_contents Contents
 * -# \ref manual_html_form_example
 * -# \ref manual_html_form_attr
 * 
 * 
 * @section manual_html_form_example Example
 * Any attribute can have its value from a database query by setting the value like;
 * @code
 * echo CMForm::TextBox(array(
 *   'name' => 'textfield',
 *   'value' => $dbh->query('select firstname from people')
 * ));
 * @endcode
 * 
 * For textboxes this will use the the value of the first column of the first row.
 * For menus/lists it will use the first column for values and the second column for text
 * 
 * 
 * @section manual_html_form_attr Attributes
 * <table border> 
 * 	<tr> 
 * 		<th>Name</th>
 * 		<th>Default</th>
 * 		<th>Description</th>
 * 	</tr>
 * 	<tr>
 * 		<td><tt>caption</tt></td>
 * 		<td><tt>false</tt></td>
 * 		<td>If this is set to <tt>1</tt>, any form object will only be printed as non-editable
 * 		    text.</td>
 * 	</tr>
 * 	<tr>
 * 		<td><tt>captionempty</tt></td>
 * 		<td><tt>""</tt></td>
 * 		<td>If the <tt>caption</tt> attribute is set but blank, this caption is used instead.</td>
 * 	</tr>
 * 	<tr>
 * 		<td><tt>checked</tt></td>
 * 		<td><tt>value</tt> attribute</td>
 * 		<td>This only applies to a Checkbox.</td>
 * 	</tr>
 * 	<tr>
 * 		<td><tt>class</tt></td>
 * 		<td><tt>false</tt></td>
 * 		<td>CSS class for entire object.</td>
 * 	</tr>
 * 	<tr>
 * 		<td><tt>custom</tt></td>
 * 		<td><tt>false</tt></td>
 * 		<td>Any extra attribute to be entered into the object. This applies to all objects.</td>
 * 	</tr>
 * 	<tr>
 * 		<td><tt>data</tt></td>
 * 		<td><tt>false</tt></td>
 * 		<td>Data source. Data can be a string for text boxes, but must be a key/value array for
 * 		    menus/lists.</td>
 * 	</tr>
 * 	<tr>
 * 		<td><tt>disabled</tt></td>
 * 		<td><tt>false</tt></td>
 * 		<td>Field is diabled. false is off, any other value is true.</td>
 * 	</tr>
 * 	<tr>
 * 		<td><tt>height</tt></td>
 * 		<td><tt>false</tt></td>
 * 		<td>This onld applies to ListBox. The number of items in the list selection.</td>
 * 	</tr>
 * 	<tr>
 * 		<td><tt>html</tt></td>
 * 		<td><tt>false</tt></td>
 * 		<td>If this is true values will be used as is and not parsed through
 * 		    <tt>htmlspecialchars()</tt>.</td>
 * 	</tr>
 * 	<tr>
 * 		<td><tt>id</tt></td>
 * 		<td><tt>name</tt> attribute</td>
 * 		<td>ID (for CSS) of the HTML object, if this is not set it will use the value of the
 * 		    <tt>name</tt> attribute.</td>
 * 	</tr>
 * 	<tr>
 * 		<td><tt>label</tt></td>
 * 		<td><tt>false</tt></td>
 * 		<td>Label.</td>
 * 	</tr> 
 * 	<tr>
 * 		<td><tt>name</tt></td>
 * 		<td><tt>""</tt></td>
 * 		<td>Name of the HTML form object.</td>
 * 	</tr>
 * 	<tr>
 * 		<td><tt>onblur</tt></td>
 * 		<td><tt>false</tt></td>
 * 		<td>JavaScript action can be added to all HTML form objects.</td>
 * 	</tr>
 * 	<tr>
 * 		<td><tt>onchange</tt></td>
 * 		<td><tt>false</tt></td>
 * 		<td>JavaScript action can be added to all HTML form objects.</td>
 * 	</tr>
 * 	<tr>
 * 		<td><tt>onclick</tt></td>
 * 		<td><tt>false</tt></td>
 * 		<td>JavaScript action can be added to all HTML form objects.</td>
 * 	</tr>
 * 	<tr>
 * 		<td><tt>ondblclick</tt></td>
 * 		<td><tt>false</tt></td>
 * 		<td>JavaScript action can be added to all HTML form objects.</td>
 * 	</tr>
 * 	<tr>
 * 		<td><tt>onfocus</tt></td>
 * 		<td><tt>false</tt></td>
 * 		<td>JavaScript action can be added to all HTML form objects.</td>
 * 	</tr>
 * 	<tr>
 * 		<td><tt>onkeydown</tt></td>
 * 		<td><tt>false</tt></td>
 * 		<td>JavaScript action can be added to all HTML form objects.</td>
 * 	</tr>
 * 	<tr>
 * 		<td><tt>onkeypress</tt></td>
 * 		<td><tt>false</tt></td>
 * 		<td>JavaScript action can be added to all HTML form objects.</td>
 * 	</tr>
 * 	<tr>
 * 		<td><tt>onkeyup</tt></td>
 * 		<td><tt>false</tt></td>
 * 		<td>JavaScript action can be added to all HTML form objects.</td>
 * 	</tr>
 * 	<tr>
 * 		<td><tt>onmousedown</tt></td>
 * 		<td><tt>false</tt></td>
 * 		<td>JavaScript action can be added to all HTML form objects.</td>
 * 	</tr>
 * 	<tr>
 * 		<td><tt>onmouseout</tt></td>
 * 		<td><tt>false</tt></td>
 * 		<td>JavaScript action can be added to all HTML form objects.</td>
 *  </tr>
 * 	<tr>
 * 		<td><tt>onmousemove</tt></td>
 * 		<td><tt>false</tt></td>
 * 		<td>JavaScript action can be added to all HTML form objects.</td>
 * 	</tr>
 * 	<tr>
 * 		<td><tt>onmouseup</tt></td>
 * 		<td><tt>false</tt></td>
 * 		<td>JavaScript action can be added to all HTML form objects.</td>
 * 	</tr>
 * 	<tr>
 * 		<td><tt>onmouseover</tt></td>
 * 		<td><tt>false</tt></td>
 * 		<td>JavaScript action can be added to all HTML form objects.</td>
 * 	</tr>
 * 	<tr>
 * 		<td><tt>onselect</tt></td>
 * 		<td><tt>false</tt></td>
 * 		<td>JavaScript action can be added to all HTML form objects.</td>
 * 	</tr>
 * 	<tr>
 * 		<td><tt>readonly</tt></td>
 * 		<td><tt>false</tt></td>
 * 		<td>Field is read only. false is off, any other value is true.</td>
 * 	</tr>
 * 	<tr>
 * 		<td><tt>style</tt></td>
 * 		<td><tt>false</tt></td>
 * 		<td>CSS style attribute for entire object.</td>
 * 	</tr>
 * 	<tr>
 * 		<td><tt>tabindex</tt></td>
 * 		<td><tt>false</tt></td>
 * 		<td>Tab index tells the browser the order in which the fields are to be tabbed through.</td>
 * 	</tr>
 * 	<tr>
 * 		<td><tt>value</tt></td>
 * 		<td><tt>""</tt></td>
 * 		<td>For menus this will be the value of the selected item, and for textboxes this will be
 * 		    the internal text. If the object is a CheckboxGroup: The value can be a single value
 * 		    for only 1 checkbox selected, or an array to select multiple checkboxes. The rules
 *		    for each indervidual checked box is the same as for Checkbox.</td>
 * 	</tr>
 * 	<tr>
 * 		<td><tt>width</tt></td>
 * 		<td><tt>false</tt></td>
 * 		<td>The number of characters wide the field is.</td>
 * 	</tr>
 * 	<tr>
 * 		<td><tt>wrap</tt></td>
 * 		<td><tt>"off"</tt></td>
 * 		<td>Only applies to TextArea.</td>
 * 	</tr>
 * </table>
 * 
 */

?>
