
var userModule = angular.module('user');

userModule.controller('UserDetailController', ['$scope', '$parse', 'UserService', '$modal','$q','$http', function($scope, $parse, UserService, $modal,$q,$http) {
    
    $scope.currentItemsRoles = [];
    var checkEmail = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    var checkNumber =  /^\(?(\d{3})\)?[ .-]?(\d{3})[ .-]?(\d{4})$/;
    $scope.mobile = function(number){
        $scope.errorMobile = '';
        if(checkNumber.test(number)){
            updateUserChange('work_mobile');
        }else{
            $scope.userProfile.personal_information.work_mobile = "";
            $scope.errorMobile = 'Work Mobile is 10 number';
        }
    }

    $scope.formatPhoneNumber = function() {
        angular.element('#phone_number').mask('(999) 999-9999? x99999',{ autoclear: false});
    }

    var updateUserChange = function(field) {
        $scope.userProfile.field = field;
        UserService.update($scope.userProfile).then(function(data) {
            $scope.userProfile = data.item;
        });
    }

    $scope.phoneNumber = function(phone) {
        var errorPhone = true;
        if(typeof phone != 'undefined') {
            $phone = phone.replace(/[^0-9]/g,'');
            if($phone.length != 0 && $phone.length < 10) {
                errorPhone = false;
            }
        }
        return errorPhone;
    }

    $scope.checkFirstName = function(data) {
        if (data == '') {
          return "The first name is a required field";
        } else {
            $scope.userProfile.first_name = data;
            $scope.updateUser('first_name');
        }
    };

    $scope.checkLastName = function(data) {
        if (data == '') {
          return "The last name is a required field";
        } else {
            $scope.userProfile.last_name = data;
            $scope.updateUser('last_name');
        }
    };

    $scope.checkPhoneNumber = function(phone) {
        $status = 1;
        if(typeof phone != 'undefined') {
            $phone = phone.replace(/[^0-9]/g,'');
            if($phone.length != 0 && $phone.length < 10) {
                $status = 0;
            }
        }
        if($status) {
            if(angular.isUndefined($scope.userProfile.personal_information)) {
                $scope.userProfile.personal_information = {};
            }
            $scope.userProfile.personal_information.phone_number = phone;
            $scope.updateUser('personal_information.phone_number');
        } else {
            return 'Phone number is from 10 to 15 character';
        }
    }

    $scope.checkEmail = function(email,id) {

        $status = 1;
        var regex_email = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/i;
        if(email == '') {
            return "The email is a required field";
        } else if(regex_email.test(email) == false) {
            return "Email Invalid";
        } else {
            var d = $q.defer();
            $http.post('/api/user/profile/check-email', {id: id, email:email}).success(function(res) {
                res = res || {};
                if(res.status == 1) {
                    $scope.userProfile.email = email;
                    $scope.updateUser('email');
                    d.resolve();
                } else {
                    d.resolve('The email has already been taken.');
                }
            }).error(function(e){
                d.reject('Server error!');
            });
            return d.promise;
        }
    }

    $scope.updateUser = function(field){
        $scope.userProfile.field = field;
        UserService.update($scope.userProfile).then(function(data){
            if(data.status) {
                $scope.userProfile = data.item;                    
            }
        });
    }

    $scope.upload = function(files, type) {
        if(files.length != 0) {
            $scope.files = files;
            $scope.getModalCropAvatar();            
        }
    }
    
    $scope.changePassword = function(id) {
        $scope.user['id'] = id;
        UserService.changePassword($scope.user).then(function(data) {
            $scope.error = null;
            $scope.message_success = 'Change password success';
        }, function(r) {
            $scope.error = r.error;
        });
    }

    $scope.getModalCropAvatar = function(size) {
        var modalInstance = $modal.open({
            templateUrl: window.baseUrl + '/app/components/user/views/modal/myModalContent.html',
            controller: 'ModalChangeAvatar',
            size: size,
            resolve: {
                files: function() {
                    return $scope.files;
                },
                userId: function(){
                     return $scope.userProfile.id;
                }
            },
        });
        modalInstance.result.then(function(avatarUrl) {
             $scope.userProfile.avatar = avatarUrl;
        }, function() {

        });
    };
}]);
userModule.controller('ModalChangeAvatar', ['$scope', '$timeout', '$modalInstance', 'Upload', 'UserService', 'files', 'userId',
function($scope, $timeout, $modalInstance, Upload, UserService, files, userId){
    $scope.myImage = '';
    $scope.myCroppedImage = '';
     var reader = new FileReader();

     console.log(files.length,'filse');

    if (files.length != 0) {
        reader.readAsDataURL(files[0]);
        reader.onload = function(evt) {
            $scope.$apply(function() {
                $scope.myImage = evt.target.result;
                $scope.myCroppedImage = evt.target.result;
            });
        };
    }

    $scope.changeAvatar = function() {
        UserService.changeAvatar(userId, $scope.myCroppedImage).then(function(response) {
            $modalInstance.close(response.item.avatar);
        });
    }
     $scope.cancel = function () {
    $modalInstance.dismiss('cancel');
  };
    
}]);


