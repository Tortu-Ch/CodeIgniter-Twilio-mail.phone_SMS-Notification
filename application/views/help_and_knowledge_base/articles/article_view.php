<h2 class="mb20 pb10 b-b"> <?php echo $article_info->title; ?></h2>
<div>
    <?php echo $article_info->description; ?>
</div>
<div class="mt20">
    <?php
    if ($article_info->files) {
        $files = unserialize($article_info->files);
        $total_files = count($files);
        $this->load->view("includes/timeline_preview", array("files" => $files));

        if ($total_files) {
            $download_caption = lang('download');
            if ($total_files > 1) {
                $download_caption = sprintf(lang('download_files'), $total_files);
            }
            echo anchor(get_uri($article_info->type."/download_files/" . $article_info->id), $download_caption, array("class" => "", "title" => $download_caption));
        }
    }
    ?>
</div>

