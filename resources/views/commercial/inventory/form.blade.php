
<meta name="csrf-token" content="{{ csrf_token() }}">

<inventory-form :trantype ="1" :taxpayer="{{ request()->route('taxPayer')->id}}" :charts= {{ $charts }}  inline-template>
  <div>
    <div class="row">
      <div class="col-6">
        <div class="form-group m-form__group row">
          <label for="example-text-input" class="col-4 col-form-label">
            Fecha de Fact.
          </label>
          <div class="col-8">
            <input type="date" class="form-control" v-model="date" />
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
              <option v-for="chart in charts" :value="chart.id">@{{ chart.name }}</option>
            </select>
          </div>
        </div>
        <div class="form-group m-form__group row">
          <label for="example-text-input" class="col-4 col-form-label">
            Current Value
          </label>
          <div class="col-8">
            <input type="date" class="form-control" v-model="date" />
          </div>
        </div>

      </div>



    </div>

    <hr>

    <button v-on:click="onSave($data,false,'/current/{{request()->route('company') }}/sales')" class="btn btn-primary">
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
