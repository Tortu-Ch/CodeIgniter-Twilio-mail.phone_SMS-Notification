<div id="page-content" class="p20 clearfix">
    <div class="panel panel-default">
        <div class="page-title clearfix">
            <h1><?php echo lang('users'); ?></h1>
            <div class="title-button-group">
                <?php
                echo modal_anchor(get_uri("clients/invitation_modal"), "<i class='fa fa-envelope-o'></i> " . lang('send_invitation'), array("class" => "btn btn-default", "title" => lang('send_invitation'), "data-post-client_id" => $client_id));
                ?>
            </div>
        </div>
        <div class="table-responsive">
            <table id="contact-table" class="display" width="100%">            
            </table>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $("#contact-table").appTable({
            source: '<?php echo_uri("clients/contacts_list_data/" . $client_id) ?>',
            order: [[1, "asc"]],
            columns: [
                {title: '', "class": "w50 text-center"},
                {title: "<?php echo lang("name") ?>"},
                {title: "<?php echo lang("job_title") ?>", "class": "w15p"},
                {title: "<?php echo lang("email") ?>", "class": "w20p"},
                {title: "<?php echo lang("phone") ?>", "class": "w15p"},
                {title: 'Skype', "class": "w15p"}
            ],
            printColumns: [0, 1, 2, 3, 4, 5],
            xlsColumns: [1, 2, 3, 4, 5]

        });
    });
</script>