<?php echo form_open(get_uri("projects/save_project_member"), array("id" => "project-member-form", "class" => "general-form", "role" => "form")); ?>
<div class="modal-body clearfix">
    <input type="hidden" name="id" value="<?php echo $model_info->id; ?>" />
    <input type="hidden" name="project_id" value="<?php echo $project_id; ?>" />

    <div class="form-group" style="min-height: 50px">
        <label for="user_id" class=" col-md-3"><?php echo lang('member'); ?></label>
        <div class="col-md-9">
            <div class="select-member-field">
                <div class="select-member-form clearfix pb10">
                    <?php echo form_dropdown("user_id[]", $users_dropdown, array($model_info->user_id), "class='user_select2 col-md-10 p0'"); ?>
                    <?php echo js_anchor("<i class='fa fa-times'></i> ", array("class" => "remove-member delete ml20")); ?>
                </div>                                
            </div>
            <?php echo js_anchor("<i class='fa fa-plus-circle'></i> " . lang('add_more'), array("class" => "add-member", "id" => "add-more-user")); ?>
        </div>
    </div>

</div>

<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal"><span class="fa fa-close"></span> <?php echo lang('close'); ?></button>
    <button type="submit" class="btn btn-primary"><span class="fa fa-check-circle"></span> <?php echo lang('save'); ?></button>
</div>
<?php echo form_close(); ?>

<script type="text/javascript">
    $(document).ready(function () {
        $("#project-member-form").appForm({
            onSuccess: function (result) {
                if (result.id !== "exists") {
                    for (i = 0; i < result.data.length; i++) {
                        $("#project-member-table").appTable({newData: result.data[i], dataId: result.id[i]});
                    }
                }
            }
        });

        var $wrapper = $('.select-member-field'),
                $field = $('.select-member-form:first-child', $wrapper).clone(); //keep a clone for future use.

        $(".add-member", $(this)).click(function (e) {
            var $newField = $field.clone();

            //remove used options
            $('.user_select2').each(function () {
                $newField.find("option[value='" + $(this).val() + "']").remove();
            });

            var $newObj = $newField.appendTo($wrapper);
            $newObj.find(".user_select2").select2();

            $newObj.find('.remove-member').click(function () {
                $(this).parent('.select-member-form').remove();
                showHideAddMore($field);
            });

            showHideAddMore($field);
        });

        showHideAddMore($field);

        $(".remove-member").hide();
        $(".user_select2").select2();

        function showHideAddMore($field) {
            //hide add more button if there are no options 
            if ($('.select-member-form').length < $field.find("option").length) {
                $("#add-more-user").show();
            } else {
                $("#add-more-user").hide();
            }
        }

    });
</script>    