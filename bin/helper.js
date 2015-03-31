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
                
            }
        }
    })

}

function redirectToClass() {
    window.location = "createClassForm.html";
}

function redirectToGroup() {
    window.location = "createStudyGroupForm.html";
}