cmLoadModule("cmWindow");

function cmModalCreate(name, url, width, height) {
	// if the modal window already exists we won't create it again
	if(document.getElementById(name) == null)
		_windowWrite('<iframe id="' + name + '" style="" src="' + url + '">&nbsp;</div>');
	else {
		// but we do make sure its displayed and refreshed
		document.getElementById(name).style.display = '';
		document.getElementById(name).contentWindow.location.reload(true);
	}
		
	// set the size of the modal window
	var obj = document.getElementById(name);
	obj.style.backgroundColor = 'white';
	obj.style.border = 'solid 1px black';
	
	// set size
	if(isNumeric(height))
		obj.style.height = height + 'px';
	else
		obj.style.height = (cmWindowHeight() * (parseInt(height) / 100)) + 'px';
		
	if(isNumeric(width))
		obj.style.width = width + 'px';
	else
		obj.style.width = (cmWindowWidth() * (parseInt(width) / 100)) + 'px';
		
	// move the modal window to the centre of the screen
	obj.style.top = ((cmWindowHeight() - parseInt(obj.style.height)) / 2) + 'px';
	obj.style.left = ((cmWindowWidth() - parseInt(obj.style.width)) / 2) + 'px';
	
	obj.style.position = 'absolute';
	
	// resize with window
	_addWindowResizeObject(name, function() {
		var obj = document.getElementById(name);
	
		// set size
		if(isNumeric(height))
			obj.style.height = height + 'px';
		else
			obj.style.height = (cmWindowHeight() * (parseInt(height) / 100)) + 'px';
			
		if(isNumeric(width))
			obj.style.width = width + 'px';
		else
			obj.style.width = (cmWindowWidth() * (parseInt(width) / 100)) + 'px';
			
		// move the modal window to the centre of the screen
		obj.style.top = ((cmWindowHeight() - parseInt(obj.style.height)) / 2) + 'px';
		obj.style.left = ((cmWindowWidth() - parseInt(obj.style.width)) / 2) + 'px';
	});
}

function _closeModalWindow(docobj, name) {
	// make sure the modal window object exists
	if(docobj.getElementById(name) == null)
		return false;
	
	// closing the modal window simply makes it invisible, so closing it multiple times should have
	// no effect
	docobj.getElementById(name).style.display = 'none';
	
	// remove the object from the resize stack
	_removeWindowResizeObject(name);
	
	return true;
}

function cmModalClose(name) {
	if(window.parent.document != null)
		return _closeModalWindow(window.parent.document, name);
	return _closeModalWindow(document, name);
}
