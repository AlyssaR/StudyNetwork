function $_GET(q,s) {
    s = (s) ? s : window.location.search;
    var re = new RegExp('&amp;'+q+'=([^&amp;]*)','i');
    return (s=s.replace(/^\?/,'&amp;').match(re)) ? s=s[1] : s='';
}

function getClasses() {
    $.ajax({
        url: "api/getClasses",
        type: "post",
        dataType: "json",
        success: function(data) {
            var table = document.getElementById('ClassData');
            for(var i = 0; i < data.length; i++) {
                $('#classresults').text("");
                if(!data[i].success)
                    continue;
                var newRow = table.insertRow(-1);
                for(var key in data[i]) {
                    if(key == "errorType" || key == "success")
                        continue;
                    if(key == "dept"){
                        var deptStr = data[i][key];
                        var newCell = newRow.insertCell(-1);
                        var newText  = document.createTextNode(data[i][key]);
                        newCell.appendChild(newText);
                        continue;
                    }
                    if(key == "class_num") {
                        var classStr = data[i][key];
                        var newCell = newRow.insertCell(-1);
                        var newText  = document.createTextNode(data[i][key]);
                        newCell.appendChild(newText);
                        continue;
                    }

                    var newCell = newRow.insertCell(-1);
                    var newText  = document.createTextNode(data[i][key]);
                    newCell.appendChild(newText);
                }

                var newButton = newRow.insertCell(-1);
                var viewButton = document.createElement("button");
                var addName = document.createTextNode("Remove Class");
                viewButton.appendChild(addName);
                viewButton.onclick=function(deptStr, classStr) { return function() { leaveClass(deptStr, classStr); }; }(deptStr, classStr);
                newButton.appendChild(viewButton);


            }
        }
    });
}

function getGroupInfo(gid) {
    var getInfo = false;
    if(gid == "group") {
        gid = $_GET('gid');
        getInfo = true;
    }

    $.ajax({
        url: "api/getGroupInfo",
        type: "post",
        data: {
            "gid":gid
        },
        dataType: "json",
        success: function(data) {
            if(data.success) {
                if(getInfo) {
                    $('#cur_gname').text(data.gname);
                    $('#cur_loc').text(data.loc);
                    $('#cur_time1').text(data.time1);
                }
                else
                    window.location="groupprofile.php?gid="+gid;
            }
            else {
                alert("Error: Could not retrieve your group.")
                goToProfile();
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
                $('#groupresults').text("");
                if(!data[i].success)
                    continue;                
                // Insert a row in the table at row index 0
                var newRow = table.insertRow(-1);
                for(var key in data[i]) {
                    if(key == "errorType" || key == "success")
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

function getGroupMembers() {
    gid = $_GET('gid');
    
    $.ajax({
        url:"api/getGroupMembers",
        type: "post",
        data: {
            "gid":gid
        },
        dataType: "json",
        success: function(data) {
            var table = document.getElementById('MemberData');
            for (var i = 0; i < data.length; i++) {
                $('#memberResults').text("");
                if(!data[i].success)
                    continue
                var newRow = table.insertRow(-1);
                for(var key in data[i]) {
                    if(key == "errorType" || key == "success")
                        continue;

                    var newCell = newRow.insertCell(-1);
                    var newText = document.createTextNode(data[i][key]);
                    newCell.appendChild(newText);
                }
            }
        }

    });
}

function getProfile(caller) {
    var sendback;
    $.ajax({
        url: "api/getUserInfo",
        type: "post",
        dataType: "json",
        async: false,
        success: function(data) {
            if(data.success) {
                if(caller == "justacheck") 
                    sendback = data.f_name;
                else
                    setProfile(data);
            }
            else if (document.title != "Study Network")
                goHome();
            else
                alert("You are not logged in.");
        }
    });
    return sendback;
}

function getOrganizations() {
    $.ajax({
        url: "api/getOrganizations",
        type: "post",
        dataType: "json",
        success: function(data) {
            var table = document.getElementById('OrgData'); //'OrgData' is the table name in the profile.html
            for (var i = 0; i < data.length; i++) {
                $('#orgresults').text("");
                if(!data[i].success)
                    continue;
                var newRow = table.insertRow(-1);
                for(var key in data[i]) {
                    if(key == "errorType" || key == "success")
                        continue;
                    if(key == "orgid") {
                        var oidStr = data[i][key];
                        continue; 
                    }

                    //insert new cell at row index 0
                    var newCell = newRow.insertCell(-1);
                    //appen a text node to the cell
                    var newText = document.createTextNode(data[i][key]);
                    newCell.appendChild(newText);
                }

                var newButton = newRow.insertCell(-1);
                var viewButton = document.createElement("button");
                var addName = document.createTextNode("Leave Organization");
                viewButton.appendChild(addName);
                viewButton.onclick=function(oidStr) { return function() {leaveOrganization(oidStr); }; }(oidStr);
                newButton.appendChild(viewButton);
            }
        }
    });
}
