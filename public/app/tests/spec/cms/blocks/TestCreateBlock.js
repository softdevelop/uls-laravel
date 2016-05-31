describe('ModalUploadNewBlockCtrl', function() {
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

    beforeEach(inject(function(_$window_, _$modal_, _$timeout_, _Upload_, _$filter_, _$sce_, _$cookieStore_, _BlockManagerService_, _$controller_, _$compile_, $rootScope, _$httpBackend_){
        // The injector unwraps the underscores (_) from around the parameter names when matching
        $controller = _$controller_;
        $modal = _$modal_;
        $timeout = _$timeout_;
        $compile = _$compile_;
        $cookieStore = _$cookieStore_;
        BlockManagerService = _BlockManagerService_;

        $scope = $rootScope.$new();

        $httpBackend = _$httpBackend_;
        $httpBackend.when('GET', /app\/shared\/select-level\/view\.html/).respond(200);

        var string = window.contentTemplate;
        var element = angular.copy(angular.element(window.contentView));
        var formData = element.find('form');

        editor = element.find('#editor');

        //form create block
        $compile(formData)($scope);
        form = $scope.formData;
        $scope.$digest();
    }));

    describe("check form", function() {
        it("check submit form with form invalid", function() {
            var $scope = {};
            var controller = $controller('ModalUploadNewBlockCtrl', { $scope: $scope, '$modal':$modal, 'BlockManagerService':BlockManagerService });

            $validate = $scope.submit();

            console.log($scope.minDate);

            expect($validate).toBe(true);
        });

        it('check field name is invalid', function() {
            var $scope = {};
            var controller = $controller('ModalUploadNewBlockCtrl', { $scope: $scope, '$modal':$modal, 'BlockManagerService':BlockManagerService });

            $invalidName = form.name.$invalid;

            $invalidForm = form.$invalid;

            expect($invalidName).toEqual(true);
            
            expect($invalidForm).toEqual(true);
        });

        it('check field type is invalid', function() {
            var $scope = {};
            var controller = $controller('ModalUploadNewBlockCtrl', { $scope: $scope, '$modal':$modal, 'BlockManagerService':BlockManagerService });

            $invalidType = form.type.$invalid;

            $invalidForm = form.$invalid;

            expect($invalidType).toEqual(true);

            expect($invalidForm).toEqual(true);
        });

        it('check content block is invalid', function() {
            controller = $controller('ModalUploadNewBlockCtrl', { $scope: $scope });

            $scope.editableCodeMirror = CodeMirror.fromTextArea(editor[0], {
                lineNumbers: true,
                mode: "application/x-httpd-php",
                keyMap: "sublime",
                autoCloseBrackets: true,
                matchBrackets: true,
                showCursorWhenSelecting: true,
                lineWrapping:true,
                theme: "monokai",
                tabSize: 2,
                indentUnit: 4,
                indentWithTabs: true,
                onChange: function() {
                }
            });

            console.log($scope.editableCodeMirror);

            $scope.editableCodeMirror.setValue("");

            $scope.block.folder = 'block';
            $scope.submit(false);
            expect($scope.requiredEditorContent).toBe(true);
        });
        
        // it('check field folder is invalid', function() {
        //     var $scope = {};

        //     var hasClassInvalid = false;

        //     var controller = $controller('ModalUploadNewBlockCtrl', { $scope: $scope, '$modal':$modal, 'BlockManagerService':BlockManagerService });

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