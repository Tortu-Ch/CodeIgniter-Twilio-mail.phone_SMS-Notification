<?php echo form_open(get_uri("timeline/save"), array("class" => "reply-form general-form", "role" => "form")); ?>
<div class="mb15 pr15 box">
    <div class="box-content avatar avatar-sm pr15">
        <img src="<?php echo get_avatar($this->login_user->image); ?>" alt="..." />
    </div>
    <div class="box-content form-group">
        <input type="hidden" name="post_id" value="<?php echo isset($post_id) ? $post_id : 0; ?>">
        <?php
        echo form_textarea(array(
            "name" => "description",
            "class" => "form-control",
            "placeholder" => lang('write_a_reply'),
            "data-rule-required" => true,
            "data-msg-required" => lang("field_required"),
        ));
        ?>
        <footer class="panel-footer b-a clearfix">
            <button class="btn btn-primary pull-right btn-sm" type="submit"><i class='fa fa-reply'></i> <?php echo lang("post_reply"); ?></button>
        </footer>
    </div> 
</div>
<?php echo form_close(); ?>


<script type="text/javascript">
    $(document).ready(function () {
        $(".reply-form").appForm({
            isModal: false,
            onSuccess: function (result) {
                $(".reply-form").parent().html("");
                var $triggerTarget = $("#reload-reply-list-button-" + "<?php echo isset($post_id) ? $post_id : 0; ?>");
                $triggerTarget.trigger("click");
                $triggerTarget.siblings(".view-replies").hide();
            }
        });
    });
</script>