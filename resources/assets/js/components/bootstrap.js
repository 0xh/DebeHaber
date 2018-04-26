
/*
 |--------------------------------------------------------------------------
 | DebeHaber Components
 |--------------------------------------------------------------------------
 |
 | Here we will load the components which makes up the core client
 | application. This is also a convenient spot for you to load all of
 | your components that you write while building your applications.
 */

require('./../spark-components/bootstrap');
require('./../model-components/bootstrap');
require('./../infinity-components/bootstrap');

//Accounting
// require('./../accounting-components/list-components/bootstrap');
 require('./../accounting-components/chart/bootstrap');
  require('./../accounting-components/fixedasset/bootstrap');
// require('./../accounting-components/chart-version/bootstrap');
require('./../accounting-components/cycle/bootstrap');
require('./../accounting-components/journal/bootstrap');
//
// require('./../accounting-components/model/bootstrap');

//Commercial
require('./../commercial-components/transactions/bootstrap');
require('./../commercial-components/accounts/bootstrap');
require('./../commercial-components/accounttransaction/bootstrap');
require('./../commercial-components/inventories/bootstrap');

//Configuration
require('./../configuration-components/taxpayer/bootstrap');
require('./../configuration-components/documents/bootstrap');
require('./../configuration-components/currency/bootstrap');
// require('./../dashboard-components/team/bootstrap');

//Reports
require('./../report-components/bootstrap');
