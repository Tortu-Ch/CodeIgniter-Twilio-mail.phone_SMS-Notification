<div class="box">
    <div class="box-content w200 text-center profile-image">
        <?php
        $url = "team_members";

        //set url
        if ($user_info->user_type === "client") {
            $url = "clients";
        }
        echo form_open(get_uri($url . "/save_profile_image/" . $user_info->id), array("id" => "profile-image-form", "class" => "general-form", "role" => "form"));
        ?>
        <?php if ($this->login_user->is_admin || $user_info->id === $this->login_user->id) { ?>
            <div class="file-upload btn mt0 p0" style="vertical-align: top;  margin-left: -45px; ">
                <span><i class="btn fa fa-camera" ></i></span> 
                <input id="profile_image_file" class="upload" name="profile_image_file" type="file" data-height="200" data-width="200" data-preview-container="#profile-image-preview" data-input-field="#profile_image" />
            </div>
            <input type="hidden" id="profile_image" name="profile_image" value=""  />
        <?php } ?>
        <span class="avatar avatar-lg"><img id="profile-image-preview" src="<?php echo get_avatar($user_info->image); ?>" alt="..."></span> 
        <h4 class=""><?php echo $user_info->first_name . " " . $user_info->last_name; ?></h4>
        <?php echo form_close(); ?>
    </div> 


    <div class="box-content pl15">
        <p class="p10 m0"><label class="label label-info large"><strong> <?php echo $user_info->job_title; ?> </strong></label></p> 

        <?php if ($show_cotact_info) { ?>
            <p class="p10 m0"><i class="fa fa-envelope-o"></i> <?php echo $user_info->email ? $user_info->email : "-"; ?></p> 
            <?php if ($user_info->phone || $user_info->skype) { ?>
                <p class="p10 m0">
                    <?php if ($user_info->phone) { ?>
                        <i class="fa fa-phone"></i> <?php echo $user_info->phone; ?> <span class="mr15"></span>
                        <?php
                    }
                    if ($user_info->skype) {
                        ?>
                        <i class="fa fa-skype"></i> <?php echo $user_info->skype; ?>
                    <?php } ?>
                </p>
            <?php } ?>
        <?php } ?> 

        <div class="p10 m0 clearfix">
            <div class="pull-left">
                <?php
                if ($show_social_links) {
                    social_links_widget($social_link);
                }
                ?>
            </div>
            <?php
            if ($user_info->id != $this->login_user->id) {

                $show_message_button = true;

                //don't show message button in client contact's page if user hasn't permission to send/receive message to/from client
                if ($user_info->user_type === "client") {
                    $client_message_users = get_setting("client_message_users");
                    $client_message_users_array = explode(",", $client_message_users);
                    if (!in_array($this->login_user->id, $client_message_users_array)) {
                        $show_message_button = false;
                    }
                }

                if (get_setting("module_message") && $show_message_button) {
                    echo modal_anchor(get_uri("messages/modal_form/" . $user_info->id), "<i class='fa fa-envelope-o'></i> " . lang('send_message'), array("class" => "btn btn-transparent success btn-sm", "title" => lang('send_message')));
                }
            }
            ?>
        </div>
    </div>
</div>