<?php echo form_open(get_uri("team/save"), array("id" => "team-form", "class" => "general-form", "role" => "form")); ?>
<div class="modal-body clearfix">
    <input type="hidden" name="id" value="<?php echo $model_info->id; ?>" />
    <div class="form-group">
        <label for="title" class=" col-md-3"><?php echo lang('title'); ?></label>
        <div class=" col-md-9">
            <?php
            echo form_input(array(
                "id" => "title",
                "name" => "title",
                "value" => $model_info->title,
                "class" => "form-control",
                "placeholder" => lang('title'),
                "autofocus" => true,
                "data-rule-required" => true,
                "data-msg-required" => lang("field_required"),
            ));
            ?>
        </div>
    </div>
    <div class="form-group">
        <label for="members" class=" col-md-3"><?php echo lang('team_members'); ?></label>
        <div class="col-md-9">
              <input type="text" value="<?php echo $model_info->members; ?>" name="members" id="team_members_dropdown" class="w100p validate-hidden"  data-rule-required="true" data-msg-required="<?php echo lang('field_required'); ?>" placeholder="<?php echo lang('team_members'); ?>"  />    
        </div>
    </div>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal"><span class="fa fa-close"></span> <?php echo lang('close'); ?></button>
    <button type="submit" class="btn btn-primary"><span class="fa fa-check-circle"></span> <?php echo lang('save'); ?></button>
</div>
<?php echo form_close(); ?>

<script type="text/javascript">
    $(document).ready(function() {
        $("#team-form").appForm({
            onSuccess: function(result) {
                $("#team-table").appTable({newData: result.data, dataId: result.id});
            }
        });
    $("#team_members_dropdown").select2({
            multiple: true,
            data: <?php echo ($members_dropdown); ?>
        });
        
        $("#team-form .select2").select2();
        $("#title").focus();
    });
</script>    