function goHome() {
	window.location = "index.html";
}

function goRegister() {
	window.location = "register.html";
}

function goToClass() {
	window.location = "createClassForm.html";
}

function goToGroup() {
    window.location = "createStudyGroupForm.html";
}

function goToProfile() {
	window.location = "profile.html";
}

function goSearch() {
	var queryInput = $("#searchInput").val();
	var splitQueryInput = queryInput.split(" ");
	var urlLocation = "searchGroups.html?searchBy=" + $("#searchBy").val() + "&";
	for (var x = 0; x < splitQueryInput.length; ++x)
		urlLocation +=  "param" + x + "=" + splitQueryInput[x] + "&";
    window.location = urlLocation;
}

function goSearchFromClass(dept, courseNumber) {
	var urlLocation = "searchGroups.html?searchBy=class&param0=" + dept + "&param1=" + courseNumber + "&";
	window.location = urlLocation;
}