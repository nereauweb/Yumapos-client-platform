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
Route::group(['middleware' => ['get.menu']], function () {
	Route::get('/', function () {
		if (Auth::User()){
			//return view('dashboard.homepage');
			return view('welcome');
		} else {
			return redirect('login');;
		}			
	})->name('index');
	Route::get('/page', function () {       return view('frontend.page'); });
    //Route::get('/backend', function () {    return view('dashboard.homepage'); });
	Route::get('/backend', function () {    return view('welcome'); });
	
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
        });	
		
		Route::prefix('/users')->group(function () { 
			Route::resource('payments',  'PointPaymentsController', [ 'names' => 'users.payments' ]);
			Route::get('/payments/export', 'PaymentsController@export')->name('users.payments.export');
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
			Route::resource('payments',  'PaymentsController', [ 'names' => 'admin.payments' ]);
        });
		
		Route::prefix('/admin/services/')->group(function () { 
			Route::get('/{id}/edit/local', 'ServiceController@edit_local')->name('admin.services.edit.local');
			Route::put('/{id}/local', 'ServiceController@update_local')->name('admin.services.update.local');
        });
		
		Route::prefix('/admin/services/')->group(function () { 
			Route::get('/', 'ServiceController@index')->name('admin.services.index');
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
		
		Route::prefix('/admin/report')->group(function () { 
            Route::get('/', 'ReportController@operations')->name('admin.report.operations');
            Route::get('/agents', 'ReportController@agentOperations')->name('admin.agent.operations');
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

    Route::group(['middleware' => ['role:user']], function () {
        Route::put('/user/update-password', 'ApprovedUserController@updatePassword')->name('user.updatePassword');
    });
});

Route::get('locale', 'LocaleController@locale');