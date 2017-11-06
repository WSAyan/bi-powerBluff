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
        nestable();
    };

    var eventListeners = function () {

    };

    var nestable = function () {
        $('.level_1').on('click', spawn);

        function spawn() {
            // check level
            var level = stripLevel(this.className);
            if (level !== '') {
                var countOthers = this.parentNode.querySelectorAll("[class^='level_" + level + "']").length;
                var x = wrapElement(level, countOthers);
                if (level.length == 1) {
                    $('#addedElements').append(x);
                } else {
                    //x.insertAfter(this);
                    $(this).parent().append(x);
                }
            }
        }

        // strip level
        var stripLevel = function (className) {
            var index = className.indexOf('_');
            if (index > -1) {
                return className.substr(index + 1);
            } else {
                return '';
            }
        };

        // wrapper element
        var wrapElement = function (level, number) {
            var div = $('<div></div>');
            if (level.length == 1) {
                // it's parent
                var input = $('<input type="text" name="foo_" />');
                div.append(input);
            } else {
                // it's child
                var span = $('<span>child level ' + level + '-' + number + '</span>');
                div.append(span);
            }
            // add button
            var button = $('<input class="level_' + level + '-' + number + '"  type="button" value="Add Navigation" />');
            button.on('click', spawn);
            div.append(button);
            div.css('margin-left', (level.length * 10) + 'px');
            return div;
        };
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
