var designReport;
designReport = function () {
    var deptId = null;
    var clientId = null;
    var branchId = null;
    var reportId = null;
    var reportURL = null;
    var reportName = null;
    var captionList = null;
    var maxJsonDepth = 0;
    var initialize = function () {
        generateReportsDropDown();
        eventListeners();
        //dragNestable();
        customNestable();
    };

    var eventListeners = function () {
        $('#saveDesign').click(function () {
            var x = $('.dd').nestable('serialize');
            captionList = JSON.stringify(x);
            alert(captionList);
        });
    };

    var customNestable = function () {
        nestablejson();
        //nestableLast();
        //savedList();
    };

    var nestablejson = function () {
        var json = '[{"id":1,"name":"aa"},{"id":2,"name":"aa"},{"id":3,"name":"aa","children":[{"id":4,"name":"aa"},{"id":5,"name":"aa"}]}]';
        //json = '[{}]';
        var options = {
            'json': json,
            itemRenderer: function (item, content, children, options) {
                console.log(item);
                var html = "<li class='dd-item' data-id='" + item['data-id'] + "'>";
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
            var newId = getMaxJsonDepth(json) + 1;
            console.log(newId);
            $('#nestable-json').nestable('add', {"id": newId, "name": itemText});
            maxJsonDepth = newId;
        });

        $(document).on('click','.deleteItem', function () {
            var selectedId = $(this).data('owner-id');
            console.log(selectedId);
            $('#nestable-json').nestable('remove', selectedId);
        });

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

    var savedList = function () {
        var obj = '[{"deleted":0,"new":1,"slug":"a","name":"as","id":"new-1"},{"deleted":0,"new":1,"slug":"sd","name":"asd","id":"new-2","children":[{"deleted":0,"new":1,"slug":"sd","name":"asd","id":"new-3"}]}]';
        var output = '';

        function buildItem(item) {
            console.log(item.id);

            var html = "<li class='dd-item' data-id='" + item.id + "'>";
            html += "<div class='dd-handle'>" + item.name + "</div>";
            html += "<span class=\"button-delete btn btn-default btn-xs pull-right\" data-owner-id='" + item.id + "'><i class=\"fa fa-times-circle-o\" aria-hidden=\"true\"></i></span>";
            html += "<span class=\"button-edit btn btn-default btn-xs pull-right\" data-owner-id='" + item.id + "'><i class=\"fa fa-pencil\" aria-hidden=\"true\"></i></span>";

            if (item.children) {

                html += "<ol class='dd-list'>";
                $.each(item.children, function (index, sub) {
                    html += buildItem(sub);
                });
                html += "</ol>";

            }

            html += "</li>";

            return html;
        }

        $.each(JSON.parse(obj), function (index, item) {
            output += buildItem(item);
        });
        $('#nestable').html(output);
    };

    var nestableLast = function () {
        var obj = '[{"id":1,"name":"aa"},{"id":2,"name":"aa"},{"id":3,"name":"aa","children":[{"id":4,"name":"aa"},{"id":5,"name":"aa"}]}]';
        var output = '';

        function buildItem(item) {
            var html = "<li class='dd-item' data-id='" + item.id + "'>";
            html += "<div class='dd-handle'>" + item.name + "</div>";
            html += "<span class='button-delete btn btn-default btn-xs pull-right deleteItem' data-owner-id='" + item.id + "'><i class=\"fa fa-times-circle-o\" aria-hidden=\"true\"></i></span>";
            html += "<span class='button-edit btn btn-default btn-xs pull-right editItem' data-owner-id='" + item.id + "'><i class=\"fa fa-pencil\" aria-hidden=\"true\"></i></span>";

            if (item.children) {
                html += "<ol class='dd-list'>";
                $.each(item.children, function (index, sub) {
                    html += buildItem(sub);
                });
                html += "</ol>";
            }

            html += "</li>";
            return html;
        }

        $.each(JSON.parse(obj), function (index, item) {
            output += buildItem(item);
        });

        $('#dd-empty-placeholder').html(output);
        $('#nestable3').nestable();

        $('.dd-item').on('click', '.deleteItem', function (ev) {
            $('#nestable3').nestable('remove', $(this).data('owner-id'));
        });


        $('#addButton').click(function () {
            var itemText = $('#addInputName').val();
            $('#nestable3').nestable('add', {id: 0, "name": itemText});

        });


    };

    var dragNestable = function () {
        var updateOutput = function (e) {
            var list = e.length ? e : $(e.target),
                output = list.data('output');
            if (window.JSON) {
                output.val(window.JSON.stringify(list.nestable('serialize')));
            } else {
                output.val('JSON browser support required for this demo.');
            }
        };

        $('#nestable').nestable({
            group: 1
        }).on('change', updateOutput);

        updateOutput($('#nestable').data('output', $('#nestable-output')));

        /*$('#nestable-menu').on('click', function (e) {
            var target = $(e.target),
                action = target.data('action');
            if (action === 'expand-all') {
                $('.dd').nestable('expandAll');
            }
            if (action === 'collapse-all') {
                $('.dd').nestable('collapseAll');
            }
        });*/
    };

    var generateReportsDropDown = function () {
        $.ajax({
            url: 'http://192.168.100.116:8080/biportaldemo/generateReportList.php',
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
            url: "http://192.168.100.116:8080/BIPortalDemo/saveDesignedReport.php",
            type: "POST",
            data: {
                'deptId': deptId,
                'clientId': clientId,
                'branchId': branchId,
                'reportId': reportId,
                'captionList': captionList
            },
            success: function (data) {
                window.location.reload();
            }
        });
    };

    return {
        initialize: initialize
    };
}();
