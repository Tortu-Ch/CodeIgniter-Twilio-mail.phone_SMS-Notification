<div id="page-content" class="p20 clearfix">
    <div class="row">
        <div class="col-sm-3 col-lg-2">
            <?php
            $tab_view['active_tab'] = "tasks";
            $this->load->view("settings/tabs", $tab_view);
            ?>
        </div>

        <div class="col-sm-9 col-lg-10">
            <div class="panel panel-default">
                <div class="page-title clearfix no-border">
                    <h4> <?php echo lang('task_status'); ?></h4>
                    <div class="title-button-group">
                        <?php echo modal_anchor(get_uri("task_status/modal_form"), "<i class='fa fa-plus-circle'></i> " . lang('add_task_status'), array("class" => "btn btn-default", "title" => lang('add_task_status'))); ?>
                    </div>
                </div>
                <div class="table-responsive ">
                    <table id="task-status-table" class="display no-thead b-t b-b-only no-hover" cellspacing="0" width="100%">         
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    $(document).ready(function () {
        $("#task-status-table").appTable({
            source: '<?php echo_uri("task_status/list_data") ?>',
            order: [[0, "asc"]],
            hideTools: true,
            displayLength: 100,
            columns: [
                {visible: false},
                {title: '<?php echo lang("title"); ?>'},
                {title: '<i class="fa fa-bars"></i>', "class": "text-center option w100"}
            ],
            onInitComplete: function () {
                //apply sortable
                $("#task-status-table").find("tbody").attr("id", "custom-field-table-sortable");
                var $selector = $("#custom-field-table-sortable");

                Sortable.create($selector[0], {
                    animation: 150,
                    chosenClass: "sortable-chosen",
                    ghostClass: "sortable-ghost",
                    onUpdate: function (e) {
                        appLoader.show();
                        //prepare sort indexes 
                        var data = "";
                        $.each($selector.find(".field-row"), function (index, ele) {
                            if (data) {
                                data += ",";
                            }

                            data += $(ele).attr("data-id") + "-" + index;
                        });

                        //update sort indexes
                        $.ajax({
                            url: '<?php echo_uri("task_status/update_field_sort_values") ?>',
                            type: "POST",
                            data: {sort_values: data},
                            success: function () {
                                appLoader.hide();
                            }
                        });
                    }
                });

            }

        });
    });
</script>