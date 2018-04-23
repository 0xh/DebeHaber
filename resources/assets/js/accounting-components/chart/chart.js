
var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
import Vue from 'vue';
import VueSweetAlert from 'vue-sweetalert';

Vue.use(VueSweetAlert);

Vue.component('chart',{

    props: ['taxpayer','cycle'],
    data() {
        return {
            id : 0,
            parent_id : '',
            chart_version_id : '',
            country : '',
            is_accountable : '',
            code : '',
            name : '',
            level :  '',
            type : '',
            sub_type : '',
            coefficient : '',
            canChange : true,
            list: [
                // id:0
                // chart_version_id
                // chart_version_name
                // country
                // is_accountable
                // code
                // name
                // level
                // type
                // sub_type
            ],
            chartversions : [],
            accounts : []
        }
    },

    methods:
    {
        //Takes Json and uploads it into Sales INvoice API for inserting. Since this is a new, it should directly insert without checking.
        //For updates code will be different and should use the ID's palced int he Json.
        onSave: function(json)
        {
          console.log(json);
            var app = this;
            var api = null;

            app.parent_id = app.$children[0].id;

            if (app.code == '')
            {
                app.$swal('Please Check fields?',
                'code',
                'warning'
            );
            return;
        }
        if (app.name == '')
        {
            app.$swal('Please fill name...');
            return;
        }
        if (app.type == 0)
        {
            app.$swal('Please Select Type...');
            return;
        }
        if (app.is_accountable && app.sub_type == 0)
        {
            app.$swal('Please Select Sub Type...');
            return;
        }
        $.ajax({
            url : '',
            headers : {'X-CSRF-TOKEN': CSRF_TOKEN},
            type : 'post',
            data : json,
            dataType : 'json',
            async : false,
            success: function(data)
            {
                console.log(data);
                if (data == 200)
                {
                    app.id = 0;
                    app.parent_id = null;
                    app.chart_version_id = null;
                    app.country = null;
                    app.is_accountable = null;
                    app.code = null;
                    app.name = null;
                    app.level = null;
                    app.type = null;
                    app.sub_type = null;
                    app.coefficient = null;
                    app.$parent.$parent.showList = 1;
                    //app.init();
                }
                else
                {
                    alert('Something Went Wrong...')
                }
            },
            error: function(xhr, status, error)
            {
                app.$swal('Something went wrong, check logs...' + error);
                console.log(xhr.responseText);
            }
        });
    },

    onEdit: function(data)
    {

        var app = this;
        app.id = data.id;
        app.parent_id = data.parent_id;
        app.chart_version_id = data.chart_version_id;
        app.country = data.country;
        app.is_accountable = data.is_accountable;
        app.code = data.code;
        app.name = data.name;
        app.level = data.level;
        app.type = data.type;
        app.sub_type = data.sub_type;
        app.coefficient = data.coefficient;
        app.$children[0].selectText=data.name;
    },
    onDelete: function(data)
    {
        swal({
            title: 'Delete "' + data.name + '"',
            text: 'Please select another chart to merge all transactions from the current chart.',
            html: '<input id="swal-input1" class="swal2-input">',
            input: 'text',
            showCancelButton: true,
            confirmButtonText: 'Merge',
            showLoaderOnConfirm: true,
            preConfirm: (email) => {
                return new Promise((resolve) => {
                    setTimeout(() => {
                        if (email === 'taken@example.com') {
                            swal.showValidationError(
                                'This email is already taken.'
                            )
                        }
                        resolve()
                    }, 2000)
                })
            },
            allowOutsideClick: () => !swal.isLoading()
        }).then((result) => {
            if (result.value) {
                swal({
                    type: 'success',
                    title: 'Ajax request finished!',
                    html: 'Submitted email: ' + result.value
                })
            }
        })
    }
},

mounted: function mounted()
{
    //    this.init();
}
});
