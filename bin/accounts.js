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
            if(data.success) {
                alert("Welcome, " + data.f_name);
                window.location = "editprofile.html";
            }
            else
                alert("Error logging in. Please check your email/password or create an account.");
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
        url: "api/register",
        type: "post",
        data: {
            "f_name":$("#f_name").val(), 
            "l_name":$("#l_name").val(), 
            "uid":$("#uid").val(), 
            "email":$("#email").val(), 
            "passwd":$("#passwd").val()
        },
        dataType: "json",
        success: function(data) {
            if(data.success) {
                alert("Welcome, " + data.f_name + "!");
                window.location = "index.html";
            }
            else
                alert("Error: " + data.errorType);
        }
    });
}

function redirect() {
    window.location = "register.html";
}
