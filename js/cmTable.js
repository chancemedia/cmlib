// we need JSON2 for this
cmLoadModule("json2");

function cmTableTotalRows(tableName) {
	if(document.getElementById(tableName) == null)
		return 0;
	return document.getElementById(tableName).rows.length;
}

function cmTableAddRow(tableName, cells, attr) {
	var table = document.getElementById(tableName);
	var row = table.insertRow(table.rows.length);
	
	if(attr != null) {
		JSON.parse(JSON.stringify(attr), function(key, value) {
			if(key == 'tr_style')
				row.style.cssText = attr.tr_style;
			else if(key.substr(0, 3) == 'tr_')
				eval('row.' + key.substr(3) + ' = attr.' + key + ';');
		});
	}
	
	for(var i = 0; i < cells.length; ++i) {
		var cell = row.insertCell(i);
		cell.innerHTML = cells[i];
		
		if(attr != null) {
			JSON.parse(JSON.stringify(attr), function(key, value) {
				if(key == 'td_style')
					cell.style.cssText = attr.td_style;
				else if(key.substr(0, 3) == 'td_')
					eval('cell.' + key.substr(3) + ' = attr.' + key + ';');
			});
		}
	}
}

function cmTableRemoveRowAtIndex(tableName, rowID) {
	document.getElementById(tableName).deleteRow(rowID);
}

function cmTableRemoveRowByID(tableName, rowID) {
	for(var i = 0; i < document.getElementById(tableName).rows.length; ++i) {
		if(document.getElementById(tableName).rows[i].id == rowID)
			document.getElementById(tableName).deleteRow(i);
	}
}
