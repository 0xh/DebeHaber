Vue.component('buefy-menu',
{

    data() {
        return {
          istransaction: false,
          isaccount: false
        };
    },

    methods: {
        OpenTransaction()
        {
          this.istransaction=!this.istransaction;
        },
        OpenAccount()
        {
          this.isaccount=!this.isaccount;
        }
    }


});
