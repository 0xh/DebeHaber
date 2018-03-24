<!DOCTYPE html>

<html>
<head>
    <title>
        @yield('reportName')
    </title>
    <link href="{{url('/')}}/css/normalize.css" rel="stylesheet" type="text/css" />
    <link href="{{url('/')}}/css/skeleton.css" rel="stylesheet" type="text/css" />
    {{-- <link href="{{url('/')}}/auxiliar/DataTables/datatables.min.css" rel="stylesheet" type="text/css" /> --}}
    <style>

    @import url('https://fonts.googleapis.com/css?family=OpenSans');

    body
    {
        padding: 10px;
        font-size: 8px;
        line-height: 0 !important;
    }

    a{
        /* color: black; */
        text-decoration: none !important;
    }

    table
    {
        border-top: 0px solid black !important;
        border-bottom: 0px solid black !important;
    }

    thead
    {
        border-bottom: 2px solid black !important;
    }

    th
    {
        border-bottom: 0px solid black !important;
        font-weight: bolder;
        text-transform: uppercase;
    }

    td
    {
        border-bottom: 0.3px dotted #E1E1E1 !important;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .danger
    {
        color: crimson;
    }

    .warning
    {
        color: gold;
    }

    .success
    {
        color: green;
    }

    .group
    {
        text-transform: uppercase !important;
        font-size: 9px;
        border-top: 1px solid black;
        border-bottom: 0.5px solid dimgray;
    }

    .important
    {
        white-space: nowrap;
    }

    .text
    {
        white-space: nowrap;
        text-overflow: ellipsis;
        overflow: hidden;
        max-width: 1px;
    }

    .number
    {
        text-align: right;
        white-space: nowrap;
    }

    .center
    {
        text-align: center;
        white-space: nowrap;
    }

    /* This breaks page every time a Horizontal Line <hr> tag is introduced. */
    @media print
    {
        hr
        {
            page-break-after: always;
        }
    }

    </style>

    {{-- <script src="/auxiliar/axios/axios.min.js"></script>
    <script src="/assets/front-end/js/jquery.min.js"></script>
    <script src="/auxiliar/DataTables/datatables.min.js"></script>
    <script type="text/javascript">
    var jsonData = {!! json_encode(array('data'=>$data,'reportName'=>'LibroIvaVEntas')) !!};

    function exportToExcel(){
    axios({
    method: 'post',
    url: '{{ URL::to('exportToExcel') }}',
    responseType: 'blob',
    headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}',
    'Accept': 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'},
    data: {
    'jsonData' : jsonData
},
}).then(response => {
var blob = new Blob([response.data], {type: 'application/vnd.ms-excel'});
var downloadUrl = URL.createObjectURL(blob);
var a = document.createElement("a");
a.href = downloadUrl;
a.download = "data.xls";
document.body.appendChild(a);
a.click();
}).catch(response => {
console.log(response);
});}

$(document).ready(function(){
$('#data').DataTable( {
"searching": true,
"paging": false,
"info":     false,
"ordering": false
} );
});

</script> --}}
</head>

<body>

    <div class="row">
        <div class="four columns">
            <h5><b>@yield('reportName')</b></h5>
        </div>

        {{ csrf_field() }}
        <div class="eight columns">
            <h5 class="u-pull-right">{{ $header->name }} | <b><small>{{ $header->taxid }}</small></b></h5>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <table class="u-full-width">
                <tr>
                    <td style="text-align:right">@lang('Taxpayer')</td>
                    <td style="text-align:left"><b>{{ $header->name }}</b></td>
                    <td style="text-align:right">Representante Legal</td>
                    {{-- <td style="text-align:left"><b>{{ $header->companySubscription->name_agent }}</b></td> --}}
                </tr>
                <tr>
                    <td style="text-align:right">@lang('TaxID')</td>
                    <td style="text-align:left"><b>{{ $header->taxid }}-{{ $header->code }}</b></td>
                    <td style="text-align:right">Cedula de Identidad del Representante</td>
                    {{-- <td style="text-align:left"><b>{{ $header->companySubscription->gov_code_agent }}</b></td> --}}
                </tr>
                <tr>
                    <td style="text-align:right">@lang('DateRange')</td>
                    <td style="text-align:left"><small>DESDE</small> <b>{{ $strDate }}</b> | <small>HASTA</small> <b>{{ $endDate }}</b></td>
                    <td style="text-align:right">Fecha de Impressión</td>
                    <td style="text-align:left"><b>{{ Carbon\Carbon::now() }}</b> |
                        <small>
                            # de Registros
                        </small>
                        @isset($data)
                            <b>{{ $data->count() }}</b>
                        @endisset
                    </td>
                </tr>
            </table>
        </div>
    </div>

    @yield('data')

    <div class="container">
        <div class="row">
            <div class="three columns">
                <p>Fecha y Hora de Impressión <b>{{ Carbon\Carbon::now() }}</b></p>
            </div>

            <div class="five columns">
                <img src="/img/logos/debehaber.svg" height="64" alt="">
            </div>

            <div class="three columns">
                <p>Emitido Por: <b>{{ Auth::user()->name }}</b> | {{ Auth::user()->email }}</p>
            </div>
        </div>
    </div>
</body>
</html>
