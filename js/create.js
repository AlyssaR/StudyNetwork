function createClass() {
    if(validClass()) {
        $.ajax({
            url: "api/addClass",
            type: "post",
            data: {
                "dept":$("#dept").val(), 
                "class_num":$("#class_num").val(),
                "time2":$("#time2").val(), 
                "profFirst":$("#profFirst").val(), 
                "profLast":$("#profLast").val(), 
            },
            dataType: "json",
            success: function(data) {
                if(data.success) {
                    alert("Class added successfully!");
                    goToProfile();
                }
                else
                    alert("Error: " + data.errorType);
            }
        });
    }
}

function createGroup() {
    $.ajax({
        url: "api/addGroup",
        type: "post",
        data: {
            "gname":$("#gname").val(), 
            "time1":$("#time1").val(),
            "loc":$("#loc").val(),
            "dept":$("#dept").val(),
            "class_num":$("#class_num").val(), 
        },
        dataType: "json",
        success: function(data) {
            if(data.success) {
                alert("Group added successfully!");
                goToProfile();
            }
            else
                alert("Error: " + data.errorType);
        }
    });  
}

function createOrganization() {
    if(validOrg()){
        $.ajax({
            url: "api/addOrganization",
            type: "post",
            data: {
                "org_name":$("#org_name").val()
            },
            dataType: "json",
            success: function(data) {
                if(data.success) {
                    alert("Organization added successfully!");
                    goToProfile();
                }
                else {
                    alert(data.errorType);
                    goToProfile();
                }
            }
        });
    }
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
                    goToProfile();
                }
                else
                    alert("Error: " + data.errorType);
            }
        });
    }
}
