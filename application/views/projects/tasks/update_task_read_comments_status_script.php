<script>
    $("body").on("click", ".unread-comments-of-tasks, .unread-comments-of-kanban", function () {
        var id = $(this).attr("data-id");
        if (!id) {
            id = $(this).attr("data-post-id");
        }

        $.ajax({url: '<?php echo get_uri("projects/set_task_comments_as_read") ?>/' + id});

        $(this).removeClass("unread-comments-of-kanban").removeClass("unread");
        $(this).removeClass("unread-comments-of-tasks");
        $(this).find("i").removeClass("fa-comment");
    });
</script>