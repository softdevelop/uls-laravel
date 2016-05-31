var termModule = angular.module('term');

termModule.controller('TermController', ['$rootScope','$scope', 'TermService', '$timeout', '$sce', '$modal', '$controller', 
    function($rootScope, $scope, TermService, $timeout, $sce, $modal, $controller) {
    $controller('BaseController', { $scope: $scope });

    $scope.callbackLoadUserFinish = function(){
        
    };
    $scope.field = window.field;

    $scope.fileds = TermService.setFields(window.htmlOrverideFiled);

    $scope.tagHtml = window.tagHtml;

    $scope.dataOptionMap = window.dataOptionMap;

    // $scope.isMulti = window.isMulti;

    // $scope.fieldIs = window.fieldIs;
    var loadWarrap = function(){
            var countTag =0;
            var countEnd =0;
            var countparent =0;
            if(!$scope.fileds.length) return;
            var parent=$("." + $scope.fileds[0].value.alias).parent();
            for(var i = 0; i <  $scope.fileds.length; i++){
                    if($scope.fileds[i].value.endField){
                        if($scope.tagHtml[countTag].parent=='parent_'+countTag){
                            $("." + $scope.fileds[i].value.alias).after($scope.tagHtml[countTag].html);
                            var addClass='class_add_'+$scope.tagHtml[countTag].parent;
                             parent.find($('.content_Wrapper').last()).addClass(addClass);
                            $("." + $scope.fileds[i].value.alias).appendTo('.class_add_'+$scope.tagHtml[countTag].parent);
                        }
                        else{
                             $('.class_add_'+$scope.tagHtml[$scope.tagHtml[countTag].parent].parent).append($scope.tagHtml[countTag].html);
                             var addClass='class_add_'+$scope.tagHtml[countTag].parent; 
                             parent.find($('.content_Wrapper').last()).addClass(addClass);
                            $("." + $scope.fileds[i].value.alias).appendTo('.class_add_'+$scope.tagHtml[countTag].parent); 
                        }
                        countTag++;
                        countparent++;
                     
                    } else{
                        if($scope.fileds[i].value.postWrapperHtml){
                            if(countparent==1){
                                if(countTag<=countEnd){
                                    return;
                                }
                                $("." + $scope.fileds[i].value.alias).appendTo('.class_add_'+$scope.tagHtml[countTag- countEnd-1].parent); 
                                countEnd=countEnd + $scope.fileds[i].value.postWrapperHtml.length;
                            } else{
                                if(countEnd<=countTag-2){
                                    countEnd=countEnd + $scope.fileds[i].value.postWrapperHtml.length;
                                    if($scope.fileds[i].value.postWrapperHtml.length>1){
                                        if($scope.fileds[i-1].value.postWrapperHtml){
                                            $("." + $scope.fileds[i].value.alias).appendTo('.class_add_'+$scope.tagHtml[countEnd- $scope.fileds[i].value.postWrapperHtml.length].parent); 
                                        } else{
                                            $("." + $scope.fileds[i].value.alias).appendTo('.class_add_'+$scope.tagHtml[countEnd- $scope.fileds[i].value.postWrapperHtml.length+1].parent); 
                                        }
                                    } else{
                                        if($scope.tagHtml[countEnd+1]){
                                            $("." + $scope.fileds[i].value.alias).appendTo('.class_add_'+$scope.tagHtml[countEnd+1].parent); 
                                        } else{
                                            $("." + $scope.fileds[i].value.alias).appendTo('.class_add_'+$scope.tagHtml[countEnd].parent);
                                        }
                                    }
                                } else{
                                    if($scope.tagHtml[countEnd]){
                                        $("." + $scope.fileds[i].value.alias).appendTo('.class_add_'+$scope.tagHtml[countEnd].parent); 
                                        countEnd=countEnd +$scope.fileds[i].value.postWrapperHtml.length;
                                    }
                                }
                            }
                        } else{
                            if(countTag>countEnd){
                              $("." + $scope.fileds[i].value.alias).appendTo('.class_add_'+$scope.tagHtml[countTag-1].parent); 
                            }
                        }
                    }
            }
    }
    $(window).load(function(){
        loadWarrap();
    });
    $rootScope.$on('orverideField', function($event, data) {
        // console.log('xx', data);
        $(".removeWrapperAppent").remove();
        $scope.fileds = TermService.getFields();
        $scope.tagHtml = data;
        $timeout(function() {
                loadWarrap();
        });
        
    });
    // $timeout(function(){
    //     function formatState (state) {
    //         var $state = $(
    //                 '<span>' + state.text + '</span>'
    //             );
    //         return $state;
    //     };

    //     $(".select-field").select2({
    //         placeholder: "--- Select Field ---",
    //         allowClear: true,
    //         templateResult: formatState
    //     });
    // }); 

    /* Change Fields of Term is Modal */
    $scope.changeFieldOfTermIsModal = function(fieldId, termId, $event)
    {
        $scope.data = {};

        $scope.data.termId = termId;

        $scope.data.fieldId = fieldId;

        TermService.changeFieldOfTermIsModal($scope.data).then(function(data){

        }); 
    }

    $scope.updateTerm = function()
    {
        TermService.updateTerm($scope.term).then(function(data){
            if (data.status == 0) {
                $scope.nameExists =data.error;
                $scope.term.name=data.name;
            } else {
                
                $scope.term = data.term;
            }
        }); 
    }
    $scope.changeName= function(){
       
        $scope.nameExists =null;
    }

    $scope.showHtmlField = function()
    {
        TermService.showHtmlField({id :$scope.term['_id'], field_id: $scope.filed.field_id}).then(function(data) {
            $(".removeWrapperAppent").remove();
            $scope.fileds = TermService.getFields();
            $scope.term.fields.push(data.item.value);
            $scope.tagHtml = data.tagHtml;
            $scope.filed = null;
        }).then( function(){
              $timeout(function() {
                 loadWarrap();
            });
        })
    }

    $scope.addMore = function(field_id, $event)
    {
        TermService.showHtmlField({id:$scope.term['_id'], field_id:field_id}).then(function(data) {
            $(".removeWrapperAppent").remove();
            $scope.fileds = TermService.getFields();
            $scope.term.fields.push(data.item.value);
            $scope.tagHtml = data.tagHtml;
            $scope.filed = null;
            $timeout(function() {
                 loadWarrap();
            });
        })
    }
    $scope.deleteGroupHtml = function(field_id, $event)
    {
        TermService.deleteGroupHtml({id:$scope.term['_id'], field_id:field_id}).then(function(data) {
            $(".removeWrapperAppent").remove();
            $scope.fileds = data.fields;
            $scope.term.fields = [];
            for(i in data.fields) {

                $scope.term.fields.push(data.fields[i].value);
            }
            $scope.tagHtml = data.tagHtml;

            $timeout(function() {
                 loadWarrap();
            });

        })
    }

    $scope.getModalUpdateHtmlField = function(field, $event)
    {
        var modalInstance = $modal.open({
            templateUrl: '/admin/terms/update-html-field/' + $scope.term['_id'] + '/' + field.value._id + '?' + new Date().getTime(),
            controller: 'ModalUpdateHtmlFieldTerm',
            resolve: {
                termId: function (){

                    return $scope.term['_id'];
                },
                field: function(){

                    return field;
                }
            }
        });
        modalInstance.result.then(function(data) {
            //  $(".removeWrapperAppent").remove();
            //    $timeout(function() {
            //      loadWarrap();
            // });
        }, function() {
              /*$(".removeWrapperAppent").remove();*/
              /* $timeout(function() {
                 loadWarrap();
            });*/

        });
    }

    $scope.getModalAddWrapper = function(fieldId, index, fieldValue, $event)
    {

        var modalInstance = $modal.open({
            templateUrl: '/admin/terms/add-wrapper/' + $scope.term['_id'] + '/' + fieldId + '?' + new Date().getTime(),
            controller: 'ModalAddWrapper',
            resolve: {
                fields: function() {
                    return $scope.fileds;
                },
                 fieldTerm: function() {
                    return $scope.term.fields;
                },
                index: function (){

                    return index;
                },
                fields_map: function(){

                    return $scope.field;
                },
                termId: function () {

                    return $scope.term['_id'];
                },
                fieldId: function () {

                    return fieldId;
                },
                fieldValue: function () {

                    return fieldValue;
                }
            }
        });
        modalInstance.result.then(function(data) {
            $(".removeWrapperAppent").remove();
            $scope.fileds = data.fields;
            $scope.term.fields = [];
            for(i in data.fields) {
                $scope.term.fields.push(data.fields[i].value);
            }

            $scope.tagHtml =data.tagHtml;

            $timeout(function() {
                loadWarrap();
            });
        },function() {

        })
    }

    $scope.deleteField = function(idField, $event)
    {
        TermService.deleteField($scope.term['_id'], idField).then(function(data) {

            if(data['status']){
                $(".removeWrapperAppent").remove();
                $scope.fileds = data.htmlOrverideFiled;
                $scope.tagHtml = data.tagHtml;

            }
        }).then(function(){
            $timeout(function() {
                loadWarrap();
            }, 1000);
        });
    }

    $scope.showTestModalTerm = function(fileds)
    {

        var modalInstance = $modal.open({
            templateUrl: window.baseUrl + '/app/components/terms/modal/view.html?v='+new Date().getTime(),
            controller: 'ModalView',
            size: undefined,
                resolve: {
                fileds: function () {
                    return fileds;
                }
            }
        });
        modalInstance.result.then(function (selectedItem) {
        }, function () {

        });       
    }

}])
.controller('testTermController', ['$scope', '$sce', '$modal', '$controller', function($scope, $sce, $modal, $controller){
    
    $controller('BaseController', { $scope: $scope });
    $scope.callbackLoadUserFinish = function(){
        
    };
    $scope.field = window.field;

    $scope.dataOptionMap = window.dataOptionMap;

    $scope.fileds = window.htmlOrverideFiled;

    $scope.isMulti = window.isMulti;

    $scope.fieldIs = window.fieldIs;

    $scope.term = window.term;
    $scope.tagHtml = window.tagHtml;
    var loadWarrap = function(){
            var countTag =0;
            var countEnd =0;
            var countparent =0;
            var parent=$("." + $scope.fileds[0].value.alias).parent();
            for(var i = 0; i <  $scope.fileds.length; i++){
                    if($scope.fileds[i].value.endField){
                        if($scope.tagHtml[countTag].parent=='parent_'+countTag){
                            $("." + $scope.fileds[i].value.alias).after($scope.tagHtml[countTag].html);
                            var addClass='class_add_'+$scope.tagHtml[countTag].parent;
                             parent.find($('.content_Wrapper').last()).addClass(addClass);
                            $("." + $scope.fileds[i].value.alias).appendTo('.class_add_'+$scope.tagHtml[countTag].parent);
                        }
                        else{
                             $('.class_add_'+$scope.tagHtml[$scope.tagHtml[countTag].parent].parent).append($scope.tagHtml[countTag].html);
                             var addClass='class_add_'+$scope.tagHtml[countTag].parent; 
                             parent.find($('.content_Wrapper').last()).addClass(addClass);
                            $("." + $scope.fileds[i].value.alias).appendTo('.class_add_'+$scope.tagHtml[countTag].parent); 
                        }
                        countTag++;
                        countparent++;
                     
                    } else{
                        if($scope.fileds[i].value.postWrapperHtml){
                            if(countparent==1){
                                if(countTag<=countEnd){
                                    return;
                                }
                                $("." + $scope.fileds[i].value.alias).appendTo('.class_add_'+$scope.tagHtml[countTag- countEnd-1].parent); 
                                countEnd=countEnd + $scope.fileds[i].value.postWrapperHtml.length;
                            } else{
                                if(countEnd<=countTag-2){
                                    countEnd=countEnd + $scope.fileds[i].value.postWrapperHtml.length;
                                    if($scope.fileds[i].value.postWrapperHtml.length>1){
                                        if($scope.fileds[i-1].value.postWrapperHtml){
                                            $("." + $scope.fileds[i].value.alias).appendTo('.class_add_'+$scope.tagHtml[countEnd- $scope.fileds[i].value.postWrapperHtml.length].parent); 
                                        } else{
                                            $("." + $scope.fileds[i].value.alias).appendTo('.class_add_'+$scope.tagHtml[countEnd- $scope.fileds[i].value.postWrapperHtml.length+1].parent); 
                                        }
                                    } else{
                                        if($scope.tagHtml[countEnd+1]){
                                            $("." + $scope.fileds[i].value.alias).appendTo('.class_add_'+$scope.tagHtml[countEnd+1].parent); 
                                        } else{
                                            $("." + $scope.fileds[i].value.alias).appendTo('.class_add_'+$scope.tagHtml[countEnd].parent);
                                        }
                                    }
                                } else{

                                    $("." + $scope.fileds[i].value.alias).appendTo('.class_add_'+$scope.tagHtml[countEnd].parent); 
                                    countEnd=countEnd +$scope.fileds[i].value.postWrapperHtml.length;
                                }
                            }
                        } else{
                            if(countTag>countEnd){
                              $("." + $scope.fileds[i].value.alias).appendTo('.class_add_'+$scope.tagHtml[countEnd].parent); 
                            }
                        }
                    }
            }
    }
    $(window).load(function(){
        loadWarrap();
    });

    $scope.dataModal = {};

    $scope.showModal = function (term,index)
    {
        console.log('term', term);

        if(typeof $scope.dataModal[index] == 'undefined'){

            $scope.dataModal[index] = [];

        }

        var lenghtHtml = term.htmlField.htmlArr.length;
        
        var modalInstance = $modal.open({
            templateUrl: window.baseUrl+'/manage-term/create-modal/' + lenghtHtml + '?v=' + new Date().getTime(),
            controller: 'ModalView',
            size: undefined,
            resolve: {
                term: function () {
                    return term;
                }
            }
        });
        modalInstance.result.then(function (data) {

            $scope.dataModal[index].push(data);
            
        }, function () {

        });    
    }

    $scope.opened = false;
    
    $scope.open = function () {

        $scope.opened = !$scope.opened;
    }

    $scope.submit = function(form)
    {
        $scope.submitted = true;

        if(!form.$valid){

            angular.element("[name='" + form.$name + "']").find('.ng-invalid:visible:first').focus();

            return;
        }
    }
}])

.controller('ModalView', ['$scope', '$modalInstance', 'term', function($scope, $modalInstance, term){

    $scope.term = term;

    $scope.cancel = function() {

        $modalInstance.dismiss('cancel');
    }

    $scope.submit = function(form){

        $scope.submitted = true;

        if(!form.$valid){

            angular.element("[name='" + form.$name + "']").find('.ng-invalid:visible:first').focus();

            return;
        }

        $modalInstance.close($scope[term.term_name]);
    }

}])


.controller('ModalUpdateHtmlFieldTerm', ['$rootScope', '$scope', '$timeout', '$modalInstance', 'TermService', 'termId', 'field', function($rootScope, $scope, $timeout, $modalInstance, TermService, termId, field) {

    $scope.orveride = {};

    /* Variable identify to show placeholder and add icon in modal update html field of term */
    $scope.isFieldTerm = field.value.term;

    $timeout(function(){

        $scope.col = window.col;

    },500);
    

    $scope.preAddonEntry = function(){

        $scope.orveride.pre_addon = {};

        $scope.orveride.pre_addon.html = '';

        $scope.orveride.pre_addon.glyphicon = '';  

        updateHtmlField();
    }

    $scope.postAddonEntry = function(){

        $scope.orveride.post_addon = {};

        $scope.orveride.post_addon.html = '';

        $scope.orveride.post_addon.glyphicon = '';  

        updateHtmlField();
    }

    var updateHtmlField = function() {

        $scope.orveride.term_id = termId;

        $scope.orveride.field_id = field.value._id;


        $scope.orveride.col = $scope.col;
        $scope.orveride.alias = field.value.alias;
        TermService.updateHtmlField($scope.orveride).then(function(data) {
            $rootScope.$emit('orverideField', data.tagHtml);
        }) 
    }

    $scope.update = function(data){

        updateHtmlField();
    }
    /**
     * [updatePreAddon description]
     * @param  {[type]} html      [description]
     * @param  {[type]} glyphicon [description]
     * @return {[type]}           [description]
     */
    $scope.updatePreAddon = function(html,glyphicon){
        // initialization pre addon
        $scope.orveride.pre_addon = {};

        $scope.orveride.pre_addon.html = html;

        $scope.orveride.pre_addon.glyphicon = glyphicon;      
        // update html field
        updateHtmlField();

    }
    /**
     * [updatePostAddon description]
     * @param  {[type]} html      [description]
     * @param  {[type]} glyphicon [description]
     * @return {[type]}           [description]
     */
    $scope.updatePostAddon = function(html,glyphicon){
        // initialization post addon
        $scope.orveride.post_addon = {};

        $scope.orveride.post_addon.html = html;

        $scope.orveride.post_addon.glyphicon = glyphicon;  
        // update html field
        updateHtmlField();
    }

    $scope.updatePlaceholder = function(placeholder){

        $scope.orveride.placeholder = placeholder;

        updateHtmlField();
    }

    $scope.updateCol = function(col){

        if(col < 1 || col > 12){

            $scope.colValidate = true;

            return;

        }else{

            $scope.colValidate = false;

            $scope.col = col;

            updateHtmlField();
        }
    }

    $scope.augmentCol = function(col){  

        if(col < 12){

            $scope.col++;

            updateHtmlField();

            angular.element("#augment").removeAttr("disabled");

        }else{

            angular.element("#augment").attr("disabled", "true");
        }
        if(col > 1){

            angular.element("#reduction").removeAttr("disabled");

        }
    }

    $scope.reductionCol = function(col){

        if(col > 1){

            $scope.col--;

            updateHtmlField();

            angular.element("#reduction").removeAttr("disabled");

        }else{

            angular.element("#reduction").attr("disabled", "true");
        }

        if(col < 12){

            angular.element("#augment").removeAttr("disabled");
        }
    }

    $scope.cancel = function() {

        $modalInstance.dismiss('cancel');
    }

}])

.controller('ModalAddWrapper', ['$rootScope', '$scope', '$timeout', '$modalInstance', 'TermService','index','fields','fieldTerm','fields_map','termId','fieldId','fieldValue', function($rootScope, $scope, $timeout, $modalInstance, TermService, index, fields,fieldTerm,fields_map,termId,fieldId,fieldValue) {
    $scope.termId = termId;
    $scope.fieldId = fieldId;
    $scope.wrapper = {};
    $scope.wrapper.endField = fieldValue.endField;
    if($scope.wrapper.endField){
        $scope.isDisibled=true;
    } else{
        $scope.isDisibled=false;
    }
    
    $scope.wrapper.preWrapperHtml = fieldValue.preWrapperHtml;

    if(typeof $scope.wrapper.endField != 'undefined' && $scope.wrapper.endField != '') {
        for(i in fields) {
           
            if(fields[i].value._id == $scope.wrapper.endField) {
        
                for ( j in fields[i].value['postWrapperHtml']) {
        
                    if(fields[i].value['postWrapperHtml'][j]['startField']==fieldValue._id){
                        $scope.wrapper.postWrapperHtml =fields[i].value['postWrapperHtml'][j]['html'];  
                    }
                }              
            }
        }
    }

    $scope.getListEndField = function () {
        $scope.listEndField = {};
        for(i in fields) {
            if(i > index) {
                $name_map = fields_map[fields[i].value.field_id];
                $id_field = fields[i].value._id;
                $scope.listEndField[$id_field] = $name_map;
            }
        }
    }

    $scope.addWrapper = function (validate) {
        $scope.submitted = true;
        if(validate) {
            return;
        }
        TermService.addWrapper($scope.termId,$scope.fieldId,$scope.wrapper).then(function(data) {
            if(!data.status) {
                $scope.error = "Can not update wrapper";
                return;
            } else {
                $modalInstance.close(data);
            }
        })

    }

    $scope.cancel = function() {

        $modalInstance.dismiss('cancel');
    }

}]);