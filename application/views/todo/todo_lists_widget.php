<div class="panel panel-default">
    <div class="panel-heading">
        <i class="fa fa-check-square-o"></i>&nbsp; <?php echo lang('todo') . " (" . lang('private') . ")"; ?>
    </div>

    <?php echo form_open(get_uri("todo/save"), array("id" => "todo-inline-form", "class" => "", "role" => "form")); ?>
    <div class="widget-todo-input-box mb0 todo-input-box">

        <div class="input-group pb15">
            <?php
            echo form_input(array(
                "id" => "todo-title",
                "name" => "title",
                "value" => "",
                "class" => "form-control",
                "placeholder" => lang('add_a_todo')
            ));
            ?>
            <span class="input-group-btn">
                <button type="submit" class="btn btn-primary"><span class="fa fa-check-circle"></span> <?php echo lang('save'); ?></button>
            </span>
        </div>

    </div>
    <?php echo form_close(); ?>

    <div class="table-responsive" id="todo-list-widget-table">
        <table id="todo-table" class="display" cellspacing="0" width="100%">            
        </table>
    </div>
</div>

<?php $this->load->view("todo/helper_js"); ?>

<script type="text/javascript">
    $(document).ready(function () {
        initScrollbar('#todo-list-widget-table', {
            setHeight: 653
        });

        $("#todo-table").appTable({
            source: '<?php echo_uri("todo/list_data") ?>',
            order: [[1, 'desc']],
            columns: [
                {visible: false, searchable: false},
                {title: '', "class": "w25"},
                {title: '<?php echo lang("title"); ?>'},
                {targets: [5], visible: false},
                {title: '<?php echo lang("date"); ?>', "class": "w50"},
                {title: '<i class="fa fa-bars"></i>', "class": "text-center option w80"}
            ],
            checkBoxes: [
                {text: '<?php echo lang("to_do") ?>', name: "status", value: "to_do", isChecked: true},
                {text: '<?php echo lang("done") ?>', name: "status", value: "done", isChecked: false}
            ],
            rowCallback: function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                $('td:eq(0)', nRow).addClass(aData[0]);
            }
        });

        $(".custom-toolbar .DTTT_container").removeClass("mr15");
        $(".toolbar-left-top .DTTT_container button").removeClass("ml15");
        $("#todo-table_length").addClass("hide");
    });
</script>