'use strict';

/**
* pwd check directive
**/
angular.module('app')
  .directive('fieldCheck', [function () {
    return {
      require: 'ngModel',
      link: function (scope, elem, attrs, ctrl) {
        var firstField = '#' + attrs.fieldCheck;
        elem.add(firstField).on('keyup', function () {
          scope.$apply(function () {
            var v = elem.val()===$(firstField).val();
            ctrl.$setValidity('fieldmatch', v);
          });
        });
      }
    }
  }]);