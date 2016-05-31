var filterDate = angular.module('customFormatDate', []);
filterDate.filter('myDate', ['$filter',function($filter) {
    return function(input, typeFormat) {
        if (input == null) {
            return "";
        }
        if (new Date(input) == 'Invalid Date') {
            while (String(input).indexOf('-') != -1) {
              input = input.replace('-','/');
            }
        }
        if (new Date(input) == 'Invalid Date') {
            return "";
        }
        var _date = $filter('date')(new Date(String(input)), (angular.isUndefined(typeFormat))?'MM-dd-yyyy':typeFormat);
        return String(_date);
    };
}]).filter('myDateL', ['$filter',function($filter) {
    return function(input) {
        if (input == null) {
            return "";
        }
        if (new Date(input) == 'Invalid Date') {
            while (String(input).indexOf('-') != -1) {
              input = input.replace('-','/');
            }
        }
        if (new Date(input) == 'Invalid Date') {
            return "";
        }
        var _date = $filter('date')(new Date(String(input)), 'MMMM d, y');
        return String(_date);
    };
}]).filter('myDateTime', ['$filter',function($filter) {
    return function(input) {
        if (input == null) {
            return "";
        }
        if(input == '0000-00-00 00:00:00') {
            return '';
        }
        if (new Date(input) == 'Invalid Date') {
            while (String(input).indexOf('-') != -1) {
              input = input.replace('-','/');
            }
        }
        if (new Date(input) == 'Invalid Date') {
            return "";
        }
        var _date = $filter('date')(new Date(String(input)), 'MM-dd-yyyy HH:mm:ss');
        return String(_date);
    };
}]).filter('myDateShortTime', ['$filter',function($filter) {
    return function(input) {
        if (input == null) {
            return "";
        }
        if(input == '0000-00-00 00:00:00') {
            return '';
        }
        if (new Date(input) == 'Invalid Date') {
            while (String(input).indexOf('-') != -1) {
              input = input.replace('-','/');
            }
        }
        if (new Date(input) == 'Invalid Date') {
            return "";
        }
        var _date = $filter('date')(new Date(String(input)), 'MM-dd-yyyy h:mma');
        return String(_date);
    };
}]).filter('clientDate', ['$filter',function($filter) {
    return function(input, typeFormat) {
        if (input == null) {
            return "";
        }
        if(input == '0000-00-00 00:00:00') {
            return '';
        }
        if (new Date(input) == 'Invalid Date') {
            while (String(input).indexOf('-') != -1) {
              input = input.replace('-','/');
            }
        }
        if (new Date(input) == 'Invalid Date') {
            return "";
        }

        input = new Date(input);
      
        input = new Date((parseInt(new Date(input).getTime())) - (parseInt(new Date().getTimezoneOffset())*60*1000));

        var _date = $filter('date')(new Date(String(input)), (angular.isUndefined(typeFormat))?'MM-dd-yyyy':typeFormat);
        return String(_date);
    };
}]).filter('clientDateTime', ['$filter',function($filter) {
    return function(input) {

        return $filter('date')(checkInvalid(input), window.dateTimeFormat);
    };
}]).filter('clientLogDate', ['$filter',function($filter) {
    return function(input) {

        return $filter('date')(checkInvalid(input), window.logDate);
    };
}]).filter('clientMediumDate', ['$filter',function($filter) {
    return function(input) {
        
        return $filter('date')(checkInvalid(input), window.mediumDate);
    };
}]).filter('clientShortTime', ['$filter',function($filter) {
    return function(input) {
        // console.log('input1',input);
        return $filter('date')(checkInvalid(input), window.shortTime);
    };
}]).filter('clientShortTimeFollowTimezone', ['$filter',function($filter) {
    return function(input, timezone) {
        // console.log('input1',input);
        if (input == null) {
                return '';
        }

        if (new Date(input) == 'Invalid Date') {
            while (String(input).indexOf('-') != -1) {
              input = input.replace('-','/');
            }
        }

        if (new Date(input) == 'Invalid Date') {
            return ''
        }

        /*format datetime*/
        var _date = $filter('date')(new Date(String(input)), window.shortTime);
        return String(_date);
    };
}])
/*not format date follow current timezone*/
/*testing*/
.filter('formatCurrentDate', ['$filter',function($filter) {
    return function(input) {
        console.log('input1',input);
        input = checkInvalid(input);

        if (!input) {
            return '';
        }

        input = new Date(input);

        var _date = input.getMonth()+'-'+input.getDate()+'-'+input.getFullYear();

        return String(_date);
    };
}])
/*not format date follow current timezone*/
/*testing*/
.filter('formatCurrentTime', ['$filter',function($filter) {
    return function(input) {
        console.log('input1',input);
        input = checkInvalid(input);

        if (!input) {
            return '';
        }

        input = new Date(input);
        var am_or_pm = (input.getHours() >= 12) ? 'pm' : 'am';
        var hours = parseInt(input.getHours()) % 12;
            hours = (hours)?(hours < 10)?'0'+hours:hours:12;
        var minutes = (parseInt(input.getMinutes()) < 10) ? '0'+input.getMinutes() : input.getMinutes();
        var seconds = (parseInt(input.getSeconds()) < 10) ? '0'+input.getSeconds() : input.getSeconds();
        var _date = hours+'-'+minutes+'-'+seconds+' '+am_or_pm;

        return String(_date);
    };
}])
/*not format date follow current timezone*/
/*testing*/
.filter('formatCurrentShortTime', ['$filter',function($filter) {
    return function(input) {
        console.log('input1',input);
        input = checkInvalid(input);

        if (!input) {
            return '';
        }

        input = new Date(input);
        var am_or_pm = (input.getHours() >= 12) ? 'pm' : 'am';
        var hours = parseInt(input.getHours()) % 12;
            hours = (hours)?(hours < 10)?'0'+hours:hours:12;
        var minutes = (parseInt(input.getMinutes()) < 10) ? '0'+input.getMinutes() : input.getMinutes();
        var _date = hours + ':' + minutes + ' ' + am_or_pm;

        return String(_date);
    };
}]);

var checkInvalid = function(input, type) {
    if (input == null) {
            return '';
    }

    if (new Date(input) == 'Invalid Date') {
        while (String(input).indexOf('-') != -1) {
          input = input.replace('-','/');
        }
    }

    if (new Date(input) == 'Invalid Date') {
        return ''
    }

    input = new Date(input);

    input = new Date((parseInt(new Date(input).getTime())) - (parseInt(new Date().getTimezoneOffset())*60*1000));

    return new Date(String(input));
};