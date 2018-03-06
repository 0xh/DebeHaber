<template>
    <div>
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
            placeholder=""

            aria-describedby="basic-addon2"
            autocomplete="off"

            v-shortkey.once="['alt', 'n']"
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
                    {{ selectText }}  {{ $t('global.Search') }}
                </span>
            </div>
        </div>

        <span class="m-form__help">
            If this is a top level account, keep this field blank, or else please select it's parent.
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
    props: ['url', 'current_company', 'cycle', 'controlName'],
    data () {
        return {
            name:'',
            code:'',
            chart_version_name:'',

            src: '/api/' + this.current_company + '/' + this.cycle + this.url,
            limit: 5,
            minChars: 3,
            queryParamName: '',
            selectText:'...',
            id:'',
            children:[]
        }
    },

    methods:
    {
        onHit (item)
        {
            var app = this;

            app.selectText = item.code + ' | ' + item.name;

            app.id = item.id;
            app.children = item.children;
            app.$parent.code = item.code + '.0' + (Number(item.children.length) + 1);
            app.$parent.type = item.type;
            app.$parent.canChange = false;
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
