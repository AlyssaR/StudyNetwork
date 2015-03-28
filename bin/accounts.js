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
    theDeets = { "uid":getID(), "f_name":"ignore", "l_name":"ignore", "email":"ignore"};

    //Set variables
    if (toChange === "first")
        theDeets['f_name'] = document.getElementById("new_f_name").value;
    else if (toChange === "last") 
        theDeets['l_name'] = document.getElementById("new_l_name").value;
    else if (toChange === "email") 
        theDeets['email'] = document.getElementById("new_email").value;

    var regexEmail = /\w+@smu\.edu/;
    var testEmail = regexEmail.test(theDeets['email']);
    if(!testEmail) {
        alert("You must enter an SMU email.");
        return;
    }
    
    //Change profile
    $.ajax({
        url: "api/editprofile",
        type: "post",
        data: theDeets,
        dataType: "json",
        success: function(data) {
            if(data.success) {
                $('#f_name').text(data.f_name);
                $('#l_name').text(data.l_name);
                $('#email').text(data.email);    
            }
            else
                alert("Error changing your information. Name: " + data.f_name + " " + data.l_name + " Email: " + data.email);
        }
    });

    //Clear input fields
    $("#new_f_name").val('');
    $("#new_l_name").val('');
    $("#new_email").val('');
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

function getProfile() {
    $.ajax({
        url: "api/getUserInfo",
        type: "post",
        data: { "uid":getID() },
        dataType: "json",
        success: function(data) {
            if(data.success) {
                $('#f_name').text(data.f_name);
                $('#l_name').text(data.l_name);
                $('#email').text(data.email);
            }
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

function validPass() {
    var pass1=document.getElementById('password');
    var pass2=document.getElementById('password2');
    var message=document.getElementById('validateMessage');
    var matchColor="#66cc66";
    var noMatch="#ff6666";
    if (pass1.value == pass2.value) {
        pass2.style.backgroundColor = matchColor;
        message.style.color=matchColor;
        message.innerHTML="Passwords match!";
        //document.getElementById('submit').disabled=false;
        return true;
    }
    else {
        pass2.style.backgroundColor = noMatch;
        message.style.color=noMatch;
        message.innerHTML = "Passwords do not match!";
        //document.getElementById('submit').disabled=true;
        return false;
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
    var pass2=document.getElementById("password2").value;
	var UserFName = document.getElementById("f_name").value;
	var UserLName = document.getElementById("l_name").value;
	var UserID = document.getElementById("uid").value;
	
    
    var test1 = regexEmail.test(UserEmail);
    var test2 = regexPass.test(UserPass);
	var test3 = regexName.test(UserFName);
	var test4 = regexName.test(UserLName);
	var test5 = regexID.test(UserID);
	console.log("Validating User Credentials");
	if(!test1) {
    	alert("You must enter an SMU email address.");
    	return false;
    }
    else if(!test2) {
    	alert("Passwords must be 8-64 characters and not contain the following: ! @ # $ % & * ; ' _ ");
        return false;
    }
	else if(!test3) {
    	alert("Your first name must be an uppercase letter followed by lowercase letters");
        return false;
    }
	else if(!test4) {
    	alert("Your last name must be an uppercase letter followed by lowercase letters");
        return false;
    }
    else if (UserPass != pass2) {
        alert("Passwords must match.");
        return false;  
    } 
	else if (!test5) {
		alert("Your SMU ID must be 8 numbers, no alpha characters or symbols.")
		return false;
	}
	else 
        return true;
}