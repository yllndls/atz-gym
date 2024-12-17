'use strict';
userApp.controller('GymTransactionController', ['$scope', 'Membership', 'Transaction', function($sc, Membership, Transaction) {

	$sc.paymentType = "0";
	$sc.gcashPaymentFlg = false;
	$sc.isProcessFlg = false;
	$sc.validate = {
		flag: false,
		type: null,
		message: null
	};

	$sc.selectedMembership = {};
	$sc.memberInfo = {};

	$sc.isPastDateFlg = false;
	$sc.validateMessage = null;

	$sc.arr_history_data = [];

    $sc.selectPaymentType = function () {
		$sc.gcashPaymentFlg = ($sc.paymentType == "1");
    };

    $sc.submitAvailMembership = function () {
		var formData = new FormData();
			formData.append('user_id', $("input[name='user_id']").val());
			formData.append('plan_id', $("input[name='plan_id']").val());
			formData.append('membership_status', $("input[name='membership_status']").val());
			formData.append('is_expired_flg', $("input[name='is_expired_flg']").val());
			formData.append('membership_amount', $("input[name='membership_amount']").val());
			formData.append('payment_type', $("input[name='payment_type']:checked").val());
			formData.append('receipt', $("input[name='receipt']")[0].files[0]);
			formData.append('reference_no', $("input[name='reference_no']").val());
			formData.append('gcash_no', $("input[name='gcash_no']").val());

		// - profile validate
		if ($("input[name='is_profile_flg']").val() == 0) {
			var swalParam = {
				icon: 'info',
				title: 'COMPLETE YOUR PROFILE',
				html: 'Update your profile to avail membership plan.',
				link: 'settings.php',
			};
			SwalAlert(swalParam);

			return;
		}

		// - payment type validate
		if ($("input[name='payment_type']:checked").val() == 1) {
			var receipt = $("input[name='receipt']")[0].files[0];
			var gcashNo = $("input[name='gcash_no']").val();
			var referenceNo = $("input[name='reference_no']").val();

			if (!gcashNo || (!receipt && !referenceNo)) {
				Swal.fire({
					icon: "error",
					title: "FAILED PROCESS",
					text: "Provide your GCash Number, receipt or reference no.",
				});
				return;
			}
		}

		Membership.availMembership(formData)
		.then(function(response) {
			if (!!response.data.success) {
				var swalParam = {
					icon: 'success',
					title: 'SUCCESS',
					html: response.data.message,
					link: 'my-plan.php',
				};
				SwalAlert(swalParam);

			} else {
				var swalParam = {
					icon: 'error',
					title: 'EXISTING PLAN',
					html: response.data.message,
					link: 'my-plan.php',
				};
				SwalAlert(swalParam);
			}

		})
		.catch(function(err) {
			console.error('ERROR:', err);
		})
	}

	$sc.membershipModal = function(membership) {
		$sc.selectedMembership = angular.copy(membership);
		$sc.memberInfo = angular.copy(membership);

		// - start & expired date convertion
		$sc.selectedMembership.starting_date = null;
   		$sc.selectedMembership.expiration_date = null;

		// - amount to received
		$sc.selectedMembership.amount_received = parseFloat($sc.selectedMembership.amount);
	}

	$sc.membershipDetailModal = function(detail) {
		$sc.arr_history_data = [];

		$sc.memberInfo = angular.copy(detail);
		var formData = {
			user_id: $sc.memberInfo.user_id
		}
		console.warn(formData);

		Transaction.membershipHistory(formData)
		.then(function(res) {
			console.warn(res);
			if (!!res.success) {
				$sc.arr_history_data = res.data;
			} else {
				$sc.arr_history_data = [];
			}
		})
		.fail(function(err) {
			console.error('MEMBERSHIP HISTORY ~ ERROR: ', err);
		})
		.always(function() {
			$sc.$apply();
		});
	}	

	$sc.receivedMembershipTransaction = function () {
		if (typeof $sc.selectedMembership.expiration_date == 'undefined') {
			$sc.selectedMembership.expiration_date = null;
			return;
		}
		
		var formData = {
			membership_id: $sc.selectedMembership.membership_id,
			received_by: $("input[name='received_by']").val(),
			starting_date: formatDateToYMD($sc.selectedMembership.starting_date),
        	expiration_date: formatDateToYMD($sc.selectedMembership.expiration_date),
			amount_received: $sc.selectedMembership.amount_received
		};

		Transaction.membershipTransaction(formData)
		.then(function(res) {
			if (!!res.success) {
				$('#checMembership').hide();
				var swalParam = {
					icon: 'success',
					title: 'TRANSACTION SUCCESS',
					html: 'Membership payment is already received',
					link: 'membership.php?membership_code=' + $sc.selectedMembership.membership_code,
				};
				SwalAlert(swalParam);
			} else {
				Swal.fire({
					icon: "error",
					title: "TRANSACTIONF AILED",
					text: 'Membership transaction failure',
				});
			}
		})
		.fail(function(err) {
			console.error('MEMBERSHIP TRANSACTION ~ ERROR: ', err);
		})
		.always(function() {
			$sc.$apply();
		});
	};

	$sc.calculateExpirationDate = function () {
		$sc.isPastDateFlg = false;

		var daysDuration = parseInt($sc.selectedMembership.days_duration, 10);
		var startingDate = new Date($sc.selectedMembership.starting_date);
		var currentDate = new Date();

		// = check if starting date is in past
		if (startingDate < currentDate.setHours(0, 0, 0, 0)) { 
			$sc.isPastDateFlg = true;
			$sc.selectedMembership.expiration_date = null;
			return;
		}
	
		// Calculate expiration date
		var expirationDate = new Date(startingDate);
		expirationDate.setDate(expirationDate.getDate() + daysDuration);
	
		// Set expiration date
		$sc.selectedMembership.expiration_date = expirationDate;
	};
	
	function formatDateToYMD(date) {
        var parsedDate = new Date(date);
        return parsedDate.toISOString().split('T')[0];
    }

	function SwalAlert(data) {
		console.warn(data);
		
		let timerInterval;
		Swal.fire({
			icon: data.icon,
			title: data.title,
			html: data.html,
			timer: 2000,
			timerProgressBar: true,
			didOpen: () => {
				Swal.showLoading();

				const timer = Swal.getPopup().querySelector("b");
				timerInterval = setInterval(() => {
					timer.textContent = Math.ceil(Swal.getTimerLeft() / 1000);
				}, 1000);
			},
			willClose: () => {
				clearInterval(timerInterval);
			}
		}).then((result) => {
			if (result.dismiss === Swal.DismissReason.timer) {
				window.location.href = data.link;
			}
		});
	}

}]);
