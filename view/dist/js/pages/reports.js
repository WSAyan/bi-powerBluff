var reports = function () {
    var baseURL = 'http://localhost:8080/biportaldemo/';
    //var baseURL = 'http://192.168.100.116:8080/biportaldemo/';
    var deptId = null;
    var clientId = null;
    var branchId = null;
    var reportId = null;
    var reportURL = null;
    var reportName = null;

    var initialize = function () {
        $('#clientList').prop('disabled', true);
        $('#branchesList').prop('disabled', true);
        $('#reportsList').prop('disabled', true);
        eventListeners();
    };

    var eventListeners = function () {
        $('#createReport').click(openExcel);

        $("#reportTable").on('click','tr',function(e){
            e.preventDefault();
            reportName= $(this).attr('id');
            $('#reportModalHeader').text(reportName);
        });

        $("#departmentsList").change(function () {
            var selectedDeptId = this.value;
            if (selectedDeptId === '0') {
                $('#clientList').prop('disabled', true);
                $('#branchesList').prop('disabled', true);
                $('#reportsList').prop('disabled', true);
            } else {
                deptId = selectedDeptId;
                $('#clientList').prop('disabled', false);
                generateClientDropDown(selectedDeptId);
                $('#clientList').change(function () {
                    var selectedClientId = this.value;
                    if (selectedClientId === '0') {
                        $('#branchesList').prop('disabled', true);
                        $('#reportsList').prop('disabled', true);
                    } else {
                        clientId = selectedClientId;
                        $('#branchesList').prop('disabled', false);
                        $('#reportsList').prop('disabled', false);

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
                            }
                        });
                    }
                });
            }

            $('#saveReport').click(saveReport);
        });


    };



    var openExcel = function () {
        $.ajax({
            url: baseURL + 'openExcel.php',
            type: 'POST',
            data: {
                'user': 'admin'
            },
            success: alert("PowerBI Desktop opened!")
        });
    };

    var generateClientDropDown = function (deptId) {
        $.ajax({
            url: baseURL + 'generateClientList.php',
            type: 'GET',
            data: {
                deptId: deptId
            },
            dataType: "json",
            success: function (data) {
                var options = '';
                $.each(data, function (i, o) {
                    options += '<option value="' + o.id + '">' +
                        o.clientName + '</option>';
                });
                $('#clientList').append(options);
            }
        });
    };

    var generateBranchDropDown = function (clientId) {
        $.ajax({
            url: baseURL + 'generateBranchList.php',
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
            url: baseURL + 'generateReportList.php',
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
            url: baseURL + 'saveBIReport.php',
            type: 'POST',
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
