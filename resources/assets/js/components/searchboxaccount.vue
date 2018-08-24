<template>
    <div>
        <div class="input-group m-input-group">

            <div v-if="selectText != ''" class="input-group-prepend">
                <span class="input-group-text m--font-boldest">
                    {{ selectText }}
                </span>
            </div>

            <input type="text"
            name ="chartOfAccounts"
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
                <span class="input-group-text" id="basic-addon1">
                    <i v-if="loading" class="fa fa-spinner fa-spin"></i>
                    <template v-else>
                        <i class="fa fa-search" v-show="isEmpty"></i>
                        <i class="fa fa-times" v-show="isDirty" @click="reset"></i>
                    </template>
                </span>
            </div>
        </div>
        <ul v-show="hasItems">
            <li v-for="(item, $item) in items" :class="activeClass($item)" @mousedown="hit" @mousemove="setActive($item)">
                <span class="strong" v-text="item.code"></span>
                <span>|</span>
                <span v-text="item.name"></span>
            </li>
        </ul>
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
    border-bottom: 1px solid whitesmoke;
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
    background-color: #734cea;
}

.active span
{
    color: white;
}

.strong
{
    font-weight: 800;
    font-style: italic;
}
</style>
