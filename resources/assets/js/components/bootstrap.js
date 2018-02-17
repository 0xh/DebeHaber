
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

//Commercial
require('./../commercial-components/transaction/bootstrap');

//Configuration


require('./home');
