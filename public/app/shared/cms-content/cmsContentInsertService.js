var cmsInsertApp = angular.module('cmsContentInsertApp', []);
cmsInsertApp.factory('CmsContentInsertResource',['$resource', function ($resource){
    return $resource('/api/cm-content/:method/:id', {'method':'@method','id':'@id'}, {
        add: {method: 'post'},
        save:{method: 'post'},
        update:{method: 'put'}
    });
}])
.service('CmsContentInsertService', ['CmsContentInsertResource', '$q', '$filter', function (CmsContentInsertResource, $q, $filter) {
	this.insertServiceProvider = function(data){
		// var defer = $q.defer();
  //       var temp  = new LanguageResource(data);
  //       temp.$save({}, function success(data) {
  //           defer.resolve(data);
  //           if(data.status != 0) {
  //               languages.push(data.language);
  //           }
  //       },
  //       function error(reponse) {
  //       	defer.resolve(reponse.data);
  //       });
  //       return defer.promise;
	};

    /**
     * get content block follow id, languge and region
     *
     * @author [Nguyen Kim Bang] <bang@httsolution.com>
     *
     * @param  {[type]} data [fill: language, region]
     * @param  {[type]} _id  [id block]
     *
     * @return {[type]}
     */
    this.getContentBlock = function(data, _id) {
        var defer = $q.defer();

        var temp = new CmsContentInsertResource(data);

        temp.$save({id:_id, method:'get-content-block'}, function success(result) {
            defer.resolve(result);
        },
        function error(reponse) {
            defer.resolve(reponse.data);
        });

        return defer.promise;
    }

  // /*
  //  * get content block
  //  * @param id
  //  *
  //  * @return array
  // */
  // this.getContentOfBlock = function(data, _id) {
  //     var defer = $q.defer();
  //     var temp = new CmsContentInsertResource(data);

  //     temp.$save({id:_id, method:'get-content-of-block'}, function success(result) {
  //         defer.resolve(result.content);
  //     },
  //     function error(reponse) {
  //         defer.resolve(reponse.data);
  //     });

  //     return defer.promise;
  // }

    /**
     * custom a string follow format {{inject(type, id, value}} [value can null]
     *
     * @author [Nguyen Kim Bang] <bang@httsolution.com>
     *
     * @param $type, $id
     * @param $listField [list field in content block]
     *
     * @return string
     */
    this.customCurrentData = function(type, _id, curFields, listField) {
        var str = '';

        if (angular.isDefined(listField)) {
            for (var i in listField) {

                var lastKey = 0;

                lastKey = getLastKeyArrayOrObject(curFields[listField[i].variable], lastKey);

                if (angular.isDate(curFields[listField[i].variable])) {
                    curFields[listField[i].variable] = $filter('date')(curFields[listField[i].variable], 'MM-dd-yyyy');
                }

                if (angular.isObject(curFields[listField[i].variable]) || angular.isArray(curFields[listField[i].variable])) {
                    var fieldType = (listField[i].type == 'term')?'term:':'';

                    var strTypeArr = fieldType + '[';

                    strTypeArr = createStringFromArrayOrObject(curFields[listField[i].variable], strTypeArr, lastKey);

                    strTypeArr = strTypeArr + "]";

                    str = str + ", " + strTypeArr;

                } else {

                    if (angular.isUndefined(curFields[listField[i].variable])) {
                        curFields[listField[i].variable] = null;
                    }

                    curFields[listField[i].variable] = this.formatCurrentData(curFields[listField[i].variable]);
                    str = str + ", '" + curFields[listField[i].variable] +"'";

                }

            }
        }

        return "{{-- Begin "+ window.blockCommentMap[_id] +" Block --}}{{inject('" + $filter('lowercase')(type) + "', '" + _id +"'" + this.formatCurrentData(str) + ')}}{{-- End '+ window.blockCommentMap[_id] + ' Block --}} ';
    }
    /**
     * @author [Nguyen Kim Bang] <bang@httsolution.com>
     *
     * [getLastKeyArrayOrObject description]
     * @param  {[type]} data    [value of fields]
     * @param  {[type]} lastKey [position of last item of array or object]
     *
     * @return {[type]} number
     */
    function getLastKeyArrayOrObject(data, lastKey) {
        /*get last position of item */
        /* if (angular.isObject(data)) {
            var arrKey = Object.keys(data);

            lastKey = arrKey.length - 1;
        } else if (angular.isArray(data)) {
            lastKey = data.length - 1;
        }*/
        //get last key
        for(var key in data) {
           lastKey = key;
        }
        return lastKey;
        /*end*/
    }
    /**
     * @author [Nguyen Kim Bang] <bang@httsolution.com>
     *
     * [createStringFromArrayOrObject description]
     *
     * convent value array or object to string
     *
     * @param  {[type]} data       [value of fields]
     * @param  {[type]} strTypeArr [string, default value is '[']
     * @param  {[type]} lastKey    [position of last item of array or object]
     *
     * @return {[type]} string        [description]
     */
    function createStringFromArrayOrObject(data, strTypeArr, lastKey) {

        (function formatData(datas, lastKey) {
            for(var key in datas) {
                //callback function when current value is array or object
                if (!angular.isArray(datas[key]) &&  angular.isObject(datas[key]) && Object.keys(datas[key]).length) {
                    strTypeArr += '[';

                    lastKey = getLastKeyArrayOrObject(datas[key], lastKey);

                    formatData(datas[key], lastKey);

                    strTypeArr += ']';
                } else {

                    //check current value is undefine?
                    if (angular.isUndefined(datas[key])) {
                        datas[key] = null;
                    }

                    //check current value is date?
                    if (angular.isDate(datas[key])) {
                        datas[key] = $filter('date')(datas[key], 'MM-dd-yyyy');
                    }

                    //check current value is last value of array or object?
                    if (key != lastKey){
                        strTypeArr += "'" + datas[key] + "', ";
                    } else {
                        strTypeArr += "'" + datas[key] + "'";
                    }
                }
            }
        })(data, lastKey);

        strTypeArr = strTypeArr.replace(/\]\[/g, '], [');

        return strTypeArr;
    }

    this.formatCurrentData = function(str) {

        if(angular.isString(str)){

            var str = str.replace(/\r?\n/g, '<br />'); // replace \n to br

        }

        return str;
    }

    this.getDetailCommentAsset = function (assetId) {
        var defer = $q.defer();

        var temp = new CmsContentInsertResource();

        temp.$save({id:assetId, method:'get-detail-comment-asset'}, function success(result) {
            defer.resolve(result);
        });
        return defer.promise;
    }

    this.getDetailCommentLink = function (contentId) {
        var defer = $q.defer();

        var temp = new CmsContentInsertResource();

        temp.$save({id:contentId, method:'get-detail-comment-link'}, function success(result) {
            defer.resolve(result);
        });
        return defer.promise;
    }
    /**
     * get info block and update inject auto increment
     * @param  {[type]} data [description]
     * @return {[type]}      [description]
     */
    this.getBlockAndUpdateInjectAutoIncrement = function (id) {

        var defer = $q.defer();
        var temp = new CmsContentInsertResource();
        // update block and update inejct auto increment
        temp.$save({id:id, method:'get-block-and-update-inject-auto-increment'}, function success(data) {

            defer.resolve(data);
        });
        return defer.promise;
    }

}]);
