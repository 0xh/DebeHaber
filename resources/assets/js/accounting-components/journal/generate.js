
var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
import VueSweetAlert from 'vue-sweetalert';

Vue.component('journal-generate',{
    props: ['taxpayer','cycle'],
    data() {
        return {
            pickerOptions2: {
                shortcuts: [{
                    text: 'Semana',
                    onClick(picker) {
                        const end = new Date();
                        const start = new Date();
                        start.setTime(start.getTime() - 3600 * 1000 * 24 * 7);
                        picker.$emit('pick', [start, end]);
                    }
                }, {
                    text: 'Mes',
                    onClick(picker) {
                        const end = new Date();
                        const start = new Date();
                        start.setTime(start.getTime() - 3600 * 1000 * 24 * 30);
                        picker.$emit('pick', [start, end]);
                    }
                }, {
                    text: 'Año',
                    onClick(picker) {
                        const end = new Date();
                        const start = new Date();
                        start.setTime(start.getTime() - 3600 * 1000 * 24 * 365);
                        picker.$emit('pick', [start, end]);
                    }
                }]
            },
            dateRange: [moment().subtract(1, 'months').startOf('month').format("YYYY-MM-DD"),
            moment().subtract(1, 'months').endOf('month').format("YYYY-MM-DD")]
        };
    },


    methods:
    {
        //Takes Json and uploads it into Sales INvoice API for inserting. Since this is a new, it should directly insert without checking.
        //For updates code will be different and should use the ID's palced int he Json.
        onSave: function(json)
        {
            var app = this;
            var api = null;
            swal({
                title: 'Generate General',
                html: '<el-date-picker v-model="dateRange" type="daterange" align="right" unlink-panels range-separator="|" start-placeholder="StartDate" end-placeholder="EndDate" format = "dd/MM/yyyy" value-format = "yyyy-MM-dd" :picker-options="pickerOptions2"></el-date-picker>',
                showCancelButton: true,
                confirmButtonText: 'Submit',
                showLoaderOnConfirm: true,
                preConfirm: (email) => {
                    return new Promise((resolve) => {
                        $.ajax({
                            url: '/api/' + this.taxpayer + '/' + this.cycle + '/generateJournals/dateRange[0]/dateRange[1]',
                            headers: {'X-CSRF-TOKEN': CSRF_TOKEN},
                            type: 'post',
                            data:json,
                            dataType: 'json',
                            async: false,
                            success: function(data)
                            {
                                if (data == 'ok')
                                {

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
        //this.init()
    }
});
