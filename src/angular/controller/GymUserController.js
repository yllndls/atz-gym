'use strict';
userApp
.controller(
	'GymUserController', 
	['$scope', '$rootScope', '$interval', '$timeout', 'User',
	function($sc, $rs, $interval, $timeout, User) {
		$sc.formData = {};
		$sc.user = {};
		$sc.validate = {
			flag: false,
			type: null,
			message: null
		};

		$sc.resetFields = function() {
			$sc.user = {
				type_id: '', 
				fname: '',
				lname: '',
				email: '',
				password: '',
				confirm_password: ''
			};
		}

		$sc.registrationBtn = function() {
			$sc.formData = {
				type_id: 2,
				fname: $sc.user.fname,
				lname: $sc.user.lname,
				email: $sc.user.email,
				password: $sc.user.password,
				confirm_password: $sc.user.confirm_password
			}
			$sc.registration($sc.formData);
		}

		$sc.registration = function(params) {

			User.registration(params)
			.then(function(res) {
				if (!res.success) {
					Swal.fire({
						icon: "error",
						title: "INVALID",
						text: res.message,
					});
                } else {
					Swal.fire({
						icon: "success",
						title: "SUCCESS",
						text: res.message,
					});

					$sc.resetFields();
				}
			})
			.fail(function(err) {
				console.error('REGISTRATION ~ ERROR: ', err);
			})
			.always(function() {
				$timeout(function() {
					$sc.validate.flag = false;
				},3000);
				$sc.$apply();
			});
		}
	
	}
]);
