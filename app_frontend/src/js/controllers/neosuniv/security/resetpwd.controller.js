/*
 * This file is part of the NeosUniversity Software.
 *
 * (c) Neossoftware Corporation
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Mario Hidalgo aka neossoftware
 */

'use strict';

// signup controller
app.controller('ResetPasswordController', ['$scope', 'authFactory', '$state', function ($scope, authFactory, $state) {
    $scope.user = {};

    $scope.muestraAcceso = false;

    $scope.alerts = [];
    //console.log('reset pwd controller');

    $scope.requestReset = function () {
        $scope.alerts = [];

        $scope.service = authFactory.requestResetPwd($scope.user);

        $scope.service.then(
            // OnSuccess function
            function (res) {
                $scope.alerts.push({type:'success', msg: 'Si tu email esta registrado en NeosUniversity recibirás un correo electronico para resetear tu password'});
            },
            // OnFailure function
            function (reason) {
                $scope.alerts.push({msg: 'Error de comunicación con el servidor'});

            }
        ).finally(function () {
            //console.log('This finally block');
            // $scope.loading = false;
        });


    };


}])
;