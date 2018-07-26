
@php
$currentTeam = Auth::user()->currentTeam->name;
@endphp

@extends('spark::layouts.dashboard')

@section('title', __('global.Dashboard', ['team' => $currentTeam]))

@section('content')

    <div class="row">
        <div class="col-xl-6">
            <!--begin:: Widgets/Top Products-->
            <div class="m-portlet m-portlet--full-height m-portlet--fit ">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text">
                                @lang('guide.SelectTaxpayer')
                            </h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">
                        <a href="{{ route('taxpayer.create') }}" class="btn btn--sm m-btn--pill btn-brand m-btn">
                            <i class="la la-plus"></i>
                            <span>
                                @lang('global.Create', ['model' => __('global.Taxpayer')])
                            </span>
                        </a>
                    </div>
                </div>

                <div class="m-portlet__body">
                    <!--begin::Widget5-->
                    <div class="m-widget4 m-widget4--chart-bottom">
                        @if(isset($taxPayerIntegrations))
                            @foreach($taxPayerIntegrations->sortBy('taxpayer.name') as $integration)
                                <div class="m-widget4__item">
                                    <div class="m-widget4__img m-widget4__img--logo">
                                        {{-- {{ $integration->taxPayer->image }} --}}
                                        <img src="/photo/" alt="" onerror="this.src='/img/icons/cloud.jpg';">
                                    </div>

                                    @if ($integration->status == 1)
                                        <div class="m-widget4__info">
                                            <span class="m-widget4__title">
                                                {{ $integration->taxpayer->name }}
                                            </span>
                                            <br>
                                            <span class="m-widget4__sub m--font-warning">
                                                Awaiting Approval
                                            </span>
                                        </div>
                                    @else
                                        <div class="m-widget4__info">
                                            <span class="m-widget4__title">
                                                <a href="{{ url('selectTaxPayer', $integration->taxpayer) }}">
                                                    {{ $integration->taxpayer->name }}
                                                </a>
                                            </span>
                                            <br>
                                            <span class="m-widget4__sub">
                                                {{ $integration->taxpayer->alias }} | {{ $integration->taxpayer->taxid }}
                                            </span>
                                        </div>

                                        <div class="m-btn-group m-btn-group--pill btn-group" role="group" aria-label="...">
                                            <a href="{{ route('taxpayer.edit', $integration) }}" class="m-btn btn btn-secondary">
                                                <i class="la la-pencil text-info"></i>
                                            </a>

                                            @if ($integration->is_owner == 1)
                                                {{-- onclick="addFavorite({{ $integration->taxpayer_id }}, 0)" --}}
                                                <a href="#" class="m-btn btn btn-secondary">
                                                    <i class="la la-star text-warning"></i>
                                                </a>
                                            @else
                                                <a href="#" class="m-btn btn btn-secondary">
                                                    <i class="la la-star-o text-warning"></i>
                                                </a>
                                            @endif
                                        </div>

                                    @endif
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            @if ($integrationInvites->count() > 0)
                <div class="m-portlet m-portlet--bordered-semi m-portlet--fit">
                    <div class="row justify-content-center m--padding-20">
                        <div class="col-3">
                            <img src="/img/icons/teams.svg" class="" alt="" width="135">
                        </div>
                        <div class="col-9">
                            <h3>Pending Approvals</h3>
                            <p>The following teams are requesting access to taxpayers of which <span class="m--font-bold">{{ $currentTeam }}</span> is the owner. Make sure you approve only those teams that have the correct role so that their association with your taxpayer is limited to only those features. For more info on that, click here...</p>
                        </div>
                    </div>

                    <div class="row justify-content-center">
                        <table class="m-datatable__table">
                            <thead class="m-datatable__head">
                                <tr class="m-datatable__row">
                                    <td>Team</td>
                                    <td>Taxpayer</td>
                                    <td>Role</td>
                                    <td>Actions</td>
                                </tr>
                            </thead>
                            <tbody class="m-datatable__body">
                                @foreach ($integrationInvites as $invite)
                                    <tr class="m-datatable__row">
                                        <td class="m-datatable__cell">{{ $invite->team->name }}</td>
                                        <td class="m-datatable__cell">{{ $invite->taxpayer->name }}</td>
                                        <td class="m-datatable__cell">
                                            @if ($invite->type == 1)
                                                Accountant
                                            @elseif($invite->type == 2)
                                                Personal
                                            @else
                                                Auditor
                                            @endif
                                        </td>
                                        <td class="m-datatable__cell">
                                            <a href="{{ route('Accept', [$invite->id,$invite->type]) }}">Approve</a>
                                            <a href="{{ route('Reject', [$invite->id,$invite->type]) }}">Reject</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif

        <!--begin:: Invitations-->
        <div class="m-portlet m-portlet--bordered-semi m-portlet--fit">
            <div class="row justify-content-center padding-40-5">
                <div class="col-3">
                    <img src="/img/icons/invitation.svg" class="" alt="" width="135">
                </div>
                <div class="col-9">
                    <h3>Invitar Alquien</h3>
                    <table class="m-table">
                        <thead>
                            <tr>
                                <td>Team</td>
                                <td>Taxpayer</td>
                                <td>Role</td>
                                <td>Actions</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($integrationInvites as $invite)
                                <tr>
                                    <td>{{ $invite->team->name }}</td>
                                    <td>{{ $invite->taxpayer->name }}</td>
                                    <td>
                                        @if ($invite->type == 1)
                                            Accountant
                                        @elseif($invite->type == 2)
                                            Personal
                                        @else
                                            Auditor
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('Accept', [$invite->id,$invite->type]) }}">Approve</a>
                                        <a href="{{ route('Reject', [$invite->id,$invite->type]) }}">Reject</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <ul>

                    </ul>
                </div>
            </div>
        </div>
        <!--begin:: Widgets/Outbound Bandwidth-->
        <div class="m-portlet m-portlet--bordered-semi m-portlet--half-height m-portlet--fit " style="min-height: 400px">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text">
                            @lang('teams.team_members')
                        </h3>
                    </div>
                </div>
            </div>
            <div class="m-portlet__body">
                <div class="m-widget4">

                </div>
            </div>
        </div>
    </div>
</div>

@endsection
