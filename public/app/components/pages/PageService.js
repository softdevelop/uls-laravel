var pageApp = angular.module('pageApp');

pageApp.factory('PageResource', ['$resource', function($resource) {
        return $resource('/api/pages/:method/:id', {
            'method': '@method',
            'id': '@id'
        }, {
            add: {
                method: 'post'
            },
            save: {
                method: 'post'
            },
            update: {
                method: 'put'
            },
            check: {
                method: 'post'
            },
            editNameFolder: {
                method: 'edit-name-folder'
            },
            deleteContent: {
                method: 'delete-content'
            }
        });
    }])
    .service('PageService', ['PageResource', '$q', function(PageResource, $q) {
        var that = this;
        var pages = [];
        /* create new page */
        this.createPageProvider = function(data) {
            var defer = $q.defer();
            var temp = new PageResource(data);
            temp.$save({}, function success(data) {
                    /* Create page success */
                    if (data.status != 0) {
                        /* Push new page to array pages */
                        pages.push(data.page);
                    }
                    defer.resolve(data);
                },
                function error(reponse) {
                    defer.resolve(reponse.data);
                });
            return defer.promise;
        };

        /* Edit page */
        this.editPageProvider = function(id, data) {
            var defer = $q.defer();
            var temp = new PageResource(data);
            temp.$update({
                    id: id
                }, function success(data) {
                    /* Foreach array pages */
                    for (var key in pages) {
                        /* If page in array = page edit then assign page edit for page */
                        if (pages[key]['key'] == data.page.key) {
                            pages[key] = data.page;
                            break;
                        }
                    }
                    defer.resolve(data);
                },
                function error(reponse) {
                    defer.resolve(reponse.data);
                });
            return defer.promise;
        };
        /* move Page */
        this.movePage = function(data){
            var defer = $q.defer(); 
            var temp  = new PageResource(data);
            temp.$save({method: 'move-page'}, function success(data) {
                /* Create page success */
                defer.resolve(data);
            },
            function error(reponse) {
                defer.resolve(reponse.data);
            });
            return defer.promise;  
        };

        /* Get child pages */
        this.getItemByCategoryId = function(key) {
            var defer = $q.defer();
            var temp = new PageResource();
            temp.$get({
                    id: key
                }, function success(data) {
                    pages = data.items;
                    defer.resolve(data);
                },
                function error(reponse) {
                    defer.resolve(reponse.data);
                });
            return defer.promise;
        };

        /* Check url page is exists */
        this.checkUrlExists = function(id, data) {
            var defer = $q.defer();
            var temp = new PageResource(data);
            temp.$check({
                    id: id,
                    method: 'check-url'
                }, function success(data) {
                    defer.resolve(data);
                },
                function error(reponse) {
                    defer.resolve(reponse.data);
                });
            return defer.promise;
        };

        /* Get position of template */
        this.getTemplatePosition = function(templateId) {
            var defer = $q.defer();
            PageResource.get({
                    method: 'get-position',
                    id: templateId
                }, function success(data) {
                    defer.resolve(data);
                },
                function error(reponse) {
                    defer.resolve(reponse.data);
                });
            return defer.promise;
        }

        /* Get position of template */
        this.getTemplate = function() {
            var defer = $q.defer();
            if ( !angular.isUndefined(window.hashData['cms_content']) &&  window.hashData['cms_content'] == 1) {
                var template = JSON.parse(localStorage.getItem('tempate'));
                defer.resolve(template);
            } else {
            PageResource.get({
                    method: 'get-template'
                }, function success(data) {
                    // localStorage.setItem("tempate", "Smith");
                    localStorage.setItem('tempate', JSON.stringify(data));
                    defer.resolve(data);
                },
                function error(reponse) {
                    defer.resolve(reponse.data);
                });
            }


            return defer.promise;
        }

        /**
         * Add tag for page
         * @param string id   id of page
         * @param Objedt data data input
         */
        this.addTagsForPage = function(id, data) {
            var defer = $q.defer();
            var temp = new PageResource(data);
            temp.$save({
                    id: id,
                    method: 'add-tags'
                }, function success(data) {
                    // If add tags successfull
                    if (data.status != 0) {

                    }
                    defer.resolve(data);
                },
                function error(reponse) {
                    defer.resolve(reponse.data);
                });
            return defer.promise;
        }

        this.createFolder = function(data) {
            var defer = $q.defer();
            var temp = new PageResource(data);
            temp.$save({
                    method: 'folder-create'
                }, function success(data) {
                    /* Create page success */
                    defer.resolve(data);
                },
                function error(reponse) {
                    defer.resolve(reponse.data);
                });
            return defer.promise;
        }

        /* Set data pages */
        this.setPages = function(data) {
            pages = data;
            return pages;
        }

        /* Get array pages */
        this.getPages = function() {
            return pages;
        }

        this.formatContentWithTemplatePosition = function(data) {
            //init content
            var content = {};

            for (var key in data) {
                if (angular.isUndefined(content[data[key].template_id])) {
                    content[data[key].template_id] = {};
                }
                content[data[key].template_id][data[key].position_id] = data[key].content;
            }

            return content;

        }

        /**
         * Delete page
         *
         * @author Thanh Tuan <tuan@httsolution.com>
         *
         * @param  {String} id Page id
         *
         * @return {Void}
         */
        this.deletePage = function (id) {
            var defer = $q.defer();
            var temp  = new PageResource();
            temp.$delete({id: id}, function success(data) {
                defer.resolve(data);
            },
            function error(reponse) {
                defer.resolve(reponse.data);
            });
            return defer.promise;
        }

        /**
         * Delete Content of page
         *
         * @author Thanh Tuan <tuan@httsolution.com>
         *
         * @param  {String} id Id of Content
         *
         * @return {Void}
         */
        this.deleteContentPage = function (id) {
            var defer = $q.defer();
            var temp  = new PageResource();
            temp.$get({id: id, method: 'delete-content'}, function success(data) {
                defer.resolve(data);
            },
            function error(reponse) {
                defer.resolve(reponse.data);
            });
            return defer.promise;
        }

        /**
         * Edit name of folder page
         *
         * @author Thanh Tuan <tuan@httsolution.com>
         *
         * @param  Object data Folder
         *
         * @return Void
         */
        this.editNameFolder = function(data){
        var defer = $q.defer();
        var temp  = new PageResource(data);
        temp.$save({id: data['id'], method: 'edit-name-folder'}, function success(data) {
            defer.resolve(data);
        },
        function error(reponse) {
            defer.resolve(reponse.data);
        });
        return defer.promise;
    };

    }])
