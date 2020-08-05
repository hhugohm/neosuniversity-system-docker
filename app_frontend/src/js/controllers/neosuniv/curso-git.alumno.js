'use strict';

/* git controller */

// bootstrap controller
app.controller('GitController', ['$scope', 'courseFactory','$state', function ($scope, courseFactory,$state) {

    //console.log('hello world controller ');

    $scope.userLogged = $scope.$parent.$parent.$parent.userLogged;

    $scope.params = {
        //user logged
        email: $scope.userLogged.mail,
        courseId: 1,
    };

    $scope.twSections = courseFactory.getTwCourseSections($scope.params);
    $scope.twSections.then(function (sections) {
           // console.log(sections.data);
            $scope.sections = sections.data;
        },

        function (error) {
            console.log(error);
        });

    $scope.playLesson = function(tw_class) {
        //console.log(tw_class);
        var description = encodeURIComponent(tw_class.clase.classdescription);
        $state.go('app.playlesson', {controlPanelId: tw_class.control_panel_id,classId:tw_class.class_id, sectionId:tw_class.section_id, description: description});
        //({controlPanelId:{{tw_class.control_panel_id}}, classId:{{tw_class.class_id}}, sectionId:{{tw_class.section_id}} }

    }


}]);
