<template>
    <div class="">
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
                                <input type="text" v-model="taxid"/>
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

        <div class="input-group m-input-group">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1">
                    <i class="fa fa-spinner fa-spin" v-if="loading"></i>
                    <template v-else>
                        <i class="fa fa-search" v-show="isEmpty"></i>
                        <i class="fa fa-times" v-show="isDirty" @click="reset"></i>
                    </template>
                </span>
            </div>

            <input type="text"
            name ="contribuyente"
            class="form-control m-input"
            placeholder="Buscar"
            aria-describedby="basic-addon2"
            autocomplete="off"

            v-shortkey.once="['ctrl', 'n']"
            @shortkey="add()"

            v-model="query"
            @keydown.down="down"
            @keydown.up="up"
            @keydown.enter="hit"
            @keydown.esc="reset"
            @blur="reset"
            @input="update"/>

            <div class="input-group-append">
                <span class="input-group-text m--font-boldest" id="basic-addon1">
                    <a class="btn-icon-only" data-pk="1" data-target="#myModal1" data-title="Añadir" data-toggle="modal" data-type="text">
                        <i class="la la-plus"></i>
                    </a>
                    @{{ selectText }}
                </span>
            </div>
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

var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
Vue.prototype.$http = Axios

export default {
    extends: VueTypeahead,
    props: ['taxpayer','url', 'cycle'],
    data () {
        return {
            name:'',
            taxid:'',
            address:'',
            email:'',
            code:'',
            telephone:'',
            src: '/api/' + this.current_company + '/get_taxpayers/',
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
            var app = this;

            app.selectText = item.name + ' | ' + item.taxid;
            app.id = item.id;

            $.ajax(
                {
                    url: '/api/' + this.current_company + '/' + this.cycle + '/commercial'  + this.url,
                    headers: {'X-CSRF-TOKEN': CSRF_TOKEN},
                    type: 'get',
                    dataType: 'json',
                    async: false,
                    success: function(data)
                    {
                        app.$parent.code = data.code;
                        app.$parent.code_expiry = data.code_expiry;
                        app.$parent.currency_id = data.currency_id;
                        app.$parent.payment_condition = data.payment_condition;
                        app.$parent.chart_account_id = data.chart_account_id;
                        if (data.details != null) {
                            if (data.details[0] != null) {
                                app.$parent.details.push({ id:0, value:0, chart_vat_id:data.details[0].chart_vat_id, chart_id:data.details[0].chart_id, vat:0, totalvat:0, withoutvat:0 })
                            }
                        }
                    },
                    error: function(xhr, status, error)
                    {
                        console.log(xhr.responseText);
                    }
                });
            },

            onSave()
            {
                $.ajax({
                    url: '/api/' + this.current_company + '/store-taxpayer',
                    headers: {'X-CSRF-TOKEN': CSRF_TOKEN},
                    type: 'post',
                    data:{
                        name : this.name,
                        code : this.code,
                        taxid : this.taxid,
                        address : this.address,
                        email : this.email,
                        telephone : this.telephone,
                    },
                    dataType: 'json',
                    async: false,
                    success: function(data)
                    {
                        //console.log(data);
                    },
                    error: function(xhr, status, error)
                    {
                        console.log(xhr.responseText);
                    }
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
