<div class="modal-body clearfix">
    <p class="pb10"><?php echo lang("estimate_request_form_selection_title"); ?></p>
    <ul class="list-group mb0">
        <?php
            foreach ($estimate_forms as $form) {
            echo "<li class='list-group-item'>" . anchor(get_uri("estimate_requests/submit_estimate_request_form/" . $form->id), $form->title) . "</li>";
        }
        ?>
    </ul>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal"><span class="fa fa-close"></span> <?php echo lang('close'); ?></button>
</div>


