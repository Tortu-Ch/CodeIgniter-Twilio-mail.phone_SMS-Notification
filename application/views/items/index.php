<div id="page-content" class="p20 clearfix">
    <div class="panel panel-default">
        <div class="page-title clearfix">
            <h1> <?php echo lang('items'); ?></h1>
            <div class="title-button-group">
                <?php echo modal_anchor(get_uri("items/modal_form"), "<i class='fa fa-plus-circle'></i> " . lang('add_item'), array("class" => "btn btn-default", "title" => lang('add_item'))); ?>
            </div>
        </div>
        <div class="table-responsive">
            <table id="item-table" class="display" cellspacing="0" width="100%">            
            </table>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $("#item-table").appTable({
            source: '<?php echo_uri("items/list_data") ?>',
            order: [[0, 'desc']],
            columns: [
                {title: "<?php echo lang('title') ?> ", "class": "w20p"},
                {title: "<?php echo lang('description') ?>"},
                {title: "<?php echo lang('unit_type') ?>", "class": "w100"},
                {title: "<?php echo lang('rate') ?>", "class": "text-right w100"},
                {title: "<i class='fa fa-bars'></i>", "class": "text-center option w100"}
            ],
            printColumns: [0, 1, 2, 3],
            xlsColumns: [0, 1, 2, 3]
        });
    });
</script>