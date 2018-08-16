Vue.component('reports', {
    data() {
        return {
            dateRange: [
                moment().subtract(1, 'months').startOf('month').format("YYYY-MM-DD"),
                moment().subtract(1, 'months').endOf('month').format("YYYY-MM-DD")
            ]
        };
    }
})
