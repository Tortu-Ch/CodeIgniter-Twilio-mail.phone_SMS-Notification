<div class="tab-content">
    <?php
    $reload_url = get_uri("team_members/view/" . $user_id . "/social");
    $save_url = get_uri("team_members/save_social_links/" . $user_id);
    if (isset($user_type) && $user_type === "client") {
        $reload_url = "";
        $save_url = get_uri("clients/save_contact_social_links/" . $user_id);
    }
    echo form_open($save_url, array("id" => "social-links-form", "class" => "general-form dashed-row white", "role" => "form"));
    ?>
    <div class="panel">
        <div class="panel-default panel-heading">
            <h4> <?php echo lang('social_links'); ?></h4>
        </div>
        <div class="panel-body">
            <div class="form-group">
                <label for="facebook" class=" col-md-2">Facebook</label>
                <div class=" col-md-10">
                    <?php
                    echo form_input(array(
                        "id" => "facebook",
                        "name" => "facebook",
                        "value" => $model_info->facebook,
                        "class" => "form-control",
                        "placeholder" => "https://www.facebook.com/"
                    ));
                    ?>
                </div>
            </div>
            <div class="form-group">
                <label for="twitter" class=" col-md-2">Twitter</label>
                <div class=" col-md-10">
                    <?php
                    echo form_input(array(
                        "id" => "twitter",
                        "name" => "twitter",
                        "value" => $model_info->twitter,
                        "class" => "form-control",
                        "placeholder" => "https://twitter.com/"
                    ));
                    ?>
                </div>
            </div>
            <div class="form-group">
                <label for="linkedin" class=" col-md-2">Linkedin</label>
                <div class=" col-md-10">
                    <?php
                    echo form_input(array(
                        "id" => "linkedin",
                        "name" => "linkedin",
                        "value" => $model_info->linkedin,
                        "class" => "form-control",
                        "placeholder" => "https://www.linkedin.com/"
                    ));
                    ?>
                </div>
            </div>
            <div class="form-group">
                <label for="googleplus" class=" col-md-2">Google plus</label>
                <div class=" col-md-10">
                    <?php
                    echo form_input(array(
                        "id" => "googleplus",
                        "name" => "googleplus",
                        "value" => $model_info->googleplus,
                        "class" => "form-control",
                        "placeholder" => "https://plus.google.com/"
                    ));
                    ?>
                </div>
            </div>
            <div class="form-group">
                <label for="digg" class=" col-md-2">Digg</label>
                <div class=" col-md-10">
                    <?php
                    echo form_input(array(
                        "id" => "digg",
                        "name" => "digg",
                        "value" => $model_info->digg,
                        "class" => "form-control",
                        "placeholder" => "http://digg.com/"
                    ));
                    ?>
                </div>
            </div>
            <div class="form-group">
                <label for="youtube" class=" col-md-2">youtube</label>
                <div class=" col-md-10">
                    <?php
                    echo form_input(array(
                        "id" => "youtube",
                        "name" => "youtube",
                        "value" => $model_info->youtube,
                        "class" => "form-control",
                        "placeholder" => "https://www.youtube.com/"
                    ));
                    ?>
                </div>
            </div>
            <div class="form-group">
                <label for="pinterest" class=" col-md-2">Pinterest</label>
                <div class=" col-md-10">
                    <?php
                    echo form_input(array(
                        "id" => "pinterest",
                        "name" => "pinterest",
                        "value" => $model_info->pinterest,
                        "class" => "form-control",
                        "placeholder" => "https://www.pinterest.com/"
                    ));
                    ?>
                </div>
            </div>
            <div class="form-group">
                <label for="instagram" class=" col-md-2">Instagram</label>
                <div class=" col-md-10">
                    <?php
                    echo form_input(array(
                        "id" => "instagram",
                        "name" => "instagram",
                        "value" => $model_info->instagram,
                        "class" => "form-control",
                        "placeholder" => "https://instagram.com/"
                    ));
                    ?>
                </div>
            </div>
            <div class="form-group">
                <label for="github" class=" col-md-2">Github</label>
                <div class=" col-md-10">
                    <?php
                    echo form_input(array(
                        "id" => "github",
                        "name" => "github",
                        "value" => $model_info->github,
                        "class" => "form-control",
                        "placeholder" => "https://github.com/"
                    ));
                    ?>
                </div>
            </div>
            <div class="form-group">
                <label for="tumblr" class=" col-md-2">Tumblr</label>
                <div class=" col-md-10">
                    <?php
                    echo form_input(array(
                        "id" => "tumblr",
                        "name" => "tumblr",
                        "value" => $model_info->tumblr,
                        "class" => "form-control",
                        "placeholder" => "https://www.tumblr.com/"
                    ));
                    ?>
                </div>
            </div>
            <div class="form-group">
                <label for="vine" class=" col-md-2">Vine</label>
                <div class=" col-md-10">
                    <?php
                    echo form_input(array(
                        "id" => "vine",
                        "name" => "vine",
                        "value" => $model_info->vine,
                        "class" => "form-control",
                        "placeholder" => "https://vine.co/"
                    ));
                    ?>
                </div>
            </div>
        </div>
        <div class="panel-footer">
            <button type="submit" class="btn btn-primary"><span class="fa fa-check-circle"></span> <?php echo lang('save'); ?></button>
        </div>
    </div>
    <?php echo form_close(); ?>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $("#social-links-form").appForm({
            isModal: false,
            onSuccess: function (result) {
                appAlert.success(result.message, {duration: 10000});

                var reloadUrl = "<?php echo $reload_url; ?>";
                if (reloadUrl) {
                    setTimeout(function () {
                        window.location.href = reloadUrl;
                    }, 500);
                }

            }
        });
    });
</script>    