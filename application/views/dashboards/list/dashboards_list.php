<div class="list-group" id="js-dashboard-popup-list">
    <?php
    //default dashboard
    echo anchor(get_uri("dashboard"), "<i class='fa fa-desktop mr10'></i> " . lang("default_dashboard"), array("class" => "list-group-item"));

    if (count($dashboards)) {
        echo "<div class='js-dashboard-list'>";

        foreach ($dashboards as $dashboard) {

            $icon = "fa-desktop";
            $title = "<i style='color: " . $dashboard->color . "' class='fa $icon mr10'></i> " . $dashboard->title;

            echo anchor(get_uri("dashboard/view/" . $dashboard->id), $title, array("class" => "list-group-item js-dashboard-list", "data-value" => $dashboard->id, "data-id" => $dashboard->id, "data-sort" => $dashboard->new_sort));
        }

        echo "</div>";
    }

    echo modal_anchor(get_uri("dashboard/modal_form"), "<i class='fa fa-plus-circle'></i> " . lang('add_new_dashboard'), array("class" => "list-group-item text-center", "title" => lang('add_new_dashboard')));
    ?>
</div>

<script type="text/javascript">
    $(document).ready(function () {

<?php if (count($dashboards)) { ?>
            //init sortable to dashboard list
            var options = {
                animation: 150,
                chosenClass: "sortable-chosen",
                ghostClass: "sortable-ghost",
                onUpdate: function (e) {
                    //moved to the same column. save the dashboard position
                    saveDashboardPosition($(e.item));
                }
            };

            //make the widget rows sortable
            options.group = "js-dashboard-list";
            Sortable.create($(".js-dashboard-list")[0], options);

            //save dashboard position
            function saveDashboardPosition($item) {
                appLoader.show();

                var $prev = $item.prev(),
                        $next = $item.next(),
                        prevSort = 0, nextSort = 0, newSort = 0,
                        step = 100000, stepDiff = 500,
                        id = $item.attr("data-id");

                if ($prev && $prev.attr("data-sort")) {
                    prevSort = $prev.attr("data-sort") * 1;
                }

                if ($next && $next.attr("data-sort")) {
                    nextSort = $next.attr("data-sort") * 1;
                }


                if (!prevSort && nextSort) {
                    //item moved at the top
                    newSort = nextSort + stepDiff;

                } else if (!nextSort && prevSort) {
                    //item moved at the bottom
                    newSort = prevSort - step;

                } else if (prevSort && nextSort) {
                    //item moved inside two items
                    newSort = (prevSort + nextSort) / 2;

                } else if (!prevSort && !nextSort) {
                    //It's the first item of this column
                    newSort = step * 100; //set a big value for 1st item
                }

                $item.attr("data-sort", newSort);

                $.ajax({
                    url: '<?php echo_uri("dashboard/save_dashboard_sort") ?>',
                    type: "POST",
                    data: {id: id, sort: newSort},
                    success: function () {
                        appLoader.hide();
                    }
                });
            }

<?php } ?>

        //don't apply scrollbar for mobile devices
        if ($(window).width() > 640) {
            if ($('#js-dashboard-popup-list').height() >= 400) {
                initScrollbar('#js-dashboard-popup-list', {
                    setHeight: 400
                });
            } else {
                $('#js-dashboard-popup-list').css({"overflow-y": "auto"});
            }
        }

    });
</script>