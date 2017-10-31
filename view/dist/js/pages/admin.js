var admin = function () {
    var deptId = 1;
    var clientId = null;
    var branchId = null;
    var reportId = null;
    var initialize = function () {
        $('#branchesList').prop('disabled', true);
        $('#branchesList').prop('disabled', true);
        $('#reportsList').prop('disabled', true);
        $('#biHeader').text("Dashboard");
        eventListeners();
    };

    var eventListeners = function () {
        $("#clientList").change(function () {
            var selectedClientId = this.value;
            if (selectedClientId === '0') {
                $('#branchesList').prop('disabled', true);
                $('#reportsList').prop('disabled', true);
            } else {
                $('#branchesList').prop('disabled', false);
                $('#reportsList').prop('disabled', false);
                clientId = selectedClientId;
                generateBranchDropDown(selectedClientId);
                $('#branchesList').change(function () {
                    var selectedBranch = this.value;
                    if (selectedBranch !== "0") {
                        branchId = selectedBranch;
                    }
                });
                generateReportsDropDown();
                $('#reportsList').change(function () {
                    var selectedReport = this.value;
                    if (selectedReport !== "0") {
                        reportId = selectedReport;
                        showReport();
                    }
                });
            }
        });

        $('#reportsList').change(function () {
            var headerText = $('#reportsList').find(":selected").text();
            $('#biHeader').text(headerText);
        });
    };

    var generateBranchDropDown = function (clientId) {
        $.ajax({
            url: 'http://localhost:8080/biportaldemo/generateBranchList.php',
            type: 'GET',
            data: {
                clientId: clientId
            },
            dataType: "json",
            success: function (data) {
                var options = '';
                $.each(data, function (i, o) {
                    options += '<option value="' + o.id + '">' +
                        o.branchName + '</option>';
                });
                $('#branchesList').append(options);
            }
        });
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

    var showReport = function () {
        $.ajax({
            url: 'http://localhost:8080/biportaldemo/getBIReport.php',
            type: 'POST',
            data: {
                'deptId': deptId,
                'clientId': clientId,
                'branchId': branchId,
                'reportId': reportId
            },
            success: function (data) {
                //alert(data);
                $('#reportURLFrame').attr('src', data)
            }
        });
    };

    return {
        initialize: initialize
    };
}();
