
function signIn(){
    event.preventDefault();
    $.ajax({
            type: "POST",
            url: "api/login",
            data: {
                email: $("#email").val(),
                password: $("#password").val()
            },
            success: function(json){
                console.log(json);
                if(json === null){
                    alert("The information entered was not correct. Try Again.");
                }
                else{
                    $("#email").val("");
                    $("#password").val("");

                    window.location = "index.html";
                }

            }
    });
}

