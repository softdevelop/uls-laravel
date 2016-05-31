var Dashboard = angular.module('uls');
Dashboard.controller ('dashboardController', ['$controller','$scope', '$modal','$filter','$timeout','ngTableParams','dashboardService','$compile', function ($controller,$scope, $modal,$filter,$timeout,ngTableParams,dashboardService, $compile) {
	$controller('BaseController', { $scope: $scope });

    $scope.callbackLoadUserFinish = function(){};

    angular.element('.st-container').removeClass('hidden');

    $scope.tickets_new = angular.copy(window.tickets_new);
    $scope.tickets_allopen = angular.copy(window.tickets_allopen);
    $scope.states = angular.copy(window.states);
    $scope.ticketTypes = angular.copy(window.ticketTypes);
    $scope.isShowTicketClosed = false;
    $scope.userDashboardViews = window.userDashboardViews;
    caculatorPercentTicketStatus();

    function caculatorPercent(value, total){
        return (value/total)*100;
    }

    /**
     * Caculator percent of type base status is show ticket closed?
     *
     * @author Quang<quang@httsolution.com>
     * 
     * @param  {object}  type     type
     * @param  {Boolean} isClosed is show closed?
     * 
     * @return {object}           type
     */
    function caculatorEachType(type, isClosed) {
        //if inlcude closed ticket
        if(isClosed) {
            type.percentNew = caculatorPercent(type.new, type.total_ticket);
            type.percentOpen = caculatorPercent(type.open, type.total_ticket);
            type.percentReviewed = caculatorPercent(type.reviewed, type.total_ticket);
            type.percentApproved = caculatorPercent(type.approved, type.total_ticket);
            type.percentClosed = 100 - (type.percentNew + type.percentOpen + type.percentReviewed + type.percentApproved);
            type.percent = type.all_percent;
        } else {
            type.percentNew = caculatorPercent(type.new, type.total_ticket - type.closed);
            type.percentOpen = caculatorPercent(type.open, type.total_ticket - type.closed);
            type.percentReviewed = caculatorPercent(type.reviewed, type.total_ticket - type.closed);
            type.percentApproved = 100 - (type.percentNew + type.percentOpen + type.percentReviewed);
            type.percent = type.total_percent;
        }        
        return type
    }

    /**
     * Caculator percent for each type
     *
     * @author Quang<quang@httsolution.com>
     * 
     * @return {object} object
     */
    function caculatorPercentTicketStatus () {
        //foreach type data
        angular.forEach($scope.ticketTypes, function(value,key) {
            //caculator percent type ticket
            caculatorEachType(value, $scope.isShowTicketClosed);
            //if type has child then caculator child ticket percent
            if(value.childs.length > 0) {
                angular.forEach(value.childs, function(child,keyChild) {
                    caculatorEachType(child, $scope.isShowTicketClosed);
                });
            }
        }); 
    }

    /**
     * Should show closed ticket?
     *
     * @author Quang<quang@httsolution.com>
     * 
     */
    $scope.showTicketClosed = function() {

        $scope.isShowTicketClosed = !$scope.isShowTicketClosed;
        caculatorPercentTicketStatus();
        
        var curSort = $scope.tableParamsTicketTypes.sorting();
        if(angular.isDefined(curSort.percent)) {
            $scope.tableParamsTicketTypes.sorting(curSort);

            var sort = curSort.percent == 'asc' ? '+' : '-';
            $scope.ticketTypes = formatOrderedDataTicket($scope.ticketTypes, sort);
            $scope.tableParamsTicketTypes.reload();
        }
    }

	$scope.isSearch= false;

    /**
     * filter closed ticket
     *
     * @author Quang<quang@httsolution.com>
     * 
     * @param  {[type]} item [description]
     */
    $scope.filterTicketClosed = function(item) {
        return item.status != 'closed';
    }

    $scope.filterTypeShow = function(item) {
        return $scope.typeAvalible.indexOf(item.id) != -1;
    }

    /**
     * Move down element
     *
     * @author Thanh Tuan <tuan@httsolution.com>
     * 
     * @param  {Event} $event Event
     * 
     * @return {Void}        
     */
    $scope.moveDown = function($event) {
        angular.element('#page-loading').css('display','block');
        // item contain a box that user want move down
        var item = $($event.currentTarget).closest('.panel-group');
        // itemSortable is a container of list box
        var itemSortable = $(item).closest('.ui-sortable');
        // items contain list boxes
        var items = itemSortable.children('.panel-group');
        // crntPos contain a  position of the current box
        var crntPos = items.index(item);
        // swap current data to new position
       if (crntPos >= items.length) {
            return;
       }
        // topMoveUp is value of the current position 
        var topMoveUp =  - (item.height() + 20);
        // topMoveDown is value of the previous position 
        var topMoveDown =  items.eq(crntPos-1).height() + 20;

        item.css({position: 'relative'}).animate({top:  topMoveDown}, 500, function(){
            item.css({position: 'static', 'top' : 'auto'});
        });
        items.eq(crntPos+1).css({position: 'relative'}).animate({top:  topMoveUp}, 500, function(){
            items.eq(crntPos+1).css({position: 'static', 'top' : 'auto'});

            ++$scope.userDashboardViews[crntPos].sort_order;
            --$scope.userDashboardViews[crntPos+1].sort_order;

            var oldValue = $scope.userDashboardViews.splice(crntPos, 1); 

            var oldIndex = crntPos;
            var newIndex = crntPos + 1;

            $scope.userDashboardViews.splice(crntPos + 1, 0, oldValue[0]);
            $scope.$apply();

            saveSort($scope.userDashboardViews);
        });
    };

    /**
     * Move up element
     *
     * @author Thanh Tuan <tuan@httsolution.com>
     * 
     * @param  {Event} $event Event
     * 
     * @return {Void}        
     */
    $scope.moveUp = function($event) {
        angular.element('#page-loading').css('display','block');
        // item contain a box that user want move down
        var item = $($event.currentTarget).closest('.panel-group');
        // itemSortable is a container of list box
        var itemSortable = $(item).closest('.ui-sortable');
        // items contain list boxes
        var items = itemSortable.children('.panel-group');
        // crntPos contain a  position of the current box
        var crntPos = items.index(item);
        // topMoveUp is value of the current position 
        var topMoveUp =  - (items.eq(crntPos-1).height() + 20);
        // topMoveDown is value of the previous position 
        var topMoveDown = + (item.height() + 20);

        item.css({position: 'relative'}).animate({top:  topMoveUp}, 500, function(){
            item.css({position: 'static', 'top' : 'auto'});
        });

        items.eq(crntPos-1).css({position: 'relative'}).animate({top:  topMoveDown}, 500, function(){
            items.eq(crntPos-1).css({position: 'static', 'top' : 'auto'});

            --$scope.userDashboardViews[crntPos].sort_order;
            ++$scope.userDashboardViews[crntPos-1].sort_order;

            var oldValue = $scope.userDashboardViews.splice(crntPos, 1); 

            var oldIndex = crntPos;
            var newIndex = crntPos - 1;

            $scope.userDashboardViews.splice(crntPos - 1, 0, oldValue[0]);
            $scope.$apply();

            saveSort($scope.userDashboardViews);
        }); 
    };
    $scope.setCollapse = function (item) {
      if(item.height == 0){
        item.height = 'auto';
      }else {
        item.height = 0;
      }
      angular.element('#page-loading').css('display','block');
      dashboardService.changeCollapse(item).then(function(data){
          if (data.status != 0) {
              for(var i in $scope.userDashboardViews) {
                  if($scope.userDashboardViews[i]['_id'] == item._id){
                    $scope.userDashboardViews[i]['height'] = item.height;
                  }
              }
          }
          angular.element('#page-loading').css('display','none');
      });    
    }

    /**
     * sort child ticket when sort by percent ticket type 
     *
     * @author Quang<quang@httsolution.com>
     * 
     * @param  {object} type  type
     * @param  {string} order order's type
     * 
     * @return {[type]}       [description]
     */
    formatSortChildTicket = function(type,order){
        if(type.childs.length) {
            if(order == '+') {
                type.childs = _.sortBy(type.childs, 'percent' );
            } else {
                type.childs = _.sortBy(type.childs, 'percent' ).reverse();
            }            
        }

        return type;
    }
    
    /**
     * format data ticket type when user order by percent ticket
     *
     * @author Quang<quang@httsolution.com>
     * 
     * @param  {object} data  data order
     * @param  {string} order order type
     * 
     * @return {object}       data after order
     */
    formatOrderedDataTicket = function(data,order) {
        var result = [];
        var arrTicketHasTotalPercentNull = [];

        angular.forEach(data, function(value,key){
            //when sort percent exception ticket closed
            if(!$scope.isShowTicketClosed) {
                //get total percent is null and type has not ticket
                if(value.total_percent === null) {
                    arrTicketHasTotalPercentNull.push(value);
                } else {
                    result.push(value);
                }
            } else {
                //get total percent include ticket
                if(value.all_percent === null) {
                    arrTicketHasTotalPercentNull.push(value);
                } else {
                    result.push(value);
                }
            }
            //format child type base on type sort
            value = formatSortChildTicket(value,order);
        });
        
        //sort types have not ticket (percent is null)
        arrTicketHasTotalPercentNull = _.sortBy(arrTicketHasTotalPercentNull, 'name' );

        //push type have percent end array when desc sort
        if(order == '-') {
            result = result.concat(arrTicketHasTotalPercentNull);
        } else if(order == '+') {
            result = arrTicketHasTotalPercentNull.concat(result);
        }
        return result;
    }    

	$scope.tableParamsNewTicket = new ngTableParams({
        page: 1,
        count: 10,
        sorting: {
            priority: 'asc'
        },
        filter: {
            url: ''
        }
    }, {
        total: $scope.tickets_new.length,
        getData: function ($defer, params) {
            var filteredData = params.filter() ? $filter('filter')($scope.tickets_new, params.filter()) : $scope.tickets_new;
            var orderedData = params.sorting() ? $filter('orderBy')(filteredData, params.orderBy()) : filteredData;
            params.total(filteredData.length);
            $defer.resolve(orderedData.slice((params.page() - 1) * params.count(), params.page() * params.count()));
        }
    });

    $scope.tableParamsTicketTypes = new ngTableParams({
        page: 1,
        count: $scope.ticketTypes.length,
        sorting: {
            name: 'asc'
        },
        filter: {
            
        }
    }, {
        // total: $scope.ticketTypes.length,
        counts: [], // hide page counts control
        total: 1,  // value less than count hide pagination
        getData: function ($defer, params) {
        	var filteredData = params.filter() ? $filter('filter')($scope.ticketTypes, params.filter()) : $scope.ticketTypes;
            
            var orderedData = params.sorting() ? $filter('orderBy')(filteredData, params.orderBy()) : filteredData;

            //if sort type is percent
            if(params.orderBy().indexOf('-percent') > -1) {
                orderedData = formatOrderedDataTicket(orderedData,'-');
            } else if(params.orderBy().indexOf('+percent') > -1){
                orderedData = formatOrderedDataTicket(orderedData,'+');
            }

            params.total(filteredData.length);
            $defer.resolve(orderedData.slice((params.page() - 1) * params.count(), params.page() * params.count()));
        }
    });

	$scope.tableParamsAllOpenTicket = new ngTableParams({
        page: 1,
        count: 10,
        sorting: {
            priority: 'asc'
        },
        filter: {
            url: ''
        }
    }, {
        total: $scope.tickets_allopen.length,
        getData: function ($defer, params) {
        	var filteredData = params.filter() ? $filter('filter')($scope.tickets_allopen, params.filter()) : $scope.tickets_allopen;
            var orderedData = params.sorting() ? $filter('orderBy')(filteredData, params.orderBy()) : filteredData;
            params.total(filteredData.length);
            $defer.resolve(orderedData.slice((params.page() - 1) * params.count(), params.page() * params.count()));
        }
    });

    var channel = RowboatPusher.subscribe('notification_ticket');
    channel.bind('Rowboat\\Notification\\Events\\Notifications\\Broadcast\\NotificationTicket', function(data){
      if (angular.isDefined(data)) {
          if(data.sender_id != window.userId){
            $scope.$apply(function(){
              getActionRequiredByMe();
            })
          }
        }
    });

    var channel = RowboatPusher.subscribe('ticket');
    channel.bind('Rowboat\\Ticket\\Events\\Ticket\\Broadcast\\TicketCreated', function(data){
      if (angular.isDefined(data)) {
          if(data.sender_id != window.userId){
            $scope.$apply(function(){
                getActionRequiredByMe();
            })
          }
        }
    });

    /*event create ticket*/
   var channel = RowboatPusher.subscribe('ticket');
      channel.bind('Rowboat\\Ticket\\Events\\Ticket\\Broadcast\\TicketFolowing', function(data){
        if (angular.isDefined(data)) {
          if(data.userId != window.userId){
            $scope.$apply(function(){
              getActionRequiredByMe();
            })
          }
        }
      });

    /*event asign*/
    var channel = RowboatPusher.subscribe('ticket');
      channel.bind('Rowboat\\Ticket\\Events\\Ticket\\Broadcast\\TicketAssigned', function(data){
        if (angular.isDefined(data)) {
          if(data.sender.id != window.userId){
            $scope.$apply(function(){
              getActionRequiredByMe();
            })
          }
        }
      });

    /*event invite*/
    var channel = RowboatPusher.subscribe('ticket');
      channel.bind('Rowboat\\Ticket\\Events\\Ticket\\Broadcast\\TicketInvite', function(data){
        if (angular.isDefined(data)) {
          if(data.sender.id != window.userId){
            $scope.$apply(function(){
              getActionRequiredByMe();
            })
          }
        }
      });

    var getActionRequiredByMe = function() {
        dashboardService.getActionRequiredByMe().then(function(data){
            $scope.tickets_new = data.tickets_new;
            $scope.tickets_allopen = data.tickets_allopen;
            $scope.states = data.states;
            $scope.tableParamsNewTicket.reload();
            $scope.tableParamsAllOpenTicket.reload();

        });
    }

    $scope.goToTaskManager = function(type,status,showClosed) {
      if(type.percent != null) {
        dashboardService.setSessionFilterTicketType(type.id,type.parent_id,status,showClosed).then(function(data){
          if(data.status) {
            window.open(window.baseUrl + '/support/state/all_open','');          
          }
        });        
      }
    }

    $scope.selectTypeToShowDashBoard = function() {
        var template = '/dashboard/select-type-to-show-dashboard?v=' + new Date().getTime();

        var modalInstance = $modal.open ({
            animation: true,
            templateUrl: window.baseUrl + template,
            controller: 'SelectTypeDashboard',
            size: null,
            resolve: {
            }
        });
        modalInstance.result.then(function (data) {
            if(data.parent_id == null) {
                $scope.ticketTypes.push(data);
            } else {
                angular.forEach($scope.ticketTypes, function(value,key){
                    if(value.id == data.parent_id) {
                        value.childs.push(data);
                    }
                });
            }
            caculatorPercentTicketStatus();
            $scope.tableParamsTicketTypes.reload();
        });
    }

    $scope.selectType = function(event,item) {        
        if(angular.isUndefined($scope.typeSelected)) {
            $scope.typeSelected = [];
        }

        if(event.target.checked == true) {
            if($scope.typeSelected.indexOf(item.id) == -1) {
                item.checked = true;
                $scope.typeSelected.push(item.id);

            }
        } else {
            var index = $scope.typeSelected.indexOf(item.id);
            if(index > -1) {
                item.checked = false;
                $scope.typeSelected.splice(index,1);
                
            }
        }
    }

    $scope.removeTypeOnDashBoard = function() {
        
        if(angular.isUndefined($scope.typeSelected) || $scope.typeSelected.length == 0) {
            alert('Select a type to remove.');
            return;
        }

        var conf = confirm("Do you want to remove type?");
        if(!conf){
            return;
        }

        dashboardService.removeTypeOnDashboard($scope.typeSelected).then(function(data){
            if(data.status) {
                $result = [];
                angular.forEach($scope.ticketTypes, function(value,key){
                    if($scope.typeSelected.indexOf(value.id) == -1 && value.parent_id == null) {
                        $childs = [];
                        _.find(value.childs, function(item){
                            if($scope.typeSelected.indexOf(item.id) == -1) {
                                $childs.push(item);
                            }
                        });
                        value.childs = $childs;
                        $result.push(value);
                    }
                });
                $scope.ticketTypes = $result;
            }
            caculatorPercentTicketStatus();
            $scope.typeSelected = [];
            $scope.tableParamsTicketTypes.reload();
        });
    }
    // sort table options multi
    $scope.sortableOptions = {
        axis: "y",
        handle: "a.my-handle-field",
        start: function(e, ui) {
            // creates a temporary attribute on the element with the old index
            $(this).attr('data-previndex', ui.item.index());
        },
        update: function(event, ui) { // callback 
        },
        stop: function(event, ui) { // callback stop event
            var oldIndex = $(this).attr('data-previndex');
            var newIndex = ui.item.index();
            saveSort($scope.userDashboardViews);
            
        }
    };

    var saveSort = function(arraySort) {
        
        dashboardService.saveSort(arraySort).then(function(data){
            if (data.status != 0) {
                angular.element('#page-loading').css('display','none');
            }
        });          
    }
}]);

Dashboard.controller ('SelectTypeDashboard', ['$scope', '$modalInstance','$filter','$timeout','ngTableParams','dashboardService','$compile', function ($scope, $modalInstance,$filter,$timeout,ngTableParams,dashboardService, $compile) {
    $scope.cancel = function(){
        $modalInstance.dismiss('cancel');
    };

    $scope.selectTypeShow = function(type) {
        $scope.errorType = false;
        $('#btnAddType').attr('disabled','disabled');

        if(angular.isDefined(type)) {
            dashboardService.selectTypeShow(type.id).then(function(data){
                if(data['status']) {
                    $modalInstance.close(data.type);
                }
            });      
        } else {
            $scope.errorType = true;
            $('#btnAddType').removeAttr('disabled');
        }
    }
}]);