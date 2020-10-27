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

use App\Models\Payment;
use App\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Contracts\Role;

Route::group(['middleware' => ['get.menu']], function () {
	Route::get('/', function () {
		if (Auth::User()){
            //return view('dashboard.homepage');
			return redirect('/backend');
		} else {
			return redirect('login');;
		}
	})->name('index');


	Route::get('/users/{id}/impersonate', function($id) {
		if (Auth::User() && Auth::user()->hasrole('admin')){
            \Auth::user()->impersonate($id);
		}
		return redirect('/backend');
	})->name('admin.users.impersonate');

	Route::get('/page', function () {       return view('frontend.page'); });
    //Route::get('/backend', function () {    return view('dashboard.homepage'); });
	Route::get('/backend', function () {
        if (auth()->user()->hasRole('admin')) {
            $usersApprovedNum = User::where('state', 1)->count();
            $usersWaitingApprovalNum = User::where('state', 0)->count();
            $usersWithRoleUser = User::role('user')->count();
            $usersWithRoleSales = User::role('sales')->count();

            $data = [
                'users' => $usersWithRoleUser,
                'sales' => $usersWithRoleSales,
                'totalUsersApproved' => $usersApprovedNum,
                'usersWaitingApproval' => $usersWaitingApprovalNum
            ];

            $payments = Payment::orderBy('approved', 'asc')->paginate(10, ['*'], 'payments');
            $paymentTotals = Payment::where('approved', 1)->count();
            $paymentsPending = Payment::where('approved', 0)->count();

            $totalAmounts = Payment::where('approved', 1)->sum('amount');

            $paymentsData = [
                'payments' => $paymentTotals,
                'pending' => $paymentsPending,
                'totals' => $totalAmounts
            ];

            $users = User::orderBy('state', 'asc')->paginate(10, ['*'], 'users');
            return view('welcome', compact('users', 'data', 'payments', 'paymentsData'));
        } else {
            return view('welcome');
        }

    });

	/*
    Route::group(['middleware' => ['role:user']], function () {
        Route::get('/colors', function () {     return view('dashboard.colors'); });
        Route::get('/typography', function () { return view('dashboard.typography'); });
        Route::get('/charts', function () {     return view('dashboard.charts'); });
        Route::get('/widgets', function () {    return view('dashboard.widgets'); });
        Route::get('/google-maps', function(){  return view('dashboard.googlemaps'); });
        Route::get('/404', function () {        return view('dashboard.404'); });
        Route::get('/500', function () {        return view('dashboard.500'); });
        Route::prefix('base')->group(function () {
            Route::get('/breadcrumb', function(){   return view('dashboard.base.breadcrumb'); });
            Route::get('/cards', function(){        return view('dashboard.base.cards'); });
            Route::get('/carousel', function(){     return view('dashboard.base.carousel'); });
            Route::get('/collapse', function(){     return view('dashboard.base.collapse'); });

            Route::get('/jumbotron', function(){    return view('dashboard.base.jumbotron'); });
            Route::get('/list-group', function(){   return view('dashboard.base.list-group'); });
            Route::get('/navs', function(){         return view('dashboard.base.navs'); });
            Route::get('/pagination', function(){   return view('dashboard.base.pagination'); });

            Route::get('/popovers', function(){     return view('dashboard.base.popovers'); });
            Route::get('/progress', function(){     return view('dashboard.base.progress'); });
            Route::get('/scrollspy', function(){    return view('dashboard.base.scrollspy'); });
            Route::get('/switches', function(){     return view('dashboard.base.switches'); });

            Route::get('/tabs', function () {       return view('dashboard.base.tabs'); });
            Route::get('/tooltips', function () {   return view('dashboard.base.tooltips'); });
        });
        Route::prefix('buttons')->group(function () {
            Route::get('/buttons', function(){          return view('dashboard.buttons.buttons'); });
            Route::get('/button-group', function(){     return view('dashboard.buttons.button-group'); });
            Route::get('/dropdowns', function(){        return view('dashboard.buttons.dropdowns'); });
            Route::get('/brand-buttons', function(){    return view('dashboard.buttons.brand-buttons'); });
            Route::get('/loading-buttons', function(){  return view('dashboard.buttons.loading-buttons'); });
        });
        Route::prefix('editors')->group(function () {
            Route::get('/code-editor', function(){          return view('dashboard.editors.code-editor'); });
            Route::get('/markdown-editor', function(){      return view('dashboard.editors.markdown-editor'); });
            Route::get('/text-editor', function(){          return view('dashboard.editors.text-editor'); });
        });

        Route::prefix('forms')->group(function () {
            Route::get('/basic-forms', function(){          return view('dashboard.forms.basic-forms'); });
            Route::get('/advanced-forms', function(){       return view('dashboard.forms.advanced-forms'); });
            Route::get('/validation', function(){           return view('dashboard.forms.validation'); });
        });

        Route::prefix('icon')->group(function () {  // word: "icons" - not working as part of adress
            Route::get('/coreui-icons', function(){         return view('dashboard.icons.coreui-icons'); });
            Route::get('/flags', function(){                return view('dashboard.icons.flags'); });
            Route::get('/brands', function(){               return view('dashboard.icons.brands'); });
        });
        Route::prefix('notifications')->group(function () {
            Route::get('/alerts', function(){               return view('dashboard.notifications.alerts'); });
            Route::get('/badge', function(){                return view('dashboard.notifications.badge'); });
            Route::get('/modals', function(){               return view('dashboard.notifications.modals'); });
            Route::get('/toastr', function(){               return view('dashboard.notifications.toastr'); });
        });
        Route::prefix('plugins')->group(function () {
            Route::get('/calendar', function(){             return view('dashboard.plugins.calendar'); });
            Route::get('/draggable-cards', function(){      return view('dashboard.plugins.draggable-cards'); });
            Route::get('/spinners', function(){             return view('dashboard.plugins.spinners'); });
        });
        Route::prefix('tables')->group(function () {
            Route::get('/tables', function () {             return view('dashboard.tables.tables'); });
            Route::get('/datatables', function () {         return view('dashboard.tables.datatables'); });
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
	*/

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

    Route::group(['middleware' => ['role:user']], function () {
        Route::put('/user/update-password', 'ApprovedUserController@updatePassword')->name('user.updatePassword');
    });

	Route::group(['middleware' => ['role:user|sales']], function () {
		Route::get('/users/info', function () { return view('users.info'); });

		Route::prefix('/users/services')->group(function () {
			Route::get('/input', 'PointServiceController@input')->name('users.services.input');
			Route::post('/preview', 'ApiReloadlyController@user_input_phone_number')->name('users.services.preview');
			Route::get('/preview/operator/{id}', 'ApiReloadlyController@user_operator_selected')->name('users.services.preview.operator');
			Route::post('/transaction', 'ApiReloadlyController@user_recharge_request')->name('users.services.transaction');
			Route::get('/transaction/result', 'ApiReloadlyController@user_recharge')->name('users.services.transaction.result');
			Route::get('/print/{id}', 'PointServiceController@print')->name('users.services.print');
			Route::get('/print/{id}/small', 'PointServiceController@print_small')->name('users.services.print.small');
        });

		Route::prefix('/users/reports')->group(function () {
			Route::get('/operations', 'PointReportController@operations')->name('users.reports.operations');
            Route::get('/users/operations/export', 'PointReportController@export')->name('user.operations.export');
        });

		Route::prefix('/users')->group(function () {
            Route::get('/payments/export', 'PointPaymentsController@export')->name('users.payments.export');
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
        });
	});

    Route::group(['middleware' => ['role:admin']], function () {

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
//            Route::get('/', 'ProviderReferentController@index')->name('admin.referents.index');
            Route::post('/', 'ProviderReferentController@store')->name('admin.referents.store');
            Route::get('/create', 'ProviderReferentController@create')->name('admin.referents.create');
//            Route::get('/{id}/edit', 'ProviderReferentController@edit')->name('admin.referents.edit');
            Route::put('/{id}', 'ProviderReferentController@update')->name('admin.referents.update');
            Route::delete('/{id}', 'ProviderReferentController@destroy')->name('admin.referents.destroy');
            // deleted providers
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
			Route::get('', 'UsersGroupsController@list')->name('admin.groups.list');
			Route::get('/{id}', 'UsersGroupsController@view')->name('admin.groups.view');
			Route::get('/deleted', 'UsersGroupsController@deleted')->name('admin.groups.deleted');
			Route::get('/create', 'UsersGroupsController@create')->name('admin.groups.create');
			Route::post('/store', 'UsersGroupsController@store')->name('admin.groups.store');
			Route::get('/{id}/edit', 'UsersGroupsController@edit')->name('admin.groups.edit');
			Route::put('/{id}/update', 'UsersGroupsController@update')->name('admin.groups.update');
			Route::delete('/{id}', 'UsersGroupsController@delete')->name('admin.groups.delete');
			Route::put('/{id}/recover', 'UsersGroupsController@recover')->name('admin.groups.recover');
        });

		Route::prefix('/admin')->group(function () {
            Route::post('/user/approve/{user}', 'UsersController@approve')->name('admin.user.approve');
			Route::resource('services',  'ServiceController', [ 'names' => 'admin.services' ]);
            Route::get('/payments/export', 'PaymentsController@export')->name('admin.payments.export');
            Route::put('payments/cancel/{payment}', 'PaymentsController@cancel')->name('admin.payments.cancel');
            Route::put('/payments/approve/{ids}', 'PaymentsController@updatePaymentStatus')->name('admin.payments.updatePaymentStatus');
            Route::put('/payments/recover/{payment}', 'PaymentsController@recover')->name('admin.payments.recover');
            Route::get('/payments/trashed-payments', 'PaymentsController@trashed')->name('admin.trashedPayments');
            Route::get('/payments/pay-user', 'PaymentsController@payUser')->name('admin.payUser');
            Route::get('/payments/pay-provider', 'PaymentsController@payProvider')->name('admin.payProvider');
            Route::post('/payments/pay-provider', 'PaymentsController@payProviderStore')->name('admin.payProviderStore');
            Route::post('/payments/pay-user', 'PaymentsController@payUserStore')->name('admin.payments.payUserStore');
            Route::resource('payments',  'PaymentsController', [ 'names' => 'admin.payments' ]);

            Route::get('/users/export', 'UsersController@export')->name('admin.user.export');

            Route::get('/api/services', 'ServiceOperationController@index');

        });

		Route::prefix('/admin/services/')->group(function () {
			Route::get('/{id}/edit/local', 'ServiceController@edit_local')->name('admin.services.edit.local');
			Route::put('/{id}/local', 'ServiceController@update_local')->name('admin.services.update.local');
        });

		Route::prefix('/admin/services/')->group(function () {
			Route::get('/', 'ServiceController@index')->name('admin.services.index');
        });


		Route::prefix('/admin/package/')->group(function () {
			Route::get('categories', 'PackageController@categories')->name('admin.package.category.manage');
			Route::post('categories/create', 'PackageController@category_create')->name('admin.package.category.create');
			Route::post('categories/update', 'PackageController@categories_update')->name('admin.package.category.update');
			Route::get('list', 'PackageController@index')->name('admin.package.list');
			Route::get('{id}/view', 'PackageController@view')->name('admin.package.view');
			Route::get('create', 'PackageController@create')->name('admin.package.create');
			Route::post('store', 'PackageController@store')->name('admin.package.store');
			Route::get('{id}/edit', 'PackageController@edit')->name('admin.package.edit');
			Route::put('{id}/update', 'PackageController@update')->name('admin.package.update');
			Route::delete('{id}/delete', 'PackageController@delete')->name('admin.package.delete');
			Route::get('deleted', 'PackageController@deleted')->name('admin.package.deleted');
			Route::put('{id}/recover', 'PackageController@recover')->name('admin.package.recover');
        });

		Route::prefix('/admin/ding/services/')->group(function () {
			Route::get('/', 'ApiDingController@products_list')->name('admin.ding.services.products');
        });

		Route::prefix('/admin/api/reloadly')->group(function () {
			Route::get('/', 'ApiReloadlyController@index')->name('admin.api.reloadly.index');
            Route::get('/balance', 'ApiReloadlyController@balance')->name('admin.api.reloadly.balance');
            Route::get('/discounts', 'ApiReloadlyController@discounts')->name('admin.api.reloadly.discounts');
            Route::post('/fx_rates', 'ApiReloadlyController@fx_rates')->name('admin.api.reloadly.fx_rates');
            Route::get('/countries', 'ApiReloadlyController@countries')->name('admin.api.reloadly.countries');
            Route::get('/operators/list', 'ApiReloadlyController@operators')->name('admin.api.reloadly.operators');
            Route::get('/promotions', 'ApiReloadlyController@promotions')->name('admin.api.reloadly.promotions');
            Route::get('/transactions', 'ApiReloadlyController@transactions')->name('admin.api.reloadly.transactions');
            Route::post('/recharge', 'ApiReloadlyController@recharge')->name('admin.api.reloadly.recharge');
            Route::get('/operators/save', 'ApiReloadlyController@save_operators')->name('admin.api.reloadly.operators.save');
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
            Route::get('/Promotions', 'ApiDingController@Promotions')->name('admin.api.ding.Promotions');
            Route::get('/PromotionDescriptions', 'ApiDingController@PromotionDescriptions')->name('admin.api.ding.PromotionDescriptions');
            Route::post('/AccountLookup', 'ApiDingController@AccountLookup')->name('admin.api.ding.account_lookup');
		});

		Route::prefix('/admin/report')->group(function () {
            Route::get('/', 'ReportController@operations')->name('admin.report.operations');
            Route::get('/agents', 'ReportController@agentOperations')->name('admin.agent.operations');
            Route::get('/agents/export', 'ReportController@agentOperationsExport')->name('admin.report.agent.export');
			Route::get('/export', 'ReportController@export_operations')->name('admin.report.operations.export');
			Route::get('/export/simple', 'ReportController@export_operations_simple')->name('admin.report.operations.export.simple');
			Route::get('/calls', 'ReportController@calls')->name('admin.report.calls');
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
    $path = storage_path() . '/app/payments/'. $filename;
    if(!\File::exists($path)) abort(404);
    return response()->download($path);
});
