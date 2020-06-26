<div id="page-content" class="p20 clearfix">
    <div class="row">
        <div class="col-sm-3 col-lg-2">
            <?php
            $tab_view['active_tab'] = "email_templates";
            $this->load->view("settings/tabs", $tab_view);
            ?>
        </div>
        <div class="col-sm-9 col-lg-10">
            <div class="row">
                <div class="col-md-3">
                    <div id="template-list-box" class="panel panel-default">
                        <div class="page-title clearfix">
                            <h4> <?php echo lang('email_templates'); ?></h4>
                        </div>
                        <div class="table-responsiv b-t b-white">
                            <table id="email-template-table" class="display clickable no-thead" cellspacing="0" width="100%">            
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <div id="template-details-section"> 
                        <div id="empty-template" class="text-center p15 box panel panel-default ">
                            <div class="box-content" style="vertical-align: middle; height: 100%"> 
                                <div><?php echo lang("select_a_template"); ?></div>
                                <span class="fa fa-code" style="font-size: 1450%; color:#f6f8f8"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
load_css(array(
    "assets/js/summernote/summernote.css",
    "assets/js/summernote/summernote-bs3.css"
));
load_js(array(
    "assets/js/summernote/summernote.min.js",
    "assets/js/bootstrap-confirmation/bootstrap-confirmation.js",
));
?>


<script type="text/javascript">
    $(document).ready(function () {
        $("#email-template-table").appTable({
            source: '<?php echo_uri("email_templates/list_data") ?>',
            order: [],
            columns: [
                {title: '<?php echo lang("name"); ?>'}
            ],
            displayLength: 100,
            hideTools: true,
            onInitComplete: function () {
                var $template_list = $("#template-list-box"),
                        $empty_template = $("#empty-template");
                if ($empty_template.length && $template_list.length) {
                    $empty_template.height($template_list.height() - 30);
                }
            }
        });

        /*load a message details*/
        $("body").on("click", "tr", function () {
            //don't load this message if already has selected.
            if (!$(this).hasClass("active")) {
                var template_name = $(this).find(".template-row").attr("data-name");
                if (template_name) {
                    $("tr.active").removeClass("active");
                    $(this).addClass("active");
                    $.ajax({
                        url: "<?php echo get_uri("email_templates/form"); ?>/" + template_name,
                        success: function (result) {
                            $("#template-details-section").html(result);
                        }
                    });
                }
            }
        });
    });
</script>