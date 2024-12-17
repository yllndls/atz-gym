'use strict';
userApp.controller('CronController', ['$scope', '$interval', 'Membership', function($sc, $interval, Membership) {

    $sc.initService = function() {
        console.log('INITIALIZE CRON RUNNING TIME');

        $sc.intervalPromise = $interval(function() {
            var current_date = new Date();
            var getHours = current_date.getHours();
            var getMinutes = current_date.getMinutes();
            var getSeconds = current_date.getSeconds();

            console.warn(getHours,':',getMinutes,':',getSeconds);

            // - runn query every day @ 23:59:59
             if (getHours == 23 && getMinutes == 59 && getSeconds == 59) {
                $sc.membershipExpiration();
             }
        }, 1000);
    }

    $sc.membershipExpiration = function() {
        var params = {
            is_running_flg: true
        }

        Membership.expiredMembership(params)
		.then(function(res) {
            console.log('CHECKING FOR EXPIRED MEMBERSHIP ~ ', res.total_count);
		})
		.fail(function(err) {
			console.error('CRON ~ ERROR: ', err);
		})
		.always(function() {
			$sc.$apply();
		});
    }
}]);


