/*
 * This file is part of the NeosUniversity Software.
 *
 * (c) Neossoftware Corporation
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

'use strict';

// signup controller
app.controller('SignupSuccessController', ['$scope', 'authFactory', '$state', function($scope, authFactory, $state) {
    $scope.user = {};

    $scope.alerts = [];
    //console.log('success');

    /*
    $scope.signup = function() {

        $scope.alerts = [];



        $scope.service.then(

            function(res) {

                if (res.data && res.data.code==0) {
                    $scope.alerts.push({type: 'success',
                        msg: res.data.message});

                } else if (res.data && res.data.code==1) {
                    $scope.alerts.push({msg: res.data.message});
                } else {
                    $scope.alerts.push({msg: 'Error de comunicación con el servidor'});
                }
            },

            function(reason) {
                $scope.alerts.push({msg: 'Error de comunicación con el servidor'});

            }
        ).catch(function (reason) {

            console.log('Encountered server error');

        });


    }; */
}])
;