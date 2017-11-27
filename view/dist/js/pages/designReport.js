var designReport;
designReport = function () {
    var baseURL = 'http://localhost:8080/biportaldemo/';
    //var baseURL = 'http://192.168.100.116:8080/biportaldemo/';
    var deptId = null;
    var clientId = null;
    var branchId = null;
    var reportId = null;
    var reportURL = null;
    var reportName = null;
    var captionList = null;
    var maxJsonDepth = 0;
    var json = '[{"id":1,"name":"example"}]';

    var initialize = function () {
        generateReportsDropDown();
        customNestable();
        //getDesignedReport();
        eventListeners();
    };

    var eventListeners = function () {
        $('#saveDesign').click(function () {
            var x = $('.dd').nestable('serialize');
            captionList = JSON.stringify(x);
            //saveDesign();
            //alert(captionList);
            x = $('.dd').nestable('asNestedSet');
            console.log(JSON.stringify(x));
        });
        $("#reportsList").change(function () {
            reportId = this.value;
            //getDesignedReport();
        });

        $(document).on('click', '.deleteItem', function () {
            var selectedId = $(this).data('owner-id');
            //console.log(selectedId);
            $('#nestable-json').nestable('remove', selectedId);
            var x = $('.dd').nestable('serialize');
            json = JSON.stringify(x);
            json = manipulateJsonOnRemoval();
            customNestable();
        });
    };

    var customNestable = function () {
        //json = '[{"id":1,"name":"a"},{"id":2,"name":"b"},{"id":3,"name":"c","children":[{"id":4,"name":"d"},{"id":5,"name":"e"}]}]';
        //console.log("customNestable");
        //console.log(json);
        var options = {
            'json': json,
            itemRenderer: function (item, content, children, options) {
                var html = "<li class='dd-item' data-id='" + item['data-id'] + "' data-name='" + item['data-name'] + "'>";
                html += "<div class='dd-handle'>" + item['data-name'] + "</div>";
                html += "<span class='button-delete btn btn-default btn-xs pull-right deleteItem' data-owner-id='" + item['data-id'] + "'><i class=\"fa fa-times-circle-o\" aria-hidden=\"true\"></i></span>";
                html += "<span class='button-edit btn btn-default btn-xs pull-right editItem' data-owner-id='" + item['data-id'] + "'><i class=\"fa fa-pencil\" aria-hidden=\"true\"></i></span>";
                html += children;
                html += "</li>";
                return html;
            }
        };

        $('#nestable-json').nestable(options);
        $('#addButton').click(function () {
            var itemText = $('#addInputName').val();
            var x = $('.dd').nestable('serialize');
            json = JSON.stringify(x);
            var newId = getMaxJsonDepth(json) + 1;
            //console.log(newId);
            $('#nestable-json').nestable('add', {"id": newId, "name": itemText});
            maxJsonDepth = newId;
        });

        /*$(document).on('click', '.deleteItem', function () {
            var selectedId = $(this).data('owner-id');
            //console.log(selectedId);
            $('#nestable-json').nestable('remove', selectedId);
            /!*var x = $('.dd').nestable('serialize');
            json = JSON.stringify(x);
            console.log(json);
            maxJsonDepth = getMaxJsonDepth(json);*!/
            //customNestable();
        });*/

    };

    function getMaxJsonDepth(obj) {
        $.each(JSON.parse(obj), function (index, item) {
            maxJsonDepth = check(parseInt(item.id));
            if (item.children) {
                $.each(item.children, function (index, sub) {
                    maxJsonDepth = check(parseInt(sub.id));
                });
            }

            function check(x) {
                if (x > maxJsonDepth) {
                    maxJsonDepth = x;
                }
                return maxJsonDepth;
            }
        });
        return maxJsonDepth;
    }

    function manipulateJsonOnRemoval(jsonObj,removeId){
        $.each(JSON.parse(jsonObj), function (index, item) {
            var recentId= check(parseInt(item.id));
            if (item.children) {
                $.each(item.children, function (index, sub) {
                    recentId = check(parseInt(sub.id));
                });
            }

            if(recentId > removeId){
                recentId--;
            }
            item.id = recentId;
        });
        return jsonObj;
    }

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

    var saveDesign = function () {
        $.ajax({
            url: baseURL + 'saveDesignedReport.php',
            type: 'POST',
            data: {
                'deptId': deptId,
                'clientId': clientId,
                'branchId': branchId,
                'reportId': reportId,
                'captionList': captionList
            },
            success: function (data) {
                console.log(data);
                window.location.reload();
            }
        });
    };

    var getDesignedReport = function () {
        $.ajax({
            url: baseURL + 'getDesignedReport.php',
            type: 'GET',
            data: {
                'deptId': 0,
                'clientId': 0,
                'branchId': 0,
                'reportId': reportId
            },
            dataType: "json",
            success: function (data) {
                json = JSON.stringify(data);
                customNestable();
                console.log("GetDesignSuccess");
                console.log(data);
            },
            error: function (xhr, statusText) {
                console.log(statusText);
                customNestable();
            }
        });
    };

    return {
        initialize: initialize
    };
}();
