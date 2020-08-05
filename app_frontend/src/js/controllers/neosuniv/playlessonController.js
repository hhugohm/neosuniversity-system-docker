'use strict';

/* git controller */

// bootstrap controller
app.controller('PlayController', ['$scope','$stateParams', 'courseFactory','$state','$sce', function ($scope,$stateParams, courseFactory,$state,$sce) {

   // console.log("Play controller running");

/*
    var iframe = document.querySelector('iframe');
    var player = new Vimeo.Player(iframe);

    player.on('play', function() {
        console.log('played the video!');
    });

    player.on('ended', function() {
        console.log('Video Finalizado');
        player.unload().then(function() {
        }).catch(function(error) {
        });
    });

    player.getVideoTitle().then(function(title) {
        console.log('title:', title);
    });*/


    $scope.isFirstOpen = true;
    $scope.isOpen = false;

    $scope.courseId = 'git';
    $scope.params = {};

    $scope.params.classId = $stateParams.classId;
    $scope.params.controlPanelId = $stateParams.controlPanelId;
    $scope.params.sectionId = $stateParams.sectionId;

   // console.log( $scope.params);

    $scope.twClassProm = courseFactory.getTwClass($scope.params);
    $scope.twClassProm.then(function (tw_class) {
           // console.log(tw_class);
            $scope.tw_class = tw_class;
            if ($scope.tw_class.data.files.length !== 0) {
                $scope.files = $scope.tw_class.data.files;
                $scope.showListFiles = true;
            } else {
                $scope.showListFiles = false;
            }

        },
        function (error) {
            console.log(error);
        });


    $scope.twClassUpdate = courseFactory.saveTwClassComplete($scope.params);
    $scope.twClassUpdate.then(function (response) {
            console.log(response);

        },
        function (error) {
            console.log(error);
        });

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
       // console.log(tw_class);
        var description = encodeURIComponent(tw_class.clase.classdescription);
        $state.go('app.playlesson', {controlPanelId: tw_class.control_panel_id,classId:tw_class.class_id, sectionId:tw_class.section_id, description: description},
            {reload:true});
        //({controlPanelId:{{tw_class.control_panel_id}}, classId:{{tw_class.class_id}}, sectionId:{{tw_class.section_id}} }

    }

    $scope.status = {
        isFirstOpen: true,
        isFirstDisabled: false
    };

    $scope.tabs = [
        {title: 'Mi titulo', "open": true},
        {title: 'Mi titulo 2', "open": false},
        {title: 'Mi titulo 2', "open": false},
        {title: 'Mi titulo 2', "open": false},
        {title: 'Mi titulo 2', "open": false},
        {title: 'Mi titulo 2', "open": false},
        {title: 'Mi titulo 2', "open": false}
    ];


    $scope.trustSrc = function(src) {
        return $sce.trustAsResourceUrl(src);
    }

}]);
