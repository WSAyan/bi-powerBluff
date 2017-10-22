var logIn = function () {

    var initialize = function () {
        eventListeners();
    };

    var eventListeners = function () {
        $('#signIn').click(function () {
            var username = $('#username').val();
            var password = $('#password').val();
            logInAttempt(username,password);
        });
    };

    var logInAttempt = function (username, password) {
        var request = $.ajax({
            url: "http://localhost:8080/BIPortalDemo/login.php",
            type: "post",
            data: {
                'username': username,
                'password': password
            }
        });

        request.done(function (response, textStatus, jqXHR) {
            console.log("Hooray, it worked!\n" + response + "\n" + textStatus);
        });

        request.fail(function (jqXHR, textStatus, errorThrown) {
            console.error(
                "The following error occurred: " +
                textStatus, errorThrown
            );
        });

    };

    return {
        initialize: initialize
    };
}();
