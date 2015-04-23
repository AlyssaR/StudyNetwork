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
    window.location = "searchGroups.html";
}

function redirectToClass() {
    window.location = "createClassForm.html";
}

function searchByClass() {
    $.ajax({
        url: "api/searchByClass",
        type: "post",
        data: {
            "class":$("#class").val(), 
            //this id could cause an issue. Not sure 
        },
        dataType: "json",
        success: function(data) {
            if(data.success) {
                alert("Groups exist for that class");
                window.location = "searchGroups.html";
            }
            else
                alert("Error: " + data.errorType);

        }
    });
}
