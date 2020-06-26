<div id="page-content" class="p20 clearfix">

    <?php echo form_open(get_uri("todo/save"), array("id" => "todo-inline-form", "class" => "", "role" => "form")); ?>
    <div class="todo-input-box">

        <div class="input-group">
            <?php
            echo form_input(array(
                "id" => "todo-title",
                "name" => "title",
                "value" => "",
                "class" => "form-control",
                "placeholder" => lang('add_a_todo'),
                "autocomplete" => "off",
                "autofocus" => true
            ));
            ?>
            <span class="input-group-btn">
                <button type="submit" class="btn btn-primary"><span class="fa fa-check-circle"></span> <?php echo lang('save'); ?></button>
            </span>
        </div>

    </div>
    <?php echo form_close(); ?>


    <div class="panel panel-default">
        <div class="page-title clearfix">
            <h1> <?php echo lang('todo') . " (" . lang('private') . ")"; ?></h1>
        </div>
        <div class="table-responsive">
            <table id="todo-table" class="display" cellspacing="0" width="100%">            
            </table>
        </div>
    </div>
</div>

<?php $this->load->view("todo/helper_js"); ?>

<script type="text/javascript">
    $(document).ready(function () {
        $("#todo-table").appTable({
            source: '<?php echo_uri("todo/list_data") ?>',
            order: [[1, 'desc']],
            columns: [
                {visible: false, searchable: false},
                {title: '', "class": "w25"},
                {title: '<?php echo lang("title"); ?>'},
                {targets: [5], visible: false},
                {title: '<?php echo lang("date"); ?>', "class": "w200"},
                {title: '<i class="fa fa-bars"></i>', "class": "text-center option w100"}
            ],
            checkBoxes: [
                {text: '<?php echo lang("to_do") ?>', name: "status", value: "to_do", isChecked: true},
                {text: '<?php echo lang("done") ?>', name: "status", value: "done", isChecked: false}
            ],
            printColumns: [2, 4],
            xlsColumns: [2, 4],
            rowCallback: function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                $('td:eq(0)', nRow).addClass(aData[0]);
            }
        });
    });
</script>