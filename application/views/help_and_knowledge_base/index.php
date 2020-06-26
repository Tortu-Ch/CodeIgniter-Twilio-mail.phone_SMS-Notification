<div id="page-content" class="clearfix p20 help-page-container <?php echo "main_" . $type ?>">
    <div id="search-box-wrapper">
        <div class="help-search-box-container">
            <h2><?php
                if ($type === "knowledge_base") {
                    echo lang("how_can_we_help");
                } else {
                    echo lang("help_page_title");
                }
                ?></h2>
            <?php $this->load->view("help_and_knowledge_base/search_box", array("type" => $type)); ?>
        </div>
    </div>

    <div class="help-page view-container-large" style="min-height: 300px;">

        <?php
        $count = 0;

        foreach ($categories as $category) {
            if ($count % 3 === 0) {
                echo "<div class='row'>";
            }
            $count++;
            ?>
            <div class="col-md-4 col-sm-12">
                <a href="<?php echo get_uri($type . "/category/" . $category->id); ?>">
                    <div class="panel panel-default">
                        <div class="page-body p15 help-category-box">
                            <h4><?php echo $category->title; ?></h4>
                            <p class="text-off"><?php echo nl2br($category->description); ?></p>
                            <span class="anchor"><?php echo $category->total_articles . " " . lang("articles"); ?></span>
                        </div>
                    </div>
                </a>
            </div>
            <?php
            if ($count % 3 === 0) {
                echo "</div>";
            }
        }
        ?>
    </div>
</div>