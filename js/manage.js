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
                goToProfile();
            }
            else{
                alert("Error: Could not delete your group");
            }
        }
    });
}

function editGroup(changes) { 
    editS = {"gid":$_GET('gid'),"gname":"ignore", "time1":"ignore", "loc":"ignore"};
    
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

function editProfile(toChange) {
    theDeets = {"f_name":"ignore", "l_name":"ignore", "email":"ignore","password":"ignore"};

    //Set variables
    if (toChange === "first") {
        if(!validFName())
            return;
        else
            theDeets['f_name'] = document.getElementById("f_name").value;            
    }
    else if (toChange === "last") {
        if(!validLName())
            return;
        else
            theDeets['l_name'] = document.getElementById("l_name").value;
    }
    else if (toChange === "email") {
        if(!validEmail())
            return;
        else
            theDeets['email'] = document.getElementById("email").value;
    }
    else if (toChange === "password") {
        if(!validPass())
            return;
        else 
            theDeets['password'] = document.getElementById("password").value;
    }
    
    //Change profile
    $.ajax({
        url: "api/editprofile",
        type: "post",
        data: theDeets,
        dataType: "json",
        success: function(data) {
            if(data.success) {
                $('#cur_f_name').text(data.f_name); //#variable is HTML id and ther one is the php variable
                $('#cur_l_name').text(data.l_name);
                $('#cur_email').text(data.email);    
            }
            else
                alert(data.errorType);
        }
    });

    //Clear input fields
    $("#f_name").val('');
    $("#l_name").val('');
    $("#email").val('');
    $("#password").val('');
    $("#password2").val('');
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
                goToProfile();
            }
            else{
                alert("Error: Could not add you to the group");
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
                goToProfile();
            }
            else{
                alert("Error: Could not remove class");
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
                goToProfile();
            }
            else{
                alert("Error: Could not remove you from group");
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
                goToProfile();
            }
            else {
                alert("Error: " + data.errorType);
            }
        }
    })
}