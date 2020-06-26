<script type="text/javascript">
    AppLanugage = {};
    AppLanugage.locale = "<?php echo lang('language_locale'); ?>";

    AppLanugage.days = <?php echo json_encode(array(lang("sunday"), lang("monday"), lang("tuesday"), lang("wednesday"), lang("thursday"), lang("friday"), lang("saturday"))); ?>;
    AppLanugage.daysShort = <?php echo json_encode(array(lang("short_sunday"), lang("short_monday"), lang("short_tuesday"), lang("short_wednesday"), lang("short_thursday"), lang("short_friday"), lang("short_saturday"))); ?>;
    AppLanugage.daysMin = <?php echo json_encode(array(lang("min_sunday"), lang("min_monday"), lang("min_tuesday"), lang("min_wednesday"), lang("min_thursday"), lang("min_friday"), lang("min_saturday"))); ?>;

    AppLanugage.months = <?php echo json_encode(array(lang("january"), lang("february"), lang("march"), lang("april"), lang("may"), lang("june"), lang("july"), lang("august"), lang("september"), lang("october"), lang("november"), lang("december"))); ?>;
    AppLanugage.monthsShort = <?php echo json_encode(array(lang("short_january"), lang("short_february"), lang("short_march"), lang("short_april"), lang("short_may"), lang("short_june"), lang("short_july"), lang("short_august"), lang("short_september"), lang("short_october"), lang("short_november"), lang("short_december"))); ?>;

    AppLanugage.today = "<?php echo lang('today'); ?>";
    AppLanugage.yesterday = "<?php echo lang('yesterday'); ?>";
    AppLanugage.tomorrow = "<?php echo lang('tomorrow'); ?>";

    AppLanugage.search = "<?php echo lang('search'); ?>";
    AppLanugage.noRecordFound = "<?php echo lang('no_record_found'); ?>";
    AppLanugage.print = "<?php echo lang('print'); ?>";
    AppLanugage.excel = "<?php echo lang('excel'); ?>";
    AppLanugage.printButtonTooltip = "<?php echo lang('print_button_help_text'); ?>";

    AppLanugage.fileUploadInstruction = "<?php echo lang('file_upload_instruction'); ?>";
    AppLanugage.fileNameTooLong = "<?php echo lang('file_name_too_long'); ?>";

    AppLanugage.custom = "<?php echo lang('custom'); ?>";
    AppLanugage.clear = "<?php echo lang('clear'); ?>";

    AppLanugage.total = "<?php echo lang('total'); ?>";
    AppLanugage.totalOfAllPages = "<?php echo lang('total_of_all_pages'); ?>";

    AppLanugage.all = "<?php echo lang('all'); ?>";

</script>