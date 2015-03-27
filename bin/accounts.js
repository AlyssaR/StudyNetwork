function authenticate() {
    var result = "";
    $.ajax({
        url: "api/login",
        type: "post",
        async: false,
        data: {
            "email":$("#email").val(), 
            "password":$("#password").val()
        },
        dataType: "json",
        success:function(data) {
            result = data;
        }
    });
    return result;
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

function redirect() {
    window.location = "register.html";
}

function register() {
    if(validRegister()) {
        $.ajax({
            url: "api/register",
            type: "post",
            data: {
                "f_name":$("#f_name").val(), 
                "l_name":$("#l_name").val(), 
                "uid":$("#uid").val(), 
                "email":$("#email").val(), 
                "passwd":$("#password").val()
            },
            dataType: "json",
            success: function(data) {
                if(data.success) {
                    alert("Welcome, " + data.f_name + "!");
                    signIn(data.uid);
                }
                else
                    alert("Error: " + data.errorType);
            }
        });
    }
}

function signIn(value) {
    var date = new Date();
    date.setTime(date.getTime() + (30*60*1000)); //Login expires in 30 minutes
    var expires = "; expires=" + date.toGMTString();

    document.cookie = "sn_uid=" + value + expires + "; path=/";
    window.location = "editprofile.html";
}

function login() {
    if(validLogin()) {
        var data = authenticate();
        if(data.success) {
            alert("Welcome, " + data.f_name);
            signIn(data.uid);
        }
        else
            alert("Error logging in.\nPlease check your email/password or create an account.");
    }
}

function validLogin() {
    var regexName = /\w+@smu\.edu/;
    var regexPass = /[\w!@#$%&*;'"_]{8,64}/;

    var UserName = document.getElementById("email").value;
    var UserPass = document.getElementById("password").value;
    
    var test1 = regexName.test(UserName);
    var test2 = regexPass.test(UserPass);
    
    console.log(test1);
    console.log(test2);
    
    if(!test1) {
    	alert("You must enter an SMU email address.");
    	return false;
    }
    else if(!test2) {
    	alert("Passwords must be 8-64 characters and not contain the following: ! @ # $ % & * ; ' _ ");
        return false;
    }
    else 
        return true;
}

function validRegister() {
	
	var regexID = /[0123456789]{8}/;
	var regexEmail = /\w+@smu\.edu/;
	var regexPass = /[\w!@#$%&*;'"_]{8,64}/;
	var regexName = /[A-Z][a-z]+/;
	
	var UserEmail = document.getElementById("email").value;
    var UserPass = document.getElementById("password").value;
	var UserFName = document.getElementById("f_name").value;
	var UserLName = document.getElementById("l_name").value;
	
    
    var test1 = regexEmail.test(UserEmail);
    var test2 = regexPass.test(UserPass);
	var test3 = regexName.test(UserFName);
	var test4 = regexName.test(UserLName);
	
	if(!test1) {
    	alert("You must enter an SMU email address.");
    	return false;
    }
    else if(!test2) {
    	alert("Passwords must be 8-64 characters and not contain the following: ! @ # $ % & * ; ' _ ");
        return false;
	else if(!test3) {
    	alert("Your first name must be an uppercase letter followed by lowercase letters");
        return false;
	else if(!test4) {
    	alert("Your last name must be an uppercase letter followed by lowercase letters");
        return false;
    }
    else 
        return true;
	
}