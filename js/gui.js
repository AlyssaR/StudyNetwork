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

function setEditableFalse() {
    document.getElementById('optDisp1').style.display = "none";
    document.getElementById('optDisp2').style.display = "none";
    document.getElementById('optDisp3').style.display = "none";
}

function setEditableTrue() {
    document.getElementById('optDisp1').style.display = "block";
    document.getElementById('optDisp2').style.display = "block";
    document.getElementById('optDisp3').style.display = "block";
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
        document.getElementById('deleteStudyGroupButton').style.display="none";
        if(isInGroup()) {
            document.getElementById('leaveButton').style.display="block";
            document.getElementById('joinButton').style.display="none";
            if(isAdmin()) {
                document.getElementById('deleteStudyGroupButton').style.display="block";
                document.getElementById('editableButton').style.display="block";
                document.getElementById('leaveButton').style.display="none";
            }
        }
        else {
            document.getElementById('leaveButton').style.display="none";
            document.getElementById('joinButton').style.display="block";
        }
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