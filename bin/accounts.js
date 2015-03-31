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

function editProfile(toChange) {
    theDeets = { "uid":getID(), "f_name":"ignore", "l_name":"ignore", "email":"ignore","password":"ignore"};

    //Set variables
    if (toChange === "first") {
        if(!validFName())
            return;
        else
            theDeets['f_name'] = document.getElementById("f_name").value;            
    }
    else if (toChange === "last") {
        if(!validLName())
            return;
        else
            theDeets['l_name'] = document.getElementById("l_name").value;
    }
    else if (toChange === "email") {
        if(!validEmail())
            return;
        else
            theDeets['email'] = document.getElementById("email").value;
    }
    else if (toChange === "password") {
        if(!validPass())
            return;
        else 
            theDeets['password'] = document.getElementById("password").value;
    }
    
    //Change profile
    $.ajax({
        url: "api/editprofile",
        type: "post",
        data: theDeets,
        dataType: "json",
        success: function(data) {
            if(data.success) {
                $('#cur_f_name').text(data.f_name); //#variable is HTML id and ther one is the php variable
                $('#cur_l_name').text(data.l_name);
                $('#cur_email').text(data.email);    
            }
            else
                alert(data.errorType);
        }
    });

    //Clear input fields
    $("#f_name").val('');
    $("#l_name").val('');
    $("#email").val('');
    $("#password").val('');
    $("#password2").val('');
}

function getProfile() {
    $.ajax({
        url: "api/getUserInfo",
        type: "post",
        dataType: "json",
        success: function(data) {
            if(data.success) {
                $('#cur_f_name').text(data.f_name);
                $('#cur_l_name').text(data.l_name);
                $('#cur_email').text(data.email);
            }
            else {
                alert("Error: Could not retrieve your profile. Please log in.")
                window.location = "index.html";
            }
        }
    });
}

function login() {
    if(validLogin()) {
        var data = authenticate();
        if(data.success) {
            alert("Welcome, " + data.f_name + "!");
            window.location = "editProfile.html";
        }
        else
            alert("Error logging in.\nPlease check your email/password or create an account.");
    }
}

function logout() {
    $.ajax({
        url: "api/logout",
        type: "post",
        dataType: "json",
        success:function() {
            window.location = "index.html";
        }
    });
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
                "email":$("#email").val(), 
                "passwd":$("#password").val()
            },
            dataType: "json",
            success: function(data) {
                if(data.success) {
                    alert("Welcome, " + data.f_name + "!");
                    window.location = "editprofile.html";
                }
                else
                    alert("Error: " + data.errorType);
            }
        });
    }
}

function validEmail() {
    var regex = /\w+@smu\.edu/;
    var email = document.getElementById("email").value;
    
    if(regex.test(email))
        return true;
    else {
        alert("You must enter an SMU email address.");
        return false;
    }
}

function validFName() {
    var regex = /[A-Z][a-z]+/;
    var name = document.getElementById("f_name").value;
    if(regex.test(name))
        return true;
    else {
        alert("Your first name must start with uppercase letter");
        return false;
    }
}

function validLName() { 
    var regex = /[A-Z][a-zA-Z]+/;
    var name = document.getElementById("l_name").value;
    if(regex.test(name))
        return true;
    else {
        alert("Your last name start with an uppercase letter");
        return false;
    }
}

function validLogin() {
    return (validEmail() && validPass());
}

function validPass() {
    var pass1=document.getElementById('password');
    var pass2=document.getElementById('password2');
    if(pass2 == null) 
        pass2 = pass1;

    var message=document.getElementById('validateMessage');
    var matchColor="#66cc66";
    var noMatch="#ff6666";
    
    if (pass1.value == pass2.value) {
        if(message != null) {
            pass2.style.backgroundColor = matchColor;
            message.style.color=matchColor;
            message.innerHTML="Passwords match!";
        }

        var isValid = /[\w!@#$%&*;'"_]{8,64}/;
        if(isValid.test(pass1.value))
            return true;
        else {
            alert("Passwords must be 8-64 characters and not contain the following: ! @ # $ % & * ; ' _ ");
            return false;
        }
        //document.getElementById('submit').disabled=false;
    }
    else if (message != null) {
        pass2.style.backgroundColor = noMatch;
        message.style.color=noMatch;
        message.innerHTML = "Passwords do not match!";
        //document.getElementById('submit').disabled=true;
    }
    return false;
}

function validRegister() {
	if(!validEmail())
    	return false;
    else if(!validPass())
        return false;
	else if(!validFName())
    	return false;
	else if(!validLName())
        return false;
	else 
        return true;
}