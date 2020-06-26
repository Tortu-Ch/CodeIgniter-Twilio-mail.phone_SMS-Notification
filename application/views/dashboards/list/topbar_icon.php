<li class="hidden-xs">
    <?php echo ajax_anchor(get_uri("dashboard/show_my_dashboards/"), "<i class='fa fa-desktop'></i>", array("class" => "dropdown-toggle", "data-toggle" => "dropdown", "data-real-target" => "#my-dashboards-list-container")); ?>
    <div class="dropdown-menu aside-xl m0 p0 font-100p w300">
        <div id="my-dashboards-list-container" class="dropdown-details panel bg-white m0">
            <div class="list-group">
                <span class="list-group-item inline-loader p20"></span>                          
            </div>
        </div>
    </div>
</li>