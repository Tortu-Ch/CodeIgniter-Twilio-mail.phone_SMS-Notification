<div class="table-responsive">
    <table id="income-vs-expenses-summary-table" class="display" cellspacing="0" width="100%">
    </table>
</div>

<script>
    $("#income-vs-expenses-summary-table").appTable({
        source: '<?php echo_uri("expenses/income_vs_expenses_summary_list_data"); ?>',
        order: [[0, "desc"]],
        dateRangeType: "yearly",
        columns: [
            {visible: false, searchable: false}, //sorting purpose only
            {title: '<?php echo lang("month") ?>', "class": "w30p", "iDataSort": 0},
            {title: '<?php echo lang("income") ?>', "class": "w20p text-right"},
            {title: '<?php echo lang("expenses") ?>', "class": "w20p text-right"},
            {title: '<?php echo lang("profit") ?>', "class": "w20p text-right"}
        ],
        printColumns: [1,2,3,4],
        xlsColumns: [1,2,3,4], 
        summation: [{column:2 , dataType: 'currency'}, {column:3 , dataType: 'currency'}, {column:4 , dataType: 'currency'}]
    });
</script>