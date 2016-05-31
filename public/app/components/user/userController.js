var userModule = angular.module('user');
userModule.controller('UserController', ['$scope', '$parse', 'UserService', '$modal', 'ngTableParams', '$timeout', '$filter', function ($scope, $parse, UserService, $modal, ngTableParams, $timeout, $filter) {
    $scope.user = {};
    $scope.isAction = false;
    $scope.items_s = [];

    // angular.element('.bs-example-modal-lg').on('shown.bs.modal', function (e) {
    //    window.location.href = window.baseUrl + '/admin/user#user-administration';
    //    $('#fix-modal-top').scrollTop(0);
    // });
     
    // $scope.goToAnchorWithId = function(value){
    //     window.location.href = window.baseUrl + '/admin/user#'+value;
    //     $('#fix-modal-top').scrollTop(0);
    // }

    $scope.changeFilter = function(){
        $timeout(function(){
            $scope.isAction = !$scope.isAction;
        },1000)       
    };

    // $scope.showGroup = function(event){
    //     $(event.target).parent().toggleClass("ac-up");
    //     $(document).on('click', function closeMenu (e){
    //         $(e.target).closest('tr').siblings().find('.wrap-ac-group').removeClass('ac-up');
    //         if($('.wrap-ac-group').has(e.target).length === 0){
    //             $('.wrap-ac-group').removeClass('ac-up');
    //         } else {
    //             $(document).one('click', closeMenu);
    //         }
    //     });
    //     angular.element('.table-responsive').addClass('fix-height');
    // };
    
    $scope.showGroup = function($event){
        var w = $(window).outerWidth();
        $($event.target).parent().toggleClass("ac-up");
            $('.group-btn-ac').css({
                top: $event.pageY - 126 + 'px',
                right: w - $event.pageX - 30 + 'px',
            });
        $(document).on('click', function closeMenu (e){
              $(e.target).closest('tr').siblings().find('.wrap-ac-group').removeClass('ac-up');
              if($('.wrap-ac-group').has(e.target).length === 0){

                  $('.wrap-ac-group').removeClass('ac-up');

              } else {
                  $(document).one('click', closeMenu);
              }
        });
        angular.element('.table-responsive').addClass('fix-height');
    }

    if(typeof window.dataController != 'undefined'){
        for(var key in window.dataController){
            var model = $parse(key);
            model.assign($scope, window.dataController[key]);
        }
    }

    $scope.$watch('hashData', function(){
        UserService.setHashData($scope.hashData);
    });

    var initMessageError = function () {
        $scope.error = false;
        $scope.message = {};
        $scope.message.per = '';
        $scope.message.role = '';
        $scope.message.group = '';
    }

    $scope.updatePermission = function(){
        initMessageError();
        UserService.updatePermissions($scope.id, Object.keys($scope.userPermissions)).then(function(data){
            if(!data.status) {
                $scope.error = true;
                $scope.message.per = data.message;
            }
        });
    };

    $scope.updateRole = function(){        
        initMessageError();
        UserService.updateRoles($scope.id, Object.keys($scope.userRoles)).then(function(data){
            if(!data.status) {
                $scope.error = true;
                $scope.message.role = data.message;
            }
        });
    };

    $scope.updateGroup = function()
    {
        initMessageError();
        UserService.updateGroup($scope.id, Object.keys($scope.userGroups)).then(function(data){
            if(!data.status) {
                $scope.error = true;
                $scope.message.group = data.message;
            }
        });
    }

    UserService.queryUsersManager().then(function(data){
        angular.element('.content').removeClass('hidden');
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

    $scope.showHelp = function(ids) {
        var teamplate = '/admin/help-editor/modal-help?ids=' + ids;
        var modalInstance = $modal.open({
            animation: $scope.animationsEnabled,
            templateUrl: window.baseUrl + teamplate,
            controller: 'showHelpController',
            size: 'lg',
            resolve: {}
        });
    }

    $scope.$watch('tableParams', function(newValue, oldValue) {
        if(angular.isDefined(newValue)) {
             $scope.tableParams.filter()['status'] = 'yes';
        }
    });

    $scope.isSearch = false;
    $scope.btnSearch = function(){
        $scope.isSearch = !$scope.isSearch;
        $scope.tableParams.filter().name = '';
        $scope.tableParams.filter().email = '';
    }

    $scope.delete = function(id) {
        if (!confirm('Are you sure you want to Deactivate this user?')) return;
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
    }
    $scope.convetDateTime = function(dateStr){
        if(dateStr == '0000-00-00 00:00:00') return '';
        // var a=dateStr.split(" ");
        // var d=a[0].split("-");
        // var t=a[1].split(":");
        // var date = new Date(d[0],(d[1]-1),d[2],t[0],t[1],t[2]);

        return $filter('date')(new Date(dateStr), 'MM-dd-yyyy HH:mm:ss');
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
            // item.created_at = $filter('date')(new Date(item.created_at), 'MM-dd-yyyy HH:mm:ss');
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

    


}]).controller('showHelpController', ['$scope', '$modalInstance', function($scope, $modalInstance) {
        $scope.cancel = function() {
            console.log('1');
            $modalInstance.dismiss('cancel');
        };
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
        $scope.formatPhoneNumber = function() {
            angular.element('#phone_number').mask('(999) 999-9999? x99999',{ autoclear: false});
        };
        $scope.validatePhone = function(number){
            $scope.formAddUser.phone_number.$invalid = false;
            if(typeof number != 'undefined') {
                number = number.replace(/[^0-9]/g,'');
                if(number.length != 0 && number.length < 10) {
                    $scope.formAddUser.phone_number.$invalid = true;
                }
            }
        };
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
            angular.element("#btnAddUser").attr("disabled", "true");
            if(typeof $scope.userItem.personal_information != 'undefined' && $scope.userItem.personal_information != null) {
                number = $scope.userItem.personal_information.phone_number.replace(/[^0-9]/g,'');
                if(number.length != 0 && number.length < 10) {
                    angular.element("#btnAddUser").removeAttr("disabled");
                    return;
                }
            }
            UserService.create($scope.userItem).then(function(data) {
                if (data.status == 0) {
                    angular.element("#btnAddUser").removeAttr("disabled");
                    $scope.error = '';
                    if(typeof data.error == 'undefined'){
                        $scope.error = 'The email has already been taken.';
                    }else{
                        for (var key in data.error) {
                            $scope.error = data.error[key][0];
                        }       
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
    }
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
