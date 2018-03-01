<template>
    <div class="">
        <a href="#" v-on:click="add()" v-shortkey.once="['ctrl', 'n']" @shortkey="add()" class="btn btn-outline-primary btn-sm m-btn m-btn--icon">
            <span>
                <i class="la la-plus"></i>
                <span>
                  @lang('global.New')
                </span>
            </span>
        </a>
    </div>
</template>

<script>

export default {

props: ['taxpayer','cycle'],

      methods: {
          add()
          {
              var app=this;

              app.$parent.$parent.status=1;

              $.ajax({
              url: '/api/' + this.taxpayer + '/' + this.cycle + '/commercial/get_lastDate' ,
              type: 'get',
              dataType: 'json',
              async: true,
              success: function(data)
              {

                  app.$parent.$parent.$children[0].date=data;


              },
              error: function(xhr, status, error)
              {
                  console.log(status);
              }
              });



          }




      }


}
</script>
