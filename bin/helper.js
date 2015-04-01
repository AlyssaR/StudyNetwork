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

function searchForClasses() {
  // get value in text input
  var search = $("#search-for-class input").val();
  // convert into array with " " as the delimiter
  search = search.split(" ");
  search = JSON.stringify(search);
  $.ajax({
    url: "api/searchForClasses",
    type: "get",
    data: {search:search},
    dataType: "json",
    success: function(data) {
      console.log(data);
    }
  });
}

function redirectToClass() {
    window.location = "createClassForm.html";
}

function redirectToGroup() {
    window.location = "createStudyGroupForm.html";
}
