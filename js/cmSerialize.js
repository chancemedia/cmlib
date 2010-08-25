// we need JSON2 for this
cmLoadModule("json2");

function cmSerializeCount(objname) {
	var json = eval(document.getElementById(objname).value);
	return json.length;
}

function cmSerializeAdd(objname, obj) {
	var json = eval(document.getElementById(objname).value);
	json.push(obj);
	document.getElementById(objname).value = JSON.stringify(json);
}

function cmSerializeRemove(objname, id) {
	var json = eval(document.getElementById(objname).value);
	json.splice(id, 1);
	document.getElementById(objname).value = JSON.stringify(json);
}
