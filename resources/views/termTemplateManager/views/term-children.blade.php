
<table style="font-family:helvetica;font-size:14px;;;width:auto;border:1px solid #ebebeb">
    <tr style="font-weight:700;color:white;height:40px;background:#90001B">
        @foreach($fields as $key => $item)
            <td style="width:100px;text-align:center;">{{$item['title']}}</td>
        @endforeach
    </tr>
    @foreach($term as $index => $value)
        <tr style="height:40px;background:#fafafa;">
            @foreach($fields as $key => $item)
                <td style="width:100px;text-align:center;">
                    @if(!empty($value[$item['name']]))
                        @if($item['element'] === 'select')
                            <p>{{getDataOptionsMap()[$value[$item['name']]]['name']}}</p>
                        @elseif($item['element'] === 'date')
                            <p>{{date('m-d-Y',strtotime($value[$item['name']]))}}</p>
                        @elseif($item['element'] === 'file')
                            <a href="{{getBaseUrl()}}/admin/file/download/{{$value[$item['name']][0]}}">
                                <?php 
                                    $fileName = fileManagerTermMap()[$value[$item['name']]]['file_name'];
                                ?>
                                {{ strlen($fileName) < 10 ? $fileName :  substr($fileName, 0, 7) . '...' .  substr($fileName, strripos($fileName,'.')) }}
                            </a>
                        @elseif($item['element'] === 'number')     
                            <p>${{number_format($value[$item['name']], 2)}}</p>
                        @else
                            <p>{{$value[$item['name']]}}</p>
                        @endif
                    @endif
                </td>
            @endforeach
        </tr>
    @endforeach
</table>