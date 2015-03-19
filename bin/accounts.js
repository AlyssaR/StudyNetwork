
function signIn(event){
    event.preventDefault();
    $.ajax({
            type: "POST",
            url: "api/login",
            data: {
                email: $("#email").val(),
                password: $("#password").val()
            },
            dataType:'json',
            success: function(data){
                alert("The information entered was not correct. Try Again.");

                /*else{
                    $.each(data, function(index, element) {
                        $('body').append($('<div>', {
                            text: element.name
                        }));
                    });
                    //$("#email").val("");
                    //$("#password").val("");

                    //alert(json);
                    //window.location = "index.html";
                }
*/
            }
    });
}

