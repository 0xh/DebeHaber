
<li class="m-nav__item" v-for="team in teams">
    <a v-if="user.current_team_id == team.id" :href="'/settings/{{ Spark::teamsPrefix() }}/'+ team.id" class="m-nav__link">
        <i class="m-nav__link-icon la la-home"></i>
        <span class="m-nav__link-title">
            <span class="m-nav__link-wrap">
                <span class="m-nav__link-text">
                    @{{ team.name }}
                </span>
            </span>
        </span>
    </a>
</li>

<div class="dropdown-divider"></div>
