
    <div>
        <div class="row">
            <div class="col-2">
                <span class="m--font-boldest">
                    @lang('accounting.ChartVersion')
                </span>
            </div>
            <div class="col-2">
                <span class="m--font-boldest">
                    @lang('global.Year')
                </span>
            </div>
            <div class="col-2">
                <span class="m--font-boldest">
                    @lang('global.StartDate')
                </span>
            </div>
            <div class="col-2">
                <span class="m--font-boldest">
                    @lang('global.EndDate')
                </span>
            </div>
            <div class="col-2">
                <span class="m--font-boldest">
                    @lang('global.Action')
                </span>
            </div>
        </div>
        <hr>
        <div class="row" v-for="data in list">
            <div class="col-2">
                @{{ data.chart_version_name }}
            </div>
            <div class="col-2">
                @{{ data.year }}
            </div>
            <div class="col-2">
                @{{ data.start_date }}
            </div>
            <div class="col-2">
                @{{ data.end_date }}
            </div>
            <div class="col-1">

                <button v-on:click="onEdit(data)" class="btn btn-outline-pencil m-btn m-btn--icon btn-sm m-btn--icon-only m-btn--pill m-btn--air">
                    <i class="la la-pencil"></i>
                </button>
            </div>
        </div>
    </div>
