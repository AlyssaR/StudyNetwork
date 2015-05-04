function getGroupsSearch() {
    $.ajax({
        url: "api/searchByClass",
        type: "post",
        dataType: "json",
        success: function(data) {
            var table  = document.getElementById('GroupData');
            for(var i = 0; i < data.length; i++) {
                $('#results').text("");
                if(!data[i].success)
                    continue;                
                // Insert a row in the table at row index 0
                var newRow = table.insertRow(-1);
                for(var key in data[i]) {
                    if(key == "errorType" || key == "success")
                        continue;
                    // Insert a cell in the row at index 0
                    var newCell  = newRow.insertCell(-1);
                    // Append a text node to the cell
                    var newText  = document.createTextNode(data[i][key]);
                    newCell.appendChild(newText);
                }
            }
        }
    });
}

function searchForStudyGroup() {
	var searchByOption = $_GET('searchBy');

	if (searchByOption == "group") {
		var group = sURLVariables[1].split('=');
		group = group[1];
		searchByGroup(group);
	}
	else if (searchByOption == "class") {
		var dept = sURLVariables[1].split('=');
		dept = dept[1];

		var courseNumber = sURLVariables[2].split('=');
		courseNumber = courseNumber[1];
		searchByClass(dept, courseNumber);
	}
	else if (searchByOption == "organization") {
		var org = sURLVariables[1].split('=');
		org = org[1];
		searchByOrganization();
	}
}

function searchByClass(dept, courseNumber) {
	$.ajax({
        url: "api/searchByClass",
        type: "post",
        data: 	{
					"dept": dept,
					"class_num": courseNumber
				},
        dataType: "json",
        success: function(data) {
        	populateSearchResults(data);
		}
    });
}

function populateSearchResults(data) {
	var table = document.getElementById('searchResults');
	var gidStr;
	for(var i = 0; i < data.length; i++) {
		$('#results').text("");
		if(!data[i].success)
			continue;
		var newRow = table.insertRow(-1);
		for(var key in data[i]) {
			if(key == "errorType" || key == "success")
				continue;
			if (key == "gid") {
				gidStr = data[i][key];
				continue;
			}
			var newCell = newRow.insertCell(-1);
			var newText  = document.createTextNode(data[i][key]);
			newCell.appendChild(newText);
		}

		var newButton = newRow.insertCell(-1);
		var viewButton = document.createElement("button");
		var addName = document.createTextNode("View Group");
		viewButton.appendChild(addName);
		viewButton.onclick=function(gidStr) { return function() { getGroupInfo(gidStr); }; }(gidStr);
		newButton.appendChild(viewButton);
	}
}

function searchByGroup(group) {
    $.ajax({
        url: "api/searchByGroup",
        type: "post",
		data: 	{
					"group": group,
				},
        dataType: "json",
        success: function(data) {
			populateSearchResults(data);
        }
    });
}

function searchByOrganization(org) {
    $.ajax({
        url: "api/searchByOrg",
        type: "post",
		data: 	{
					"org": org
				},
        dataType: "json",
        success: function(data) {
				populateSearchResults(data);
        }
    });
}