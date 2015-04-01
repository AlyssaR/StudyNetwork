function searchByClass() {
    $.ajax({
        url: "api/searchByClass",
        type: "post",
        data: {
            "class":$("#class").val(),  
        },
        dataType: "json",
        success: function(data) {
            if(data.success) {
                alert("Groups exist for that class");
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
