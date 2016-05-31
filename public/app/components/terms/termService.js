var termModule = angular.module('term');
termModule.factory('TermResource', ['$resource',function($resource){
	return $resource('/api/term/:method/:id/:_id', {method:'@method', id: '@id', _id: '@_id'}, {
		add: {method: 'post'},
		save: {method: 'post'},
        update: {method: 'put'}
	})
}])
.service('TermService', ['$q', '$filter', 'TermResource',  function($q, $filter, TermResource){


    var fields = [];

    var terms = [];
    /**
     * Call server to create role
     * @param  {[object]} data role info
     * @return {[promise]}      promise
     */
	this.create = function(data)
    {
        var defer = $q.defer();

        var temp = new TermResource(data);
        temp.$save({}, function success(data) {

                defer.resolve(data);

            },
            function error(reponse) {
               defer.resolve(reponse.data);
            });

        return defer.promise;
    }

    this.update = function(data)
    {
        var defer = $q.defer();

        var temp = new TermResource(data);
        temp.$update({'id':data['_id']},function success(data) {

               defer.resolve(data);

            },function error(reponse) {
               defer.resolve(reponse.data);
            });

        return defer.promise;
    }
    this.updateTerm = function(data)
    {
        var defer = $q.defer();

        var temp = new TermResource(data);
        temp.$save({'id':data['_id'],method:'update-term'},function success(data) {

               defer.resolve(data);

            },function error(reponse) {
               defer.resolve(reponse.data);
            });

        return defer.promise;
    }

    this.showHtmlField = function(data)
    {
        var defer = $q.defer();

        var temp = new TermResource(data);

        temp.$save({id:data['id'],method:'get-show-html-field'},function success(data) {
                fields=data.htmlOrverideFiled;
                defer.resolve(data);

             /*   fields.push(data['item']);*/

            },function error(reponse) {
               defer.resolve(reponse.data);
            });

        return defer.promise;
    }

    this.updateHtmlField = function(data)
    {
        var defer = $q.defer();

        var temp = new TermResource(data);

        temp.$save({id:data['term_id'],method:'update-html-field'},function success(data) {
                // console.log(fields);
                fields = data['htmlOrverideFiled '];
                // console.log(data.htmlOrverideFiled);
                // for(var key in fields){

                //     if(fields[key]['value']['_id'] == data.item['value']['_id']){

                //         fields[key] = data.item;

                //         break;
                //     }
                // }
                defer.resolve(data);
            },function error(reponse) {
               defer.resolve(reponse.data);
            });

        return defer.promise;
    }

    this.addWrapper = function(termId,fieldId,data)
    {
        var defer = $q.defer();

        var temp = new TermResource(data);

        temp.$save({id:termId,_id:fieldId,method:'add-wrapper'},function success(data) {
                fields = data.htmlOrverideFiled;
                defer.resolve(data);
            },function error(reponse) {
               defer.resolve(reponse.data);
            });

        return defer.promise;
    }
    this.deleteGroupHtml = function(id, field_id)
    {
        var data=[];
        data.id=id;
        data.field_id=field_id;
        var defer = $q.defer();

        var temp = new TermResource(data);


        temp.$save({method:'delete-group-html'}, function success(data) {
                defer.resolve(data);

        },function error(reponse) {
               defer.resolve(reponse.data);
        });

        return defer.promise;
    }
    this.changeFieldOfTermIsModal = function(data)
    {
        var defer = $q.defer();

        var temp = new TermResource(data);

        temp.$save({method:'change-field-is-modal'}, function success(data) {

                defer.resolve(data);

            },function error(reponse) {
               defer.resolve(reponse.data);
            });

        return defer.promise;
    }

    this.deleteField = function(id, _id)
    {
        var defer = $q.defer();
        TermResource.delete({ id: id, _id:_id , method:'delete-field-term'}, function(data) {
            defer.resolve(data);

        });
        return defer.promise;
    }

    /**
     * push roles to service that controller or directive can use it (shared)
     * @param {[array]} data list roles
     */
    this.setFields = function(data){
        fields = data;
        return fields;
    }

    /**
     * [getData description]
     * @return {[type]} [description]
     */
    this.getFields = function() {
        return fields;
    }

    /**
     * Delete term
     *
     * @author Thanh Tuan <tuan@httsolution>
     *
     * @param  {String} id term id
     *
     * @return {Void}
     */
    this.remove = function (id) {
        var defer = $q.defer();
        var temp  = new TermResource();
        temp.$delete({id: id}, function success(data) {
            if (data.status != 0) {
                for (var key in terms) {
                    if (terms[key]._id == id){
                        terms.splice(key, 1);
                        break;
                    }
                }
            }
            defer.resolve(data);
        },
        function error(reponse) {
            defer.resolve(reponse.data);
        });
        return defer.promise;
    }

    this.setTerms = function (data) {
        terms = data;
        return terms;
    }

    this.getTerms = function (data) {
        return terms;
    }
}])
