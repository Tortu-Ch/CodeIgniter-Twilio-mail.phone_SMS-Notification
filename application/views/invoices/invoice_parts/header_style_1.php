<table style="color: #444; width: 100%;">
    <tr>
        <td style="width: 45%; vertical-align: top;">
            <?php $this->load->view('invoices/invoice_parts/company_logo'); ?>
        </td>
        <td style="width: 20%;">
        </td>
        <td style="width: 35%; vertical-align: top; text-align: right"><?php
            $data = array(
                "client_info" => $client_info,
                "color" => $color,
                "invoice_info" => $invoice_info
            );
            $this->load->view('invoices/invoice_parts/invoice_info', $data);
            ?>
        </td>
    </tr>
    <tr>
        <td style="padding: 5px;"></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td><?php
            $this->load->view('invoices/invoice_parts/bill_from', $data);
            ?>
        </td>
        <td></td>
        <td><?php
            $this->load->view('invoices/invoice_parts/bill_to', $data);
            ?>
        </td>
    </tr>
</table>