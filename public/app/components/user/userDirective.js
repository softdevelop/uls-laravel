var userModule = angular.module('user');
userModule.directive('users', ['$modal', '$filter', "UserService", "ngTableParams",'$timeout',
    function($modal, $filter, UserService, ngTableParams,$timeout) {
        return {
            restrict: 'EA',
            scope: {},
            templateUrl: '/app/components/user/views/index.html',
            link: function($scope, element, attr) {
                $scope.isAction = false;
                $scope.items_s = [];
                $timeout(function(){
                     angular.element('#filter-checkbox').trigger('click');
                     angular.element('#filter-checkbox-contact').trigger('click');
                 },500)
                $scope.changeFilter = function(){
                    $timeout(function(){
                        $scope.isAction = !$scope.isAction;
                    },1000)
                   
                };

                UserService.query().then(function(data){
                    $scope.items_s = UserService.getUsers();
                    $scope.tableParams = new ngTableParams({
                        page: 1,
                        count: 10,
                        sorting: {
                            'name': 'asc'
                        },
                    }, {
                        total: $scope.items_s.length,
                        getData: function($defer, params) {
                            var orderedData = params.sorting() ? $filter('orderBy')($scope.items_s, params.orderBy()) : $scope.items_s;
                            orderedData = params.filter() ? $filter('filter')(orderedData, params.filter()) : orderedData;
                            params.total(orderedData.length);
                            $defer.resolve(orderedData.slice((params.page() - 1) * params.count(), params.page() * params.count()));
                        }
                    });
                });

                $scope.delete = function(id) {
                    if (!confirm('Do you want delete this user')) return;
                    UserService.remove(id).then(function(data) {
                        $scope.items_s = UserService.getUsers();
                        $scope.tableParams.reload();
                    });
                };
                        /**
                 * [deleteModalPwv description]
                 * @param  {[type]} item [description]
                 * @return {[type]}      [description]
                 */
                $scope.changeStatus = function(item,$index) {
                      var modalInstance = $modal.open({
                        templateUrl: '/app/components/user/views/modal/changeStatusUser.html',
                        controller: 'ModalChangeStatusCtrl',
                        size: undefined,
                        resolve: {
                            userInfo: function(){
                                return item;
                            }
                        }
                      });
                      
                      modalInstance.result.then(function (result) {
                          $scope.items_s = UserService.getUsers();
                          $scope.tableParams.reload();
                      }, function () {
                      });
                    
                };
                $scope.showContact = function(userId, isShowContact){
                    UserService.showContact({id:userId, is_show_contact:isShowContact}).then(function(data){
                        $scope.items_s = UserService.getUsers();
                        $scope.tableParams.reload();
                    });
                };
                $scope.convetDateTime = function(dateStr){
                    if(dateStr == '0000-00-00 00:00:00') return '';
                    var a=dateStr.split(" ");
                    var d=a[0].split("-");
                    var t=a[1].split(":");
                    var date = new Date(d[0],(d[1]-1),d[2],t[0],t[1],t[2]);

                    return $filter('date')(date, 'yyyy-MM-dd HH:mm:ss');
                };
                /**
                 * get layout update user
                 * @param  {[int]} id id of user. it can null
                 * @return {[type]}    [description]
                 */
                $scope.getModalCreateUser = function(id) {
                    var templateUrl = '/admin/user/create';
                    if (typeof id != 'undefined') {
                        templateUrl = '/admin/user/' + id + '/edit' + '?' + new Date().getTime();
                    }
                    var modalInstance = $modal.open({
                        templateUrl: templateUrl,
                        controller: 'ModalCreateUser',
                        size: undefined,
                        windowClass: 'modal fade   sizer',
                        resolve: {}
                    });
                    modalInstance.result.then(function(item) {
                        if(id){
                             UserService.updateUser(item);
                         }
                       
                         $scope.items_s = UserService.getUsers();
                         $scope.tableParams.reload();
                    }, function() {});
                };
                
                $scope.resetPassword = function(email){
                    UserService.resetPassword(email).then(function(data){
                        if(data.status){
                            $scope.success_message = data.message;
                        }else{
                            $scope.error_message = data.message;
                        }
                    });
                };
            }
        }
    }
]).controller('ModalChangeStatusCtrl', ['$scope', '$modalInstance', 'UserService','userInfo',
    function($scope, $modalInstance, UserService,userInfo) {
        $scope.userInfo = userInfo;
        $scope.changeStatus = function(){
            UserService.changeStatus($scope.userInfo.id).then(function(data){
                $modalInstance.close(data);
            });
        };
        $scope.cancel = function() {
            $modalInstance.dismiss('cancel');
        };
    }
]).controller('ModalCreateUser', ['$scope', '$timeout', '$modalInstance', 'UserService',
    function($scope, $timeout, $modalInstance, UserService) {
        $scope.isNext1 = false;
        $scope.isNext2 = false;
        $scope.validateEmail = true;
       
        $scope.currentStep = 1;
        /**
         * [next] next modal
         * @return {Function} [description]
         */
        $scope.next = function(){
            $scope.currentStep+= 1;
        };
        /**
         * [back description] back step create user
         * @return {[type]} [description]
         */
        $scope.back = function(){
             $scope.currentStep -= 1;
        };
        
        /**
         * update user
         * @return {[type]} [description]
         */
        $scope.createUser = function() {
            UserService.create($scope.userItem).then(function(data) {
                console.log(data);
                if (data.status == 0) {
                    $scope.error = '';
                    for (var key in data.error) {
                        $scope.error = data.error[key][0];
                    }
                } else {
                    $modalInstance.close(data.item);
                }
            });
        };
        $scope.cancel = function() {
            $modalInstance.dismiss('cancel');
        };
    }
]).directive('uniqueEmail', ["UserService",
    function(UserService) {
        return {
            restrict: 'A',
            controller: 'UserController',
            link: function(scope, el, attrs) {
                el.blur(function() {
                    var value = el.val();
                    if (value.length == 0) return;
                    UserService.query().then(function(data) {});
                })
            }
        };
    };
]).directive('profile', ['UserService', '$upload', '$timeout', '$filter', '$modal',
    function(UserService, $upload, $timeout, $filter, $modal) {
        return {
            restrict: 'EA',
            scope: {
                userProfile: '=',
                roles: '='
            },
            templateUrl: '/app/components/user/views/profile.html',
            link: function(scope, elm, attrs, ctrl) {
                scope.currentItemsRoles = [];
                var checkEmail = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                var checkNumber = /[0-9]|\./;
                var checkZipCode = /^[0-9]{1,15}$/;
                scope.mobile = function(number){
                    scope.errorMobile = '';
                    if(checkNumber.test(number)){
                        updateUserChange();
                    }else{
                        scope.userProfile.personal_information.work_mobile = "";
                        scope.errorMobile = 'Work Mobile Invald';
                    }
                };
                scope.fax = function(number){
                    scope.errorFax = '';
                    if(checkNumber.test(number)){
                        updateUserChange();
                    }else{
                        scope.userProfile.personal_information.fax = "";
                        scope.errorFax = 'Work Mobile Invald';
                    }
                };
                scope.workEmail = function(email){
                    scope.errorWorkEmail = '';
                    if(checkEmail.test(email)){
                        updateUserChange();
                    }else{
                        scope.userProfile.personal_information.work_email = "";
                        scope.errorWorkEmail = 'Email Invald';
                    }
                };
                scope.personalEmail = function(email){
                    scope.errorPersonalEmail = '';
                    if(checkEmail.test(email)){
                        updateUserChange();
                    }else{
                        scope.userProfile.personal_information.personal_email = "";
                        scope.errorPersonalEmail = 'Personal Email invald';
                    }
                };
                scope.homeZip = function(number){
                    scope.errorHomeZip = '';
                    if(checkZipCode.test(number)){
                        updateUserChange();
                    }else{
                        scope.userProfile.personal_information.home_zip = "";
                        scope.errorHomeZip = 'Home Zip invald';
                    }
                };
                var updateUserChange = function() {
                    UserService.update(scope.userProfile).then(function(data) {
                        // scope.userProfile = data;
                    });
                };
                scope.updateUser = function(){
                    UserService.update(scope.userProfile).then(function(data){});
                };
                scope.upload = function(files, type) {
                    scope.files = files;
                    getModalCropAvatar();
                };
            
                getModalCropAvatar = function(size) {
                    var modalInstance = $modal.open({
                        templateUrl: 'myModalContent.html',
                        controller: 'ModalChangeAvatar',
                        size: size,
                        resolve: {
                            files: function() {
                                return scope.files;
                            },
                            userId: function(){
                                 return scope.userProfile.id;
                            }
                        },
                    });
                    modalInstance.result.then(function(avatarUrl) {
                         scope.userProfile.avatar = avatarUrl;
                    }, function() {

                    });
                };

            }
        };
    };
]).controller('ModalChangeAvatar', ['$scope', '$timeout', '$modalInstance', '$upload', 'UserService', 'files', 'userId',
function($scope, $timeout, $modalInstance, $upload, UserService, files, userId){
    $scope.myImage = '';
    $scope.myCroppedImage = '';
     var reader = new FileReader();
    reader.readAsDataURL(files[0]);
    reader.onload = function(evt) {
        $scope.$apply(function() {
            $scope.myImage = evt.target.result;
            $scope.myCroppedImage = evt.target.result;
        });
    };
    $scope.changeAvatar = function() {
        UserService.changeAvatar(userId, $scope.myCroppedImage).then(function(response) {
            $modalInstance.close(response.item.avatar);
        });
    };
     $scope.cancel = function () {
    $modalInstance.dismiss('cancel');
  };
    
}]);