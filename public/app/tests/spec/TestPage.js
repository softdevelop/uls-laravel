$('body').empty();

describe('PageController', function() {
  beforeEach(angular.mock.module('uls'));
  beforeEach(angular.mock.module('ngFileUpload'));
  beforeEach(angular.mock.module('pageApp'));
  var $scope, $controller, deferred, $httpBackend, $templateCache,$compile,form,$controller,$timeout;


  beforeEach(inject(function(_$controller_, _$httpBackend_, $rootScope, _$q_,_$templateCache_,_$compile_, _$controller_,_$timeout_) {
    $scope = $rootScope.$new();
    $controller = _$controller_;
    $httpBackend = _$httpBackend_;
    
    $httpBackend.whenGET(/\.html*/).respond(200, {"meta":{"apiVersion":"0.1","code":200,"errors":null}});
    
    $templateCache = _$templateCache_;
    $compile = _$compile_;

    var element = angular.element(window.contentTemplate);
    var formData = element.find('form');

    $compile(formData)($scope);

    form = $scope.ProposePageForm;

    $scope.$digest();

  }));

  describe('Test create pages', function(){
    it('expect success with name null', function(){
      form.name.$setViewValue(null);
      expect(form.name.$invalid).toBeTruthy();
    })
    it('expect success with version define', function(){
      expect(form.version).toBeDefined();
      if (angular.isDefined(form.version)) {
        expect(form.version.$invalid).toBeTruthy();
      }
    })
    it('expect fail with due_date null', function(){
      form.due_date.$setViewValue(null);
      expect(form.due_date.$invalid).toBeTruthy();
    })
  });
});

