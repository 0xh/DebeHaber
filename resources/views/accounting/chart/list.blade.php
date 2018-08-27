<meta name="csrf-token" content="{{ csrf_token() }}">
<div>
    <div class="row">
        <div class="col-2">
            @lang('global.Code')
        </div>

        <div class="col-5">
            <span class="m--font-boldest">
                @lang('accounting.Accounts')
            </span>
        </div>
        <div class="col-2">

        </div>

        <div class="col-3">
            <span class="m--font-boldest">
                @lang('global.Action')
            </span>
        </div>
    </div>

    <div class="row m--margin-15 m--valign-middle" v-for="data in list">
        <div class="col-2 m--align-left">
            <span v-if="data.type == 1" class="m-badge m-badge--info m-badge--wide m-badge--rounded">
                <b>@{{ data.code }}</b>
            </span>
            <span v-else-if="data.type == 2" class="m-badge m-badge--brand m-badge--wide m-badge--rounded">
                <b>@{{ data.code }}</b>
            </span>
            <span v-else-if="data.type == 3" class="m-badge m-badge--warning m-badge--wide m-badge--rounded">
                <b>@{{ data.code }}</b>
            </span>
            <span v-else-if="data.type == 4" class="m-badge m-badge--success m-badge--wide m-badge--rounded">
                <b>@{{ data.code }}</b>
            </span>
            <span v-else-if="data.type == 5" class="m-badge m-badge--danger m-badge--wide m-badge--rounded">
                <b>@{{ data.code }}</b>
            </span>
        </div>

        <div class="col-5 m--valign-middle">
            <span v-if="data.is_accountable" class="m--font-bolder">
                @{{ data.name }}
            </span>
            <span v-else class="m--font-bolder m--font-metal m--font-transform-u">
                @{{ data.name }}
            </span>
        </div>

        <div class="col-2 m--valign-middle">
            <p>
                <span v-if="data.is_accountable" class="m--font-info">
                    @lang('accounting.IsAccountable')
                </span>
            </p>
        </div>
        <div class="col-3 m--valign-middle">
            <div v-if="data.taxpayer_id != null" class="m-btn-group btn-group-sm m-btn-group--pill btn-group" role="group" aria-label="...">
                <button @click="onView(data)" class="m-btn btn btn-default"><i class="la la-eye m--font-success"></i></button>
                <button @click="onEdit(data.id)" class="m-btn btn btn-default"><i class="la la-pencil m--font-info"></i></button>
                <button @click="onDeleteAccount(data)" class="m-btn btn btn-default"><i class="la la-trash m--font-danger"></i></button>
            </div>
        </div>
    </div>


    <b-modal :active.sync="isActive">
        <mergechart :taxpayer="{{ request()->route('taxPayer')->id }}" :cycle="{{ request()->route('cycle')->id }}" :chart2delete="item" inline-template>
            <div class="m--margin-15">
                <!--begin::Form-->
                <div class="m-portlet__body m--align-center">
                    <img src="/img/icons/trash.svg" width="128" height="128" alt="" class="m--margin-25">

                    <p class="lead">Delete & Transfer</p>

                    <p>
                        Since accounts are used in many locations,
                        before deleting it is important to merge all transactions into a another account.
                        Use this window to help guide
                    </p>

                    <hr>

                    <div class="form-group m-form__group row">
                        <label class="col-4 m--align-right">
                            @lang('global.DeleteModel')
                        </label>

                        <div class="col-8 m--align-left">
                            <span v-if="chart2delete.type == 1" class="m-badge m-badge--info m-badge--wide m-badge--rounded">
                                <b>@{{ chart2delete.code }}</b>
                            </span>
                            <span v-else-if="chart2delete.type == 2" class="m-badge m-badge--brand m-badge--wide m-badge--rounded">
                                <b>@{{ chart2delete.code }}</b>
                            </span>
                            <span v-else-if="chart2delete.type == 3" class="m-badge m-badge--warning m-badge--wide m-badge--rounded">
                                <b>@{{ chart2delete.code }}</b>
                            </span>
                            <span v-else-if="chart2delete.type == 4" class="m-badge m-badge--success m-badge--wide m-badge--rounded">
                                <b>@{{ chart2delete.code }}</b>
                            </span>
                            <span v-else-if="chart2delete.type == 5" class="m-badge m-badge--danger m-badge--wide m-badge--rounded">
                                <b>@{{ chart2delete.code }}</b>
                            </span>
                            |
                            <b> @{{ chart2delete.name }} </b>
                        </div>
                    </div>

                    <b-message v-if="deleteFailed" type="is-warning">
                        This account has been used in other parts of DebeHaber, and due to this, it is necesary that you merge the transactions into another account.
                    </b-message>

                    <div v-if="deleteFailed" class="form-group m-form__group row">
                        <label class="col-4 m--align-right">
                            @lang('global.ToAccount')
                        </label>
                        <div class="col-8 m--align-left">
                            <router-view name="SearchBoxAccount" url="/accounting/chart/get-accountables/" :cycle="{{ request()->route('cycle')->id }}" :current_company="{{ request()->route('taxPayer')->id }}" ></router-view>
                        </div>
                    </div>
                </div>

                <div class="m-portlet__foot m-portlet__foot--fit m--align-center">
                    <button v-if="deleteFailed == false" v-on:click="tryDelete($data)" class="btn btn-danger">
                        @lang('global.Delete')
                    </button>
                    <button v-else v-on:click="tryMerge($data)" class="btn btn-warning">
                        @lang('global.Merge')
                    </button>
                    <button v-on:click="onCancel()" class="btn btn-secondary">@lang('global.Cancel')</button>
                </div>
            </div>
        </mergechart>
    </b-modal>
 
</div>
