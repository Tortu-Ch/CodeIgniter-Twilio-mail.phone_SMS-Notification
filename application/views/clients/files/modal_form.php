<?php echo form_open(get_uri("clients/save_file"), array("id" => "file-form", "class" => "general-form", "role" => "form")); ?>
<div class="modal-body clearfix">
    <input type="hidden" name="client_id" value="<?php echo $client_id; ?>" />
    <?php
    $this->load->view("includes/multi_file_uploader", array(
        "upload_url" =>get_uri("clients/upload_file"),
        "validation_url" =>get_uri("clients/validate_file"),
    ));
    ?>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-default cancel-upload" data-dismiss="modal"><span class="fa fa-close"></span> <?php echo lang('close'); ?></button>
    <button type="submit" disabled="disabled" class="btn btn-primary start-upload"><span class="fa fa-check-circle"></span> <?php echo lang('save'); ?></button>
</div>
<?php echo form_close(); ?>

<script type="text/javascript">
    $(document).ready(function () {
        $("#file-form").appForm({
            onSuccess: function (result) {
                $("#client-file-table").appTable({reload: true});
            }
        });

    });

</script>    
