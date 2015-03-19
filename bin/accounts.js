function signIn() {
    $.ajax({
        url: "api/login",
        type: "post",
        data: {
            "email":$("#email").val(), 
            "password":$("#password").val()
        },
        success: function(data) {
            var json = getJSON(data);
            alert(json.f_name);
        }
    });
}