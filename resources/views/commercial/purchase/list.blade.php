<vuetable ref="vuetable"
    api-url="/api/get_sales/3"
    :fields="fields"
    :sort-order="sortOrder"
    :css="css.table"
    pagination-path=""
    :per-page="3"
    @vuetable:pagination-data="onPaginationData"
    @vuetable:loading="onLoading"
    @vuetable:loaded="onLoaded"
  >
    <template slot="actions" scope="props">
      <div class="table-button-container">
          <button class="btn btn-warning btn-sm" @click="editRow(props.rowData)">
            <span class="glyphicon glyphicon-pencil"></span> Edit</button>&nbsp;&nbsp;
          <button class="btn btn-danger btn-sm" @click="deleteRow(props.rowData)">
            <span class="glyphicon glyphicon-trash"></span> Delete</button>&nbsp;&nbsp;
      </div>
      </template>
    </vuetable>
    <vuetable-pagination ref="pagination"
      :css="css.pagination"
      @vuetable-pagination:change-page="onChangePage"
    ></vuetable-pagination>
