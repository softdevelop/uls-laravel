describe('ModalCreateFolderBlockCtrl', function() {
    beforeEach(module('uls'));
    beforeEach(module('BlockApp'));

    var $controller;
    var $model;
    var $modalInstance;
    var form;
    var $compile;
    var $httpBackend;

    beforeEach(inject(function(_$controller_, _$modal_, _$compile_, $rootScope, _$httpBackend_){

        $modalInstance = {                    // Create a mock object using spies
            close: jasmine.createSpy('modalInstance.close'),
            dismiss: jasmine.createSpy('modalInstance.dismiss'),
            result: {
                then: jasmine.createSpy('modalInstance.result.then')
            }
        };
        $controller = _$controller_;
        $modal = _$modal_;
        $compile = _$compile_;
        $scope = $rootScope.$new();

        $httpBackend = _$httpBackend_;

        $httpBackend.when('GET', /app\/shared\/select\-level\/view\.html/).respond(200);

        var element = angular.copy(angular.element(window.contentView));

        var formData = element.find('form');

        //form create block
        $compile(formData)($scope);
        form = $scope.createFolderForm;
        $scope.$digest();
    }));

    describe('check form create directory block', function() {
        it('check form is invalid', function() {
            var $scope = {};
            var controller = $controller('ModalCreateFolderBlockCtrl', { $scope: $scope, '$modalInstance':$modalInstance});
            $validForm = $scope.submit(form.$invalid);

            expect($validForm).toEqual(true);
        });

        it('check form invalid with name is wrong', function() {
            var $scope = {};
            var controller = $controller('ModalCreateFolderBlockCtrl', { $scope: $scope, '$modalInstance':$modalInstance});
            form.name.$setViewValue('');

            var validFieldName = form.name.$invalid;
            var $validForm = form.$invalid;
                
            expect(validFieldName).toEqual(true);
            expect($validForm).toEqual(true);
        });


        it('check submit form when miss folder id', function() {
            var $scope = {};
            var controller = $controller('ModalCreateFolderBlockCtrl', { $scope: $scope, '$modalInstance':$modalInstance});
            form.name.$setViewValue('test');
            
            $validForm = $scope.submit(form.$invalid);
                
            expect($validForm).toEqual(true);
        });


        it('check form invalid with name is passed', function() {
            var $scope = {};
            var controller = $controller('ModalCreateFolderBlockCtrl', { $scope: $scope, '$modalInstance':$modalInstance});
            form.name.$setViewValue('test Block');

            var validFieldName = form.name.$invalid;

            $validForm = $scope.submit(form.$invalid);

            expect(validFieldName).toEqual(false);
            expect($validForm).toEqual(true);
        });


        it('check form success', function() {
            var $scope = {};
            var controller = $controller('ModalCreateFolderBlockCtrl', { $scope: $scope, '$modalInstance':$modalInstance});
            form.name.$setViewValue('test Block');
            $scope.blockFolder.parent_id = '570a025b9a8920112613e072';

            var validFieldName = form.name.$invalid;

            $validForm = $scope.submit(form.$invalid);

            expect(validFieldName).toEqual(false);
            expect($validForm).not.toBeDefined();
        });
    });
});