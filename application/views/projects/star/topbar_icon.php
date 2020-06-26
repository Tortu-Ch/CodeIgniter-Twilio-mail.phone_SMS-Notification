<li class="hidden-xs">
    <?php echo ajax_anchor(get_uri("projects/show_my_starred_projects/"), "<i class='fa fa-th-large starred-icon'></i>", array("class" => "dropdown-toggle", "data-toggle" => "dropdown", "data-real-target" => "#projects-quick-list-container")); ?>
    <div class="dropdown-menu aside-xl m0 p0 font-100p" style="width: 400px;" >
        <div id="projects-quick-list-container" class="dropdown-details panel bg-white m0">
            <div class="list-group">
                <span class="list-group-item inline-loader p20"></span>                          
            </div>
        </div>
    </div>
</li>