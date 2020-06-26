<div class="clearfix">
    <div class="p20 bg-white pb0" id="js-kanban-filter-container">
        <div class="row">
            <div class="col-md-1 pb20">
                <button class="btn btn-default" id="reload-kanban-button"><i class="fa fa-refresh"></i></button>
            </div>
            <div id="kanban-filters" class="col-md-11"></div>
        </div>
    </div>


    <div id="load-kanban"></div>

</div>

<?php $this->load->view("projects/tasks/kanban/all_tasks_kanban_helper_js"); ?>