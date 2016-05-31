$('body').empty();

describe('TemplateContentManager', function() {
  beforeEach(angular.mock.module('uls'));
  beforeEach(angular.mock.module('TemplateContentManager'));
  var $scope, $httpBackend, $controller, modalInstance, $templateCache, $compile, TemplateContentManagerService, TemplateContentManagerResource;


  beforeEach(inject(function(_$controller_, _$httpBackend_, _$templateCache_, _$compile_, $rootScope, _TemplateContentManagerService_, _TemplateContentManagerResource_) {

    $scope = $rootScope.$new();
    TemplateContentManagerResource = _TemplateContentManagerResource_;
    TemplateContentManagerService = _TemplateContentManagerService_;
    $controller = _$controller_;
    $templateCache = _$templateCache_;
    $compile = _$compile_;
    $httpBackend = _$httpBackend_;

    // $httpBackend.whenGET(window.baseUrl+'/app/shared/select-level/view.html').respond(200, {"meta":{"apiVersion":"0.1","code":200,"errors":null}});
    // $httpBackend.whenGET(window.baseUrl+'/app/shared/file-upload/views/file-upload.html?v=1').respond(200, {"meta":{"apiVersion":"0.1","code":200,"errors":null}});

    $httpBackend.whenGET(/\.html*/).respond(200, {"meta":{"apiVersion":"0.1","code":200,"errors":null}});;

    modalInstance = {                    // Create a mock object using spies
      close: jasmine.createSpy('modalInstance.close'),
      dismiss: jasmine.createSpy('modalInstance.dismiss'),
      result: {
        then: jasmine.createSpy('modalInstance.result.then')
      }
    };
    var string = window.contentTemplate;
    var element = angular.element(string);
    var formTemplate = element.find('form');
    $compile(formTemplate)($scope);
    form = $scope.formTemplate;
    $scope.$digest();
    $scope = {};
  }));

  describe('Test create template', function(){
    it('expect success with name null', function(){
      form.name.$setViewValue(null);

      expect(form.name.$invalid).toBeTruthy();
    })
    it('expect success with folder_id null', function(){
      $scope.template = {};
      $scope.template.folder_id = null;

      expect(!$scope.template.folder_id).toBeTruthy();
    })
  });
});
