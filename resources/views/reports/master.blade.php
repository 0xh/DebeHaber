<!DOCTYPE html>

<html>
<head>
    <title>
        @yield('reportName') | {{ request()->route('taxPayer')->alias }}
    </title>

    <link href="{{url('/')}}/css/normalize.css" rel="stylesheet" type="text/css" />
    <link href="{{url('/')}}/css/skeleton.css" rel="stylesheet" type="text/css" />
    <link href="{{url('/')}}/vendors/base/vendors.bundle.css" rel="stylesheet" type="text/css" />

    <link rel="apple-touch-icon" sizes="57x57" href="/img/favicon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/img/favicon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/img/favicon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/img/favicon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/img/favicon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/img/favicon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/img/favicon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/img/favicon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/img/favicon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="/img/favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/img/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/img/favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/img/favicon/favicon-16x16.png">
    <link rel="manifest" href="/img/favicon/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">

    <style>
    body
    {
        padding: 10px;
        font-size: 9px;
        line-height: 0 !important;
    }

    a
    {
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
        background-color: whitesmoke;
        color:black;
    }

    th
    {
        border-bottom: 0px solid black !important;
        font-weight: bolder;
        text-transform: uppercase;
    }

    /* tr:nth-child(even)
    {
        background-color: #f1f1f1;
    } */

    td
    {
        border-bottom: 0.3px dotted #E1E1E1 !important;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    h6
    {
        margin-bottom: 0px;
        font-weight: bolder;
    }

    .header
    {
        padding: 8px;
        background-color: gainsboro;
        background-blend-mode: lighten;
        color: white;
        width: 100%;
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
        { page-break-after: always; }
    }

    </style>
</head>

<body>

    <div class="row">
        <div class="four columns">
            <h5 class="title is-5"><b>@yield('reportName')</b></h5>
        </div>

        {{ csrf_field() }}
        <div class="eight columns">
            <h5 class="u-pull-right">{{ $header->name }} | <b><small>{{ $header->taxid }}</small></b></h5>
        </div>
    </div>

    @php
    $taxIDName = Config::get('countries.' . request()->route('taxPayer')->country . '.taxpayer-id')
    @endphp

    <div class="container">
        <div class="row">
            <table class="u-full-width">
                <tr>
                    <td style="text-align:right">@lang('global.Taxpayer')</td>
                    <td style="text-align:left"><b>{{ $header->name }}</b></td>

                    <td style="text-align:right">@lang('global.LegalRepresentative')</td>
                    <td style="text-align:left"><b>{{ $header->setting->agent_name }}</b></td>
                </tr>
                <tr>
                    <td style="text-align:right">{{ $taxIDName }}</td>
                    <td style="text-align:left"><b>{{ $header->taxid }}-{{ $header->code }}</b></td>

                    <td style="text-align:right">@lang('global.LegalRepresentative') {{ $taxIDName }}</td>
                    <td style="text-align:left"><b>{{ $header->setting->agent_taxid }}</b></td>
                </tr>
                <tr>
                    <td style="text-align:right">@lang('global.DateRange')</td>
                    <td style="text-align:left"><small>@lang('global.StartDate')</small> <b>{{ $strDate }}</b> | <small>@lang('global.EndDate')</small> <b>{{ $endDate }}</b></td>
                    <td style="text-align:right">@lang('global.Timestamp')</td>
                    <td style="text-align:left"><b>{{ Carbon\Carbon::now(Auth::user()->timezone) }}</b> |
                        <small>
                            @lang('global.NumberOfRecords')
                        </small>

                        @isset($data)
                            <b>{{ $data->count() }}</b>
                        @endisset
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td style="text-align:right">
                        Share This!
                    </td>
                    <td>
                        <a href="{{ basename(Request::url()) }}/e">
                            <span><i class="la la-file-excel-o"></i>Excel</span>
                        </a>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    @yield('data')

    <div class="row">
        <table class="u-full-width">
            <tr>
                <td style="text-align:left">
                    @lang('global.Timestamp') <b>{{ Carbon\Carbon::now(Auth::user()->timezone) }}</b>
                </td>
                <td style="text-align:center">
                    <img src="/img/logos/debehaber.jpg" width="100" alt="">
                </td>
                <td style="text-align:right">@lang('global.IssuedBy') <b>{{ Auth::user()->name }}</b> | <a href="mailto:{{ Auth::user()->email }}">{{ Auth::user()->email }}</a></td>
            </tr>
        </table>
    </div>
</body>
</html>
