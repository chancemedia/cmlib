cmLoadModule('cmTimeline');

var windowResizeStack = [];

function _windowWrite(html) {
	document.getElementsByTagName('body').item(0).innerHTML += html;
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

function _removeWindowResizeObject(name) {
	for(var i = 0; i < windowResizeStack.length; i += 2) {
		if(windowResizeStack[i] == name) {
			windowResizeStack.splice(i, 2);
			break;
		}
	}
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

function cmWindowHeight() {
	// we must look up to all parent windows
	if(window.parent.document != null)
		return _windowHeight(window.parent.document, window.parent);
	
	return _windowHeight(document, window);
}

function cmWindowWidth() {
	// we must look up to all parent windows
	if(window.parent.document != null)
		return _windowWidth(window.parent.document, window.parent);
	
	return _windowWidth(document, window);
}

function _dimSmooth(obj, opacity, totalTime, onclick) {
	_createWindowDim();
	
	if(obj == document)
		cmTimelineRun('cmWindowDim(%)', 0.0, opacity, totalTime / 0.1, totalTime);
	else
		cmTimelineRun('cmWindowDimParent(%)', 0.0, opacity, totalTime / 0.1, totalTime);
	
	// actions
	if(onclick != null)
		obj.getElementById('window_dim').onclick = onclick;
}

function cmWindowDimSmooth(opacity, totalTime, onclick) {
	return _dimSmooth(document, opacity, totalTime, onclick);
}

function cmWindowDimParentSmooth(opacity, totalTime, onclick) {
	return _dimSmooth(window.parent.document, opacity, totalTime, onclick);
}

function cmWindowUndimSmooth(opacity, totalTime) {
	cmTimelineRun('cmWindowDim(%)', opacity, 0.0, totalTime / 0.1, totalTime);
	setTimeout('cmWindowUndim()', (totalTime * 1000) + 10);
}

function cmWindowUndimParentSmooth(opacity, totalTime) {
	cmTimelineRun('cmWindowDimParent(%)', opacity, 0.0, totalTime / 0.1, totalTime);
	setTimeout('cmWindowUndimParent()', (totalTime * 1000) + 10);
}

function _undim(obj) {
	// if the dimmer doesn't exist then something went wrong, but we have to return
	if(obj.getElementById('window_dim') == null)
		return false;
		
	var obj = obj.getElementById('window_dim');
	obj.style.backgroundColor = 'rgba(0, 0, 0, 0.0)';
	obj.style.height = '0px';
	obj.style.width = '0px';
	
	// remove the object from the window stack
	_removeWindowResizeObject('window_dim');
	
	return true;
}

function cmWindowUndim() {
	return _undim(document);
}

function cmWindowUndimParent() {
	return _undim(window.parent.document);
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
	obj.style.height = cmWindowHeight() + 'px';
	obj.style.width = cmWindowWidth() + 'px';
	obj.style.position = 'absolute';
	
	// resize with window
	_addWindowResizeObject('window_dim', function() {
		var obj = docobj.getElementById('window_dim');
		obj.style.height = cmWindowHeight() + 'px';
		obj.style.width = cmWindowWidth() + 'px';
	});
	
	// actions
	if(onclick != null)
		docobj.getElementById('window_dim').onclick = onclick;
}

function cmWindowDim(opacity, onclick) {
	return _dimWindow(document, opacity, onclick);
}

function cmWindowDimParent(opacity, onclick) {
	return _dimWindow(window.parent.document, opacity, onclick);
}

// setup environment
if(window.parent.window != null)
	window.parent.window.onresize = _windowResize;
else
	window.onresize = _windowResize;
