<div id="page-content" class="p20 clearfix">
    <div class="panel panel-default">
        <div class="page-title clearfix">
            <h4> <?php echo lang('categories') . " (" . lang($type) . ")"; ?></h4>
            <div class="title-button-group">
                <?php echo modal_anchor(get_uri("help/category_modal_form/" . $type), "<i class='fa fa-plus-circle'></i> " . lang('add_category'), array("class" => "btn btn-default", "title" => lang('add_category'))); ?>
            </div>
        </div>
        <div class="table-responsive">
            <table id="category-table" class="display" cellspacing="0" width="100%">            
            </table>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $("#category-table").appTable({
            source: '<?php echo_uri("help/categories_list_data/" . $type) ?>',
            columns: [
                {title: '<?php echo lang("title"); ?>'},
                {title: '<?php echo lang("description"); ?>'},
                {title: '<?php echo lang("status"); ?>'},
                {title: '<?php echo lang("sort"); ?>'},
                {title: '<i class="fa fa-bars"></i>', "class": "text-center option w100"}
            ],
            printColumns: [0, 1, 2, 3]
        });
    });
</script>