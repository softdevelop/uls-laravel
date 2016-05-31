$('body').empty();
describe('ModalUploadNewBlockCtrl', function() {

  beforeEach(angular.mock.module('uls'));
  beforeEach(angular.mock.module('BlockApp'));
  beforeEach(angular.mock.module('ngMockE2E'));

  var $scope , $controller, deferred, $httpBackend, $templateCache,$compile,form,$controller,$timeout,modalInstance;

  beforeEach(inject(function(_$controller_, _$httpBackend_, $rootScope, _$q_,_$templateCache_,_$compile_, _$controller_,_$timeout_) {

    deferred = _$q_.defer();
    $scope = $rootScope.$new();

    $controller = _$controller_;
    $httpBackend = _$httpBackend_;

    $httpBackend.whenGET(/\.html*/).respond(200, {"meta":{"apiVersion":"0.1","code":200,"errors":null}});;



    $templateCache = _$templateCache_;
    $compile = _$compile_;
    $controller = _$controller_;
    $timeout = _$timeout_;

    // var string = window.contentTemplate;
    var element = angular.element(window.contentTemplate);
    var formData = element.find('form');

    editor = element.find('#editor');

    //form create block
    $compile(formData)($scope);
    form = $scope.formData;

    //compile form create folder.
    $compile(angular.element(window.contentCreateFolder))($scope);
    createFolderForm = $scope.createFolderForm;

    //compile request new block.
    // $compile(angular.element(window.contentRequestBlock))($scope);
    // contentRequestBlock = $scope.contentRequestBlock;
    // console.log(createFolderForm,'createFolderForm');
    //digest
    $scope.$digest();



  }));

  describe('Test Create New Block', function(){



    it('expect fail with empty name', function(){
        form.name.$setViewValue(null);
        expect(form.name.$valid).toBeFalsy();
    })
    it('expect fail with empty type', function(){
        form.type.$setViewValue(null);
        expect(form.type.$valid).toBeFalsy();
    })

    it('expect fail with empty description', function(){
        form.description.$setViewValue(null);
        expect(form.description.$valid).toBeFalsy();
    })

    it('expect fail with empty content', function(){
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
      $scope.editableCodeMirror.setValue("");

      $scope.block.folder = 'block';
      $scope.submit(false);
       expect($scope.requiredEditorContent).toBe(true);
    })
  })

   describe('Test Create New Folder', function(){

    it('expect fail with empty name', function(){
        createFolderForm.name.$setViewValue(null);
        expect(createFolderForm.name.$valid).toBeFalsy();
    })

    it('expect fail with length > 50', function(){
      var text = 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using , making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like)';
        createFolderForm.name.$setViewValue(text);
        expect(createFolderForm.name.$valid).toBe(false);

    })


  })

   describe('Test Request New Block', function(){
    var modalInstance;
    beforeEach(inject(function(_$controller_, _$httpBackend_, $rootScope, _$q_,_$templateCache_,_$compile_, _$controller_,_$modal_) {

    deferred = _$q_.defer();
    $scope = $rootScope.$new();
    $controller = _$controller_;
    $httpBackend = _$httpBackend_;
    $templateCache = _$templateCache_;
    $compile = _$compile_;
    $controller = _$controller_;
    // $modal = _$modal_;
    //compile form create folder.
    $compile(angular.element(window.contentRequestBlock))($scope);
    contentRequestBlockForm = $scope.formData;
    $scope.$digest();
    // $modalInstance = _$modalInstance_;

     modalInstance = {                    // Create a mock object using spies
      close: jasmine.createSpy('modalInstance.close'),
      dismiss: jasmine.createSpy('modalInstance.dismiss'),
      result: {
        then: jasmine.createSpy('modalInstance.result.then')
      }
    };
    var controller = $controller('ModalRequestBlockController',
    {
      $scope: $scope,
      folder_id: 1,
      $modalInstance: modalInstance
    });



  }));

    it('expect fail with empty name', function(){
        contentRequestBlockForm.name.$setViewValue(null);
        expect(contentRequestBlockForm.name.$valid).toBeFalsy();
    })
    it('expect fail with empty type', function(){
        contentRequestBlockForm.type.$setViewValue(null);
        expect(contentRequestBlockForm.type.$valid).toBeFalsy();
    })

    it('expect fail with empty due_date', function(){
        contentRequestBlockForm.due_date.$setViewValue(null);
        expect(contentRequestBlockForm.due_date.$valid).toBeFalsy();
    })

    // it('expect fail with description empty', function(){
    //   $scope.initRedactor();
    //   $('#description').redactor('code.set','');
    //   $scope.block = {};
    //   $scope.block.folder_id = 1;
    //   $scope.submit(false);
    // });


  })


});
