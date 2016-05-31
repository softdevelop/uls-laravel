var roleGroupModule = angular.module('roleGroup1');

roleGroupModule.controller('RoleGroupController', ['$rootScope','$scope', '$parse', 'UserGroupService', '$modal','$filter', function($rootScope,$scope, $parse, UserGroupService, $modal, $filter) {

    $scope.lists_group_user = angular.copy(window.userGroupInfor);
    $scope.lastData = [];

    angular.element('.table-responsive').removeClass('hidden');

    $scope.addGroup = function(id, data) {
      console.log(id, 'id');
        if (id || !angular.isUndefined(id)) {
          var tempUrl = '/admin/roles/edit-user-group/'+id;
        } else {
          var tempUrl = '/admin/roles/create-user-group';
        }
        var modalInstance = $modal.open({
          templateUrl: baseUrl + tempUrl,
          controller: 'ModalGroupUserCtr',
          size: undefined,
          resolve: {
            id:function() {
              return id;
            },
            detail:function() {
              return data;
            }
          }
        });
        modalInstance.result.then(function (data) {
        }, function () {
          if ($scope.lastData['edit']) {
            var data = $scope.lastData['result'];
            for (i in $scope.lists_group_user) {
                 if ($scope.lists_group_user[i].id == id) {
                    $scope.lists_group_user[i] = data;
                 }
             }

          } else if ($scope.lastData['result']){
            $scope.lists_group_user.push($scope.lastData['result']);
          }

          $scope.lastData = [];
          
        });
    }

    $scope.removeUserGroup = function(id) {
      var r = confirm('Do you delete this group?');
      if (r) {
          UserGroupService.removeGroup(id).then(function(data) {
             if (data['status']) {
               var lists_group_user = $scope.lists_group_user;
               for (i in lists_group_user) {
                   if (lists_group_user[i].id == id) {
                      $scope.lists_group_user.splice(i,1);
                   }
               }
             }
          })        
      }
       
    }
    $scope.showGroup = function($event){
        var w = $(window).outerWidth();
        $($event.target).parent().toggleClass("ac-up");
        $('.group-btn-ac').css({
           top: $event.pageY - 100 + 'px',
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
  };
    $rootScope.$on('createGroup', function(event, data){
        $scope.lastData = data;
    });

}]).controller('ModalGroupUserCtr', ['$rootScope','$scope', 'UserGroupService', 'UserService', '$controller', 'id', 'detail', '$modalInstance', '$timeout', function ($rootScope,$scope, UserGroupService, UserService, $controller, id, detail, $modalInstance, $timeout) {

  $scope.groupUser = {};
  $scope.group_id_after_add = {};
  $scope.list_user = [];
  // $scope.lastData = {};


  $scope.isDisabled = false;

  if (id) {
    $scope.groupUser = angular.copy(detail);
    $scope.list_user = detail.userInGroup;
    $scope.addGrouped = true;
    $scope.group_id_after_add = id;
  }

  $controller('BaseController', { $scope: $scope });
  $scope.callbackLoadUserFinish = function(){
  };
   $scope.create = function(validate) {
    $scope.submitted = true;
    if (validate) {
      return;
    }
    if (id) {
      UserGroupService.update({id: id, name: $scope.groupUser}).then(function(result) {
        if (result['result']) {
          // console.log(result,'result');
          $rootScope.$emit('createGroup', result);
          // $scope.lastData = result;
          $scope.group_id_after_add = result['result'].id;
          $scope.addGrouped = true;
          result['edit'] = true;
        }
      })
    } else {
      UserGroupService.create($scope.groupUser).then(function(result) {
        if (result['result']) {
          $rootScope.$emit('createGroup', result);
          $scope.group_id_after_add = result['result'].id;
          $scope.addGrouped = true;
          $scope.isDisabled = true;
          // $scope.lastData = result;
          angular.element('#appendedInputButtons').attr('disabled','true');
        }
      })
    }
      
   }

   $scope.shareToUser = function(userId) {
    if(angular.isUndefined(userId) || userId == null) return;

    if ($scope.group_id_after_add > 0) {
      UserGroupService.addUserToGroup({userId : userId, userGroupId : $scope.group_id_after_add}).then(function(result){
          if (result['result']) {
            $scope.list_user = result['result']['userInGroup'];
            if (id) {
              result['edit'] = true;
            }
              $timeout(function(){
                $('.search-people').val(null).trigger('change');
              },500);
            $rootScope.$emit('createGroup', result);
          }
      });
    }
   
   }

   $scope.removeUser = function(userId) {
    UserGroupService.removeUser({userId : userId, userGroupId : $scope.group_id_after_add}).then(function(data) {
      if (data['status']) {
        var list_user = $scope.list_user;
        for (i in list_user) {
          if (list_user[i].id == userId) {
            $scope.list_user.splice(i,1);
          }
        }
      }
    })
   }

  UserService.query().then(function(data){
      $scope.users = data;
      }, function(){
  });

  $scope.cancel = function() {
    $modalInstance.dismiss('cancel');
  }
}]);
