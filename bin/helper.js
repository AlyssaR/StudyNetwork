function createClass() {
    $.ajax({
        url: "api/addClass",
        type: "post",
        data: {
            "dept":$("#dept").val(), 
            "class_num":$("#class_num").val(),
            "time2":$("#time2").val(), 
            "professor":$("#professor").val(), 
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

function redirectToClass() {
    window.location = "createClassForm.html";
}

function redirectToGroup() {
    window.location = "createStudyGroupForm.html";
}