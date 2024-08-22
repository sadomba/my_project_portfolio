function exportToExcel(tableId){
	let tableData = document.getElementById(tableId).outerHTML;
	tableData = tableData.replace(/<A[^>]*>|<\/A>/g, ""); //remove if u want links in your table
    tableData = tableData.replace(/<input[^>]*>|<\/input>/gi, ""); //remove input params
	tableData = tableData + '<br /><br />Code witten By LecturerAide team.'

	let a = document.createElement('a');
	a.href = `data:application/vnd.ms-excel, ${encodeURIComponent(tableData)}`
	a.download = 'CSW' + getRandomNumbers() + '.xls'
	a.click()
}
function getRandomNumbers() {
	let dateObj = new Date()
	let dateTime = `${dateObj.getHours()}${dateObj.getMinutes()}${dateObj.getSeconds()}`

	return `${dateTime}`
}
