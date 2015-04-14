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
<<<<<<< HEAD

                alert("Results for Groups");
=======
>>>>>>> 6a4d25507a1a4e298b33b31fd9b7b584d41f1647
            }
            else
                alert("Error: " + data.errorType);
        }
    });
}

<<<<<<< HEAD

function getGroups() {
=======
function getGroupsSearch() {
>>>>>>> 6a4d25507a1a4e298b33b31fd9b7b584d41f1647
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
<<<<<<< HEAD
=======
}
>>>>>>> 6a4d25507a1a4e298b33b31fd9b7b584d41f1647
function redirectToSearchGroups() {
    window.location = "searchGroups.html";
}

function redirectToClass() {
    window.location = "createClassForm.html";
}
