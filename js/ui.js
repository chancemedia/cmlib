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

function getWindowHeight() {
	// the more standards compliant browsers (mozilla/netscape/opera/IE7) use window.innerWidth and window.innerHeight
	if(typeof window.innerHeight != 'undefined')
		return window.innerHeight;
	
	// IE6 in standards compliant mode (i.e. with a valid doctype as the first line in the document)
	else if(typeof document.documentElement != 'undefined' && typeof document.documentElement.clientHeight != 'undefined' &&
			document.documentElement.clientHeight != 0)
		return document.documentElement.clientHeight;
		
	// older versions of IE
	else
		return document.getElementsByTagName('body')[0].clientHeight;
}

function getWindowWidth() {
	// the more standards compliant browsers (mozilla/netscape/opera/IE7) use window.innerWidth and window.innerHeight
	if(typeof window.innerWidth != 'undefined')
		return window.innerWidth;
	
	// IE6 in standards compliant mode (i.e. with a valid doctype as the first line in the document)
	else if(typeof document.documentElement != 'undefined' && typeof document.documentElement.clientWidth != 'undefined' &&
			document.documentElement.clientWidth != 0)
		return document.documentElement.clientWidth;
		
	// older versions of IE
	else
		return document.getElementsByTagName('body')[0].clientWidth;
}

function undimWindow() {
	// if the dimmer doesn't exist then something went wrong, but we have to return
	if(document.getElementById('window_dim') == null)
		return;
		
	var obj = document.getElementById('window_dim');
	obj.style.backgroundColor = 'rgba(0, 0, 0, 0.0)';
	obj.style.height = '0px';
	obj.style.width = '0px';
}

function _windowWrite(html) {
	document.getElementsByTagName('body').item(0).innerHTML += html;
}

function _createWindowDim() {
	if(document.getElementById('window_dim') == null)
		_windowWrite('<div id="window_dim" style="">&nbsp;</div>');
}

function dimWindow(opacity, onclick) {
	_createWindowDim();
	
	var obj = document.getElementById('window_dim');
	obj.style.backgroundColor = "rgba(0, 0, 0, " + opacity + ")";
	obj.style.top = '0px';
	obj.style.left = '0px';
	obj.style.height = getWindowHeight() + 'px';
	obj.style.width = getWindowWidth() + 'px';
	obj.style.position = 'absolute';
	
	// resize with window
	_addWindowResizeObject('window_dim', function() {
		var obj = document.getElementById('window_dim');
		obj.style.height = getWindowHeight() + 'px';
		obj.style.width = getWindowWidth() + 'px';
	});
	
	// actions
	if(onclick != null)
		document.getElementById('window_dim').onclick = onclick;
}

function runTimeline(code, start, finish, totalFrames, totalTime) {
	// the time each frame takes
	var milli = (totalTime / totalFrames) * 1000;
	
	// setup and execute timeline
	var next = start;
	for(var i = 0; i < totalFrames; ++i) {
		next += ((finish - start) / totalFrames);
		var newcode = code.replace('%', next);
		setTimeout(newcode, milli * i);
	}
}

function dimWindowSmooth(opacity, totalTime, onclick) {
	_createWindowDim();
	runTimeline('dimWindow(%)', 0.0, opacity, totalTime / 0.1, totalTime);
	
	// actions
	if(onclick != null)
		document.getElementById('window_dim').onclick = onclick;
}

function undimWindowSmooth(opacity, totalTime) {
	runTimeline('dimWindow(%)', opacity, 0.0, totalTime / 0.1, totalTime);
	setTimeout('undimWindow()', (totalTime * 1000) + 10);
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

// setup environment
window.onresize = _windowResize;
