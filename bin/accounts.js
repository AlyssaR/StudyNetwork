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

function validate() {
    console.log("You pushed the login button");
    
    var regexName = /\w*@smu\.edu/;
    var regexPass = /[\w!@#$%&*;'"_]{8,64}/;

    var UserName = document.getElementById("email").value;
    var UserPass = document.getElementById("password").value;
    
    var test1 = regexName.test(UserName);
    var test2 = regexPass.test(UserPass);
    
    console.log(test1);
    console.log(test2);
    
    if(test1 && test2) {
        console.log("PostCall");
        signIn();
    }
}

function register() {
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
