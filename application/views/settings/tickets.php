
<?php echo form_open(get_uri("settings/save_ticket_settings"), array("id" => "ticket-settings-form", "class" => "general-form dashed-row", "role" => "form")); ?>
<div class="panel">

    <div class="panel-body mt20">
        <div class="form-group">
            <label for="show_recent_ticket_comments_at_the_top" class="col-md-4"><?php echo lang('show_most_recent_ticket_comments_at_the_top'); ?></label>
            <div class="col-md-8">
                <?php
                echo form_checkbox("show_recent_ticket_comments_at_the_top", "1", get_setting("show_recent_ticket_comments_at_the_top") ? true : false, "id='show_recent_ticket_comments_at_the_top' class='ml15'");
                ?>                       
            </div>
        </div>
        <div class="form-group">
            <label for="project_reference_in_tickets" class="col-md-4"><?php echo lang('project_reference_in_tickets'); ?></label>
            <div class="col-md-8">
                <?php
                echo form_checkbox("project_reference_in_tickets", "1", get_setting("project_reference_in_tickets") ? true : false, "id='project_reference_in_tickets' class='ml15'");
                ?>                       
            </div>
        </div>
         <div class="form-group">
                    <label for="ticket_prefix" class=" col-md-4"><?php echo lang('ticket_prefix'); ?></label>
                    <div class=" col-md-8">
                        <?php
                        echo form_input(array(
                            "id" => "ticket_prefix",
                            "name" => "ticket_prefix",
                            "value" => get_setting("ticket_prefix"),
                            "class" => "form-control",
                            "placeholder" =>  lang('ticket_prefix')
                        ));
                        ?>
                    </div>
                </div>
    </div>

    <div class="panel-footer">
        <button type="submit" class="btn btn-primary"><span class="fa fa-check-circle"></span> <?php echo lang('save'); ?></button>
    </div>

</div>
<?php echo form_close(); ?>

<script type="text/javascript">
    $(document).ready(function () {
        $("#ticket-settings-form").appForm({
            isModal: false,
            onSuccess: function (result) {
                appAlert.success(result.message, {duration: 10000});
            }
        });

    });
</script>