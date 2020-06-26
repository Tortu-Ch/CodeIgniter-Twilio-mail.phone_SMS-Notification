<?php
    foreach ($announcements as $announcement) {
        ?>
        <div id="<?php echo "announcement-$announcement->id"; ?>" class="alert alert-warning"><i class="fa fa-bullhorn mr10"></i> 
            <?php
            echo anchor(get_uri("announcements/view/" . $announcement->id), $announcement->title);
            echo ajax_anchor(get_uri("announcements/mark_as_read/" . $announcement->id), "<span aria-hidden='true' >×</span>", array("class" => "close mt-5", "data-remove-on-click" => "#announcement-$announcement->id"));
            ?>
        </div>
        <?php
    }
    ?>