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
    var captionListWithDepth = null;
    var maxJsonId = 0;
    var json = '[{"id":1,"name":"example"}]';

    var initialize = function () {
        generateReportsDropDown();
        customNestable();
        //getDesignedReport();
        eventListeners();
    };

    var eventListeners = function () {
        $('#saveDesign').click(function () {
            var serializedData = JSON.stringify($('#nestable-json').nestable('serialize'));
            var dataWithDepth = JSON.stringify($('#nestable-json').nestable('asNestedSet'));
            captionList = serializedData;
            captionListWithDepth = dataWithDepth;
            saveDesign();
        });
        $("#reportsList").change(function () {
            reportId = this.value;
            //getDesignedReport();
        });
    };

    var customNestable = function () {
        $('#nestable-json').nestable(renderedOption());

        $('#addButton').click(function () {
            var itemText = $('#addInputName').val();
            var x = $('.dd').nestable('serialize');
            json = JSON.stringify(x);
            var newId = getMaxJsonDepth(json) + 1;
            $('#nestable-json').nestable('add', {"id": newId, "name": itemText});
            maxJsonId = newId;
        });

        $(document).on('click', '.deleteItem', function () {
            var selectedId = $(this).data('owner-id');
            $('#nestable-json').nestable('remove', selectedId, function () {
                //customNestable();
                var x = $('#nestable-json').nestable('serialize');
                json = JSON.stringify(x);
                json = manipulateJsonOnRemoval(json, selectedId);
                //console.log("manipulated Json: " + json);
                $('#nestable-json').nestable('destroy');
                $('#nestable-json').nestable(renderedOption());
                maxJsonId = 0;
            });
        });
    };

    function renderedOption() {
        //console.log("Passed Json" + json);
        return {
            'json': json,
            itemRenderer: function (item, content, children, options) {
                //console.log(item['data-id']);
                var html = "<li class='dd-item' data-name='" + item['data-name'] + "' data-id='" + item['data-id'] + "' >";
                html += "<div class='dd-handle'>" + item['data-name'] + "</div>";
                html += "<span class='button-delete btn btn-default btn-xs pull-right deleteItem' data-owner-id='" + item['data-id'] + "'><i class=\"fa fa-times-circle-o\" aria-hidden=\"true\"></i></span>";
                html += "<span class='button-edit btn btn-default btn-xs pull-right editItem' data-owner-id='" + item['data-id'] + "'><i class=\"fa fa-pencil\" aria-hidden=\"true\"></i></span>";
                html += children;
                html += "</li>";
                return html;
            }
        };
    }

    function getMaxJsonDepth(obj) {
        $.each(JSON.parse(obj), function (index, item) {
            maxJsonId = check(parseInt(item.id));
            if (item.children) {
                $.each(item.children, function (index, sub) {
                    maxJsonId = check(parseInt(sub.id));
                });
            }

            function check(x) {
                if (x > maxJsonId) {
                    maxJsonId = x;
                }
                return maxJsonId;
            }
        });
        return maxJsonId;
    }

    function manipulateJsonOnRemoval(jsonObj, removeId) {
        console.log("To Remove: " + removeId);
        var manipulatedJson = JSON.parse(jsonObj);
        /*$.each(manipulatedJson, function (index, item) {
            var recentId = parseInt(item.id);
            if (recentId > removeId) {
                console.log("Before Removing: " + recentId);
                item.id = recentId - 1;
                console.log("id: " + item.id);
            }
            console.log("id: " + item.id);
            if (item.children) {
                $.each(item.children, function (index, sub) {
                    recentId = parseInt(sub.id);
                    if (recentId > removeId) {
                        console.log("Before Removing: " + recentId);
                        sub.id = recentId - 1;
                        console.log("sub id: " + sub.id);
                    }

                });
            }
            //console.log("Before Removing: " + recentId);
            //console.log("id: " + item.id);
        });*/
        var i = 0;
        $.each(manipulatedJson, drillThroughJson);

        function drillThroughJson(key, value) {

            //value.id = key;
            if (value.id !== undefined) {
                i++;
                //console.log("index: " + i +" value: " + value.id);
                value.id = i;
            }
            if (value !== null && typeof value === "object") {
                $.each(value, drillThroughJson);
            }
        }

        console.log("new Json" + JSON.stringify(manipulatedJson));
        return JSON.stringify(manipulatedJson);
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
                'captionList': captionList,
                'captionListWithDepth': captionListWithDepth
            },
            success: function (data) {
                console.log(data);
                window.location.reload();
            },
            error: function (XMLHttpRequest, statusText, errorThrown) {
                alert(statusText);
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
