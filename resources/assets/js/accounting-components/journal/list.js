var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
Vue.component('journals-list',{

    props: ['taxpayer','cycle'],
    data(){
        return {
            data: [

            ],
            query: {}
        };
    },
    methods: {

        init(){
            var app = this;
            $.ajax({
                url: '/api/' + this.taxpayer + '/' + this.cycle + '/accounting/journal/get' ,
                headers: {'X-CSRF-TOKEN': CSRF_TOKEN},
                type: 'get',
                dataType: 'json',
                async: true,
                success: function(data)
                {
                    app.$children[1].data = [];
                    app.$children[1].data = data;
                },
                error: function(xhr, status, error)
                {
                    console.log(status);
                }
            });
        },

        onEdit: function(data)
        {
            var app = this;
            app.$parent.status = 1;
            $.ajax({
                url: '/api/' + this.taxpayer + '/' + this.cycle + '/accounting/journals/id/' + data,
                headers: {'X-CSRF-TOKEN': CSRF_TOKEN},
                type: 'get',
                dataType: 'json',
                async: true,
                success: function(data)
                {
                    app.$parent.$children[0].onEdit(data[0]);
                },
                error: function(xhr, status, error)
                {
                    console.log(status);
                }
            });
        },
        toggleSelectAll() {
            this.allSelected = !this.allSelected;
            this.data.forEach(row => {
                if(this.allSelected){
                    data.selected = true;
                }else{
                    data.selected = false;
                }
            })
        }
    }
});
