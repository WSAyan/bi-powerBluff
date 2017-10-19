var logIn = $(function () {
    "use strict";

    function initialize() {
        alert("");
        eventListeners();
    };

    var eventListeners = function () {
        var username = $('#username').val;
        var password = $('#password').val;
        $('#signIn').click(logInAttempt(username, password));
    };

    var logInAttempt = function (username, password) {
        alert("a");
        var request = $.ajax({
            url: "http://localhost:8080/BIPortalDemo/login.php",
            type: "post",
            data: {
                'username' : username,
                'password' : password
            }
        });
        // Callback handler that will be called on success
        request.done(function (response, textStatus, jqXHR){
            // Log a message to the console
            console.log("Hooray, it worked!");
        });

        // Callback handler that will be called on failure
        request.fail(function (jqXHR, textStatus, errorThrown){
            // Log the error to the console
            console.error(
                "The following error occurred: "+
                textStatus, errorThrown
            );
        });

    };

    return {
        initialize: initialize
    };
});
