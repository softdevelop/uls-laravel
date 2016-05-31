angular.module('uls')
.directive('comments', ['FileService', function(FileService){
    return {
        restrict: 'E',
        scope:{
            usersMap:'=',
            files:'=',
            items:'=',
            totalComments:'=',
            numberLimit:'=',
            limitStep:'=',
            hideLoadMore:'=',
            openPicture:'&',
            ticket:'='
        },

        templateUrl: baseUrl +'/app/shared/comments/views/index.html?v=1'+new Date().getTime(),
        link: function($scope, element, attrs, ngModel){
            
            $scope.templateComment =  baseUrl +'/app/shared/comments/views/comment.html?v=1'+new Date().getTime(), 
            console.log($scope.items,'items');
            
            $scope.baseUrl = baseUrl;
            $scope.userId = window.userId;

            /**
            * [loadMoreComments description]
            * load more for comments
            * @param  {[type]} count: number of comments
            */
            $scope.convetUnixTimeDescription = function(unixTime) {
            var date = new Date(unixTime);
                return date;
            };

            $scope.loadMoreComments = function(count){
                $scope.numberLimit += $scope.totalComments;
                $scope.hideLoadMore = true;
            }

            /**
            * [convetUnixTime description]
            * Convet date time for comments
            * @param  {[type]} strToTime     datTimer format from strToTime
            * @param  {[type]} unixTimestamp [description]
            * @return {[type]}               [description]
            */
            $scope.convetUnixTime = function(strToTime,unixTimestamp){
                var unixTimestampFormat = '';
                if(typeof strToTime !== 'undefined'){
                    unixTimestampFormat = strToTime;
                }else{
                    unixTimestampFormat = unixTimestamp;
                }

                var date = new Date(unixTimestampFormat*1000);
                return date;
            }

            /**
            * [checkFile description]
            * @param  {[type]} type [description]
            * @return {[type]}      [description]
            */
            $scope.checkFile = function(type){
                return FileService.checkFile(type);
            }
        }
    }
}])
.filter('to_trusted', ['$sce', function($sce){
    return function(text) {
        return $sce.trustAsHtml(text);
    };
}]);