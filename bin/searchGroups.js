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
                alert("Groups for Class");
                //need to pull up search results
                //window.location = "editprofile.html";
            }
            else
                alert("Error: " + data.errorType);
        }
    });
}


function redirectToClass() {
    window.location = "createClassForm.html";
}
