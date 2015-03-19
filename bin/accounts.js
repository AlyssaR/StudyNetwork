<script type="text/javascript" src="http://code.jquery.com/jquery-1.7.1.min.js"></script>

$(document).ready(function() {
    $("#signIn").submit(function(event){
        $("#result").html('');

        /* Get some values from elements on the page: */
        var values = $(this).serialize();

        /* Send the data using post and put the results in a div */
        $.ajax({
            type: "POST",
            url: "api/login",
            data: loginForm,
            success: function(data){
                if(!data.success)
                    alert("login failed");
                else
                    alert("request succeeded");
                //$("#result").html('Submitted successfully');
            },
            error:function(){
                alert("request failed");
                //$("#result").html('There is error while submit');
            }
        });
        event.preventDefault();
    });
});