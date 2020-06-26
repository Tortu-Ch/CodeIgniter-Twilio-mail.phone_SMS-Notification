<div class="modal-body clearfix general-form bg-off-white pb0">
    <div class="col-md-12 clearfix">
        <?php echo $widget; ?>
    </div>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal"><span class="fa fa-close"></span> <?php echo lang('close'); ?></button>
</div>

<script>
    $(document).ready(function () {
        initScrollbar('#project-timeline-container', {
            setHeight: 719
        });

        initScrollbar('#upcoming-event-container', {
            setHeight: 330
        });
    });
</script>