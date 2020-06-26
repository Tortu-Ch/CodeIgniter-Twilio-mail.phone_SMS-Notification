<div id="page-content" class="p20 clearfix">
    <div class="row">
        <div class="col-sm-3 col-lg-2">
            <?php
            $tab_view['active_tab'] = "custom_fields";
            $this->load->view("settings/tabs", $tab_view);
            ?>
        </div>
        <div class="col-sm-9 col-lg-10">

            <div class="panel panel-default no-border clearfix ">

                <ul id="custom-field-tab" data-toggle="ajax-tab" class="nav nav-tabs bg-white title" role="tablist">
                    <li class="title-tab"><h4 class="pl15 pt10 pr15"><?php echo lang("custom_fields"); ?></h4></li>
                    <li><a role="presentation" data-related_to="clients" class="active" href="javascript:;" data-target="#custom-field-clients"><?php echo lang("clients"); ?></a></li>
                    <li><a role="presentation" data-related_to="contacts" class="" href="<?php echo_uri("custom_fields/contacts/"); ?>" data-target="#custom-field-contacts"><?php echo lang("contacts"); ?></a></li>
                    <li><a role="presentation" data-related_to="projects" href="<?php echo_uri("custom_fields/projects/"); ?>" data-target="#custom-field-projects"><?php echo lang('projects'); ?></a></li>
                    <li><a role="presentation" data-related_to="tasks" href="<?php echo_uri("custom_fields/tasks/"); ?>" data-target="#custom-field-tasks"><?php echo lang('tasks'); ?></a></li>
                    <li><a role="presentation" data-related_to="team_members" href="<?php echo_uri("custom_fields/team_members/"); ?>" data-target="#custom-field-team_members"><?php echo lang('team_members'); ?></a></li>
                    <li><a role="presentation" data-related_to="tickets" href="<?php echo_uri("custom_fields/tickets/"); ?>" data-target="#custom-field-tickets"><?php echo lang('tickets'); ?></a></li>
                    <li><a role="presentation" data-related_to="invoices" href="<?php echo_uri("custom_fields/invoices/"); ?>" data-target="#custom-field-invoices"><?php echo lang('invoices'); ?></a></li>
                    <li><a role="presentation" data-related_to="events" href="<?php echo_uri("custom_fields/events/"); ?>" data-target="#custom-field-events"><?php echo lang('events'); ?></a></li>
                    <li><a role="presentation" data-related_to="expenses" href="<?php echo_uri("custom_fields/expenses/"); ?>" data-target="#custom-field-expenses"><?php echo lang('expenses'); ?></a></li>
                    <li><a role="presentation" data-related_to="estimates" href="<?php echo_uri("custom_fields/estimates/"); ?>" data-target="#custom-field-estimates"><?php echo lang('estimates'); ?></a></li>
                    <div class="tab-title clearfix no-border">
                        <div class="title-button-group">
                            <?php echo modal_anchor(get_uri("custom_fields/modal_form/"), "<i class='fa fa-plus-circle'></i> " . lang('add_field'), array("class" => "btn btn-default", "id" => "add-field-button", "data-post-related_to" => "clients", "title" => lang('add_field'))); ?>
                        </div>
                    </div>
                </ul>


                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane fade active clearfix" id="custom-field-clients">
                        <div class="panel panel-default mb0 p20">
                            <div class="table-responsive general-form">
                                <table id="custom-field-table-clients" class="display no-thead b-t b-b-only no-hover" cellspacing="0" width="100%">            
                                </table>
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="custom-field-contacts"></div>
                    <div role="tabpanel" class="tab-pane fade" id="custom-field-projects"></div>
                    <div role="tabpanel" class="tab-pane fade" id="custom-field-tasks"></div>
                    <div role="tabpanel" class="tab-pane fade" id="custom-field-team_members"></div>
                    <div role="tabpanel" class="tab-pane fade" id="custom-field-tickets"></div>
                    <div role="tabpanel" class="tab-pane fade" id="custom-field-invoices"></div>
                    <div role="tabpanel" class="tab-pane fade" id="custom-field-events"></div>
                    <div role="tabpanel" class="tab-pane fade" id="custom-field-expenses"></div>
                    <div role="tabpanel" class="tab-pane fade" id="custom-field-estimates"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $("#custom-field-tab a").click(function () {
            $("#add-field-button").attr("data-post-related_to", $(this).attr("data-related_to"));
        });

        var tab = "<?php echo $tab; ?>";
        if (tab) {
            $("[data-target=#custom-field-" + tab + "]").trigger("click");
        }


        loadCustomFieldTable("clients");

    });

    loadCustomFieldTable = function (relatedTo) {

        $("#custom-field-table-" + relatedTo).appTable({
            source: '<?php echo_uri("custom_fields/list_data") ?>' + "/" + relatedTo,
            order: [[1, "asc"]],
            hideTools: true,
            displayLength: 100,
            columns: [
                {title: '<?php echo lang("title") ?>'},
                {visible: false},
                {title: '<i class="fa fa-bars"></i>', "class": "text-right option w100"}
            ],
            onInitComplete: function () {
                //apply sortable
                $("#custom-field-table-" + relatedTo).find("tbody").attr("id", "custom-field-table-sortable-" + relatedTo);
                var $selector = $("#custom-field-table-sortable-" + relatedTo);

                Sortable.create($selector[0], {
                    animation: 150,
                    chosenClass: "sortable-chosen",
                    ghostClass: "sortable-ghost",
                    onUpdate: function (e) {
                        appLoader.show();
                        //prepare sort indexes 
                        var data = "";
                        $.each($selector.find(".field-row"), function (index, ele) {
                            if (data) {
                                data += ",";
                            }

                            data += $(ele).attr("data-id") + "-" + index;
                        });

                        //update sort indexes
                        $.ajax({
                            url: '<?php echo_uri("custom_fields/update_field_sort_values") ?>' + "/" + relatedTo,
                            type: "POST",
                            data: {sort_values: data},
                            success: function () {
                                appLoader.hide();
                            }
                        });
                    }
                });

            }
        });
    };


</script>