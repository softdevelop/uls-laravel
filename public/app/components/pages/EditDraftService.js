var editDraftApp = angular.module('EditDraftApp', []);

editDraftApp.factory('EditDraftResource',['$resource', function ($resource){
    return $resource('/api/pages/:method/:id', {'method':'@method','id':'@id'}, {
        add: {method: 'post'},
        save:{method: 'post'},
        update:{method: 'put'}
    });
}]);

editDraftApp.service('EditDraftService', ['EditDraftResource', '$q', function (EditDraftResource, $q) {

    this.editDraft = function(data){
        var defer = $q.defer(); 
        var temp  = new EditDraftResource(data);
        temp.$save({method:'edit-draft'}, function success(data) {
            defer.resolve(data);
        },
        function error(reponse) {
            defer.resolve(reponse.data);
        });
        return defer.promise;  
    }
    this.editChangeDraft = function(data, parent, text){

        var defer = $q.defer(); 
        var temp  = new EditDraftResource(data);

        temp.$save({method:'edit-change-draft'}, function success(data) {
            defer.resolve(data);
        },
        function error(reponse) {
            defer.resolve(reponse.data);
        });
        return defer.promise;  
    }

    this.createDraftContentPreview = function(data, parent){

        var defer = $q.defer(); 
        var temp  = new EditDraftResource(data);

        temp.$save({method:'create-preview-draft'}, function success(data) {
            defer.resolve(data);
        },
        function error(reponse) {
            defer.resolve(reponse.data);
        });
        return defer.promise;  
    }

    this.changePositionOfBlock = function (data) {
        var defer = $q.defer(); 
        var temp  = new EditDraftResource(data);

        temp.$save({method:'change-position-block'}, function success(data) {
            defer.resolve(data);
        },
        function error(reponse) {
            defer.resolve(reponse.data);
        });
        return defer.promise;  
    }

    this.addFieldType = function(data)
    {
        var defer = $q.defer(); 
        var temp  = new EditDraftResource(data);

        temp.$save({method:'add-field-type'}, function success(data) {
            defer.resolve(data);
        },
        function error(reponse) {
            defer.resolve(reponse.data);
        });
        return defer.promise; 
    }

    this.addFieldType = function(field, templateId, index, indexcurrentFile, dynamicIndex) {
        var defer = $q.defer();

        if (typeof index == 'undefined') {

            dynamicIndex = 1;

        } else {

            dynamicIndex = index + 1;
        }

        // var strFind = '\[0\]';

        var regExpField = new RegExp('[[0]]', 'g');

        var htmlLabel = '<label class="label-form"><span class="pointer" \
        ng-click="removeFieldType(' + indexcurrentFile + ',' + dynamicIndex + ',\'' + field['variable'].trim() + '\')"> '
        + field.name + '&nbsp<i class="fa fa-times"></i></span></label><div class="clearfix"></div>';

        var formHtml = angular.copy(field.form);

        formHtml = formHtml.replace(regExpField, dynamicIndex + ']');

        var validate = '<small class="help-inline" ng-show="submitted && !curFields.'+field.variable+'['+dynamicIndex+'] && '+field.required +' == true"><span style="text-transform: capitalize;">'+field.name+'</span> is invalid</small>';

        formHtml = '<div id="element-apepend-' + indexcurrentFile + dynamicIndex + '">' + htmlLabel + formHtml + validate +'</div>';
        

        defer.resolve({'dynamicIndex':dynamicIndex, 'html': formHtml});

        return defer.promise;

    }

    this.convertContentToInject = function(sections) {
        var defer = $q.defer();
        var length = Object.keys(sections).length;
        var count = 0;

         if(count == length) {
            defer.resolve(sections);
            return defer.promise;
        }

        for(i in sections) {
            count++;
            var element = $('<div>' + sections[i] + '</div>').find('[data^="inject"]');

            element.each(function(index, el) {

                var inject = "{{" + $(el).attr('data') + "}}";

                sections[i] = sections[i].replace(' >','>');

                sections[i] = sections[i].replace($(el)[0].outerHTML, inject);
            });
            if(count == length) {
                defer.resolve(sections);
                return defer.promise;
            }
        }
    }

    this.getContentForIframe = function () {
        var defer = $q.defer(); 
        var temp  = new EditDraftResource(data);

        temp.$save({method:'get-content-iframe'}, function success(data) {
            defer.resolve(data);
        },
        function error(reponse) {
            defer.resolve(reponse.data);
        });
        return defer.promise; 
    }

    /**
     * [getListQueryWithViewId description]
     *
     * get all recode's value of table follow table name and column
     *
     * @author [bang@httsolution.com]
     * 
     * @return {[type]} [description]
     */
    this.getListQueryWithViewId = function(data) {
        var defer = $q.defer(); 
        var temp  = new EditDraftResource(data);

        temp.$save({method:'get-list-query-with-view-id', 'id':data['id']}, function success(result) {
            defer.resolve(result);
        },
        function error(reponse) {
            defer.resolve(reponse.data);
        });
        return defer.promise;
    }

    /**
     * [customDataDatabsesFieldOfTemplate description]
     *
     * get all recode's value of table follow table name and column
     *
     * @author [bang@httsolution.com]
     * 
     * @return {[type]} [description]
     */
    this.customDataDatabsesFieldOfTemplate = function(data) {
        var defer = $q.defer(); 
        var temp  = new EditDraftResource(data);

        temp.$save({method:'custom-data-databses-field-of-template'}, function success(result) {
            defer.resolve(result);
        },
        function error(reponse) {
            defer.resolve(reponse.data);
        });
        return defer.promise;
    }

    this.getParentUrl = function(data) {
        var defer = $q.defer();
        var temp  = new EditDraftResource(data);

        temp.$save({method:'get-parent-url'}, function success(result) {
            defer.resolve(result);
        },
        function error(reponse) {
            defer.resolve(reponse.data);
        });
        return defer.promise;
    }

    this.getDataPage = function(data) {

        var defer = $q.defer(); 
        var temp  = new EditDraftResource(data);

        temp.$save({method:'get-data-page'}, function success(result) {
            defer.resolve(result);
        },
        function error(reponse) {
            defer.resolve(reponse.data);
        });
        return defer.promise;

    }
    /**
     * remove data page
     * @param  {[type]} id [description]
     * @return {[type]}    [description]
     */
    this.removeDataPage = function(id) {
        var defer = $q.defer();
        EditDraftResource.get({id:id, method:'remove-data-page'}, function(data) {

            defer.resolve(data);
        });
        return defer.promise;
    };
    /**
     * [sortArray description]
     *
     * @author Minh than <than@httsolution.com>
     * @param  {[type]} oldIndex       [description]
     * @param  {[type]} newIndex       [description]
     * @param  {[type]} arrayBeforSort [description]
     * @return {[type]}                [description]
     */
    this.sortArray = function(oldIndex, newIndex, arrayBeforSort) {

        var arrayAfterSort = [];
        var defer = $q.defer();
        for(var key in arrayBeforSort) {

            if(key == newIndex) { // if position key == newIndex
                if(arrayBeforSort[oldIndex]) {

                    arrayAfterSort[newIndex] = arrayBeforSort[oldIndex]; // data nested to new index
                }
            }
            if(newIndex > oldIndex) { // move down position

                // check key is equal oldIndex and key less than or equal newIndex to set data
                if(key > oldIndex && key <= newIndex) {
                    // arrayBeforSort not is null
                    if(arrayBeforSort[key]) {
                        // down 1 key to set data curremt key
                        arrayAfterSort[parseInt(key) - 1] = arrayBeforSort[key];
                    }
                }
                else if(key > newIndex || key < oldIndex) {
                     // arrayBeforSort not is null
                    if(arrayBeforSort[key]) {
                        arrayAfterSort[key] = arrayBeforSort[key]; // set current ket  to equal key
                    }  
                } 
            } else if(newIndex < oldIndex) { // if move up position 

               if(key < oldIndex && key >= newIndex) {
                     // arrayBeforSort not is null
                    if(arrayBeforSort[key]) {
                        arrayAfterSort[parseInt(key) + 1] = arrayBeforSort[key];
                    } 
                }else if (key < newIndex || key > oldIndex) {
                     // arrayBeforSort not is null
                    if(arrayBeforSort[key]) {
                        arrayAfterSort[key] = arrayBeforSort[key];
                    }
                } 
            }
        }

        defer.resolve(arrayAfterSort);

        return defer.promise;

    }

}])