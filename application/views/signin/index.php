<!DOCTYPE html>
<html lang="en">
    <head>
        <?php $this->load->view('includes/head'); ?>
    </head>
    <body>
        <?php
        if (get_setting("show_background_image_in_signin_page") === "yes") {
            $background_url = get_file_uri('files/system/sigin-background-image.jpg');
            ?>
            <style type="text/css">
                body {background-image: url('<?php echo $background_url; ?>'); background-size:cover}
            </style>
        <?php } ?>

        <div class="signin-box">
            <h4 style="color: red;"><?php echo $this->session->flashdata('verfiynumber'); ?></h4>
            <?php
                if(isset($_REQUEST['ref']))
                {
                    ?>
                    <h4 style="color: red;"> Your phon not verified. can you please check your mobile .</h4>
                    <?php
            }
                ?>


            <?php
            if (isset($form_type) && $form_type == "request_reset_password")
            {
                $this->load->view("signin/reset_password_form");
            }
             else if (isset($form_type) && $form_type == "new_password")
             {
                $this->load->view('signin/new_password_form');
            }
             else if (isset($form_type) && $form_type == "phone_verofiy")
             {
                $this->load->view('signin/Verify_phon');
            }
             else
            {
                $this->load->view("signin/signin_form");
            }
            ?>
        </div>
    </body>
</html>