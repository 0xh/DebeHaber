<!-- Notifications Modal -->
<spark-notifications
:notifications="notifications"
:has-unread-announcements="hasUnreadAnnouncements"
:loading-notifications="loadingNotifications" inline-template>

<div v-if="$parent.showingNotificationPanel" class="m-quick-sidebar m-quick-sidebar--tabbed m-quick-sidebar--skin-light m-quick-sidebar--on" style="">
    <div class="m-quick-sidebar__content">
        <span @click="$parent.showingNotificationPanel = false" class="m-quick-sidebar__close">
            <i class="la la-close"></i>
        </span>

        <b-tabs>
            <b-tab-item label="{{ __('Notifications') }}">
                <div class="m-list-timeline m-scrollable ps ps--active-y">
                    <div class="m-list-timeline__group">
                        <div class="m-list-timeline__heading">
                            {{ __('Messeges') }}
                        </div>
                        <div class="m-timeline-3">
                            <div class="m-timeline-3__items" v-for="notification in notifications.notifications">
                                <div class="m-timeline-3__item m-timeline-3__item--info">
                                    <span class="m-timeline-3__item-time">
                                        <p class="small">@{{ notification.created_at | relative }}</p>
                                    </span>
                                    <div class="m-timeline-3__item-desc">
                                        <span class="m-timeline-3__item-text">
                                            <p class="small">
                                                @{{ notification.body }}
                                                <a v-if="notification.action_text" :href="notification.action_url">More Info</a>
                                            </p>
                                        </span>
                                        {{-- <br> --}}
                                        <span class="m-timeline-3__item-user-name">
                                            <a href="#" class="m-link m-link--metal m-timeline-3__item-link">
                                                By DebeHaber
                                            </a>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="ps__rail-x" style="left: 0px; bottom: 0px;">
                        <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>
                    </div>
                    <div class="ps__rail-y" style="top: 0px; right: 4px; height: 349px;">
                        <div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 118px;"></div>
                    </div>
                </div>
            </b-tab-item>

            <b-tab-item label="{{ __('Announcements') }}">
                <div class="m-list-timeline m-scrollable ps ps--active-y">
                    <div class="m-list-timeline__group">
                        <div class="m-list-timeline__heading">
                            {{ __('Team') }} DebeHaber,
                        </div>
                        <div class="m-list-timeline__items">
                            <div class="m-list-timeline__item" v-for="announcement in notifications.announcements">
                                <span class="m-list-timeline__badge m-list-timeline__badge--state-success"></span>
                                <span class="m-list-timeline__text">
                                    <p>@{{ announcement.body }}</p>
                                    <a v-if="announcement.action_text" :href="announcement.action_url">
                                        More Info
                                    </a>
                                </span>
                                <span class="m-list-timeline__time">@{{ announcement.created_at | relative }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="ps__rail-x" style="left: 0px; bottom: 0px;">
                        <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>
                    </div>
                    <div class="ps__rail-y" style="top: 0px; right: 4px; height: 349px;">
                        <div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 118px;"></div>
                    </div>
                </div>
            </b-tab-item>
        </b-tabs>
    </div>
</div>
</spark-notifications>
