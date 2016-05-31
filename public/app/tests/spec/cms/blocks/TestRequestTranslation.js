describe('ModalRequestBlockController', function() {
    beforeEach(module('uls'));
    beforeEach(module('BlockApp'));

    var $controller;
    var $modal;
    var $timeout;
    var $compile;
    var $cookieStore;
    var BlockManagerService;
    var $httpBackend;
    var form;
    var editor;
    var folderId;

    beforeEach(inject(function(_$window_, _$modal_, _$timeout_, _Upload_, _$filter_, _BlockManagerService_, _$controller_, _$compile_, $rootScope, _$httpBackend_){
        $modalInstance = {                    // Create a mock object using spies
            close: jasmine.createSpy('modalInstance.close'),
            dismiss: jasmine.createSpy('modalInstance.dismiss'),
            result: {
                then: jasmine.createSpy('modalInstance.result.then')
            }
        };

        // The injector unwraps the underscores (_) from around the parameter names when matching
        $controller = _$controller_;
        $modal = _$modal_;
        $timeout = _$timeout_;
        $compile = _$compile_;
        BlockManagerService = _BlockManagerService_;

        $scope = $rootScope.$new();

        $httpBackend = _$httpBackend_;
        $httpBackend.when('GET', /\.html*/).respond(200);
        // $httpBackend.when('GET', /app\/shared\/file-upload\/views\/file-upload.html/).respond(200);

        var string = window.contentTemplate;
        var element = angular.copy(angular.element(window.contentView));
        var formData = element.find('form');

        editor = element.find('#description');

        //form create block
        $compile(formData)($scope);
        form = $scope.formData;
        $scope.$digest();
    }));

    describe("check form", function() {
        it("check submit form with form empty", function() {
            var $scope = {};
            var controller = $controller('ModalRequestBlockController', { $scope: $scope, '$modalInstance':$modalInstance, 'folder_id':2});
            $scope.block = {};

            $validate = $scope.submit();

            expect($validate).toBe(true);
        });

        it('check field name is empty', function() {
            var $scope = {};
            var controller = $controller('ModalRequestBlockController', { $scope: $scope, '$modalInstance':$modalInstance, 'folder_id':2});

            $invalidName = form.name.$invalid;

            $invalidForm = form.$invalid;

            expect($invalidName).toEqual(true);
            
            expect($invalidForm).toEqual(true);
        });

        it('check field type is empty', function() {
            var $scope = {};
            var controller = $controller('ModalRequestBlockController', { $scope: $scope, '$modalInstance':$modalInstance, 'folder_id':2});

            $invalidType = form.type.$invalid;

            $invalidForm = form.$invalid;

            expect($invalidType).toEqual(true);

            expect($invalidForm).toEqual(true);
        });


        it('check due date is empty', function() {
            var $scope = {};
            var controller = $controller('ModalRequestBlockController', { $scope: $scope, '$modalInstance':$modalInstance, 'folder_id':2});

            $invalidType = form.due_date.$invalid;

            $invalidForm = form.$invalid;

            expect($invalidType).toEqual(true);

            expect($invalidForm).toEqual(true);
        });

        it('check language is empty', function() {
            var $scope = {};
            var controller = $controller('ModalRequestBlockController', { $scope: $scope, '$modalInstance':$modalInstance, 'folder_id':2});

            expect($scope.languages_selected).toEqual(jasmine.any(Object));

            var maxlength = Object.keys(angular.extend({}, $scope.languages_selected)).length;

            expect(maxlength).toEqual(0);
        });

        // it('check content block is invalid', function() {
        //     var $scope = {};
        //     var controller = $controller('ModalRequestBlockController', { $scope: $scope, '$modalInstance':$modalInstance, 'folder_id':2});

        //     $scope.block = {};

        //     $('#description').redactor({
        //         plugins: '',
        //         imageUpload: '/content/upload',
        //         // buttonsHide: ['link','insertpage'],
        //         callbacks: {
                    
        //         },
        //         linkSize: 1000,
        //         minHeight: 200 // pixels
        //     });

        //     console.log($('#description').redactor());

        //     $('#description').redactor('code.set', 'ddddd');
        //     console.log($('#description').redactor('code.get'), 111111);

        //     $scope.block.folder_id = '11111111';
        //     $scope.submit(false);
        //     expect($scope.requiredDescription).toBe(true);
        // });
        
        // it('check field folder is invalid', function() {
        //     var $scope = {};

        //     var hasClassInvalid = false;

        //     var controller = $controller('ModalUploadNewBlockCtrl', { $scope: $scope, '$modalInstance':$modalInstance, 'folder_id':2});

        //     var curElement = formElement.find('[ng-model="block.folder"]');

        //     console.log($(formElement));

        //     if (curElement.length) {
        //         var currentScope = $(formElement).find('body');
        //         console.log(currentScope);
        //         hasClassInvalid = curElement.hasClass('invalid');
        //     }

        //     expect(hasClassInvalid).toEqual(true);

        //     expect($invalidForm).toEqual(true);
        // });
    });
});