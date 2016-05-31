var cmsApp = angular.module('CmsApp', []);

cmsApp.service('CmsService', ['$q', '$filter', function ($q, $filter) {

  var fields = []; //default fields map
  var sections = []; // default sections map

  var fieldsOld = [];

  var sectionsOld = [];

  this.setHeightTable = function(){
    var h = window.innerHeight;
        $('.table-animate').css({
            height: h - 170 + 'px',
        });
  }
  /**
   * set fields content
   * @param {[type]} data [description]
   */
  this.setFieldsContent = function(data) {

      if(typeof data != 'undefined'){
        // bowser data field when fields map
        for(var key in data){
          // push fields to check fields and map
          fields[data[key]['variable']] = data[key];

        }
      }     
  }
  /**
   * set sections content
   * @param {object} data [description]
   */
  this.setSectionsContent = function(data) {

      if(typeof data != 'undefined'){
        // bowser data sections when sections map
        for(var key in data){
          // push sections to check section and map
          sections[data[key]['variable']] = data[key];

        }
      }
  }
  /**
   * get new field
   *
   * @author minh than
   * @param  {array} beforFields   [fields befor edit]
   * @param  {array} currentFields [fields current edit]
   * @return {[type]}               [description]
   */
  this.getFieldsNew = function(currentFields) {

    var fieldsNew = []; // default fields new
    //brower current fields to check item field new
    for(var key in currentFields){
        // check current item fields has is fields new 
        if(typeof fields[currentFields[key]['variable']] == 'undefined'){
          // push fields new in fieldsnew
          fieldsNew.push(currentFields[key]);

        }else{

          fieldsOld.push(currentFields[key]);
        }
    }

    return fieldsNew;

  }

  this.setFieldsOld = function() {

    fieldsOld = [];
  }
  /**
   * get new section
   *
   * @author minh than
   * @param  {array} beforSections   [sections befor edit]
   * @param  {array} currentSections [sections current edit]
   * @return {[type]}                 [description]
   */
  this.getSectionsNew = function(currentSections) {

    var sectionsNew = []; // default sections new
    //brower current fields to check item field new
    for(var key in currentSections){
        // check current item sections has is sections new 
        if(typeof sections[currentSections[key]['variable']] == 'undefined'){
          // push sections new in sectionsNew
          sectionsNew.push(currentSections[key]);
        }else{

          sectionsOld.push(currentSections[key]);
        }
    }

    return sectionsNew;   
    
  }

  this.setSectionsOld = function() {

    sectionsOld = [];
  }
  /**
   * [mapDataFields description]
   * @param  {[type]} dataNew [description]
   * @param  {[type]} data    [description]
   * @return {[type]}         [description]
   */
  this.mapDataFields = function(fieldsNew) {

    for(var key in fieldsOld){

      if(typeof fields[fieldsOld[key]['variable']] != 'undefined'){

        if(fieldsOld[key].multiple != fields[fieldsOld[key]['variable']].multiple){

          fields[fieldsOld[key]['variable']].multiple = fieldsOld[key].multiple;
          
        }

        fieldsOld[key] = fields[fieldsOld[key]['variable']];
      }

    }

    for(var key in fieldsNew){

      fieldsOld.push(fieldsNew[key]);

    }

    return fieldsOld;

  }
  this.mapDataSections = function(sectionsNew) {

    for(var key in sectionsOld){

      if(typeof sections[sectionsOld[key]['variable']] != 'undefined'){

          sectionsOld[key] = sections[sectionsOld[key]['variable']];
      }

    }

    for(var key in sectionsNew){

      sectionsOld.push(sectionsNew[key]);

    }

    return sectionsOld;

  }
}]);
