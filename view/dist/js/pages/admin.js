var admin = function () {

    var initialize = function () {
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
                generateBranchDropDown(selectedClientId);
                generateReportsDropDown();
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
            type: 'POST',
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

    return {
        initialize: initialize
    };
}();
