var assetApp = angular.module('assetManager');
assetApp.controller('CropImageAssetController', ['$scope', '$modal', 'AssetManagerService','$timeout', function ($scope, $modal, AssetManagerService,$timeout){
    $scope.isFinishedCrop = false;
    $('.content-crop-asset').removeClass('hidden');
    $scope.assetFile = window.assetFile;

    $scope.obj = {};
    $scope.size = '200x200';

    $scope.obj.config = {
        minSize: [ 200, 200 ],
        maxSize: [ 200, 200 ],
        allowResize: false

    };

    $scope.obj.src = window.baseUrl+ '/cms/asset-manager/file/'+ $scope.assetFile._id;

    /**
     * crop
     * @return {[type]} [description]
     */
    $scope.crop = function() {
        AssetManagerService.crop({id:$scope.assetFile._id, coords: $scope.imageCroped ,size:$scope.size}).then(function(data){
            if(!data.status){
                if(!angular.isUndefined(data.maxSize)){
                    alert('It is always smaller than' + data.maxSize);
                } else {
                    alert('Crop is not the standard of size');
                }
            } else{
                $scope.isFinishedCrop = true;
                previewImageCrop($scope.obj.src+'?v=' + new Date().getTime());
            }

        });
    }
    $(window).resize(function (){
        $scope.setDIVHeight();
    });
    $scope.setDIVHeight = function() {
        var theDivCode =  $('.content-crop-images');

        var offset = theDivCode.offset();

        var offsetTop = offset.top;

        var winHeight = $(window).height();
        console.log(winHeight);

        var divHeight = winHeight - offsetTop - 30;

        theDivCode.attr('style', 'height: ' + divHeight + 'px!important;overflow:auto'  );
    }


    /**
     * [previewImageCrop show result of cropping]
     * @author toan
     */
    var previewImageCrop = function(imageSrc){
        var modalInstance = $modal.open({
          animation: $scope.animationsEnabled,
          templateUrl: 'imageCropPreview.html',
          controller: 'imageCropPreviewCtroller',
          size: null,
          resolve: {
            imageSrc: function () {
              return imageSrc;
            }
          }
        });

        modalInstance.result.then(function (selectedItem) {
          window.location.href = window.baseUrl + '/cms/asset-manager'
        }, function () {
          window.location.href = window.baseUrl + '/cms/asset-manager'
        });
    };


}]);

assetApp.controller('imageCropPreviewCtroller',['$scope', '$modalInstance', 'imageSrc', function ($scope, $modalInstance, imageSrc) {

  $scope.imageSrc = imageSrc;
  $scope.ok = function () {
    $modalInstance.close();
  };

  $scope.cancel = function () {
          $modalInstance.dismiss('cancel');
      };

}]);
