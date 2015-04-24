function LandingPageRedirect() {
	window.location = "index.html";
}

function redirect() {
    window.location = "register.html";
}

function redirectToClass() {
    window.location = "createClassForm.html";
}

function redirectToGroup() {
    window.location = "createStudyGroupForm.html";
}

function redirectToSearchResults() {
	window.location = "searchGroups.html";
}

function redirectToSearchGroups() {
	var queryInput = $("#searchInput").val();
	var splitQueryInput = queryInput.split(" ");
	var urlLocation = "searchGroups.html?";
	for (var x = 0; x < splitQueryInput.length; ++x)
		urlLocation +=  "param" + x + "=" + splitQueryInput[x] + "&";
    window.location = urlLocation;
}
