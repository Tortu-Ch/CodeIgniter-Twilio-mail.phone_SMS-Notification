<?php
$user_id = "";
$show_push_notification = 0;
$push_notification_volume = 0;

if (isset($this->login_user->id)) {
    $user_id = $this->login_user->id;
}
?>

<script type="text/javascript">
    AppHelper = {};
    AppHelper.baseUrl = "<?php echo base_url(); ?>";
    AppHelper.assetsDirectory = "<?php echo base_url("assets") . "/"; ?>";
    AppHelper.settings = {};
    AppHelper.settings.firstDayOfWeek =<?php echo get_setting("first_day_of_week") * 1; ?> || 0;
    AppHelper.settings.currencySymbol = "<?php echo get_setting("currency_symbol"); ?>";
    AppHelper.settings.currencyPosition = "<?php echo get_setting("currency_position"); ?>" || "left";
    AppHelper.settings.decimalSeparator = "<?php echo get_setting("decimal_separator"); ?>";
    AppHelper.settings.thousandSeparator = "<?php echo get_setting("thousand_separator"); ?>";
    AppHelper.settings.noOfDecimals = ("<?php echo get_setting("no_of_decimals"); ?>" =="0") ? 0 : 2;
    AppHelper.settings.displayLength = "<?php echo get_setting("rows_per_page"); ?>";
    AppHelper.settings.dateFormat = "<?php echo get_setting("date_format"); ?>";
    AppHelper.settings.timeFormat = "<?php echo get_setting("time_format"); ?>";
    AppHelper.settings.scrollbar = "<?php echo get_setting("scrollbar"); ?>";
   // AppHelper.settings.showPushNotification = "<?php echo get_setting("user_" . $user_id . "_show_push_notification"); ?>";
    AppHelper.settings.notificationSoundVolume = "<?php echo get_setting("user_" . $user_id . "_notification_sound_volume"); ?>";
    AppHelper.userId = "<?php echo $user_id; ?>";
</script>