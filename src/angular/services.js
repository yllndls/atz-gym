// - use strict
'use strict'
userApp.factory('Ajax', ['$http', function($http) {
	var fac = {};

	fac.ajaxAction = function(obj) {
		return $.ajax({
			url: obj.url,
			type: obj.method,
			data: obj.data,
			dataType: "json"
		});
	}
	
	return fac;
}]);

userApp.factory('User', ['$http', 'Ajax', function($http, a) {
	var fac = {};

	fac.registration = function(params){
		params = {
			url: PROVIDERS_URL.registration,
			method: 'POST',
			data: params
		};
		
		return a.ajaxAction(params)
	}

	return fac;
}]);

userApp.factory('Membership', ['$http', 'Ajax', function ($http, a) {
    var fac = {};

    fac.availMembership = function (params) {
        return $http({
            url: PROVIDERS_URL.avail_membership,
            method: 'POST',
            data: params,
            headers: { 'Content-Type': undefined },
            transformRequest: angular.identity,
        });
    };

	fac.expiredMembership = function(params) {
		params = {
			url: PROVIDERS_URL.expired_membership,
			method: 'POST',
			data: params
		};
		
		return a.ajaxAction(params)
	}

    return fac;
}]);

userApp.factory('Transaction', ['$http', 'Ajax', function($http, a) {
	var fac = {};

	fac.membershipTransaction = function(params){
		params = {
			url: PROVIDERS_URL.membership_transaction,
			method: 'POST',
			data: params
		};
		
		return a.ajaxAction(params)
	}

	fac.membershipHistory = function(params){
		params = {
			url: PROVIDERS_URL.membership_history,
			method: 'POST',
			data: params
		};
		
		return a.ajaxAction(params)
	}

	return fac;
}]);


userApp.factory('Cart', ['$http', 'Ajax', function($http, a) {
	var fac = {};

	fac.carList = function(params){
		params = {
			url: PROVIDERS_URL.cart_list,
			method: 'POST',
			data: params
		};
		
		return a.ajaxAction(params)
	}

	fac.addToCart = function(params){
		params = {
			url: PROVIDERS_URL.cart_added,
			method: 'POST',
			data: params
		};
		
		return a.ajaxAction(params)
	}

	fac.updateCart = function(params){
		params = {
			url: PROVIDERS_URL.cart_updated,
			method: 'POST',
			data: params
		};
		
		return a.ajaxAction(params)
	}

	fac.removeToCart = function(params){
		params = {
			url: PROVIDERS_URL.cart_remove,
			method: 'POST',
			data: params
		};
		
		return a.ajaxAction(params)
	}

	fac.checkOut = function(params) {
        return $http({
            url: PROVIDERS_URL.checkout_product,
            method: 'POST',
            data: params,
            headers: { 'Content-Type': 'application/json' }
        });
    };
	fac.checkOutTransaction = function(params) {
		return $http({
			url: PROVIDERS_URL.checkout_transaction,
			method: 'POST',
			data: params,
			headers: { 'Content-Type': undefined },
			transformRequest: angular.identity,
		});
	};

	fac.orderDetails = function(params){
		params = {
			url: PROVIDERS_URL.order_details,
			method: 'POST',
			data: params,
			headers: { 'Content-Type': 'application/json' }
		};
		
		return a.ajaxAction(params)
	}

	fac.adminOrderDetails = function(params){
		params = {
			url: PROVIDERS_URL.admin_order_details,
			method: 'POST',
			data: params,
			headers: { 'Content-Type': 'application/json' }
		};
		
		return a.ajaxAction(params)
	}

	fac.orderStatusChange = function(params){
		params = {
			url: PROVIDERS_URL.order_status_change,
			method: 'POST',
			data: params,
			headers: { 'Content-Type': 'application/json' }
		};
		
		return a.ajaxAction(params)
	}

	return fac;
}]);
