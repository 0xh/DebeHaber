
var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

Vue.component('taxpayer',{
    props: ['taxpayer'],
    data() {
        return {

            show_wizard: false,
            show_settings: false,
            page: '1',
            pageProg: '',
            id: 0,
            name: '',
            alias: '',
            taxid: '',
            address: '',
            telephone: '',
            email: '',
            
            type: '1',

            setting_inventory: false,
            setting_production: false,
            setting_fixedasset: false,
            setting_import: false,
            setting_export: false,

            setting_regime: '',
            setting_is_company: false,

            setting_agenttaxid: '',
            setting_agent: '',

            no_owner: 0,
            owner_name: '',
            owner_img: '',
            owner_type: '',

            agent_name: '',
            agent_taxid: '',
        }
    },
    methods:
    {
        isCompany: function()
        {
            var app = this;
            if (app.setting_is_company == 'false')
            {
                setting_regime = '';
                setting_agenttaxid: '';
                setting_agent: '';
                setting_inventory: false;
                setting_production: false;
                setting_import: false;
                setting_export: false;
            }
        },
        //Useful for when user wants to create a Taxpayer not in the system.
        clearPage: function()
        {
            var app = this;
            app.id = 0;
            app.name = '';
            app.alias = '';
            app.taxid = '';
            app.address = '';
            app.telephone = '';
            app.email = '';
            app.no_owner = true;
            app.owner_name = '';
            app.owner_img = '';
            app.owner_type = '';
        },

        nextPage: function(json)
        {
            var app = this;

            if (app.page == 3)
            {
                this.onSave(json);
            }

            //If owner exists, then skip settings (#2) page.
            if (app.owner_name != '')
            {
                if (app.page == 1)
                { app.page == 2; }

                app.page = app.page + 1;
            }
            else
            {
                app.page = app.page + 1;
            }

            app.pageProg = (app.page / 3) * 100;
        },

        //Takes Json and uploads it into Sales INvoice API for inserting. Since this is a new, it should directly insert without checking.
        //For updates code will be different and should use the ID's palced int he Json.
        onSave: function(json)
        {
            $.ajax({
                url: '/taxpayer',
                headers: {'X-CSRF-TOKEN': CSRF_TOKEN},
                type: 'post',
                data:json,
                dataType: 'json',
                async: false,
                success: function(data)
                {
                    document.location.href = '../home/'
                },
                error: function(xhr, status, error)
                {
                    console.log(xhr.responseText);
                }
            });
        },
    }
});
