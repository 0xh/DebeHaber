<template>
    <div class="">
        <div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
                            <span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">Crear Empresa</h4>
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
                                    <button type="submit" data-dismiss="modal" class="btn btn-success store_empresa_ajax" v-on:click="onSave()"  >Guardar</button>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="input-group m-input-group">
                <span class="input-group-addon" id="basic-addon1">
                    <i class="fa fa-spinner fa-spin" v-if="loading"></i>
                    <template v-else>
                        <i class="fa fa-search" v-show="isEmpty"></i>
                        <i class="fa fa-times" v-show="isDirty" @click="reset"></i>
                    </template>
                </span>

                <input type="text"
                name ="contribuyente"
                class="form-control m-input"
                placeholder="Buscar"
                aria-describedby="basic-addon2"
                autocomplete="off"
                v-model="query"
                @keydown.down="down"
                @keydown.up="up"
                @keydown.enter="hit"
                @keydown.esc="reset"
                @blur="reset"
                @input="update"/>

                <span class="input-group-addon" id="basic-addon1">
                    {{ selectText }}
                </span>
                <span class="input-group-addon">
                    <a class="btn-icon-only" data-pk="1" data-target="#myModal1" data-title="Añadir" data-toggle="modal"
                    data-type="text" id="mostrar_modal_empresa" style="display: inline;">
                    <i class="fa fa-plus"></i>
                </a>
            </span>
        </div>
        <span class="m-form__help">
            <ul v-show="hasItems">
                <li v-for="(item, $item) in items" :class="activeClass($item)" @mousedown="hit" @mousemove="setActive($item)">
                    <span class="name" v-text="item.name"></span>
                    <span class="screen-name" v-text="item.screen_name"></span>
                </li>
            </ul>
        </span>
    </div>
</template>

<script>
import VueTypeahead from 'vue-typeahead'
import Vue from 'vue'
import Axios from 'axios'

Vue.prototype.$http = Axios

export default {
    extends: VueTypeahead,
    props: ['url','current_company'],
    data () {
        return {
            name:'',
            gov_code:'',
            address:'',
            email:'',
            telephone:'',
            src: this.url,
            limit: 5,
            minChars: 3,
            queryParamName: '',
            selectText:'Favor Elegir',
            id:''
        }
    },

    methods:
    {
        onHit (item)
        {
            var app = this  ;

            app.selectText = item.name + ' | ' + item.gov_code;
            app.id= item.id;

        },
        onSave()
        {
            axios({
                method: 'post',
                url: '/api/saveCompany/',
                responseType: 'json',
                data: {
                    name:this.name,
                    gov_code:this.gov_code,
                    address:this.address,
                    email:this.email,
                    telephone:this.telephone,
                }

            }).then(function (response)
            {


            })
            .catch(function (error)
            {
                console.log(error);
            });
        }
    }
}
</script>



<style scoped>

.fa-times
{
    cursor: pointer;
}

i
{
    float: right;
    position: relative;
    opacity: 0.4;
}

ul
{
    position: absolute;
    padding: 0;
    min-width: 100%;
    background-color: #fff;
    list-style: none;
    border-radius: 4px;
    box-shadow: 0 0 10px rgba(0,0,0, 0.25);
    z-index: 1000;
}

li
{
    padding: 5px;
    border-bottom: 1px solid #ccc;
    cursor: pointer;
}

li:first-child
{
    border-top-left-radius: 4px;
    border-top-right-radius: 4px;
}

li:last-child
{
    border-bottom-left-radius: 4px;
    border-bottom-right-radius: 4px;
    border-bottom: 0;
}

span
{
    color: #2c3e50;
}

.active
{
    background-color: #3aa373;
}

.active span
{
    color: white;
}

.name
{
    font-weight: 500;
    font-size: 14px;
}

.screen-name
{
    font-style: italic;
}
</style>
