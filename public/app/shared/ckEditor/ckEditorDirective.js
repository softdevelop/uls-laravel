angular.module('uls')
	.directive('ckEditor', function() {
  return {
    require: '?ngModel',
    scope: true,
    link: function(scope, elm, attr, ngModel) {
      var ck = CKEDITOR.replace(elm[0]);
       	  CKEDITOR.config.filebrowserBrowseUrl= '/browser/browse.php';
	      CKEDITOR.config.filebrowserImageBrowseUrl='/browser/browse.php?type=Images';
	      CKEDITOR.config.filebrowserUploadUrl='/uploader/upload.php';
	      CKEDITOR.config.filebrowserImageUploadUrl='/uploader/upload.php?type=Images';
	      CKEDITOR.config.filebrowserWindowWidth='900';
	      CKEDITOR.config.filebrowserWindowHeight='400';
	      CKEDITOR.config.filebrowserBrowseUrl='/ckfinder/ckfinder.html?Type=Images';
	      CKEDITOR.config.filebrowserImageBrowseUrl= '/ckfinder/ckfinder.html?Type=Images';
	      CKEDITOR.config.filebrowserFlashBrowseUrl='/ckfinder/ckfinder.html?Type=Flash';
	      CKEDITOR.config.filebrowserUploadUrl= '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files';
	      CKEDITOR.config.filebrowserImageUploadUrl='/ckfinder/core/connctor/php/connector.php?command=QuickUpload&type=Images';
	      CKEDITOR.config.filebrowserFlashUploadUrl='/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash';
      if (!ngModel) return;

      ck.on('instanceReady', function() {
        ck.setData(ngModel.$viewValue);
      });

      function updateModel() {
          scope.$apply(function(){
              ngModel.$setViewValue(ck.getData());
          })
      }

      ck.on('pasteState', updateModel);
      ck.on('change', updateModel);
      ck.on('key', updateModel);
      ck.on('dataReady', updateModel);

      ngModel.$render = function(value) {
        ck.setData(ngModel.$viewValue);
      };
    }
  };
});