<div id="page-content" class="clearfix">
    <div style="max-width: 1000px; margin: auto;">
        <div class="page-title clearfix mt15">


            <h1 ><?php echo lang("estimate_request"); ?> # <?php echo $model_info->id; ?></h1>

            <?php if ($show_actions) { ?>
                <div class="title-button-group p10">

                    <span class="dropdown inline-block">
                        <button class="btn btn-default dropdown-toggle  mt0 mb0" type="button" data-toggle="dropdown" aria-expanded="true">
                            <i class='fa fa-cogs'></i> <?php echo lang('actions'); ?>
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu pull-right" role="menu">
                            <?php if ($this->login_user->user_type == "staff") { ?>
                                <li role="presentation">
                                    <?php echo modal_anchor(get_uri("estimate_requests/edit_estimate_request_modal_form"), "<i class='fa fa-pencil'></i> " . lang('edit'), array("title" => lang('estimate_request'), "data-post-view" => "details", "data-post-id" => $model_info->id)); ?>
                                </li>
                            <?php }
                            
                                $this->load->view("estimate_requests/estimate_request_status_options");
                            ?>
                          
                        </ul>
                    </span>
                </div>
            <?php } ?>
        </div>
        <div class="panel panel-default  p15 no-border">
            <span class="text-off"><?php echo lang("status") . ": "; ?></span>
            <?php echo $status; ?>


            <?php if ($show_client_info) { ?>
            
                <span class="text-off ml15"><?php echo lang("client") . ": "; ?></span>
                <?php
                if ($model_info->company_name) {
                    echo anchor(get_uri("clients/view/" . $model_info->client_id), $model_info->company_name);
                } else if ($model_info->lead_company_name) {
                    echo $model_info->lead_company_name;
                }
                ?>

            <?php } ?>

            <span class="text-off ml15"><?php echo lang("created") . ": "; ?></span>
            <?php echo format_to_datetime($model_info->created_at); ?>

            <?php
            if ($show_assignee && $model_info->assigned_to) {
                $image_url = get_avatar($model_info->assigned_to_avatar);
                $assigned_to_user = "<span class='avatar avatar-xs mr10'><img src='$image_url' alt='...'></span> $model_info->assigned_to_user";
                $assigned_to = get_team_member_profile_link($model_info->assigned_to, $assigned_to_user);
                ?>
                <span class="text-off ml15"><?php echo lang("assigned_to") . ":"; ?></span>
                <span class="ml10"><?php echo $assigned_to; ?> </span>
                <?php
            }
            ?>

        </div>

        <div class="panel panel-default">


            <div class="panel-body">
                <h3 class="pl15 pr15">  <?php echo $model_info->form_title; ?></h3>

                <div class="table-responsive mt20 general-form">
                    <table id="estimate-request-table" class="display no-thead b-t b-b-only no-hover" cellspacing="0" width="100%">            
                    </table>
                </div>
                <div class="p15">
                    <?php
                    if ($model_info->files) {
                        $files = unserialize($model_info->files);
                        $total_files = count($files);
                        $this->load->view("includes/timeline_preview", array("files" => $files));

                        if ($total_files && $show_download_option) {
                            $download_caption = lang('download');
                            if ($total_files > 1) {
                                $download_caption = sprintf(lang('download_files'), $total_files);
                            }

                            echo "<i class='fa fa-paperclip pull-left font-16'></i>";


                            echo anchor(get_uri("estimate_requests/download_estimate_request_files/" . $model_info->id), $download_caption, array("class" => "pull-right", "title" => $download_caption));
                        }
                    }
                    ?>
                </div>

            </div>
        </div>

            

        <?php if ($lead_info) { ?>
            <div class="panel panel-default">
                <div class="page-title ml15">
                    <h4><?php echo lang("client_info"); ?></h4>
                </div>
                <div class="panel-body">
                    <table class="display no-thead b-t b-b-only no-hover dataTable no-footer ">
                        <tbody>
                            <tr>
                                <td>
                                    <i class="fa fa-cube"></i><strong> <?php echo lang('company_name'); ?></strong>
                                    <div class="pl15"><?php echo $lead_info->company_name; ?></div>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <i class="fa fa-cube"></i><strong> <?php echo lang('first_name'); ?></strong>
                                    <div class="pl15"><?php echo $lead_info->first_name; ?></div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <i class="fa fa-cube"></i><strong> <?php echo lang('last_name'); ?></strong>
                                    <div class="pl15"><?php echo $lead_info->last_name; ?></div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <i class="fa fa-cube"></i><strong> <?php echo lang('email'); ?></strong>
                                    <div class="pl15"><?php echo $lead_info->email; ?></div>
                                </td>
                            </tr>

                            <?php if ($lead_info->address) { ?>
                                <tr>
                                    <td>
                                        <i class="fa fa-cube"></i><strong> <?php echo lang('address'); ?></strong>
                                        <div class="pl15"><?php echo nl2br($lead_info->address); ?></div>
                                    </td>
                                </tr>
                            <?php } ?>

                            <?php if ($lead_info->city) { ?>    
                                <tr>
                                    <td>
                                        <i class="fa fa-cube"></i><strong> <?php echo lang('city'); ?></strong>
                                        <div class="pl15"><?php echo $lead_info->city; ?></div>
                                    </td>
                                </tr>
                            <?php } ?>

                            <?php if ($lead_info->state) { ?>      
                                <tr>
                                    <td>
                                        <i class="fa fa-cube"></i><strong> <?php echo lang('state'); ?></strong>
                                        <div class="pl15"><?php echo $lead_info->state; ?></div>
                                    </td>
                                </tr>
                            <?php } ?>
                            <?php if ($lead_info->zip) { ?>    
                                <tr>
                                    <td>
                                        <i class="fa fa-cube"></i><strong> <?php echo lang('zip'); ?></strong>
                                        <div class="pl15"><?php echo $lead_info->zip; ?></div>
                                    </td>
                                </tr>
                            <?php } ?>
                            <?php if ($lead_info->country) { ?>    
                                <tr>
                                    <td>
                                        <i class="fa fa-cube"></i><strong> <?php echo lang('country'); ?></strong>
                                        <div class="pl15"><?php echo $lead_info->country; ?></div>
                                    </td>
                                </tr>
                            <?php } ?>
                            <?php if ($lead_info->phone) { ?>    
                                <tr>
                                    <td>
                                        <i class="fa fa-cube"></i><strong> <?php echo lang('phone'); ?></strong>
                                        <div class="pl15"><?php echo $lead_info->phone; ?></div>
                                    </td>
                                </tr>
                            <?php } ?>
                    </table>
                </div>
                <br>
            </div>
        <?php } ?>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $("#estimate-request-table").appTable({
            source: '<?php echo_uri("estimate_requests/estimate_request_filed_list_data/" . $model_info->id) ?>',
            order: [[1, "asc"]],
            hideTools: true,
            displayLength: 100,
            columns: [
                {title: '<?php echo lang("title") ?>'},
                {visible: false}
            ],
            onInitComplete: function () {
                $(".dataTables_empty").hide();
            }
        });
    });
</script>
