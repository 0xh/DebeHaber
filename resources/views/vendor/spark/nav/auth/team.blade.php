<div class="m-header-menu m-aside-header-menu-mobile m-aside-header-menu-mobile--offcanvas  m-header-menu--skin-light m-header-menu--submenu-skin-light m-aside-header-menu-mobile--skin-dark m-aside-header-menu-mobile--submenu-skin-dark ">
    <ul class="m-menu__nav">
        <li class="m-menu__item m-menu__item--rel">
            <a href="{{ route('hello') }}" class="m-menu__link m-menu__toggle">
                <span class="m-menu__item-here"></span>
                <i class="m-menu__link-icon la la-dashboard"></i>
                <span class="m-menu__link-text">
                    @lang('teams.team')
                </span>
            </a>
        </li>

        <li class="m-menu__item m-menu__item--rel">
            <a href="{{ route('hello') }}" class="m-menu__link m-menu__toggle">
                <span class="m-menu__item-here"></span>
                <i class="m-menu__link-icon la la-gear"></i>
                <span class="m-menu__link-text">
                    @lang('teams.team_settings')
                </span>
            </a>
        </li>
    </ul>
</div>