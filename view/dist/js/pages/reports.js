var reports = function () {

    var initialize = function () {
        eventListeners();
    };

    var eventListeners = function () {
        $('#createReport').click(openExcel);
    };

    var openExcel = function() {
        $.ajax({
            type: "post",
            url: "http://localhost:8080/BIPortalDemo/openExcel.php",
            data: {
                'user': 'admin'
            },
            success: alert("Excel opened!")
        });
    };

    return {
        initialize: initialize
    };
}();
