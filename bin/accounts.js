$("#signIn").submit(function(event){
    var $form = $( this ),
        email = $form.find("input[name='email']").val(),
        password = $form.find("input[name='password']").val(),
        url = $form.attr("action");

    // Send the data using post
    var posting = $.post( url, { s: term } );

    // Put the results in a div
    posting.done(function( data ) {
    var content = $( data ).find( "#content" );
    $( "#result" ).empty().append( content );
    });

    $.post( "api/login", function(data) {
        alert( "Data Loaded: " + data );
    });
    
    event.preventDefault();
});