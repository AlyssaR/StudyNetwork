function signIn() {
    var creds = {"email":$("#email").val(), "password":$("#password").val()},
        url = "api/login";
    
    $.ajax({
        url: "api/login",
        type: "post",
        data: creds,
        success: function(data) {
            alert(data);
        }
    })

//    event.preventDefault();
}