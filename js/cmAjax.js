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

function cmAjaxSubmitForm(form, url, successAction) {
	var objs = [];
	for(var i = 0; i < form.elements.length; ++i)
		objs[form.elements[i].name] = form.elements[i].value;
	return cmAjaxSubmit(url, objs, successAction);
}

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
