<nav class="navbar public-navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="fa fa-bars"></span>
        </button>

        <a class="navbar-brand" href="<?php echo_uri('dashboard'); ?>"><img src="<?php echo get_file_uri(get_setting("system_file_path") . get_setting("site_logo")); ?>" /></a>
    </div>
    <div id="navbar" class="navbar-collapse collapse">

        <ul class="nav navbar-nav navbar-right">
            <?php
            if (get_setting("module_knowledge_base")) {
                echo " <li>" . anchor("knowledge_base", lang("knowledge_base")) . " </li>";
            }

            if (!get_setting("disable_client_login")) {
                echo " <li>" . anchor("signin", lang("signin")) . " </li>";
            }

            if (!get_setting("disable_client_signup")) {
                echo " <li>" . anchor("signup", lang("signup")) . " </li>";
            }
            ?>
            <li class="mr15 pr15 pl15">
            </li>
        </ul>
    </div>
</nav>

