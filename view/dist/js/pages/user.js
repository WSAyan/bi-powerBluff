var user = function () {
    var baseURL = 'http://localhost:8080/biportaldemo/';
    //var baseURL = 'http://192.168.100.116:8080/biportaldemo/';
    var deptId = null;
    var clientId = null;
    var branchId = null;
    var reportId = null;
    var reportURL = null;
    var reportName = null;

    var initialize = function () {
        reportId = 0;
        showReport();
        eventListeners();
        $('#biHeader').text("Dashboard");
    };

    var eventListeners = function () {
        $('#reportsList li').click(function () {
            var selectedReport = $(this).index();
            var selectedReportName = $(this).text();
            $('#biHeader').text(selectedReportName);
            reportId = selectedReport + 1;
            showReport();
        });
    };

    var showReport = function () {
        deptId = 1;
        clientId = 1;
        branchId = 0;
        $.ajax({
            url: baseURL + 'getBIReport.php',
            type: 'POST',
            data: {
                'deptId': deptId,
                'clientId': clientId,
                'branchId': branchId,
                'reportId': reportId
            },
            success: function (data) {
                $('#reportURLFrame').attr('src', data);
            },
            fail: function () {
                $('#reportURLFrame').attr('src', defaultReport);
            }
        });
    };

    return {
        initialize: initialize
    };
}();
