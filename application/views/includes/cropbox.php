<?php
load_js(array(
    "assets/js/cropbox/cropbox-min.js"
));
?>
<div class="modal fade" id="cropModal" tabindex="-1" role="dialog" aria-labelledby="cropModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="crop-box">
                    <div class="thumb-box"></div>
                    <div class="spinner" style="display: none">Loading...</div>
                </div>
            </div>
            <div class="modal-footer clearfix">
                <button  id="image-zoomout-button" type="button" class="btn btn-default pull-left mr10"><i class="fa fa-minus"></i></button>
                <button id="image-zoomin-button" type="button" class="btn btn-default pull-left"><i class="fa fa-plus"></i></button>

                <button type="button" class="btn btn-default" data-dismiss="modal"> <i class="fa fa-times"></i> <?php echo lang("close"); ?></button>
                <button id="image-crop-button" type="button" class="btn btn-primary" data-dismiss="modal"> <i class="fa fa-check-circle"></i> <?php echo lang("crop"); ?></button>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    var options =
            {
                thumbBox: '.thumb-box',
                spinner: '.spinner',
                imgSrc: ''
            };
    var cropper = $('.crop-box').cropbox(options);
    function showCropBox(element) {
        var $selector = $(element),
                file = element.files ? element.files[0] : "";
        if (file) {
            var height = $selector.attr("data-height") || 200,
                    width = $selector.attr("data-width") || 200,
                    previewCntainer = $selector.attr('data-preview-container'),
                    inputField = $selector.attr('data-input-field');
            $('#image-crop-button').attr('data-preview-container', previewCntainer);
            $('#image-crop-button').attr('data-input-field', inputField);
            appLoader.show();
            var fileTypes = ["image/jpeg", "image/png", "image/gif"];
            if (fileTypes.indexOf(file.type) === -1) {
                appAlert.error("<?php echo lang("invalid_file_type"); ?>");
                appLoader.hide();
                return false;
            } else if (file.size / 1024 > 3072) {
                appAlert.error("<?php echo lang("max_file_size_3mb_message"); ?>");
                appLoader.hide();
                return false;
            }

            if (typeof FileReader == 'function') {
                $(options.thumbBox).css({"width": width + "px", "height": height + "px", "margin-top": (height / 2) * -1 + "px", "margin-left": (width / 2) * -1 + "px"});
                var reader = new FileReader();
                reader.onload = function(e) {
                    options.imgSrc = e.target.result;
                    cropper = $('.crop-box').cropbox(options);
                };
                reader.readAsDataURL(file);
                setTimeout(function() {
                    $("#cropModal").modal('toggle');
                    setTimeout(function() {
                        cropper.zoomIn();
                        cropper.zoomOut();
                        appLoader.hide();
                    }, 500);
                }, 500);
                $selector.val("");
            } else {
                //FileReader is not supported....
            }
        }
    }

    $(document).ready(function() {
        $('#image-crop-button').on('click', function() {
            var img = cropper.getDataURL(),
                    previewCntainer = $(this).attr('data-preview-container'),
                    inputField = $(this).attr('data-input-field');
            $(previewCntainer).attr("src", img);
            $(inputField).val(img).trigger("change");
        });
        $('#image-zoomin-button').on('click', function() {
            cropper.zoomIn();
        });
        $('#image-zoomout-button').on('click', function() {
            cropper.zoomOut();
        });
    });
</script>
