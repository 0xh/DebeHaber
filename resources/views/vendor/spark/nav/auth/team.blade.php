<div class="m-header-menu m-aside-header-menu-mobile m-aside-header-menu-mobile--offcanvas  m-header-menu--skin-light m-header-menu--submenu-skin-light m-aside-header-menu-mobile--skin-dark m-aside-header-menu-mobile--submenu-skin-dark ">
    <ul class="m-menu__nav">
        <li class="m-menu__item m-menu__item--rel">
            <a href="{{ route('home') }}" class="m-menu__link m-menu__toggle">
                <span class="m-menu__item-here"></span>
                <i class="m-menu__link-icon la la-home"></i>
                <span class="m-menu__link-text" v-for="team in teams">
                    <span v-if="user.current_team_id == team.id">
                        @{{ team.name }}
                    </span>
                </span>
            </a>
        </li>
    </ul>
</div>
