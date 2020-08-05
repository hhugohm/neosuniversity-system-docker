/*
 * This file is part of the NeosUniversity Software.
 *
 * (c) Neossoftware Corporation
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Mario Hidalgo aka neossoftware
 * 2018
 */

'use strict';
app.controller('SuccessPagoController', ['$scope', 'courseFactory', '$state', '$stateParams',
    function ($scope, courseFactory, $state, $stateParams ) {

        $scope.data =  $stateParams.data;

        if ($scope.data===null || $scope.data===undefined) {
            $state.go('app.dashboard-v1');
        }

        $scope.viewCourses = function () {
            $state.go('app.dashboard-v1');
        }


    }]);