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
app.controller('ResetPasswordEmailController', ['$scope', 'authFactory', '$stateParams','toaster',
    function ($scope, authFactory, $stateParams,toaster) {
        $scope.user = {password: '', email: '', hash: ''};

        $scope.alerts = [];
        $scope.validLink = false;
       // console.log('reset pwd email controller');
        var email = $stateParams.email;
        var hash = $stateParams.hash;

        $scope.user.email = email;
        $scope.user.hash = hash;

        $scope.toaster = {
            type: 'success',
            title: 'Cambio de password',
            text: 'El password se cambió de forma exitosa'
        };
        //validate URL

        $scope.serviceUrl = authFactory.validateUrl($scope.user);
        $scope.serviceUrl.then(
            // OnSuccess function
            function (res) {

                if (res.data.code !==0 ) {
                    $scope.alerts.push({msg: res.data.message});

                } else {
                    $scope.validLink = true;
                }


            },
            // OnFailure function
            function (reason) {
                $scope.alerts.push({msg: 'Error de comunicación con el servidor'});

            }
        ).finally(function () {

            //console.log('This finally block');
            // $scope.loading = false;
        });


        /**
         * Realiza el cambio de password del usuario
         * */
        $scope.changePwd = function () {
            $scope.alerts = [];

            $scope.service = authFactory.changePassword($scope.user);
            $scope.service.then(
                // OnSuccess function
                function (res) {
                    $scope.toaster.text = res.data.message;
                    if (res.data.code !==0 ) {
                        $scope.toaster.type = 'error';
                        toaster.pop($scope.toaster.type, $scope.toaster.title, $scope.toaster.text);
                    } else {
                        $scope.toaster.type = 'success';
                        toaster.pop($scope.toaster.type, $scope.toaster.title, $scope.toaster.text);
                        $scope.validLink = false;
                    }


                   // console.log(res);
                },
                // OnFailure function
                function (reason) {
                    $scope.alerts.push({msg: 'Error de comunicación con el servidor'});

                }
            ).finally(function () {
                //console.log('This finally block');
                // $scope.loading = false;
            });


        }


    }])
;