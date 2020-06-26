<div id="page-content" class="p20 clearfix">
    <div class="panel panel-default">
        <div class="page-title clearfix">
            <h1><?php echo lang('articles') . " (" . lang($type) . ")"; ?></h1>
            <div class="title-button-group">
                <?php
                echo anchor(get_uri("help/article_form/".$type), "<i class='fa fa-plus-circle'></i> " . lang('add_article'), array("class" => "btn btn-default", "title" => lang('add_article')));
                ?>
            </div>
        </div>
        <div class="table-responsive">
            <table id="article-table" class="display" cellspacing="0" width="100%">            
            </table>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {

        $("#article-table").appTable({
            source: '<?php echo_uri("help/articles_list_data/" . $type) ?>',
            order: [[0, "desc"]],
            columns: [
                {title: '<?php echo lang("title") ?>'},
                {title: '<?php echo lang("category") ?>', "class": "w30p"},
                {title: '<?php echo lang("status") ?>', "class": "w10p"},
                {title: '<?php echo lang("total_views") ?>', "class": "w10p"},
                {title: '<i class="fa fa-bars"></i>', "class": "text-center option w100"}
            ],
            printColumns: [0, 1, 2, 3]
        });
    });
</script>