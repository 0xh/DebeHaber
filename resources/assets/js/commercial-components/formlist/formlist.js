var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
import Vue from 'vue';
import VueSweetAlert from 'vue-sweetalert';

Vue.use(VueSweetAlert);

Vue.component('form-list',
{
    data() {
        return {
            status : 0
        }
    },
    created() {

    },
    onDelete: function(data)
    {
        //SweetAlert message and confirmation.
        $.ajax({
            url: '/api/' + this.taxpayer + '/' + this.cycle + '/commercial/' + this.url + '/delete/' + data.ID,
            headers: {'X-CSRF-TOKEN': CSRF_TOKEN},
            type: 'delete',
            dataType: 'json',
            async: true,
            success: function(data)
            {
                if (data == 'ok')
                {
                    app.onReset(isnew);
                }
                else
                {
                    alert('Something Went Wrong...')
                }
            },
            error: function(xhr, status, error)
            {
                console.log(xhr.responseText);
            }
        });
    },
});
