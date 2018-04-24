
<meta name="csrf-token" content="{{ csrf_token() }}">

<inventory-form trantype ="1" taxpayer="{{ request()->route('taxPayer')->id}}"  cycle="{{ request()->route('cycle')->id }}" :charts= "{{ $charts }}"  inline-template>
  <div>
    <div class="row">
      <div class="col-6">
        <div class="form-group m-form__group row">
          <label for="example-text-input" class="col-4 col-form-label">
            Start Date
          </label>
          <div class="col-8">
            <input type="date" class="form-control" v-model="start_date" />
          </div>
        </div>
        <div class="form-group m-form__group row">
          <label for="example-text-input" class="col-4 col-form-label">
            End Date
          </label>
          <div class="col-8">
            <input type="date" class="form-control" v-model="end_date" />
          </div>
        </div>

      </div>
      <div class="col-6">
        <div class="form-group m-form__group row">
          <label class="col-lg-2 col-form-label">
            @lang('global.Charts'):
          </label>
          <div class="col-lg-6">
            <select v-model="chart_id" required class="custom-select"  >
              <option v-for="chart in charts" v-bind:value="chart.id">@{{ chart.name }}</option>
            </select>
          </div>
        </div>


      </div>
      <div v-for="types in charttypes">
        <div class="col-8">
          <input  type="checkbox" v-bind:value="types.id" class="form-control" v-model="selectcharttype">@{{ types.name }}</input>
        </div>
      </div>


    </div>
    <button v-on:click="onCalculate($data,false)" class="btn btn-primary">
      Calculate
    </button>
    <hr>

    <div class="form-group m-form__group row">
      <label for="example-text-input" class="col-4 col-form-label">
        Inventory Value
      </label>
      <div class="col-8">
        <input type="number" class="form-control" v-model="inventory_value" />
      </div>
    </div>
    <div class="form-group m-form__group row">
      <label for="example-text-input" class="col-4 col-form-label">
        Sales Value
      </label>
      <div class="col-8">
        @{{sales_value}}
      </div>
    </div>
    <div class="form-group m-form__group row">
      <label for="example-text-input" class="col-4 col-form-label">
        Margin Value
      </label>
      <div class="col-8">
        <input type="number" class="form-control" v-model="margin" />
      </div>
    </div>
    <div class="form-group m-form__group row">
      <label for="example-text-input" class="col-4 col-form-label">
        Cost Value
      </label>
      <div class="col-8">
        <input type="number" class="form-control" v-model="cost_value" />
      </div>
    </div>
    <hr>

    <button v-on:click="onSave($data,false)" class="btn btn-primary">
      Guardar
    </button>
    <button v-on:click="onSave($data,true,'')" class="btn btn-primary">
      Guardar & New
    </button>
    <button v-on:click="cancel()" class="btn btn-default">
      Cancelar
    </button>
  </div>
</inventory-form>
