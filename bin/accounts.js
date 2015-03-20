function authenticate() {
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
                signIn(data.uid);
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
        authenticate();
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

function signIn(value) {
    var date = new Date();
    date.setTime(date.getTime() + (30*60*1000)); //Login expires in 30 minutes
    var expires = "; expires=" + date.toGMTString();

    document.cookie = "sn_uid=" + value + expires + "; path=/";
}

function getID() {
    var name = "sn_uid=";
    var ca = document.cookie.split(';');
    for(var i=0;i < ca.length;i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1,c.length);
        if (c.indexOf(name) == 0) return c.substring(name.length,c.length);
    }
    return null;
}

function getName() {
    $.ajax({
        url: "api/getUserInfo",
        type: "post",
        data: { "uid":getID() },
        dataType: "json",
        success: function(data) {
            if(data.success)
                $('#name').text(data.f_name + " " + data.l_name);
            else
                alert("Error retrieving your information. Please log in.");
        }
    });
}

function logout() {
    document.cookie = "sn_uid=;expires=-1;path=/";
    window.location = "index.html";
}