function loadCentralNav() {
	document.getElementById('centralNavBar').innerHTML = "<!--Navigation bar and Header-->"+
	"<nav class='navbar navbar-default'>"+
	    "<div class='container-fluid'>"+
	        "<!-- Brand and toggle get grouped for better mobile display -->"+
	        "<div class='navbar-header'>"+
	            "<button type='button' class='navbar-toggle collapsed' data-toggle='collapse' data-target='#bs-example-navbar-collapse-1'>"+
	                "<span class='sr-only'>Toggle navigation</span>"+
	                "<span class='icon-bar'></span>"+
	                "<span class='icon-bar'></span>"+
	                "<span class='icon-bar'></span>"+
	            "</button>"+
	            "<a class='navbar-brand' href='index.html'>The Study Network</a>"+
	        "</div>"+

	        "<!-- Collect the nav links, forms, and other content for toggling -->"+
	        "<div class='collapse navbar-collapse' id='bs-example-navbar-collapse-1'>"+
	            "<ul class='nav navbar-nav'>"+
	                "<li class='active'><a href='index.html'>Home <span class='sr-only'>(current)</span></a></li>"+
	                "<li><a href='about.html'>About</a></li>"+
	                "<li class='dropdown'>"+
	                    "<a href='#' class='dropdown-toggle' data-toggle='dropdown' role='button' aria-expanded='false' id = 'navCreate'>Create <span class='caret'></span></a>"+
	                    "<ul class='dropdown-menu' role='menu'>"+
	                        "<li><a href='createClassForm.html'>Create Class</a></li>"+
	                        "<li><a href='createStudyGroupForm.html'>Create Study Group</a></li>"+
	                    "</ul>"+
	                "</li>"+
	            "</ul>"+
	            "<form class='navbar-form navbar-left' role='search' action='javascript:redirectToSearchGroups()'>"+
	                "<div class='form-group'>"+
	                    "<!-- No functionality currently -->"+
	                    "<input type='text' id='searchInput' class='form-control' placeholder='Search'>"+
	                "</div>"+
	                "<button type='submit' class='btn btn-default'>Search</button>"+
	            "</form>"+
	            "<ul class='nav navbar-nav navbar-right'>"+

	                "<li class='dropdown'>"+
	                    "<a href='#' class='dropdown-toggle' data-toggle='dropdown' role='button' aria-expanded='false' id='navGreet'>Welcome, <label id='sayHello'></label><span class='caret'></span></a>"+
	                    "<ul class='dropdown-menu' role='menu'>"+
	                        "<li><a href='profile.html'>View Profile</a></li>"+
	                        "<li><a href='javascript:void(0)' onclick = 'logout();'>Logout</a></li>"+
	                    "</ul>"+
	                "</li>"+
	            "</ul>"+
	        "</div><!-- /.navbar-collapse -->"+
	    "</div><!-- /.container-fluid -->"+
	"</nav>"+
	"<!--end nav bar -->";
}