var designReport = function () {
    var deptId = null;
    var clientId = null;
    var branchId = null;
    var reportId = null;
    var reportURL = null;
    var reportName = null;

    var initialize = function () {
        generateReportsDropDown();
        eventListeners();
    };

    var eventListeners = function () {

    };

    var generateReportsDropDown = function () {
        $.ajax({
            url: 'http://localhost:8080/biportaldemo/generateReportList.php',
            type: 'GET',
            data: {
                report: 'report'
            },
            dataType: "json",
            success: function (data) {
                var options = '';
                $.each(data, function (i, o) {
                    options += '<option value="' + o.id + '">' +
                        o.ReportName + '</option>';
                });
                $('#reportsList').append(options);
            }
        });
    };

    var saveReport = function () {
        reportURL = $("#urlInput").val();
        reportName = $('#reportModalHeader').text();
        $.ajax({
            url: "http://localhost:8080/BIPortalDemo/saveBIReport.php",
            type: "POST",
            data: {
                'deptId': deptId,
                'clientId': clientId,
                'branchId': branchId,
                'reportId': reportId,
                'reportURL': reportURL,
                'reportName': reportName
            },
            success: function (data) {
                alert("Report Saved");
                window.location.reload();
            }
        });
    };

    return {
        initialize: initialize
    };
}();
