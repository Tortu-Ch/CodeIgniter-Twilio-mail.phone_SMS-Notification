<div class="tab-content">
    <?php echo form_open(get_uri("clients/save_contact/"), array("id" => "contact-form", "class" => "general-form dashed-row white", "role" => "form")); ?>
    <div class="panel">
        <div class="panel-default panel-heading">
            <h4> <?php echo lang('general_info'); ?></h4>
        </div>
        <div class="panel-body">
            <?php $this->load->view("clients/contacts/contact_general_info_fields"); ?>
        </div>
        <div class="panel-footer">
            <button type="submit" class="btn btn-primary"><span class="fa fa-check-circle"></span> <?php echo lang('save'); ?></button>
        </div>
    </div>
    <?php echo form_close(); ?>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $("#contact-form").appForm({
            isModal: false,
            onSuccess: function(result) {
                appAlert.success(result.message, {duration: 10000});
            }
        });
    });
</script>