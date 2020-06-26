<div class="panel panel-default  p15 no-border m0">
    <span><?php echo $invoice_status_label; ?></span>
    <?php if ($invoice_info->project_id) { ?>
        <span class="ml15"><?php echo lang("project") . ": " . anchor(get_uri("projects/view/" . $invoice_info->project_id), $invoice_info->project_title); ?></span>
    <?php }; ?>

    <span class="ml15"><?php
        echo lang("client") . ": ";
        echo (anchor(get_uri("clients/view/" . $invoice_info->client_id), $invoice_info->company_name));
        ?>
    </span> 

    <span class="ml15"><?php
        echo lang("last_email_sent") . ": ";
        echo (is_date_exists($invoice_info->last_email_sent_date)) ? $invoice_info->last_email_sent_date : lang("never");
        ?>
    </span>
    <span class="ml15"><?php
        if ($invoice_info->recurring_invoice_id) {
            echo lang("created_from") . ": ";
            echo anchor(get_uri("invoices/view/" . $invoice_info->recurring_invoice_id), get_invoice_id($invoice_info->recurring_invoice_id));
        }
        ?>
    </span>

</div>