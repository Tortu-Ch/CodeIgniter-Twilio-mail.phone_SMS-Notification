<div class="modal-body">
    <div class="row">
        <div class="p10 clearfix">
            <div class="media m0 bg-white">
                <div class="media-left">
                    <span class="avatar avatar-sm">
                        <img src="<?php echo get_avatar($leave_info->applicant_avatar); ?>" alt="..." />
                    </span>
                </div>
                <div class="media-body w100p pt5">
                    <div class="media-heading m0">
                        <?php echo $leave_info->applicant_name; ?>
                    </div>
                    <p><span class='label label-info'><?php echo $leave_info->job_title; ?></span> </p>
                </div>
            </div>
        </div>
        <div class="table-responsive mb15">
            <table class="table dataTable display b-t">
                <tr>
                    <td class="w100"> <?php echo lang('leave_type'); ?></td>
                    <td><?php echo $leave_info->leave_type_meta; ?></td>
                </tr>
                <tr>
                    <td> <?php echo lang('date'); ?></td>
                    <td><?php echo $leave_info->date_meta; ?></td>
                </tr>
                <tr>
                    <td> <?php echo lang('duration'); ?></td>
                    <td><?php echo $leave_info->duration_meta; ?></td>
                </tr>
                <tr>
                    <td> <?php echo lang('reason'); ?></td>
                    <td><?php echo nl2br($leave_info->reason); ?></td>
                </tr>
                <tr>
                    <td> <?php echo lang('status'); ?></td>
                    <td><?php echo $leave_info->status_meta; ?></td>
                </tr>
                <?php if ($leave_info->status === "rejected") { ?>
                    <tr>
                        <td> <?php echo lang('rejected_by'); ?></td>
                        <td><?php
                            $image_url = get_avatar($leave_info->checker_avatar);
                            echo "<span class='avatar avatar-xs mr10'><img src='$image_url' alt=''></span><span>" . $leave_info->checker_name . "</span>";
                            ?>
                        </td>
                    </tr>
                <?php } ?>
                <?php if ($leave_info->status === "approved") { ?>
                    <tr>
                        <td> <?php echo lang('approved_by'); ?></td>
                        <td><?php
                            $image_url = get_avatar($leave_info->checker_avatar);
                            echo "<span class='avatar avatar-xs mr10'><img src='$image_url' alt=''></span><span>" . $leave_info->checker_name . "</span>";
                            ?>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </div>
    </div>
</div>
<?php echo form_open(get_uri("leaves/update_status"), array("id" => "leave-status-form", "class" => "general-form", "role" => "form")); ?>
<input type="hidden" name="id" value="<?php echo $leave_info->id; ?>" />
<input id="leave_status_input" type="hidden" name="status" value="" />
<div class="modal-footer">
    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><span class="fa fa-close"></span> <?php echo lang('close'); ?></button>
    <?php if ($leave_info->status === "pending" && $this->login_user->id === $leave_info->applicant_id) { ?>
        <button data-status="canceled" type="submit" class="btn btn-danger btn-sm update-leave-status"><span class="fa fa-times-circle-o"></span> <?php echo lang('cancel'); ?></button>
    <?php } ?>   
    <?php if ($leave_info->status === "pending" && $show_approve_reject) { ?>
        <button data-status="rejected" type="submit" class="btn btn-danger btn-sm update-leave-status"><span class="fa fa-times-circle-o"></span> <?php echo lang('reject'); ?></button>
        <button data-status="approved" type="submit" class="btn btn-success btn-sm update-leave-status"><span class="fa fa-check-circle-o"></span> <?php echo lang('approve'); ?></button>
    <?php } ?>
</div>
<?php echo form_close(); ?>

<script type="text/javascript">
    $(document).ready(function() {

        $(".update-leave-status").click(function() {
            $("#leave_status_input").val($(this).attr("data-status"));
        });

        $("#leave-status-form").appForm({
            onSuccess: function() {
                location.reload();
            }
        });

    });
</script>    