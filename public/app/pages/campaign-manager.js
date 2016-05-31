function humanized_time_span(e,t,n,a){function r(){for(var e=0;e<n[u].length;e++)if(null==n[u][e].ceiling||s<=n[u][e].ceiling)return n[u][e];return null}function i(){for(var e=s,t={},n=0;n<a.length;n++){var r=Math.floor(e/a[n][0]);e-=a[n][0]*r,t[a[n][1]]=r}return t}function o(e){var t=i(),n=e.text.replace(/\$(\w+)/g,function(){return t[arguments[1]]});return l(n,t)}function l(e,t){for(var n in t)if(1==t[n]){var a=new RegExp("\\b"+n+"\\b");e=e.replace(a,function(){return arguments[0].replace(/s\b/g,"")})}return e}if(n=n||{past:[{ceiling:60,text:"$seconds seconds ago"},{ceiling:3600,text:"$minutes minutes ago"},{ceiling:86400,text:"$hours hours ago"},{ceiling:2629744,text:"$days days ago"},{ceiling:31556926,text:"$months months ago"},{ceiling:null,text:"$years years ago"}],future:[{ceiling:60,text:"in $seconds seconds"},{ceiling:3600,text:"in $minutes minutes"},{ceiling:86400,text:"in $hours hours"},{ceiling:2629744,text:"in $days days"},{ceiling:31556926,text:"in $months months"},{ceiling:null,text:"in $years years"}]},a=a||[[31556926,"years"],[2629744,"months"],[86400,"days"],[3600,"hours"],[60,"minutes"],[1,"seconds"]],"Invalid Date"==new Date(e))for(;-1!=String(e).indexOf("-");)e=e.replace("-","/");e=new Date(e),t=t?new Date(t):new Date;var s=(t-e)/1e3,u="past";return 0>s&&(u="future",s=0-s),o(r())}angular.module("user",[]),angular.module("permission",[]),angular.module("role",[]),angular.module("multiSelect",[]),angular.module("ticket",[]),angular.module("type",[]),angular.module("dataOption",[]),angular.module("nlcFilter",[]),angular.module("file",[]),angular.module("AppLanguage",[]),angular.module("TemplateManagerApp",[]),angular.module("RegionApp",[]),angular.module("campaignApp",[]),angular.module("campaignDetailApp",[]),angular.module("MarketsegmentApp",[]),angular.module("notification",[]),angular.module("transApp",[]),angular.module("assetManager",[]),angular.module("BlockApp",[]),angular.module("ChannelPartnersApp",[]),angular.module("roleGroup1",[]),angular.module("filedType",[]),angular.module("filed",[]),angular.module("term",[]),angular.module("customFormatDate",[]),angular.module("SeoAnalysisApp",[]),angular.module("pageApp",[]),angular.module("treeresizer",[]),angular.module("CreatePageApp",[]),angular.module("EditDraftApp",[]),angular.module("fomatHtml",[]),angular.module("colorpicker.module",[]),angular.module("formBuilderDirectiveApp",[]),angular.module("appManageTerm",[]),angular.module("TermTemplateManagerApp",[]),angular.module("configurator",[]),angular.module("TemplateContentManager",[]),angular.module("cmsContentFolderApp",[]),angular.module("lowercaseCharater",[]),angular.module("selectLevel",[]),angular.module("modalSelectLevel",[]),angular.module("configField",[]),angular.module("cmsContentInsertApp",[]),angular.module("confirmDirective",[]),angular.module("CmsApp",[]),angular.module("checkLimitAndChangeDateTimeDirectiveApp",[]),angular.module("tagContentApp",[]),angular.module("tagContentDirective",[]),angular.module("cmsContentTagApp",[]),angular.module("viewDraft",[]),angular.module("databaseManager",[]),angular.module("selectLevelDatabase",[]),angular.module("modalSelectPage",[]),angular.module("configFormDatabaseApp",[]),angular.module("historyApp",[]),angular.module("BlockNestedApp",[]),angular.module("selectLevelAsset",[]),angular.module("MaterialApp",[]),angular.module("draganddrop",[]),angular.module("activityLog",[]),angular.module("translation",[]),angular.module("HelpEditorApp",[]),angular.module("helpEditorDirective",[]),angular.module("selectLevelHelp",[]),angular.module("cache",[]),angular.module("file",[]),angular.module("treeresize",[]),angular.module("test",[]),angular.module("guide",[]),angular.module("PlatformsApp",[]),angular.module("accessories",[]);var defaultModules=["ui.bootstrap","ngResource","ngCookies","ngFileUpload","ngRoute","toggle-switch","ngImgCrop","ngTable","user","role","permission","multiSelect","ticket","type","dataOption","nlcFilter","file","xeditable","timer","AppLanguage","TemplateManagerApp","RegionApp","campaignApp","campaignDetailApp","MarketsegmentApp","notification","transApp","assetManager","BlockApp","ChannelPartnersApp","roleGroup1","filedType","filed","term","ui-iconpicker","customFormatDate","SeoAnalysisApp","pageApp","treeresizer","CreatePageApp","EditDraftApp","fomatHtml","colorpicker.module","formBuilderDirectiveApp","appManageTerm","TermTemplateManagerApp","mgo-angular-wizard","configurator","TemplateContentManager","cmsContentFolderApp","lowercaseCharater","selectLevel","configField","cmsContentInsertApp","confirmDirective","CmsApp","checkLimitAndChangeDateTimeDirectiveApp","tagContentApp","tagContentDirective","cmsContentTagApp","viewDraft","modalSelectLevel","databaseManager","selectLevelDatabase","modalSelectPage","configFormDatabaseApp","historyApp","BlockNestedApp","selectLevelAsset","MaterialApp","ui.sortable","activityLog","translation","HelpEditorApp","helpEditorDirective","selectLevelHelp","cache","file","treeresize","guide","PlatformsApp","accessories"];"undefined"!=typeof modules&&(defaultModules=defaultModules.concat(modules));var myApp=angular.module("uls",defaultModules);angular.module("uls").run(["editableOptions",function(e){e.theme="bs3"}]),angular.module("uls").config(["$logProvider",function(e){e.debugEnabled(window.debug)}]),"undefined"!=typeof angularMock&&(defaultModules=defaultModules.concat(angularMock));var goTo=function(e){window.location.href="#_"+e,$("#fix-modal-top").scrollTop(0),$("#"+e).hasClass("in")||$("#"+e).prev().trigger("click")};myApp.config(["$httpProvider",function(e){e.interceptors.push(["$q",function(e){e.defer();return{responseError:function(t){var n=angular.element(".butterbar-container");switch(t.status){case 401:return void(window.location.href=window.baseUrl);case 404:n.hasClass("hidden")&&n.removeClass("hidden");break;case 500:n.hasClass("hidden")&&n.removeClass("hidden")}return e.reject(t)}}}])}]),function(e){function t(){var t=window.innerHeight;screen.height;e(".table-responsive.set-height, .table-responsive#tb-group-user").css({height:t-170+"px"}),e(".table-animate").css({height:t-170+"px"}),e("#search-page,.box-maps").css({height:t-105+"px"}),e(".box-list-rep").css({height:t-100+"px"}),e("#load-maps").css({height:t-185+"px"})}e(document).ready(t),e(window).resize(t),e(document).ready(function(){e(".dropdown-menu table tr td button").removeAttr("style")}),e(document).ready(function(){setTimeout(function(){var t=e("#frame_html").contents().find("head");t.append('<style type="text/css">.area_toolbar{background-color:#f1f1f1;}#editor{border:solid #ccc 1px}#result{border-top:solid #ccc 1px;border-bottom: solid #ccc 1px}.editarea_popup{box-shadow: 0px 4px 36px rgba(177, 177, 177, 0.75);border: solid 1px #CCCCCC;background-color: #FFFFFF;}.area_toolbar select{font-size:9pt;background-color:#fff}</style>')},1e3)}),e(window).load(function(){e(".step3 .show-more").click(function(){e(".step3 .wrap-more-product").toggleClass("show")})}),e(document).ready(function(){e(".nav-icon").click(function(){e(this).toggleClass("open"),e("#pagehome").toggleClass("on-off")})});var n,a,r,i,o,l,s;e(".next").click(function(){return s?!1:(s=!0,n=e(this).parent(),a=e(this).parent().next(),a.show(),void n.animate({opacity:0},{step:function(e,t){l=1-.2*(1-e),i=50*e+"%",o=1-e,n.css({transform:"scale("+l+")"}),a.css({left:i,opacity:o})},duration:800,complete:function(){n.hide(),s=!1},easing:"easeInOutBack"}))}),e(".previous").click(function(){return s?!1:(s=!0,n=e(this).parent(),r=e(this).parent().prev(),r.show(),void n.animate({opacity:0},{step:function(e,t){l=.8+.2*(1-e),i=50*(1-e)+"%",o=1-e,n.css({left:i}),r.css({transform:"scale("+l+")",opacity:o})},duration:800,complete:function(){n.hide(),s=!1},easing:"easeInOutBack"}))}),e(".submit").click(function(){return!1})}(jQuery),angular.module("uls").controller("BaseController",["$scope","$parse","$timeout","$modal","UserService","AssetManagerService",function(e,t,n,a,r,i){if(angular.element(".wrapper").removeClass("hidden"),r.setData(window.usersMap),n(function(){"undefined"!=typeof e.callbackLoadUserFinish&&(e.callbackLoadUserFinish(),e.users_map=r.getUsersMap())}),e.testFuture=window.testFuture,1==e.testFuture&&angular.element(".test").removeClass("hidden"),e.windowType=window.info,"undefined"!=typeof window.info)for(var o in window.info){var l=t(o);l.assign(e,window.info[o])}e.initDate=function(){angular.element(".date").bdatepicker({format:"yyyy-mm-dd"})},e.viewModalImage=function(e){var t=a.open({templateUrl:baseUrl+"/app/components/termTemplateManager/views/modal/viewImage.html",controller:"ModalViewPictureCtrl",size:void 0,windowClass:"show-img",resolve:{fileId:function(){return e}}});t.result.then(function(e){},function(){})},e.urlForm=[],e.getUrlImageAssetForm=function(t,n){"undefined"==typeof e.urlForm[t]&&(e.urlForm[t]=[]),i.getUrlImageAsset(t).then(function(a){e.urlForm[t][n]=a.url})},e.removeThumbnailAssertForm=function(t,n){e.urlForm[t][n]=""},e.initTooltip=function(e){$('[data-toggle="tooltip"]').tooltip()}}]).controller("ModalViewPictureCtrl",["$scope","$modalInstance","fileId",function(e,t,n){e.fileId=n,e.baseUrl=baseUrl,e.cancel=function(){t.dismiss("cancel")}}]);var userModule=angular.module("user");userModule.factory("UserResource",["$resource",function(e){return e("/api/user/:method/:id",{method:"@method",id:"@id"},{add:{method:"post"},save:{method:"post"},update:{method:"put"}})}]).factory("UserService",["$q","$filter","UserResource",function(e,t,n){var a=[],r=[],i=[],o=this,l={},s={};return this.setHashData=function(e){l=e},this.create=function(t){if("undefined"!=typeof t.id)return o.update(t);var r=e.defer(),i=new n(t);return i.$save({},function(e){e.status&&e.item&&(a.push(e.item),"undefined"==typeof e.item.last_login&&(e.item.last_login="0000-00-00 00:00:00")),r.resolve(e)},function(e){r.resolve(e.data)}),r.promise},this.changePassword=function(t){var a=e.defer(),r=new n(t);return r.$save({method:"change-password",id:t.id},function(e){e.status?a.resolve(e):a.reject(e)},function(e){a.reject(e.data)}),a.promise},this.changeRoles=function(t){var a=e.defer(),r=new n(t);return r.$save({method:"change-roles"},function(e){e?a.resolve(e):a.reject(e)},function(e){a.reject(e.data)}),a.promise},this.update=function(t){var r=e.defer(),i=new n(t);return i.$update({id:t.id},function(e){if(e.status)for(var t in a)if(a[t].id==e.item.id){a[t]=e.item;break}r.resolve(e)},function(e){r.resolve(e.data)}),r.promise},this.get=function(t){var a=e.defer();return n.get({id:t},function(e){a.resolve(e)}),a.promise},this.query=function(){var t=e.defer();return n.query(function(e){a=e,t.resolve(e)}),t.promise},this.queryUsersManager=function(){var t=e.defer();return n.query({method:"get-all-user-manager"},function(e){a=e,t.resolve(e)}),t.promise},this.remove=function(t){var r=e.defer();return n["delete"]({id:t},function(e){if(e.status)for(var n in a)if(a[n].id==t){a[n].status="no";break}r.resolve(e)}),r.promise},this.pushUser=function(e){a.push(e)},this.updateUser=function(e){for(var t in a)if(a[t].id==e.id){e.status="yes",a[t]=e;break}},this.changeAvatar=function(t,a){var r=e.defer();return n.save({method:"change-avatar",file:a,id:t},function(e){r.resolve(e)},function(e){r.resolve(e.data)}),r.promise},this.resetPassword=function(t){var a=e.defer();return n.save({method:"email",entity:"password",email:t},function(e){a.resolve(e)},function(e){a.resolve(e.data)}),a.promise},this.getUsers=function(){return a},this.getUserById=function(e){return s[e]},this.getUsersMap=function(){return s},this.listMap=function(e,t){if("role"==t)for(var n in e)r[e[n].id]=e[n];else for(var n in e)i[e[n].id]=e[n]},this.getMap=function(e){return"role"==e?r:i},this.userBranchManager=function(t){var a=e.defer();return n.query({id:t,method:"get-users-branch-manager"},function(e){a.resolve(e)}),a.promise},this.updatePermissions=function(t,a){var r=e.defer();return n.save({id:t,permissionIds:a,method:"update-permission"},function(e){r.resolve(e)},function(e){r.resolve(e.data)}),r.promise},this.updateGroup=function(t,a){var r=e.defer();return n.save({id:t,groupIds:a,method:"update-group"},function(e){r.resolve(e)},function(e){r.resolve(e.data)}),r.promise},this.updateRoles=function(t,a){var r=e.defer();return n.save({id:t,roleIds:a,method:"update-role"},function(e){r.resolve(e)},function(e){r.resolve(e.data)}),r.promise},this.changeStatus=function(t){var r=e.defer();return n["delete"]({id:t,method:"change-status"},function(e){if(e.status)for(var n in a)if(a[n].id==t){a[n].status="yes";break}r.resolve(e)}),r.promise},this.setData=function(e){a=e;for(var t in e)s[e[t].id]=e[t];return a},this.updateShowDueDateUser=function(t){var a=e.defer(),r=new n(t);return r.$save({method:"update-show-due-date-user"},function(e){a.resolve(e)},function(e){a.resolve(e.data)}),a.promise},this}]);var assetmanagerApp=angular.module("assetManager",["ngResource","ui.bootstrap","ngSanitize","ngTable"]);assetmanagerApp.factory("AssetManagerResource",["$resource",function(e){return e("/api/asset-manager/:method/:id",{method:"@method",id:"@id"},{add:{method:"post"},save:{method:"post"},update:{method:"put"},editNameFolder:{method:"edit-name-folder"}})}]).service("AssetManagerService",["AssetManagerResource","$q",function(e,t){var n=this,a=[];this.createFolderProvider=function(a){if("undefined"!=typeof a.id)return n.editFolderAndFile(a);var r=t.defer(),i=new e(a);return i.$save({method:"create-folder"},function(e){r.resolve(e)},function(e){r.resolve(e.data)}),r.promise},this.uploadNewAsset=function(n){var r=t.defer(),i=new e(n);return i.$save({method:"upload-new-asset"},function(e){0!=e.status&&a.push(e.item),r.resolve(e.item)},function(e){r.resolve(e.data)}),r.promise},this.createNewAsset=function(n){var r=t.defer(),i=new e(n);return i.$save({method:"create-new-asset"},function(e){0!=e.status&&a.push(e.item),r.resolve(e.item)},function(e){r.resolve(e.data)}),r.promise},this.saveFieldFile=function(n){var a=t.defer(),r=new e(n);return r.$save({method:"save-file-asset"},function(e){a.resolve(e)},function(e){a.resolve(e.data)}),a.promise},this.editFile=function(n){var a=t.defer(),r=new e(n);return r.$save({method:"edit-file"},function(e){a.resolve(e)},function(e){a.resolve(e.data)}),a.promise},this.crop=function(n){var a=t.defer(),r=new e(n);return r.$save({method:"crop"},function(e){a.resolve(e)},function(e){a.resolve(e.data)}),a.promise},this.addTagsForPage=function(n,a){var r=t.defer(),i=new e(a);return i.$save({id:n,method:"add-tags"},function(e){0!=e.status,r.resolve(e)},function(e){r.resolve(e.data)}),r.promise},this.getAssetManagerById=function(n){var a=t.defer(),r=new e;return r.$get({id:n},function(e){a.resolve(e)},function(e){a.resolve(e.data)}),a.promise},this.setAssetManagers=function(e){return a=e},this.getAssetManagers=function(){return a},this.getUrlImageAsset=function(n){var a=t.defer();return e.get({id:n,method:"get-url-image-asset"},function(e){a.resolve(e)}),a.promise},this.deleteFolderAndAsset=function(n){var a=t.defer(),r=new e;return r.$delete({id:n},function(e){a.resolve(e)},function(e){a.resolve(e.data)}),a.promise},this.deleteAssetFile=function(n){var a=t.defer(),r=new e;return r.$get({id:n,method:"delete-file"},function(e){a.resolve(e)},function(e){a.resolve(e.data)}),a.promise},this.editNameFolder=function(n){var a=t.defer(),r=new e(n);return r.$save({id:n.id,method:"edit-name-folder"},function(e){0!=e.status&&a.resolve(e)},function(e){a.resolve(e.data)}),a.promise},this.updateContentFile=function(n,a){var r=t.defer(),i=new e(a);return i.$save({id:n,method:"update-content-file"},function(e){r.resolve(e)},function(e){r.resolve(e.data)}),r.promise}}]),angular.module("uls").controller("NotificationController",["$scope","$filter","NotificationService","$controller","$timeout",function(e,t,n,a,r){function i(){}function o(){if(f=!1,c.length>0){var e=c.shift();s(e)}}function l(){}function s(t){if(f)return void c.push(t);if(f=!0,-1==t.data.sender_id)var n=e.baseUrl+"/160x160_avatar_default.png?t=1";else var n=e.users_map[t.data.sender_id].avatar;var a=new Notify("Notification",{icon:n,body:t.data.message,tag:t.data.sender_id,notifyShow:i,notifyClose:o,notifyClick:function(){window.location.href="/"+t.data.href},notifyError:l,timeout:5});a.show()}a("BaseController",{$scope:e}),e.callbackLoadUserFinish=function(){},angular.element("#notification-top").removeClass("hidden"),e.baseUrl=window.baseUrl;var u=10;e.limitTo=u;var d=1;e.notifications=[];var c=[],f=!1;e.amount=0,$(".scroll-noti1").scroll(function(){$(this)[0].scrollHeight-$(this).scrollTop()===$(this).outerHeight()&&e.$apply(function(){e.limitTo=e.limitTo+u})});var p=RowboatPusher.subscribe("notification_ticket");p.bind("Rowboat\\Notification\\Events\\Notifications\\Broadcast\\NotificationTicket",function(t){e.$apply(function(){"undefined"!=typeof t.data.user_id&&-1!=t.data.user_id.indexOf(window.userId)&&(s(t),d=1,e.amount++)})}),e.getNotifications=function(){n.query(d).then(function(t){d&&e.setUserReadThisNotification(),e.notifications=t,e.hightlight=angular.copy(e.amount),e.amount=0,d=0})},e.setUserReadThisNotification=function(){n.setRead().then(function(){})},n.getAmountNotificationsNotRead().then(function(t){e.amount=t.result})}]);var permissionModule=angular.module("notification");permissionModule.factory("NotificationResource",["$resource",function(e){return e("/api/notification/:method/:id",{},{add:{method:"post"},save:{method:"post"}})}]).service("NotificationService",["$q","$filter","NotificationResource",function(e,t,n){var a=[];this.getAmountNotificationsNotRead=function(t){var a=e.defer();return n.get({method:"amount-notifications-not-read"},function(e){a.resolve(e)}),a.promise},this.query=function(t){var r=e.defer();return t?n.query().$promise.then(function(e){a=e,r.resolve(a)}):r.resolve(a),r.promise},this.notificationInvite=function(t){var a=e.defer(),r=new n(t);return r.$save({data:t,method:"invite"},function(e){a.resolve(e)},function(e){a.resolve(e.data)}),a.promise},this.setRead=function(){var t=e.defer(),a=new n;return a.$save({method:"set-read"},function(e){t.resolve(e)},function(e){t.resolve(e.data)}),t.promise}}]),notificationModule=angular.module("notification"),notificationModule.directive("notification",[function(){return{restrict:"AE",scope:{item:"="},replace:!0,templateUrl:baseUrl+"/app/shared/notification/views/notification.html",link:function(){}}}]);var module=angular.module("uls");module.directive("rowboatRequired",function(){return{restrict:"A",require:"ngModel",link:function(e,t,n,a){"undefined"==typeof e.$eval(n.ngModel)&&a.$setValidity("rowboatRequired",!1),t.on("focus",function(r){e.$watch(n.ngModel,function(e){var n="undefined"!=typeof e&&0!=e.length;if(n)t.parent().find("span").remove(),t.parent().removeClass("error"),a.$setValidity("rowboatRequired",n);else if(0==t.parent().find("span").length){t.parent().addClass("error");var r='<span class="control-label">It is required</span>';t.parent().append(r),a.$setValidity("rowboatRequired",n)}})})}}}),module.directive("rowboatLength",function(){return{restrict:"A",require:"ngModel",link:function(e,t,n,a){"undefined"!=typeof e.$eval(n.ngModel)&&e.$eval(n.ngModel).length!=n.rowboatLength&&a.$setValidity("rowboatLength",!1),t.on("focus",function(r){e.$watch(n.ngModel,function(e){var r=n.rowboatLength,i="undefined"!=typeof e&&e.length==r;if(i)t.parent().find("span").remove(),t.parent().removeClass("error"),a.$setValidity("rowboatLength",i);else if(0==t.parent().find("span").length){t.parent().addClass("error");var o='<span class="control-label">Length is '+r+"</span>";t.parent().append(o),a.$setValidity("rowboatLength",i)}})})}}}),module.directive("rowboatMinLength",function(){return{restrict:"A",require:"ngModel",link:function(e,t,n,a){"undefined"!=typeof e.$eval(n.ngModel)&&e.$eval(n.ngModel).length<n.rowboatMinLength&&a.$setValidity("rowboatMinLength",!1),t.on("focus",function(r){e.$watch(n.ngModel,function(e){var r=n.rowboatMinLength,i="undefined"!=typeof e&&e.length>=r;if(i)t.parent().find("span").remove(),t.parent().removeClass("error"),a.$setValidity("rowboatMinLength",i);else if(0==t.parent().find("span").length){t.parent().addClass("error");var o='<span class="control-label">Min length is '+r+"</span>";t.parent().append(o),a.$setValidity("rowboatMinLength",i)}})})}}}),module.directive("rowboatMaxLength",function(){return{restrict:"A",require:"ngModel",link:function(e,t,n,a){"undefined"!=typeof e.$eval(n.ngModel)&&e.$eval(n.ngModel).length>n.rowboatMaxLength&&a.$setValidity("rowboatMaxLength",!1),t.on("focus",function(r){e.$watch(n.ngModel,function(e){var r=n.rowboatMaxLength,i="undefined"!=typeof e&&e.length<=r;if(i)t.parent().find("span").remove(),t.parent().removeClass("error"),a.$setValidity("rowboatMaxLength",i);else if(0==t.parent().find("span").length){t.parent().addClass("error");var o='<span class="control-label">Max length is '+r+"</span>";t.parent().append(o),a.$setValidity("rowboatMaxLength",i)}})})}}}),module.directive("rowboatEmailPattern",function(){return{restrict:"A",require:"ngModel",link:function(e,t,n,a){$pattern=/^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/,"undefined"==typeof e.$eval(n.ngModel)&&a.$setValidity("rowboatEmailPattern",!1),t.on("blur",function(r){e.$watch(n.ngModel,function(e){var n="undefined"!=typeof e&&$pattern.test(e);if(n)t.parent().find("span").remove(),t.parent().removeClass("error"),a.$setValidity("rowboatEmailPattern",n);else if(0==t.parent().find("span").length){t.parent().addClass("error");var r='<span class="control-label">Email Invalid</span>';t.parent().append(r),a.$setValidity("rowboatEmailPattern",n)}})})}}});var filterDate=angular.module("customFormatDate",[]);filterDate.filter("myDate",["$filter",function(e){return function(t,n){if(null==t)return"";if("Invalid Date"==new Date(t))for(;-1!=String(t).indexOf("-");)t=t.replace("-","/");if("Invalid Date"==new Date(t))return"";var a=e("date")(new Date(String(t)),angular.isUndefined(n)?"MM-dd-yyyy":n);return String(a)}}]).filter("myDateL",["$filter",function(e){return function(t){if(null==t)return"";if("Invalid Date"==new Date(t))for(;-1!=String(t).indexOf("-");)t=t.replace("-","/");if("Invalid Date"==new Date(t))return"";var n=e("date")(new Date(String(t)),"MMMM d, y");return String(n)}}]).filter("myDateTime",["$filter",function(e){return function(t){if(null==t)return"";if("0000-00-00 00:00:00"==t)return"";if("Invalid Date"==new Date(t))for(;-1!=String(t).indexOf("-");)t=t.replace("-","/");if("Invalid Date"==new Date(t))return"";var n=e("date")(new Date(String(t)),"MM-dd-yyyy HH:mm:ss");return String(n)}}]).filter("myDateShortTime",["$filter",function(e){return function(t){if(null==t)return"";if("0000-00-00 00:00:00"==t)return"";if("Invalid Date"==new Date(t))for(;-1!=String(t).indexOf("-");)t=t.replace("-","/");if("Invalid Date"==new Date(t))return"";var n=e("date")(new Date(String(t)),"MM-dd-yyyy h:mma");return String(n)}}]).filter("clientDate",["$filter",function(e){return function(t,n){if(null==t)return"";if("0000-00-00 00:00:00"==t)return"";if("Invalid Date"==new Date(t))for(;-1!=String(t).indexOf("-");)t=t.replace("-","/");if("Invalid Date"==new Date(t))return"";t=new Date(t),t=new Date(parseInt(new Date(t).getTime())-60*parseInt((new Date).getTimezoneOffset())*1e3);var a=e("date")(new Date(String(t)),angular.isUndefined(n)?"MM-dd-yyyy":n);return String(a)}}]).filter("clientDateTime",["$filter",function(e){return function(t){return e("date")(checkInvalid(t),window.dateTimeFormat)}}]).filter("clientLogDate",["$filter",function(e){return function(t){return e("date")(checkInvalid(t),window.logDate)}}]).filter("clientMediumDate",["$filter",function(e){return function(t){return e("date")(checkInvalid(t),window.mediumDate)}}]).filter("clientShortTime",["$filter",function(e){return function(t){return e("date")(checkInvalid(t),window.shortTime)}}]).filter("clientShortTimeFollowTimezone",["$filter",function(e){return function(t,n){if(null==t)return"";if("Invalid Date"==new Date(t))for(;-1!=String(t).indexOf("-");)t=t.replace("-","/");if("Invalid Date"==new Date(t))return"";var a=e("date")(new Date(String(t)),window.shortTime);return String(a)}}]).filter("formatCurrentDate",["$filter",function(e){return function(e){if(e=checkInvalid(e),!e)return"";e=new Date(e);var t=e.getMonth()+"-"+e.getDate()+"-"+e.getFullYear();return String(t)}}]).filter("formatCurrentTime",["$filter",function(e){return function(e){if(e=checkInvalid(e),!e)return"";e=new Date(e);var t=e.getHours()>=12?"pm":"am",n=parseInt(e.getHours())%12;n=n?10>n?"0"+n:n:12;var a=parseInt(e.getMinutes())<10?"0"+e.getMinutes():e.getMinutes(),r=parseInt(e.getSeconds())<10?"0"+e.getSeconds():e.getSeconds(),i=n+"-"+a+"-"+r+" "+t;return String(i)}}]).filter("formatCurrentShortTime",["$filter",function(e){return function(e){if(e=checkInvalid(e),!e)return"";e=new Date(e);var t=e.getHours()>=12?"pm":"am",n=parseInt(e.getHours())%12;n=n?10>n?"0"+n:n:12;var a=parseInt(e.getMinutes())<10?"0"+e.getMinutes():e.getMinutes(),r=n+":"+a+" "+t;return String(r)}}]);var checkInvalid=function(e,t){if(null==e)return"";if("Invalid Date"==new Date(e))for(;-1!=String(e).indexOf("-");)e=e.replace("-","/");return"Invalid Date"==new Date(e)?"":(e=new Date(e),e=new Date(parseInt(new Date(e).getTime())-60*parseInt((new Date).getTimezoneOffset())*1e3),new Date(String(e)))};angular.module("nlcFilter").filter("elapsedtime",function(){return function(e){return humanized_time_span(e)}});var translation=angular.module("translation",[]);translation.filter("trans",["$filter",function(e){return function(e,t){return null==e?"":window.translations[t][e]}}]);var selectLevel=angular.module("helpEditorDirective",[]),version=5;selectLevel.directive("helpEditorDirective",["$timeout","$filter",function(e,t){return{require:"?ngModel",restrict:"EA",scope:{items:"=",text:"@",selectedItems:"=selectedItem",onClick:"&"},replace:!0,templateUrl:baseUrl+"/app/components/user/help-editor/view/view-help.html?v="+(new Date).getTime(),link:function(t,n,a,r){t.description="",t.recursiveGetDescription=function(e){angular.forEach(e,function(e,n){e.parent=!1,t.description+='<strong class="space-topic" id="_'+e._id+'">'+e.name+"</strong>"+e.description,e.subFolder.length>0&&t.recursiveGetDescription(e.subFolder)})},t.getDesctiption=function(){angular.forEach(t.items,function(e,n){e.parent=!0,t.description+='<h4 id="_'+e._id+'" class="c-primary">'+e.name+'</h4><div class="space-area user-ad-area">'+e.description,t.recursiveGetDescription(e.subFolder),t.description+="</div>"})},t.getDesctiption(),t.goToAnchorWithId=function(e){window.location.href="#"+e,$("#fix-modal-top").scrollTop(0)},e(function(){$(".sub-select-"+t.items[0]._id).addClass("in")})}}}]);var campaignApp=angular.module("campaignApp",["ngResource","ui.bootstrap"]).factory("CampaignResource",["$resource",function(e){return e("/api/campaign/:method/:id",{method:"@method",id:"@id"},{add:{method:"post"},save:{method:"post"},update:{method:"put"}})}]).service("CampaignService",["CampaignResource","$q",function(e,t){this.searchReportCampaignByDateRange=function(n){var a=t.defer(),r=new e(n);return r.$save({method:"search-report-campaign"},function(e){a.resolve(e)},function(e){a.resolve(e.data)}),a.promise}}]);campaignApp.controller("campaignCtrl",["$scope","$modal","$filter","$timeout","CampaignService","ngTableParams",function(e,t,n,a,r,i){e.isLoading=!1,e.isLoadingChart=!1,e.campaignsData=[],e.totalCampaign={CPA:0,AvgCPC:0},e.campaigns=angular.copy(window.campaigns),Number.prototype.round=function(e){return+(Math.round(this+"e+"+e)+"e-"+e)};for(var o in e.campaigns)e.campaigns[o].campaignId=o,e.totalCampaign.CPA+=e.campaigns[o].CPA,e.totalCampaign.AvgCPC+=e.campaigns[o].AvgCPC,e.campaignsData.push(e.campaigns[o]);e.total=window.total,e.total.CPA=e.totalCampaign.CPA,e.total.AvgCPC=e.totalCampaign.AvgCPC.round(5),e.campaign={},e.campaign.endDate=n("date")(new Date(window.endDate),"MM-dd-yyyy"),e.campaign.startDate=n("date")(new Date(window.startDate),"MM-dd-yyyy"),e.dateRange=window.dateRange;for(var o in e.dateRange)e.dateRange[o]=n("date")(new Date(dateRange[o]),"MM-dd-yyyy");e.dataReportChart=angular.copy(window.dataReportChart),e.tableParams=new i({page:1,count:10,sorting:{name:"asc"}},{total:e.campaignsData.length,getData:function(t,a){var r=a.sorting()?n("orderBy")(e.campaignsData,a.orderBy()):e.campaignsData;r=a.filter()?n("filter")(r,a.filter()):r,a.total(r.length),t.resolve(r.slice((a.page()-1)*a.count(),a.page()*a.count()))}}),e.open=function(t,n){t.preventDefault(),t.stopPropagation(),e.opened={},e.opened[n]=!0},e.format="MM-dd-yyyy";var l=function(){$("#container").highcharts({title:{text:"Report Campaign Chart",x:-20},xAxis:{categories:e.dateRange},credits:{enabled:!1},yAxis:[{labels:{style:{color:Highcharts.getOptions().colors[1]},formatter:function(){return this.value.toString().replace(/\B(?=(\d{3})+(?!\d))/g,",")}},title:{text:e.typeSecondFilter,style:{color:Highcharts.getOptions().colors[1]}},opposite:!0},{labels:{style:{color:Highcharts.getOptions().colors[0]},formatter:function(){return this.value.toString().replace(/\B(?=(\d{3})+(?!\d))/g,",")}},title:{text:e.typeFirstFilter,style:{color:Highcharts.getOptions().colors[0]}}}],tooltip:{valueSuffix:" clicks"},legend:{layout:"vertical",align:"right",verticalAlign:"middle",borderWidth:0},series:[{yAxis:1,name:e.typeFirstFilter,data:e.dataFirstSelect,tooltip:{valueSuffix:" "}},{name:e.typeSecondFilter,data:e.dataSecondSelect,tooltip:{valueSuffix:" "}}]})};l(),e.getSearchModalCampaign=function(t){e.isLoading=!0,e.campaign.start_date=n("date")(new Date(e.campaign.startDate),"yyyyMMdd"),e.campaign.end_date=n("date")(new Date(e.campaign.endDate),"yyyyMMdd"),e.submitted=!0,(t||e.campaign.start_date>e.campaign.end_date)&&e.campaign.start_date>e.campaign.end_date&&alert("End date is bigger Start date."),r.searchReportCampaignByDateRange(e.campaign).then(function(t){e.totalCampaign={CPA:0,AvgCPC:0},e.campaignsData=[],e.campaigns=t.campaigns,e.dateRange=t.dateRange;for(var r in e.dateRange)e.dateRange[r]=n("date")(new Date(e.dateRange[r]),"MM-dd-yyyy");e.dataReportChart=t.dataReportChart;for(var r in e.campaigns)e.campaigns[r].campaignId=r,e.totalCampaign.CPA+=e.campaigns[r].CPA,e.totalCampaign.AvgCPC+=e.campaigns[r].AvgCPC,e.campaignsData.push(e.campaigns[r]);e.total=t.total,e.total.CPA=e.totalCampaign.CPA,e.total.AvgCPC=e.totalCampaign.AvgCPC.round(5),e.filterFirstSelect(e.firstSelect.typeFilterFirst),e.filterSecondSelect(e.secondSelect.typeFilterSecond),e.tableParams.reload(),a(function(){l()}),e.isLoading=!1})},e.filterFirstSelect=function(t){e.dataFirstSelect=e.dataReportChart[t].data,e.typeFirstFilter=e.dataReportChart[t].name,"Avg. CPC"==e.typeFirstFilter&&(e.typeFirstFilter="Conv. Rate"),l()},e.filterSecondSelect=function(t){e.dataSecondSelect=e.dataReportChart[t].data,e.typeSecondFilter=e.dataReportChart[t].name,"Avg. CPC"==e.typeSecondFilter&&(e.typeSecondFilter="Conv. Rate"),l()}}]);