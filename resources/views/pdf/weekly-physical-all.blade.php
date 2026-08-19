<!doctype html><html lang="id"><head><meta charset="utf-8"><style>
@page{margin:20px}body{font-family:Arial,sans-serif;font-size:8px;color:#000}table{width:100%;border-collapse:collapse}.b{border:1px solid #000}.green{background:#e2efda}.c{text-align:center;vertical-align:middle}.l{vertical-align:top}.title{font-size:13px;font-weight:bold}.small{font-size:8px}.pad td{padding:3px;vertical-align:top}.items th,.items td{border:1px solid #000;padding:2px}.items th{background:#e2efda;text-align:center;vertical-align:middle}.items td{height:14px}.sign td{text-align:center;height:75px;vertical-align:bottom}.muted{color:#666}
.page-break{page-break-before:always;}
</style></head><body>

@foreach($projects as $projectData)
    @include('pdf.weekly-physical-content', [
        'summary' => $projectData['summary'],
        'rows' => $projectData['rows']
    ])
    
    @if(!$loop->last)
        <div class="page-break"></div>
    @endif
@endforeach

</body></html>
