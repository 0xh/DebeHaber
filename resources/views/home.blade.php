
@extends('spark::layouts.dashboard')

@section('title', __('global.Dashboard',['team' => Auth::user()->currentTeam->name]))

@section('content')

    <div class="row">
        <div class="col-xl-6">
            <!--begin:: Widgets/Top Products-->
            <div class="m-portlet m-portlet--full-height m-portlet--fit ">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text">
                                Contribuyentes del equipo, @{{ teams[0].name }}
                            </h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">
                        <a href="{{ route('taxpayer.create') }}" class="btn btn--sm m-btn--pill btn-secondary m-btn m-btn--label-brand">
                            <span>
                                Crear un Contribuyente
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
                                        <a href="{{ url('selectTaxPayer', $integration->taxpayer) }}" class="m-btn btn btn-secondary">
                                            <i class="la la-info text-info"></i>
                                        </a>

                                        {{-- @if ($favorites->contains('company_id', $integration->taxpayer_id)) --}}
                                            <a href="#" onclick="addFavorite({{ $integration->taxpayer_id }},0)" class="m-btn btn btn-secondary">
                                                <i class="la la-star text-warning"></i>
                                            </a>
                                        {{-- @else --}}
                                            {{-- <a href="#" onclick="addFavorite({{$integration->taxpayer_id}},1)" class="m-btn btn btn-secondary">
                                                <i class="la la-star-o text-warning"></i>
                                            </a>
                                        @endif --}}
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <!--begin:: Invitations-->
            <div class="m-portlet m-portlet--bordered-semi m-portlet--fit">
                <div class="row justify-content-center padding-40-5">
                    <div class="col-3">
                        <img src="/img/icons/invitation.svg" class="" alt="" width="135">
                    </div>
                    <div class="col-9">
                        <h3>Invitar a Alguien</h3>
                        <p>
                            <br>
                            ¿Quieres invitar alguien para que forme parte del equipo?
                            <br>
                            Miembros tienen accesso a todos los contribuyentes del equipo.
                        </p>
                        <form class="" action="index.html" method="post">
                            <div class="m-input-icon m-input-icon--left m-input-icon--right">
                                <input type="text" class="form-control m-input m-input--pill m-input--air" name="email" value="" placeholder="Correo Electronico del Invitado">
                                <span class="m-input-icon__icon m-input-icon__icon--left">
                                    <span>
                                        <i class="la la-envelope"></i>
                                    </span>
                                </span>
                                <span class="m-input-icon__icon m-input-icon__icon--right">
                                    <span>
                                        <button class="btn btn-outline-success m-btn m-btn--icon m-btn--icon-only m-btn--pill btn-inline-input" type="button" name="button">
                                            <i class="la la-send"></i>
                                        </button>
                                    </span>
                                </span>
                            </div>

                        </form>
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
                        <spark-team-settings :user="user" :team-id="user.current_team_id" inline-template>
                            <spark-team-members :user="user" :team="team" inline-template>
                                <div>
                                    <div class="m-widget4__item" v-for="member in team.users">
                                        <div class="m-widget4__img m-widget4__img--pic">
                                            <img :src="member.photo_url" alt="spark-profile-photo">
                                        </div>
                                        <div class="m-widget4__info">
                                            <span class="m-widget4__title">
                                                @{{ member.name }}
                                            </span>
                                        </div>
                                        <div class="m-widget4__ext">
                                            <a href="#" class="m-btn m-btn--pill m-btn--hover-brand btn btn-sm btn-secondary">
                                                @{{ teamMemberRole(member) }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </spark-team-members>
                        </spark-team-settings>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
