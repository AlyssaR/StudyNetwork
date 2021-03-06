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
    theDeets = {"f_name":"ignore", "l_name":"ignore", "email":"ignore","password":"ignore"};

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

function getProfile(caller) {
    var sendback;
    $.ajax({
        url: "api/getUserInfo",
        type: "post",
        dataType: "json",
        async: false,
        success: function(data) {
            if(data.success) {
                if(caller == "justacheck") 
                    sendback = data.f_name;
                else
                    setProfile(data);
            }
            else if (document.title != "Study Network")
                window.location = "index.html";
            else
                alert("You are not logged in.");
        }
    });
    return sendback;
}

function hideAllTheThings() {
    document.getElementById('navCreate').style.display = "none";
    document.getElementById('navGreet').style.display = "none";
    //Add if is createGroup,createClass,groupProfile,profile, etc, redirect to login
    if(document.title == "Profile" || document.title == "Group Profile" 
        || document.title == "Create a Class" || document.title == "Create a Study Group") {
        alert("You do not have permission to view this page.\nPlease log in or create an account.");
        window.location = "index.html";
    }
}

function $_GET(q,s) {
    s = (s) ? s : window.location.search;
    var re = new RegExp('&amp;'+q+'=([^&amp;]*)','i');
    return (s=s.replace(/^\?/,'&amp;').match(re)) ? s=s[1] : s='';
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
            window.location = "profile.html";
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
                window.location = "index.html";
        },
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
                "email":$("#reg_email").val(), 
                "passwd":$("#reg_pass").val()
            },
            dataType: "json",
            success: function(data) {
                if(data.success) {
                    alert("Welcome, " + data.f_name + "!");
                    window.location = "profile.html";
                }
                else
                    alert("Error: " + data.errorType);
            }
        });
    }
}

function setEditableTrue() {
    document.getElementById('optDisp1').style.display = "block";
    document.getElementById('optDisp2').style.display = "block";
    document.getElementById('optDisp3').style.display = "block";
    document.getElementById('optDisp4').style.display = "block";
}

function setEditableFalse() {
    document.getElementById('optDisp1').style.display = "none";
    document.getElementById('optDisp2').style.display = "none";
    document.getElementById('optDisp3').style.display = "none";
    document.getElementById('optDisp4').style.display = "none";
}

function setProfile(data) {
    $('#cur_f_name').text(data.f_name);
    $('#cur_l_name').text(data.l_name);
    $('#cur_email').text(data.email);        
}

function showAllTheThings() {
    document.getElementById('navCreate').style.display = "show";
    document.getElementById('navGreet').style.display = "show";
    document.getElementById('sayHello').innerHTML = getProfile('justacheck');

    if(document.title == "Study Network") {
        document.getElementById('loginForm').style.display = "none";
        document.getElementById('registerLinkTo').style.display = "none";
    }
    else if(document.title == "Group Profile") {
        document.getElementById('editableButton').style.display="none";
        if(isInGroup()) {
            toggleJoin('leave');
            if(isAdmin()) {
                document.getElementById('deleteStudyGroupButton').style.display="block";
                document.getElementById('editableButton').style.display="block";
                document.getElementById('leaveButton').style.display="none";
            }

        }
        else
            toggleJoin('join');
    }
}

function toggleJoin(action){
    if (action == "leave") {
        document.getElementById('leaveButton').style.display="block";
        document.getElementById('joinButton').style.display="none";
    }
    else {
        document.getElementById('leaveButton').style.display="none";
        document.getElementById('joinButton').style.display="block";
    }
}

function toggle(){
	if (document.getElementById('optDisp1').style.display == "none") {
		document.getElementById("editableButton").innerHTML="View Profile";
		setEditableTrue();
	}
	else {
		document.getElementById("editableButton").innerHTML="Edit Profile";
		setEditableFalse();
	}
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

function toggle_visibility(id) {
    var e = document.getElementById(id);
    if (e.style.display == 'visible' || e.style.display=='')
    {
        e.style.display = 'hidden';
    }
    else 
    {
        e.style.display = 'visible';
    }
}