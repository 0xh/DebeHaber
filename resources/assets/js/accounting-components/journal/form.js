
var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

Vue.component('journal-form',{
    props: ['taxpayer','cycle'],
    data() {
        return {
            id:0,
            number:'',
            date:'',
            comment:'',
            details: [
                //     {
                //     id:0,
                //     journal_id:'',
                //     chart_id:'',
                //     debit:0,
                //     credit:''


                // }
            ],
            accounts:[],
        }
    },
    computed: {

        grandCreditTotal: function()
        {
            var totalcredit = 0.0;
            if (this.details !=null ) {
                for(let i = 0; i < this.details.length; i++)
                {
                    totalcredit +=  parseFloat(this.details[i].credit).toFixed(2) ;
                }
            }
            return parseFloat(totalcredit).toFixed(2);
        },
        grandDebitTotal: function()
        {
            var totaldebit = 0.0000;
            if (this.details !=null ) {
                for(let i = 0; i < this.details.length; i++)
                {
                    totaldebit +=  parseFloat(this.details[i].debit).toFixed(4) ;
                }
            }


            return parseFloat(totaldebit).toFixed(4);
        }
    },

    methods: {
        addDetail: function()
        {
            this.details.push({ id:0, journal_id:0, chart_id:0, debit:0, credit:0 })
        },

        //Removes Detail. Make sure it removes the correct detail, and not in randome.
        deleteDetail: function(detail)
        {
            let index = this.details.indexOf(detail)
            this.details.splice(index, 1)
        },

        //Takes Json and uploads it into Sales INvoice API for inserting. Since this is a new, it should directly insert without checking.
        //For updates code will be different and should use the ID's palced int he Json.
        onSave: function(json)
        {

            var app = this;
            var api = null;

            $.ajax({
                url: '',
                headers: {'X-CSRF-TOKEN': CSRF_TOKEN},
                type: 'post',
                data:json,
                dataType: 'json',
                async: false,
                success: function(data)
                {
                    if (data == 'ok')
                    {
                        app.onReset();
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

        onEdit: function(data)
        {
            console.log(data)
            var app = this;
            app.id = data.id;
            app.number = data.number;
            app.date = data.date;
            app.comment= data.comment;
            app.details = data.details;
        },

        onReset: function()
        {
            var app=this;
            app.id = 0;
            app.number = null;
            app.date = null;
            app.comment=null;
            app.details = [];
            app.$parent.status=0;
        },

        cancel()
        {
            var app = this;
            app.$parent.status=0;
        },


        //Get Money Accounts
        getAccounts: function(data)
        {
            var app = this;
            $.ajax({
                url: '/api/' + this.taxpayer + '/' + this.cycle + '/accounting/chart/get-accountables' ,
                headers: {'X-CSRF-TOKEN': CSRF_TOKEN},
                type: 'get',
                dataType: 'json',
                async: true,
                success: function(data)
                {
                    app.accounts = [];
                    for(let i = 0; i < data.length; i++)
                    {
                        app.accounts.push({name:data[i]['name'],id:data[i]['id']});
                    }
                },
                error: function(xhr, status, error)
                {
                    console.log(xhr.responseText);
                }
            });
        }
    },

    mounted: function mounted()
    {
        this.getAccounts();
    }
});
