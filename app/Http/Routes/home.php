<?php

/*
|--------------------------------------------------------------------------
| 应用程序前台路由
|--------------------------------------------------------------------------
*/

Route::group(['middleware' => ['auth'], 'namespace' => 'Home'], function() {
    Route::get('/',[
        'as' => 'admin.index', 'acl' => 'admin.index', 'uses' => 'IndexController@index'
    ]);
    
    Route::get('/home',[
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
        Route::match(['get', 'post'],'/user/search', [
            'as' => 'admin.user.search', 'acl' => 'admin.user.viewlist', 'uses' => 'UserController@search'
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
            'as' => 'admin.roleUser', 'acl' => 'admin.role.viewlist',  'uses' => 'RoleController@show'
        ]);
        Route::get('/roleUser/edit', [
            'as' => 'admin.roleUser.edit', 'acl' => 'admin.role.store',  'uses' => 'RoleController@roleUserEdit'
        ]);
        Route::post('/roleUser/store', [
            'as' => 'admin.roleUser.store', 'acl' => 'admin.role.store',  'uses' => 'RoleController@roleUserStore'
        ]);
        Route::post('/roleUser/destroy', [
            'as' => 'admin.roleUser.destroy', 'acl' => 'admin.role.destroy', 'uses' => 'RoleController@roleUserDestroy'
        ]);
        
        /**
         * 角色权限相关路由
         */
        Route::get('/permission', [
            'as' => 'admin.permission', 'acl' => 'admin.role.viewlist',  'uses' => 'PermissionController@index'
        ]);
        Route::post('/permission/store', [
            'as' => 'admin.permission.store', 'acl' => 'admin.role.store',  'uses' => 'PermissionController@store'
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
        Route::match(['get', 'post'],'/storageSkuCount/search', [
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
        Route::match(['get', 'post'],'/storageSkuCount/productSearch', [
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
        Route::match(['get', 'post'],'/storageSkuCount/storageCostSearch', [
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
        Route::match(['get', 'post'],'/supplier/search', [
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
        Route::match(['get', 'post'],'/consignor/search', [
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
        Route::match(['get', 'post'],'/product', [
            'as' => 'admin.product', 'acl' => 'admin.product.viewlist', 'uses' => 'ProductController@index'
        ]);
        Route::match(['get', 'post'],'/product/unpublishList', [
            'as' => 'admin.product.unpublishList', 'acl' => 'admin.product.viewlist', 'uses' => 'ProductController@unpublishList'
        ]);
        Route::match(['get', 'post'],'/product/saleList', [
            'as' => 'admin.product.saleList', 'acl' => 'admin.product.viewlist', 'uses' => 'ProductController@saleList'
        ]);
        Route::match(['get', 'post'],'/product/cancList', [
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
        Route::match(['get', 'post'],'/product/search', [
            'as' => 'admin.product.search', 'acl' => 'admin.product.viewlist', 'uses' => 'ProductController@search'
        ]);
        Route::post('/product/ajaxUpShelves', [
            'as' => 'admin.product.up', 'acl' => 'admin.product.verified', 'uses' => 'ProductController@upShelves'
        ]);
        Route::post('/product/ajaxDownShelves', [
            'as' => 'admin.product.down', 'acl' => 'admin.product.verified', 'uses' => 'ProductController@downShelves'
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
        
        /**
         * 分类
         */
        Route::get('/category', [
            'as' => 'admin.category', 'acl' => 'admin.setting.viewlist', 'uses' => 'CategoryController@index'
        ]);
        Route::post('/category/store',[
            'as' => 'admin.category.store', 'acl' => 'admin.setting.store', 'uses' => 'CategoryController@store'
        ]);
        Route::get('/category/ajaxEdit',[
            'as' => 'admin.category.edit', 'acl' => 'admin.setting.store', 'uses' => 'CategoryController@ajaxEdit'
        ]);
        Route::post('/category/update',[
            'as' => 'admin.category.update', 'acl' => 'admin.setting.store', 'uses' => 'CategoryController@update'
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
        Route::match(['get', 'post'],'/purchase/search', [
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
        Route::match(['get', 'post'],'/returned/search', [
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
        Route::match(['get', 'post'],'/enterWarehouse/search', [
            'as' => 'admin.enter.warehouse.search', 'acl' => 'admin.warehouse.viewlist', 'uses' => 'EnterWarehouseController@search'
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
        Route::match(['get', 'post'],'/outWarehouse/search', [
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
            'as' => 'admin.change.warehouse.destroy', 'acl' => 'admin.warehouse.destroy', 'uses' => 'ChangeWarehouseController@ajaxDestroy'
        ]);
        Route::post('/changeWarehouse/ajaxVerified', [
            'as' => 'admin.change.warehouse.verified', 'acl' => 'admin.warehouse.verify', 'uses' => 'ChangeWarehouseController@ajaxVerified'
        ]);
        Route::post('/changeWarehouse/ajaxDirectorVerified', [
            'as' => 'admin.change.warehouse.directorVerified', 'acl' => 'admin.warehouse.verify', 'uses' => 'ChangeWarehouseController@ajaxDirectorVerified'
        ]);
        Route::match(['get', 'post'],'/changeWarehouse/search', [
            'as' => 'admin.change.warehouse.search', 'acl' => 'admin.warehouse.viewlist', 'uses' => 'ChangeWarehouseController@search'
        ]);
        
        /**
         * 订单
         */
        Route::match(['get', 'post'],'/order', [
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
        Route::match(['get', 'post'],'/order/reversedOrderList', [
            'as' => 'admin.order.reversedlist', 'acl' => 'admin.order.viewlist', 'uses' => 'OrderController@reversedOrderList'
        ]);
        Route::post('/order/ajaxVerifyOrder', [
            'as' => 'admin.order.verifyorder', 'acl' => 'admin.order.verify', 'uses' => 'OrderController@ajaxVerifyOrder'
        ]);
        Route::post('/order/ajaxReversedOrder', [
            'as' => 'admin.order.reversedorder', 'acl' => 'admin.order.verify', 'uses' => 'OrderController@ajaxReversedOrder'
        ]);
        Route::match(['get', 'post'],'/order/sendOrderList', [
            'as' => 'admin.order.sendorderlist', 'acl' => 'admin.order.viewlist', 'uses' => 'OrderController@sendOrderList'
        ]);
        Route::post('/order/ajaxSendOrder', [
            'as' => 'admin.order.sendorder', 'acl' => 'admin.order.send', 'uses' => 'OrderController@ajaxSendOrder'
        ]);
        Route::match(['get', 'post'],'/order/nonOrderList', [
            'as' => 'admin.order.nonorderlist', 'acl' => 'admin.order.viewlist', 'uses' => 'OrderController@nonOrderList'
        ]);
        Route::match(['get', 'post'],'/order/completeOrderList', [
            'as' => 'admin.order.completelist', 'acl' => 'admin.order.viewlist', 'uses' => 'OrderController@completeOrderList'
        ]);
        Route::get('/order/ajaxSkuSearch', [
            'as' => 'admin.order.skusearch', 'acl' => 'admin.order.viewlist', 'uses' => 'OrderController@ajaxSkuSearch'
        ]);
        Route::match(['get', 'post'],'/order/servicingOrderList', [
            'as' => 'admin.order.servicingOrderList', 'acl' => 'admin.order.viewlist', 'uses' => 'OrderController@servicingOrderList'
        ]);
        Route::match(['get', 'post'],'/order/finishedOrderList', [
            'as' => 'admin.order.finishedOrderList', 'acl' => 'admin.order.viewlist', 'uses' => 'OrderController@finishedOrderList'
        ]);
        Route::match(['get', 'post'],'/order/closedOrderList', [
            'as' => 'admin.order.closedOrderList', 'acl' => 'admin.order.viewlist', 'uses' => 'OrderController@closedOrderList'
        ]);
        Route::post('/order/splitOrder', [
            'as' => 'admin.order.splitOrder', 'acl' => 'admin.order.verify', 'uses' => 'OrderController@splitOrder'
        ]);
        Route::match(['get', 'post'],'/order/search', [
            'as' => 'admin.order.search', 'acl' => 'admin.order.viewlist', 'uses' => 'OrderController@search'
        ]);
        
        Route::match(['get', 'post'],'/order/userSaleList', [
            'as' => 'admin.order.userSaleList', 'acl' => 'admin.user.stats', 'uses' => 'OrderController@userSaleList'
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
        Route::match(['get', 'post'],'/payment/search', [
            'as' => 'admin.payment.search', 'acl' => 'admin.payment.viewlist', 'uses' => 'PaymentController@search'
        ]);
        Route::get('/payment/create', [
            'as' => 'admin.payment.create', 'acl' => 'admin.payment.store', 'uses' => 'PaymentController@create'
        ]);
        Route::post('/payment/storePayment', [
            'as' => 'admin.payment.store', 'acl' => 'admin.payment.store', 'uses' => 'PaymentController@storePayment'
        ]);
        Route::post('/payment/ajaxDestroy', [
            'as' => 'admin.payment.destroy', 'acl' => 'admin.payment.store', 'uses' => 'PaymentController@ajaxDestroy'
        ]);
        
        /**
         * 收款单
         */
        Route::get('/receive', [
            'as' => 'admin.receive', 'acl' => 'admin.payment.viewlist', 'uses' => 'ReceiveOrderController@index'
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
        Route::match(['get', 'post'],'/receive/search', [
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
         * 首页提示信息确认
         */
        Route::post('/home/ajaxConfirm',[
            'as' => 'admin.home.ajaxConfirm', 'acl' => 'admin.index.store', 'uses' => 'IndexController@ajaxConfirm'
        ]);

        /*
         * 会员管理
         */
        Route::get('/orderUser', [
            'as' => 'admin.orderUser' , 'acl' => 'admin.orderUser.viewlist' , 'uses' => 'OrderUserController@index'
        ]);

        Route::get('/orderUser/create', [
            'as' => 'admin.orderUser.create' , 'acl' => 'admin.orderUser.store' , 'uses' => 'OrderUserController@create'
        ]);

        Route::post('/orderUser/store', [
            'as' => 'admin.orderUser.store' , 'acl' => 'admin.orderUser.store' , 'uses' => 'OrderUserController@store'
        ]);

        Route::get('/orderUser/edit', [
            'as' => 'admin.orderUser.edit' , 'acl' => 'admin.orderUser.store' , 'uses' => 'OrderUserController@edit'
        ]);

        Route::post('/orderUser/update', [
            'as' => 'admin.orderUser.update' , 'acl' => 'admin.orderUser.store' , 'uses' => 'OrderUserController@update'
        ]);

        Route::get('/orderUser/destroy', [
            'as' => 'admin.orderUser.destroy' , 'acl' => 'admin.orderUser.destroy' , 'uses' => 'OrderUserController@destroy'
        ]);

        Route::match(['get', 'post'],'/orderUser/search', [
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
            'as' => 'admin.salesStatistics.user' , 'acl' => 'admin.salesStatistics.viewList' , 'uses' => 'SalesStatisticsController@user'
        ]);
        Route::match(['get', 'post'],'/salesStatistics/search', [
            'as' => 'admin.salesStatistics.search' , 'acl' => 'admin.salesStatistics.viewList' , 'uses' => 'SalesStatisticsController@search'
        ]);
        Route::get('/salesStatistics/membershipList', [
            'as' => 'admin.salesStatistics.membershipList' , 'acl' => 'admin.salesStatistics.viewList' , 'uses' => 'SalesStatisticsController@membershipList'
        ]);
        Route::post('/salesStatistics/membershipSalesSearch', [
            'as' => 'admin.salesStatistics.membershipSalesSearch' , 'acl' => 'admin.salesStatistics.viewList' , 'uses' => 'SalesStatisticsController@membershipSalesSearch'
        ]);

        /**
         * 销售人员销售统计
         */
        Route::match(['get', 'post'], '/userSaleStatistics/index', [
            'as' => 'admin.userSaleStatistics.user' , 'acl' => 'admin.userSaleStatistics.viewList' , 'uses' => 'UserSaleStatisticsController@index'
        ]);
        /**
         * 部门销售统计
         */
        Route::match(['get', 'post'], '/userSaleStatistics/department', [
            'as' => 'admin.userSaleStatistics.department' , 'acl' => 'admin.userSaleStatistics.viewList' , 'uses' => 'UserSaleStatisticsController@department'
        ]);

        /**
         * sku 销售统计
         */
        Route::match(['get', 'post'], '/statistics/skuSale', [
            'as' => 'admin.statistics.skuSale' , 'acl' => 'admin.statistics.viewList' , 'uses' => 'StatisticsController@skuSale'
        ]);


    });
});   

Route::group(['middleware' => ['auth']], function () {
    
    //图片删除
    Route::post('/asset/ajaxDelete','Common\AssetController@ajaxDelete');

    /*Route::get('/refund/refundMoney','RefundMoneyController@refundMoney');
    Route::get('/refund/createRefundMoney','RefundController@createRefundMoney');
    Route::get('/refund/ajaxOrder','RefundController@ajaxOrder');
    Route::post('/refund/storeRefundMoney','RefundController@storeRefundMoney');*/

    //timingTask
    Route::get('/timingTask','TestController@timingTask');

    /**
     * 订单导出excel
     */
    Route::post('/excel','Common\ExcelController@orderList');
});

