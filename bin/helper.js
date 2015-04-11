function createClass() {
    if(validClass()) {
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
}

function createGroup() {
    $.ajax({
        url: "api/addGroup",
        type: "post",
        data: {
            "gname":$("#gname").val(), 
            "time1":$("#time1").val(),
            "loc":$("#loc").val(), 
            "dept":$("#dept").val(),
            "class_num":$("class_num").val(),
        },
        dataType: "json",
        success: function(data) {
            if(data.success) {
                alert("Group added successfully!");
                window.location = "editprofile.html";
            }
            else
                alert("Error: Class does not exist");
        }
    });
}

function editGroup(changes) { 
    editS = {"gid":$('#gid').text(),"gname":"ignore", "time1":"ignore", "loc":"ignore"};

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
        url: "api/editStudyGroup",
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

function getGroupInfo(gidGet) {
    $.ajax({
        url: "api/getGroupInfo",
        type: "post",
        data: {
            "gid":gidGet
        },
        dataType: "json",
        success: function(data) {
            if(data.success)
                window.location="groupprofile.php?gid="+gidGet+"&gname="+data.gname+"&time1="+data.time1+"&loc="+data.loc;
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
            var table  = document.getElementById('GroupData');//.style.textAlign = "center";
            for(var i = 0; i < data.length; i++) {
                $('#results').text("");
                if(!data[i].success)
                    continue;                
                // Insert a row in the table at row index 0
                var newRow = table.insertRow(-1);
                for(var key in data[i]) {
                    if(key == "error" || key == "success")
                        continue;
                    if(key == "gid") {
                        var gidStr = data[i][key];
                        continue;
                    }

                    // Insert a cell in the row at index 0
                    var newCell  = newRow.insertCell(-1);
                    // Append a text node to the cell
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
    });
}

function leaveStudyGroup() {
    $.ajax({
        url: "api/leaveStudyGroup",
        type: "post",
        data: {
            "gid": $('#gid').text()
        },
        dataType: "json",
        success: function(data) {
            if(data.success) {
                alert("You have left the group.");
                window.location = "editprofile.html";
            }
            else{
                alert("Error: Could not remove you from group");
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


function validClass(){
    if(!validFName())
        return false;
    if(!validLName())
        return false;
    else
        return true;
}

function validFName() {
    var regex = /[A-Z][a-z]+/;
    var name = document.getElementById("prof_first").value;
    if(regex.test(name))
        return true;
    else {
        alert("Your first name must start with uppercase letter");
        return false;
    }
}

function validGroup() {

}

function validLName() { 
    var regex = /[A-Z][a-zA-Z]+/;
    var name = document.getElementById("prof_last").value;
    if(regex.test(name))
        return true;
    else {
        alert("Your last name start with an uppercase letter");
        return false;
    }
}
