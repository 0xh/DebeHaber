@extends('reports.master')

@section('reportName', __('accounting.Ledger'))

@section('data')
    <table class="u-full-width">
        <tbody>
            @foreach ($data->groupBy('type') as $groupedRows)
                <thead>
                    <tr>

                    </tr>
                </thead>
            @endforeach
        </tbody>
    </table>
@endsection
