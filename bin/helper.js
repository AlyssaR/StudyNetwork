function createClass() {
    if(validClass()) {
        $.ajax({
            url: "api/addClass",
            type: "post",
            data: {
                "dept":$("#dept").val(), 
                "class_num":$("#class_num").val(),
                "time2":$("#time2").val(), 
                "profFirst":$("#profFirst").val(), 
                "profLast":$("#profLast").val(), 
            },
            dataType: "json",
            success: function(data) {
                if(data.success) {
                    alert("Class added successfully!");
                    window.location = "profile.html";
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
            "class_num":$("#class_num").val(), 
        },
        dataType: "json",
        success: function(data) {
            if(data.success) {
                alert("Group added successfully!");
                window.location = "profile.html";
            }
            else
                alert("Error: " + data.errorType);
        }
    });  
}

function createOrganization() {
    if(validOrg()){
        $.ajax({
            url: "api/addOrganization",
            type: "post",
            data: {
                "org_name":$("#org_name").val()
            },
            dataType: "json",
            success: function(data) {
                if(data.success) {
                    alert("Organization added successfully!");
                    window.location = "profile.html";
                }
                else {
                    alert(data.errorType);
                    window.location = "profile.html";
                }
            }
        });
    }
}

function editGroup(changes) { 
    editS = {"gid":$('#gid').text(),"gname":"ignore", "time1":"ignore", "loc":"ignore"};

    //Change variables
    if (changes === "GroupName") { //also "GroupName is probably tied to HTML"
        editS['gname'] = document.getElementById("gname").value;
    }
    if(changes === "time1") {
        editS['time1'] = document.getElementById("time1").value;
    }
    if(changes === "loc") {
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
                var buttonTwo = newRow.insertCell(-1);

                var viewButton = document.createElement("button");
                var viewTwo = document. createElement("button");

                var addName = document.createTextNode("Remove Class");
                var nameTwo = document.createTextNode("Search for Related Groups");

                viewButton.appendChild(addName);
                viewTwo.appendChild(nameTwo);

                viewButton.onclick=function(deptStr, classStr) { return function() { leaveClass(deptStr, classStr); }; }(deptStr, classStr);
                viewTwo.onclick=function(deptStr, classStr) { return function() { pullGroup(deptStr, classStr); }; }(deptStr, classStr);

                buttonTwo.appendChild(viewTwo);
                newButton.appendChild(viewButton);



            }
        }
    });
}

function $_GET(q,s) {
    s = (s) ? s : window.location.search;
    var re = new RegExp('&amp;'+q+'=([^&amp;]*)','i');
    return (s=s.replace(/^\?/,'&amp;').match(re)) ? s=s[1] : s='';
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
                window.location = "profile.html";
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

function getDoodleData()
{
	var DoodleData = {};
	var times = [];
	var dates = [];
	
	times[0] = document.getElementById("meet_time").value;
	dates[0] = document.getElementById("meet_date").value;
	
	DoodleData.grpName = document.getElementById("meet_name").value;
	DoodleData.times = times;//.push(document.getElementById("meet_time").value);
	DoodleData.dates = dates;//.push(document.getElementById("meet_date").value);
	
	
	
	console.log(DoodleData);
	console.log(document.getElementById("meet_time").value);
	
	
	
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

function leaveClass(dept, class_num) {
    $.ajax({ 
        url: "api/leaveClass",
        type: "post",
        data: {
            "dept": dept,
            "class_num": class_num
        },
        dataType: "json",
        success: function(data) {
            if (data.success) {
                alert("Class removed from profile.");
                window.location = "profile.html";
            }
            else{
                alert("Error: Could not remove class");
            }
        }
    });
}

function joinStudyGroup() {
    $.ajax({
        url: "api/joinStudyGroup",
        type: "post",
        data: {
            "gid": $_GET('gid')
        },
        dataType: "json",
        success: function(data) {
            if(data.success) {
                alert("You have joined the group.");
                window.location = "profile.html";
            }
            else{
                alert("Error: Could not add you to the group");
            }
        }
    });
}

function leaveStudyGroup() {
    $.ajax({
        url: "api/leaveStudyGroup",
        type: "post",
        data: {
            "gid": $_GET('gid')
        },
        dataType: "json",
        success: function(data) {
            if(data.success) {
                alert("You have left the group.");
                window.location = "profile.html";
            }
            else{
                alert("Error: Could not remove you from group");
            }
        }
    });
}

function deleteStudyGroup() {
    $.ajax({
        url: "api/deleteGroup",
        type: "post",
        data: {
            "gid": $_GET('gid')
        },
        dataType: "json",
        success: function(data) {
            if(data.success) {
                alert("You have deleted the group.");
                window.location = "profile.html";
            }
            else{
                alert("Error: Could not delete your group");
            }
        }
    });
}



function leaveOrganization(orgid) {
    $.ajax({ 
        url: "api/leaveOrganization",
        type: "post",
        data: {
            "orgid": orgid
        },
        dataType: "json",
        success: function(data) {
            if(data.success) {
                alert("You have removed the organization from your profile.");
                window.location = "profile.html";
            }
            else {
                alert("Error: " + data.errorType);
            }
        }
    })
}


function pullGroup(dept, class_num) {
    $.ajax({ 
        url: "api/pullGroup",
        type: "post",
        data: {
            "dept": dept,
            "class_num": class_num
        },
        dataType: "json",
        success: function(data) {
            populateSearchResults(data)
        }

    })
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


function redirectToClass() {
    window.location = "createClassForm.html";
}

function redirectToDoodle() {
	window.location = "doodleAPILink.html";
}

function redirectToGroup() {
    window.location = "createStudyGroupForm.html";
}

function redirectToSearchResults() {
	window.location = "searchGroups.html";
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
    var name = document.getElementById("profFirst").value;
    if(regex.test(name))
        return true;
    else {
        alert("The first name must start with an uppercase letter and be followed by lowercase letters.");
        return false;
    }
}


function validLName() { 
    var regex = /[A-Z][a-zA-Z]+/;
    var name = document.getElementById("profLast").value;
    if(regex.test(name))
        return true;
    else {
        alert("The last name must start with an uppercase letter and be followed by only letters from the English alphabet.");
        return false;
    }
}

function validOrgName() {
    var regex = /[A-Z][-'a-zA-Z0-9]+/;
    var name = document.getElementById("org_name").value;
    if(regex.test(name))
        return true;
    else {
        alert("The organization must start with a capital letter.");
        return false;
    }
}

function validOrg(){
    if(!validOrgName())
        return false;
    else
        return true;
}
