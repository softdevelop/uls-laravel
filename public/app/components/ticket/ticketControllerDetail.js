var userModule = angular.module('ticket', ['ngSanitize']);

userModule.controller('TicketController', ['$scope','TicketService', '$modal', 'UserService','$timeout','FileService', '$controller', 'Upload', '$compile','$q', function($scope, TicketService, $modal, UserService, $timeout, FileService, $controller, Upload, $compile,$q) {
  $controller('BaseController', { $scope: $scope });
  angular.element('.wrapper').removeClass('hidden');
  $scope.baseUrl = baseUrl;
  $scope.focusinControl = {};
  
  /* Declare to contain child tickets of current ticket show */
  $scope.childTickets = angular.copy(window.childTickets);
  $scope.ticketChild =[];

  /* If ticket has child then show table child tickets */
  $scope.arrNull = [];
  if (!angular.equals($scope.childTickets, $scope.arrNull)) {
    angular.element('.wrap-children-ticket').removeClass('hidden');
  }

  $scope.showSubSelect = function (event) {
    event.preventDefault();
    $(event.currentTarget).addClass('fa-plus');
    $(event.currentTarget).toggleClass('fa-minus');
}

  /*init redactor editor*/
  function initRedactor()
  {
    $('#content').redactor({
      imageUpload: window.baseUrl+'/file-redactor/upload-file-redactor',
      plugins: ['table', window.isAdvancedEditingFeatures == true ? 'source' : ''],
      linebreaks:['<br>'],
      callbacks: {
          modalOpened: function(name, modal) {
              if(name == 'link' && !this.observe.isCurrent('a')) {
                  $('#redactor-link-blank').attr("checked","true");
                  $('<label><input type="checkbox" checked id="redactor-link-no-follow"> No Follow</label>').insertAfter($('#redactor-link-blank').parent());
              } else if(name == 'link') {
                var rel = this.link.$node.attr('rel');
                if(typeof rel == 'undefined') {
                  $('<label><input type="checkbox" id="redactor-link-no-follow"> No Follow</label>').insertAfter($('#redactor-link-blank').parent());
                } else {
                  $('<label><input type="checkbox" checked id="redactor-link-no-follow"> No Follow</label>').insertAfter($('#redactor-link-blank').parent());
                }
              }
          },
          insertedLink: function(element) {
            var href = $(element).attr('href');
            if(href.substring(0, 4) != 'http' && href.substring(0,5) != 'https' && href.substring(0,3) != 'ftp') {
              $(element).attr('href','http://' + href);
            }
            if($('#redactor-link-no-follow').prop('checked')) {
              element.attr('rel', 'nofollow');
            } else {
              element.removeAttr('rel');
            }
          },
          linkify: function(elements) {
            elements.attr("target","_blank");
          },
          change: function() {
              $content = $('#content').redactor('code.get');

              $scope.$apply(function(){
                if($content == '<div></div>' || $content == ''|| $content == '<br>'|| $content == '<div><strong></strong></div>'|| $content == '<div><em></em><strong></strong></div>'|| $content == '<div><em><del></del></em></div>') {
                    $scope.validate = false;
                } else {
                    $scope.validate = true;
                }
              });
          }
      },
      linkSize: 1000
    });
  }

  // set height your ticket
  function size_your_ticket(){
  
        var winHeight = $(window).height();
        console.log(winHeight);

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
        

        var Height_Content_Your_Ticket = height - height_intput - height_title -29;

        set_Height_Content_Your_Ticket.attr('style', 'height: ' + Height_Content_Your_Ticket + 'px!important' );
        // end
  };

  $(document).ready(size_your_ticket);
  $(window).resize(size_your_ticket);
  // end

   /*init redactor editor*/
  function initRedactorChild()
  {
    $('#content-child').redactor({
      imageUpload: window.baseUrl+'/file-redactor/upload-file-redactor',
      plugins: ['table', window.isAdvancedEditingFeatures == true ? 'source' : ''],
      linebreaks:['<br>'],
      callbacks: {
          modalOpened: function(name, modal) {
              if(name == 'link' && !this.observe.isCurrent('a')) {
                  $('#redactor-link-blank').attr("checked","true");
                  $('<label><input type="checkbox" checked id="redactor-link-no-follow"> No Follow</label>').insertAfter($('#redactor-link-blank').parent());
              } else if(name == 'link') {
                var rel = this.link.$node.attr('rel');
                if(typeof rel == 'undefined') {
                  $('<label><input type="checkbox" id="redactor-link-no-follow"> No Follow</label>').insertAfter($('#redactor-link-blank').parent());
                } else {
                  $('<label><input type="checkbox" checked id="redactor-link-no-follow"> No Follow</label>').insertAfter($('#redactor-link-blank').parent());
                }
              }
          },
          insertedLink: function(element) {
            var href = $(element).attr('href');
            if(href.substring(0, 4) != 'http' && href.substring(0,5) != 'https' && href.substring(0,3) != 'ftp') {
              $(element).attr('href','http://' + href);
            }
            if($('#redactor-link-no-follow').prop('checked')) {
              element.attr('rel', 'nofollow');
            } else {
              element.removeAttr('rel');
            }
          },
          linkify: function(elements) {
            elements.attr("target","_blank");
          },
          change: function() {
              $content = $('#content-child').redactor('code.get');

              $scope.$apply(function(){
                if($content == '<div></div>' || $content == ''|| $content == '<br>'|| $content == '<div><strong></strong></div>'|| $content == '<div><em></em><strong></strong></div>'|| $content == '<div><em><del></del></em></div>') {
                    $scope.validateChild = false;
                } else {
                    $scope.validateChild = true;
                }
              });
          }
      },
      linkSize: 1000
    });
  }
  $scope.getChildRedactor =function(){
    initRedactorChild();
    $timeout(function(){
      $('#content-child').redactor('code.set','');
      $('.redactor-box .redactor-editor').addClass('redactor-placeholder');
    });

    $scope.filesUploadChild.finished = true;
    $scope.submitted = false;
    $scope.isShowAction = false;
  }

  dataInternalOld = [];
  $scope.userId = window.userId;
  $scope.limitStep = 2;
  $scope.numberLimit = $scope.limitStep;
  $scope.hideLoadMore = true;
  $scope.hideReOpenBtn = true;
  $scope.totalComments = 0;
  $scope.isSubmit = false;

  $scope.ticketAdmin = window.isAdmin;
  $scope.isSysAdmin = window.isSysAdmin;
  $scope.ticket  = window.ticket;
  $scope.ticketChild.title = $scope.ticket.title;
  $scope.lastUpdated = $scope.ticket.lastUpdated;

  $scope.types = window.types;
  $scope.listPriorities = window.listPriorities;
  $scope.isShowAction = true;
  $scope.checkAssign = true;
  $scope.displaySelect = false;
  $scope.hideDueDate = window.hideDueDate;
  $scope.filterDataParam = angular.copy(window.filterDataParam);
  console.log($scope.filterDataParam,'filterDataParam');
  
  $scope.minDate = $scope.minDate ? null : new Date();

  $scope.datePicker = {opened:false};
  $scope.open = function ($event) {
    $event.preventDefault();
    $event.stopPropagation();
    $scope.datePicker.opened = true;
  }

  $scope.updateTitleChild = function()
  {
    if(angular.isUndefined($scope.ticketChild.title)||!$scope.ticketChild.title.length){
      $scope.ticketChild.title = $scope.ticket.title;
    }
  }
  // $scope.ticket.created_at = new Date($scope.ticket.created_at);

  $scope.overdue = false;

  $scope.isTime = window.isTime;

  $scope.finishCountDown = function()
  {
    $timeout(function(){
      $scope.$apply(function(){

        $scope.overdue = true;
      });
    });
  }

   $scope.$watch(function()
   {
     return window.innerWidth;
      }, function(value) {
      if(value > 1200){
          TicketService.query().then(function(data){
                  $scope.tickets = data;
          })
      }
    });
    var channel = RowboatPusher.subscribe('notification_ticket');
    channel.bind('Rowboat\\Notification\\Events\\Notifications\\Broadcast\\NotificationTicket', function(data){
      if (angular.isDefined(data)) {
          if(data.sender_id != window.userId){
            $scope.$apply(function(){
              getAmountOfEachTypeTicket();
            })
          }
        }
    });
    /*event Unfollowing*/
    var channel = RowboatPusher.subscribe('ticket');
      channel.bind('Rowboat\\Ticket\\Events\\Ticket\\Broadcast\\TicketFolowing', function(data){
        if (angular.isDefined(data)) {
          if(data.userId != window.userId){
            $scope.$apply(function(){
                //get infomation of ticket
                getAmountOfEachTypeTicket();

                //get users invited of ticket
                getUserInviteOfTicket().then(function(){
                  $checkInInvite = $scope.invites.indexOf(window.userId);
                  if($checkInInvite < 0 && !$scope.ticketAdmin && !($scope.isSysAdmin && $scope.ticket.status == 'approved') && window.userId != $scope.ticket.user_id && window.userId != $scope.ticket.assign_id) {
                    window.location.href=window.baseUrl + '/support';
                  }
                });
                getCountUserInvite();
                //Get users to select invite
                getUsersOfTicketInvite();
            })
          }
        }
      });

    /*event asign*/
      channel.bind('Rowboat\\Ticket\\Events\\Ticket\\Broadcast\\TicketAssigned', function(data){
        if (angular.isDefined(data)) {
          if(data.sender.id != window.userId){
            $scope.$apply(function(){
                $scope.checkAssign = true;
                //get infomation of ticket
                getAmountOfEachTypeTicket();
                //get users invited of ticket
                getUserInviteOfTicket();
                getCountUserInvite();
                //Get users to select invite
                getUsersOfTicketInvite();
            });
          }
        }
      });

    /*event invite*/
      channel.bind('Rowboat\\Ticket\\Events\\Ticket\\Broadcast\\TicketInvite', function(data){
        if (angular.isDefined(data)) {
          if(data.sender.id != window.userId){
            $scope.$apply(function(){
                //get infomation of ticket
                getAmountOfEachTypeTicket();
                //get users invited of ticket
                getUserInviteOfTicket();
                getCountUserInvite();
                //Get users to select invite
                getUsersOfTicketInvite();
            })
          }
        }
      });

      /*event invite*/
      channel.bind('Rowboat\\Ticket\\Events\\Ticket\\Broadcast\\BroadCastUpdateNameTicket', function(data){
        if (angular.isDefined(data)) {
          $scope.$apply(function(){
            getAmountOfEachTypeTicket();
          });
        }
      });

    /*event response ticket*/
    var channel2 = RowboatPusher.subscribe('ticket_'+$scope.ticket.id);
    channel2.bind('Rowboat\\Ticket\\Events\\Ticket\\Broadcast\\TicketResponse', function(data){
      if(data.sender.id != window.userId){
        if (angular.isDefined(data.comment)) {
          $scope.$apply(function(){
            //push comment real time
            commentReadTime(data.comment);
          });
        }
      }
    });

    /*event private ticket*/
    channel2.bind('Rowboat\\Ticket\\Events\\Ticket\\Broadcast\\TicketPrivate', function(data){
      if(data.sender.id != window.userId){
        if (angular.isDefined(data.comment)) {
          $scope.$apply(function(){
            //push comment real time
            commentReadTime(data.comment);
          });
        }
      }

    });

    /*Event ready for review ticket*/
    channel2.bind('Rowboat\\Ticket\\Events\\Ticket\\Broadcast\\TicketReadyForReviewed', function(data){
      // if(data.sender.id != window.userId){
        if (angular.isDefined(data)) {
          $scope.ticket.status = 'reviewed';
          // $scope.$broadcast('timer-resume');
          $scope.showBoxComment = true;
          $scope.hideReOpenBtn = true;
          $scope.hideCloseBtn = true;
          //get infomation of ticket
          getAmountOfEachTypeTicket();
        }
      // }
    });

    /*Event approved ticket*/
    channel2.bind('Rowboat\\Ticket\\Events\\Ticket\\Broadcast\\TicketApproved', function(data){
      // if(data.sender.id != window.userId){
        if (angular.isDefined(data)) {
          $scope.ticket.status = 'approved';
          // $scope.$broadcast('timer-resume');
          $scope.showBoxComment = true;
          $scope.hideReOpenBtn = true;
          $scope.hideCloseBtn = true;
          //get infomation of ticket
          getAmountOfEachTypeTicket();
        }
      // }
    });

    /*Event deny ticket*/
    channel2.bind('Rowboat\\Ticket\\Events\\Ticket\\Broadcast\\TicketDeny', function(data){
        if(data.sender.id != window.userId){
          if (angular.isDefined(data)) {
            $scope.ticket.status = 'assigned';
            // $scope.$broadcast('timer-resume');
            $scope.showBoxComment = true;
            $scope.hideReOpenBtn = true;
            $scope.hideCloseBtn = true;
            //get infomation of ticket
            getAmountOfEachTypeTicket();
          }
        }
    });

    /*event Deploy ticket*/
    channel2.bind('Rowboat\\Ticket\\Events\\Ticket\\Broadcast\\TicketClosed', function(data){
        if(data.sender.id != window.userId){
          if (angular.isDefined(data.comment)) {
              commentReadTime(data.comment);
              $scope.ticket.status = 'closed';
              $scope.showBoxComment = true;
              $scope.hideReOpenBtn = false;
              $scope.hideCloseBtn = true;
              $scope.$broadcast('timer-stop');
              //get infomation of ticket
              getAmountOfEachTypeTicket();
          }
        }
    });

    /*Event when remove assign*/
    channel2.bind('Rowboat\\Ticket\\Events\\Ticket\\Broadcast\\BroadcastUnAssign', function(data){
        if (angular.isDefined(data)) {
          if(data.sender.id != window.userId) {
            
            $scope.ticket.status = 'new';
            
            if (angular.isDefined(data.comment)) {
              $scope.$apply(function(){
                //push comment real time
                commentReadTime(data.comment);
              });
            }

            getAmountOfEachTypeTicket();
          }
          
        }
      // }
    });

    // $scope.showBtnDes = false;
    // $scope.showDescription = function () {
    //   $scope.showBtnDes = !$scope.showBtnDes;
    // }

  $scope.callbackLoadUserFinish = function(){

  };

  var channelCreateChildTicket = RowboatPusher.subscribe('create_child_ticket_' + $scope.ticket.id);
  channelCreateChildTicket.bind('Rowboat\\Ticket\\Events\\Ticket\\Broadcast\\BroadCastCreateChildTicket', function(data){
    console.log('1');
    if (angular.isDefined(data)) {
        if(data.sender.id != window.userId){
          $scope.$apply(function(){
            getAmountOfEachTypeTicket();
          })
        }
      }
  });
    if (angular.isDefined($scope.ticket.base_id)) {
        var parentTicketDetail = RowboatPusher.subscribe('parent_ticket_detail' + $scope.ticket.base_id);
        parentTicketDetail.bind('Rowboat\\Ticket\\Events\\Ticket\\Broadcast\\BroadCastCreateChildTicket', function(data){
            console.log('2');
            if (angular.isDefined(data)) {
                if(data.sender.id != window.userId){
                    console.log('quang');
                    $scope.$apply(function(){
                        getAmountOfEachTypeTicket();
                    })
                }
            }
        });   
    }

  // Model view image
  $scope.viewModel = function(id){
      var modalInstance = $modal.open({
        templateUrl: baseUrl+'/app/components/ticket/views/modal/viewPicture.html',
        controller: 'ModalViewPictureCtrl',
        size: undefined,
        windowClass: 'show-img',
        resolve: {
          fileId: function () {
            return id;
          }
        }
      });
      modalInstance.result.then(function (selectedItem) {
      }, function () {
    });
  };

  //Check file type
  $scope.checkFile = function(type){
    return FileService.checkFile(type);
  };

  //get number ticket of each status ticket
  var getNumberOfTickets = function(){
      TicketService.getNumberOfTickets().then(function(dataNumber){
      $scope.numberOfTickets = dataNumber;
    })
  };

  //Get ticket
  var getAmountOfEachTypeTicket = function(){

      getNumberOfTickets();

      if($scope.ticket['id']){
          // Get ticket
          TicketService.get($scope.ticket['id']).then(function(data){
              $scope.ticket = data;

              $scope.lastUpdated = $scope.ticket.lastUpdated;
          })
          .then(function(){
              // get group name of ticket base on ticket's status
              $scope.groupName = TicketService.getGroupBaseOnCurrentItem($scope.ticketAdmin,$scope.ticket);
              $scope.linkGroupName = angular.lowercase($scope.groupName);
              if($scope.linkGroupName == 'responded'){
                $scope.linkGroupName = 'updated';
              }
              if($scope.linkGroupName == 'ready for review'){
                $scope.linkGroupName = 'reviewed';
              }
          });
      }
  };

  //get a static infomation of ticket
  TicketService.getConfig().then(function(data){
    $scope.states = data['states'];
    $scope.prioritys = data['prioritys'];
    // $scope.decisions = data['decisions'];
  });

  /**
   * push comment to list comment
   * @param  {[string]} comment [comment]
   */
  var commentReadTime = function(comment)
  {
    $scope.items_s = TicketService.pushCommentReadTime(comment, $scope.ticketAdmin,$scope.isSysAdmin);
    //If empty file
    if(typeof $scope.filesUpload !== 'undefined'){
      for(var key in $scope.filesUpload['files']){
        $scope.fileAll[$scope.filesUpload['files'][key].id] = $scope.filesUpload['files'][key];
      }
         $scope.$broadcast("emptyFiles");
         $scope.filesUpload['ids'] = [];
    }
    //if ticket have file, then get all file have start date = create date ticket
    if(typeof comment['files_id'] != 'undefined'){
      if(comment['files_id'].length > 0){
         TicketService.getAllOfUser($scope.ticket['created_at']).then(function(data){
            $scope.fileAll = TicketService.getFilesOfUser();
        });
      }
    }
    // get infomation ticket
    getAmountOfEachTypeTicket();
    $scope.numberLimit += $scope.totalComments;
    // $scope.hideLoadMore = true;
    angular.element('#page-loading').css('display','none');
    angular.element('#respond').removeAttr('disabled');
    angular.element('#internal').removeAttr('disabled');
  };

  /**
   * [getTicket description]
   * get Ticket detail
   * @param  {[type]} id: id of ticket
   * @return {[type]}    [description]
   */
  // $scope.lastUpdated = false;

  $scope.getTicket = function(id)
  {
      //Get all file
      TicketService.getAllOfUser($scope.ticket['created_at']).then(function(data){

          $scope.fileAll = TicketService.getFilesOfUser();
      });
      $scope.currentState = $scope.ticket.status;

      //get all comment of ticket
      $scope.items_s = TicketService.setComments(angular.copy(ticket), $scope.ticketAdmin,$scope.isSysAdmin);
      if(typeof $scope.items_s['comments'] !== 'undefined'){

          $scope.totalComments = $scope.items_s['comments'].length;

          // if($scope.totalComments > 0) {
          //   $scope.lastUpdated = $scope.items_s['comments'][$scope.totalComments - 1]['created_at']['sec'] * 1000;
          // }

          if($scope.numberLimit < $scope.totalComments){
              $scope.hideLoadMore = false;
          }
      }

      //If curent ticket has closed
      if($scope.currentState == 'closed'){
        $scope.showBoxComment = true;
        $timeout(function(){
           $scope.$broadcast('timer-stop');
          },1);
      }

      //get uses has been invited
      getUserInviteOfTicket();

      //get users to select invite
      getUsersOfTicketInvite();

      //get all user of type ticket
      TicketService.getUsersOfTicket($scope.ticket.id).then(function(data){
          $scope.usersOfTicket = data;
      });
      $scope.TicketType = TicketService.setType();
      // $scope.ticketDecision = TicketService.setDecision();

      //Get group of ticket
      $scope.groupName = TicketService.getGroupBaseOnCurrentItem($scope.ticketAdmin,$scope.ticket);

      //Set link in breadcrum
      $scope.linkGroupName = angular.lowercase($scope.groupName);
      if($scope.linkGroupName == 'responded'){
        $scope.linkGroupName = 'updated';
      }

      if($scope.linkGroupName == 'ready for review'){
        $scope.linkGroupName = 'reviewed';
      }

      TicketService.query().then(function(data){
        $scope.items = data;
      })
      if(typeof $scope.ticket['internal'] != 'undefined'){
        dataInternalOld= angular.copy($scope.ticket['internal']);
      }
      getNumberOfTickets();
      getCountUserInvite();
      //   /*event create ticket*/
      var channel = RowboatPusher.subscribe('ticket_'+id);

      channel.bind('Rowboat\\Ticket\\Events\\Ticket\\Broadcast\\TicketReOpen', function(data){
        if (angular.isDefined(data)) {
          $scope.ticket.status = 'open';
          $scope.$broadcast('timer-resume');
          $scope.showBoxComment = false;
          $scope.hideReOpenBtn = true;
          $scope.hideCloseBtn = false;
          getAmountOfEachTypeTicket();
        }

      });

      if($scope.ticket['assign_id']){
          $scope.checkAssign = true;
      }

      if($scope.ticket.type == 'page') {
        $scope.isCms = true;
      }

  };

  /**
   * count user following
   * @return {[type]} [description]
   */
  var getCountUserInvite = function(){
      TicketService.countFollowing($scope.ticket.id).then(function(data){
        countFollowing();
      }).then(function(){
        angular.element('.show-follow').removeClass('hidden');
      });
  };
  var getUserInviteOfTicket = function()
  {
    var defer = $q.defer();
    TicketService.getUserInviteOfTicket($scope.ticket['id']).then(function(data){
    }).then(function(){

      defer.resolve(setInvites());
    });
    return defer.promise;
  };
  var setInvites = function()
  {
    var defer = $q.defer();
    $scope.invites = TicketService.setUserInvite();
    defer.resolve($scope.invites);
    $scope.following = false;
    $scope.userDisplayFollowing = false;
    $scope.userInternal = false;
    if($scope.invites[0]){
      $scope.diplayListUserInvite = true;
    }
    for(var i = 0;i<$scope.invites.length;i++){
        if($scope.invites[i] == userId){
          $scope.userDisplayFollowing = true;
          $scope.userInternal = true;
          $scope.following = true;
        }

    }
    return defer.promise;
  };
  var getUsersOfTicketInvite = function()
  {
        TicketService.getUsersOfTicketInvite($scope.ticket['id']).then(function(data){
          $scope.usersOfTicketInvite = data;
      });
  };

  /**
   * invite user
   * @param {[type]} inviteId [description]
   */
  $scope.addInviteUsers = function(inviteId)
  {
    $('#re-invite').attr('disabled','disabled');

    TicketService.addInvite({id: $scope.ticket['id'],user_id: inviteId}).then(function(data){
      if(data.status==1){
        setInvites();
        getAmountOfEachTypeTicket();
        countFollowing();

        commentReadTime(data.comment);

        getUsersOfTicketInvite($scope.ticket['id']);
        $scope.displaySelect = false;
      }
      $('#re-invite').removeAttr('disabled');
    });
  };
  $scope.checkUserAssign = function(checkAssign)
  {
      if(checkAssign){

          $timeout(function(){
            angular.element('#triggerSelect').trigger('click');
          })
      }
      $scope.displaySelect = false;
      $scope.checkAssign = !checkAssign;
  };

  /**
   * Following ticket
   * @param {[type]} id [description]
   */
  $scope.addFollowing = function(id)
  {
      $scope.followMe = true;
      TicketService.addFollowing(id).then(function(data){
          if(data.status==1){
            commentReadTime(data.comment);
            countFollowing();
            setInvites();
            getAmountOfEachTypeTicket();
            getUsersOfTicketInvite();
          }
          $scope.followMe = false;
      });
  };

  $scope.removeInvite = function (id,userId,following) {
    // $conf = confirm("Do you want to remove Follower?");
    // if(!$conf) {
    //   return;
    // }
    $scope.unFollowing(id,userId,following);
  }

  /**
   * Unfollowing ticket
   * @param  {[integer]} id        [ticket id]
   * @param  {[integer]} userId    [user id]
   * @param  {[bool]} following [check current user click unfollowing or ticket admin remove from list invite]
   */
  $scope.unFollowing = function(id,userId,following)
  {
      $scope.unFollowMe = true;
      TicketService.unFollowing(id,userId).then(function(data){
        if(data.status==1){

          countFollowing();

          setInvites().then(function(){
            $checkInInvite = $scope.invites.indexOf(window.userId);
            if($checkInInvite < 0 && !$scope.ticketAdmin && !($scope.isSysAdmin && $scope.ticket.status == 'approved') && window.userId != $scope.ticket.user_id && window.userId != id) {
              window.location.href=window.baseUrl + '/support';
            }
          });

          commentReadTime(data.comment);
          
          getUsersOfTicketInvite();
          getAmountOfEachTypeTicket();
        }
        $scope.unFollowMe = false;
      });
  };

  /**
   * count number user following
   * @return {[type]} [description]
   */
  var countFollowing = function()
  {
      $scope.countFollowing = TicketService.setCountFollowing();
  }

  $scope.userBranchId = function(branch_id)
  {
      $scope.nameUserbranchManager = '';
      if(branch_id){

          UserService.userBranchManager(branch_id).then(function(data){
              if(data[0]){
                $scope.nameUserbranchManager = data[0]['first_name'] + data[0]['last_name'];
              }
          })
      }
  };
  $scope.checkDisplayInvite = function(displaySelect)
  {
        if(!displaySelect){

          $timeout(function(){
            angular.element('#triggerSelect').trigger('click');
          });
        }

        $scope.checkAssign = true;

        $scope.displaySelect = !displaySelect;
  };
  $scope.hideSelectInvite = function()
  {
      $scope.hideSelect = false;
  };
/**
    * [convetUnixTime description]
    * Convet date time for comments
    * @param  {[type]} strToTime     datTimer format from strToTime
    * @param  {[type]} unixTimestamp [description]
    * @return {[type]}               [description]
    */
  $scope.convetUnixTime = function(unixTime)
  {

      var date = new Date(unixTime);
      return date;
   };
  $scope.clickable = function(id){
    window.location = baseUrl + "/support/show/" + id;
  };

  /**
   * stop event
   */
  $scope.delete = function($event,id){
    $event.stopPropagation();
  };

  /**
   * assign user
   * @param  {[integer]} id       [user assigned]
   * @param  {[integer]} assignId [user before assigned]
   * @param  {[integer]} userId   [owner id]
   */
  $scope.assignPeople = function(id,assignId,userId)
  {
    if(typeof id == 'undefined' || id == assignId) {
      return;
    }

    $('#re-assign').attr('disabled','disabled');

    var data = {id: $scope.ticket.id,user_id: id};
    TicketService.addAssign(data,assignId,userId).then(function(data){
        if(data.status == 0){
          $scope.error = '';
            for(var key in data.error){
                $scope.error = data.error[key]+'<br/>';
            }
          $scope.checkAssign = true;
          getAmountOfEachTypeTicket();
        }else{
          $scope.ticket.status = 'assigned';
          setInvites().then(function(data){
            $checkInInvite = $scope.invites.indexOf(window.userId);
            //check if user don't permission recieve ticket then redirect to ticket page
            if($checkInInvite < 0 && !$scope.ticketAdmin && !($scope.isSysAdmin && $scope.ticket.status == 'approved') && window.userId != $scope.ticket.user_id && window.userId != id) {
              window.location.href=window.baseUrl + '/support';
            }
          });
          countFollowing();

          //push comment: comment assign, comment remove invite
          for(i in data.comment) {
              commentReadTime(data.comment[i]);   
          }

          getAmountOfEachTypeTicket();

          $scope.ticket.assign_id = id;

          $scope.checkAssign = true;

          getUsersOfTicketInvite();
        }

        $('.mini-show').removeClass('div-mini-show');
        $('#re-assign').removeAttr('disabled');
    });
  }
 /**
   * assign user child ticket
   *
   */
  $scope.assignPeopleChild = function(id,assignId,userId)
  {
    if(typeof id == 'undefined' || id == assignId) {
      return;
    }
    if(angular.isUndefined($scope.ticketChild)){
         $scope.ticketChild = [];
    }
    $scope.ticketChild.assign_id = id;

    $scope.checkAssignChild = true;

    $('.mini-show').removeClass('div-mini-show');
    $('#re-assign').removeAttr('disabled');
  }
  $scope.updateShowDueDateUser = function(type)
  {
        var data = {userId: $scope.userId ,type: type};

        UserService.updateShowDueDateUser(data).then(function(data){

            if(data.status){

              if(data.type == 'time'){

                $scope.isTime = true;

              }else{

                $scope.isTime = false;

              }
            }

        });
  }
  /**
   * [addComment description]
   * add private comment
   * @param {[type]} ticketId [description]
   */
    var isSendingRespond = false;
    $scope.addComment = function(ticketId, isPrivate)
    {
      $scope.response(ticketId, 1);
     };
  /**
   * [response description]
   * @return {[type]} [description]
   */

    $scope.hiddentAction = function(type) {
      initRedactor();
      $scope.submitted = false;
      $scope.isShowAction = false;
      $scope.typeShow = type;
    }

    $scope.showAction = function() {
      $('#content').val('');
      $("#content").redactor('code.set', '');
      $('.redactor-box .redactor-editor').addClass('redactor-placeholder');
      $('#content').redactor('core.destroy');
      $scope.isShowAction = true;

    }

    $scope.showAction1 = function() {
      $('#content-child').redactor('core.destroy');
      $scope.isShowAction = true;
      $scope.filesUploadChild=[];
      $scope.submittedChild = false;
      $scope.ticketChild=[];
      $scope.ticketChild.title = $scope.ticket.title;
    }

    $scope.getModalUpdatePercent = function (ticketId, percent) {
      var template = '/support/update-percent-complete/' + ticketId + '?' + new Date().getTime();

      var modalInstance = $modal.open ({
          animation: true,
          templateUrl: window.baseUrl + template,
          controller: 'ModalUpdatePercentController',
          size: null,
          resolve: {
            ticketId : function() {
              return ticketId;
            },
            percent: function(){
              return $scope.ticket.percent_complete;
            }
          }

      });
      modalInstance.result.then(function (data) {
        $scope.ticket.percent_complete = data.percent;
        commentReadTime(data.comment);
      });
    };

    $scope.getModalRequestExtention = function (ticketId, due_date,checkDueDate) {
      var template = '/support/update-request-extention';

      var modalInstance = $modal.open ({
          animation: true,
          templateUrl: window.baseUrl + template,
          controller: 'ModalUpdateDueData',
          size: null,
          resolve: {
            ticketId : function() {
              return ticketId;
            },
            due_date: function(){
              return due_date;
            },
            checkDueDate: function(){
              return checkDueDate;
            }
          }

      });
      modalInstance.result.then(function (data) {
        if(data.check_due_date){

          $scope.ticket.due_date = data.due_date;
          commentReadTime(data.comment);
        } else {
            $scope.ticket.request_extension = new Date(data.due_date);
            commentReadTime(data.comment);
        }
        // $scope.overdue = false;
        // $scope.ticket['due_date'] = new Date(data.due_date);
        // $timeout(function(){
        //   $scope.$apply(function(){

        //     $scope.$broadcast('timer-start');

        //   });
        // },100);

      });
    };
    $scope.changeDateTimeChildTicket= function(){
        $scope.errorDateTime = false;
    }
    $scope.response = function(ticketId, isPrivate)
    {
      // $scope.isShowAction = true;
      $scope.submitted = true;



      angular.element('#internal').attr('disabled', 'true');
      angular.element('#respond').attr('disabled', 'true');
      // angular.element('.wrapper').css('display','none');
      angular.element('#page-loading').css('display','block');

      if(isSendingRespond || $scope.comment == 'undefined') return;
        isSendingRespond = true;
        $scope.numberLimit += $scope.limitStep;
        // $scope.hideLoadMore = true;
        var files_id = [];

        if(typeof $scope.filesUpload !== 'undefined'){
            files_id = $scope.filesUpload['ids'];
        }

        $scope.isSubmit = true;
        $content = $('#content').redactor('code.get');
        var data = {id: ticketId, content: $content, files_id: files_id};

        $scope.validate = true;
        if(data.content == '<div></div>' || data.content == ''|| data.content == '<br>' || $content == '<div><strong></strong></div>'|| $content == '<div><em></em><strong></strong></div>'|| $content == '<div><em><del></del></em></div>') {
          $scope.validate = false;
          isSendingRespond = false;

          angular.element('#page-loading').css('display','none');
          angular.element('#respond').removeAttr('disabled');
          angular.element('#internal').removeAttr('disabled');


          return;
        }

        //If response
        if(!isPrivate){

          TicketService.response(data).then(function(data){

              commentReadTime(data);
              isSendingRespond = false;
              $scope.submitted = false;
              $scope.lastUpdated = data.lastUpdated;
              $('html, body').animate({
                  scrollTop: $('#endOfPage').offset().top
              }, 1000);

          });
        }
        else{ //if comment internal
          TicketService.addComment(data).then(function(data){

            if(data.status) {

              commentReadTime(data.item);

            }

            isSendingRespond = false;
            $scope.submitted = false;
          });
        }

        $scope.showAction();
        // $('#content').redactor('core.destroy');
        // $scope.isShowAction = true;
         angular.element('#collapseExample.ui-create').removeClass('in');
     };

     /**
      * [Close ticket]
      * close ticket
      * @return {[type]} [description]
      */
     $scope.close = function(ticketId)
     {
        $scope.numberLimit += $scope.limitStep;
        $scope.hideLoadMore = true;
        var loaded = false;
        if(loaded == false){
            if(typeof $scope.comment == 'undefined'){
               content = '';
            }else{
                content = $('#content').redactor('code.get');
            }
            var data = {id: ticketId, content: content};
            TicketService.close(data).then(function(data){

                getAmountOfEachTypeTicket();
                window.location.href = window.baseUrl + '/support';

            });
        }
     };
        // $scope.$on('timer-tick', function (event, args) {
        //         $scope.timerConsole += $scope.timerType  + ' - event.name = '+ event.name + ', timeoutId = ' + args.timeoutId + ', millis = ' + args.millis +'\n';
        //     });
       $scope.reopen = function(ticketId)
       {
         var loaded = false;
        if(loaded == false){
            var data = {id: ticketId};
            TicketService.reopen(data).then(function(data){
                // if($scope.ticket.decision == 'denied'){
                //   $scope.ticketDecision  = '';
                // }
                getAmountOfEachTypeTicket();
            });
        }
     };
    $scope.newChildTicket = function(ticketChild)
    {
      // $scope.isShowAction = true;
      $scope.submittedChild = true;
        var files_id = [];

        if(typeof $scope.filesUploadChild !== 'undefined'){
            files_id = $scope.filesUploadChild['ids'];
        }
        $content = $('#content-child').redactor('code.get');
        $content.validate = true;
        if($content == '<div></div>' || $content == ''|| $content == '<br>' || $content == '<div><strong></strong></div>'|| $content == '<div><em></em><strong></strong></div>'|| $content == '<div><em><del></del></em></div>') {
          $scope.validateChild = false;
        }
        $scope.ticketChild.description= $content;
        $scope.ticketChild.files_id= files_id;
        $scope.ticketChild.base_id= $scope.ticket.id;
        $scope.ticketChild.type= $scope.ticket.type_id;
        $scope.ticketChild.priority= $scope.ticket.priority;
        $scope.ticketChild.url= $scope.ticket.url;
        $scope.ticketChild.ticketType= $scope.ticket.type;
        $scope.errorDateTime = false;
        if(!$scope.hideDueDate) {
          if(typeof $scope.ticketChild.due_date == 'undefined' || typeof $scope.ticketChild.due_date == 'undefined'|| $scope.ticketChild.due_date == null) {
            $scope.errorDateTime = true;
          }          
        }
        if(!$scope.validateChild||$scope.errorDateTime||angular.isUndefined(ticketChild.assign_id)||ticketChild.assign_id==null){
            return;
        }
        angular.element('#page-loading').css('display','block');
        if(typeof $scope.ticketChild.ticketType != 'undefined' && $scope.ticketChild.ticketType=='page') {
          delete $scope.ticketChild.ticketType;
          delete $scope.ticketChild.url;
          delete $scope.ticketChild.content_id;
        }

        TicketService.create($scope.ticketChild).then(function(data){
            $scope.ticket.childTickets.push(data.item);
            commentReadTime(data.commentCreate);
            commentReadTime(data.commentAssign);

            angular.element('#page-loading').css('display','none');
            $('#collapseExample-child-ticket').removeClass('in');

            $('#content-child').redactor('core.destroy');

            $scope.isShowAction = true;

            $scope.filesUploadChild=[];
            $scope.filesUpload=[];
            $scope.submittedChild = false;
            $scope.ticketChild=[];
            $scope.ticketChild.title = $scope.ticket.title;

        });
     };

     /**
      * [Close ticket]
      * close ticket
      * @return {[type]} [description]
      */
     $scope.close = function(ticketId)
     {
        $scope.numberLimit += $scope.limitStep;
        $scope.hideLoadMore = true;
        var loaded = false;
        if(loaded == false){
            if(typeof $scope.comment == 'undefined'){
               content = '';
            }else{
                content = $('#content').redactor('code.get');
            }
            var data = {id: ticketId, content: content};
            TicketService.close(data).then(function(data){

                getAmountOfEachTypeTicket();
                window.location.href = window.baseUrl + '/support';

            });
        }
     };
        // $scope.$on('timer-tick', function (event, args) {
        //         $scope.timerConsole += $scope.timerType  + ' - event.name = '+ event.name + ', timeoutId = ' + args.timeoutId + ', millis = ' + args.millis +'\n';
        //     });
       $scope.reopen = function(ticketId)
       {
         var loaded = false;
        if(loaded == false){
            var data = {id: ticketId};
            TicketService.reopen(data).then(function(data){
                // if($scope.ticket.decision == 'denied'){
                //   $scope.ticketDecision  = '';
                // }
                getAmountOfEachTypeTicket();
            });
        }
     };

    $scope.editDraft = function(ticketId) {
        window.location = window.baseUrl + '/cms/pages/edit-draft/'+ window.ticket_content_map[ticketId]['_id'] + '?checkPage=' + 1 ;
    }

    $scope.viewDraft = function(ticketId) {

        TicketService.getLinkViewDraft(ticketId).then(function(data){
          console.log(data,'data');
          if(data.status) {
            window.open(window.linkViewDraft + data.url,'_blank');
          }
        });


        // var linkLanguageRegion = '';
        // if(window.ticket_content_map[ticketId]['language'] == 'en' && window.ticket_content_map[ticketId]['region'] == null) {
        //   var linkLanguageRegion = '';
        // } else {
        //   if( window.ticket_content_map[ticketId]['region'] == null) {
        //     var reRegion = 'us';
        //   } else {
        //     var reRegion = window.ticket_content_map[ticketId]['region'];
        //   }
        //   var linkLanguageRegion = '/' + window.ticket_content_map[ticketId]['language'] + '-' + reRegion;
        // }
        // window.open(window.linkViewDraft + linkLanguageRegion + window.ticket_content_map[ticketId]['route'] + '/' + window.ticket_content_map[ticketId]['_id'],'_blank');
        // window.open(window.baseUrl + '/cms/pages/view-draft/'+ window.ticket_content_map[ticketId],'_blank');
    }

     /**
      * when assign click ready for reviewed
      * @param  {[integer]} ticketId [ticket id]
      */
     $scope.readyForReviewed = function(ticketId)
     {
        var loaded = false;
        if(loaded == false){
          angular.element('#page-loading').css('display','block');
          angular.element('#reviewed').attr('disabled', 'true');
          var data = {id: ticketId};
          TicketService.readyForReviewed(data).then(function(data){
            if(data.status) {
              $scope.ticket.status = 'reviewed';
              // $scope.$broadcast('timer-resume');
              $scope.showBoxComment = true;
              $scope.hideReOpenBtn = true;
              $scope.hideCloseBtn = true;
              commentReadTime(data.comment);
              getAmountOfEachTypeTicket();

            }
            angular.element('#reviewed').removeAttr('disabled');
            angular.element('#page-loading').css('display','none');
            loaded = true;
          });
        }
        $scope.submitted = false;
     };

     /**
      * when ticket admin click approved
      * @param  {[integer]} ticketId [ticket id]
      */
     $scope.approved = function(ticketId)
     {
        var loaded = false;
        if(loaded == false){
            angular.element('#page-loading').css('display','block');
            angular.element('#approved').attr('disabled', 'true');
            var data = {id: ticketId};
            TicketService.approved(data).then(function(data){
              if(data.status) {
                $scope.ticket.status = data.ticketStatus;
                $scope.showBoxComment = true;
                $scope.hideReOpenBtn = true;
                $scope.hideCloseBtn = true;
                commentReadTime(data.comment);
                getAmountOfEachTypeTicket();
              }
              angular.element('#approved').removeAttr('disabled');
              angular.element('#page-loading').css('display','none');
              loaded = true;
            });
        }
        $scope.submitted = false;
     };

     /**
      * when system administrator click deploy
      * @param  {[integer]} ticketId [ticket id]
      */
     $scope.deploy = function(ticketId){
         var loaded = false;
        if(loaded == false){
            angular.element('#page-loading').css('display','block');
            angular.element('#deploy').attr('disabled', 'true');
            var data = {id: ticketId};
            TicketService.deploy(data).then(function(data){
              if(data.status) {
                commentReadTime(data.comment);
                $scope.ticket.status = data.ticketStatus;
                $scope.showBoxComment = true;
                $scope.hideReOpenBtn = false;
                $scope.hideCloseBtn = true;
                // $scope.$broadcast('timer-stop');
                getAmountOfEachTypeTicket();
                angular.element('#deploy').removeAttr('disabled');
                angular.element('#page-loading').css('display','none');
                loaded = true;                
              }
            });
        }
        $scope.submitted = false;
     };

     /**
      * when ticket admin click deny
      * @param  {[integer]} ticketId [ticket id]
      */
     $scope.deny = function(ticketId){
        var loaded = false;
        if(loaded == false){
            angular.element('#page-loading').css('display','block');
            angular.element('#deny').attr('disabled', 'true');
            var data = {id: ticketId};
            TicketService.deny(data).then(function(data){
              if(data.status) {
                $scope.ticket.status = 'assigned';
                // $scope.$broadcast('timer-resume');
                $scope.showBoxComment = true;
                $scope.hideReOpenBtn = true;
                $scope.hideCloseBtn = true;
                commentReadTime(data.comment);
                getAmountOfEachTypeTicket();
              }
              angular.element('#deny').removeAttr('disabled');
              angular.element('#page-loading').css('display','none');
              loaded = true;
            });
        }
        $scope.submitted = false;
     };

     /* show modal add assign and invite
     param string tmp*/
    $scope.getModalAdd = function(tmp, ticketId) {
        var templateUrl = 'support/add-invite';
        // check tmp
        if(tmp == 'assign'){
          templateUrl = 'support/add-assign';
        }
        var modalInstance = $modal.open({
            templateUrl: templateUrl,
            controller: 'ModalCreateAdd',
            size: undefined,
            resolve: {
                 ticketId: function(){
                    return ticketId;
                 } ,
                 userSelect: function(){
                    return $scope.usersOfTicket;
                 } ,
           }
        });
        modalInstance.result.then(function(item) {
          getAmountOfEachTypeTicket();
        }, function() {});

    };

  /**
   * show modal edit type
   * @param  {[integer]} id [type id]
   */
  $scope.getModalUpdateType = function(id) {
    var modalInstance = $modal.open({
      templateUrl: 'support/update-type/' + id,
      controller: 'ModalUpdateType',
      size: undefined,
      resolve: {

      }
    });
    modalInstance.result.then(function (type) {
          $scope.TicketType = TicketService.setType();
        }, function () {
        });
  };

    /**
    *   isImage: check file is Image
    * @param  {[type]}  type [description]
    * @return {Boolean}      [description]
    */
    $scope.isImage = function(type){
      if(typeof type !== 'undefined'){
         if(type.indexOf('image') == 0){
             return true;
        }
        return false;
      }

    };

    $scope.checkImage = function(typeFile){
      if(typeof typeFile != 'undefined'){
        if(angular.lowercase(typeFile) == 'jpg' || angular.lowercase(typeFile) == 'png'){
          return true;
        }else{
          return false;
        }
      }
    };

    $scope.approveExtension = function(ticketId) {
        $('#btnApproveExtension').attr('disabled','disabled');

        var data = {id: ticketId};
        TicketService.approveExtension(data).then(function(data){
          if(data.status) {
            commentReadTime(data.comment);
            $scope.ticket.request_extension = null;
            $scope.overdue = false;
            $scope.ticket['due_date'] = new Date(data.due_date);
            $timeout(function(){
              $scope.$apply(function(){

                $scope.$broadcast('timer-start');

              });
            },100);
          }
          $('#btnApproveExtension').removeAttr('disabled');
        });
    }

    $scope.unAssign = function (ticketId) {
      
      $('#page-loading').css('display','block');

      TicketService.unAssign(ticketId).then(function(data){
        console.log(data,'data');
        if(data.status) {
          $scope.ticket.status = 'new';
          commentReadTime(data.comment);
          getAmountOfEachTypeTicket();
        }
        $('#page-loading').css('display','none');
      });
    }

    $scope.selectChild = function($event, childId) {
      if(typeof $scope.ticket.childSelected == 'undefined') {
        $scope.ticket.childSelected = [];
      }

      if($event.target.checked == true) {
        if($scope.ticket.childSelected.indexOf(childId) == -1) {
          $scope.ticket.childSelected.push(childId);
        }
      } else {
        var index = $scope.ticket.childSelected.indexOf(childId);
        if(index > -1) {
          $scope.ticket.childSelected.splice(index,1);
        }
      }
    }

    /**
     * return search result
     *
     * @author Quang <httsolution.com>
     * 
     */
    $scope.returnSearchResult = function() {
        console.log($scope.filterDataParam,'$scope.filterDataParam');
        TicketService.returnSearchResult($scope.filterDataParam).then(function(data){
            console.log(data,'data');
            if(data.status) {
              window.location = window.baseUrl + '/support/state/'+ data.ticket_state;
            }
        });
    }

}])
.controller('ModalUpdatePercentController', ['$scope', '$modalInstance','ticketId','percent','TicketService', function ($scope, $modalInstance,ticketId, percent,TicketService) {
    $scope.ticket = {};
    $scope.ticket.id = ticketId;
    $scope.ticket.percent_complete = parseInt(percent);

    $scope.updatePercentComplete = function(ticketId){
      $('#btnUpdatePercent').attr('disabled','disabled');

      $scope.errorPercent = false;
      if(typeof $scope.ticket.percent_complete == 'undefined' || $scope.ticket.percent_complete == null) {
        $scope.errorPercent = true;
        $('#btnUpdatePercent').removeAttr('disabled');
        return;
      }

      TicketService.updatePercentComplete(ticketId, $scope.ticket.percent_complete).then(function(data){
          if(data.status) {
            $modalInstance.close(data);
          }
          $('#btnUpdatePercent').removeAttr('disabled');
      });
    }

    $scope.cancel = function(){
      $modalInstance.dismiss('cancel');
    };
}])

.controller('ModalUpdateDueData', ['$scope', '$modalInstance','$filter','ticketId','due_date','checkDueDate','TicketService', function ($scope, $modalInstance,$filter,ticketId, due_date,checkDueDate,TicketService) {
    due_date = $filter('date')(new Date(due_date.replace(/-/g, "/")), 'MM/dd/yyyy HH:mm:ss');
    $scope.checkDueDate = checkDueDate;

    $scope.myDate = $filter('date')(new Date(due_date), 'MM-dd-yyyy');

    $scope.myTime = new Date(due_date);

    $scope.ticket = {};
    $scope.ticket.id = ticketId;

    $scope.open = function ($event) {
      $scope.opened = true;
    }
    $scope.changeDateTime = function(){
      $scope.errorDateTime = false;
    }
    $scope.updateDueDate = function (ticketId) {
      $('#btnRequestExtension').attr('disabled','disabled');

      if(typeof $scope.myDate == 'undefined' || typeof $scope.myTime == 'undefined'|| $scope.myTime ==null|| $scope.myDate ==null) {
        $scope.errorDateTime = true;
        $('#btnRequestExtension').removeAttr('disabled');
        return;
      }
      $scope.dueDateUpdate =angular.copy($scope.myDate);
      $scope.dueDate = new Date($scope.myDate);

      var stringTime = $filter('date')($scope.myTime, 'HH:mm:ss');
      var arrayTime = stringTime.split(":");

      $scope.dueDate.setHours(arrayTime[0]);
      $scope.dueDate.setMinutes(arrayTime[1]);
      $scope.dueDate.setSeconds(arrayTime[2]);

      TicketService.updateDueDate(ticketId, $scope.dueDate,$scope.checkDueDate).then(function(data){
          if(data.status) {
            $modalInstance.close(data);
          }
          $('#btnRequestExtension').removeAttr('disabled');
      });
    }

    $scope.cancel = function(){
      $modalInstance.dismiss('cancel');
    };
}])
.controller('ModalViewPictureCtrl', ['$scope', '$modalInstance','fileId', function ($scope, $modalInstance, fileId) {
    $scope.fileId = fileId;
    $scope.baseUrl = baseUrl;
    $scope.cancel = function(){
      $modalInstance.dismiss('cancel');
    };
}]).filter('bytes', function() {
    return function(bytes, precision) {
        if (isNaN(parseFloat(bytes)) || !isFinite(bytes)) return '-';
        if (typeof precision === 'undefined') precision = 1;
        var units = ['bytes', 'kB', 'MB', 'GB', 'TB', 'PB'],
            number = Math.floor(Math.log(bytes) / Math.log(1024));
        return (bytes / Math.pow(1024, Math.floor(number))).toFixed(precision) + ' ' + units[number];
    };
}).filter('to_trusted', ['$sce', function($sce){
      return function(text) {
          return $sce.trustAsHtml(text);
      };
  }]);
