var ticketModule = angular.module('ticket');

ticketModule.controller('TicketController', ['$scope', 'TicketService', '$filter', 'ngTableParams', '$controller','$modal', '$timeout',
    function($scope, TicketService, $filter, ngTableParams, $controller,$modal, $timeout) {
    $controller('BaseController', {
        $scope: $scope
    });

    $scope.filterTicketClosed = function(tickets) {
        var listExceptionClosed = [];
        angular.forEach(tickets, function(value,key) {
            if(value.status != 'closed') {
                listExceptionClosed.push(value);
            }
        });

        return listExceptionClosed;
    }

    // $scope.filterTicketClosed = function(item) {
    //     if($scope.currentState == 'all_open') {
    //         if($scope.showChild) {
    //             return true;
    //         } else {
    //             return item.status != 'closed';
    //         }
    //     }
    //     return true;
    // }

    angular.element('.wrapper').removeClass('hidden');
    $scope.isSearch = false;
    $scope.message = 'Hello!';
    $scope.baseUrl = baseUrl;
    dataInternalOld = [];
    $scope.userId = window.userId;
    $scope.types = window.types;
    $scope.states = window.states;
    $scope.prioritys = window.prioritys;
    $scope.showChild = true;
    $scope.usersSelected = angular.copy(window.usersSelected);
    // Save default value of ticket
    $scope.itemsDefault = angular.copy(window.items);

    // Contain ticket has base_id is null and child ticket
    $scope.parentAndChild = [];
    $scope.filterQueue = [];
    $scope.returnSearchResultParam = angular.copy(window.returnSearchResultParam);
    console.log($scope.returnSearchResultParam,'returnSearchResultParam');

    // Format ticket to show style is parent and child
    $scope.formatTicketToParentAndChild = function (items) {
        angular.forEach(items, function(value, key) {
            // First
            if($scope.currentState == 'deployed') {
                if(value.base_id == null) {
                    value.children = [];
                    // Find all child and push to array children of first
                    _.find(items, function(obj) {
                        if(obj.base_id == value.id) {
                            value.children.push(obj);
                        }
                    });
                    $scope.parentAndChild.push(value);
                }

            } else {
                if(value.base_id == null && value.status !='closed') {
                    value.children = [];
                    // Find all child and push to array children of first
                    _.find(items, function(obj) {
                        if(obj.base_id == value.id && $scope.currentState == 'all_open') {
                            value.children.push(obj);
                        } else if(obj.base_id == value.id && $scope.currentState != 'all_open' && obj.status !='closed'){
                            value.children.push(obj);
                        }
                    });
                    $scope.parentAndChild.push(value);
                }
            }

        });
    }

    // set height your ticket
    function size_your_ticket(){
        // set height for class your-ticket
        
        var winHeight = $(window).height();

        var set_Height_Your_Ticket = $('.your-ticket');
        var offset_Height_Your_Ticket = $('.your-ticket').offset();

        var top_offset_Height_Your_Ticket = offset_Height_Your_Ticket.top;
        

        var Height_Your_Ticket = winHeight - top_offset_Height_Your_Ticket;
        
        set_Height_Your_Ticket.attr('style', 'height: ' + Height_Your_Ticket + 'px!important' );
        // end height your-ticket


        // set height for class content your ticket
        var set_Height_Content_Your_Ticket = $('.your-ticket .content-your-ticket');

        var height_intput = $('.sidebar-block input').outerHeight();
        

        var height_title = $('.sidebar-block .head-your-ticket').outerHeight();
        

        var height = set_Height_Your_Ticket.outerHeight();
        

        var Height_Content_Your_Ticket = height - height_intput - height_title - 29;

        set_Height_Content_Your_Ticket.attr('style', 'height: ' + Height_Content_Your_Ticket + 'px!important' );
        // end
    };

    $(document).ready(size_your_ticket);
    $(window).resize(size_your_ticket);
    // end

    $scope.$watch(function() {
        return window.innerWidth;
    }, function(value) {
        if (value > 1200) {
            TicketService.query().then(function(data) {
                $scope.tickets = data;
            })
        }
    });

    var channelNotification = RowboatPusher.subscribe('notification_ticket');
    channelNotification.bind('Rowboat\\Notification\\Events\\Notifications\\Broadcast\\NotificationTicket', function(data) {
        if (angular.isDefined(data)) {
            if (data.sender_id != window.userId) {
                $scope.$apply(function() {
                    getTicketGroup();
                })
            }
        }
    });

    /*event create ticket*/
    var channel = RowboatPusher.subscribe('ticket');
    channel.bind('Rowboat\\Ticket\\Events\\Ticket\\Broadcast\\TicketCreated', function(data) {
        if (angular.isDefined(data)) {
            if (data.creator.id != window.userId) {
                $scope.$apply(function() {
                    getTicketGroup();
                })
            }
        }
    });

    /*event following*/
    channel.bind('Rowboat\\Ticket\\Events\\Ticket\\Broadcast\\TicketFolowing', function(data) {
        if (angular.isDefined(data)) {
            if (data.userId != window.userId) {
                $scope.$apply(function() {
                    getTicketGroup();
                })
            }
        }
    });

    /*event asign*/
    channel.bind('Rowboat\\Ticket\\Events\\Ticket\\Broadcast\\TicketAssigned', function(data) {
        if (angular.isDefined(data)) {
            if (data.sender.id != window.userId) {
                $scope.$apply(function() {
                    getTicketGroup();
                })
            }
        }
    });

    /*event invite*/
    channel.bind('Rowboat\\Ticket\\Events\\Ticket\\Broadcast\\TicketInvite', function(data) {
        if (angular.isDefined(data)) {
            if (data.sender.id != window.userId) {
                $scope.$apply(function() {
                    getTicketGroup();
                })
            }
        }
    });

    /*event invite*/
    channel.bind('Rowboat\\Ticket\\Events\\Ticket\\Broadcast\\BroadcastUpdateDueDateListTicket', function(data) {
        if (angular.isDefined(data)) {
            if (data.sender.id != window.userId) {
                $scope.$apply(function() {
                    getTicketGroup();
                })
            }
        }
    });

    /*event delete*/
    channel.bind('Rowboat\\Ticket\\Events\\Ticket\\Broadcast\\BroadcastDeleteListTickets', function(data) {
        if (angular.isDefined(data)) {
            if (data.sender.id != window.userId) {
                $scope.$apply(function() {
                    getTicketGroup();
                })
            }
        }
    });

    /*event edit name ticket*/
    channel.bind('Rowboat\\Ticket\\Events\\Ticket\\Broadcast\\BroadCastUpdateNameTicket', function(data) {
        if (angular.isDefined(data)) {
            $scope.$apply(function() {
                getTicketGroup();
            })
        }
    });

    $scope.callbackLoadUserFinish = function() {};

    var getTicketGroup = function() {
        TicketService.getTicketGroup($scope.currentState).then(function(data) {
            getNumberOfTickets();
            // $scope.items = data;
            // $scope.tableParams.reload();
            $scope.itemsDefault = data;
            $scope.parentAndChild = [];
            $scope.formatTicketToParentAndChild($scope.itemsDefault);

            if ($scope.showChild) {
                $scope.items = $scope.parentAndChild;
            } else {
                $scope.items = $scope.filterTicketClosed($scope.itemsDefault);
            }
            $scope.tableParams.reload();


        });
    };

    //Get number of each group ticket
    var getNumberOfTickets = function() {
        TicketService.getNumberOfTickets().then(function(dataNumber) {
            $scope.numberOfTickets = dataNumber;
        })
    };

    $scope.formatStructChildParentWhenFilter = function (items) {
        angular.forEach(items, function(value, key) {
            if(value.base_id == null) {
                value.children = [];
                // Find all child and push to array children of first
                _.find(items, function(obj) {
                    if(obj.base_id == value.id) {
                        value.children.push(obj);
                    }
                });
                $scope.parentAndChild.push(value);
            }
        });
    }

    // Table ticket
    var getCurrentTicketGroup = function() {
        getNumberOfTickets();
        if (typeof $scope.currentState != 'undefined') {

            $scope.groupName = TicketService.getGroupBaseOnState($scope.currentState);

            $scope.formatTicketToParentAndChild($scope.itemsDefault);

            if ($scope.groupName == 'Assigned To Me') {
                $scope.showChild = false;
                $scope.items = $scope.filterTicketClosed($scope.itemsDefault);
            } else {
                $scope.items = $scope.parentAndChild;
            }


            $scope.$watch('tableParams', function(newVal, oldVal){
                if (angular.isUndefined(newVal) || angular.isUndefined(oldVal)) return;

                //init filter for stats
                if(angular.isDefined(window.statusFilter) && window.statusFilter != '') {
                    var status = window.statusFilter;
                    $scope.tableParams.filter()['status'] = [];
                    $scope.tableParams.filter()['status'].push(status);
                    window.statusFilter = '';
                    $timeout(function(){
                        $('#filter-status').select2({
                            tag:true,
                            value:status
                        });
                    });
                }

                //init filter for type
                if(angular.isDefined(window.typeFilter) && window.typeFilter != '') {
                    $timeout(function(){
                        var type_id = window.typeFilter;
                        $scope.tableParams.filter()['type_id'] = [];
                        $scope.tableParams.filter()['type_id'].push(type_id);
                        $timeout(function(){
                            $('#filter-type_id').select2({
                                tag:true,
                                value:type_id
                            });
                        });
                    });
                }

                if(angular.isDefined(window.filterIncludeClosed) && window.filterIncludeClosed == true) {
                    $timeout(function(){
                        var param = ['all','closed'];
                        $scope.tableParams.filter()['status'] = param;
                        $timeout(function(){
                            $('#filter-status').select2({
                                tag:true,
                                value:param
                            });
                        });
                        $scope.showChild = false;
                    });
                }

                if(angular.isDefined(window.returnSearchResultParam) && window.returnSearchResultParam != null) {
                    $scope.returnPreviousSearch(window.returnSearchResultParam);
                }
            });

            $scope.tableParams = new ngTableParams({
                page: 1,
                count: 50,
                sorting: {
                    'id': 'desc'
                },
                filter: {
                    id:'',
                    percentSearch: '100',
                }
            }, {
                total: $scope.items.length,
                getData: function($defer, params) {
                    var filters = params.filter();

                    $scope.filterQueue = angular.copy({'filterData' :  params.filter(), 'showAllOrShowNested' : $scope.showChild, 'ticket_state' : $scope.currentState});
                    $scope.setSessionToFilter($scope.filterQueue);

                    if(angular.isDefined(window.shouldShowAllTicket) && window.shouldShowAllTicket) {
                        $scope.showChild = false;
                        window.shouldShowAllTicket = false;
                    }
                    

                    //if filter status closed
                    if(angular.isDefined(filters.status) && filters.status.indexOf('closed') != -1) {
                        if(!$scope.showChild) {
                            $scope.items = $scope.itemsDefault;
                        } else {
                            $scope.parentAndChild = [];
                            $scope.formatStructChildParentWhenFilter($scope.itemsDefault);
                            $scope.items = $scope.parentAndChild;
                        }
                    } else {
                        if($scope.currentState != 'deployed'){
                            $scope.items = $scope.filterTicketClosed($scope.itemsDefault);
                        } else {
                            $scope.items = $scope.itemsDefault;
                        }

                        if($scope.showChild) {
                            $scope.parentAndChild = [];
                            $scope.formatTicketToParentAndChild($scope.itemsDefault);
                            $scope.items = $scope.parentAndChild;
                        }
                    }

                    var orderedData = params.sorting() ? $filter('orderBy')($scope.items, params.orderBy()) : $scope.items;

                    var paramFilter = params.filter();
                    
                    orderedData = params.filter() ? $filter('filter')(orderedData, paramFilter, searchMultiple) : orderedData;

                    // window.returnSearch = false;

                    params.total(orderedData.length);

                    $defer.resolve(orderedData.slice((params.page() - 1) * params.count(), params.page() * params.count()));
                    
                    //remove loading page
                    $('#page-loading').css('display', 'none');

                    //show button return search result
                    // if($scope.filterQueue.length > 1) {
                    //     $('#return-search-result').removeAttr('disabled');                        
                    // }
                }
            });
        }
    };

    var searchMultiple = function(value, searchTerm) {
        if (value =='' || searchTerm == '') return value;

         if(value.toString().indexOf('%') !== -1) {
            var arr = value.split('%');
            var percent = parseInt(arr[0]);
            var searchTerm = parseInt(searchTerm);
        }

        if(typeof searchTerm == 'array') {
            angular.forEach(searchTerm, function(valueS,key){
                if(typeof valueS == 'string') {
                    valueS = valueS.toLowerCase();                    
                }
            });
        }

        if(typeof searchTerm == 'string') {
            searchTerm = searchTerm.toLowerCase();
        }

        if(angular.isArray(searchTerm)) {
            if(searchTerm.indexOf("all") !== -1) {
                return value;
            }
            return searchTerm.indexOf(value) !== -1;

        } else if(value.toString().toLowerCase().indexOf('%') === -1) {
            return value.toString().toLowerCase().indexOf(searchTerm) !== -1;

        } else if(value.toString().toLowerCase().indexOf('%') !== -1){
            return percent <= searchTerm;
        }
    }

    $scope.paramSearch = function(paramSearch,data) {
        var itemsSearch = [];
        angular.forEach( data, function(value, key){
            var checkNumber =true;

            if(angular.isDefined(paramSearch.type_id)){
                if(value.type_id != paramSearch.type_id){
                    checkNumber = false;
                }
            }

            if(angular.isDefined(paramSearch.assign_id)){
                if(paramSearch.assign_id !=''){
                    if(value.assign_id != paramSearch.assign_id){
                        checkNumber =false;
                    }
                }
            }

            if(checkNumber){
                itemsSearch.push(value);
            }
        });

        return itemsSearch;
    };
    //Click to get list of type
    $scope.clickable = function($event, id) {
        window.location = baseUrl + "/support/show/" + id;
    };

    /*Filter type ticket*/
    $scope.typeFilterSelect = function(column) {
        var _typeFilter = [];
        angular.forEach($scope.types, function(value, key) {
            _typeFilter.push({
                'id': value.id,
                'title': value.name
            });
        })
        _typeFilter.unshift({id:'all', title: 'All'});
        _typeFilter = _.sortBy(_typeFilter, 'title' );
        return _typeFilter;
    };

    /*Filter priority ticket*/
    $scope.priorityFilterSelect = function(column) {
        var _priorityFilter = [];
        angular.forEach($scope.prioritys, function(value, key) {
            _priorityFilter.push({
                'id': key,
                'title': value
            });
        });
        _priorityFilter.unshift({id:'all', title: 'All'});
        _priorityFilter = _.sortBy(_priorityFilter, 'title' );
        return _priorityFilter;
    };

    /*Filter priority ticket*/
    $scope.statusFilterSelect = function(column) {
        var _statusFilter = [];
        angular.forEach($scope.states, function(value, key) {
            _statusFilter.push({
                'id': key,
                'title': value
            });
        });
        _statusFilter.unshift({id:'all', title: 'All'});
        return _statusFilter;
    };

    /*Filter priority ticket*/
    $scope.assignFilterData = function(column) {
        var _assignData = [];
        angular.forEach($scope.usersSelected, function(value, key) {
            _assignData.push({
                'id': value.id,
                'title': value.name
            });
        });
        _assignData.unshift({id:'unassigned', title: 'Unassigned'});
        _assignData.unshift({id:'all', title: 'All'});
        // _assignData = _.sortBy(_assignData, function (i) { return i.title.toLowerCase(); });
        return _assignData;
    };

    /*get data ticket table paragram*/
    $scope.getTicketGroup = function() {
        getCurrentTicketGroup();
    };

    /**
     * Delete ticket
     *
     * @author Thanh Tuan <tuan@httsolution.com>
     *
     * @return Void
     */
    $scope.deleteTicket = function ($event, ticket) {
        $event.stopPropagation();
        var comfrm = confirm("Are you sure you want to delete this ticket?");
        var idTicket = ticket.id;
        if (comfrm == true) {
            // Call function to delete selected node
            TicketService.deleteTicket(ticket.id).then(function (data) {
                if (data.status == true) {
                    // window.returnSearch = true;
                    $scope.errorDeleted = false;
                    $scope.itemsTemp = [];
                    if($scope.currentState != 'deployed') {
                        if(ticket.base_id == null && ticket.status != 'closed') {
                            for (var key in $scope.itemsDefault) {
                                if (!(idTicket == $scope.itemsDefault[key].id || $scope.itemsDefault[key].base_id == idTicket)) {
                                    $scope.itemsTemp.push($scope.itemsDefault[key]);
                                }
                            }
                        } else {
                            for (var key in $scope.itemsDefault) {
                                if (!(ticket.id == $scope.itemsDefault[key].id)) {
                                    $scope.itemsTemp.push($scope.itemsDefault[key]);
                                }
                            }
                        }
                    } else {
                        if(ticket.base_id == null) {
                            for (var key in $scope.itemsDefault) {
                                if (!(idTicket == $scope.itemsDefault[key].id || $scope.itemsDefault[key].base_id == idTicket)) {
                                    $scope.itemsTemp.push($scope.itemsDefault[key]);
                                }
                            }
                        } else {
                            for (var key in $scope.itemsDefault) {
                                if (!(ticket.id == $scope.itemsDefault[key].id)) {
                                    $scope.itemsTemp.push($scope.itemsDefault[key]);
                                }
                            }
                        }
                    }
                    $scope.itemsDefault = $scope.itemsTemp;

                    // Contain ticket has base_id is null and child ticket
                    $scope.parentAndChild = [];

                    $scope.formatTicketToParentAndChild($scope.itemsDefault);

                    if ($scope.showChild) {
                        $scope.items = $scope.parentAndChild;
                    } else {
                        $scope.items = $scope.filterTicketClosed($scope.itemsDefault);
                    }

                    $scope.tableParams.reload();
                } else {

                    $scope.errorDeleted = true;
                }
            })
        }
    }

    /**
     * Should show or not show nested ticket
     *
     * @author Thanh Tuan <tuan@httsolution.com>
     *
     * @return {Void}
     */
    $scope.shouldShowChild = function () {
        // Set value
        $scope.showChild = !$scope.showChild;
        // If showChild then show nested ticket
        if ($scope.showChild) {
            $scope.items = $scope.parentAndChild;
        } else { // Show all ticket
            if($scope.currentState == 'deployed') {
                $scope.items = $scope.itemsDefault;
            } else {
                $scope.items = $scope.filterTicketClosed($scope.itemsDefault);                
            }
        }
        $('#checkbox').attr('checked', false);
        // Reload table
        $scope.tableParams.reload();
    }

    $scope.selectTicket = function($event, item) {
        angular.element('#select-menu-modal-assign-list').removeClass('active-navigation-container');

        if(typeof $scope.ticketSelected == 'undefined') {
            $scope.ticketSelected = [];
            $scope.listTicket = [];
        }

        if($event.target.checked == true) {
            if($scope.ticketSelected.indexOf(item.id) == -1) {
                item.checked = true;
                $scope.ticketSelected.push(item.id);
                $scope.listTicket.push(item);
            }
        } else {
            var index = $scope.ticketSelected.indexOf(item.id);
            if(index > -1) {
                item.checked = false;
                $scope.ticketSelected.splice(index,1);
                $scope.listTicket.splice(index,1);
            }
        }
    }

    /**
     * Delete list tickets
     *
     * @author Thanh Tuan <tuan@httsolution.com>
     *
     * @param  {Array} ticketSelected List ids of ticket
     *
     * @return {Void}
     */
    $scope.deleteListTickets = function(ticketSelected) {
        // If user not selected ticket
        if (angular.isUndefined(ticketSelected) || ticketSelected.length <= 0) {
            alert('Please select one or more tickets to perform this action.');
            return;
        } else {
            var comfrm = confirm("Are you sure you want to delete tickets?");
            if (!comfrm) return;
        }

        TicketService.deleteListTickets(ticketSelected).then(function (data) {
            if(data.status == true) {
                // window.returnSearch = true;
                angular.forEach(ticketSelected, function(value, key) {
                    // Delete ticket and child
                    $scope.deleteParentAndChilds(value);
                });

                //Contain ticket has base_id is null and child ticket
                $scope.parentAndChild = [];

                // Format ticket to show nested ticket
                $scope.formatTicketToParentAndChild($scope.itemsDefault);

                // If showChild == true then show nested ticket
                if ($scope.showChild) {
                    $scope.items = $scope.parentAndChild;
                } else { // Show all ticket
                    $scope.items = $scope.filterTicketClosed($scope.itemsDefault);
                }

                $scope.tableParams.reload();
                $scope.ticketSelected = [];
                $scope.listTicket = [];
                $scope.errorDeleted = false;
                
            } else {
                $scope.errorDeleted = true;
            }
        })
    }

    /**
     * Recursive delete ticket and child
     *
     * @author Thanh Tuan <tuan@httsolution.com>
     *
     * @param  {Int} id Ticket id
     *
     * @return {Void}
     */
    $scope.deleteParentAndChilds = function (id) {
        // Find ticket with id
        var ticket = _.find($scope.itemsDefault, function(obj) { if(obj.id == id) return obj; });
        // If undefined tiket then return
        if (angular.isUndefined(ticket)) return;
        // Contain ticket childs
        var ticketChilds = [];
        // Find childs of ticket and push to array ticketChilds
        _.find($scope.itemsDefault, function(obj) { if(obj.base_id == ticket.id) { ticketChilds.push(obj) } });
        // If ticket has childs
        if (ticketChilds.length > 0) {
            // Each ticket child
            angular.forEach(ticketChilds, function(value, key) {
                // Contain childs of ticket child
                var subTickets = [];
                // Find childs of ticket child and push to array subtickets
                _.find($scope.itemsDefault, function(obj) { if(obj.base_id == value.id) { subTickets.push(obj) } });
                // If ticket child has childs then call function delete ticket and child
                if (subTickets.length > 0) {
                    $scope.deleteParentAndChilds(value.id);
                }
                // Delete child ticket
                angular.forEach($scope.itemsDefault, function(item, i) {
                    if (value.id == item.id) {
                        $scope.itemsDefault.splice(i, 1);
                    }
                })
            })
        }
        // Delete ticket
        angular.forEach($scope.itemsDefault, function(itm, j) {
            if (itm.id == ticket.id) {
                $scope.itemsDefault.splice(j, 1);
            }
        })
    }

    /**
     * update Due date for list ticket
     * @param  {[type]} ticketSelected [description]
     * @return {[type]}               [description]
     */
    $scope.updateDueDateListTicket = function (ticketSelected) {

        if(typeof ticketSelected == 'undefined' || ticketSelected.length <= 0) {
            alert('Please select one or more tickets to perform this action.');
        } else {
            $scope.getModalRequestExtentionListTicket(ticketSelected);

        }
    }

    $scope.getModalRequestExtentionListTicket = function (ticketSelected) {

        var template = '/support/update-request-extention/';

        var modalInstance = $modal.open ({
            animation: true,
            templateUrl: window.baseUrl + template,
            controller: 'ModalUpdateDueDateListTicket',
            size: null,
            resolve: {
                ticketSelected : function() {
                return ticketSelected;
                }
            }
        });
        modalInstance.result.then(function (data) {
            for(i in $scope.itemsDefault) {

                if(data['tickets'].indexOf($scope.itemsDefault[i]['id']) > -1) {

                    $scope.itemsDefault[i]['dueDate'] = data['due_date'];
                    $scope.itemsDefault[i]['due_date'] = data['due_date'];

                }
            }
            $scope.parentAndChild = [];
            $scope.formatTicketToParentAndChild($scope.itemsDefault);

            if ($scope.showChild) {
                $scope.items = $scope.parentAndChild;
            } else {
                $scope.items = $scope.filterTicketClosed($scope.itemsDefault);
            }

            // Uncheck all ticket selected
            angular.forEach($scope.ticketSelected, function(value, key) {
                $('#checkbox-' + value).attr('checked', false);
            })

            // Set scope ticket selected is null
            $scope.ticketSelected = [];
            $scope.listTicket = [];
            // window.returnSearch = true;
            $scope.tableParams.reload();
        });
    }

    $scope.assignPeopleList = function(assignId) {
        $('#re-assign').attr('disabled','disabled');

        TicketService.assignListTicket($scope.ticketSelected, assignId).then(function(data){            
            angular.forEach($scope.itemsDefault, function(value,key){
                if($scope.ticketSelected.indexOf(value.id) > -1) {
                    value.status = 'assigned';
                    value.assign_id = assignId;
                }
            });

            $scope.parentAndChild = [];
            $scope.formatTicketToParentAndChild($scope.itemsDefault);

            if ($scope.showChild) {
                $scope.items = $scope.parentAndChild;
            } else {
                $scope.items = $scope.filterTicketClosed($scope.itemsDefault);
            }

            // Uncheck all ticket selected
            angular.forEach($scope.ticketSelected, function(value, key) {
                $('#checkbox-' + value).attr('checked', false);
            })

            // Set scope ticket selected is null
            $scope.ticketSelected = [];
            $scope.listTicket = [];
            // window.returnSearch = true;

            $scope.tableParams.reload();

            $('.mini-show').removeClass('div-mini-show');
            $('#re-assign').removeAttr('disabled');
        });
    }

    $scope.initSelect2 = function(element) {
        $('#'+element).select2({
            tag:true
        })
    }

    /**
     * return previous search result
     *
     * @author Quang<quang@httsolution.com>
     * 
     */
    $scope.returnPreviousSearch = function(filterParams) {
        $scope.showChild = filterParams.showAllOrShowNested;

        $scope.filterWithData(filterParams.filterData);
    }

    /**
     * re-filter for ticket
     *
     * @author Quang<quang@httsolution.com>
     * 
     * @param  {object} data filter params
     * 
     */
    $scope.filterWithData = function(data) {
        var arrElement = ['assign_id','type_id','status','priority'];
        var arr = [];
        
        //delete filter old value
        angular.forEach(data, function(value,key) {
            if(typeof value == 'object' || typeof value == 'array') {
                arr.push(key);
            }
        });
        minus = _.difference(arrElement, arr);
        $scope.resetFilter(minus);

        //filter for current filter param
        angular.forEach(data, function(value,key) {
            //set value for select2
            if(typeof value == 'object') {
                $timeout(function(){
                    $('#filter-'+key).select2({
                        tag:true,
                        value:value
                    });
                });
            }
            //set value to ng-table filter
            $scope.tableParams.filter()[key] = value;            
        });
    }

    /**
     * reset value filter param
     * 
     * @param  {array} arrElement filter params is not filter
     * 
     */
    $scope.resetFilter = function(arrElement){
        angular.forEach(arrElement, function(value,key) {
            $timeout(function(){
                $('#filter-'+value).select2('val','');
            });
            $scope.tableParams.filter()[value] = [''];
        });
        $scope.tableParams.filter()['percentSearch'] = 100;
        // $('#percent-search').val(100);

        $scope.tableParams.filter()['title'] = '';
        $scope.tableParams.filter()['id'] = '';
        $scope.tableParams.filter()['create'] = '';
        $scope.tableParams.filter()['dueDate'] = '';
    }

    $scope.filtering = function() {
        // $('#page-loading').css('display', 'block');
    }

    $scope.setSessionToFilter = function(filterParam) {
        TicketService.setSessionToFilter(filterParam).then(function(){
        });
    }

}]);

ticketModule.controller('ModalUpdateDueDateListTicket', ['$scope', '$modalInstance','$filter','ticketSelected','TicketService', function ($scope, $modalInstance,$filter,ticketSelected,TicketService) {


    $scope.minDate = $scope.myDate = $filter('date')(new Date(), 'MM-dd-yyyy');

    $scope.myTime = new Date($scope.myDate).setHours(17);
    $scope.myTime = new Date($scope.myTime).setMinutes(0);
    $scope.myTime = new Date($scope.myTime).setSeconds(0);
    $scope.myTime = new Date($scope.myTime).setMilliseconds(0);

    $scope.ticketSelected = ticketSelected;

    $scope.open = function ($event) {
      $scope.opened = true;
    }
    $scope.changeDateTime = function(){
      $scope.errorDateTime = false;
    }

    $scope.updateDueDate = function (ticketSelected) {

        $('#btnRequestExtension').attr('disabled','disabled');

        if(typeof $scope.myDate == 'undefined' || typeof $scope.myTime == 'undefined'|| $scope.myTime ==null|| $scope.myDate ==null) {
            $scope.errorDateTime = true;
            $('#btnRequestExtension').removeAttr('disabled');
            return;
        }

        $scope.dueDate = new Date($scope.myDate);

        var stringTime = $filter('date')($scope.myTime, 'HH:mm:ss');
        var arrayTime = stringTime.split(":");

        $scope.dueDate.setHours(arrayTime[0]);
        $scope.dueDate.setMinutes(arrayTime[1]);
        $scope.dueDate.setSeconds(arrayTime[2]);

        TicketService.updateDueDateListTicket($scope.ticketSelected,$scope.dueDate).then(function(data){
            if(data.status) {
                $modalInstance.close(data);
            }
            $('#btnRequestExtension').removeAttr('disabled');
        });
    }

    $scope.cancel = function(){
      $modalInstance.dismiss('cancel');
    };

}]);
