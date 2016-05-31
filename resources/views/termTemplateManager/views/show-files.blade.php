<div class="file-ticket">
    @foreach($files as $key => $value)
        <?php
            $file = fileManagerTermMap()[$value]; 
        ?>
        @if(checkIsImage($file['type']))
            <a href="javascript:void(0)" ng-click="viewModalImage({{$value}})" class="icon-f" style="margin-left:10px">
                <i class="fa fa-picture-o"></i>
                <span>
                    {{strlen($file['file_name']) < 10 ? $file['file_name'] :  substr($file['file_name'], 0, 7) . '...' .  substr($file['file_name'], strripos($file['file_name'],'.'))}}
                </span>
            </a>
        @else
            <a ng-href="{{getBaseUrl()}}/admin/file/download/{{$value}}" class="icon-f" style="margin-left:10px">
                <i class="fa fa-file-o"></i>
                <span>
                    {{strlen($file['file_name']) < 10 ? $file['file_name'] :  substr($file['file_name'], 0, 7) . '...' .  substr($file['file_name'], strripos($file['file_name'],'.'))}}
                </span>
            </a>
        @endif
    @endforeach
    <div class="clearfix"></div>
</div>