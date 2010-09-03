String.prototype.startsWith = function(str) {
	return this.match("^" + str) == str;
}

String.prototype.endsWith = function(str) {
	return this.match(str + "$") == str;
}

String.prototype.trim = function() {
	return this.replace(/^[\s\xA0]+/, "").replace(/[\s\xA0]+$/, "");
}

function isNumeric(num) {
	var validChars = "0123456789.";
	
	for(var i = 0; i < num.length; ++i) {
		if(validChars.indexOf(num.charAt(i)) == -1)
			return false;
	}
			
	return true;
}

function isEmpty(obj) {
	return getValue(obj) == null || getValue(obj) == '';
}

function getValue(obj) {
	if(document.getElementById(obj) == null)
		return true;
		
	// could be a menu
	if(document.getElementById(obj).type == 'select-one')
		return document.getElementById(obj).options[document.getElementById(obj).selectedIndex].text;
	
	return document.getElementById(obj).value;
}

function randomString(string_length) {
	var chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXTZabcdefghiklmnopqrstuvwxyz";
	var randomstring = '';
	for (var i = 0; i < string_length; ++i) {
		var rnum = Math.floor(Math.random() * chars.length);
		randomstring += chars.substring(rnum, rnum+1);
	}
	return randomstring;
}

var loadedModules = [];

function cmLoadModule(module) {
	// check if the module is already loaded
	if(loadedModules.indexOf(module) >= 0)
		return;
		
	document.write('<script src="cmlib/js/' + module + '.js"></script>');
	loadedModules.push(module);
}

function cmLoadModules(modules) {
	for(var i = 0; i < modules.length; ++i)
		cmLoadModule(modules[i]);
}
