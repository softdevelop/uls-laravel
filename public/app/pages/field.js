function humanized_time_span(e,t,n,r){function i(){for(var e=0;e<n[s].length;e++)if(null==n[s][e].ceiling||u<=n[s][e].ceiling)return n[s][e];return null}function a(){for(var e=u,t={},n=0;n<r.length;n++){var i=Math.floor(e/r[n][0]);e-=r[n][0]*i,t[r[n][1]]=i}return t}function o(e){var t=a(),n=e.text.replace(/\$(\w+)/g,function(){return t[arguments[1]]});return l(n,t)}function l(e,t){for(var n in t)if(1==t[n]){var r=new RegExp("\\b"+n+"\\b");e=e.replace(r,function(){return arguments[0].replace(/s\b/g,"")})}return e}if(n=n||{past:[{ceiling:60,text:"$seconds seconds ago"},{ceiling:3600,text:"$minutes minutes ago"},{ceiling:86400,text:"$hours hours ago"},{ceiling:2629744,text:"$days days ago"},{ceiling:31556926,text:"$months months ago"},{ceiling:null,text:"$years years ago"}],future:[{ceiling:60,text:"in $seconds seconds"},{ceiling:3600,text:"in $minutes minutes"},{ceiling:86400,text:"in $hours hours"},{ceiling:2629744,text:"in $days days"},{ceiling:31556926,text:"in $months months"},{ceiling:null,text:"in $years years"}]},r=r||[[31556926,"years"],[2629744,"months"],[86400,"days"],[3600,"hours"],[60,"minutes"],[1,"seconds"]],"Invalid Date"==new Date(e))for(;-1!=String(e).indexOf("-");)e=e.replace("-","/");e=new Date(e),t=t?new Date(t):new Date;var u=(t-e)/1e3,s="past";return 0>u&&(s="future",u=0-u),o(i())}angular.module("user",[]),angular.module("permission",[]),angular.module("role",[]),angular.module("multiSelect",[]),angular.module("ticket",[]),angular.module("type",[]),angular.module("dataOption",[]),angular.module("nlcFilter",[]),angular.module("file",[]),angular.module("AppLanguage",[]),angular.module("TemplateManagerApp",[]),angular.module("RegionApp",[]),angular.module("campaignApp",[]),angular.module("campaignDetailApp",[]),angular.module("MarketsegmentApp",[]),angular.module("notification",[]),angular.module("transApp",[]),angular.module("assetManager",[]),angular.module("BlockApp",[]),angular.module("ChannelPartnersApp",[]),angular.module("roleGroup1",[]),angular.module("filedType",[]),angular.module("filed",[]),angular.module("term",[]),angular.module("customFormatDate",[]),angular.module("SeoAnalysisApp",[]),angular.module("pageApp",[]),angular.module("treeresizer",[]),angular.module("CreatePageApp",[]),angular.module("EditDraftApp",[]),angular.module("fomatHtml",[]),angular.module("colorpicker.module",[]),angular.module("formBuilderDirectiveApp",[]),angular.module("appManageTerm",[]),angular.module("TermTemplateManagerApp",[]),angular.module("configurator",[]),angular.module("TemplateContentManager",[]),angular.module("cmsContentFolderApp",[]),angular.module("lowercaseCharater",[]),angular.module("selectLevel",[]),angular.module("modalSelectLevel",[]),angular.module("configField",[]),angular.module("cmsContentInsertApp",[]),angular.module("confirmDirective",[]),angular.module("CmsApp",[]),angular.module("checkLimitAndChangeDateTimeDirectiveApp",[]),angular.module("tagContentApp",[]),angular.module("tagContentDirective",[]),angular.module("cmsContentTagApp",[]),angular.module("viewDraft",[]),angular.module("databaseManager",[]),angular.module("selectLevelDatabase",[]),angular.module("modalSelectPage",[]),angular.module("configFormDatabaseApp",[]),angular.module("historyApp",[]),angular.module("BlockNestedApp",[]),angular.module("selectLevelAsset",[]),angular.module("MaterialApp",[]),angular.module("draganddrop",[]),angular.module("activityLog",[]),angular.module("translation",[]),angular.module("HelpEditorApp",[]),angular.module("helpEditorDirective",[]),angular.module("selectLevelHelp",[]),angular.module("cache",[]),angular.module("file",[]),angular.module("treeresize",[]),angular.module("test",[]),angular.module("guide",[]),angular.module("PlatformsApp",[]),angular.module("accessories",[]);var defaultModules=["ui.bootstrap","ngResource","ngCookies","ngFileUpload","ngRoute","toggle-switch","ngImgCrop","ngTable","user","role","permission","multiSelect","ticket","type","dataOption","nlcFilter","file","xeditable","timer","AppLanguage","TemplateManagerApp","RegionApp","campaignApp","campaignDetailApp","MarketsegmentApp","notification","transApp","assetManager","BlockApp","ChannelPartnersApp","roleGroup1","filedType","filed","term","ui-iconpicker","customFormatDate","SeoAnalysisApp","pageApp","treeresizer","CreatePageApp","EditDraftApp","fomatHtml","colorpicker.module","formBuilderDirectiveApp","appManageTerm","TermTemplateManagerApp","mgo-angular-wizard","configurator","TemplateContentManager","cmsContentFolderApp","lowercaseCharater","selectLevel","configField","cmsContentInsertApp","confirmDirective","CmsApp","checkLimitAndChangeDateTimeDirectiveApp","tagContentApp","tagContentDirective","cmsContentTagApp","viewDraft","modalSelectLevel","databaseManager","selectLevelDatabase","modalSelectPage","configFormDatabaseApp","historyApp","BlockNestedApp","selectLevelAsset","MaterialApp","ui.sortable","activityLog","translation","HelpEditorApp","helpEditorDirective","selectLevelHelp","cache","file","treeresize","guide","PlatformsApp","accessories"];"undefined"!=typeof modules&&(defaultModules=defaultModules.concat(modules));var myApp=angular.module("uls",defaultModules);angular.module("uls").run(["editableOptions",function(e){e.theme="bs3"}]),angular.module("uls").config(["$logProvider",function(e){e.debugEnabled(window.debug)}]),"undefined"!=typeof angularMock&&(defaultModules=defaultModules.concat(angularMock));var goTo=function(e){window.location.href="#_"+e,$("#fix-modal-top").scrollTop(0),$("#"+e).hasClass("in")||$("#"+e).prev().trigger("click")};myApp.config(["$httpProvider",function(e){e.interceptors.push(["$q",function(e){e.defer();return{responseError:function(t){var n=angular.element(".butterbar-container");switch(t.status){case 401:return void(window.location.href=window.baseUrl);case 404:n.hasClass("hidden")&&n.removeClass("hidden");break;case 500:n.hasClass("hidden")&&n.removeClass("hidden")}return e.reject(t)}}}])}]),function(e){function t(){var t=window.innerHeight;screen.height;e(".table-responsive.set-height, .table-responsive#tb-group-user").css({height:t-170+"px"}),e(".table-animate").css({height:t-170+"px"}),e("#search-page,.box-maps").css({height:t-105+"px"}),e(".box-list-rep").css({height:t-100+"px"}),e("#load-maps").css({height:t-185+"px"})}e(document).ready(t),e(window).resize(t),e(document).ready(function(){e(".dropdown-menu table tr td button").removeAttr("style")}),e(document).ready(function(){setTimeout(function(){var t=e("#frame_html").contents().find("head");t.append('<style type="text/css">.area_toolbar{background-color:#f1f1f1;}#editor{border:solid #ccc 1px}#result{border-top:solid #ccc 1px;border-bottom: solid #ccc 1px}.editarea_popup{box-shadow: 0px 4px 36px rgba(177, 177, 177, 0.75);border: solid 1px #CCCCCC;background-color: #FFFFFF;}.area_toolbar select{font-size:9pt;background-color:#fff}</style>')},1e3)}),e(window).load(function(){e(".step3 .show-more").click(function(){e(".step3 .wrap-more-product").toggleClass("show")})}),e(document).ready(function(){e(".nav-icon").click(function(){e(this).toggleClass("open"),e("#pagehome").toggleClass("on-off")})});var n,r,i,a,o,l,u;e(".next").click(function(){return u?!1:(u=!0,n=e(this).parent(),r=e(this).parent().next(),r.show(),void n.animate({opacity:0},{step:function(e,t){l=1-.2*(1-e),a=50*e+"%",o=1-e,n.css({transform:"scale("+l+")"}),r.css({left:a,opacity:o})},duration:800,complete:function(){n.hide(),u=!1},easing:"easeInOutBack"}))}),e(".previous").click(function(){return u?!1:(u=!0,n=e(this).parent(),i=e(this).parent().prev(),i.show(),void n.animate({opacity:0},{step:function(e,t){l=.8+.2*(1-e),a=50*(1-e)+"%",o=1-e,n.css({left:a}),i.css({transform:"scale("+l+")",opacity:o})},duration:800,complete:function(){n.hide(),u=!1},easing:"easeInOutBack"}))}),e(".submit").click(function(){return!1})}(jQuery),angular.module("uls").controller("BaseController",["$scope","$parse","$timeout","$modal","UserService","AssetManagerService",function(e,t,n,r,i,a){if(angular.element(".wrapper").removeClass("hidden"),i.setData(window.usersMap),n(function(){"undefined"!=typeof e.callbackLoadUserFinish&&(e.callbackLoadUserFinish(),e.users_map=i.getUsersMap())}),e.testFuture=window.testFuture,1==e.testFuture&&angular.element(".test").removeClass("hidden"),e.windowType=window.info,"undefined"!=typeof window.info)for(var o in window.info){var l=t(o);l.assign(e,window.info[o])}e.initDate=function(){angular.element(".date").bdatepicker({format:"yyyy-mm-dd"})},e.viewModalImage=function(e){var t=r.open({templateUrl:baseUrl+"/app/components/termTemplateManager/views/modal/viewImage.html",controller:"ModalViewPictureCtrl",size:void 0,windowClass:"show-img",resolve:{fileId:function(){return e}}});t.result.then(function(e){},function(){})},e.urlForm=[],e.getUrlImageAssetForm=function(t,n){"undefined"==typeof e.urlForm[t]&&(e.urlForm[t]=[]),a.getUrlImageAsset(t).then(function(r){e.urlForm[t][n]=r.url})},e.removeThumbnailAssertForm=function(t,n){e.urlForm[t][n]=""},e.initTooltip=function(e){$('[data-toggle="tooltip"]').tooltip()}}]).controller("ModalViewPictureCtrl",["$scope","$modalInstance","fileId",function(e,t,n){e.fileId=n,e.baseUrl=baseUrl,e.cancel=function(){t.dismiss("cancel")}}]);var userModule=angular.module("user");userModule.factory("UserResource",["$resource",function(e){return e("/api/user/:method/:id",{method:"@method",id:"@id"},{add:{method:"post"},save:{method:"post"},update:{method:"put"}})}]).factory("UserService",["$q","$filter","UserResource",function(e,t,n){var r=[],i=[],a=[],o=this,l={},u={};return this.setHashData=function(e){l=e},this.create=function(t){if("undefined"!=typeof t.id)return o.update(t);var i=e.defer(),a=new n(t);return a.$save({},function(e){e.status&&e.item&&(r.push(e.item),"undefined"==typeof e.item.last_login&&(e.item.last_login="0000-00-00 00:00:00")),i.resolve(e)},function(e){i.resolve(e.data)}),i.promise},this.changePassword=function(t){var r=e.defer(),i=new n(t);return i.$save({method:"change-password",id:t.id},function(e){e.status?r.resolve(e):r.reject(e)},function(e){r.reject(e.data)}),r.promise},this.changeRoles=function(t){var r=e.defer(),i=new n(t);return i.$save({method:"change-roles"},function(e){e?r.resolve(e):r.reject(e)},function(e){r.reject(e.data)}),r.promise},this.update=function(t){var i=e.defer(),a=new n(t);return a.$update({id:t.id},function(e){if(e.status)for(var t in r)if(r[t].id==e.item.id){r[t]=e.item;break}i.resolve(e)},function(e){i.resolve(e.data)}),i.promise},this.get=function(t){var r=e.defer();return n.get({id:t},function(e){r.resolve(e)}),r.promise},this.query=function(){var t=e.defer();return n.query(function(e){r=e,t.resolve(e)}),t.promise},this.queryUsersManager=function(){var t=e.defer();return n.query({method:"get-all-user-manager"},function(e){r=e,t.resolve(e)}),t.promise},this.remove=function(t){var i=e.defer();return n["delete"]({id:t},function(e){if(e.status)for(var n in r)if(r[n].id==t){r[n].status="no";break}i.resolve(e)}),i.promise},this.pushUser=function(e){r.push(e)},this.updateUser=function(e){for(var t in r)if(r[t].id==e.id){e.status="yes",r[t]=e;break}},this.changeAvatar=function(t,r){var i=e.defer();return n.save({method:"change-avatar",file:r,id:t},function(e){i.resolve(e)},function(e){i.resolve(e.data)}),i.promise},this.resetPassword=function(t){var r=e.defer();return n.save({method:"email",entity:"password",email:t},function(e){r.resolve(e)},function(e){r.resolve(e.data)}),r.promise},this.getUsers=function(){return r},this.getUserById=function(e){return u[e]},this.getUsersMap=function(){return u},this.listMap=function(e,t){if("role"==t)for(var n in e)i[e[n].id]=e[n];else for(var n in e)a[e[n].id]=e[n]},this.getMap=function(e){return"role"==e?i:a},this.userBranchManager=function(t){var r=e.defer();return n.query({id:t,method:"get-users-branch-manager"},function(e){r.resolve(e)}),r.promise},this.updatePermissions=function(t,r){var i=e.defer();return n.save({id:t,permissionIds:r,method:"update-permission"},function(e){i.resolve(e)},function(e){i.resolve(e.data)}),i.promise},this.updateGroup=function(t,r){var i=e.defer();return n.save({id:t,groupIds:r,method:"update-group"},function(e){i.resolve(e)},function(e){i.resolve(e.data)}),i.promise},this.updateRoles=function(t,r){var i=e.defer();return n.save({id:t,roleIds:r,method:"update-role"},function(e){i.resolve(e)},function(e){i.resolve(e.data)}),i.promise},this.changeStatus=function(t){var i=e.defer();return n["delete"]({id:t,method:"change-status"},function(e){if(e.status)for(var n in r)if(r[n].id==t){r[n].status="yes";break}i.resolve(e)}),i.promise},this.setData=function(e){r=e;for(var t in e)u[e[t].id]=e[t];return r},this.updateShowDueDateUser=function(t){var r=e.defer(),i=new n(t);return i.$save({method:"update-show-due-date-user"},function(e){r.resolve(e)},function(e){r.resolve(e.data)}),r.promise},this}]);var assetmanagerApp=angular.module("assetManager",["ngResource","ui.bootstrap","ngSanitize","ngTable"]);assetmanagerApp.factory("AssetManagerResource",["$resource",function(e){return e("/api/asset-manager/:method/:id",{method:"@method",id:"@id"},{add:{method:"post"},save:{method:"post"},update:{method:"put"},editNameFolder:{method:"edit-name-folder"}})}]).service("AssetManagerService",["AssetManagerResource","$q",function(e,t){var n=this,r=[];this.createFolderProvider=function(r){if("undefined"!=typeof r.id)return n.editFolderAndFile(r);var i=t.defer(),a=new e(r);return a.$save({method:"create-folder"},function(e){i.resolve(e)},function(e){i.resolve(e.data)}),i.promise},this.uploadNewAsset=function(n){var i=t.defer(),a=new e(n);return a.$save({method:"upload-new-asset"},function(e){0!=e.status&&r.push(e.item),i.resolve(e.item)},function(e){i.resolve(e.data)}),i.promise},this.createNewAsset=function(n){var i=t.defer(),a=new e(n);return a.$save({method:"create-new-asset"},function(e){0!=e.status&&r.push(e.item),i.resolve(e.item)},function(e){i.resolve(e.data)}),i.promise},this.saveFieldFile=function(n){var r=t.defer(),i=new e(n);return i.$save({method:"save-file-asset"},function(e){r.resolve(e)},function(e){r.resolve(e.data)}),r.promise},this.editFile=function(n){var r=t.defer(),i=new e(n);return i.$save({method:"edit-file"},function(e){r.resolve(e)},function(e){r.resolve(e.data)}),r.promise},this.crop=function(n){var r=t.defer(),i=new e(n);return i.$save({method:"crop"},function(e){r.resolve(e)},function(e){r.resolve(e.data)}),r.promise},this.addTagsForPage=function(n,r){var i=t.defer(),a=new e(r);return a.$save({id:n,method:"add-tags"},function(e){0!=e.status,i.resolve(e)},function(e){i.resolve(e.data)}),i.promise},this.getAssetManagerById=function(n){var r=t.defer(),i=new e;return i.$get({id:n},function(e){r.resolve(e)},function(e){r.resolve(e.data)}),r.promise},this.setAssetManagers=function(e){return r=e},this.getAssetManagers=function(){return r},this.getUrlImageAsset=function(n){var r=t.defer();return e.get({id:n,method:"get-url-image-asset"},function(e){r.resolve(e)}),r.promise},this.deleteFolderAndAsset=function(n){var r=t.defer(),i=new e;return i.$delete({id:n},function(e){r.resolve(e)},function(e){r.resolve(e.data)}),r.promise},this.deleteAssetFile=function(n){var r=t.defer(),i=new e;return i.$get({id:n,method:"delete-file"},function(e){r.resolve(e)},function(e){r.resolve(e.data)}),r.promise},this.editNameFolder=function(n){var r=t.defer(),i=new e(n);return i.$save({id:n.id,method:"edit-name-folder"},function(e){0!=e.status&&r.resolve(e)},function(e){r.resolve(e.data)}),r.promise},this.updateContentFile=function(n,r){var i=t.defer(),a=new e(r);return a.$save({id:n,method:"update-content-file"},function(e){i.resolve(e)},function(e){i.resolve(e.data)}),i.promise}}]),angular.module("uls").controller("NotificationController",["$scope","$filter","NotificationService","$controller","$timeout",function(e,t,n,r,i){function a(){}function o(){if(c=!1,f.length>0){var e=f.shift();u(e)}}function l(){}function u(t){if(c)return void f.push(t);if(c=!0,-1==t.data.sender_id)var n=e.baseUrl+"/160x160_avatar_default.png?t=1";else var n=e.users_map[t.data.sender_id].avatar;var r=new Notify("Notification",{icon:n,body:t.data.message,tag:t.data.sender_id,notifyShow:a,notifyClose:o,notifyClick:function(){window.location.href="/"+t.data.href},notifyError:l,timeout:5});r.show()}r("BaseController",{$scope:e}),e.callbackLoadUserFinish=function(){},angular.element("#notification-top").removeClass("hidden"),e.baseUrl=window.baseUrl;var s=10;e.limitTo=s;var d=1;e.notifications=[];var f=[],c=!1;e.amount=0,$(".scroll-noti1").scroll(function(){$(this)[0].scrollHeight-$(this).scrollTop()===$(this).outerHeight()&&e.$apply(function(){e.limitTo=e.limitTo+s})});var p=RowboatPusher.subscribe("notification_ticket");p.bind("Rowboat\\Notification\\Events\\Notifications\\Broadcast\\NotificationTicket",function(t){e.$apply(function(){"undefined"!=typeof t.data.user_id&&-1!=t.data.user_id.indexOf(window.userId)&&(u(t),d=1,e.amount++)})}),e.getNotifications=function(){n.query(d).then(function(t){d&&e.setUserReadThisNotification(),e.notifications=t,e.hightlight=angular.copy(e.amount),e.amount=0,d=0})},e.setUserReadThisNotification=function(){n.setRead().then(function(){})},n.getAmountNotificationsNotRead().then(function(t){e.amount=t.result})}]);var permissionModule=angular.module("notification");permissionModule.factory("NotificationResource",["$resource",function(e){return e("/api/notification/:method/:id",{},{add:{method:"post"},save:{method:"post"}})}]).service("NotificationService",["$q","$filter","NotificationResource",function(e,t,n){var r=[];this.getAmountNotificationsNotRead=function(t){var r=e.defer();return n.get({method:"amount-notifications-not-read"},function(e){r.resolve(e)}),r.promise},this.query=function(t){var i=e.defer();return t?n.query().$promise.then(function(e){r=e,i.resolve(r)}):i.resolve(r),i.promise},this.notificationInvite=function(t){var r=e.defer(),i=new n(t);return i.$save({data:t,method:"invite"},function(e){r.resolve(e)},function(e){r.resolve(e.data)}),r.promise},this.setRead=function(){var t=e.defer(),r=new n;return r.$save({method:"set-read"},function(e){t.resolve(e)},function(e){t.resolve(e.data)}),t.promise}}]),notificationModule=angular.module("notification"),notificationModule.directive("notification",[function(){return{restrict:"AE",scope:{item:"="},replace:!0,templateUrl:baseUrl+"/app/shared/notification/views/notification.html",link:function(){}}}]);var module=angular.module("uls");module.directive("rowboatRequired",function(){return{restrict:"A",require:"ngModel",link:function(e,t,n,r){"undefined"==typeof e.$eval(n.ngModel)&&r.$setValidity("rowboatRequired",!1),t.on("focus",function(i){e.$watch(n.ngModel,function(e){var n="undefined"!=typeof e&&0!=e.length;if(n)t.parent().find("span").remove(),t.parent().removeClass("error"),r.$setValidity("rowboatRequired",n);else if(0==t.parent().find("span").length){t.parent().addClass("error");var i='<span class="control-label">It is required</span>';t.parent().append(i),r.$setValidity("rowboatRequired",n)}})})}}}),module.directive("rowboatLength",function(){return{restrict:"A",require:"ngModel",link:function(e,t,n,r){"undefined"!=typeof e.$eval(n.ngModel)&&e.$eval(n.ngModel).length!=n.rowboatLength&&r.$setValidity("rowboatLength",!1),t.on("focus",function(i){e.$watch(n.ngModel,function(e){var i=n.rowboatLength,a="undefined"!=typeof e&&e.length==i;if(a)t.parent().find("span").remove(),t.parent().removeClass("error"),r.$setValidity("rowboatLength",a);else if(0==t.parent().find("span").length){t.parent().addClass("error");var o='<span class="control-label">Length is '+i+"</span>";t.parent().append(o),r.$setValidity("rowboatLength",a)}})})}}}),module.directive("rowboatMinLength",function(){return{restrict:"A",require:"ngModel",link:function(e,t,n,r){"undefined"!=typeof e.$eval(n.ngModel)&&e.$eval(n.ngModel).length<n.rowboatMinLength&&r.$setValidity("rowboatMinLength",!1),t.on("focus",function(i){e.$watch(n.ngModel,function(e){var i=n.rowboatMinLength,a="undefined"!=typeof e&&e.length>=i;if(a)t.parent().find("span").remove(),t.parent().removeClass("error"),r.$setValidity("rowboatMinLength",a);else if(0==t.parent().find("span").length){t.parent().addClass("error");var o='<span class="control-label">Min length is '+i+"</span>";t.parent().append(o),r.$setValidity("rowboatMinLength",a)}})})}}}),module.directive("rowboatMaxLength",function(){return{restrict:"A",require:"ngModel",link:function(e,t,n,r){"undefined"!=typeof e.$eval(n.ngModel)&&e.$eval(n.ngModel).length>n.rowboatMaxLength&&r.$setValidity("rowboatMaxLength",!1),t.on("focus",function(i){e.$watch(n.ngModel,function(e){var i=n.rowboatMaxLength,a="undefined"!=typeof e&&e.length<=i;if(a)t.parent().find("span").remove(),t.parent().removeClass("error"),r.$setValidity("rowboatMaxLength",a);else if(0==t.parent().find("span").length){t.parent().addClass("error");var o='<span class="control-label">Max length is '+i+"</span>";t.parent().append(o),r.$setValidity("rowboatMaxLength",a)}})})}}}),module.directive("rowboatEmailPattern",function(){return{restrict:"A",require:"ngModel",link:function(e,t,n,r){$pattern=/^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/,"undefined"==typeof e.$eval(n.ngModel)&&r.$setValidity("rowboatEmailPattern",!1),t.on("blur",function(i){e.$watch(n.ngModel,function(e){var n="undefined"!=typeof e&&$pattern.test(e);if(n)t.parent().find("span").remove(),t.parent().removeClass("error"),r.$setValidity("rowboatEmailPattern",n);else if(0==t.parent().find("span").length){t.parent().addClass("error");var i='<span class="control-label">Email Invalid</span>';t.parent().append(i),r.$setValidity("rowboatEmailPattern",n)}})})}}});var filterDate=angular.module("customFormatDate",[]);filterDate.filter("myDate",["$filter",function(e){return function(t,n){if(null==t)return"";if("Invalid Date"==new Date(t))for(;-1!=String(t).indexOf("-");)t=t.replace("-","/");if("Invalid Date"==new Date(t))return"";var r=e("date")(new Date(String(t)),angular.isUndefined(n)?"MM-dd-yyyy":n);return String(r)}}]).filter("myDateL",["$filter",function(e){return function(t){if(null==t)return"";if("Invalid Date"==new Date(t))for(;-1!=String(t).indexOf("-");)t=t.replace("-","/");if("Invalid Date"==new Date(t))return"";var n=e("date")(new Date(String(t)),"MMMM d, y");return String(n)}}]).filter("myDateTime",["$filter",function(e){return function(t){if(null==t)return"";if("0000-00-00 00:00:00"==t)return"";if("Invalid Date"==new Date(t))for(;-1!=String(t).indexOf("-");)t=t.replace("-","/");if("Invalid Date"==new Date(t))return"";var n=e("date")(new Date(String(t)),"MM-dd-yyyy HH:mm:ss");return String(n)}}]).filter("myDateShortTime",["$filter",function(e){return function(t){if(null==t)return"";if("0000-00-00 00:00:00"==t)return"";if("Invalid Date"==new Date(t))for(;-1!=String(t).indexOf("-");)t=t.replace("-","/");if("Invalid Date"==new Date(t))return"";var n=e("date")(new Date(String(t)),"MM-dd-yyyy h:mma");return String(n)}}]).filter("clientDate",["$filter",function(e){return function(t,n){if(null==t)return"";if("0000-00-00 00:00:00"==t)return"";if("Invalid Date"==new Date(t))for(;-1!=String(t).indexOf("-");)t=t.replace("-","/");if("Invalid Date"==new Date(t))return"";t=new Date(t),t=new Date(parseInt(new Date(t).getTime())-60*parseInt((new Date).getTimezoneOffset())*1e3);var r=e("date")(new Date(String(t)),angular.isUndefined(n)?"MM-dd-yyyy":n);return String(r)}}]).filter("clientDateTime",["$filter",function(e){return function(t){return e("date")(checkInvalid(t),window.dateTimeFormat)}}]).filter("clientLogDate",["$filter",function(e){return function(t){return e("date")(checkInvalid(t),window.logDate)}}]).filter("clientMediumDate",["$filter",function(e){return function(t){return e("date")(checkInvalid(t),window.mediumDate)}}]).filter("clientShortTime",["$filter",function(e){return function(t){return e("date")(checkInvalid(t),window.shortTime)}}]).filter("clientShortTimeFollowTimezone",["$filter",function(e){return function(t,n){if(null==t)return"";if("Invalid Date"==new Date(t))for(;-1!=String(t).indexOf("-");)t=t.replace("-","/");if("Invalid Date"==new Date(t))return"";var r=e("date")(new Date(String(t)),window.shortTime);return String(r)}}]).filter("formatCurrentDate",["$filter",function(e){return function(e){if(e=checkInvalid(e),!e)return"";e=new Date(e);var t=e.getMonth()+"-"+e.getDate()+"-"+e.getFullYear();return String(t)}}]).filter("formatCurrentTime",["$filter",function(e){return function(e){if(e=checkInvalid(e),!e)return"";e=new Date(e);var t=e.getHours()>=12?"pm":"am",n=parseInt(e.getHours())%12;n=n?10>n?"0"+n:n:12;var r=parseInt(e.getMinutes())<10?"0"+e.getMinutes():e.getMinutes(),i=parseInt(e.getSeconds())<10?"0"+e.getSeconds():e.getSeconds(),a=n+"-"+r+"-"+i+" "+t;return String(a)}}]).filter("formatCurrentShortTime",["$filter",function(e){return function(e){if(e=checkInvalid(e),!e)return"";e=new Date(e);var t=e.getHours()>=12?"pm":"am",n=parseInt(e.getHours())%12;n=n?10>n?"0"+n:n:12;var r=parseInt(e.getMinutes())<10?"0"+e.getMinutes():e.getMinutes(),i=n+":"+r+" "+t;return String(i)}}]);var checkInvalid=function(e,t){if(null==e)return"";if("Invalid Date"==new Date(e))for(;-1!=String(e).indexOf("-");)e=e.replace("-","/");return"Invalid Date"==new Date(e)?"":(e=new Date(e),e=new Date(parseInt(new Date(e).getTime())-60*parseInt((new Date).getTimezoneOffset())*1e3),new Date(String(e)))};angular.module("nlcFilter").filter("elapsedtime",function(){return function(e){return humanized_time_span(e)}});var translation=angular.module("translation",[]);translation.filter("trans",["$filter",function(e){return function(e,t){return null==e?"":window.translations[t][e]}}]);var selectLevel=angular.module("helpEditorDirective",[]),version=5;selectLevel.directive("helpEditorDirective",["$timeout","$filter",function(e,t){return{require:"?ngModel",restrict:"EA",scope:{items:"=",text:"@",selectedItems:"=selectedItem",onClick:"&"},replace:!0,templateUrl:baseUrl+"/app/components/user/help-editor/view/view-help.html?v="+(new Date).getTime(),link:function(t,n,r,i){t.description="",t.recursiveGetDescription=function(e){angular.forEach(e,function(e,n){e.parent=!1,t.description+='<strong class="space-topic" id="_'+e._id+'">'+e.name+"</strong>"+e.description,e.subFolder.length>0&&t.recursiveGetDescription(e.subFolder)})},t.getDesctiption=function(){angular.forEach(t.items,function(e,n){e.parent=!0,t.description+='<h4 id="_'+e._id+'" class="c-primary">'+e.name+'</h4><div class="space-area user-ad-area">'+e.description,t.recursiveGetDescription(e.subFolder),t.description+="</div>"})},t.getDesctiption(),t.goToAnchorWithId=function(e){window.location.href="#"+e,$("#fix-modal-top").scrollTop(0)},e(function(){$(".sub-select-"+t.items[0]._id).addClass("in")})}}}]);var dataOption=angular.module("filed");dataOption.controller("filedController",["$scope","$compile","filedService","filedTypeService","$filter","ngTableParams","$filter","$timeout","$controller",function(e,t,n,r,i,a,i,o,l){l("BaseController",{$scope:e}),angular.element(".wrap-branch").removeClass("hidden"),e.callbackLoadUserFinish=function(){},e.dataOption=0,e.fields=angular.copy(n.setFields(window.fields)),e.listRequiredFieldType_Map=window.listRequiredFieldType_Map,e.getAllField=function(){e.tableParams=new a({page:1,count:10},{total:e.fields.length,getData:function(t,n){var r=n.sorting()?i("orderBy")(e.fields,e.tableParams.orderBy()):e.fields;t.resolve(r.slice((n.page()-1)*n.count(),n.page()*n.count()))}})},e.deleteField=function(t){confirm("All changes will be lost if this is changed. Do you want to proceed?")&&n.remove(t).then(function(){e.fields=n.getFields(),e.tableParams.reload()})}}]).controller("createFiledController",["$scope","$timeout","$filter","filedService","filedTypeService",function(e,t,n,r,a){e.field=window.field,e.openedLimitDate=!1,e.listType=window.listType,window.formatDate&&(1==window.formatDate?e.formatDate="yyyy-MM-dd":e.formatDate=window.formatDate),e.lengthAttribute=function(){var t="",n="";e.validateLength=!1;for(i in e.field.html_attributes)"minlength"==e.field.html_attributes[i].key&&e.field.html_attributes[i].value&&(t=e.field.html_attributes[i].value),"maxlength"==e.field.html_attributes[i].key&&e.field.html_attributes[i].value&&(n=e.field.html_attributes[i].value);t&&n&&t>n&&(e.validateLength=!0)},e.changeDate=function(){var t="",n="";e.checkDate=!1;for(i in e.field.html_attributes)"min-date"!=e.field.html_attributes[i].key&&"min"!=e.field.html_attributes[i].key||!e.field.html_attributes[i].value||(t=e.field.html_attributes[i].value),"max-date"!=e.field.html_attributes[i].key&&"max"!=e.field.html_attributes[i].key||!e.field.html_attributes[i].value||(n=e.field.html_attributes[i].value);if(n&&t){var r=new Date(t),a=new Date(n);r>a&&(e.checkDate=!0)}},e.createField=function(a,o){if(e.submitted=!0,!e.checkDate&&!e.validateLength&&!a){angular.element("#bt-submit").attr("disabled","true"),angular.element("#bt-submit-new").attr("disabled","true");for(i in e.field.html_attributes)"min-date"!=e.field.html_attributes[i].key&&"max-date"!=e.field.html_attributes[i].key||(e.field.html_attributes[i].value=n("date")(e.field.html_attributes[i].value,"yyyy-MM-dd")),""==e.field.html_attributes[i].value&&delete e.field.html_attributes[i];r.create(e.field).then(function(n){0==n.status?(e.error="Name is Exist",angular.element("#bt-submit").removeAttr("disabled"),angular.element("#bt-submit-new").removeAttr("disabled")):e.field._id?window.location=window.baseUrl+"/admin/field":o?(e.field={},e.filedTypeAttributes={},e.submitted=!1,e.errorMessage=!0,angular.element("#bt-submit").removeAttr("disabled"),angular.element("#bt-submit-new").removeAttr("disabled"),t(function(){$(".select-field-type").select2("val","")}),t(function(){e.errorMessage=!1},5e3)):window.location=window.baseUrl+"/admin/field"})}},t(function(){$(".select-field-type").select2()}),e.getFieldAttributes=function(){angular.isDefined(e.field)||(e.field={}),e.field.html_attributes={},"undefined"!=typeof e.field.field_type_id&&a.getFieldAttributes(e.field.field_type_id).then(function(t){e.formatDate="",t.formatDate&&(1==t.formatDate?e.formatDate="yyyy-MM-dd":e.formatDate=t.formatDate);for(var n in t.filedTypeAttributes)e.field.html_attributes[n]={},1!=t.filedTypeAttributes[n].value&&(0==t.filedTypeAttributes[n].value.indexOf("&")?(t.filedTypeAttributes[n].attr="&",e.field.html_attributes[n].orveride="&",t.filedTypeAttributes[n].value=t.filedTypeAttributes[n].value.replace("&","")):0==t.filedTypeAttributes[n].value.indexOf("*")&&(t.filedTypeAttributes[n].attr="*",e.field.html_attributes[n].orveride="*",t.filedTypeAttributes[n].value=t.filedTypeAttributes[n].value.replace("*","")),e.field.html_attributes[n].key=t.filedTypeAttributes[n].key,e.field.html_attributes[n].value=t.filedTypeAttributes[n].value);e.field.html_attributes=t.filedTypeAttributes,e.field.term=t.term}).then(function(){})}}]);var typeModule=angular.module("filed");typeModule.factory("filedResource",["$resource",function(e){return e("/api/field/:method/:id",{method:"@method",id:"@id"},{add:{method:"post"},save:{method:"post"},update:{method:"put"}})}]).service("filedService",["$q","$filter","filedResource",function(e,t,n){var r=this,i=[];this.create=function(t){if("undefined"!=typeof t._id)return r.update(t);var i=e.defer(),a=new n(t);return a.$save({},function(e){i.resolve(e)},function(e){i.resolve(e)}),i.promise},this.update=function(t){var r=e.defer(),i=new n(t);return i.$update({id:t._id},function(e){r.resolve(e)},function(e){r.resolve(e.data)}),r.promise},this.remove=function(t){var r=e.defer();return n["delete"]({id:t},function(e){r.resolve(e)}),r.promise},this.remove=function(t){var r=e.defer(),a=new n;return a.$delete({id:t},function(e){if(0!=e.status)for(var n in i)if(i[n]._id==t){i.splice(n,1);break}r.resolve(e)},function(e){r.resolve(e.data)}),r.promise},this.setFields=function(e){return i=e},this.getFields=function(e){return i}}]);var typeModule=angular.module("filedType");typeModule.factory("filedTypeResource",["$resource",function(e){return e("/api/field-type/:method/:id",{
method:"@method",id:"@id"},{add:{method:"post"},save:{method:"post"},update:{method:"put"}})}]).service("filedTypeService",["$q","$filter","filedTypeResource",function(e,t,n){var r=this,i=[];this.query=function(){var t=e.defer();return n.query(function(e){t.resolve(e)}),t.promise},this.create=function(t){if("undefined"!=typeof t._id)return r.update(t);var i=e.defer(),a=new n(t);return a.$save({},function(e){i.resolve(e)},function(e){i.resolve(e)}),i.promise},this.update=function(t){var r=e.defer(),i=new n(t);return i.$update({id:t._id},function(e){r.resolve(e)},function(e){r.resolve(e.data)}),r.promise},this.changeCategory=function(t){var r=e.defer();return n.get({id:t,method:"get-category"},function(e){r.resolve(e)}),r.promise},this.changeOutputType=function(t){var r=e.defer();return n.get({id:t,method:"get-output-type"},function(e){r.resolve(e)}),r.promise},this.remove=function(t){var r=e.defer();return n["delete"]({id:t},function(e){r.resolve(e)}),r.promise},this.getFieldAttributes=function(t){var r=e.defer();return n.get({id:t,method:"get-field-attributes"},function(e){r.resolve(e)}),r.promise},this.remove=function(t){var r=e.defer(),a=new n;return a.$delete({id:t},function(e){if(0!=e.status)for(var n in i)if(i[n]._id==t){i.splice(n,1);break}r.resolve(e)},function(e){r.resolve(e.data)}),r.promise},this.setFieldTypes=function(e){return i=e},this.getFieldTypes=function(e){return i}}]);