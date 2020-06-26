<div id="widget-column-container">
    <?php
    if ($widget_sortable_rows) {
        echo $widget_sortable_rows;
    }
    ?>
</div>

<div id="add-column-button" class="dropdown-toggle w100p p10 bg-white text-center clickable" data-toggle="collapse" data-target="#add-column-collapse-panel"><i class="fa fa-plus-circle"></i> <?php echo lang("add_row"); ?></div>
<div class="collapse font-100p" id="add-column-collapse-panel">
    <div class="panel mb0">
        <div class="list-group text-center">

            <?php
            $columns_array = array(
                "12" => "1",
                "6-6" => "1/2-1/2",
                "4-4-4" => "1/3-1/3-1/3",
                "3-6-3" => "1/4-2/4-1/4",
                "3-3-3-3" => "1/4-1/4-1/4-1/4",
                "4-8" => "1/3-2/3",
                "3-9" => "1/4-3/4",
                "9-3" => "3/4-1/4",
                "8-4" => "2/3-1/3"
            );

            foreach ($columns_array as $key => $value) {

                $content = "<div class='clearfix'>";
                $columns = explode("-", $key);
                $column_captions = explode("-", $value);

                foreach ($columns as $column_key => $column) {
                    $content .= "<div class='col-xs-$column'><div class='grid-bg'>" . get_array_value($column_captions, $column_key) . "</div></div>";
                }

                $content .= "</div>";

                echo js_anchor($content, array("class" => "p10 text-center list-group-item column-grid-link", "data-column-value" => $key));
            }
            ?>

        </div>
    </div>
</div>

<?php $this->load->view("dashboards/helper_js"); ?>

<script>
    $(document).ready(function () {

        $("#add-column-collapse-panel .list-group-item").click(function () {
            //show widgets after adding the first row
            if ($("#add-column-collapse-panel").hasClass("first-row-of-widget")) {
                $("#widget-container-area").removeClass("hide");
                $("#widget-row-container").addClass("ml298");
                $("#add-column-collapse-panel").removeClass("first-row-of-widget");

                adjustHeightOfWidgetContainer();
            }

            var columnValue = $(this).attr("data-column-value");

            addNewColumn(columnValue);
        });

        //delete widget row
        $('body #widget-column-container').on('click', '.delete-widget-row', function () {
            //restore the selected widgets to widgets container
            var widgetColumn = $(this).closest(".widget-row").find(".widget-column");

            widgetColumn.each(function (index) {
                var widgets = $(this).find(".widget").attr("data-value");

                if (widgets) {
                    $(this).find(".widget").each(function (index) {
                        var widget = $(this).attr("data-value"),
                                widgetRow = $(this).html(),
                                errorClass = "";

                        if ($(this).hasClass("error")) {
                            errorClass = "error";
                        }

                        $(".js-widget-container").append("<div data-value=" + widget + " class='mb5 widget clearfix p10 bg-white " + errorClass + "'>" + widgetRow + "</div>");
                    });
                }
            });

            //remove drag/drop text from widget container
            removeEmptyAreaText($(".js-widget-container"));

            //remove the row finally
            $(this).closest(".widget-row").fadeOut(300, function () {
                $(this).closest(".widget-row").remove();

                saveWidgetPosition();
            });

            adjustHeightOfWidgetContainer();
        });
    });
</script>