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
app.controller('TemarioController', ['$scope', 'courseFactory', '$state', 'toaster', '$stateParams', 'uiGridConstants',
    function ($scope, courseFactory, $state, toaster, $stateParams, uiGridConstants) {

        $scope.courseId =  $stateParams.courseId;
        $scope.courseName = decodeURIComponent($stateParams.courseName);

        $scope.showlist = true;
        $scope.showAltaUnidad = false;
        $scope.showAltaClass = false;
        $scope.unidad = {};
        $scope.clase = {};

        $scope.showModifyUnidad = function(item) {
            $scope.unidad = {};

            $scope.unidad = {
                sectionId  : item.sectionId,
                description: item.description
            };

            $scope.viewModifUnidad();

            //console.log($scope.unidad);

        };

        $scope.showNewFile = function() {

            $scope.file = {
                sectionId : $scope.clase.sectionId,
                classId :  $scope.clase.classId,
                fileName: '',
                filePath : ''
            }

            $scope.viewNewFile();
        };

        $scope.showModifyFile = function(file) {

            $scope.file= {
                id: file.id,
                sectionId : file.section_id,
                classId :  file.class_id,
                fileName:  file.file_name,
                filePath : file.file_path
            };
            $scope.viewModifyFile();

        };

        $scope.showModifyClase = function(item) {

            $scope.item_ = item;
            $scope.clase = {};
            $scope.clase = {
                nombreUnidad : item.sectionObj.description,
                classDescription: item.description,
                videoURL : item.videoUrl,
                sectionId : item.sectionObj.sectionId,
                classId : item.classId
            };

            courseFactory.getFilesByClass({ sectionId: $scope.clase.sectionId, classId: $scope.clase.classId }).then(function(response) {
               $scope.files = response.data;
            }, function (reason) {
                $scope.toaster.type = 'error';
                toaster.pop($scope.toaster.type, "Error", reason.data.error);
            });

            //load files related to class

            $scope.viewModifClase();
        }

        $scope.addClass = function(item) {
            $scope.clase = {};
            $scope.clase.sectionId = item.sectionId;
            $scope.clase.nombreUnidad = item.description;
            $scope.viewAltaClass();
            //console.log(item);

        };



        /**
         * formatea la fila en dado caso de ser una clase
         * */
        $scope.rowFormatter = function(row) {
            return !row.entity.isSection;
        };

        $scope.gridOptions = {
            //data: data,
            enableColumnMenus:false,
            gridMenuShowHideColumns :false,
            enableFiltering: true,
            enableGridMenu: true,
            enableColumnResizing :true,
            showTreeExpandNoChildren: false,
            enableRowSelection : false,
            rowTemplate:     '<div ng-class="{\'blue\': grid.appScope.rowFormatter(row)}"><div ng-repeat="(colRenderIndex, col) in colContainer.renderedColumns track by col.colDef.name" class="ui-grid-cell" ng-class="{ \'ui-grid-row-header-cell\': col.isRowHeader }" ui-grid-cell></div>blue',
            enableVerticalScrollbar: uiGridConstants.NEVER,

            columnDefs: [
                {
                    field: 'sectionnumber',
                    name: 'Unidad/Clase' ,
                    width: '10%',
                    enableFiltering :false

                },
                {
                    field:'description',
                    name: 'Descripcion',
                    width: '60%'
                },

                {
                    field: 'isSection',
                    name : 'Agregar clase',
                    enableFiltering :false,
                    cellTemplate : '<div class="ui-grid-cell-contents ng-scope ng-binding" ng-class="col.colIndex()">  <button ng-if="row.entity.isSection"  type="button"  ng-click="grid.appScope.addClass(row.entity)" class="btn btn-primary btn-xs">  <i class="fa fa-book" aria-hidden="true"></i></button>  </div>'

                },

                {
                    field: 'isSection',
                    name : 'Modificar',
                    enableFiltering :false,
                    cellTemplate : '<div class="ui-grid-cell-contents ng-scope ng-binding" ng-class="col.colIndex()"> ' +
                    ' <button ng-if="row.entity.isSection"  type="button"  ng-click="grid.appScope.showModifyUnidad(row.entity)" class="btn btn-info btn-xs">  <i class="fa fa-pencil" aria-hidden="true"></i></button> ' +
                    '<button ng-if="!row.entity.isSection"  type="button"  ng-click="grid.appScope.showModifyClase(row.entity)" class="btn btn-info btn-xs">  <i class="fa fa-pencil" aria-hidden="true"></i></button>' +
                    ' </div>'

                }

            ],
            onRegisterApi: function( gridApi ) {
                $scope.gridApi = gridApi; // i'd recommend a promise or deferred for this

                $scope.gridApi.grid.registerDataChangeCallback(function() {
                  // $scope.gridApi.treeBase.expandAllRows();
                });
            }
        };




        $scope.toaster = {
            type: 'success',
            title: 'Nuevo Curso',
            text: ''
        };

        $scope.regresarClase = function() {

            $scope.showModifyClase($scope.item_);

        }

        $scope.saveNewFile = function(form) {
          if (!form.$invalid) {
              courseFactory.addFileToClass($scope.file).then(function (response) {
                  $scope.toaster.type = 'success';
                  toaster.pop($scope.toaster.type, "Sucess!", response.data.message);
                  $scope.showModifyClase($scope.item_);
              }, function (reason) {
                  $scope.toaster.type = 'error';
                  toaster.pop($scope.toaster.type, "Error", reason.data.error);
              });
          }

        };


        $scope.updateFile = function(form) {
            if (form.$valid) {

                courseFactory.updateFile($scope.file).then(function (response) {
                    $scope.toaster.type = 'success';
                    toaster.pop($scope.toaster.type, "Sucess!", response.data.message);
                    $scope.showModifyClase($scope.item_);
                }, function (reason) {
                    $scope.toaster.type = 'error';
                    toaster.pop($scope.toaster.type, "Error", reason.data.error);
                });
            }

        };

        $scope.saveNewClase = function(form) {

            if (form.$valid) {

                courseFactory.saveNewClass($scope.clase).then(function (response) {
                    $scope.toaster.type = 'success';
                    toaster.pop($scope.toaster.type, "Sucess!", response.data.message);

                    $scope.listSections();
                    $scope.viewTree();
                }, function (reason) {
                    $scope.toaster.type = 'error';
                    toaster.pop($scope.toaster.type, "Error", reason.data.error);
                });
            }

        };

        $scope.regresar = function() {

            $scope.viewTree();

        }
        
        $scope.saveModifUnidad = function () {

            courseFactory.updateSection($scope.unidad).then(function(response) {
                $scope.toaster.type = 'success';
                toaster.pop($scope.toaster.type, "Sucess!", response.data.message);

                $scope.listSections();
                $scope.viewTree();
            }, function (reason) {
                $scope.toaster.type = 'error';
                toaster.pop($scope.toaster.type, "Error", reason.data.error);
            });
            
        }


        $scope.saveNewSection =  function() {

            var params = {
                sectionName : $scope.unidad.sectionName,
                courseId : $scope.courseId
            }

            courseFactory.saveNewSection(params).then(function (response) {

                $scope.toaster.type = 'success';
                toaster.pop($scope.toaster.type, "Sucess!", response.data.message);

                $scope.listSections();
                $scope.viewTree();

            }, function (reason) {
                $scope.toaster.type = 'error';
                toaster.pop($scope.toaster.type, "Error", reason.data.error);
            }) ;
        };

        $scope.saveModifClase = function(form) {

            if (form.$valid) {

                courseFactory.updateClase($scope.clase).then(function (response) {
                    $scope.toaster.type = 'success';
                    toaster.pop($scope.toaster.type, "Sucess!", response.data.message);

                    $scope.listSections();
                    $scope.viewTree();
                }, function (reason) {
                    $scope.toaster.type = 'error';
                    toaster.pop($scope.toaster.type, "Error", reason.data.error);
                });
            }

        }


        $scope.listSections = function () {

            $scope.getallSections = courseFactory.getCourseSections({courseId: $scope.courseId });



            $scope.getallSections.then(function (res) {
               $scope.sections = res.data;
               $scope.tree = $scope.getTreeSections($scope.sections);
               $scope.gridOptions.data =  $scope.tree;
            }, function (reason) {
                $scope.toaster.type = 'error';
               toaster.pop($scope.toaster.type, "Error", reason.data.error);
            });
        };



        $scope.listSections();

        /**
         * obtiene todas las secciones mas las clases en forma de arbol para el grid
         *
         * */
        $scope.getTreeSections = function(sections) {

            var tree = [];

            angular.forEach(sections, function(section, index) {
                var element = {
                    sectionnumber: section.sectionnumber,
                    description: section.description,
                    isSection :  true,
                    $$treeLevel: 0,
                    sectionId : section.id
                };
                tree.push(element);
                //agregar los elementos hijos
                angular.forEach(section.classes, function(clase, index2) {
                    var sectiontmp = {
                        description: section.description,
                        sectionId: section.id
                    };

                    var elemt = {
                        sectionnumber: clase.class_id,
                        description: clase.classdescription,
                         isSection : false,
                        $$treeLevel: 1,
                        sectionId: section.id,
                        videoUrl : clase.videourl,
                        classId : clase.class_id,
                        sectionObj: sectiontmp
                    };

                    tree.push(elemt);

                });
            });

            return tree;
        }


        $scope.viewModifyFile = function() {
            $scope.showModifFile = true;
            $scope.showAddFile = false;
            $scope.showlist = false;
            $scope.showAltaUnidad = false;
            $scope.showAltaClass = false;
            $scope.showModifUnidad = false;
            $scope.showModifClass = false;

        }

        $scope.viewNewFile = function() {
            $scope.showAddFile = true;
            $scope.showlist = false;
            $scope.showAltaUnidad = false;
            $scope.showAltaClass = false;
            $scope.showModifUnidad = false;
            $scope.showModifClass = false;
            $scope.showModifFile = false;

        };

        $scope.viewAltaUnidad = function() {

            $scope.showlist = false;
            $scope.showAltaUnidad = true;
            $scope.showAltaClass = false;
            $scope.showModifUnidad = false;
            $scope.showModifClass = false;
            $scope.showAddFile = false;
            $scope.showModifFile = false;
        };

        $scope.viewAltaClass = function() {

            $scope.showlist = false;
            $scope.showAltaUnidad = false;
            $scope.showAltaClass = true;
            $scope.showModifUnidad = false;
            $scope.showModifClass = false;
            $scope.showAddFile = false;
            $scope.showModifFile = false;
        };

        $scope.viewModifUnidad = function() {

            $scope.showlist = false;
            $scope.showAltaUnidad = false;
            $scope.showAltaClass = false;
            $scope.showModifUnidad = true;
            $scope.showModifClass = false;
            $scope.showAddFile = false;
            $scope.showModifFile = false;
        };

        $scope.viewModifClase = function() {

            $scope.showlist = false;
            $scope.showAltaUnidad = false;
            $scope.showAltaClass = false;
            $scope.showModifUnidad = false;
            $scope.showModifClass = true;
            $scope.showAddFile = false;
            $scope.showModifFile = false;
        };

        $scope.viewTree = function () {

            $scope.showlist = true;
            $scope.showAltaUnidad = false;
            $scope.showAltaClass = false;
            $scope.showModifUnidad = false;
            $scope.showModifClass = false;
            $scope.showAddFile = false;
            $scope.showModifFile = false;
        }




    }]);