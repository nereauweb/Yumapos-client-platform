<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Contracts\Role;

Route::group(['middleware' => ['get.menu']], function () {

	Route::get('/', function () {
		if (Auth::User()){
			return redirect('/backend');
		} else {
			return redirect('login');
		}
	})->name('index');

	Route::get('/users/{id}/impersonate', function($id) {
		if (Auth::User() && Auth::user()->hasrole('admin')){
            \Auth::user()->impersonate($id);
		}
		return redirect('/backend');
	})->name('admin.users.impersonate');

	Route::get('/page', function () { return view('frontend.page'); });

	Route::get('/backend', 'HomeController@index')->name('home');

    Auth::routes();

    Route::resource('resource/{table}/resource', 'ResourceController')->names([
        'index'     => 'resource.index',
        'create'    => 'resource.create',
        'store'     => 'resource.store',
        'show'      => 'resource.show',
        'edit'      => 'resource.edit',
        'update'    => 'resource.update',
        'destroy'   => 'resource.destroy'
    ]);

	Route::group(['middleware' => ['role:user|sales']], function () {

        Route::put('/user/update-password', 'ApprovedUserController@updatePassword')->name('user.updatePassword');
		Route::post('/user/accept-privacy', 'HomeController@accept_privacy')->name('user.privacy.accept');

//	    chart data
        Route::post('/user/internal/services/operations/totals/{type}', 'ServiceOperationController@user_totals'); // endpoint for initial calculations (daily)
        Route::post('user/internal/services/{type}', 'ServiceOperationController@user_operations');  // data for operations
        Route::post('/admin/internal/services/countries/{country}', 'ServiceOperationController@countries');  // data for operations

		Route::get('/users/info', function () { return view('users.info'); });

		Route::prefix('/users/services')->group(function () {
			Route::get('/category/{id}', 'PointServiceController@category')->name('users.services.category');
			Route::get('/input', 'PointServiceController@input')->name('users.services.input');
			Route::post('/preview', 'PointServiceController@preview')->name('users.services.preview');
			Route::put('/preview/category/{id}', 'PointServiceController@preview_category')->name('users.services.preview.category');
			Route::get('/preview/operator/{category_id}/{operator_id}/{phone_number}', 'PointServiceController@user_operator_selected')->name('users.services.preview.operator');
			Route::post('/transaction', 'PointServiceController@user_recharge_request')->name('users.services.transaction');
			Route::get('/ding/transaction/result', 'ApiDingController@user_recharge')->name('users.services.ding.transaction.result');
			Route::get('/reloadly/transaction/result', 'ApiReloadlyController@user_recharge')->name('users.services.reloadly.transaction.result');
			Route::get('/print/{id}', 'PointServiceController@print')->name('users.services.print');
			Route::get('/print/{id}/small', 'PointServiceController@print_small')->name('users.services.print.small');
			
			Route::post('/mbs/ricarica', 'PointServiceController@user_mbs_recharge_request')->name('users.services.mbs.ricarica_telefonica');
			Route::get('/mbs/ricarica/bridged', 'ApiMbsController@point_ricarica_telefonica')->name('users.services.mbs.ricarica_telefonica.bridged');			
			Route::post('/mbs/ricarica-pin', 'PointServiceController@user_mbs_pin_request')->name('users.services.mbs.ricarica_pin');
			Route::get('/mbs/ricarica-pin/bridged', 'ApiMbsController@point_ricarica_pin')->name('users.services.mbs.ricarica_pin.bridged');
			
        });

		Route::prefix('/users/reports')->group(function () {
			Route::get('/operations', 'PointReportController@operations')->name('users.reports.operations');
            Route::get('/users/operations/export', 'PointReportController@export')->name('user.operations.export');			
            Route::get('/ticket', 'PointReportController@operations_ticket')->name('user.reports.operations_ticket');
        });

		Route::prefix('/users')->group(function () {
            Route::get('/payments/export', 'PointPaymentsController@export')->name('users.payments.export');
            Route::get('/payments/transfer/{id}', 'PointPaymentsController@create_transfer')->name('users.payments.transfer.create');
            Route::post('/payments/transfer/', 'PointPaymentsController@transfer')->name('users.payments.transfer.do');
			Route::put('/payments/approve/{id}', 'PointPaymentsController@approve')->name('users.payments.approve');
            Route::resource('payments',  'PointPaymentsController', [ 'names' => 'users.payments' ]);
        });

		Route::prefix('/users/settings')->group(function () {
			Route::get('/account', 'PointSettingsController@account')->name('users.settings.account');
			Route::post('/update', 'PointSettingsController@update')->name('users.settings.update');
        });

	});

	Route::group(['middleware' => ['role:sales']], function () {
        Route::get('/sales/users', 'AgentController@userIndex')->name('agent.user.index');
        Route::get('/sales/user/create', 'AgentController@userCreate')->name('agent.user.create');
        Route::post('/sales/user', 'AgentController@userStore')->name('agent.user.store');
		Route::prefix('/sales/reports')->group(function () {
			Route::get('/operations', 'AgentReportController@operations')->name('agents.reports.operations');
			Route::post('/internal/{type}', 'ServiceOperationController@agentOperations');
			Route::post('/internal/agent-totals/{type}', 'ServiceOperationController@agentTotals');
        });
	});

    Route::group(['middleware' => ['role:admin']], function () {

        Route::get('/admin/account', 'AdminController@index');
        Route::put('/admin/account/{admin}', 'AdminController@update')->name('admin.updatePassword');

        Route::post('/admin/users/change-role/{user}', 'UsersController@changeRole')->name('admin.user.change-role');

        Route::put('admin/agent/user/approve', 'AgentController@approve')->name('admin.agent.user.approve');

        Route::get('/reloadly_balance', 'ApiReloadlyController@getBalance');

        // providers paths
        Route::prefix('/admin/providers')->group(function () {
            Route::get('/', 'ProviderController@index')->name('admin.providers.index');
            Route::get('/create', 'ProviderController@create')->name('admin.providers.create');
            Route::post('/', 'ProviderController@store')->name('admin.providers.store');
            Route::get('/{id}/edit', 'ProviderController@edit')->name('admin.providers.edit');
            Route::put('/{id}', 'ProviderController@update')->name('admin.providers.update');
            Route::delete('/{id}', 'ProviderController@destroy')->name('admin.providers.destroy');
            // deleted providers
            Route::get('/trash', 'ProviderController@trash')->name('admin.providers.trash');
            Route::put('/restore/{provider}', 'ProviderController@restore')->name('admin.providers.restore');
        });

        // referents paths
        Route::prefix('/admin/referents')->group(function () {
            Route::post('/', 'ProviderReferentController@store')->name('admin.referents.store');
            Route::get('/create', 'ProviderReferentController@create')->name('admin.referents.create');
            Route::put('/{id}', 'ProviderReferentController@update')->name('admin.referents.update');
            Route::delete('/{id}', 'ProviderReferentController@destroy')->name('admin.referents.destroy');
            Route::get('/trash', 'ProviderReferentController@trash')->name('admin.referents.trash');
            Route::put('/restore/{provider}', 'ProviderReferentController@restore')->name('admin.referents.restore');
        });

        Route::prefix('/admin/files')->group(function () {
            Route::get('/', 'PaymentFileController@index');
            Route::get('/paymentfile/{payment}', 'PaymentFileController@create')->name('admin.paymentfile.create');
            Route::post('/paymentfile/{payment}', 'PaymentFileController@store')->name('admin.paymentfile.store');
            Route::delete('/paymentfile/{paymentfile}', 'PaymentFileController@destroy')->name('admin.paymentfile.destroy');
        });


		Route::prefix('/admin/users/groups')->group(function () {
			
			Route::get('/ping-pricings', 'UsersGroupsController@ping_pricings')->name('admin.groups.ping_pricings');
			
			Route::get('', 'UsersGroupsController@list')->name('admin.groups.list');
			Route::get('/create', 'UsersGroupsController@create')->name('admin.groups.create');
			Route::get('/create-agent', 'UsersGroupsController@create_agent')->name('admin.groups.create_agent');
			Route::get('/{id}', 'UsersGroupsController@view')->name('admin.groups.view');
			Route::get('/deleted', 'UsersGroupsController@deleted')->name('admin.groups.deleted');
			Route::post('/store', 'UsersGroupsController@store')->name('admin.groups.store');
			Route::get('/{id}/edit', 'UsersGroupsController@edit')->name('admin.groups.edit');
			Route::put('/{id}/update', 'UsersGroupsController@update')->name('admin.groups.update');
			Route::delete('/{id}', 'UsersGroupsController@delete')->name('admin.groups.delete');
			Route::put('/{id}/recover', 'UsersGroupsController@recover')->name('admin.groups.recover');
        });

        Route::post('/admin/user/approve/{user}', 'UsersController@approve')->name('admin.user.approve');
        Route::get('/admin/users/export', 'UsersController@export')->name('admin.user.export');

        Route::resource('/admin/payments/',  'PaymentsController', [ 'names' => 'admin.payments' ]);
		Route::prefix('/admin/payments')->group(function () {
            Route::get('/{id}/edit', 'PaymentsController@edit')->name('admin.payments.edit');
            Route::get('/export', 'PaymentsController@export')->name('admin.payments.export');
            Route::put('/cancel/{payment}', 'PaymentsController@cancel')->name('admin.payments.cancel');
            Route::put('/approve/{ids}', 'PaymentsController@updatePaymentStatus')->name('admin.payments.updatePaymentStatus');
            Route::put('/recover/{payment}', 'PaymentsController@recover')->name('admin.payments.recover');
            Route::get('/trashed-payments', 'PaymentsController@trashed')->name('admin.trashedPayments');
            Route::get('/pay-user', 'PaymentsController@payUser')->name('admin.payUser');
            Route::get('/pay-provider', 'PaymentsController@payProvider')->name('admin.payProvider');
            Route::post('/pay-provider', 'PaymentsController@payProviderStore')->name('admin.payProviderStore');
            Route::post('/pay-user', 'PaymentsController@payUserStore')->name('admin.payments.payUserStore');
            Route::delete('/delete/{payment}', 'PaymentsController@reject')->name('admin.payments.reject');
            Route::put('/recover-from-trash/{payment}', 'PaymentsController@recoverFromTrash')->name('admin.payments.recover-from-trash');
        });		

		Route::prefix('/admin/api/mbs')->group(function () {
			Route::get('/', 'ApiMbsController@index')->name('admin.api.mbs.index');
			Route::get('/balance', 'ApiMbsController@balance')->name('admin.api.mbs.balance');
			Route::get('/prefix-list', 'ApiMbsController@list_prefix')->name('admin.api.mbs.list_prefix');			
			Route::post('/beneficiario-bollettino', 'ApiMbsController@beneficiario_bollettino')->name('admin.api.mbs.beneficiario_bollettino');
			Route::post('/pagamento-bollettino', 'ApiMbsController@pagamento_bollettino')->name('admin.api.mbs.pagamento_bollettino');
			Route::post('/pagamento-bollettino', 'ApiMbsController@pagamento_bollettino')->name('admin.api.mbs.pagamento_bollettino');
			Route::post('/pagamento-bollettino-mav', 'ApiMbsController@pagamento_bollettino_mav')->name('admin.api.mbs.pagamento_bollettino_mav');
			Route::post('/pagamento-bollettino-rav', 'ApiMbsController@pagamento_bollettino_rav')->name('admin.api.mbs.pagamento_bollettino_rav');
			Route::post('/richiesta-biller', 'ApiMbsController@richiesta_biller')->name('admin.api.mbs.richiesta_biller');
			Route::post('/pagamento-bollettino-cbill', 'ApiMbsController@pagamento_bollettino_cbill')->name('admin.api.mbs.pagamento_bollettino_cbill');
			Route::post('/ricarica-telefonica', 'ApiMbsController@ricarica_telefonica')->name('admin.api.mbs.ricarica_telefonica');
			Route::post('/ricarica-pin', 'ApiMbsController@ricarica_pin')->name('admin.api.mbs.ricarica_pin');
			Route::post('/verifica-ricarica', 'ApiMbsController@verifica_ricarica')->name('admin.api.mbs.verifica_ricarica');
			Route::post('/verifica-ricarica-pin', 'ApiMbsController@verifica_ricarica_pin')->name('admin.api.mbs.verifica_ricarica_pin');
			Route::post('/tagli-prefissi-internazionali', 'ApiMbsController@tagli_prefissi_internazionali')->name('admin.api.mbs.tagli_prefissi_internazionali');
			Route::post('/ricarica-internazionale', 'ApiMbsController@ricarica_internazionale')->name('admin.api.mbs.ricarica_internazionale');
			Route::post('/pagamento-visura', 'ApiMbsController@pagamento_visura')->name('admin.api.mbs.pagamento_visura');
			Route::post('/verifica-visura', 'ApiMbsController@verifica_visura')->name('admin.api.mbs.verifica_visura');
			Route::post('/spedizione', 'ApiMbsController@spedizione')->name('admin.api.mbs.spedizione');
			Route::post('/verifica-spedizione', 'ApiMbsController@verifica_spedizione')->name('admin.api.mbs.verifica_spedizione');
			Route::post('/ricarica-postepay', 'ApiMbsController@ricarica_postepay')->name('admin.api.mbs.ricarica_postepay');
		});

		Route::prefix('/admin/api/reloadly')->group(function () {
			Route::get('/', 'ApiReloadlyController@index')->name('admin.api.reloadly.index');
            Route::get('/balance', 'ApiReloadlyController@balance')->name('admin.api.reloadly.balance');
            Route::get('/cached_balance', 'ApiReloadlyController@get_cache_balance')->name('admin.api.reloadly.cached_balance');
            Route::get('/discounts', 'ApiReloadlyController@discounts')->name('admin.api.reloadly.discounts');
            Route::post('/fx_rates', 'ApiReloadlyController@fx_rates')->name('admin.api.reloadly.fx_rates');
            Route::get('/countries', 'ApiReloadlyController@countries')->name('admin.api.reloadly.countries');
            Route::get('/operators/list', 'ApiReloadlyController@operators')->name('admin.api.reloadly.operators');
            Route::get('/promotions', 'ApiReloadlyController@promotions')->name('admin.api.reloadly.promotions');
            Route::get('/transactions', 'ApiReloadlyController@transactions')->name('admin.api.reloadly.transactions');
            Route::post('/recharge', 'ApiReloadlyController@recharge')->name('admin.api.reloadly.recharge');
            Route::get('/operators/save', 'ApiReloadlyController@save_operators')->name('admin.api.reloadly.operators.save');
            Route::get('/graph','ApiReloadlyController@graph_data')->name('graph_data');
        });

		Route::prefix('/admin/api/ding')->group(function () {
			Route::get('/', 'ApiDingController@index')->name('admin.api.ding.index');
            Route::get('/ErrorCodeDescriptions', 'ApiDingController@ErrorCodeDescriptions')->name('admin.api.ding.ErrorCodeDescriptions');
            Route::get('/Currencies', 'ApiDingController@Currencies')->name('admin.api.ding.Currencies');
            Route::get('/Currencies/save', 'ApiDingController@Currencies_save')->name('admin.api.ding.Currencies.save');
            Route::get('/Regions', 'ApiDingController@Regions')->name('admin.api.ding.Regions');
            Route::get('/Regions/save', 'ApiDingController@Regions_save')->name('admin.api.ding.Regions.save');
            Route::get('/Countries', 'ApiDingController@Countries')->name('admin.api.ding.Countries');
            Route::get('/Countries/save', 'ApiDingController@Countries_save')->name('admin.api.ding.Countries.save');
            Route::get('/Providers', 'ApiDingController@Providers')->name('admin.api.ding.Providers');
            Route::get('/Providers/save', 'ApiDingController@Providers_save')->name('admin.api.ding.Providers.save');
            Route::get('/ProviderStatus', 'ApiDingController@ProviderStatus')->name('admin.api.ding.ProviderStatus');
            Route::get('/Products', 'ApiDingController@Products')->name('admin.api.ding.Products');
            Route::get('/Products/save', 'ApiDingController@Products_save')->name('admin.api.ding.Products.save');
            Route::get('/ProductDescriptions', 'ApiDingController@ProductDescriptions')->name('admin.api.ding.ProductDescriptions');
            Route::get('/Balance', 'ApiDingController@Balance')->name('admin.api.ding.Balance');
            Route::get('/cached_balance', 'ApiDingController@get_cache_balance')->name('admin.api.ding.cached_balance');
            Route::get('/Promotions', 'ApiDingController@Promotions')->name('admin.api.ding.Promotions');
            Route::get('/PromotionDescriptions', 'ApiDingController@PromotionDescriptions')->name('admin.api.ding.PromotionDescriptions');
            Route::post('/AccountLookup', 'ApiDingController@AccountLookup')->name('admin.api.ding.account_lookup');
            Route::get('/graph', 'ApiDingController@graph_data')->name('admin.ding.graph_data');
		});

		Route::prefix('/admin/service/reloadly')->group(function () {
			Route::get('/{id}/edit/local', 'ReloadlyController@edit_local')->name('admin.reloadly.edit.local');
			Route::put('/{id}/local', 'ReloadlyController@update_local')->name('admin.reloadly.update.local');
        	});
		Route::resource('/admin/service/reloadly',  'ReloadlyController', [ 'names' => 'admin.reloadly' ]);

		Route::resource('/admin/service/ding',  'DingController', [ 'names' => 'admin.ding' ]);
		
		Route::resource('/admin/service/mbs',  'MbsController', [ 'names' => 'admin.mbs' ]);

		Route::post('/admin/internal/services/operations/totals/{type}', 'ServiceOperationController@totals'); // endpoint for initial calculations (daily)
		Route::post('/admin/internal/services/{type}', 'ServiceOperationController@operations');  // data for operations
        Route::post('/admin/internal/services/countries/{country}', 'ServiceOperationController@countries');  // data for operations

		Route::prefix('/admin/service')->group(function () {

			Route::get('/categories', 'ServiceController@categories')->name('admin.service.category.manage');
			Route::get('/categories/{id}/data', 'ServiceController@category_data')->name('admin.service.category.data');
			Route::put('/categories/{id}/update-configuration', 'ServiceController@category_configuration_update')->name('admin.service.category.update_configuration');
			Route::post('/categories/create', 'ServiceController@category_create')->name('admin.service.category.create');
			Route::post('/categories/update', 'ServiceController@categories_update')->name('admin.service.category.update');

			Route::put('/{id}/set-master', 'ServiceController@set_master')->name('admin.service.set_master');
			Route::put('/{id}/associate', 'ServiceController@associate')->name('admin.service.set_master');
			Route::get('/deleted', 'ServiceController@deleted')->name('admin.service.deleted');
			Route::put('/{id}/recover', 'ServiceController@recover')->name('admin.service.recover');
	        });
		Route::resource('/admin/service',  'ServiceController', [ 'names' => 'admin.service' ]);

		Route::prefix('/admin/report')->group(function () {
            Route::get('/', 'ReportController@operations')->name('admin.report.operations');
            Route::get('/ticket', 'ReportController@operations_ticket')->name('admin.report.operations_ticket');
            Route::get('/agents', 'ReportController@agentOperations')->name('admin.agent.operations');
            Route::get('/agents/export', 'ReportController@agentOperationsExport')->name('admin.report.agent.export');
			Route::get('/export', 'ReportController@export_operations')->name('admin.report.operations.export');
			Route::get('/export/simple', 'ReportController@export_operations_simple')->name('admin.report.operations.export.simple');
			Route::get('/calls', 'ReportController@calls')->name('admin.report.calls');
			Route::get('/calls/reloadly', 'ReportController@reloadly_calls')->name('admin.report.calls.reloadly');
			Route::get('/calls/ding', 'ReportController@ding_calls')->name('admin.report.calls.ding');
			Route::get('/calls/mbs', 'ReportController@mbs_calls')->name('admin.report.calls.mbs');
			Route::get('/{id}/details', 'ReportController@operation_details')->name('admin.report.operation.details');
        });

        Route::resource('bread',  'BreadController');

		Route::get('/users/deleted', 'UsersController@deleted')->name('admin.users.deleted');
		Route::put('users/{id}/recover', 'UsersController@recover')->name('admin.users.recover');
        Route::resource('users', 'UsersController');

        Route::resource('languages',    'LanguageController');
        Route::resource('mail',        'MailController');
        Route::get('prepareSend/{id}',        'MailController@prepareSend')->name('prepareSend');
        Route::post('mailSend/{id}',        'MailController@send')->name('mailSend');
        Route::resource('roles',        'RolesController');
        Route::get('/roles/move/move-up',      'RolesController@moveUp')->name('roles.up');
        Route::get('/roles/move/move-down',    'RolesController@moveDown')->name('roles.down');
        Route::prefix('menu/element')->group(function () {
            Route::get('/',             'MenuElementController@index')->name('menu.index');
            Route::get('/move-up',      'MenuElementController@moveUp')->name('menu.up');
            Route::get('/move-down',    'MenuElementController@moveDown')->name('menu.down');
            Route::get('/create',       'MenuElementController@create')->name('menu.create');
            Route::post('/store',       'MenuElementController@store')->name('menu.store');
            Route::get('/get-parents',  'MenuElementController@getParents');
            Route::get('/edit',         'MenuElementController@edit')->name('menu.edit');
            Route::post('/update',      'MenuElementController@update')->name('menu.update');
            Route::get('/show',         'MenuElementController@show')->name('menu.show');
            Route::get('/delete',       'MenuElementController@delete')->name('menu.delete');
        });
        Route::prefix('menu/menu')->group(function () {
            Route::get('/',         'MenuController@index')->name('menu.menu.index');
            Route::get('/create',   'MenuController@create')->name('menu.menu.create');
            Route::post('/store',   'MenuController@store')->name('menu.menu.store');
            Route::get('/edit',     'MenuController@edit')->name('menu.menu.edit');
            Route::post('/update',  'MenuController@update')->name('menu.menu.update');
            //Route::get('/show',     'MenuController@show')->name('menu.menu.show');
            Route::get('/delete',   'MenuController@delete')->name('menu.menu.delete');
        });
        Route::prefix('media')->group(function () {
            Route::get('/',                 'MediaController@index')->name('media.folder.index');
            Route::get('/folder/store',     'MediaController@folderAdd')->name('media.folder.add');
            Route::post('/folder/update',   'MediaController@folderUpdate')->name('media.folder.update');
            Route::get('/folder',           'MediaController@folder')->name('media.folder');
            Route::post('/folder/move',     'MediaController@folderMove')->name('media.folder.move');
            Route::post('/folder/delete',   'MediaController@folderDelete')->name('media.folder.delete');;

            Route::post('/file/store',      'MediaController@fileAdd')->name('media.file.add');
            Route::get('/file',             'MediaController@file');
            Route::post('/file/delete',      'MediaController@fileDelete')->name('media.file.delete');
            Route::post('/file/update',     'MediaController@fileUpdate')->name('media.file.update');
            Route::post('/file/move',       'MediaController@fileMove')->name('media.file.move');
            Route::post('/file/cropp',      'MediaController@cropp');
            Route::get('/file/copy',        'MediaController@fileCopy')->name('media.file.copy');
        });

		Route::prefix('apps')->group(function () {
            Route::prefix('invoicing')->group(function () {
                Route::get('/invoice', function () {        return view('dashboard.apps.invoicing.invoice'); });
            });
            Route::prefix('email')->group(function () {
                Route::get('/inbox', function () {          return view('dashboard.apps.email.inbox'); });
                Route::get('/message', function () {        return view('dashboard.apps.email.message'); });
                Route::get('/compose', function () {        return view('dashboard.apps.email.compose'); });
            });
        });
        Route::resource('notes', 'NotesController');

    });

});

Route::get('locale', 'LocaleController@locale');

Route::get('payments/{filename}', function ($filename)
{
    $path = storage_path() . '/app/payments/'. $filename;
    if(!\File::exists($path)) abort(404);
    return response()->download($path);
});

Route::get('users-added-payments/{filename}', function ($filename)
{
    $path = storage_path() . '/app/payments/' . $filename;
    if (!\File::exists($path)) abort(404);
    return response()->download($path);
});

Route::get('files/{filename}', function ($filename)
{
    $path = storage_path() . '/app/public/'. $filename;
    if(!\File::exists($path)) abort(404);
    return response()->file($path);
});
