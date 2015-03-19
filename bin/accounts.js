function signIn() {
    $.ajax({
        url: "api/login",
        type: "post",
        data: {
            "email":$("#email").val(), 
            "password":$("#password").val()
        },
        dataType: "json",
        success: function(data) {
            if(data.success)
                alert("Welcome, " + data.f_name);
            else
                alert("Go away!");
        }
    });
}