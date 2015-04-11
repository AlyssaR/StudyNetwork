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
                alert("Results for Groups");
                //need to pull up search results
                //window.location = "editprofile.html";
            }
            else
                alert("Error: " + data.errorType);
        }
    });
}

function redirectToSearchGroups() {
    window.location = "searchGroups.html";
}

function redirectToClass() {
    window.location = "createClassForm.html";
}
