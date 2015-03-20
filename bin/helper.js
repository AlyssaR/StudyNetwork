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

function redirectToClass() {
    window.location = "createClassForm.html";
}

function redirectToGroup() {
    window.location = "createStudyGroupForm.html";
}