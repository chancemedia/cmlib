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

function _createWindowDim() {
	if(document.getElementById('window_dim') == null)
		document.getElementsByTagName('body').item(0).innerHTML += '<div id="window_dim" style="">&nbsp;</div>';
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
	
	// resize with window resize
	window.onresize = function() {
		var obj = document.getElementById('window_dim');
		obj.style.height = getWindowHeight() + 'px';
		obj.style.width = getWindowWidth() + 'px';
	}
	
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
