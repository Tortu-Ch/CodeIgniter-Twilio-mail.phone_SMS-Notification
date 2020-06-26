<div id="page-content" class="p20 clearfix">
    <div class="panel panel-default">
        <div class="page-title clearfix">
            <h1><?php echo lang('tickets'); ?></h1>
            <div class="title-button-group">
                <?php echo modal_anchor(get_uri("tickets/modal_form"), "<i class='fa fa-plus-circle'></i> " . lang('add_ticket'), array("class" => "btn btn-default", "title" => lang('add_ticket'))); ?>
            </div>
        </div>
        <div class="table-responsive">
            <table id="ticket-table" class="display" cellspacing="0" width="100%">            
            </table>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        
        var optionsVisibility = false;
        if("<?php if(isset($show_options_column) && $show_options_column){echo '1';}?>"=="1"){
            optionsVisibility = true;
        }
        
        var projectVisibility = false;
        if("<?php echo $show_project_reference; ?>"=="1"){
            projectVisibility = true;
        }
        
        $("#ticket-table").appTable({
            source: '<?php echo_uri("tickets/list_data") ?>',
            order: [[6, "desc"]],
            radioButtons: [{text: '<?php echo lang("open") ?>', name: "status", value: "open", isChecked: true}, {text: '<?php echo lang("closed") ?>', name: "status", value: "closed", isChecked: false}],
            filterDropdown: [{name: "ticket_label", class: "w200", options: <?php echo $ticket_labels_dropdown; ?>}, {name: "assigned_to", class: "w200", options: <?php echo $assigned_to_dropdown; ?>}],
            columns: [
                {title: '<?php echo lang("ticket_id") ?>', "class": "w10p"},
                {title: '<?php echo lang("title") ?>'},
                {title: '<?php echo lang("client") ?>', "class": "w15p"},
                {title: '<?php echo lang("project") ?>', "class": "w15p", visible: projectVisibility},
                {title: '<?php echo lang("ticket_type") ?>', "class": "w10p"},
                {title: '<?php echo lang("assigned_to") ?>', "class": "w10p"},
                {visible: false, searchable: false},
                {title: '<?php echo lang("last_activity") ?>', "iDataSort": 5, "class": "w10p"},
                {title: '<?php echo lang("status") ?>', "class": "w5p"}
                <?php echo $custom_field_headers; ?>,
                {title: '<i class="fa fa-bars"></i>', "class": "text-center dropdown-option w50", visible: optionsVisibility}
            ],
            printColumns: combineCustomFieldsColumns([0, 2, 1, 3, 4, 6, 7], '<?php echo $custom_field_headers; ?>'),
            xlsColumns: combineCustomFieldsColumns([0, 2, 1, 3, 4, 6, 7], '<?php echo $custom_field_headers; ?>')
        });

    });
</script>
