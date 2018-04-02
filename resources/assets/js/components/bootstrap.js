
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

//Accounting
require('./../accounting-components/chart/bootstrap');
require('./../accounting-components/chart-version/bootstrap');
require('./../accounting-components/cycle/bootstrap');
require('./../accounting-components/journal/bootstrap');
require('./../accounting-components/model/bootstrap');

//Commercial
require('./../commercial-components/credit-note/bootstrap');
require('./../commercial-components/debit-note/bootstrap');
require('./../commercial-components/purchase/bootstrap');
require('./../commercial-components/sales/bootstrap');
require('./../commercial-components/model/bootstrap');
require('./../commercial-components/account-payable/bootstrap');
require('./../commercial-components/account-receivable/bootstrap');
require('./../commercial-components/money-transfer/bootstrap');

//Configuration
require('./../configuration-components/taxpayer/bootstrap');
require('./../configuration-components/documents/bootstrap');
require('./../configuration-components/currency/bootstrap');
require('./../dashboard-components/team/bootstrap');

//reports
require('./../report-components/bootstrap');


require('./home');
