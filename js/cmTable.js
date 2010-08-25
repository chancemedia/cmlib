function cmTableTotalRows(tableName) {
	if(document.getElementById(tableName) == null)
		return 0;
	return document.getElementById(tableName).rows.length;
}

function cmTableAddRow(tableName, cells) {
	var table = document.getElementById(tableName);
	var row = table.insertRow(table.rows.length);
	
	for(var i = 0; i < cells.length; ++i) {
		var cell = row.insertCell(i);
		cell.innerHTML = cells[i];
	}
}

function cmTableRemoveRowAtIndex(tableName, rowID) {
	document.getElementById(tableName).deleteRow(rowID);
}
