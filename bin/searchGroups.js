function getGroupsSearch() {
    $.ajax({
        url: "api/getGroups_searchByClass",
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
                    if(key == "error" || key == "success")
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

function redirectToSearchGroups() {
	var queryInput = $("#searchInput").val();
	var splitQueryInput = queryInput.split(" ");
	var urlLocation = "searchGroups.html?";
	for (var x = 0; x < splitQueryInput.length; ++x) {
		urlLocation +=  "param" + x + "=" + splitQueryInput[x] + "&";
		alert(urlLocation);
	}
    window.location = urlLocation;
}

function redirectToClass() {
    window.location = "createClassForm.html";
}


function searchByClass() {
	
	var sPageURL = window.location.search.substring(1);
    var sURLVariables = sPageURL.split('&');
	
	var dept = sURLVariables[0].split('=');
	dept = dept[1];
	
	var courseNumber = sURLVariables[1].split('=');
	courseNumber = courseNumber[1];
	
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
	for(var i = 0; i < data.length; i++) {
		$('#results').text("");
		if(!data[i].success)
			continue;
		var newRow = table.insertRow(-1);
		for(var key in data[i]) {
			if(key == "errorType" || key == "success")
				continue;
			if (key == "gid") {
				var gidstr = data[i][key];
				continue;
			}
			var newCell = newRow.insertCell(-1);
			var newText  = document.createTextNode(data[i][key]);
			newCell.appendChild(newText);
		}

		var newButton = newRow.insertCell(-1);
		var viewButton = document.createElement("button");
		var addName = document.createTextNode("Join Group");
		viewButton.appendChild(addName);
		viewButton.onclick=function(gidstr) { return function() { joinGroup(gidstr); }; }(gidstr);
		newButton.appendChild(viewButton);
	}
}
