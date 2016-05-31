var helpEditorApp = angular.module('HelpEditorApp');

helpEditorApp.factory('HelpEditorResource',['$resource', function ($resource){
    return $resource('/api/help-editor/:method/:_id', {'method':'@method','_id':'@_id'}, {
        add: {method: 'post'},
        save: {method: 'post'},
        update: {method: 'put'},
        editNameFolder: {method: 'edit-name-folder'}
    });
}])
.service('HelpEditorService', ['HelpEditorResource', '$q', function (HelpEditorResource, $q) {
    var that = this;

    this.createHelpEditor = function(data){

        if(angular.isDefined(data._id)) {
            return this.updateHelpEditor(data);
        }
        var defer = $q.defer();
        var temp  = new HelpEditorResource(data);
        temp.$save({}, function success(data) {
            defer.resolve(data);
        },
        function error(reponse) {
            defer.resolve(reponse.data);
        });
        return defer.promise; 
    };

    this.createNewTopic = function(data){

        if(angular.isDefined(data._id)) {
            return this.updateHelpEditor(data);
        }

        var defer = $q.defer();
        var temp  = new HelpEditorResource(data);
        temp.$save({method: 'create-new-topic'}, function success(data) {
            defer.resolve(data);
        },
        function error(reponse) {
            defer.resolve(reponse.data);
        });
        return defer.promise; 
    };

    this.updateHelpEditor = function(data){
        var defer = $q.defer();
        var temp  = new HelpEditorResource(data);
        temp.$update({}, function success(data) {
            defer.resolve(data);
        },
        function error(reponse) {
            defer.resolve(reponse.data);
        });
        return defer.promise;
    };

    this.deleteHelpEditor = function(id) {
        var defer = $q.defer();
        data = {_id:id};
        var temp  = new HelpEditorResource(data);
        temp.$delete({}, function success(data) {
            defer.resolve(data);
        },
        function error(reponse) {
            defer.resolve(reponse.data);
        });
        return defer.promise;
    }

    this.getListHelpEditorWithParentIdZero = function() {
        var defer = $q.defer();
        var temp  = new HelpEditorResource();

        temp.$save({method:'get-list-help-editor-with-parent-id-zero'}, function success(data) {
            defer.resolve(data);
        },

        function error(reponse) {
            defer.resolve(reponse.data);
        });

        return defer.promise;
    }

    /**
     * add page
     *
     * @author Quang <quang@httsolution.com>
     * 
     * @param {[type]} data [description]
     */
    this.addPage = function(data) {
        var defer = $q.defer();
        var temp  = new HelpEditorResource(data);
        temp.$save({method:'add-page'}, function success(data) {
            defer.resolve(data);
        },
        function error(reponse) {
            defer.resolve(reponse.data);
        });
        return defer.promise; 
    }

    /**
     * update sort number
     * @author Thanh Tuan <tuan@httsolution.com>
     * @param  {Object} data Data input
     * @return {Void}      
     */
    this.updateSortNumber = function(data) {
        var defer = $q.defer();
        var temp  = new HelpEditorResource(data);
        temp.$save({method:'update-sort-number'}, function success(data) {
            defer.resolve(data);
        },
        function error(reponse) {
            defer.resolve(reponse.data);
        });
        return defer.promise; 
    }

    
}])
