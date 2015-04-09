function createClass() {
    $.ajax({
        url: "api/addClass",
        type: "post",
        data: {
            "dept":$("#dept").val(), 
            "class_num":$("#class_num").val(),
            "time2":$("#time2").val(), 
            "prof_first":$("#prof_first").val(), 
            "prof_last":$("#prof_last").val(), 
        },
        dataType: "json",
        success: function(data) {
            if(data.success) {
                alert("Class added successfully!");
                window.location = "editprofile.html";
            }
            else
                alert("Error: " + data.errorType);
        }
    });
}

function createGroup() {
    $.ajax({
        url: "api/addGroup",
        type: "post",
        data: {
            "gname":$("#gname").val(), 
            "time1":$("#time1").val(),
            "loc":$("#loc").val(), 
        },
        dataType: "json",
        success: function(data) {
            if(data.success) {
                alert("Group added successfully!");
                window.location = "editprofile.html";
            }
            else
                alert("Error: " + data.errorType);
        }
    });

}

function editGroup(changes) { //need to figure out what changes is
    editS = {"gname":"ignore", "time1":"ignore", "loc":"ignore"};

    //Change variables
    if (changes === "GroupName") { //also "GroupName is probably tied to HTML"
        editS['gname'] = document.getElementById("gname").value;
    }
    else if(changes === "time1") {
        editS['time1'] = document.getElementById("time1").value;
    }
    else if(changes === "loc") {
        editS['loc'] = document.getElementById("loc").value;
    }

    //update StudyGroups
    $.ajax({
        url: "api/editGroup",
        type: "post",
        data: editS,
        dataType: "json",
        success: function(data) {
            if(data.success) {
                $('#cur_gname').text(data.gname);
                $('#cur_time1').text(data.time1);
                $('#cur_loc').text(data.loc); 
            }
            else
                alert(data.errorType);
        }
    });

}

function getGroup() {
    $.ajax({
        url: "api/getGroup",
        type: "post",
        dataType: "json",
        success: function(data) {
            if(data.success) {
               $('cur_gname').text(data.gname);
               $('cur_time1').text(data.time1);
               $('cur_loc').text(data.loc); 
            }
            else {
                alert("Error: Could not retrieve your group.")
                window.location = "editprofile.html";
            }
        }
    });
}

function getGroupsForProfile() {
    $ajax({
        url:"api/GetGroupsRow",
        type: "post",
        dataType: "integer",
        success: function(data) {
            if(data.success) {
                var numRows = data.numRows;
            }
        }

    });

}

function getGroups() {
    $.ajax({
        url: "api/getGroups",
        type: "post",
        dataType: "json",
        success: function(data) {
            var table  = document.getElementById('GroupData');
            for(var i = 0; i < data.length; i++) {
                // Insert a row in the table at row index 0
                var newRow = table.insertRow(i);
                for(var j = 1; j < data[i].length - 1; j++) {
                    // Insert a cell in the row at index 0
                    var newCell  = newRow.insertCell(j);
                    // Append a text node to the cell
                    var newText  = document.createTextNode(data[i][j]);
                    newCell.appendChild(newText);
                }
                $('#results').text("");
            }
        }
    });
}



function leaveStudyGroup() {
    $.ajax({
        url: "api/leaveStudyGroup",
        type: "post",
        dataType: "json",
        success: function(data) {
            if(data.success) {
                alert("You have left the group.")
                window.location = "editprofile.html";
            }
            else{
                alert("Error: Could not remove you from group")
                window.location = "groupProfile.html";
                //not sure if any of this will actually work
            }
        }
    });
}

function redirectToClass() {
    window.location = "createClassForm.html";
}

function redirectToGroup() {
    window.location = "createStudyGroupForm.html";
}