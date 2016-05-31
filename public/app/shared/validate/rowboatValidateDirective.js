var module = angular.module('uls');
module.directive('rowboatRequired', function() {
        return {
            restrict: 'A',
            require: 'ngModel',
            link: function($scope, $element, $attrs, ngModel) {
                if(typeof $scope.$eval($attrs.ngModel) == 'undefined') {                    
                    ngModel.$setValidity('rowboatRequired', false);
                }
                $element.on('focus', function (evt) {
                    $scope.$watch($attrs.ngModel, function(value) {
                        var isValid = (typeof value != 'undefined' && value.length != 0);
                        if (isValid) {
                            $element.parent().find('span').remove();                            
                            $element.parent().removeClass('error');
                            ngModel.$setValidity('rowboatRequired', isValid);
                        } else {
                            if ($element.parent().find('span').length == 0) {
                                $element.parent().addClass('error');
                                var content = '<span class="control-label">It is required</span>';
                                $element.parent().append(content);
                                ngModel.$setValidity('rowboatRequired', isValid);
                            }
                        }
                    });
                });
            }
        }
});

module.directive('rowboatLength', function() {
    return {
        restrict: 'A',
        require: 'ngModel',
        link: function($scope, $element, $attrs, ngModel) {
            if(typeof $scope.$eval($attrs.ngModel) != 'undefined' && $scope.$eval($attrs.ngModel).length != $attrs.rowboatLength) {
                ngModel.$setValidity('rowboatLength', false);
            }

            $element.on('focus', function (evt) {
                $scope.$watch($attrs.ngModel, function(value) {
                    var Length = $attrs.rowboatLength;
                    var isValid = (typeof value != 'undefined' && value.length == Length);
                    if (isValid) {
                        $element.parent().find('span').remove();                            
                        $element.parent().removeClass('error');
                        ngModel.$setValidity('rowboatLength', isValid);
                    } else {
                        if ($element.parent().find('span').length == 0) {
                            $element.parent().addClass('error');
                            var content = '<span class="control-label">Length is ' + Length + '</span>';
                            $element.parent().append(content);
                            ngModel.$setValidity('rowboatLength', isValid);
                        }
                    }
                });
            });
        }
    }
});

module.directive('rowboatMinLength', function() {
    return {
        restrict: 'A',
        require: 'ngModel',
        link: function($scope, $element, $attrs, ngModel) {
            if(typeof $scope.$eval($attrs.ngModel) != 'undefined' && $scope.$eval($attrs.ngModel).length < $attrs.rowboatMinLength) {
                ngModel.$setValidity('rowboatMinLength', false);
            }            
            $element.on('focus', function (evt) {
                $scope.$watch($attrs.ngModel, function(value) {
                    var minLength = $attrs.rowboatMinLength;
                    var isValid = (typeof value != 'undefined' && value.length >= minLength);
                    if (isValid) {
                        $element.parent().find('span').remove();                            
                        $element.parent().removeClass('error');
                        ngModel.$setValidity('rowboatMinLength', isValid);
                    } else {
                        if ($element.parent().find('span').length == 0) {
                            $element.parent().addClass('error');
                            var content = '<span class="control-label">Min length is ' + minLength + '</span>';
                            $element.parent().append(content);
                            ngModel.$setValidity('rowboatMinLength', isValid);
                        }
                    }
                });
            });
        }
    }
});

module.directive('rowboatMaxLength', function() {
    return {
        restrict: 'A',
        require: 'ngModel',
        link: function($scope, $element, $attrs, ngModel) {
            if(typeof $scope.$eval($attrs.ngModel) != 'undefined' && $scope.$eval($attrs.ngModel).length > $attrs.rowboatMaxLength) {
                ngModel.$setValidity('rowboatMaxLength', false);
            }

            $element.on('focus', function (evt) {
                $scope.$watch($attrs.ngModel, function(value) {
                    var maxLength = $attrs.rowboatMaxLength;
                    var isValid = (typeof value != 'undefined' && value.length <= maxLength);
                    if (isValid) {
                        $element.parent().find('span').remove();                            
                        $element.parent().removeClass('error');
                        ngModel.$setValidity('rowboatMaxLength', isValid);
                    } else {
                        if ($element.parent().find('span').length == 0) {
                            $element.parent().addClass('error');
                            var content = '<span class="control-label">Max length is ' + maxLength + '</span>';
                            $element.parent().append(content);
                            ngModel.$setValidity('rowboatMaxLength', isValid);
                        }
                    }
                });
            });
        }
    }
});

module.directive('rowboatEmailPattern', function() {
    return {
        restrict: 'A',
        require: 'ngModel',
        link: function($scope, $element, $attrs, ngModel) {
            $pattern = /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/;
            if(typeof $scope.$eval($attrs.ngModel) == 'undefined') {
                ngModel.$setValidity('rowboatEmailPattern', false);
            }
            $element.on('blur', function (evt) {
                $scope.$watch($attrs.ngModel, function(value) {
                    var isValid = (typeof value != 'undefined' && $pattern.test(value));
                    if (isValid) {
                        $element.parent().find('span').remove();                            
                        $element.parent().removeClass('error');
                        ngModel.$setValidity('rowboatEmailPattern', isValid);
                    } else {
                        if ($element.parent().find('span').length == 0) {
                            $element.parent().addClass('error');
                            var content = '<span class="control-label">Email Invalid</span>';
                            $element.parent().append(content);
                            ngModel.$setValidity('rowboatEmailPattern', isValid);
                        }
                    }
                });
            });
        }
    }
});