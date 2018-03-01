<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Crear Contribuyente</h4>
            </div>
            <div class="modal-body">
                <div class="form-group m-form__group row">
                    <label class="col-lg-3 col-form-label">
                        Nombre
                    </label>
                    <div class="col-lg-7">
                        <input type="text" v-model="name"/>
                    </div>
                </div>
                <div class="form-group m-form__group row">
                    <label class="col-lg-3 col-form-label">
                        Code
                    </label>
                    <div class="col-lg-7">
                        <input type="text" v-model="code"/>
                    </div>
                </div>

                <div class="form-group m-form__group row">
                    <label class="col-lg-3 col-form-label">
                        RUC
                    </label>
                    <div class="col-lg-7">
                        <input type="text" v-model="gov_code"/>
                    </div>
                </div>

                <div class="form-group m-form__group row">
                    <label class="col-lg-3 col-form-label">
                        Dirección
                    </label>
                    <div class="col-lg-7">
                        <textarea  v-model="address"/>
                    </div>
                </div>

                <div class="form-group m-form__group row">
                    <label class="col-lg-3 col-form-label">
                        Correo
                    </label>
                    <div class="col-lg-7">
                        <input type="text" v-model="email"/>
                    </div>
                </div>

                <div class="form-group m-form__group row">
                    <label class="col-lg-3 col-form-label">
                        Teléfono
                    </label>
                    <div class="col-lg-7">
                        <input type="text" v-model="telephone"/>
                    </div>
                </div>
                <div class="form-group">

                    <div class="col-sm-7">
                        <button type="submit" data-dismiss="modal" class="btn btn-success" v-on:click="onSave()">
                            Guardar
                        </button>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
