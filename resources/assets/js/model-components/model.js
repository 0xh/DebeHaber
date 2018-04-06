var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

Vue.component('model',
{
    data() {
        return {
            showList : true,
        }
    }
});
