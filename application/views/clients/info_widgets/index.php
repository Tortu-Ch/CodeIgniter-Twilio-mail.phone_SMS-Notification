<div class="clearfix">
    <?php if ($show_invoice_info) { ?>
        <?php if (!in_array("projects", $hidden_menu)) { ?>
            <div class="col-md-3 col-sm-6 widget-container">
                <?php $this->load->view("clients/info_widgets/tab", array("tab" => "projects")); ?>
            </div>
        <?php } ?>

        <?php if (!in_array("invoices", $hidden_menu)) { ?>
            <div class="col-md-3 col-sm-6  widget-container">
                <?php $this->load->view("clients/info_widgets/tab", array("tab" => "invoice_value")); ?>
            </div>
        <?php } ?>

        <?php if (!in_array("payments", $hidden_menu) && !in_array("invoices", $hidden_menu)) { ?>
            <div class="col-md-3 col-sm-6  widget-container">
                <?php $this->load->view("clients/info_widgets/tab", array("tab" => "payments")); ?>
            </div>
            <div class="col-md-3 col-sm-6  widget-container">
                <?php $this->load->view("clients/info_widgets/tab", array("tab" => "due")); ?>
            </div>
        <?php } ?>

        <?php if ((in_array("projects", $hidden_menu)) && (in_array("invoices", $hidden_menu))) { ?>
            <div class="col-sm-12 col-md-12" style="margin-top: 10%">
                <div class="text-center box">
                    <div class="box-content" style="vertical-align: middle; height: 100%">
                        <span class="fa fa-meh-o" style="font-size: 2000%; color:#CBCED0;"></span>
                    </div>
                </div>
            </div>
        <?php } ?>

    <?php } ?>
</div>