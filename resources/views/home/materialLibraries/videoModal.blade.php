{{--协议展示拟态框--}}
<div class="modal fade" id="Video" tabindex="-1" role="dialog" aria-labelledby="XieYiLabel">
    <div class="modal-dialog" style="width:800px;height:600px;" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="gridSystemModalLabel">视频</h4>
            </div>
            <div class="modal-body">
                <video id="videoAddress" width="780" height="500" controls="controls" src="{{ url($materialLibrary->path) }}"></video>
            </div>
        </div>
    </div>
</div>