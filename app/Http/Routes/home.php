<?php

/*
|--------------------------------------------------------------------------
| 应用程序前台路由
|--------------------------------------------------------------------------
*/

Route::group(['middleware' => ['auth'], 'namespace' => 'Home'], function () {
    Route::get('/', [
        'as' => 'admin.index', 'acl' => 'admin.index', 'uses' => 'IndexController@index'
    ]);

    Route::get('/home', [
        'as' => 'admin.home', 'acl' => 'admin.index', 'uses' => 'IndexController@index'
    ]);
    // 个人编辑
    Route::get('/user/edit', [
        'as' => 'admin.user.edit', 'acl' => 'admin.user', 'uses' => 'UserController@edit'
    ]);
    Route::post('/user/update', [
        'as' => 'admin.user.update', 'acl' => 'admin.user', 'uses' => 'UserController@update'
    ]);


    // 验证用户权限
    Route::group(['middleware' => ['acl']], function () {

        /**
         * 用户管理相关路由
         */
        Route::get('/user', [
            'as' => 'admin.user', 'acl' => 'admin.user.viewlist', 'uses' => 'UserController@index'
        ]);
        Route::post('/user/store', [
            'as' => 'admin.user.store', 'acl' => 'admin.user.store', 'uses' => 'UserController@store'
        ]);
        Route::get('/user/ajaxEdit', [
            'as' => 'admin.user.ajaxedit', 'acl' => 'admin.user.store', 'uses' => 'UserController@ajaxEdit'
        ]);
        Route::post('/user/destroy', [
            'as' => 'admin.user.destroy', 'acl' => 'admin.user.destroy', 'uses' => 'UserController@ajaxDestroy'
        ]);
        Route::match(['get', 'post'], '/user/search', [
            'as' => 'admin.user.search', 'acl' => 'admin.user.viewlist', 'uses' => 'UserController@search'
        ]);
        Route::match(['get', 'post'], '/user/default', [
            'as' => 'admin.user.verifylist', 'acl' => 'admin.user.viewlist', 'uses' => 'UserController@defaultList'
        ]);
        Route::match(['get', 'post'], '/user/fiu', [
            'as' => 'admin.user.verifylist', 'acl' => 'admin.user.viewlist', 'uses' => 'UserController@fiuList'
        ]);
        Route::match(['get', 'post'], '/user/d3in', [
            'as' => 'admin.user.verifylist', 'acl' => 'admin.user.viewlist', 'uses' => 'UserController@d3inList'
        ]);
        Route::match(['get', 'post'], '/user/abroad', [
            'as' => 'admin.user.verifylist', 'acl' => 'admin.user.viewlist', 'uses' => 'UserController@abroadList'
        ]);
        Route::match(['get', 'post'], '/user/onlineRetailers', [
            'as' => 'admin.user.verifylist', 'acl' => 'admin.user.viewlist', 'uses' => 'UserController@onlineRetailersList'
        ]);
        Route::match(['get', 'post'], '/user/support', [
            'as' => 'admin.user.verifylist', 'acl' => 'admin.user.viewlist', 'uses' => 'UserController@supportList'
        ]);

        /**
         * 角色管理相关路由
         */
        Route::get('/role', [
            'as' => 'admin.role', 'acl' => 'admin.role.viewlist', 'uses' => 'RoleController@index'
        ]);
        Route::post('/role/store', [
            'as' => 'admin.role.store', 'acl' => 'admin.role.store', 'uses' => 'RoleController@store'
        ]);
        Route::get('/role/ajaxEdit', [
            'as' => 'admin.role.update', 'acl' => 'admin.role.store', 'uses' => 'RoleController@ajaxEdit'
        ]);
        Route::post('/role/update', [
            'as' => 'admin.role.update', 'acl' => 'admin.role.store', 'uses' => 'RoleController@update'
        ]);
        Route::post('/role/destroy', [
            'as' => 'admin.role.destroy', 'acl' => 'admin.role.destroy', 'uses' => 'RoleController@ajaxDestroy'
        ]);

        /**
         * 用户与角色关联设置
         */
        Route::get('/roleUser', [
            'as' => 'admin.roleUser', 'acl' => 'admin.role.viewlist', 'uses' => 'RoleController@show'
        ]);
        Route::get('/roleUser/edit', [
            'as' => 'admin.roleUser.edit', 'acl' => 'admin.role.store', 'uses' => 'RoleController@roleUserEdit'
        ]);
        Route::post('/roleUser/store', [
            'as' => 'admin.roleUser.store', 'acl' => 'admin.role.store', 'uses' => 'RoleController@roleUserStore'
        ]);
        Route::post('/roleUser/destroy', [
            'as' => 'admin.roleUser.destroy', 'acl' => 'admin.role.destroy', 'uses' => 'RoleController@roleUserDestroy'
        ]);

        /**
         * 角色权限相关路由
         */
        Route::get('/permission', [
            'as' => 'admin.permission', 'acl' => 'admin.role.viewlist', 'uses' => 'PermissionController@index'
        ]);
        Route::post('/permission/store', [
            'as' => 'admin.permission.store', 'acl' => 'admin.role.store', 'uses' => 'PermissionController@store'
        ]);
        Route::get('/permission/ajaxEdit', [
            'as' => 'admin.permission.update', 'acl' => 'admin.role.store', 'uses' => 'PermissionController@ajaxEdit'
        ]);
        Route::post('/permission/update', [
            'as' => 'admin.permission.update', 'acl' => 'admin.role.store', 'uses' => 'PermissionController@update'
        ]);
        Route::post('/permission/destroy', [
            'as' => 'admin.permission.destroy', 'acl' => 'admin.role.destroy', 'uses' => 'PermissionController@ajaxDestroy'
        ]);

        /**
         * 角色-权限关联设置
         */
        Route::get('/rolePermission', [
            'as' => 'admin.role.permission.show', 'acl' => 'admin.role.viewlist', 'uses' => 'PermissionController@show'
        ]);
        Route::post('/rolePermission/store', [
            'as' => 'admin.role.permission.store', 'acl' => 'admin.role.store', 'uses' => 'PermissionController@rolePermissionStore'
        ]);

        Route::get('/rolePermission/edit', [
            'as' => 'admin.role.permission.edit', 'acl' => 'admin.role.store', 'uses' => 'PermissionController@rolePermissionEdit'
        ]);

        Route::post('/rolePermission/update', [
            'as' => 'admin.role.permission.update', 'acl' => 'admin.role.store', 'uses' => 'PermissionController@rolePermissionUpdate'
        ]);

        Route::get('/rolePermission/destroy', [
            'as' => 'admin.role.permission.destroy', 'acl' => 'admin.role.destroy', 'uses' => 'PermissionController@rolePermissionDestroy'
        ]);

        /**
         * 审核管理-权限设置
         */
        Route::get('/auditing', [
            'as' => 'admin.auditing.show', 'acl' => 'admin.auditing.viewlist', 'uses' => 'AuditingController@index'
        ]);
        Route::post('/auditing/store', [
            'as' => 'admin.auditing.store', 'acl' => 'admin.auditing.store', 'uses' => 'AuditingController@store'
        ]);
        Route::get('/auditing/edit', [
            'as' => 'admin.auditing.edit', 'acl' => 'admin.auditing.store', 'uses' => 'AuditingController@edit'
        ]);
        Route::post('/auditing/destroy', [
            'as' => 'admin.auditing.destroy', 'acl' => 'admin.auditing.destroy', 'uses' => 'AuditingController@destroy'
        ]);

        /**
         * 仓库管理
         */
        Route::get('/storage', [
            'as' => 'admin.storage', 'acl' => 'admin.storage.viewlist', 'uses' => 'StorageController@index'
        ]);
        Route::post('/storage/add', [
            'as' => 'admin.storage.add', 'acl' => 'admin.storage.store', 'uses' => 'StorageController@add'
        ]);
        Route::get('/storage/storageList', [
            'as' => 'admin.storage.index', 'acl' => 'admin.storage.viewlist', 'uses' => 'StorageController@lists'
        ]);
        Route::post('/storage/destroy', [
            'as' => 'admin.storage.destroy', 'acl' => 'admin.storage.destroy', 'uses' => 'StorageController@destroy'
        ]);
        Route::get('/storage/edit', [
            'as' => 'admin.storage.edit', 'acl' => 'admin.storage.store', 'uses' => 'StorageController@edit'
        ]);
        Route::post('/storage/update', [
            'as' => 'admin.storage.update', 'acl' => 'admin.storage.store', 'uses' => 'StorageController@update'
        ]);


        /**
         * 库存监控管理
         */
        Route::get('/storageSkuCount/list', [
            'as' => 'admin.storage.list', 'acl' => 'admin.storage.viewlist', 'uses' => 'StorageSkuCountController@index'
        ]);
        Route::match(['get', 'post'], '/storageSkuCount/search', [
            'as' => 'admin.storage.search', 'acl' => 'admin.storage.viewlist', 'uses' => 'StorageSkuCountController@search'
        ]);
        Route::post('/storageSkuCount/updateMax', [
            'as' => 'admin.storage.update.max', 'acl' => 'admin.storage.store', 'uses' => 'StorageSkuCountController@ajaxUpdateMax'
        ]);
        Route::post('/storageSkuCount/updateMin', [
            'as' => 'admin.storage.updae.min', 'acl' => 'admin.storage.store', 'uses' => 'StorageSkuCountController@ajaxUpdateMin'
        ]);
        Route::get('/storageSkuCount/productCount', [
            'as' => 'admin.storage.product.count', 'acl' => 'admin.storage.store', 'uses' => 'StorageSkuCountController@productCount'
        ]);
        Route::match(['get', 'post'], '/storageSkuCount/productSearch', [
            'as' => 'admin.storage.product.search', 'acl' => 'admin.storage.viewlist', 'uses' => 'StorageSkuCountController@productSearch'
        ]);
        Route::post('/storageSkuCount/productCountList', [
            'as' => 'admin.storage.product.list', 'acl' => 'admin.storage.viewlist', 'uses' => 'StorageSkuCountController@productCountList'
        ]);
        Route::post('/storageSkuCount/storagePlace', [
            'as' => 'admin.storage.place', 'acl' => 'admin.storage.viewlist', 'uses' => 'StorageSkuCountController@storagePlace'
        ]);
        Route::post('/storageSkuCount/RackPlace', [
            'as' => 'admin.storage.rack.place', 'acl' => 'admin.storage.viewlist', 'uses' => 'StorageSkuCountController@rackPlace'
        ]);
        Route::get('/storageSkuCount/storageCost', [
            'as' => 'admin.storage.cost', 'acl' => 'admin.storage.viewlist', 'uses' => 'StorageSkuCountController@storageCost'
        ]);
        Route::match(['get', 'post'], '/storageSkuCount/storageCostSearch', [
            'as' => 'admin.storage.cost.search', 'acl' => 'admin.storage.viewlist', 'uses' => 'StorageSkuCountController@storageCostSearch'
        ]);
        Route::post('/storageSkuCount/deleteRackPlace', [
            'as' => 'admin.storage.deleteRackPlace', 'acl' => 'admin.storage.store', 'uses' => 'StorageSkuCountController@deleteRackPlace'
        ]);
        /**
         * 仓库-库区路由
         */
        Route::post('/storageRack/add', [
            'as' => 'admin.storage.rack.add', 'acl' => 'admin.storage.store', 'uses' => 'StorageRackController@add'
        ]);
        Route::get('/storageRack/list', [
            'as' => 'admin.storage.rack.index', 'acl' => 'admin.storage.store', 'uses' => 'StorageRackController@lists'
        ]);
        Route::post('/storageRack/destroy', [
            'as' => 'admin.storage.rack.destroy', 'acl' => 'admin.storage.destroy', 'uses' => 'StorageRackController@destroy'
        ]);
        Route::get('/storageRack/edit', [
            'as' => 'admin.storage.rack.edit', 'acl' => 'admin.storage.store', 'uses' => 'StorageRackController@edit'
        ]);
        Route::post('/storageRack/update', [
            'as' => 'admin.storage.rack.update', 'acl' => 'admin.storage.store', 'uses' => 'StorageRackController@update'
        ]);


        /**
         * 仓位路由
         */
        Route::post('/storagePlace/add', [
            'as' => 'admin.storage.place.add', 'acl' => 'admin.storage.store', 'uses' => 'StoragePlaceController@add'
        ]);
        Route::get('/storagePlace/list', [
            'as' => 'admin.storage.place.index', 'acl' => 'admin.storage.viewlist', 'uses' => 'StoragePlaceController@lists'
        ]);
        Route::post('/storagePlace/destroy', [
            'as' => 'admin.storage.place.destroy', 'acl' => 'admin.storage.destroy', 'uses' => 'StoragePlaceController@destroy'
        ]);
        Route::get('/storagePlace/edit', [
            'as' => 'admin.storage.place.edit', 'acl' => 'admin.storage.store', 'uses' => 'StoragePlaceController@edit'
        ]);
        Route::post('/storagePlace/update', [
            'as' => 'admin.storage.place.update', 'acl' => 'admin.storage.store', 'uses' => 'StoragePlaceController@update'
        ]);


        /**
         * 供货商路由
         */
        Route::get('/supplier', [
            'as' => 'admin.supplier', 'acl' => 'admin.supplier.viewlist', 'uses' => 'SupplierController@index'
        ]);
        Route::get('/supplier/create', [
            'as' => 'admin.supplier.create', 'acl' => 'admin.supplier.store', 'uses' => 'SupplierController@create'
        ]);
        Route::post('/supplier/store', [
            'as' => 'admin.supplier.store', 'acl' => 'admin.supplier.store', 'uses' => 'SupplierController@store'
        ]);
        Route::post('/supplier/destroy', [
            'as' => 'admin.supplier.destroy', 'acl' => 'admin.supplier.destroy', 'uses' => 'SupplierController@ajaxDestroy'
        ]);
        Route::get('/supplier/edit', [
            'as' => 'admin.supplier.edit', 'acl' => 'admin.supplier.store', 'uses' => 'SupplierController@edit'
        ]);
        Route::post('/supplier/update', [
            'as' => 'admin.supplier.update', 'acl' => 'admin.supplier.store', 'uses' => 'SupplierController@update'
        ]);
        Route::match(['get', 'post'], '/supplier/search', [
            'as' => 'admin.supplier.search', 'acl' => 'admin.supplier.viewlist', 'uses' => 'SupplierController@search'
        ]);
        Route::get('/supplier/verifyList', [
            'as' => 'admin.supplier.verifyList', 'acl' => 'admin.supplier.viewlist', 'uses' => 'SupplierController@verifyList'
        ]);
        Route::get('/supplier/closeList', [
            'as' => 'admin.supplier.closeList', 'acl' => 'admin.supplier.viewlist', 'uses' => 'SupplierController@closeList'
        ]);
        Route::post('/supplier/ajaxVerify', [
            'as' => 'admin.supplier.ajaxVerify', 'acl' => 'admin.supplier.verified', 'uses' => 'SupplierController@ajaxVerify'
        ]);
        Route::post('/supplier/ajaxClose', [
            'as' => 'admin.supplier.ajaxClose', 'acl' => 'admin.supplier.verified', 'uses' => 'SupplierController@ajaxClose'
        ]);
        Route::get('/supplier/details', [
            'as' => 'admin.supplier.verifyList', 'acl' => 'admin.supplier.viewlist', 'uses' => 'SupplierController@details'
        ]);
        //绑定模版get
        Route::get('/supplier/addMould', [
            'as' => 'admin.supplier.store', 'acl' => 'admin.supplier.store', 'uses' => 'SupplierController@addMould'
        ]);
        //绑定模版post
        Route::post('/supplier/storeMould', [
            'as' => 'admin.supplier.store', 'acl' => 'admin.supplier.store', 'uses' => 'SupplierController@storeMould'
        ]);
        //生成用户
        Route::post('/supplier/addUser', [
            'as' => 'admin.supplier.store', 'acl' => 'admin.supplier.store', 'uses' => 'SupplierController@addUser'
        ]);
        //删除用户
        Route::post('/supplier/deleteUser', [
            'as' => 'admin.supplier.store', 'acl' => 'admin.supplier.store', 'uses' => 'SupplierController@deleteUser'
        ]);
        /**
         * 物流公司
         */
        Route::get('/logistics', [
            'as' => 'admin.logistics', 'acl' => 'admin.logistics.viewlist', 'uses' => 'LogisticsController@index'
        ]);
        Route::post('/logistics/store', [
            'as' => 'admin.logistics.store', 'acl' => 'admin.logistics.store', 'uses' => 'LogisticsController@ajaxStore'
        ]);
        Route::get('/logistics/edit', [
            'as' => 'admin.logistics.edit', 'acl' => 'admin.logistics.store', 'uses' => 'LogisticsController@ajaxEdit'
        ]);
        Route::post('/logistics/update', [
            'as' => 'admin.logistics.update', 'acl' => 'admin.logistics.store', 'uses' => 'LogisticsController@ajaxUpdate'
        ]);
        Route::post('/logistics/destroy', [
            'as' => 'admin.logistics.destroy', 'acl' => 'admin.logistics.destroy', 'uses' => 'LogisticsController@ajaxDestroy'
        ]);
        Route::post('/logistics/status', [
            'as' => 'admin.logistics.status', 'acl' => 'admin.logistics.viewlist', 'uses' => 'LogisticsController@ajaxStatus'
        ]);
        Route::get('/logistics/go', [
            'as' => 'admin.logistics.go', 'acl' => 'admin.logistics.viewlist', 'uses' => 'LogisticsController@show'
        ]);
        Route::post('/logistics/goStore', [
            'as' => 'admin.logistics.go.store', 'acl' => 'admin.logistics.store', 'uses' => 'LogisticsController@goStore'
        ]);
        Route::post('/logistics/goUpdate', [
            'as' => 'admin.logistics.go.update', 'acl' => 'admin.logistics.store', 'uses' => 'LogisticsController@goUpdate'
        ]);
        Route::post('/logistics/goDestroy', [
            'as' => 'admin.logistics.go.destroy', 'acl' => 'admin.logistics.destroy', 'uses' => 'LogisticsController@goDestroy'
        ]);

        /**
         * 发货人信息设置
         */
        Route::get('/consignor', [
            'as' => 'admin.consignor', 'acl' => 'admin.logistics.viewlist', 'uses' => 'ConsignorController@index'
        ]);
        Route::post('/consignor/store', [
            'as' => 'admin.consignor.store', 'acl' => 'admin.logistics.store', 'uses' => 'ConsignorController@store'
        ]);
        Route::post('/consignor/ajaxDestroy', [
            'as' => 'admin.consignor.destroy', 'acl' => 'admin.logistics.destroy', 'uses' => 'ConsignorController@ajaxDestroy'
        ]);
        Route::get('/consignor/ajaxShow', [
            'as' => 'admin.consignor.show', 'acl' => 'admin.logistics.viewlist', 'uses' => 'ConsignorController@ajaxShow'
        ]);
        Route::post('/consignor/edit', [
            'as' => 'admin.consignor.edit', 'acl' => 'admin.logistics.store', 'uses' => 'ConsignorController@edit'
        ]);
        Route::match(['get', 'post'], '/consignor/search', [
            'as' => 'admin.consignor.search', 'acl' => 'admin.logistics.viewlist', 'uses' => 'ConsignorController@search'
        ]);

        /**
         * 店铺
         */
        Route::get('/store', [
            'as' => 'admin.store', 'acl' => 'admin.setting.viewlist', 'uses' => 'StoreController@index'
        ]);
        Route::post('/store/store', [
            'as' => 'admin.store.store', 'acl' => 'admin.setting.store', 'uses' => 'StoreController@ajaxStore'
        ]);
        Route::get('/store/edit', [
            'as' => 'admin.store.edit', 'acl' => 'admin.setting.store', 'uses' => 'StoreController@ajaxEdit'
        ]);
        Route::post('/store/update', [
            'as' => 'admin.store.update', 'acl' => 'admin.setting.store', 'uses' => 'StoreController@ajaxUpdate'
        ]);
        Route::post('/store/destroy', [
            'as' => 'admin.store.destroy', 'acl' => 'admin.setting.destroy', 'uses' => 'StoreController@ajaxDestroy'
        ]);

        /**
         * 商品
         */
        Route::match(['get', 'post'], '/product', [
            'as' => 'admin.product', 'acl' => 'admin.product.viewlist', 'uses' => 'ProductController@index'
        ]);
        Route::match(['get', 'post'], '/product/unpublishList', [
            'as' => 'admin.product.unpublishList', 'acl' => 'admin.product.viewlist', 'uses' => 'ProductController@unpublishList'
        ]);
        Route::match(['get', 'post'], '/product/saleList', [
            'as' => 'admin.product.saleList', 'acl' => 'admin.product.viewlist', 'uses' => 'ProductController@saleList'
        ]);
        Route::match(['get', 'post'], '/product/cancList', [
            'as' => 'admin.product.cancList', 'acl' => 'admin.product.viewlist', 'uses' => 'ProductController@cancList'
        ]);
        Route::get('/product/create', [
            'as' => 'admin.product.create', 'acl' => 'admin.product.store', 'uses' => 'ProductController@create'
        ]);
        Route::post('/product/store', [
            'as' => 'admin.product.store', 'acl' => 'admin.product.store', 'uses' => 'ProductController@store'
        ]);
        Route::get('/product/edit', [
            'as' => 'admin.product.edit', 'acl' => 'admin.product.store', 'uses' => 'ProductController@edit'
        ]);
        Route::post('/product/update', [
            'as' => 'admin.product.update', 'acl' => 'admin.product.store', 'uses' => 'ProductController@update'
        ]);
        Route::post('/product/ajaxDestroy', [
            'as' => 'admin.product.destroy', 'acl' => 'admin.product.destroy', 'uses' => 'ProductController@ajaxDestroy'
        ]);
        Route::match(['get', 'post'], '/product/search', [
            'as' => 'admin.product.search', 'acl' => 'admin.product.viewlist', 'uses' => 'ProductController@search'
        ]);
        Route::post('/product/ajaxUpShelves', [
            'as' => 'admin.product.up', 'acl' => 'admin.product.verified', 'uses' => 'ProductController@upShelves'
        ]);
        Route::post('/product/ajaxDownShelves', [
            'as' => 'admin.product.down', 'acl' => 'admin.product.verified', 'uses' => 'ProductController@downShelves'
        ]);
        Route::get('/product/details', [
            'as' => 'admin.product.details', 'acl' => 'admin.product.verified', 'uses' => 'ProductController@details'
        ]);
        Route::post('/product/virtualInventory', [
            'as' => 'admin.product.virtualInventory', 'acl' => 'admin.product.verified', 'uses' => 'ProductController@virtualInventory'
        ]);
        /**
         * 商品sku
         */
        Route::post('/productsSku/store', [
            'as' => 'admin.products.sku.store', 'acl' => 'admin.product.viewlist', 'uses' => 'ProductsSkuController@store'
        ]);
        Route::get('/productsSku/ajaxEdit', [
            'as' => 'admin.products.sku.edit', 'acl' => 'admin.product.store', 'uses' => 'ProductsSkuController@ajaxEdit'
        ]);
        Route::post('/productsSku/update', [
            'as' => 'admin.products.sku.update', 'acl' => 'admin.product.store', 'uses' => 'ProductsSkuController@update'
        ]);
        Route::post('/productsSku/ajaxDestroy', [
            'as' => 'admin.products.sku.destroy', 'acl' => 'admin.product.destroy', 'uses' => 'ProductsSkuController@ajaxDestroy'
        ]);
        Route::get('/productsSku/ajaxSkus', [
            'as' => 'admin.products.sku', 'acl' => 'admin.product.store', 'uses' => 'ProductsSkuController@ajaxSkus'
        ]);
        Route::get('/productsSku/ajaxSearch', [
            'as' => 'admin.products.sku.search', 'acl' => 'admin.product.viewlist', 'uses' => 'ProductsSkuController@ajaxSearch'
        ]);
        Route::get('/productsSku/uniqueNumber', [
            'as' => 'admin.products.sku.uniqueNumber', 'acl' => 'admin.product.store', 'uses' => 'ProductsSkuController@uniqueNumber'
        ]);
        Route::post('/productsSku/uniqueNumberCaptcha', [
            'as' => 'admin.products.sku.uniqueNumberCaptcha', 'acl' => 'admin.product.store', 'uses' => 'ProductsSkuController@uniqueNumberCaptcha'
        ]);

        /**
         * 分类
         */
        Route::get('/category', [
            'as' => 'admin.category', 'acl' => 'admin.setting.viewlist', 'uses' => 'CategoryController@index'
        ]);
        Route::post('/category/store', [
            'as' => 'admin.category.store', 'acl' => 'admin.setting.store', 'uses' => 'CategoryController@store'
        ]);
        Route::get('/category/ajaxEdit', [
            'as' => 'admin.category.edit', 'acl' => 'admin.setting.store', 'uses' => 'CategoryController@ajaxEdit'
        ]);
        Route::post('/category/update', [
            'as' => 'admin.category.update', 'acl' => 'admin.setting.store', 'uses' => 'CategoryController@update'
        ]);
        Route::post('/category/getCitys', [//获取城市
            'as' => 'admin.category.getCitys', 'acl' => 'admin.setting.store', 'uses' => 'CategoryController@getCitys'
        ]);
        Route::post('/category/getAreas', [//获取区/县
            'as' => 'admin.category.getAreas', 'acl' => 'admin.setting.store', 'uses' => 'CategoryController@getAreas'
        ]);

        /**
         * 采购单
         */
        Route::get('/purchase', [
            'as' => 'admin.purchase', 'acl' => 'admin.purchase.viewlist', 'uses' => 'PurchaseController@index'
        ]);
        Route::get('/purchase/create', [
            'as' => 'admin.purchase.create', 'acl' => 'admin.purchase.store', 'uses' => 'PurchaseController@create'
        ]);
        Route::post('/purchase/store', [
            'as' => 'admin.purchase.store', 'acl' => 'admin.purchase.store', 'uses' => 'PurchaseController@store'
        ]);
        Route::post('/purchase/ajaxDestroy', [
            'as' => 'admin.purchase.destroy', 'acl' => 'admin.purchase.destroy', 'uses' => 'PurchaseController@ajaxDestroy'
        ]);
        Route::match(['get', 'post'], '/purchase/search', [
            'as' => 'admin.purchase.search', 'acl' => 'admin.purchase.viewlist', 'uses' => 'PurchaseController@search'
        ]);
        Route::get('/purchase/edit', [
            'as' => 'admin.purchase.edit', 'acl' => 'admin.purchase.store', 'uses' => 'PurchaseController@edit'
        ]);
        Route::post('/purchase/update', [
            'as' => 'admin.purchase.update', 'acl' => 'admin.purchase.store', 'uses' => 'PurchaseController@update'
        ]);
        Route::get('/purchase/purchaseStatus', [
            'as' => 'admin.purchase.status', 'acl' => 'admin.purchase.verified', 'uses' => 'PurchaseController@purchaseStatus'
        ]);
        Route::get('/purchase/show', [
            'as' => 'admin.purchase.show', 'acl' => 'admin.purchase.store', 'uses' => 'PurchaseController@show'
        ]);
        Route::post('/purchase/ajaxVerified', [
            'as' => 'admin.purchase.verified', 'acl' => 'admin.purchase.store', 'uses' => 'PurchaseController@ajaxVerified'
        ]);
        Route::post('/purchase/ajaxDirectorVerified', [
            'as' => 'admin.purchase.director', 'acl' => 'admin.purchase.verified', 'uses' => 'PurchaseController@ajaxDirectorVerified'
        ]);
        Route::post('/purchase/ajaxDirectorReject', [
            'as' => 'admin.purchase.reject', 'acl' => 'admin.purchase.verified', 'uses' => 'PurchaseController@ajaxDirectorReject'
        ]);
        Route::post('/purchase/ajaxReturned', [
            'as' => 'admin.purchase.ajaxReturned', 'acl' => 'admin.purchase.store', 'uses' => 'PurchaseController@ajaxReturned'
        ]);
        // 获取采购单信息
        Route::get('/purchase/ajaxPurchaseInfo', [
            'as' => 'admin.purchase.ajaxPurchaseInfo', 'acl' => 'admin.purchase.viewlist', 'uses' => 'PurchaseController@ajaxPurchaseInfo'
        ]);


        /**
         * 采购退货单
         */
        Route::get('/returned', [
            'as' => 'admin.returned', 'acl' => 'admin.purchase.viewlist', 'uses' => 'ReturnedPurchaseController@index'
        ]);
        Route::get('/returned/create', [
            'as' => 'admin.returned.create', 'acl' => 'admin.purchase.store', 'uses' => 'ReturnedPurchaseController@create'
        ]);
        Route::get('/returned/ajaxPurchase', [
            'as' => 'admin.returned.purchase', 'acl' => 'admin.purchase.store', 'uses' => 'ReturnedPurchaseController@ajaxPurchase'
        ]);
        Route::post('/returned/store', [
            'as' => 'admin.returned.store', 'acl' => 'admin.purchase.store', 'uses' => 'ReturnedPurchaseController@store'
        ]);
        Route::get('/returned/edit', [
            'as' => 'admin.returned.edit', 'acl' => 'admin.purchase.store', 'uses' => 'ReturnedPurchaseController@edit'
        ]);
        Route::post('/returned/update', [
            'as' => 'admin.returned.update', 'acl' => 'admin.purchase.store', 'uses' => 'ReturnedPurchaseController@update'
        ]);
        Route::post('/returned/ajaxDestroy', [
            'as' => 'admin.returned.destroy', 'acl' => 'admin.purchase.destroy', 'uses' => 'ReturnedPurchaseController@ajaxDestroy'
        ]);
        Route::match(['get', 'post'], '/returned/search', [
            'as' => 'admin.returned.search', 'acl' => 'admin.purchase.viewlist', 'uses' => 'ReturnedPurchaseController@search'
        ]);
        Route::get('/returned/show', [
            'as' => 'admin.returned.show', 'acl' => 'admin.purchase.viewlist', 'uses' => 'ReturnedPurchaseController@show'
        ]);
        Route::get('/returned/returnedStatus', [
            'as' => 'admin.returned.status', 'acl' => 'admin.purchase.viewlist', 'uses' => 'ReturnedPurchaseController@returnedStatus'
        ]);
        Route::post('/returned/ajaxVerified', [
            'as' => 'admin.returned.verified', 'acl' => 'admin.purchase.verified', 'uses' => 'ReturnedPurchaseController@ajaxVerified'
        ]);
        Route::post('/returned/ajaxDirectorVerified', [
            'as' => 'admin.returned.verified', 'acl' => 'admin.purchase.verified', 'uses' => 'ReturnedPurchaseController@ajaxDirectorVerified'
        ]);
        Route::post('/returned/ajaxDirectorReject', [
            'as' => 'admin.returned.reject', 'acl' => 'admin.purchase.verified', 'uses' => 'ReturnedPurchaseController@ajaxDirectorReject'
        ]);


        /**
         * 采购入库
         */
        Route::get('/enterWarehouse', [
            'as' => 'admin.enter.warehouse', 'acl' => 'admin.warehouse.viewlist', 'uses' => 'EnterWarehouseController@home'
        ]);
        Route::get('/enterWarehouse/changeEnter', [
            'as' => 'admin.enter.warehouse.change', 'acl' => 'admin.warehouse.change', 'uses' => 'EnterWarehouseController@changeEnter'
        ]);
        Route::get('/enterWarehouse/complete', [
            'as' => 'admin.enter.warehouse.complete', 'acl' => 'admin.warehouse.viewlist', 'uses' => 'EnterWarehouseController@complete'
        ]);
        Route::get('/enterWarehouse/show/{id}', [
            'as' => 'admin.enter.warehouse.show', 'acl' => 'admin.warehouse.viewlist', 'uses' => 'EnterWarehouseController@show'
        ]);
        Route::get('/enterWarehouse/ajaxEdit', [
            'as' => 'admin.enter.warehouse.edit', 'acl' => 'admin.warehouse.store', 'uses' => 'EnterWarehouseController@ajaxEdit'
        ]);
        Route::post('/enterWarehouse/update', [
            'as' => 'admin.enter.warehouse.update', 'acl' => 'admin.warehouse.store', 'uses' => 'EnterWarehouseController@update'
        ]);
        Route::match(['get', 'post'], '/enterWarehouse/search', [
            'as' => 'admin.enter.warehouse.search', 'acl' => 'admin.warehouse.viewlist', 'uses' => 'EnterWarehouseController@search'
        ]);
        // 入库单打印
        Route::get('/enterWarehouse/ajaxPrintInfo', [
            'as' => 'admin.enter.warehouse.ajaxPrintInfo', 'acl' => 'admin.warehouse.viewlist', 'uses' => 'EnterWarehouseController@ajaxPrintInfo'
        ]);
        /**
         * 出库
         */
        Route::get('/outWarehouse', [
            'as' => 'admin.out.warehouse', 'acl' => 'admin.warehouse.viewlist', 'uses' => 'OutWarehouseController@home'
        ]);
        Route::get('/outWarehouse/changeOut', [
            'as' => 'admin.out.warehouse.change', 'acl' => 'admin.warehouse.change', 'uses' => 'OutWarehouseController@changeOut'
        ]);
        Route::get('/outWarehouse/ajaxEdit', [
            'as' => 'admin.out.warehouse.edit', 'acl' => 'admin.warehouse.store', 'uses' => 'OutWarehouseController@ajaxEdit'
        ]);
        Route::post('/outWarehouse/update', [
            'as' => 'admin.out.warehouse.update', 'acl' => 'admin.warehouse.store', 'uses' => 'OutWarehouseController@update'
        ]);
        Route::get('/outWarehouse/complete', [
            'as' => 'admin.out.warehouse.complete', 'acl' => 'admin.warehouse.viewlist', 'uses' => 'OutWarehouseController@complete'
        ]);
        Route::get('/outWarehouse/orderOut', [
            'as' => 'admin.out.warehouse.orderout', 'acl' => 'admin.warehouse.viewlist', 'uses' => 'OutWarehouseController@orderOut'
        ]);
        Route::match(['get', 'post'], '/outWarehouse/search', [
            'as' => 'admin.out.warehouse.search', 'acl' => 'admin.warehouse.viewlist', 'uses' => 'OutWarehouseController@search'
        ]);
        //采购单退货出库审核
        Route::post('/outWarehouse/verifyReturned', [
            'as' => 'admin.out.warehouse.verifyReturned', 'acl' => 'admin.warehouse.verified', 'uses' => 'OutWarehouseController@verifyReturned'
        ]);
        //订单出库审核
        Route::post('/outWarehouse/verifyOrder', [
            'as' => 'admin.out.warehouse.verifyOrder', 'acl' => 'admin.warehouse.verified', 'uses' => 'OutWarehouseController@verifyOrder'
        ]);
        //调拨出库审核
        Route::post('/outWarehouse/verifyChange', [
            'as' => 'admin.out.warehouse.verifyChange', 'acl' => 'admin.warehouse.verified', 'uses' => 'OutWarehouseController@verifyChange'
        ]);
        Route::post('/outWarehouse/ajaxDelete', [
            'as' => 'admin.out.warehouse.delete', 'acl' => 'admin.warehouse.verified', 'uses' => 'OutWarehouseController@ajaxDelete'
        ]);
        // 出库单手动发货
        Route::post('/outWarehouse/ajaxSendOut', [
            'as' => 'admin.out.warehouse.update', 'acl' => 'admin.warehouse.store', 'uses' => 'OutWarehouseController@ajaxSendOut'
        ]);

        /**
         * 调拨单
         */
        Route::get('/changeWarehouse', [
            'as' => 'admin.change.warehouse', 'acl' => 'admin.warehouse.viewlist', 'uses' => 'ChangeWarehouseController@home'
        ]);
        Route::get('/changeWarehouse/verify', [
            'as' => 'admin.change.warehouse.verify', 'acl' => 'admin.warehouse.verify', 'uses' => 'ChangeWarehouseController@verify'
        ]);
        Route::get('/changeWarehouse/completeVerify', [
            'as' => 'admin.change.warehouse.complete', 'acl' => 'admin.warehouse.verify', 'uses' => 'ChangeWarehouseController@completeVerify'
        ]);
        Route::get('/changeWarehouse/create', [
            'as' => 'admin.change.warehouse.create', 'acl' => 'admin.warehouse.store', 'uses' => 'ChangeWarehouseController@create'
        ]);
        Route::post('/changeWarehouse/store', [
            'as' => 'admin.change.warehouse.store', 'acl' => 'admin.warehouse.store', 'uses' => 'ChangeWarehouseController@store'
        ]);
        Route::get('/changeWarehouse/edit', [
            'as' => 'admin.change.warehouse.edit', 'acl' => 'admin.warehouse.store', 'uses' => 'ChangeWarehouseController@edit'
        ]);
        Route::post('/changeWarehouse/update', [
            'as' => 'admin.change.warehouse.update', 'acl' => 'admin.warehouse.store', 'uses' => 'ChangeWarehouseController@update'
        ]);
        Route::get('/changeWarehouse/show', [
            'as' => 'admin.change.warehouse.show', 'acl' => 'admin.warehouse.viewlist', 'uses' => 'ChangeWarehouseController@show'
        ]);
        Route::get('/changeWarehouse/ajaxSkuList', [
            'as' => 'admin.change.warehouse.skulist', 'acl' => 'admin.warehouse.viewlist', 'uses' => 'ChangeWarehouseController@ajaxSkuList'
        ]); //指定仓库sku列表
        Route::get('/changeWarehouse/ajaxSearch', [
            'as' => 'admin.change.warehouse.search', 'acl' => 'admin.warehouse.viewlist', 'uses' => 'ChangeWarehouseController@ajaxSearch'
        ]);
        Route::post('/changeWarehouse/ajaxDestroy', [
            'as' => 'admin.change.warehouse.destroy', 'acl' => 'admin.warehouse.verify', 'uses' => 'ChangeWarehouseController@ajaxDestroy'
        ]);
        Route::post('/changeWarehouse/ajaxVerified', [
            'as' => 'admin.change.warehouse.verified', 'acl' => 'admin.warehouse.verify', 'uses' => 'ChangeWarehouseController@ajaxVerified'
        ]);
        Route::post('/changeWarehouse/ajaxDirectorVerified', [
            'as' => 'admin.change.warehouse.directorVerified', 'acl' => 'admin.warehouse.verify', 'uses' => 'ChangeWarehouseController@ajaxDirectorVerified'
        ]);
        Route::match(['get', 'post'], '/changeWarehouse/search', [
            'as' => 'admin.change.warehouse.search', 'acl' => 'admin.warehouse.viewlist', 'uses' => 'ChangeWarehouseController@search'
        ]);

        /**
         * 订单
         */
        Route::match(['get', 'post'], '/order', [
            'as' => 'admin.order', 'acl' => 'admin.order.viewlist', 'uses' => 'OrderController@index'
        ]);
        Route::get('/order/create', [
            'as' => 'admin.order.create', 'acl' => 'admin.order.store', 'uses' => 'OrderController@create'
        ]);
        Route::post('/order/store', [
            'as' => 'admin.order.store', 'acl' => 'admin.order.store', 'uses' => 'OrderController@store'
        ]);
        Route::get('/order/ajaxSkuList', [
            'as' => 'admin.order.skulist', 'acl' => 'admin.order.viewlist', 'uses' => 'OrderController@ajaxSkuList'
        ]);
        Route::get('/order/ajaxEdit', [
            'as' => 'admin.order.edit', 'acl' => 'admin.order.store', 'uses' => 'OrderController@ajaxEdit'
        ]);
        Route::post('/order/ajaxUpdate', [
            'as' => 'admin.order.update', 'acl' => 'admin.order.store', 'uses' => 'OrderController@ajaxUpdate'
        ]);
        Route::post('/order/ajaxDestroy', [
            'as' => 'admin.order.destroy', 'acl' => 'admin.order.destroy', 'uses' => 'OrderController@ajaxDestroy'
        ]);
        Route::match(['get', 'post'], '/order/verifyOrderList', [
            'as' => 'admin.order.verifylist', 'acl' => 'admin.order.viewlist', 'uses' => 'OrderController@verifyOrderList'
        ]);
        Route::match(['get', 'post'], '/order/reversedOrderList', [
            'as' => 'admin.order.reversedlist', 'acl' => 'admin.order.viewlist', 'uses' => 'OrderController@reversedOrderList'
        ]);
        Route::post('/order/ajaxVerifyOrder', [
            'as' => 'admin.order.verifyorder', 'acl' => 'admin.order.verify', 'uses' => 'OrderController@ajaxVerifyOrder'
        ]);
        Route::post('/order/ajaxReversedOrder', [
            'as' => 'admin.order.reversedorder', 'acl' => 'admin.order.verify', 'uses' => 'OrderController@ajaxReversedOrder'
        ]);
        Route::match(['get', 'post'], '/order/sendOrderList', [
            'as' => 'admin.order.sendorderlist', 'acl' => 'admin.order.viewlist', 'uses' => 'OrderController@sendOrderList'
        ]);
        Route::post('/order/ajaxSendOrder', [
            'as' => 'admin.order.sendorder', 'acl' => 'admin.order.send', 'uses' => 'OrderController@ajaxSendOrder'
        ]);
        Route::match(['get', 'post'], '/order/nonOrderList', [
            'as' => 'admin.order.nonorderlist', 'acl' => 'admin.order.viewlist', 'uses' => 'OrderController@nonOrderList'
        ]);
        Route::match(['get', 'post'], '/order/completeOrderList', [
            'as' => 'admin.order.completelist', 'acl' => 'admin.order.viewlist', 'uses' => 'OrderController@completeOrderList'
        ]);
        Route::get('/order/ajaxSkuSearch', [
            'as' => 'admin.order.skusearch', 'acl' => 'admin.order.viewlist', 'uses' => 'OrderController@ajaxSkuSearch'
        ]);
        Route::match(['get', 'post'], '/order/servicingOrderList', [
            'as' => 'admin.order.servicingOrderList', 'acl' => 'admin.order.viewlist', 'uses' => 'OrderController@servicingOrderList'
        ]);
        Route::match(['get', 'post'], '/order/finishedOrderList', [
            'as' => 'admin.order.finishedOrderList', 'acl' => 'admin.order.viewlist', 'uses' => 'OrderController@finishedOrderList'
        ]);
        Route::match(['get', 'post'], '/order/closedOrderList', [
            'as' => 'admin.order.closedOrderList', 'acl' => 'admin.order.viewlist', 'uses' => 'OrderController@closedOrderList'
        ]);
        Route::post('/order/splitOrder', [
            'as' => 'admin.order.splitOrder', 'acl' => 'admin.order.verify', 'uses' => 'OrderController@splitOrder'
        ]);
        Route::match(['get', 'post'], '/order/search', [
            'as' => 'admin.order.search', 'acl' => 'admin.order.viewlist', 'uses' => 'OrderController@search'
        ]);

        Route::match(['get', 'post'], '/order/userSaleList', [
            'as' => 'admin.order.userSaleList', 'acl' => 'admin.user.stats', 'uses' => 'OrderController@userSaleList'
        ]);
        Route::match(['get', 'post'], '/order/oneUserSaleList', [
            'as' => 'admin.order.oneUserSaleList', 'acl' => 'admin.user.stats', 'uses' => 'OrderController@oneUserSaleList'
        ]);
        Route::match(['get', 'post'], '/order/seniorSearch', [
            'as' => 'admin.order.seniorSearch', 'acl' => 'admin.order.viewlist', 'uses' => 'OrderController@seniorSearch'
        ]);

        Route::get('/order/daifaSupplierOrderList', [
            'as' => 'admin.order.daifaSupplierOrderList', 'acl' => 'admin.order.viewlist', 'uses' => 'OrderController@daifaSupplierOrderList'
        ]);

        /**
         * 发票模板
         */


        Route::match(['get', 'post'], '/invoice', [
            'as' => 'admin.invoice', 'acl' => 'admin.invoice.viewlist', 'uses' => 'InvoiceController@index'
        ]);
        Route::match(['get', 'post'], '/invoice/lists', [
            'as' => 'admin.invoice.lists', 'acl' => 'admin.invoice.lists', 'uses' => 'InvoiceController@lists'
        ]);
         Route::match(['get', 'post'], '/invoice/nonOrderList', [
             'as' => 'admin.invoice.lists', 'acl' => 'admin.invoice.lists', 'uses' => 'InvoiceController@nonOrderList'
         ]);
        Route::match(['get', 'post'], '/invoice/verifyOrderList', [
            'as' => 'admin.invoice.lists', 'acl' => 'admin.invoice.lists', 'uses' => 'InvoiceController@verifyOrderList'
        ]);
        Route::match(['get', 'post'], '/invoice/sendOrderList', [
            'as' => 'admin.invoice.lists', 'acl' => 'admin.invoice.lists', 'uses' => 'InvoiceController@sendOrderList'
        ]);
        Route::match(['get', 'post'], '/invoice/completeOrderList', [
            'as' => 'admin.invoice.lists', 'acl' => 'admin.invoice.lists', 'uses' => 'InvoiceController@completeOrderList'
        ]);

        Route::get('/invoice/ajaxEdit', [
            'as' => 'admin.invoice.edit', 'acl' => 'admin.invoice.edit', 'uses' => 'InvoiceController@ajaxEdit'
        ]);
        Route::get('/invoice/rejected', [
            'as' => 'admin.invoice.rejected', 'acl' => 'admin.invoice.edit', 'uses' => 'InvoiceController@rejected'
        ]);
         Route::get('/invoice/through', [
             'as' => 'admin.invoice.through', 'acl' => 'admin.invoice.edit', 'uses' => 'InvoiceController@through'
         ]);
        Route::get('/invoice/history', [
            'as' => 'admin.invoice.history', 'acl' => 'admin.invoice.history', 'uses' => 'InvoiceController@history'
        ]);


        /**
         * 订单模版
         */
        Route::match(['get', 'post'], '/orderMould', [
            'as' => 'admin.order', 'acl' => 'admin.order.viewlist', 'uses' => 'OrderMouldController@index'
        ]);
        Route::get('/orderMould/create', [
            'as' => 'admin.order.create', 'acl' => 'admin.order.store', 'uses' => 'OrderMouldController@create'
        ]);
        Route::get('/orderMould/edit/{id}', [
            'as' => 'admin.order.edit', 'acl' => 'admin.order.store', 'uses' => 'OrderMouldController@edit'
        ]);
        Route::post('/orderMould/store', [
            'as' => 'admin.order.store', 'acl' => 'admin.order.store', 'uses' => 'OrderMouldController@store'
        ]);
        Route::post('/orderMould/deleted', [
            'as' => 'admin.order.create', 'acl' => 'admin.order.store', 'uses' => 'OrderMouldController@deleted'
        ]);

        /**
         * 财务付款
         */
        Route::get('/payment', [
            'as' => 'admin.payment', 'acl' => 'admin.payment.viewlist', 'uses' => 'PaymentController@home'
        ]);
        Route::post('/payment/ajaxCharge', [
            'as' => 'admin.payment.charge', 'acl' => 'admin.payment.charge', 'uses' => 'PaymentController@ajaxCharge'
        ]); //财务记账
        Route::post('/payment/ajaxReject', [
            'as' => 'admin.payment.reject', 'acl' => 'admin.payment.charge', 'uses' => 'PaymentController@ajaxReject'
        ]); //财务驳回
        Route::get('/payment/payableList', [
            'as' => 'admin.payment.payablelist', 'acl' => 'admin.payment.viewlist', 'uses' => 'PaymentController@payableList'
        ]);
        Route::get('/payment/editPayable', [
            'as' => 'admin.payment.editpayable', 'acl' => 'admin.payment.store', 'uses' => 'PaymentController@editPayable'
        ]);
        Route::get('/payment/detailedPayment', [
            'as' => 'admin.payment.detailed', 'acl' => 'admin.payment.viewlist', 'uses' => 'PaymentController@detailedPayment'
        ]);
        Route::post('/payment/updatePayable', [
            'as' => 'admin.payment.updatepayable', 'acl' => 'admin.payment.store', 'uses' => 'PaymentController@updatePayable'
        ]);
        Route::post('/payment/ajaxConfirmPay', [
            'as' => 'admin.payment.confirmpay', 'acl' => 'admin.payment.confrim', 'uses' => 'PaymentController@ajaxConfirmPay'
        ]);
        Route::get('/payment/completeList', [
            'as' => 'admin.payment.completelist', 'acl' => 'admin.payment.viewlist', 'uses' => 'PaymentController@completeList'
        ]);
        Route::match(['get', 'post'], '/payment/search', [
            'as' => 'admin.payment.search', 'acl' => 'admin.payment.viewlist', 'uses' => 'PaymentController@search'
        ]);
        Route::get('/payment/create', [
            'as' => 'admin.payment.create', 'acl' => 'admin.payment.store', 'uses' => 'PaymentController@create'
        ]);
        Route::any('/payment/storePayment', [
            'as' => 'admin.payment.store', 'acl' => 'admin.payment.store', 'uses' => 'PaymentController@storePayment'
        ]);
        Route::post('/payment/ajaxDestroy', [
            'as' => 'admin.payment.destroy', 'acl' => 'admin.payment.store', 'uses' => 'PaymentController@ajaxDestroy'
        ]);
        Route::get('/payment/brand', [//添加品牌付款单
            'as' => 'admin.payment.brand', 'acl' => 'admin.payment.store', 'uses' => 'PaymentController@brand'
        ]);
        Route::post('/payment/storeBrand', [//保存品牌付款单
            'as' => 'admin.payment.store', 'acl' => 'admin.payment.store', 'uses' => 'PaymentController@storeBrand'
        ]);

        Route::get('/payment/ajaxBrand', [//编辑获取订单明细
            'as' => 'admin.payment.sku', 'acl' => 'admin.payment.store', 'uses' => 'PaymentController@ajaxBrand'
        ]);
        Route::get('/payment/ajaxNum', [//添加/追加获取促销数量
            'as' => 'admin.payment.ajaxNum', 'acl' => 'admin.payment.store', 'uses' => 'PaymentController@ajaxNum'
        ]);

        Route::get('/payment/editNum', [//编辑获取促销数量
            'as' => 'admin.payment.editNum', 'acl' => 'admin.payment.store', 'uses' => 'PaymentController@editNum'
        ]);

        Route::get('/payment/ajaxAdd', [//添加获取订单明细
            'as' => 'admin.payment.ajaxAdd', 'acl' => 'admin.payment.store', 'uses' => 'PaymentController@ajaxAdd'
        ]);

        //品牌收款单列表
        Route::get('/payment/brandlist', [//展示品牌付款单
            'as' => 'admin.payment.brandlist', 'acl' => 'admin.payment.viewlist', 'uses' => 'PaymentController@brandlist'
        ]);
        Route::match(['get', 'post'], '/payment/brandIndex', [
            'as' => 'admin.payment.brandIndex', 'acl' => 'admin.payment.viewlist', 'uses' => 'PaymentController@brandIndex'
        ]);
        Route::match(['get', 'post'], '/payment/guanlianrenList', [
            'as' => 'admin.payment.guanlianrenList', 'acl' => 'admin.payment.viewlist', 'uses' => 'PaymentController@guanlianrenList'
        ]);
        Route::match(['get', 'post'], '/payment/unpublishList', [
            'as' => 'admin.payment.unpublishList', 'acl' => 'admin.payment.viewlist', 'uses' => 'PaymentController@unpublishList'
        ]);
        Route::match(['get', 'post'], '/payment/saleList', [
            'as' => 'admin.payment.saleList', 'acl' => 'admin.payment.viewlist', 'uses' => 'PaymentController@saleList'
        ]);
        Route::match(['get', 'post'], '/payment/cancList', [
            'as' => 'admin.payment.cancList', 'acl' => 'admin.payment.viewlist', 'uses' => 'PaymentController@cancList'
        ]);
        Route::match(['get', 'post'], '/payment/overList', [
            'as' => 'admin.payment.overList', 'acl' => 'admin.payment.viewlist', 'uses' => 'PaymentController@overList'
        ]);
        //品牌付款单详情
        Route::get('/payment/show', [
            'as' => 'admin.payment.show', 'acl' => 'admin.userSaleStatistics.viewList', 'uses' => 'PaymentController@show'
        ]);
        Route::get('/payment/edit', [
            'as' => 'admin.payment.edit', 'acl' => 'admin.payment.store', 'uses' => 'PaymentController@edit'
        ]);
        Route::post('/payment/update', [
            'as' => 'admin.payment.update', 'acl' => 'admin.payment.store', 'uses' => 'PaymentController@update'
        ]);
        Route::post('/payment/Destroy', [
            'as' => 'admin.payment.Destroy', 'acl' => 'admin.payment.store', 'uses' => 'PaymentController@Destroy'
        ]);
        Route::post('/payment/ajaxVerify', [
            'as' => 'admin.payment.ajaxVerify', 'acl' => 'admin.payment.viewlist', 'uses' => 'PaymentController@ajaxVerify'
        ]);


        /**
         * 收款单
         */
        Route::get('/receive', [//财务审核列表
            'as' => 'admin.receive', 'acl' => 'admin.finance.viewlist', 'uses' => 'ReceiveOrderController@index'
        ]);
        Route::post('/receive/ajaxCharge', [//财务审核
            'as' => 'admin.receive.ajaxCharge', 'acl' => 'admin.finance.verified', 'uses' => 'ReceiveOrderController@ajaxCharge'
        ]);

        Route::get('/receive/receive', [//收款单
            'as' => 'admin.receive.receive', 'acl' => 'admin.payment.viewlist', 'uses' => 'ReceiveOrderController@receive'
        ]);
        Route::get('/receive/complete', [
            'as' => 'admin.receive.complete', 'acl' => 'admin.payment.viewlist', 'uses' => 'ReceiveOrderController@complete'
        ]);
        Route::post('/receive/ajaxConfirmReceive', [
            'as' => 'admin.receive.confirm', 'acl' => 'admin.payment.confirm', 'uses' => 'ReceiveOrderController@ajaxConfirmReceive'
        ]);
        Route::get('/receive/editReceive', [
            'as' => 'admin.receive.edit', 'acl' => 'admin.payment.store', 'uses' => 'ReceiveOrderController@editReceive'
        ]);
        Route::post('/receive/updateReceive', [
            'as' => 'admin.receive.update', 'acl' => 'admin.payment.store', 'uses' => 'ReceiveOrderController@updateReceive'
        ]);
        Route::get('/receive/detailedReceive', [
            'as' => 'admin.receive.detailed', 'acl' => 'admin.payment.viewlist', 'uses' => 'ReceiveOrderController@detailedReceive'
        ]);
        Route::match(['get', 'post'], '/receive/search', [
            'as' => 'admin.receive.search', 'acl' => 'admin.payment.viewlist', 'uses' => 'ReceiveOrderController@search'
        ]);
        Route::get('/receive/createReceive', [
            'as' => 'admin.receive.create', 'acl' => 'admin.payment.store', 'uses' => 'ReceiveOrderController@createReceive'
        ]);
        Route::post('/receive/storeReceive', [
            'as' => 'admin.receive.store', 'acl' => 'admin.payment.store', 'uses' => 'ReceiveOrderController@storeReceive'
        ]);
        Route::post('/receive/ajaxDestroy', [
            'as' => 'admin.receive.destroy', 'acl' => 'admin.payment.store', 'uses' => 'ReceiveOrderController@ajaxDestroy'
        ]);

        Route::match(['get', 'post'], '/receive/receiveIndex', [
            'as' => 'admin.receive.receiveIndex', 'acl' => 'admin.payment.viewlist', 'uses' => 'ReceiveOrderController@receiveIndex'
        ]);
        Route::match(['get', 'post'], '/receive/guanlianrenList', [//销售
            'as' => 'admin.receive.guanlianrenList', 'acl' => 'admin.payment.viewlist', 'uses' => 'ReceiveOrderController@guanlianrenList'
        ]);
        Route::match(['get', 'post'], '/receive/saleList', [//负责人
            'as' => 'admin.receive.saleList', 'acl' => 'admin.payment.viewlist', 'uses' => 'ReceiveOrderController@saleList'
        ]);
        Route::match(['get', 'post'], '/receive/unpublishList', [
            'as' => 'admin.receive.unpublishList', 'acl' => 'admin.payment.viewlist', 'uses' => 'ReceiveOrderController@unpublishList'
        ]);
        Route::match(['get', 'post'], '/receive/cancList', [
            'as' => 'admin.receive.cancList', 'acl' => 'admin.payment.viewlist', 'uses' => 'ReceiveOrderController@cancList'
        ]);
        Route::match(['get', 'post'], '/receive/overList', [
            'as' => 'admin.receive.overList', 'acl' => 'admin.payment.viewlist', 'uses' => 'ReceiveOrderController@overList'
        ]);

        Route::get('/receive/channellist', [//渠道收款单列表
            'as' => 'admin.receive.channellist', 'acl' => 'admin.payment.viewlist', 'uses' => 'ReceiveOrderController@channellist'
        ]);
        Route::get('/receive/channel', [//添加渠道收款单
            'as' => 'admin.receive.channel', 'acl' => 'admin.payment.store', 'uses' => 'ReceiveOrderController@channel'
        ]);
        Route::post('/receive/storeChannel', [//保存渠道收款单
            'as' => 'admin.receive.storeChannel', 'acl' => 'admin.payment.store', 'uses' => 'ReceiveOrderController@storeChannel'
        ]);

        Route::get('/receive/ajaxChannel', [//编辑获取订单明细
            'as' => 'admin.receive.ajaxChannel', 'acl' => 'admin.payment.store', 'uses' => 'ReceiveOrderController@ajaxChannel'
        ]);
        Route::get('/receive/ajaxAdd', [//添加获取订单明细
            'as' => 'admin.receive.ajaxAdd', 'acl' => 'admin.payment.store', 'uses' => 'ReceiveOrderController@ajaxAdd'
        ]);

        Route::get('/receive/ajaxNum', [//添加或追加获取促销数量明细
            'as' => 'admin.receive.ajaxNum', 'acl' => 'admin.payment.store', 'uses' => 'ReceiveOrderController@ajaxNum'
        ]);

        Route::get('/receive/editNum', [//编辑获取促销数量
            'as' => 'admin.receive.editNum', 'acl' => 'admin.payment.store', 'uses' => 'ReceiveOrderController@editNum'
        ]);
        //渠道收款单详情
        Route::get('/receive/show', [
            'as' => 'admin.receive.show', 'acl' => 'admin.userSaleStatistics.viewList', 'uses' => 'ReceiveOrderController@show'
        ]);
        Route::get('/receive/edit', [
            'as' => 'admin.receive.edit', 'acl' => 'admin.payment.store', 'uses' => 'ReceiveOrderController@edit'
        ]);
        Route::post('/receive/update', [
            'as' => 'admin.receive.update', 'acl' => 'admin.payment.store', 'uses' => 'ReceiveOrderController@update'
        ]);
        Route::post('/receive/Destroy', [
            'as' => 'admin.receive.Destroy', 'acl' => 'admin.payment.store', 'uses' => 'ReceiveOrderController@Destroy'
        ]);

        Route::post('/receive/ajaxVerify', [//渠道审核
            'as' => 'admin.receive.ajaxVerify', 'acl' => 'admin.payment.viewlist', 'uses' => 'ReceiveOrderController@ajaxVerify'
        ]);


        /**
         * 省份
         */
        Route::get('/province', [
            'as' => 'admin.province', 'acl' => 'admin.setting.viewlist', 'uses' => 'ProvinceController@index'
        ]);
        Route::post('/province/store', [
            'as' => 'admin.province.store', 'acl' => 'admin.setting.store', 'uses' => 'ProvinceController@store'
        ]);
        Route::post('/province/update', [
            'as' => 'admin.province.update', 'acl' => 'admin.setting.store', 'uses' => 'ProvinceController@update'
        ]);
        Route::post('/province/edit', [
            'as' => 'admin.province.edit', 'acl' => 'admin.setting.store', 'uses' => 'ProvinceController@ajaxEdit'
        ]);
        Route::post('/province/destroy', [
            'as' => 'admin.province.destroy', 'acl' => 'admin.setting.destroy', 'uses' => 'ProvinceController@destroy'
        ]);

        /**
         * 城市
         */
        Route::get('/chinaCity', [
            'as' => 'admin.chinaCity', 'acl' => 'admin.chinaCity.viewlist', 'uses' => 'ChinaCitiesController@index'
        ]);
        Route::get('/ajaxFetchCity', [
            'as' => 'admin.ajaxFetchCity', 'acl' => 'admin.chinaCity.viewlist', 'uses' => 'ChinaCitiesController@ajaxFetchCity'
        ]);

        /**
         * 用户操作日志
         */
        Route::get('/record', [
            'as' => 'admin.record', 'acl' => 'admin.setting.viewlist', 'uses' => 'RecordController@index'
        ]);

        /**
         * 付款账户基础资料
         */
        Route::get('/paymentAccount', [
            'as' => 'admin.paymentAccount', 'acl' => 'admin.payment.viewlist', 'uses' => 'PaymentAccountController@index'
        ]);
        Route::post('/paymentAccount/store', [
            'as' => 'admin.paymentAccount.store', 'acl' => 'admin.payment.store', 'uses' => 'PaymentAccountController@store'
        ]);
        Route::get('/paymentAccount/edit', [
            'as' => 'admin.paymentAccount.edit', 'acl' => 'admin.payment.store', 'uses' => 'PaymentAccountController@ajaxEdit'
        ]);
        Route::post('/paymentAccount/update', [
            'as' => 'admin.paymentAccount.update', 'acl' => 'admin.payment.store', 'uses' => 'PaymentAccountController@update'
        ]);
        Route::post('/paymentAccount/destroy', [
            'as' => 'admin.paymentAccount.destroy', 'acl' => 'admin.payment.destroy', 'uses' => 'PaymentAccountController@ajaxDestroy'
        ]);

        /**
         * 订单退款
         */
        Route::get('/refund', [
            'as' => 'admin.refund', 'acl' => 'admin.refund.viewlist', 'uses' => 'RefundMoneyController@index'
        ]);
        Route::get('/refund/consentList', [
            'as' => 'admin.refund.consentlist', 'acl' => 'admin.refund.viewlist', 'uses' => 'RefundMoneyController@consentList'
        ]);
        Route::get('/refund/rejectList', [
            'as' => 'admin.refund.rejectList', 'acl' => 'admin.refund.viewlist', 'uses' => 'RefundMoneyController@rejectList'
        ]);
        Route::post('/refundMoney/ajaxConsentRefund', [
            'as' => 'admin.refund.consent', 'acl' => 'admin.refund.store', 'uses' => 'RefundMoneyController@ajaxConsentRefund'
        ]);
        Route::post('/refundMoney/ajaxRejectRefund', [
            'as' => 'admin.refund.reject', 'acl' => 'admin.refund.store', 'uses' => 'RefundMoneyController@ajaxRejectRefund'
        ]);

        /*
         *正能量
         */
        Route::get('/positiveEnergy', [
            'as' => 'admin.positiveEnergy', 'acl' => 'admin.positiveEnergy.viewlist', 'uses' => 'PositiveEnergyController@index'
        ]);

        Route::post('/positiveEnergy/store', [
            'as' => 'admin.positiveEnergy.store', 'acl' => 'admin.positiveEnergy.store', 'uses' => 'PositiveEnergyController@store'
        ]);

        Route::get('/positiveEnergy/edit', [
            'as' => 'admin.positiveEnergy.edit', 'acl' => 'admin.positiveEnergy.store', 'uses' => 'PositiveEnergyController@edit'
        ]);

        Route::post('/positiveEnergy/update', [
            'as' => 'admin.positiveEnergy.update', 'acl' => 'admin.positiveEnergy.store', 'uses' => 'PositiveEnergyController@update'
        ]);

        Route::post('/positiveEnergy/destroy', [
            'as' => 'admin.positiveEnergy.destroy', 'acl' => 'admin.positiveEnergy.destroy', 'uses' => 'PositiveEnergyController@destroy'
        ]);

        /**
         * 手动同步库存
         */
        Route::get('/synchronousStock', [
            'as' => 'admin.synchronousStock', 'acl' => 'admin.synchronousStock.store', 'uses' => 'SynchronousStockController@home'
        ]);
        Route::get('/synchronousStock/synchronous', [
            'as' => 'admin.synchronousStock.synchronous', 'acl' => 'admin.synchronousStock.store', 'uses' => 'SynchronousStockController@synchronous'
        ]);

        /**
         * 库存盘点相关操作
         */
        // 盘点记录列表
        Route::get('/takeStock/index', [
            'as' => 'admin.takeStock.index', 'acl' => 'admin.takeStock.viewlist', 'uses' => 'TakeStockController@index'
        ]);
        // createTakeStock 创建盘点
        Route::post('/createTakeStock', [
            'as' => 'admin.createTakeStock', 'acl' => 'admin.takeStock.viewlist', 'uses' => 'TakeStockController@createTakeStock'
        ]);
        //  盘点备注
        Route::post('/takeStock/addSummary', [
            'as' => 'admin.takeStock.addSummary', 'acl' => 'admin.takeStock.viewlist', 'uses' => 'TakeStockController@addSummary'
        ]);
        // ajaxDeleteTakeStock 删除盘点
        Route::post('/ajaxDeleteTakeStock', [
            'as' => 'admin.ajaxDeleteTakeStock', 'acl' => 'admin.takeStock.viewlist', 'uses' => 'TakeStockController@ajaxDeleteTakeStock'
        ]);
        // takeStockDetailed 盘点明细
        Route::get('/takeStockDetailed', [
            'as' => 'admin.takeStockDetailed', 'acl' => 'admin.takeStock.viewlist', 'uses' => 'TakeStockController@takeStockDetailed'
        ]);
        // ajaxSetSkuNumber 设置实际库存
        Route::post('/ajaxSetSkuNumber', [
            'as' => 'admin.ajaxSetSkuNumber', 'acl' => 'admin.takeStock.viewlist', 'uses' => 'TakeStockController@ajaxSetSkuNumber'
        ]);
        // ajaxTrue 确认盘点完毕
        Route::post('/takeStock/ajaxTrue', [
            'as' => 'admin.takeStock.ajaxTrue', 'acl' => 'admin.takeStock.viewlist', 'uses' => 'TakeStockController@ajaxTrue'
        ]);

        /**
         * 首页提示信息确认
         */
        Route::post('/home/ajaxConfirm', [
            'as' => 'admin.home.ajaxConfirm', 'acl' => 'admin.index.store', 'uses' => 'IndexController@ajaxConfirm'
        ]);

        /*
         * 会员管理
         */
        Route::get('/orderUser', [
            'as' => 'admin.orderUser', 'acl' => 'admin.orderUser.viewlist', 'uses' => 'OrderUserController@index'
        ]);

        Route::get('/orderUser/create', [
            'as' => 'admin.orderUser.create', 'acl' => 'admin.orderUser.store', 'uses' => 'OrderUserController@create'
        ]);

        Route::post('/orderUser/store', [
            'as' => 'admin.orderUser.store', 'acl' => 'admin.orderUser.store', 'uses' => 'OrderUserController@store'
        ]);

        Route::get('/orderUser/edit', [
            'as' => 'admin.orderUser.edit', 'acl' => 'admin.orderUser.store', 'uses' => 'OrderUserController@edit'
        ]);

        Route::post('/orderUser/update', [
            'as' => 'admin.orderUser.update', 'acl' => 'admin.orderUser.store', 'uses' => 'OrderUserController@update'
        ]);

        Route::get('/orderUser/destroy', [
            'as' => 'admin.orderUser.destroy', 'acl' => 'admin.orderUser.destroy', 'uses' => 'OrderUserController@destroy'
        ]);

        Route::match(['get', 'post'], '/orderUser/search', [
            'as' => 'admin.orderUser.search', 'acl' => 'admin.orderUser.viewlist', 'uses' => 'OrderUserController@search'
        ]);
        Route::get('/orderUser/ajaxOrderUser', [
            'as' => 'admin.orderUser.ajaxOrderUser', 'acl' => 'admin.orderUser.viewlist', 'uses' => 'OrderUserController@ajaxOrderUser'
        ]);
        Route::post('/orderUser/ajaxSearch', [
            'as' => 'admin.orderUser.ajaxSearch', 'acl' => 'admin.orderUser.viewlist', 'uses' => 'OrderUserController@ajaxSearch'
        ]);


        /**
         * 渠道客户销售统计
         */
        Route::get('/salesStatistics/user', [
            'as' => 'admin.salesStatistics.user', 'acl' => 'admin.salesStatistics.viewList', 'uses' => 'SalesStatisticsController@user'
        ]);
        Route::match(['get', 'post'], '/salesStatistics/search', [
            'as' => 'admin.salesStatistics.search', 'acl' => 'admin.salesStatistics.viewList', 'uses' => 'SalesStatisticsController@search'
        ]);
        Route::get('/salesStatistics/membershipList', [
            'as' => 'admin.salesStatistics.membershipList', 'acl' => 'admin.salesStatistics.viewList', 'uses' => 'SalesStatisticsController@membershipList'
        ]);
        Route::post('/salesStatistics/membershipSalesSearch', [
            'as' => 'admin.salesStatistics.membershipSalesSearch', 'acl' => 'admin.salesStatistics.viewList', 'uses' => 'SalesStatisticsController@membershipSalesSearch'
        ]);


        /**
         * 统计报表
         */
        Route::get('/count', [
            'as' => 'admin.count', 'acl' => 'admin.count.viewlist', 'uses' => 'CountController@index'
        ]);
        Route::post('/count/ingathering', [
            'as' => 'admin.count.ingathering', 'acl' => 'admin.count.viewlist', 'uses' => 'CountController@ingathering'
        ]);
        Route::post('/count/products', [
            'as' => 'admin.count.products', 'acl' => 'admin.count.viewlist', 'uses' => 'CountController@products'
        ]);
        Route::post('/count/commodityIncome', [
            'as' => 'admin.count.commodityIncome', 'acl' => 'admin.count.viewlist', 'uses' => 'CountController@commodityIncome'
        ]);
        Route::post('/count/skus', [
            'as' => 'admin.count.skus', 'acl' => 'admin.count.viewlist', 'uses' => 'CountController@skus'
        ]);


        /**
         * 销售人员销售统计
         */
        Route::match(['get', 'post'], '/userSaleStatistics/index', [
            'as' => 'admin.userSaleStatistics.user', 'acl' => 'admin.userSaleStatistics.viewList', 'uses' => 'UserSaleStatisticsController@index'
        ]);
        /**
         * 部门销售统计
         */
        Route::match(['get', 'post'], '/userSaleStatistics/department', [
            'as' => 'admin.userSaleStatistics.department', 'acl' => 'admin.userSaleStatistics.viewList', 'uses' => 'UserSaleStatisticsController@department'
        ]);

        /**
         * sku 销售统计
         */
        Route::match(['get', 'post'], '/statistics/skuSale', [
            'as' => 'admin.statistics.skuSale', 'acl' => 'admin.statistics.viewList', 'uses' => 'StatisticsController@skuSale'
        ]);


        /**
         * 采购订单列表
         */
        Route::get('/purchases', [
            'as' => 'admin.purchases.lists', 'acl' => 'admin.userSaleStatistics.viewList', 'uses' => 'PurchaseController@lists'
        ]);
        //采购订单详情
        Route::get('/purchases/showPurchases', [
            'as' => 'admin.purchases.show', 'acl' => 'admin.userSaleStatistics.viewList', 'uses' => 'PurchaseController@showPurchases'
        ]);
        /**
         * 采购发票列表
         */
        Route::get('/pInvoices', [
            'as' => 'admin.pInvoices.lists', 'acl' => 'admin.userSaleStatistics.viewList', 'uses' => 'PurchaseController@invoicesLists'
        ]);
        //采购发票详情
        Route::get('/pInvoices/showPInvoices', [
            'as' => 'admin.pInvoices.show', 'acl' => 'admin.userSaleStatistics.viewList', 'uses' => 'PurchaseController@showPInvoices'
        ]);
        /**
         * 销售订单列表
         */
        Route::get('/salesOrders', [
            'as' => 'admin.salesOrders.lists', 'acl' => 'admin.userSaleStatistics.viewList', 'uses' => 'OrderController@salesOrderLists'
        ]);
        //销售订单详情
        Route::get('/salesOrders/showSalesOrders', [
            'as' => 'admin.salesOrders.show', 'acl' => 'admin.userSaleStatistics.viewList', 'uses' => 'OrderController@showSalesOrders'
        ]);
        /**
         * 电商销售订单列表
         */
        Route::get('/ESSalesOrders', [
            'as' => 'admin.ESSalesOrders.lists', 'acl' => 'admin.userSaleStatistics.viewList', 'uses' => 'OrderController@ESSalesOrdersLists'
        ]);
        //电商销售订单详情
        Route::get('/ESSalesOrders/showESSalesOrders', [
            'as' => 'admin.ESSalesOrders.show', 'acl' => 'admin.userSaleStatistics.viewList', 'uses' => 'OrderController@showESSalesOrders'
        ]);
        /**
         * 销售发票列表
         */
        Route::get('/salesInvoices', [
            'as' => 'admin.salesInvoices.lists', 'acl' => 'admin.userSaleStatistics.viewList', 'uses' => 'OrderController@salesInvoicesLists'
        ]);
        //销售发票详情
        Route::get('/salesInvoices/showSalesInvoices', [
            'as' => 'admin.salesInvoices.show', 'acl' => 'admin.userSaleStatistics.viewList', 'uses' => 'OrderController@showSalesInvoices'
        ]);
        /**
         * 配送信息列表
         */
        Route::get('/deliveries', [
            'as' => 'admin.deliveries.lists', 'acl' => 'admin.userSaleStatistics.viewList', 'uses' => 'OrderController@deliveriesLists'
        ]);
        //配送信息详情
        Route::get('/deliveries/showDeliveries', [
            'as' => 'admin.deliveries.show', 'acl' => 'admin.userSaleStatistics.viewList', 'uses' => 'OrderController@showDeliveries'
        ]);

        /**
         * 供应商列表
         */
        Route::get('/suppliers', [
            'as' => 'admin.suppliers.list', 'acl' => 'admin.userSaleStatistics.viewList', 'uses' => 'SupplierController@suppliersLists'
        ]);

        /**
         * 供应商详情
         */
        Route::get('/suppliers/showSuppliers', [
            'as' => 'admin.suppliers.show', 'acl' => 'admin.userSaleStatistics.viewList', 'uses' => 'SupplierController@showSuppliers'
        ]);

        /**
         * 代发供应商订单
         */
        Route::get('/supplierOrder', [
            'as' => 'admin.suppliers.order', 'acl' => 'admin.userSaleStatistics.viewList', 'uses' => 'SupplierController@suppliersOrder'
        ]);

        /**
         * 供应商每月统计列表
         */
        Route::get('/supplierMonth', [
            'as' => 'admin.supplierMonth.list', 'acl' => 'admin.userSaleStatistics.viewList', 'uses' => 'SupplierController@supplierMonthLists'
        ]);

        /**
         * 供应商每月未确认统计列表
         */
        Route::get('/noSupplierMonth', [
            'as' => 'admin.supplierMonth.list', 'acl' => 'admin.userSaleStatistics.viewList', 'uses' => 'SupplierController@noSupplierMonthLists'
        ]);

        //供应商月统计１确认　０取消
        Route::get('/supplierMonth/{id}/status', [
            'as' => 'admin.supplierMonth.status', 'acl' => 'admin.userSaleStatistics.viewList', 'uses' => 'SupplierController@noStatus'
        ]);
        Route::get('/supplierMonth/{id}/noStatus', [
            'as' => 'admin.supplierMonth.status', 'acl' => 'admin.userSaleStatistics.viewList', 'uses' => 'SupplierController@status'
        ]);
        Route::get('/supplier/testSupplier', [
            'as' => 'admin.testSupplier.list', 'acl' => 'admin.userSaleStatistics.viewList', 'uses' => 'SupplierController@testSupplier'
        ]);


        /**
         * 导入记录
         */
        Route::get('/fileRecords', [
            'as' => 'admin.order', 'acl' => 'admin.order.viewlist', 'uses' => 'OrderController@fileRecords'
        ]);

        /**
         * 分发SaaS
         */
//        //商品列表
//        Route::match(['get', 'post'], '/saasProduct/lists', [
//            'as' => 'admin.saasProduct.lists', 'acl' => 'admin.saasProduct.viewList', 'uses' => 'SaasProductController@lists'
//        ]);
//        // 商品详情页面
//        Route::get('/saasProduct/info', [
//            'as' => 'admin.saasProduct.info', 'acl' => 'admin.saasProduct.viewList', 'uses' => 'SaasProductController@info'
//        ]);
//        // 添加关联分销商
//        Route::post('/saasProduct/ajaxSetCheck', [
//            'as' => 'admin.saasProduct.ajaxSetCheck', 'acl' => 'admin.saasProduct.store', 'uses' => 'SaasProductController@ajaxSetCheck'
//        ]);
//        // 取消分销商和用户的关联 ajaxDelete
//        Route::post('/saasProduct/ajaxDelete', [
//            'as' => 'admin.saasProduct.ajaxDelete', 'acl' => 'admin.saasProduct.store', 'uses' => 'SaasProductController@ajaxDelete'
//        ]);
//        // 编辑分销商看到的商品售价和库存
//        Route::post('/saasProduct/setProduct', [
//            'as' => 'admin.saasProduct.setProduct', 'acl' => 'admin.saasProduct.store', 'uses' => 'SaasProductController@setProduct'
//        ]);
//        // 编辑分销商看到的SKU售价
//        Route::post('/saasProduct/setSku', [
//            'as' => 'admin.saasProduct.setSku', 'acl' => 'admin.saasProduct.store', 'uses' => 'SaasProductController@setSku'
//        ]);
//        // 获取商品价格信息
//        Route::get('/saasProduct/getProduct', [
//            'as' => 'admin.saasProduct.getProduct', 'acl' => 'admin.saasProduct.store', 'uses' => 'SaasProductController@getProduct'
//        ]);
//        // 获取sku信息
//        Route::get('/saasProduct/getSku', [
//            'as' => 'admin.saasProduct.getSku', 'acl' => 'admin.saasProduct.store', 'uses' => 'SaasProductController@getSku'
//        ]);

        // 用户反馈
        Route::get('/saasFeedback', [
            'as' => 'admin.saasFeedback.lists', 'acl' => 'admin.saasProduct.viewList', 'uses' =>
                'SaasFeedbackController@lists'
        ]);


        /**
         * 素材库图片
         */
        Route::match(['get', 'post'], '/saas/image', [
            'as' => 'admin.materialLibraries', 'acl' => 'admin.saasProduct.viewList', 'uses' => 'MaterialLibrariesController@imageIndex'
        ]);
        Route::match(['get', 'post'], '/saas/image/noStatus', [
            'as' => 'admin.materialLibraries', 'acl' => 'admin.saasProduct.viewList', 'uses' => 'MaterialLibrariesController@imageNoStatusIndex'
        ]);
        Route::get('/saas/image/create', [
            'as' => 'admin.materialLibraries.store', 'acl' => 'admin.saasProduct.viewList', 'uses' => 'MaterialLibrariesController@imageCreate'
        ]);
        Route::post('/saas/image/store', [
            'as' => 'admin.materialLibraries.store', 'acl' => 'admin.saasProduct.viewList', 'uses' => 'MaterialLibrariesController@imageStore'
        ]);
        Route::get('/saas/image/edit/{materialLibrary_id}', [
            'as' => 'admin.materialLibraries.store', 'acl' => 'admin.saasProduct.viewList', 'uses' => 'MaterialLibrariesController@imageEdit'
        ]);
        Route::post('/saas/image/update', [
            'as' => 'admin.materialLibraries.store', 'acl' => 'admin.saasProduct.viewList', 'uses' => 'MaterialLibrariesController@imageUpdate'
        ]);
        /**
         * 素材库视频
         */
        Route::match(['get', 'post'], '/saas/video', [
            'as' => 'admin.materialLibraries', 'acl' => 'admin.saasProduct.viewList', 'uses' => 'MaterialLibrariesController@videoIndex'
        ]);
        Route::match(['get', 'post'], '/saas/video/noStatus', [
            'as' => 'admin.materialLibraries', 'acl' => 'admin.saasProduct.viewList', 'uses' => 'MaterialLibrariesController@videoNoStatusIndex'
        ]);
        Route::get('/saas/video/create', [
            'as' => 'admin.materialLibraries.store', 'acl' => 'admin.saasProduct.viewList', 'uses' => 'MaterialLibrariesController@videoCreate'
        ]);
        Route::post('/saas/video/store', [
            'as' => 'admin.materialLibraries.store', 'acl' => 'admin.saasProduct.viewList', 'uses' => 'MaterialLibrariesController@videoStore'
        ]);
        Route::get('/saas/video/edit/{materialLibrary_id}', [
            'as' => 'admin.materialLibraries.store', 'acl' => 'admin.saasProduct.viewList', 'uses' => 'MaterialLibrariesController@videoEdit'
        ]);
        Route::post('/saas/video/update', [
            'as' => 'admin.materialLibraries.store', 'acl' => 'admin.saasProduct.viewList', 'uses' => 'MaterialLibrariesController@videoUpdate'
        ]);

        /**
         * 素材库文字段
         */
        Route::match(['get', 'post'], '/saas/describe', [
            'as' => 'admin.materialLibraries', 'acl' => 'admin.saasProduct.viewList', 'uses' => 'MaterialLibrariesController@describeIndex'
        ]);
        Route::match(['get', 'post'], '/saas/describe/noStatus', [
            'as' => 'admin.materialLibraries', 'acl' => 'admin.saasProduct.viewList', 'uses' => 'MaterialLibrariesController@describeNoStatusIndex'
        ]);
        Route::get('/saas/describe/create', [
            'as' => 'admin.materialLibraries.store', 'acl' => 'admin.saasProduct.viewList', 'uses' => 'MaterialLibrariesController@describeCreate'
        ]);
        Route::post('/saas/describe/store', [
            'as' => 'admin.materialLibraries.store', 'acl' => 'admin.saasProduct.viewList', 'uses' => 'MaterialLibrariesController@describeStore'
        ]);
        Route::get('/saas/describe/edit/{materialLibrary_id}', [
            'as' => 'admin.materialLibraries.store', 'acl' => 'admin.saasProduct.viewList', 'uses' => 'MaterialLibrariesController@describeEdit'
        ]);
        Route::post('/saas/describe/update', [
            'as' => 'admin.materialLibraries.store', 'acl' => 'admin.saasProduct.viewList', 'uses' => 'MaterialLibrariesController@describeUpdate'
        ]);
        //删除
        Route::get('/saas/material/delete/{material_id}', [
            'as' => 'admin.materialLibraries.store', 'acl' => 'admin.saasProduct.viewList', 'uses' => 'MaterialLibrariesController@delete'
        ]);

        //更新material状态　１已审核　０草稿箱
        Route::get('/saas/material/{id}/unStatus', [
            'as' => 'admin.materialLibraries.store', 'acl' => 'admin.saasProduct.viewList', 'uses' => 'MaterialLibrariesController@unStatus'
        ]);
        Route::get('/saas/material/{id}/status', [
            'as' => 'admin.materialLibraries.store', 'acl' => 'admin.saasProduct.viewList', 'uses' => 'MaterialLibrariesController@status'
        ]);
        /**
         * 文章库
         */
        Route::match(['get', 'post'], '/saas/article', [
            'as' => 'admin.article', 'acl' => 'admin.saasProduct.viewList', 'uses' => 'ArticleController@articleIndex'
        ]);
        Route::match(['get', 'post'], '/saas/article/noStatus', [
            'as' => 'admin.article', 'acl' => 'admin.saasProduct.viewList', 'uses' => 'ArticleController@articleNoStatusIndex'
        ]);
        Route::get('/saas/article/create', [
            'as' => 'admin.article.store', 'acl' => 'admin.saasProduct.viewList', 'uses' => 'ArticleController@articleCreate'
        ]);
        Route::post('/saas/article/store', [
            'as' => 'admin.article.store', 'acl' => 'admin.saasProduct.viewList', 'uses' => 'ArticleController@articleStore'
        ]);
        Route::get('/saas/article/edit/{article_id}', [
            'as' => 'admin.article.store', 'acl' => 'admin.saasProduct.viewList', 'uses' => 'ArticleController@articleEdit'
        ]);
        Route::post('/saas/article/update', [
            'as' => 'admin.article.store', 'acl' => 'admin.saasProduct.viewList', 'uses' => 'ArticleController@articleUpdate'
        ]);
        Route::get('/saas/articles', [
            'as' => 'admin.articleList', 'acl' => 'admin.saasProduct.viewList', 'uses' => 'ArticleController@articles'
        ]);
        Route::post('/saas/article/imageUpload', [
            'as' => 'admin.article.store', 'acl' => 'admin.saasProduct.viewList', 'uses' => 'ArticleController@imageUpload'
        ]);
        //文章删除
        Route::get('/saas/article/delete/{article_id}', [
            'as' => 'admin.article.store', 'acl' => 'admin.saasProduct.viewList', 'uses' => 'ArticleController@delete'
        ]);
        //全部文章
        Route::get('/saas/atricleAll', [
            'as' => 'admin.article.store', 'acl' => 'admin.saasProduct.viewList', 'uses' => 'ArticleController@articleAll'
        ]);
        //更新article状态　１已审核　０草稿箱
        Route::get('/saas/article/{id}/unStatus', [
            'as' => 'admin.article.store', 'acl' => 'admin.saasProduct.viewList', 'uses' => 'ArticleController@unStatus'
        ]);
        Route::get('/saas/article/{id}/status', [
            'as' => 'admin.article.store', 'acl' => 'admin.saasProduct.viewList', 'uses' => 'ArticleController@status'
        ]);
        //更新saasType状态　１开放　０关闭
//        Route::get('/product/{id}/unSaasType', [
//            'as' => 'admin.product.saasType', 'acl' => 'admin.product.store', 'uses' => 'ProductController@unSaasType'
//        ]);
//        Route::get('/product/{id}/saasType', [
//            'as' => 'admin.product.saasType', 'acl' => 'admin.product.store', 'uses' => 'ProductController@saasType'
//        ]);


        /**
         * 站点管理
         */
        Route::get('/saas/site', [
            'as' => 'admin.site', 'acl' => 'admin.site.view', 'uses' => 'SiteController@siteIndex'
        ]);
        Route::get('/saas/site/create', [
            'as' => 'admin.site.store', 'acl' => 'admin.site.operate', 'uses' => 'SiteController@siteCreate'
        ]);
        Route::post('/saas/site/store', [
            'as' => 'admin.site.store', 'acl' => 'admin.site.operate', 'uses' => 'SiteController@siteStore'
        ]);
        Route::get('/saas/site/edit/{site_id}', [
            'as' => 'admin.site.store', 'acl' => 'admin.site.operate', 'uses' => 'SiteController@siteEdit'
        ]);
        Route::post('/saas/site/update', [
            'as' => 'admin.site.store', 'acl' => 'admin.site.operate', 'uses' => 'SiteController@siteUpdate'
        ]);
        //站点１开放　０关闭
        Route::get('/site/{id}/unStatus', [
            'as' => 'admin.site.status', 'acl' => 'admin.site.operate', 'uses' => 'SiteController@unStatus'
        ]);
        Route::get('/site/{id}/status', [
            'as' => 'admin.site.status', 'acl' => 'admin.site.operate', 'uses' => 'SiteController@status'
        ]);

        //删除
        Route::get('/saas/site/delete/{site_id}', [
            'as' => 'admin.site.store', 'acl' => 'admin.site.operate', 'uses' => 'SiteController@delete'
        ]);

        /**
         * 分销商
         */
        Route::get('/saas/user', [
            'as' => 'admin.user.store', 'acl' => 'admin.saasProduct.viewList', 'uses' => 'DistributorController@index'
        ]);
        Route::get('/saas/user/noStatus', [
            'as' => 'admin.user.store', 'acl' => 'admin.saasProduct.viewList', 'uses' => 'DistributorController@noStatusIndex'
        ]);
        Route::post('/saas/user/store', [
            'as' => 'admin.user.store', 'acl' => 'admin.saasProduct.viewList', 'uses' => 'DistributorController@store'
        ]);
        Route::get('/saas/user/ajaxEdit', [
            'as' => 'admin.user.store', 'acl' => 'admin.saasProduct.viewList', 'uses' => 'DistributorController@ajaxEdit'
        ]);
        Route::post('/saas/user/update', [
            'as' => 'admin.user.store', 'acl' => 'admin.saasProduct.viewList', 'uses' => 'DistributorController@update'
        ]);
        Route::post('/saas/user/destroy', [
            'as' => 'admin.user.destroy', 'acl' => 'admin.saasProduct.viewList', 'uses' => 'DistributorController@ajaxDestroy'
        ]);
        //更新user状态　１已审核　０草稿箱
        Route::get('/saas/user/{id}/unStatus', [
            'as' => 'admin.user.store', 'acl' => 'admin.saasProduct.viewList', 'uses' => 'DistributorController@unStatus'
        ]);
        Route::get('/saas/user/{id}/status', [
            'as' => 'admin.user.store', 'acl' => 'admin.saasProduct.viewList', 'uses' => 'DistributorController@status'
        ]);
        /**
         * 产品搜索
         */
        Route::match(['get', 'post'], '/saas/search', [
            'as' => 'admin.search', 'acl' => 'admin.saasProduct.viewList', 'uses' => 'MaterialLibrariesController@search'
        ]);


        /**
         * 经销商路由
         */
        /**
         * 经销商列表
         */
        Route::get('/distributors', [
            'as' => 'admin.distributors', 'acl' => 'admin.distributors.viewlist', 'uses' => 'DistributorsController@index'
        ]);
        Route::get('/distributors/details', [
            'as' => 'admin.distributors.verifyList', 'acl' => 'admin.distributors.viewlist', 'uses' => 'DistributorsController@details'
        ]);
        Route::match(['get', 'post'], '/distributors/search', [
            'as' => 'admin.distributors.search', 'acl' => 'admin.distributors.viewlist', 'uses' => 'DistributorsController@search'
        ]);
        Route::post('/distributors/ajaxVerify', [
            'as' => 'admin.distributors.ajaxVerify', 'acl' => 'admin.distributors.verified', 'uses' => 'DistributorsController@ajaxVerify'
        ]);
        Route::post('/distributors/ajaxClose', [
            'as' => 'admin.distributors.ajaxClose', 'acl' => 'admin.distributors.verified', 'uses' => 'DistributorsController@ajaxClose'
        ]);
        //删除经销商
        Route::post('/distributors/ajaxDestroy', [
            'as' => 'admin.distributors.ajaxDestroy', 'acl' => 'admin.distributors.store', 'uses' => 'DistributorsController@ajaxDestroy'
        ]);

    });
});

Route::group(['middleware' => ['auth']], function () {

    //图片删除
    Route::post('/asset/ajaxDelete', 'Common\AssetController@ajaxDelete');

    //文章图片删除
    Route::post('/material/ajaxDelete', 'Home\MaterialLibrariesController@ajaxDelete');

    /*Route::get('/refund/refundMoney','RefundMoneyController@refundMoney');
    Route::get('/refund/createRefundMoney','RefundController@createRefundMoney');
    Route::get('/refund/ajaxOrder','RefundController@ajaxOrder');
    Route::post('/refund/storeRefundMoney','RefundController@storeRefundMoney');*/

    //timingTask
    Route::get('/timingTask', 'TestController@timingTask');

    /**
     * 订单导出excel
     */
    Route::post('/excel', 'Common\ExcelController@orderList');

    Route::post('/purchaseList', 'Common\ExcelController@purchaseList');//采购订单导出
    Route::post('/channelLists', 'Common\ExcelController@channelLists');//渠道收款订单导出

    Route::post('/inexcel', 'Common\ExcelController@inFile');
    Route::post('/paymentExcel', 'Common\ExcelController@paymentList');
    Route::post('/dateGetPaymentExcel', 'Common\ExcelController@dateGetPayment');

    Route::post('/zcInExcel', 'Common\ExcelController@zcInFile');
    Route::post('/contactsInExcel', 'Common\ExcelController@contactsInExcel');
    Route::post('/logisticsInExcel', 'Common\ExcelController@logisticsInExcel');

    //收入列表
    Route::get('/receiveExcel', 'Common\ExcelController@receive');
    //按时间搜索
    Route::match(['get', 'post'], '/receiveExcel/search', 'Common\ExcelController@receiveSearch');
    //收款导出
    Route::post('/dateGetReceiveExcel', 'Common\ExcelController@dateGetReceive');

    //采购列表
    Route::get('/dateGetPurchasesExcel', 'Common\ExcelController@Purchases');
    //按时间搜索
    Route::match(['get', 'post'], '/dateGetPurchasesExcel/search', 'Common\ExcelController@PurchasesSearch');
    //采购导出
    Route::post('/dateGetPurchasesExcel', 'Common\ExcelController@dateGetPurchases');

    // 导出代发供应商订单
    Route::post('/getDaiFaSupplierData', 'Common\ExcelController@getDaiFaSupplierData');

    // 导入代发供应商订单物流信息
    Route::post('/daiFaSupplierInput', 'Common\ExcelController@daiFaSupplierInput');

    // 导出渠道分销商订单
    Route::post('/getQuDaoDistributorData', 'Common\ExcelController@getQuDaoDistributorData');

    // 导入分销渠订单信息
    Route::post('/quDaoDistributorInput', 'Common\ExcelController@quDaoDistributorInput');

    // 导出渠道分销商订单
    Route::post('/supplierExcel', 'Common\ExcelController@supplierExcel');

    //采购到导入
    Route::post('/purchaseExcel', 'Common\ExcelController@purchaseExcel');
    Route::post('/channelExcel', 'Common\ExcelController@channelExcel');//渠道收款单导入

});

// 下载附件
Route::get('/asset/download', 'Common\AssetController@download');

