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

function isAdmin() { 
    var status = false;
    $.ajax({
        url: "api/groupRole",
        data: { "gid":$_GET('gid')},
        dataType: "json",
        async: false,
        type: "post",
        success:function(data) {
            if(data.success && data.role == "admin")
                status = true;
        }
    });
    return status;
}

function isInGroup() { 
    var status = false;
    $.ajax({
        url: "api/isInGroup",
        data: { "gid":$_GET('gid')},
        dataType: "json",
        async: false,
        type: "post",
        success:function(data) {
            if(data.success)
                status = true;
        }
    });
    return status;
}

function isLoggedIn() {
    $.ajax({
        url: "api/getUserID",
        data: { "getID":true},
        dataType: "json",
        type: "post",
        success:function(data) {
            if(data.success)
                showAllTheThings();
            else {
                hideAllTheThings();
            }
        }
    });
}

function login() {
    if(validLogin()) {
        var data = authenticate();
        if(data.success) {
            alert("Welcome, " + data.f_name + "!");
            goToProfile();
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
        success:function(data) {
            if(data.success)
                goHome();
        },
    });
}


function validClass(){
    if(!validProfFName())
        return false;
    if(!validProfLName())
        return false;
    else
        return true;
}

function validEmail(email) {
    var regex = /\w+@smu\.edu/;
    
    if(regex.test(email))
        return true;
    else {
        alert("You must enter an SMU email address.");
        return false;
    }
}

function validFName() {
    var regex = /^[A-Z][-a-zA-Z]+$/;
    var name = document.getElementById("f_name").value;
    if(regex.test(name))
        return true;
    else {
        alert("Your first name must start with an uppercase letter and be followed by only letters from the English alphabet.");
        return false;
    }
}

function validLName() { 
    var regex = /^[A-Z][-'a-zA-Z]+$/;
    var name = document.getElementById("l_name").value;
    if(regex.test(name))
        return true;
    else {
        alert("Your last name must start with an uppercase letter and be followed by only letters from the English alphabet.");
        return false;
    }
}

function validLogin() {
    return (validEmail(document.getElementById("email").value) && validPass('alert'));
}

function validOrg() {
    var regex = /[A-Z][a-zA-Z0-9]+/;
    var name = document.getElementById("org_name").value;
    if(regex.test(name))
        return true;
    else {
        alert("The organization must start with a capital letter.");
        return false;
    }
}


function validPass(alertTrue) {
    var pass1;
    var pass2; 
    if(alertTrue == 'reg' || alertTrue == 'nowregistering') {
        pass1=document.getElementById('reg_pass');
        pass2=document.getElementById('reg_pass2');
    }
    else {
        pass1=document.getElementById('password');
        pass2=document.getElementById('password2');
    }
    if(pass2 == null) 
        pass2 = pass1;

    var message=document.getElementById('validateMessage');
    var matchColor="#66cc66";
    var noMatch="#ff6666";
    
    if (pass1.value == pass2.value) {
        if(message != null) {
            pass1.style.backgroundColor = matchColor;
            pass2.style.backgroundColor = matchColor;
            message.style.color=matchColor;
            message.innerHTML="Passwords match!";
        }

        var isValid = /[\w!@#$%&*;'"_]{8,64}/;
        if(isValid.test(pass1.value))
            return true;
        else {
            if(alertTrue != 'reg')
                alert("Passwords must be 8-64 characters and not contain the following: ! @ # $ % & * ; ' _ ");
            return false;
        }
        //document.getElementById('submit').disabled=false;
    }
    else if (message != null) {
        pass1.style.backgroundColor = noMatch;
        pass2.style.backgroundColor = noMatch;
        message.style.color=noMatch;
        message.innerHTML = "Passwords do not match!";
        //document.getElementById('submit').disabled=true;
    }
    return false;
}

function validProfFName() {
    var regex = /[A-Z][a-z]+/;
    var name = document.getElementById("profFirst").value;
    if(regex.test(name))
        return true;
    else {
        alert("The first name must start with an uppercase letter and be followed by lowercase letters.");
        return false;
    }
}

function validProfLName() { 
    var regex = /[A-Z][a-zA-Z]+/;
    var name = document.getElementById("profLast").value;
    if(regex.test(name))
        return true;
    else {
        alert("The last name must start with an uppercase letter and be followed by only letters from the English alphabet.");
        return false;
    }
}

function validRegister() {
    if(!validEmail(document.getElementById("reg_email").value))
        return false;
    else if(!validPass('nowregistering'))
        return false;
    else if(!validFName())
        return false;
    else if(!validLName())
        return false;
    else 
        return true;
}