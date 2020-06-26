<div id="page-content" class="p20 clearfix">
    <div id="estimate-form-container">
        <?php
        echo form_open(get_uri("estimate_requests/save_estimate_request"), array("id" => "estimate-request-form", "class" => "general-form", "role" => "form"));
        echo "<input type='hidden' name='form_id' value='$model_info->id' />";
        $this->load->view("estimate_requests/estimate_request_form");
        echo form_close();
        ?>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $("#estimate-request-form").appForm({
            isModal: false,
            onSubmit: function () {
                appLoader.show();
                $("#estimate-request-form").find('[type="submit"]').attr('disabled', 'disabled');
            },
            onSuccess: function (result) {
                appLoader.hide();
                window.location = "<?php echo get_uri('estimate_requests/view_estimate_request') ?>/" + result.estimate_id;
            }
        });

    });
</script>