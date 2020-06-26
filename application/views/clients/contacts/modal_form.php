<?php echo form_open(get_uri("clients/save_contact"), array("id" => "contact-form", "class" => "general-form", "role" => "form", "autocomplete" => "false")); ?>
<div class="modal-body clearfix">
    <?php $this->load->view("clients/contacts/contact_general_info_fields"); ?>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal"><span class="fa fa-close"></span> <?php echo lang('close'); ?></button>
    <button type="submit" class="btn btn-primary"><span class="fa fa-check-circle"></span> <?php echo lang('save'); ?></button>
</div>
<?php echo form_close(); ?>

<script type="text/javascript">
    $(document).ready(function() {
        $("#contact-form").appForm({
            onSuccess: function(result) {
                $("#contact-table").appTable({newData: result.data, dataId: result.id});
            }
        });
        $("#first_name").focus();
    });
</script>    