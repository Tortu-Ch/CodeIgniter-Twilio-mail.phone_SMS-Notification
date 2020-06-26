<?php
if ($this->login_user->user_type == "staff") {

    $access_client = get_array_value($this->login_user->permissions, "client");
    if ($this->login_user->is_admin || $access_client) {
        ?>
        <li class="hidden-xs">
            <?php echo ajax_anchor(get_uri("clients/show_my_starred_clients/"), "<i class='fa fa-briefcase starred-icon'></i>", array("class" => "dropdown-toggle", "data-toggle" => "dropdown", "data-real-target" => "#clients-quick-list-container")); ?>
            <div class="dropdown-menu aside-xl m0 p0 font-100p" style="width: 400px;" >
                <div id="clients-quick-list-container" class="dropdown-details panel bg-white m0">
                    <div class="list-group">
                        <span class="list-group-item inline-loader p20"></span>                          
                    </div>
                </div>
            </div>
        </li>

        <?php
    }
}