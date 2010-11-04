AIM = {
 
	frame : function(c) {
		var n = 'f' + Math.floor(Math.random() * 99999);
		var d = document.createElement('DIV');
		d.innerHTML = '<iframe style="display: none" src="about:blank" id="'+n+'" name="'+n+'" onload="AIM.loaded(\''+n+'\')"></iframe>';
		document.body.appendChild(d);
 
		var i = document.getElementById(n);
		if (c && typeof(c.onComplete) == 'function')
			i.onComplete = c.onComplete;
 
		return n;
	},
 
	form : function(f, name) {
		f.setAttribute('target', name);
	},
 
	submit : function(f, c) {
		AIM.form(f, AIM.frame(c));
		if (c && typeof(c.onStart) == 'function')
			return c.onStart();
		else
			return true;
	},
 
	loaded : function(id) {
		var i = document.getElementById(id);
		if (i.contentDocument)
			var d = i.contentDocument;
		else if (i.contentWindow)
			var d = i.contentWindow.document;
		else
			var d = window.frames[id].document;
			
		if (d.location.href == "about:blank")
			return;
 
		if (typeof(i.onComplete) == 'function')
			i.onComplete(d.body.innerHTML);
	}
 
}

/**
 * @brief Create AJAX handle.
 * 
 * This function is suited to Firefox, Opera, Safari and Internet Explorer.
 * 
 * @return New AJAX handle or false on error.
 */
function cmAjaxCreateHandle() {
	var xmlHttp;
	
	try {
		// Firefox, Opera 8.0+, Safari
		xmlHttp = new XMLHttpRequest();
	}
	catch (e) {
		// Internet Explorer
		try {
			xmlHttp = new ActiveXObject("Msxml2.XMLHTTP");
		}
		catch (e) {
			try {
				xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
			}
			catch (e) {
				alert("Your browser does not support AJAX!");
				return false;
			}
		}
	}
	
	return xmlHttp;
}

/**
 * @brief Submit an AJAX form.
 * 
 * This takes all the objects in the \p form and passes that to cmAjaxSubmit().
 * 
 * @param form A form object.
 * @param url The URL to submit to.
 * @param successAction An anonymous function to be executed when the request completed.
 * @returns The result returned by cmAjaxSubmit().
 */
function cmAjaxSubmitForm(form, url, successAction) {
	var objs = [];
	for(var i = 0; i < form.elements.length; ++i)
		objs[form.elements[i].name] = form.elements[i].value;
	return cmAjaxSubmit(url, objs, successAction);
}

/**
 * @brief POST data to a URL without submitting the page.
 * 
 * This is probably the most key AJAX method that POSTs data to a server and performs an
 * action on completion.
 * 
 * @param url The URL to POST the data to.
 * @param data An associative array of data.
 * @param successAction An anonymous function to be performed when the server returns the result.
 */
function cmAjaxSubmit(url, data, successAction) {
	// make sure we always use a new handle, less efficient but much safer if multiple
	// requests/results happen at once
	var ajaxHandle = cmAjaxCreateHandle();
	
	// setup listener
	ajaxHandle.onreadystatechange = function() {
		if(ajaxHandle.readyState == 4)
			successAction();
	}
	
	// submit request
	ajaxHandle.open("POST", url, true);
	ajaxHandle.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	var post = new Array();
	for(key in data)
		post.push(key + "=" + escape(data[key]));
	ajaxHandle.send(post.join('&'));
}

/**
 * @brief Upload a file without submitting the form.
 *
 * @param before A function to run before the upload start
 * @Param after A function to run after the upload is complete.
 */
function cmAjaxUploadFile(theForm, before, after) {
	return AIM.submit(theForm, { 'onStart' : before, 'onComplete' : after });
}
