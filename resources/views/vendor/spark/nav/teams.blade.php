<!-- Teams -->

<li class="m-nav__section m--hide">
    <span class="m-nav__section-text">
        {{ __('teams.teams')}}
    </span>
</li>

<!-- Create Team -->
@if (Spark::createsAdditionalTeams())
    <li class="m-nav__item">
        <a href="/settings#/{{Spark::teamsPrefix()}}" class="m-nav__link">
            <i class="m-nav__link-icon la la-plus-circle"></i>
            <span class="m-nav__link-title">
                <span class="m-nav__link-wrap">
                    <span class="m-nav__link-text m--font-metal">
                        {{__('teams.create_team')}}
                    </span>
                </span>
            </span>
        </a>
    </li>
@endif

<!-- Switch Current Team -->
@if (Spark::showsTeamSwitcher())
    <li class="m-nav__item" v-for="team in teams">
        <a :href="'/settings/{{ Spark::teamsPrefix() }}/'+ team.id +'/switch'" class="m-nav__link">
            <i class="m-nav__link-icon la la-users"></i>
            <span class="m-nav__link-title">
                <span class="m-nav__link-wrap">
                    <span v-if="user.current_team_id == team.id" class="m-nav__link-text m--font-info">
                        @{{ team.name }}
                    </span>
                    <span v-else>
                        @{{ team.name }}
                    </span>
                </span>
            </span>
        </a>
    </li>
@endif

<div class="dropdown-divider"></div>
