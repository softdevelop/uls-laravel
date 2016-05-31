assetmanagerApp.controller('EditAssetController', ['$scope', '$modal', 'ngTableParams','$timeout','AssetManagerService', 'CmsContentFolderService', '$filter', '$templateCache', function ($scope, $modal, ngTableParams, $timeout, AssetManagerService, CmsContentFolderService, $filter, $templateCache){

    /**
     * load codemirror plugin
     */
    $timeout(function () {
        $scope.editableCodeMirror = CodeMirror.fromTextArea(document.getElementById('editor'), {
            // mode:  "htmlmixed",
            theme: "monokai",
            styleActiveLine: true,
            lineNumbers: true,
        });


        //catch event change content
        $scope.editableCodeMirror.on("change", function() {
            $timeout(function(){
                $scope.$apply(function(){
                    var content = $scope.editableCodeMirror.getValue();
                    $scope.requiredEditorContent = false;
                    //check validate
                    if (content == '') {
                        $scope.requiredEditorContent = true;
                    }
                    // $scope.changeSaveDraft($scope.formData.$invalid);
                });
            });
        });
    });


    /**
     * set height Editor full screen
     *
     * @author Cong Hoan <hoan@httsolution.com>
     *
     * @return Void
    */
    
    $timeout(function(){
        $(document).ready(function (){
            $scope.setDIVHeight();
        });

        $(window).resize(function (){
            $scope.setDIVHeight();
        });

    })

    $scope.setDIVHeight = function() {
        var theDivCode =  $('.set-height');

        var Divtop = $('.set-height').offset();

        var divTop = Divtop.top;
        console.log(divTop);

        // var winHeight = $(window).height();
        var winHeight = screen.height;
        console.log(winHeight);

        var divHeight = winHeight - divTop - 170;

        theDivCode.attr('style', 'height: ' + divHeight + 'px!important;overflow:auto'  );
    }


    $scope.cancel = function() {
        window.location.href = 'cms/asset-manager';
    }

    /**
     * [updateContentFile description]
     * update contetn file with file id
     *
     * @author [bang@httsolution.com]
     * 
     * @param  {[type]} fileId   [description]
     * @param  {[type]} validate [description]
     * 
     * @return {[type]} void        [description]
     */
    $scope.updateContentFile = function(fileId, validate) {
        $scope.submitted = true;
        if ($scope.requiredEditorContent || angular.isUndefined(fileId)) {
              return;
        }
        $scope.isSaving = true;
        $scope.asset.content = $scope.editableCodeMirror.getValue();
        if($scope.asset.content == ''){
            $scope.requiredEditorContent = true;
            return;
        }
        
        AssetManagerService.updateContentFile(fileId, $scope.asset).then(function(data) {
            if (data['status']) {
                window.location.href = 'cms/asset-manager/set-asset-selected/' + $scope.asset.folder_id;
            }
            $scope.isSaving = false;
        })
    }
    
}]);

