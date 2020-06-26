<div id="page-content" class="p20 row">
    <div class="col-sm-3 col-lg-2">
        <?php
        $tab_view['active_tab'] = "db_backup";
        $this->load->view("settings/tabs", $tab_view);
        ?>
    </div>

    <div class="col-sm-9 col-lg-10">
        <div class="panel">
            <div class="panel-body">
                db backup
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {

    });
</script>