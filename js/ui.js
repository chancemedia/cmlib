var windowResizeStack = [];

String.prototype.startsWith = function(str) {
	return this.match("^" + str) == str;
}

String.prototype.endsWith = function(str) {
	return this.match(str + "$") == str;
}

String.prototype.trim = function() {
	return this.replace(/^[\s\xA0]+/, "").replace(/[\s\xA0]+$/, "");
}

function _windowResize() {
	// resize all of the objects on the object stack
	for(var i = 1; i < windowResizeStack.length; i += 2)
		windowResizeStack[i]();
}

function _addWindowResizeObject(name, func) {
	// for objects already on the stack we just replace the resizing function
	for(var i = 0; i < windowResizeStack.length; i += 2) {
		if(windowResizeStack[i] == name) {
			windowResizeStack[i + 1] = func;
			return;
		}
	}
	
	// new object - add it to the stack
	windowResizeStack.push(name, func);
}

function _windowHeight(docobj, winobj) {
	// the more standards compliant browsers (mozilla/netscape/opera/IE7) use window.innerWidth and window.innerHeight
	if(typeof winobj.innerHeight != 'undefined')
		return winobj.innerHeight;
	
	// IE6 in standards compliant mode (i.e. with a valid doctype as the first line in the document)
	else if(typeof docobj.documentElement != 'undefined' && typeof docobj.documentElement.clientHeight != 'undefined' &&
			docobj.documentElement.clientHeight != 0)
		return docobj.documentElement.clientHeight;
		
	// older versions of IE
	else
		return docobj.getElementsByTagName('body')[0].clientHeight;
}

function _windowWidth(docobj, winobj) {
	// the more standards compliant browsers (mozilla/netscape/opera/IE7) use window.innerWidth and window.innerHeight
	if(typeof winobj.innerWidth != 'undefined')
		return winobj.innerWidth;
	
	// IE6 in standards compliant mode (i.e. with a valid doctype as the first line in the document)
	else if(typeof docobj.documentElement != 'undefined' && typeof docobj.documentElement.clientWidth != 'undefined' &&
			docobj.documentElement.clientWidth != 0)
		return docobj.documentElement.clientWidth;
		
	// older versions of IE
	else
		return docobj.getElementsByTagName('body')[0].clientWidth;
}

function getWindowHeight() {
	// we must look up to all parent windows
	if(window.parent.document != null)
		return _windowHeight(window.parent.document, window.parent);
	
	return _windowHeight(document, window);
}

function getWindowWidth() {
	// we must look up to all parent windows
	if(window.parent.document != null)
		return _windowWidth(window.parent.document, window.parent);
	
	return _windowWidth(document, window);
}

function _undim(obj) {
	// if the dimmer doesn't exist then something went wrong, but we have to return
	if(obj.getElementById('window_dim') == null)
		return false;
		
	var obj = obj.getElementById('window_dim');
	obj.style.backgroundColor = 'rgba(0, 0, 0, 0.0)';
	obj.style.height = '0px';
	obj.style.width = '0px';
	return true;
}

function undimWindow() {
	return _undim(document);
}

function undimParentWindow() {
	return _undim(window.parent.document);
}

function _windowWrite(html) {
	document.getElementsByTagName('body').item(0).innerHTML += html;
}

function _createWindowDim() {
	if(document.getElementById('window_dim') == null)
		_windowWrite('<div id="window_dim" style="">&nbsp;</div>');
}

function _dimWindow(docobj, opacity, onclick) {
	_createWindowDim();
	
	var obj = docobj.getElementById('window_dim');
	obj.style.backgroundColor = "rgba(0, 0, 0, " + opacity + ")";
	obj.style.top = '0px';
	obj.style.left = '0px';
	obj.style.height = getWindowHeight() + 'px';
	obj.style.width = getWindowWidth() + 'px';
	obj.style.position = 'absolute';
	
	// resize with window
	_addWindowResizeObject('window_dim', function() {
		var obj = docobj.getElementById('window_dim');
		obj.style.height = getWindowHeight() + 'px';
		obj.style.width = getWindowWidth() + 'px';
	});
	
	// actions
	if(onclick != null)
		docobj.getElementById('window_dim').onclick = onclick;
}

function dimWindow(opacity, onclick) {
	return _dimWindow(document, opacity, onclick);
}

function dimParentWindow(opacity, onclick) {
	return _dimWindow(window.parent.document, opacity, onclick);
}

function runTimeline(code, start, finish, totalFrames, totalTime) {
	// the time each frame takes
	var milli = (totalTime / totalFrames) * 1000;
	
	// setup and execute timeline
	var next = start;
	for(var i = 0; i <= totalFrames; ++i) {
		next += ((finish - start) / totalFrames);
		var newcode = code.replace('%', next);
		setTimeout(newcode, milli * i);
	}
}

function _dimSmooth(obj, opacity, totalTime, onclick) {
	_createWindowDim();
	
	if(obj == document)
		runTimeline('dimWindow(%)', 0.0, opacity, totalTime / 0.1, totalTime);
	else
		runTimeline('dimParentWindow(%)', 0.0, opacity, totalTime / 0.1, totalTime);
	
	// actions
	if(onclick != null)
		obj.getElementById('window_dim').onclick = onclick;
}

function dimWindowSmooth(opacity, totalTime, onclick) {
	return _dimSmooth(document, opacity, totalTime, onclick);
}

function dimParentWindowSmooth(opacity, totalTime, onclick) {
	return _dimSmooth(window.parent.document, opacity, totalTime, onclick);
}

function undimWindowSmooth(opacity, totalTime) {
	runTimeline('dimWindow(%)', opacity, 0.0, totalTime / 0.1, totalTime);
	setTimeout('undimWindow()', (totalTime * 1000) + 10);
}

function undimParentWindowSmooth(opacity, totalTime) {
	runTimeline('dimParentWindow(%)', opacity, 0.0, totalTime / 0.1, totalTime);
	setTimeout('undimParentWindow()', (totalTime * 1000) + 10);
}

function isNumeric(num) {
	var validChars = "0123456789.";
	
	for(var i = 0; i < num.length; ++i) {
		if(validChars.indexOf(num.charAt(i)) == -1)
			return false;
	}
			
	return true;
}

function createModalWindow(name, url, width, height) {
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
		obj.style.height = (getWindowHeight() * (parseInt(height) / 100)) + 'px';
		
	if(isNumeric(width))
		obj.style.width = width + 'px';
	else
		obj.style.width = (getWindowWidth() * (parseInt(width) / 100)) + 'px';
		
	// move the modal window to the centre of the screen
	obj.style.top = ((getWindowHeight() - parseInt(obj.style.height)) / 2) + 'px';
	obj.style.left = ((getWindowWidth() - parseInt(obj.style.width)) / 2) + 'px';
	
	obj.style.position = 'absolute';
	
	// resize with window
	_addWindowResizeObject(name, function() {
		var obj = document.getElementById(name);
	
		// set size
		if(isNumeric(height))
			obj.style.height = height + 'px';
		else
			obj.style.height = (getWindowHeight() * (parseInt(height) / 100)) + 'px';
			
		if(isNumeric(width))
			obj.style.width = width + 'px';
		else
			obj.style.width = (getWindowWidth() * (parseInt(width) / 100)) + 'px';
			
		// move the modal window to the centre of the screen
		obj.style.top = ((getWindowHeight() - parseInt(obj.style.height)) / 2) + 'px';
		obj.style.left = ((getWindowWidth() - parseInt(obj.style.width)) / 2) + 'px';
	});
}

function _closeModalWindow(docobj, name) {
	// make sure the modal window object exists
	if(docobj.getElementById(name) == null)
		return false;
	
	// closing the modal window simply makes it invisible, so closing it multiple times should have
	// no effect
	docobj.getElementById(name).style.display = 'none';
	return true;
}

function closeModalWindow(name) {
	if(window.parent.document != null)
		return _closeModalWindow(window.parent.document, name);
	return _closeModalWindow(document, name);
}

function isEmpty(obj) {
	if(document.getElementById(obj) == null)
		return true;
	return document.getElementById(obj).value == '';
}

// setup environment
window.onresize = _windowResize;
