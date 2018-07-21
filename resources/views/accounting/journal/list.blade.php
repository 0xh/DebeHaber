<meta name="csrf-token" content="{{ csrf_token() }}">

<div>
  <b-table :data="list" hoverable
  detailed
  detail-key="id"
  @details-open="(row, index) => $toast.open(`Expanded ${row.comment}`)">
  <template slot-scope="props">
    <b-table-column field="id" label="ID">
      @{{ props.row.id }} | @{{ props.row.date }}
    </b-table-column>

    <b-table-column field="number" label="Number">
      @{{ props.row.number }}
    </b-table-column>

    <b-table-column field="comment" label="Comment">
      @{{ props.row.comment }}

    </b-table-column>



    <b-table-column custom-key="actions">

      <button v-on:click="onEdit(props.row.id)" type="button" class="btn btn-sm btn-secondary js-tooltip-enabled" data-toggle="tooltip" data-original-title="Delete">
        <i class="la la-pencil m--font-brand"></i>
      </button>
      <button v-on:click="onDelete(props.row)" type="button" class="btn btn-sm btn-secondary js-tooltip-enabled" data-toggle="tooltip" data-original-title="Delete">
        <i class="fa fa-trash"></i>
      </button>

    </b-table-column>
  </template>
  <template slot="detail" slot-scope="props">


<div class="media-content">
   <div class="content">
       <p>
         <div class="row" v-for="detail in props.row.details">
           <div class="col-8">
             <p v-if="detail.chart !=null"> @{{ detail.chart.code }} | <span class="m--font-bold">@{{ detail.chart.name }}</span> </p>
           </div>
           <div class="col-2 m--align-right">
             <p v-if="detail.credit > 0" class="m--font-bold "> @{{ new Number(detail.credit).toLocaleString() }} </p>
             <p v-else class="m--font-metal"> - </p>
           </div>
           <div class="col-2 m--align-right">
             <p v-if="detail.debit > 0" class="m--font-bold "> @{{ new Number(detail.debit).toLocaleString() }} </p>
             <p v-else class="m--font-metal"> - </p>
           </div>
       </p>
   </div>
</div>
          


    </template>
    </b-table>
    <b-pagination :total="meta.total" :current.sync="meta.current_page" :simple="false" :per-page="meta.per_page" @change="pageChange"> </b-pagination>
    {{-- <div class="row">
    <div class="col-8">
    <p class="m--font-boldest m--font-transform-u">@lang('accounting.ChartofAccounts')</p>
  </div>
  <div class="col-2">
  <p class="m--align-right m--font-boldest m--font-transform-u">@lang('accounting.Credit')</p>
</div>
<div class="col-2">
<p class="m--align-right m--font-boldest m--font-transform-u">@lang('accounting.Debit')</p>
</div>
</div>

<div class="m--margin-bottom-5" v-for="journal in list">
<div class="row">
<div class="col-2">
<p> @{{ journal.id }} | @{{ journal.date }} </p>
</div>

<div class="col-1">
<p> @{{ journal.number }} </p>
</div>

<div class="col-7">
<p class="m--font-bolder"> @{{ journal.comment }} </p>
</div>

<div class="col-2">
<div class="m-btn-group btn-group-sm m-btn-group--pill btn-group" role="group" aria-label="...">
<a class="m-btn btn btn-secondary"><i class="la la-check m--font-success"></i></a>
<a @click="onEdit(journal.id)" class="m-btn btn btn-secondary"><i class="la la-pencil m--font-brand"></i></a>
<a @click="onDelete(journal)" class="m-btn btn btn-secondary"><i class="la la-trash m--font-danger"></i></a>
</div>
</div>
</div>
<div class="row" v-for="detail in journal.details">
<div class="col-8">
<p> @{{ detail.chart.code }} | <span class="m--font-bold">@{{ detail.chart.name }}</span> </p>
</div>
<div class="col-2 m--align-right">
<p v-if="detail.credit > 0" class="m--font-bold "> @{{ new Number(detail.credit).toLocaleString() }} </p>
<p v-else class="m--font-metal"> - </p>
</div>
<div class="col-2 m--align-right">
<p v-if="detail.debit > 0" class="m--font-bold "> @{{ new Number(detail.debit).toLocaleString() }} </p>
<p v-else class="m--font-metal"> - </p>
</div>
</div>
</div>

<infinite-loading force-use-infinite-wrapper="true" @infinite="infiniteHandler">
<span slot="no-more">
No more data
</span>
</infinite-loading> --}}
</div>
