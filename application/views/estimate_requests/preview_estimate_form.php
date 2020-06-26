<div id="page-content" class="p20 clearfix">
    <div class='text-center mb15'> <?php echo anchor(get_uri("estimate_requests/edit_estimate_form/" . $model_info->id), lang('close_preview'), array("class" => "btn btn-default round", "title" => lang('close_preview'))); ?> </div>
    <?php
    $this->load->view("estimate_requests/estimate_request_form");
    ?>
</div>
