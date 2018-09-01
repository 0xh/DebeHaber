<!-- Notifications Modal -->
<spark-notifications
:notifications="notifications"
:has-unread-announcements="hasUnreadAnnouncements"
:loading-notifications="loadingNotifications" inline-template>

<b-modal :active.sync="$parent.showingNotificationPanel" canCancel scroll="keep">
    <div class="modal-content" class="m--margin-50">
        <div class="modal-header text-center">
            <div class="btn-group">
                <button class="btn btn-light" :class="{'active': showingNotifications}" @click="showNotifications" style="width: 50%;">
                    <i class="fa fa-circle text-danger p-l-xs" v-if="hasUnreadNotifications"></i> {{__('Notifications')}}
                </button>

                <button class="btn btn-light" :class="{'active': showingAnnouncements}" @click="showAnnouncements" style="width: 50%;">
                    <i class="fa fa-circle text-danger p-l-xs" v-if="hasUnreadAnnouncements"></i> {{__('Announcements')}}
                </button>
            </div>
        </div>

        <div class="modal-body">
            <!-- Informational Messages -->
            <div class="notification-container" v-if="loadingNotifications">
                <i class="fa fa-btn fa-spinner fa-spin"></i> {{__('Loading Notifications')}}
            </div>

            <div class="notification-container" v-if=" ! loadingNotifications && activeNotifications.length == 0">
                <div class="alert alert-warning m-b-none">
                    {{__('We don\'t have anything to show you right now! But when we do, we\'ll be sure to let you know. Talk to you soon!')}}
                </div>
            </div>

            <!-- List Of Notifications -->
            <div class="notification-container" v-if="showingNotifications && hasNotifications">
                <div class="notification" v-for="notification in notifications.notifications">

                    <!-- Notification -->
                    <div class="notification-content">
                        <div class="notification-content">
                            <div class="notification-body" v-html="notification.parsed_body"></div>

                            <!-- Announcement Action -->
                            <a :href="notification.action_url" v-if="notification.action_text">
                                @{{ notification.action_text }}
                            </a>

                            <small>
                                @{{ notification.created_at | relative }} | <i>{{ Spark::product() }}</i>
                            </small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- List Of Announcements -->
            <div class="notification-container" v-if="showingAnnouncements && hasAnnouncements">
                <div class="notification" v-for="announcement in notifications.announcements">
                    <!-- Notification Icon -->


                    <!-- Announcement -->
                    <div class="notification-content">
                        <div class="notification-body" v-html="announcement.parsed_body"></div>

                        <!-- Announcement Action -->
                        <a :href="announcement.action_url" class="btn btn-primary" v-if="announcement.action_text">
                            <p class="lead">
                                @{{ announcement.action_text }}
                            </p>
                        </a>
                        <small>
                            @{{ announcement.created_at | relative }} | <i>{{ Spark::product() }}</i>
                            {{-- <i>@{{ announcement.creator.name }}</i> --}}
                        </small>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Modal Actions -->
        {{-- <div class="modal-footer"> --}}
        <button type="button" @click="$parent.showingNotificationPanel = false" class="btn btn-default" data-dismiss="modal">
            {{__('Close')}}
        </button>
        {{-- </div> --}}
    </div>
</b-modal>

</spark-notifications>
