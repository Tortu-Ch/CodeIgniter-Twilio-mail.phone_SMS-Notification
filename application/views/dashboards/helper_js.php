<script>

    //adjust height of widgets container
    function adjustHeightOfWidgetContainer() {
        if ($('.js-widget-container').height() > $(window).height() - 175) {
            $('.js-widget-container').height($(window).height() - 170).addClass("overflow-y-scroll");
        }
    }

    //prepare the columns according to column size
    function addNewColumn(columnValue) {
        var newColumnDiv = "",
                columns = columnValue.split("-");

        for (var i = 0; i < columns.length; i++) {
            newColumnDiv = newColumnDiv + "<div class='pr0 widget-column col-md-" + columns[i] + " col-sm-" + columns[i] + "'><div id='add-column-panel-" + getRandomAlphabet(5) + "' class='add-column-panel add-column-drop text-center p15'><span class='text-off empty-area-text'><?php echo lang('drag_and_drop_widgets_here'); ?></span></div></div>";
        }

        $("#widget-column-container").append("<row class='widget-row clearfix block bg-white' data-column-ratio='" + columnValue + "'><div class='pull-left row-controller text-off font-16'><i class='fa fa-bars move'></i><i class='fa fa-times delete delete-widget-row'></i></div><div class='pull-left clearfix row-container'>" + newColumnDiv + "</div></row>");

        //new row added. hide the collapse panel
        $("#add-column-button").trigger("click");

        setTimeout(function () {
            initSortable();
        }, 500);

    }

    //initialize sortable
    function initSortable() {

        var options = {
            animation: 150,
            chosenClass: "sortable-chosen",
            ghostClass: "sortable-ghost",
            filter: ".empty-area-text",
            cancel: ".empty-area-text",
            onAdd: function (e) {
                //moved to the new column/row. save the widget position
                saveWidgetPosition();

                removeEmptyAreaText(e.to);
                addEmptyAreaText(e.to);
                addEmptyAreaText(e.from);
            },
            onUpdate: function (e) {
                //moved to the same column/row. save the widget position
                saveWidgetPosition();

                removeEmptyAreaText(e.to);
                addEmptyAreaText(e.to);
                addEmptyAreaText(e.from);
            }
        };

        //make elements sortable
        $(".add-column-panel").each(function (index) {

            var id = this.id;
            options.group = "add-column-panel";
            Sortable.create($("#" + id)[0], options);
        });

        //make the widget rows sortable
        options.group = "widget-column-container";
        Sortable.create($("#widget-column-container")[0], options);
    }

    //remove drag/drop text from new added area if there is no elements available
    function removeEmptyAreaText(index) {
        if ($(index).has("div").length > 0 && $(index).attr("id") !== "widget-column-container") {
            $(index).find("span.empty-area-text").remove();
        }
    }

    //add drag/drop text from removed area if there is no elements available
    function addEmptyAreaText(index) {
        if ($(index).has("div").length < 1) {
            if ($(index).hasClass("js-widget-container")) {
                //if it's widgets container area
                $(index).html("<span class='text-off empty-area-text'><?php echo lang('no_more_widgets_available'); ?></span>");
            } else {
                //if it's widgets row area
                $(index).html("<span class='text-off empty-area-text'><?php echo lang('drag_and_drop_widgets_here'); ?></span>");
            }
        }
    }

    //save the widget's position
    function saveWidgetPosition() {
        var rows = [];

        $(".widget-row").each(function (index) {
            var columns = [],
                    $widgetColumn = $(this).find(".widget-column"),
                    columnRatio = $(this).attr("data-column-ratio");

            if ($widgetColumn) {
                $widgetColumn.each(function (index) {
                    var widget = $(this).find(".widget").attr("data-value");

                    if (widget) {
                        var widgets = [];
                        $(this).find(".widget").each(function (index) {
                            var widgetValue = $(this).attr("data-value");

                            if (widgetValue) {
                                widgets.push({widget: widgetValue, title: $(this).find(".pull-left").text()});
                            }
                        });

                        columns.push(widgets);
                    }
                });
            }

            if (columns.length) {
                rows.push({columns: columns, ratio: columnRatio});
            }
        });

        //convert array to json data and save into an input field
        $("#widgets-data").val(JSON.stringify(rows));
    }
</script>