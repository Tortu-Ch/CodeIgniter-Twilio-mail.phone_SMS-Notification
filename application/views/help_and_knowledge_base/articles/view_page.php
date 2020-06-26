<div id="page-content" class="clearfix p20 help-page-container <?php echo "sub_" . $type ?>">
    <div class="view-container">
        <div class="row ">
            <div id="help-left-panel" class="col-md-3">
                <?php $this->load->view("help_and_knowledge_base/search_box", array("type" => $type)); ?>

                <h4 class="mt20"><?php echo lang("categories"); ?></h4>
                <ul class="list-group help-catagory">
                    <?php
                    foreach ($categories as $category) {
                        $active_class = "";
                        if ($category->id === $selected_category_id) {
                            $active_class = "active";
                        }
                        echo anchor(get_uri($type . "/category/" . $category->id), $category->title, array("class" => "list-group-item $active_class"));
                    }
                    ?>
                </ul>

            </div>


            <div class="col-md-9">
                <div id="help-page-content" class="panel">

                    <?php
                    if ($page_type == "articles_list_view") {
                        $this->load->view("help_and_knowledge_base/articles/articles_list_view", array("category_info" => $category_info, "articles" => $articles));
                    } else if ($page_type == "article_view") {
                        $this->load->view("help_and_knowledge_base/articles/article_view", array("article_info" => $article_info));
                    }
                    ?>

                </div>
            </div>

        </div>
    </div>
</div>



<script type="text/javascript">
    $(document).ready(function () {
        //load message notifications
        $("#help-page-content").css({"min-height": $(window).height() - 110 + "px"});
    });
</script>
