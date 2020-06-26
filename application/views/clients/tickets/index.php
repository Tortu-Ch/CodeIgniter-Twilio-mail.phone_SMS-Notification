<?php if (isset($page_type) && $page_type === "full") { ?>
    <div id="page-content" class="m20 clearfix">
    <?php } ?>

    <div class="panel">
        <?php if (isset($page_type) && $page_type === "full") { ?>
            <div class="page-title clearfix">
                <h1><?php echo lang('tickets'); ?></h1>
                <div class="title-button-group">
                    <?php echo modal_anchor(get_uri("tickets/modal_form"), "<i class='fa fa-plus-circle'></i> " . lang('add_ticket'), array("class" => "btn btn-default", "data-post-client_id" => $client_id, "title" => lang('add_ticket'))); ?>
                </div>
            </div>
        <?php } else { ?>
            <div class="tab-title clearfix">
                <h4><?php echo lang('tickets'); ?></h4>
                <div class="title-button-group">
                    <?php echo modal_anchor(get_uri("tickets/modal_form"), "<i class='fa fa-plus-circle'></i> " . lang('add_ticket'), array("class" => "btn btn-default", "data-post-client_id" => $client_id, "title" => lang('add_ticket'))); ?>
                </div>
            </div>
        <?php } ?>

        <div class="table-responsive">
            <table id="ticket-table" class="display" width="100%">            
            </table>
        </div>
    </div>
    <?php if (isset($page_type) && $page_type === "full") { ?>
    </div>
<?php } ?>

<script type="text/javascript">
    $(document).ready(function () {
        var userType = "<?php echo $this->login_user->user_type; ?>";

        var projectVisibility = false;
        if("<?php echo $show_project_reference; ?>"=="1"){
            projectVisibility = true;
        }
        

        $("#ticket-table").appTable({
            source: '<?php echo_uri("tickets/ticket_list_data_of_client/" . $client_id) ?>',
            order: [[6, "desc"]],
            columns: [
                {title: '<?php echo lang("ticket_id") ?>', "class": "w10p"},
                {title: '<?php echo lang("title") ?>'},
                
                {visible: false, searchable: false},
                {title: '<?php echo lang("project") ?>', "class": "w20p", visible: projectVisibility},
                {title: '<?php echo lang("ticket_type") ?>', "class": "w20p"},
                {title: '<?php echo lang("assigned_to") ?>', visible: userType == "staff" ? true : false}, //show only to team members
                {visible: false, searchable: false},
                {title: '<?php echo lang("last_activity") ?>', "iDataSort": 5, "class": "w15p"},
                {title: '<?php echo lang("status") ?>', "class": "w10p"}
                <?php echo $custom_field_headers; ?>
            ],
            printColumns:  combineCustomFieldsColumns([0, 1, 3, 5, 6], '<?php echo $custom_field_headers; ?>'),
            xlsColumns: combineCustomFieldsColumns([0, 1, 3, 5, 6], '<?php echo $custom_field_headers; ?>')
        });
    });
</script>