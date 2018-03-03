<template>
  <div class="btn-group btn-group-sm">
    <button @click="onEdit(row.id)">Edit</button>
    <button class="btn btn-default" title="Friends"

    @click="toggleNestedComp('FriendsTable')">
    <i class="fa fa-users"></i> {{ row.friends.length }}
  </button>
</div>
</template>
<script>

export default {
  props: ['row', 'nested'],
  mounted () {
    $(this.$el).find('button[title]').tooltip()
  },
  computed: {
    isDisplayRowVisible () {
      if (this.nested.comp !== 'DisplayRow') return
      return this.nested.visible
    },
    isFriendsTableVisible () {
      if (this.nested.comp !== 'FriendsTable') return
      return this.nested.visible
    }
  },
  methods: {
    toggleNestedComp (comp) {
      const { nested } = this
      if (nested.comp === comp) return nested.$toggle()
      nested.$toggle(comp, true)
    },
    onEdit: function(data)
    {

      var app = this;

      app.$parent.$parent.$parent.$parent.$parent.onEdit(data);


    }
  }
}
</script>
<style>
.-nested-comp-open-btn {
  color: #fff !important;
  background-color: #337ab7 !important;
}
</style>
