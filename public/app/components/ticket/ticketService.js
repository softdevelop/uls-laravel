var branchModule = angular.module('ticket');
branchModule.factory('TicketResource', ['$resource',function($resource){
    return $resource('/api/support/:method/:id/:idExpenseReport/:status', {}, {
        add: {method: 'post'},
        save: {method: 'post'},
        update: {method: 'put'},
        get : {method : 'get'},
        deleteTicket: {method: 'delete-ticket'}
    })
}]).service('TicketService', ['$q', '$filter', 'TicketResource', function($q, $filter, TicketResource){
    var items = [];
    var ticket = [];
    var usersInvitation = [];
    var usersAssign = [];
    var that = this;
    var currentItem;
    var config = [];
    var type;
    var decision;
    var expenseReport = [];
    var invites = [];
    var countFollowing;
    var filesUser = [];
    /**
     * Call server to create branch
     * @param  {[object]} data branch info
     * @return {[promise]}      promise
     */
    this.create = function(data) {
        if(typeof data['id'] != 'undefined'){
            return that.update(data);
        }
        var defer = $q.defer();
        var temp = new TicketResource(data);
        temp.$save({},
            function success(data) {
                if(data.status && data.item){
                }
                defer.resolve(data);

            },
            function error(reponse) {
               defer.resolve(reponse.data);
            });

        return defer.promise;
    };

    this.updatePercentComplete = function(ticketId, percent) {
        var defer = $q.defer();
        var temp = new TicketResource(percent);

        temp.$save({method: 'update-percent-complete', id: ticketId, percent: percent}, function success(data) {
            defer.resolve(data);
        },
        function error(reponse) {
           defer.resolve(reponse.data);
        });

        return defer.promise;
    }

    this.updateDueDate = function(ticketId, due_date,checkDueDate) {
        var defer = $q.defer();

        var data = {'due_date': due_date,'check_due_date':checkDueDate};

        var temp = new TicketResource(data);


        temp.$save({method: 'update-due-date', id: ticketId}, function success(data) {
            defer.resolve(data);
        },
        function error(reponse) {
           defer.resolve(reponse.data);
        });

        return defer.promise;
    }
     /**
     * Call server to create branch
     * @param  {[object]} data branch info
     * @return {[promise]}      promise
     */
    this.addComment = function(data) {

        var defer = $q.defer();
        var temp = new TicketResource(data);
        temp.$save({id:data['id'], method:'add-comment'},
            function success(data) {
                /*if(data.status && data.item){
                     if(ticket.length == 0 || typeof ticket['comments'] == 'undefined'){
                        ticket['comments'] = [];
                    }
                     console.log(data, 'huy123');
                    ticket['comments'].push(data.item);
                }*/
                defer.resolve(data);

            },

            function error(reponse) {
               defer.resolve(reponse.data);
            });

        return defer.promise;
    };

    //set comments
    this.setComments = function(data, isAdmin,isSysAdmin){
        if(window.userId != data ['user_id'] || isAdmin || isSysAdmin){
            ticket = data;
            return ticket;
        }
        var comments = [];
        for(var key in data['comments']){
            if(data['comments'][key]['ticket_state'] != 'private'){
                comments.push(data['comments'][key]);
            }
        }
        data['comments'] = comments;
        ticket = data;
        return ticket;
    };

    //get comments
    this.getComments = function(){
        return ticket;
    };

    /**
     * push comment real time
     * @param  object  data       data
     * @param  {Boolean} isAdmin    [is admin or not]
     * @param  {Boolean} isSysAdmin [is system admin or not]
     * @return object             [ticket]
     */

    this.pushCommentReadTime = function(data, isAdmin, isSysAdmin) {

        console.log(ticket['comments'],'ll');

        if(typeof ticket['comments'] == 'undefined'){

            ticket['comments'] = [];
        }

        for(var key in ticket['comments']){

            if(ticket['comments'][key]['_id'] != 'undefined'){

                if(ticket['comments'][key]['_id'] == data['_id']){

                    return ticket;
                }

            }else{

                if(ticket['comments'][key]['_id'] == data['_id']){

                    return ticket;
                }
            }
        }

        if(window.userId != ticket['user_id'] || isAdmin || isSysAdmin){
            ticket['comments'].push(data);
            return ticket;
        }

        if(data['ticket_state'] != 'private'){

             for(var key in ticket['comments']){

                if(ticket['comments'][key]['ticket_state'] == 'private'){

                    ticket['comments'].splice(key, 1);
                }
            }
            ticket['comments'].push(data);
        }
        console.log('ticket', ticket);
        return ticket;
    }

         /**
     * Call server to create branch
     * @param  {[object]} data branch info
     * @return {[promise]}      promise
     */
    this.close = function(data) {
        var defer = $q.defer();
        var temp = new TicketResource(data);
        temp.$save({id:data['id'], method:'close'},
            function success(data) {
                if(data){
                    if(ticket.length == 0 || typeof ticket['comments'] == 'undefined'){
                        ticket['comments'] = [];
                    }
                    ticket['comments'].push(data);
                }
                defer.resolve(data);

            },

            function error(reponse) {
               defer.resolve(reponse.data);
            });

        return defer.promise;
    };
        /**
     * Call server to create branch
     * @param  {[object]} data branch info
     * @return {[promise]}      promise
     */
    this.response = function(data) {
        var defer = $q.defer();
        var temp = new TicketResource(data);
        temp.$save({id:data['id'], method:'response'},
            function success(data) {
                /*if(data){
                    if(ticket.length == 0 || typeof ticket['comments'] == 'undefined'){
                        ticket['comments'] = [];
                    }
                    ticket['comments'].push(data);
                }*/
                defer.resolve(data);

            },

            function error(reponse) {
               defer.resolve(reponse.data);
            });

        return defer.promise;
    };

    /**
     * Call server to create branch
     * @param  {[object]} data branch info
     * @return {[promise]}      promise
     */
    this.reopen = function(data) {
        var defer = $q.defer();
        var temp = new TicketResource(data);
        temp.$save({id:data['id'], method:'reopen'},
            function success(data) {
                defer.resolve(data);
            },
            function error(reponse) {
               defer.resolve(reponse.data);
            });

        return defer.promise;
    };

    /**
     * ready for reviewed ticket
     * @param  object data [ticket]
     * @return promise    data
     */
    this.readyForReviewed = function(data) {
        var defer = $q.defer();
        var temp = new TicketResource(data);
        temp.$save({id:data['id'], method:'readyforreviewed'},
            function success(data) {
                defer.resolve(data);
            },
            function error(reponse) {
               defer.resolve(reponse.data);
            });

        return defer.promise;
    };

    /**
     * approved ticket
     * @param  object data [ticket]
     * @return promise      [data]
     */
    this.approved = function(data) {
        var defer = $q.defer();
        var temp = new TicketResource(data);
        temp.$save({id:data['id'], method:'approved'},
            function success(data) {
                defer.resolve(data);
            },
            function error(reponse) {
               defer.resolve(reponse.data);
            });

        return defer.promise;
    };

    /**
     * deploy ticket
     * @param  object data [ticket]
     * @return promise      data
     */
    this.deploy = function(data) {
        var defer = $q.defer();
        var temp = new TicketResource(data);
        temp.$save({id:data['id'], method:'close'},
            function success(data) {
                defer.resolve(data);
            },
            function error(reponse) {
               defer.resolve(reponse.data);
            });

        return defer.promise;
    };

    /**
     * Call server to create branch
     * @param  {[object]} data branch info
     * @return {[promise]}      promise
     */
    this.deny = function(data) {
        var defer = $q.defer();
        var temp = new TicketResource(data);
        temp.$save({id:data['id'], method:'deny'},
            function success(data) {
                defer.resolve(data);
            },
            function error(reponse) {
               defer.resolve(reponse.data);
            });

        return defer.promise;
    };
        /**
     * Call server to create branch
     * @param  {[object]} data branch info
     * @return {[promise]}      promise
     */
    this.getFiles = function(id) {
        var defer = $q.defer();
        TicketResource.get({id:id, method:'get-files'}, function(data) {
            // console.log(data,'data');
            defer.resolve(data);
        });
        return defer.promise;
    };
    /**
     * Call server to update branch
     * @param  {[object]} data branch info
     * @return {[promise]}      promise
     */
    this.update = function(data) {
        var defer = $q.defer();
        var temp = new TicketResource(data);
        temp.$update({id:data['id']},
            function success(data) {
               defer.resolve(data);
               type = data['type'];
            },
            function error(reponse) {
               defer.resolve(reponse.data);
            });

        return defer.promise;
    };

    /**
     * [get description]
     * @param  {[int]} id branch id
     * @return {[promise]}    promise
     */
     this.get = function(id) {
        var defer = $q.defer();
        TicketResource.get({id:id}, function(data) {
            currentItem = data;
            type = data['type'];
            decision = data['decision'];
            defer.resolve(data);
        });
        return defer.promise;
    };

    /**
     * get list items
     * @return {[promise]} promise contain list items
     */
    this.query = function() {

        var defer = $q.defer();
        if(items.length>0){
            defer.resolve(items);
        }
        if(items && items.length) {
            defer.resolve(items);
        } else {
            TicketResource.query().$promise
                .then(function(data) {
                    items = data;

                    defer.resolve(items);
                }
            );
        }

        return defer.promise;
    };


    /**
     * push items to service that controller or directive can use it (shared)
     * @param {[array]} data list items
     */
    this.setData = function(data){
        items = data;
        return items;
    };
    this.getData = function(){
        return items;
    };
    /**
     * remove branch
     * @param  {[int]} id branch id
     * @return {[promise]}    contain data that is response from server
     */
    this.remove = function(id) {
        var defer = $q.defer();
        TicketResource.delete({ id: id}, function(data) {
            if(data.status){
                for(var key in items){
                    if(items[key]['id'] == id){
                         items.splice(key, 1);
                         break;
                    }

                }
            }
            defer.resolve(data);
        });
         return defer.promise;
    };

    this.push = function(ticket){
        items.push(ticket);

    };

    /**
     * get all user corporate employee ticket
     * @param  int id [description]
     * @return defer
     */
    this.getUserAssign = function(id,assignId){
        var defer = $q.defer();
        TicketResource.query({id:id,method:'all-user-assign'}, function(data){
                defer.resolve(data);
            });
        return defer.promise;
    };
    /**
     * get type
     * @return types
     */

    this.getTypesOptions = function(){
        var result = {};
        angular.forEach(types, function(value, key) {
            return result[key] = value;
        });
        return result;
    };
    /**
     * get state
     * @return states
     */

    this.getStatesOptions = function(){
        var result = {};
        angular.forEach(states, function(value, key) {
            return result[key] = value;
        });
        return result;
    };

    this.getTicketsByState = function(state){
        if(!state) return [];
        return $filter('filter')(items, {status: state});
    };


    /**
     * add assign user corporate employee
     * @param object data
     * return {[promise]} promise contain list items
     */
    this.addAssign = function(data,assignId,userId) {
        var defer = $q.defer();
        var user_id = data['user_id'];
        var temp = new TicketResource(data);
        temp.$save({id:data['id'],method:'add-assign'},
            function success(data) {
                if(data.status){
                    var statusAssign = 1;
                    if(assignId != null){
                        for(var i = 0;i<invites.length;i++){
                            if(invites[i] == assignId){
                                statusAssign = 0;
                            }
                            if(invites[i] == user_id) {
                                invites.splice(i,1);
                                countFollowing--;

                            }
                        }
                        if(statusAssign == 1 && userId != assignId){
                            invites.push(assignId);
                            countFollowing += 1;
                        }
                    }
                }
                defer.resolve(data);
            },
            function error(reponse) {
               defer.resolve(reponse.data);
            });

        return defer.promise;
    };
    this.getCurrentItem = function(){
        return currentItem;
    };
    /**
     * [listUserInvitation description]
     * get list User from data of ticket detail
     * @param  {[type]} data [description]
     * @return {[type]}      [description]
     */

    this.getlistUserInvitation = function(){
        return usersInvitation;
    };
    /**
     * [listUserAssign description]
     * get list User from data of ticket detail
     * @param  {[type]} data [description]
     * @return {[type]}      [description]
     */
    this.getlistUserAssign = function(data){
       return usersAssign;
    };
    /**
     * send mail user ticket
     * @param object data
     * @param  string status
     */
    this.sendMail = function(data,status){
        var defer = $q.defer();
        var id = data['id'];
        var temp = new TicketResource(data);
        if(status == 'createTicket'){
            id = data.item['id'];
        }
        temp.$save({method:'send-mail',id:id,status:status}, function(data) {
            defer.resolve(data);
        });
        return defer.promise;
    };

    /**
     * get ticket of group
     * @param  string group [group's name]
     * @return {[type]}       [description]
     */
    this.getTicketGroup = function(group){
         var defer = $q.defer();
            TicketResource.query({method: 'get-group',status:group}).$promise
                .then(function(data) {
                    defer.resolve(data);
            });
        return defer.promise;
    };

    this.getConfig = function(){

        var defer = $q.defer();
        localStorage.removeItem('config');
        config = localStorage.getItem('config');
        if(config){
            config = JSON.parse(config);
            defer.resolve(config);
            }
        else{
            TicketResource.get({method: 'get-config'}, function(data) {
                localStorage.setItem('config', JSON.stringify(data));
                defer.resolve(data);
            });
         }
        return defer.promise;
    };

    /**
     * get number of each group
     * @return promise group
     */
    this.getNumberOfTickets = function(){
        var defer = $q.defer();
        TicketResource.query({method: 'get-number-of-ticket'}).$promise
            .then(function(data) {
                defer.resolve(data);
            });
        return defer.promise;
    };

    /**
     * get name group
     * @param  {[type]} ticketAdmin [description]
     * @param  {[type]} ticket      [description]
     * @return {[type]}             [description]
     */
    this.getGroupBaseOnCurrentItem = function(ticketAdmin,ticket){
        var currentItem = ticket;
        if(typeof currentItem != 'undefined'){
            if(currentItem.status != 'closed'){
                if(currentItem.invitations){
                    for(var key in currentItem.invitations ){
                        if(currentItem.invitations[key].user_id == window.userId){
                            return 'Following';
                        }
                    }
                }
            }
            if(currentItem.status == 'open'){
                if(currentItem.comments){
                    for(var key in currentItem.comments ){
                        if(currentItem.comments[key].ticket_state == 'response'){
                            return 'Responded';
                        }
                    }
                }
            }
            if(typeof ticketAdmin != 'undefined' && !ticketAdmin){
                    if(currentItem.status == 'answered'){
                        return 'Updated';
                    }
            }
            if(typeof ticketAdmin != 'undefined' && ticketAdmin){
                if(currentItem.status == 'answered'){
                    return 'Responded';
                }
            }
            if(currentItem.status == 'closed'){
                return 'Deployed';
            }
            if(currentItem.status == 'assigned'){
                return 'Assigned';
            }
            if(currentItem.status == 'reviewed'){
                return 'Ready For Review';
            }
            if(currentItem.status == 'approved'){
                return 'Approved';
            }

            if(currentItem.status == 'deploy'){
                return 'Closed';
            }
            return 'New';

        }
    };
    /**
     * is used for page list
     * @return {[type]} [description]
     */
    this.getGroupBaseOnState = function(state){
        switch(state){
            case 'all_open':
                return 'All Open';
            case 'new':
                return 'New';
            case 'assigned':
                return 'Assigned';
            case 'updated':
                return 'Updated';
            case 'following':
                return 'Following';
            case 'deployed':
                return 'Deployed';
            case 'closed':
                return 'Closed';
            case 'reviewed':
                return 'Ready For Review';
            case 'approved':
                return 'Approved';
            case 'assigned-to-me':
                return 'Assigned To Me';
            case 'opened-by-me':
                return 'Opened By Me';
        }
    };
    /**
     * function get User Of Ticket
     * @param  int id
     * @return list promise
     */
    this.getUsersOfTicket = function(id){
         var defer = $q.defer();
        TicketResource.query({id:id, method:'get-users-of-ticket'}, function(data) {
            defer.resolve(data);
        });
        return defer.promise;
    };
    /**
     * function set type
     * return current type
     */
    this.setType = function(){
        return type;
    };
    this.updateDecision = function(data){
        var defer = $q.defer();
        var temp = new TicketResource(data);
        temp.$update({id:data['id'],method:'update-decision'},
            function success(data) {
               defer.resolve(data);
               decision = data['decision'];
            },
            function error(reponse) {
               defer.resolve(reponse.data);
            });

        return defer.promise;
    };

    this.getListUserInvite = function(datas){
        var inviteIds = [];
        for(var key in datas){
            inviteIds.push(datas[key]['user_id']);
        }

        return inviteIds;
    };
    this.addFollowing = function(id){
        var defer = $q.defer();
        TicketResource.get({method:'add-following', id:id}, function(response){
            invites.push(window.userId);
            countFollowing += 1;
            defer.resolve(response);
        });

        return defer.promise;
    };
    this.unFollowing = function(id,userId){
        var defer = $q.defer();
        TicketResource.get({method:'un-following', id:id,idExpenseReport:userId}, function(response){
            for(var i = 0;i<invites.length;i++){
                if(invites[i] == userId){
                    invites.splice(i, 1);
                    break;
                }
            }
            countFollowing -= 1;
            defer.resolve(response);
        });

        return defer.promise;
    };
    this.countFollowing = function(id){
        var defer = $q.defer();
        TicketResource.get({method:'count-following', id:id}, function(response){
            countFollowing = response.count;
            defer.resolve(response);
        });
        return defer.promise;
    };
    this.getUsersOfTicketInvite = function(id){
        var defer = $q.defer();
        TicketResource.query({id:id, method:'get-users-of-ticket-invite'}, function(data) {
            defer.resolve(data);
        });
        return defer.promise;
    };

    //Get user has been invited of that ticket
    this.getUserInviteOfTicket = function(id){
        var defer = $q.defer();
        TicketResource.query({id:id, method:'get-users-invite-of-ticket'}, function(data) {
            invites = data;
            defer.resolve(data);
        });
        return defer.promise;
    };

    /**
     * add invite user corporate employee
     * @param object data
     * return {[promise]} promise contain list items
     */
    this.addInvite = function(data) {
        var defer = $q.defer();
        var temp = new TicketResource(data);
        temp.$save({id:data['id'],method:'add-intive'},
            function success(data) {
                if(data.status && data.userInvite){
                    invites.push(data.userInvite);
                    countFollowing += 1;
                }
                defer.resolve(data);

            },
            function error(reponse) {
               defer.resolve(reponse.data);
            });

        return defer.promise;
    };
    this.setUserInvite = function(){
        return invites;
    };
    this.setCountFollowing = function(){
        return countFollowing;
    };
    this.getAllOfUser = function(data) {
        var defer = $q.defer();
        TicketResource.query({created_at:data, method:'file-all'}, function(data) {
            for(var key in data){
                filesUser[data[key].id] = data[key];
            }
            defer.resolve(data);
        });
        return defer.promise;
    };

    this.getFilesOfUser = function(){
        return filesUser;
    };

    this.approveExtension = function(data) {
        var defer = $q.defer();
        var temp = new TicketResource(data);
        temp.$save({id:data['id'], method:'approve-extension'},
            function success(data) {
                defer.resolve(data);
            },
            function error(reponse) {
               defer.resolve(reponse.data);
            });

        return defer.promise;
    };

    this.getLinkViewDraft = function(ticketId) {
        var defer = $q.defer();
        var temp = new TicketResource(ticketId);
        temp.$get({id:ticketId, method:'get-link-view-draft'},
            function success(data) {
                defer.resolve(data);
            },
            function error(reponse) {
               defer.resolve(reponse.data);
            });

        return defer.promise;
    };

    /**
     * Delete ticket
     * 
     * @author Thanh Tuan <tuan@httsolution.com>
     * 
     * @param  {String} id Ticket id
     * 
     * @return {Void}    
     */
    this.deleteTicket = function (id) {
        var defer = $q.defer(); 
        var temp  = new TicketResource();
        temp.$get({id: id, method: 'delete-ticket'}, function success(data) {
            defer.resolve(data);
        },
        function error(reponse) {
            defer.resolve(reponse.data);
        });
        return defer.promise;  
    }

    /**
     * Delete ticket
     * 
     * @author Thanh Tuan <tuan@httsolution.com>
     * 
     * @param  {String} id List ticket ids
     * 
     * @return {Void}    
     */
    this.deleteListTickets = function (ticketIds) {
        var defer = $q.defer(); 
        var temp = new TicketResource(ticketIds);
        temp.$save({method: 'delete-list-tickets'}, function success(data) {
            defer.resolve(data);
        },
        function error(reponse) {
            defer.resolve(reponse.data);
        });
        return defer.promise; 
    }

    this.unAssign = function(ticketId) {
        var defer = $q.defer(); 
        var temp  = new TicketResource();
        temp.$get({id : ticketId, method : 'un-assign'}, function success(data) {
            defer.resolve(data);
        },
        function error(reponse) {
            defer.resolve(reponse.data);
        });
        return defer.promise;  
    }

    this.updateDueDateListTicket = function (listTicket, dueDate) {
        var defer = $q.defer(); 
        var data = {tickets:listTicket, due_date : dueDate};

        var temp  = new TicketResource(data);
        temp.$save({method : 'update-due-date-list-ticket'}, function success(data) {
            defer.resolve(data);
        },
        function error(reponse) {
            defer.resolve(reponse.data);
        });
        return defer.promise;  
    }

    this.assignListTicket = function(listTicket, assignId) {
        var defer = $q.defer(); 
        var data = {tickets:listTicket, assign_id : assignId};

        var temp  = new TicketResource(data);
        temp.$save({method : 'assign-list-ticket'}, function success(data) {
            defer.resolve(data);
        },
        function error(reponse) {
            defer.resolve(reponse.data);
        });
        return defer.promise;
    }

    this.queryTicket = function(currentState) {
        var defer = $q.defer(); 
        var data = {group:currentState, query : []};

        var temp  = new TicketResource(data);
        temp.$save({method : 'query-ticket'}, function success(data) {
            defer.resolve(data);
        },
        function error(reponse) {
            defer.resolve(reponse.data);
        });
        return defer.promise;
    }

    this.setSessionToFilter = function (filterParam) {
        var defer = $q.defer();

        var temp  = new TicketResource(filterParam);
        temp.$save({method : 'set-session-to-filter'}, function success(data) {
            defer.resolve(data);
        },
        function error(reponse) {
            defer.resolve(reponse.data);
        });
        return defer.promise;
    }

    this.returnSearchResult = function(filterDataParam){
        var defer = $q.defer();
        data = {filterDataParam : filterDataParam};
        var temp  = new TicketResource(data);
        temp.$save({method : 'return-search-result'}, function success(data) {
            defer.resolve(data);
        },
        function error(reponse) {
            defer.resolve(reponse.data);
        });
        return defer.promise;
    }
}])
