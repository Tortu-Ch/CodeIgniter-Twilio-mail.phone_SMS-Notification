<div class="modal-body clearfix general-form ">
    <div class="p10 clearfix">
        <div class="media m0 bg-white">
            <div class="media-left">
                <span class="avatar avatar-sm">
                    <img src="<?php echo get_avatar($model_info->assigned_to_avatar); ?>" alt="..." />
                </span>
            </div>
            <div class="media-body w100p pt5">
                <div class="media-heading m0">
                    <?php echo $model_info->assigned_to_user; ?>
                </div>
                <p> 
                    <span class='label label-light mr5' title='Point'><?php echo $model_info->points; ?></span>

                    <?php echo $labels . " " . "<span class='label' style='background:$model_info->status_color; '>" . ($model_info->status_key_name ? lang($model_info->status_key_name) : $model_info->status_title) . "</span>"; ?>
                </p>
            </div>
        </div>
    </div>

    <div class="form-group clearfix">
        <div  class="col-md-12 mb15">
            <strong><?php echo $model_info->title; ?></strong>
        </div>

        <div class="col-md-12 mb15">
            <?php echo $model_info->description ? nl2br(link_it($model_info->description)) : "-"; ?>
        </div>

        <?php if ($model_info->milestone_title) { ?>
            <div class="col-md-12 mb15">
                <strong><?php echo lang('milestone') . ": "; ?></strong> <?php echo $model_info->milestone_title; ?>
            </div>
        <?php } ?>

        <?php if (is_date_exists($model_info->start_date)) { ?>
            <div class="col-md-12 mb15">
                <strong><?php echo lang('start_date') . ": "; ?></strong> <?php echo format_to_date($model_info->start_date, false); ?>
            </div>
        <?php } ?>
        <div class="col-md-12 mb15">
            <strong><?php echo lang('deadline') . ": "; ?></strong> <?php echo format_to_date($model_info->deadline, false); ?>
        </div>
        <?php if ($collaborators) { ?>
            <div class="col-md-12 mb15">
                <strong><?php echo lang('collaborators') . ": "; ?> </strong> <?php echo $collaborators; ?>
            </div>
        <?php } ?>

        <?php
        if (count($custom_fields_list)) {
            foreach ($custom_fields_list as $data) {
                if ($data->value) {
                    ?>
                    <div class="col-md-12 mb15">
                        <strong><?php echo $data->title . ": "; ?> </strong> <?php echo $this->load->view("custom_fields/output_" . $data->field_type, array("value" => $data->value), true); ?>
                    </div>
                    <?php
                }
            }
        }
        ?>

        <div class="col-md-12 mb15">
            <strong><?php echo lang('project') . ": "; ?> </strong> <?php echo anchor(get_uri("projects/view/" . $model_info->project_id), $model_info->project_title); ?>
        </div>


        <!--checklist-->
        <?php echo form_open(get_uri("projects/save_checklist_item"), array("id" => "checklist_form", "class" => "general-form", "role" => "form")); ?>
        <div class="col-md-12 mb15 b-t">
            <div class="pb10 pt10">
                <strong><?php echo lang("checklist"); ?></strong>
            </div>
            <input type="hidden" name="task_id" value="<?php echo $task_id; ?>" />
            <div class="checklist-items">

            </div>
            <?php if ($can_edit_tasks) { ?>
                <div class="form-group">
                    <div class="mt5 col-md-12 p0">
                        <?php
                        echo form_input(array(
                            "id" => "checklist-add-item",
                            "name" => "checklist-add-item",
                            "class" => "form-control",
                            "placeholder" => lang('add_item'),
                            "data-rule-required" => true,
                            "data-msg-required" => lang("field_required")
                        ));
                        ?>
                    </div>
                </div>
                <div id="checklist-options-panel" class="col-md-12 mb15 p0 hide">
                    <button type="submit" class="btn btn-primary"><span class="fa fa-check-circle"></span> <?php echo lang('add'); ?></button> 
                    <button id="checklist-options-panel-close" type="button" class="btn btn-default"><span class="fa fa-close"></span> <?php echo lang('cancel'); ?></button>
                </div>
            <?php } ?>
        </div>
        <?php echo form_close(); ?>



    </div>

    <div class="row clearfix">
        <div class="col-md-12 b-t pt10 list-container">
            <?php if ($can_comment_on_tasks) { ?>
                <?php $this->load->view("projects/comments/comment_form"); ?>
            <?php } ?>
            <?php $this->load->view("projects/comments/comment_list"); ?>
        </div>
    </div>

    <?php if ($this->login_user->user_type === "staff") { ?>
        <div class="box-title"><span ><?php echo lang("activity"); ?></span></div>
        <div class="pl15 pr15 mt15 list-container">
            <?php activity_logs_widget(array("limit" => 20, "offset" => 0, "log_type" => "task", "log_type_id" => $model_info->id)); ?>
        </div>
    <?php } ?>
</div>

<div class="modal-footer">
    <?php
    if ($can_edit_tasks) {
        echo modal_anchor(get_uri("projects/task_modal_form/"), "<i class='fa fa-pencil'></i> " . lang('edit_task'), array("class" => "btn btn-default", "data-post-id" => $model_info->id, "title" => lang('edit_task')));
    }
    ?>
    <button type="button" class="btn btn-default" data-dismiss="modal"><span class="fa fa-close"></span> <?php echo lang('close'); ?></button>
</div>

<?php
$task_link = anchor(get_uri("projects/view/$model_info->project_id/tasks?task=" . $model_info->id), '<i class="fa fa-external-link"></i>', array("target" => "_blank", "class" => "p15"));
?>

<script type="text/javascript">
    $(document).ready(function () {

        //make the checklist items sortable
        var $selector = $(".checklist-items");
        Sortable.create($selector[0], {
            animation: 150,
            chosenClass: "sortable-chosen",
            ghostClass: "sortable-ghost",
            onUpdate: function (e) {
                appLoader.show();
                //prepare checklist items indexes 
                var data = "";
                $.each($selector.find(".checklist-item-row"), function (index, ele) {
                    if (data) {
                        data += ",";
                    }

                    data += $(ele).attr("data-id") + "-" + parseInt(index + 1);
                });
                
                //update sort indexes
                $.ajax({
                    url: '<?php echo_uri("projects/save_checklist_items_sort") ?>',
                    type: "POST",
                    data: {sort_values: data},
                    success: function () {
                        appLoader.hide();
                    }
                });
            }
        });

        //add a clickable link in task title.
        $("#ajaxModalTitle").append('<?php echo $task_link ?>');

        //show the items in checklist
        $(".checklist-items").html(<?php echo $checklist_items; ?>);

        //show save & cancel button when the checklist-add-item-form is focused
        $("#checklist-add-item").focus(function () {
            $("#checklist-options-panel").removeClass("hide");
            $("#checklist-add-item-error").removeClass("hide");
        });

        $("#checklist-options-panel-close").click(function () {
            $("#checklist-options-panel").addClass("hide");
            $("#checklist-add-item-error").addClass("hide");
            $("#checklist-add-item").val("");
        });

        $("#checklist_form").appForm({
            isModal: false,
            onSuccess: function (response) {
                $("#checklist-add-item").val("");
                $("#checklist-add-item").focus();
                $(".checklist-items").append(response.data);
            }
        });

        $('body').on('click', '[data-act=update-checklist-item-status-checkbox]', function () {
            var status_checkbox = $(this).find("span");
            status_checkbox.addClass("inline-loader");
            $.ajax({
                url: '<?php echo_uri("projects/save_checklist_item_status") ?>/' + $(this).attr('data-id'),
                type: 'POST',
                dataType: 'json',
                data: {value: $(this).attr('data-value')},
                success: function (response) {
                    if (response.success) {
                        status_checkbox.closest("div").html(response.data);
                    }
                }
            });
        });
    });
</script>