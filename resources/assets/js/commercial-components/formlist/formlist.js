
Vue.component('form-list',{

    data () {
        return {

        }
    },
    created() {

    },

    methods:
    {
        onLoad ()
        {
            var options = {
                data: {
                    type: 'remote',
                    source: {
                        read: {
                            url: '/api/get_sales/' + this.taxpayer,
                            method: 'GET',
                            // custom headers
                            //  headers: { 'x-my-custom-header': 'some value', 'x-test-header': 'the value'},
                            params: {
                                // custom query params
                                query: {
                                    //  taxPayerID: this.taxpayer
                                    //  someParam: 'someValue',
                                    //  token: 'token-value'
                                }
                            },
                            map: function(raw) {
                                // sample data mapping
                                var dataSet = raw;
                                if (typeof raw.data !== 'undefined') {
                                    dataSet = raw.data;
                                }
                                return dataSet;
                            },
                        }
                    },
                    pageSize: 10,
                    saveState: {
                        cookie: true,
                        webstorage: true
                    },

                    serverPaging: false,
                    serverFiltering: false,
                    serverSorting: false
                },

                layout: {
                    theme: 'default',
                    class: 'm-datatable--brand',
                    scroll: false,
                    height: null,
                    footer: false,
                    header: true,

                    smoothScroll: {
                        scrollbarShown: true
                    },

                    spinner: {
                        overlayColor: '#000000',
                        opacity: 0,
                        type: 'loader',
                        state: 'brand',
                        message: true
                    },

                    icons: {
                        sort: {asc: 'la la-arrow-up', desc: 'la la-arrow-down'},
                        pagination: {
                            next: 'la la-angle-right',
                            prev: 'la la-angle-left',
                            first: 'la la-angle-double-left',
                            last: 'la la-angle-double-right',
                            more: 'la la-ellipsis-h'
                        },
                        rowDetail: {expand: 'fa fa-caret-down', collapse: 'fa fa-caret-right'}
                    }
                },

                sortable: false,

                pagination: true,

                search: {
                    // enable trigger search by keyup enter
                    onEnter: false,
                    // input text for search
                    input: $('#generalSearch'),
                    // search delay in milliseconds
                    delay: 400,
                },

                detail: {
                    title: 'Load sub table',
                    content: function (e) {
                        // e.data
                        // e.detailCell
                    }
                },

                rows: {
                    callback: function() {},
                    // auto hide columns, if rows overflow. work on non locked columns
                    autoHide: false,
                },

                // columns definition
                columns: [{
                    field: "RecordID",
                    title: "#",
                    locked: {left: 'xl'},
                    sortable: false,
                    width: 40,
                    selector: {class: 'm-checkbox--solid m-checkbox--brand'}
                }, {
                    field: "id",
                    title: "id",
                    sortable: 'asc',
                    filterable: false,
                    width: 150,
                    responsive: {visible: 'lg'},
                    locked: {left: 'xl'},
                    template: '{{id}}'
                }, {
                    field: "code",
                    title: "code",
                    width: 150,
                    overflow: 'visible',
                    template: function (row) {
                        return row.code;
                    }
                }],

                toolbar: {
                    layout: ['pagination', 'info'],

                    placement: ['bottom'],  //'top', 'bottom'

                    items: {
                        pagination: {
                            type: 'default',

                            pages: {
                                desktop: {
                                    layout: 'default',
                                    pagesNumber: 6
                                },
                                tablet: {
                                    layout: 'default',
                                    pagesNumber: 3
                                },
                                mobile: {
                                    layout: 'compact'
                                }
                            },

                            navigation: {
                                prev: true,
                                next: true,
                                first: true,
                                last: true
                            },

                            pageSizeSelect: [10, 20, 30, 50, 100]
                        },

                        info: true
                    }
                },

                translate: {
                    records: {
                        processing: 'Please wait...',
                        noRecords: 'No records found'
                    },
                    toolbar: {
                        pagination: {
                            items: {
                                default: {
                                    first: 'First',
                                    prev: 'Previous',
                                    next: 'Next',
                                    last: 'Last',
                                    more: 'More pages',
                                    input: 'Page number',
                                    select: 'Select page size'
                                },
                                info: 'Displaying {{start}} - {{end}} of {{total}} records'
                            }
                        }
                    }
                }
            }

            var datatable = $('.my_datatable').mDatatable(options);

        }
    },

    mounted: function mounted()
    {
        
    }
});
