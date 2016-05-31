<!DOCTYPE html>
<html data-ng-app="uls">
  <head>

  	{!! Html::script('bower_components/angular/angular.js')!!}
    {!! Html::script('bower_components/angular-resource/angular-resource.js')!!}
    {!! Html::script('bower_components/angular-bootstrap/ui-bootstrap.js')!!}
    {!! Html::script('bower_components/angular-bootstrap/ui-bootstrap-tpls.js')!!}
    
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-1.12.3.min.js"></script>
    <style type="text/css">

      #tipue_drop_input {
          /*background: #fff url('img/search.png') no-repeat 7px 8px;*/
          border: 1px solid #d9d9d9;
          width: 232px!important;
          border-radius: 0;
          width: auto;
          display: inline-block;
          font-style: italic;
          padding: 4px 12px;
          height: 30px;
      }

      #tipue_drop_content
      {
           display: none;
           position: absolute;
        margin: 13px 20px 0 0;
        line-height: 0;
        z-index: 1000;
      }

      .tipue_drop_box 
      {
           position: relative;
        background: #fff;
        border: 1px solid #dcdcdc;
        border-radius: 2px;
        box-shadow: 2px 2px 5px #f9f9f9;
      }
      .tipue_drop_box:after, .tipue_drop_box:before
      {
        position: absolute;
        pointer-events: none;
        border: solid transparent;
        bottom: 100%;
        content: "";
        height: 0;
        width: 0;
      }
      .tipue_drop_box:after
      {
        border-bottom-color: #fff;
        border-width: 8px;
        left: 42px;
        margin-left: -8px;
      }
      .tipue_drop_box:before 
      {
        border-bottom-color: #dcdcdc;
        border-width: 9px;
        left: 42px;
        margin-left: -9px;
      }

      #tipue_drop_wrapper
      {
           margin: 6px;
      }
      #tipue_drop_wrapper a
      {
           text-decoration: none;
      }
      .tipue_drop_item
      {
           background-color: #fff;
      }
      .tipue_drop_item:hover
      {
           background-color: #f7f7f7;
      }
      .tipue_drop_left
      {
           display: table-cell;
           padding: 7px;
      }
      .tipue_drop_image
      {
           width: 50px;
           height: 50px;
           
           border: 2px solid #fff;
      }
      .tipue_drop_right {
          display: table-cell;
          vertical-align: middle;
          font: 300 14px/1.6 'Helvetica Neue', Helvetica, Arial, sans-serif;
          color: #333;
          width: 170px;
          padding: 0 7px;
          text-align: left;
      }
      .search-result-dropdown {
          left: 154px;
      }
    </style>
  </head>
  <body>
  <div ng-controller="GalaryController as galaryCtrl">
  <!-- <input type="checkbox" ng-model="tagsIds[id cua tag]" ng-click="galaryCtrl.getGalleryWitTagsIds()" ng-true-value"1" ng-false-value=""> -->
    <div ng-repeat="item in galaryCtrl.items">
        <img src="@{{item.url}}">
      </div>
    <div data-ng-controller="PaginationUlsController as paginationCtrl">
      <div class="text-center panigation">
  	     <pagination total-items="paginationCtrl.totalItems" ng-model="paginationCtrl.currentPage" max-size="paginationCtrl.maxSize" class="pagination-sm" ng-change="paginationCtrl.pageChanged()" boundary-links="true" rotate="false" items-per-page="paginationCtrl.itemsPerPage"></pagination>
  	</div>
  </div>
</div>
<form>
    <input type='text' id='search-pages' name ='search'> </input>
</form>

  <div class="form-group box-option">
    <input type="text" name="q" id="tipue_drop_input" autocomplete="off" required placeholder="Search...">
    <div id="tipue_drop_content" class="search-result-dropdown"></div>
    <button class="btn btn-default">Search</button>
  </div>

  <script type="text/javascript">
      window.galary = {!!json_encode($galary)!!};
  </script>
    {!! Html::script('app/components/pagination/app.js')!!}
    {!! Html::script('app/components/pagination/config.js')!!}
     {!! Html::script('app/components/pagination/galaryController.js')!!}
    {!! Html::script('app/components/pagination/paginationController.js')!!}
    {!! Html::script('app/components/pagination/paginationService.js')!!}
   
  </body>
    <script type="text/javascript">
      var tipuedrop = {"pages": [
         {"title": "<b>Wood</b> Engraving and Cutting with Laser...", "thumb": "search/img/wood01.png", "text": "a site search engine jQuery plugin", "url": "search-result.html"},
         {"title": "<b>Wood</b>working Custom <b>wood</b>working with Universal Laser...", "thumb": "search/img/wood02.png", "text": "a search suggestion box jQuery plugin", "url": "search-result.html"},
         {"title": "Most <b>wood</b> types are easy to cut using DLMP® technology.", "thumb": "search/img/wood03.png", "text": "a small and simple tooltip jQuery plugin", "url": "search-result.html"},
          {"title": "View All", "thumb": "search/img/search-all.png", "text": "a site search engine jQuery plugin", "url": "search-result.html"}
        ]};
    </script>

    <script type="text/javascript">
      (function($) {

         $.fn.tipuedrop = function(options) {

              var set = $.extend( {
              
                   'show'                   : 4,
                   'speed'                  : 300,
                   'newWindow'              : false,
                   'mode'                   : 'static',
                   'contentLocation'        : 'tipuedrop/tipuedrop_content.json'
              
              }, options);
              
              return this.each(function() {
              
                   var tipuedrop_in = {
                        pages: []
                   };
                   $.ajaxSetup({
                        async: false
                   });
                   
                   if (set.mode == 'json')
                   {
                        $.getJSON(set.contentLocation)
                             .done(function(json)
                             {
                                  tipuedrop_in = $.extend({}, json);
                             });
                   }               
                   
                   if (set.mode == 'static')
                   {
                        tipuedrop_in = $.extend({}, tipuedrop);
                   }

                   $(this).keyup(function(event)
                   {
                    var data = { //Fetch form data
                        'text'     : $(this).val() //Store name fields value
                    };
                    console.log(data);
                    $.ajax({ //Process the form using $.ajax()
                        type      : 'POST', //Method type
                        url       : '/api/pages/search-pages', //Your form processing file URL
                        data      : data, //Forms name
                        dataType  : 'json',
                        success   : function(data) {
                                      tipuedrop_in.pages = data.items;
                                        console.log(tipuedrop_in.pages)
                                      }
                    });
                        getTipuedrop($(this));
                   });               
                   
                   function getTipuedrop($obj)
                   {
                        if ($obj.val())
                        {
                             var c = 0;
                             for (var i = 0; i < tipuedrop_in.pages.length; i++)
                             {
                                  var pat = new RegExp($obj.val(), 'i');
                                  if ((tipuedrop_in.pages[i].title.search(pat) != -1 || tipuedrop_in.pages[i].text.search(pat) != -1) && c < set.show)
                                  {
                                       if (c == 0)
                                       {
                                            var out = '<div class="tipue_drop_box"><div id="tipue_drop_wrapper">';    
                                       }
                                       out += '<a href="' + tipuedrop_in.pages[i].url + '"';
                                       if (set.newWindow)
                                       {
                                            out += ' target="_blank"';
                                       }
                                       out += '><div class="tipue_drop_item"><div class="tipue_drop_left"><img src="' + tipuedrop_in.pages[i].thumb + '" class="tipue_drop_image"></div><div class="tipue_drop_right">' + tipuedrop_in.pages[i].title + '</div></div></a>';
                                       c++;
                                  }
                             }
                             if (c != 0)
                             {
                                  out += '</div></div>';               
                                  $('#tipue_drop_content').html(out);
                                  $('#tipue_drop_content').fadeIn(set.speed);
                             }
                        }
                        else
                        {
                             $('#tipue_drop_content').fadeOut(set.speed);
                        }
                   }
                   
                   $('html').click(function()
                   {
                        $('#tipue_drop_content').fadeOut(set.speed);
                   });
              
              });
         };
         
    })(jQuery);
    </script>
    <script>
        $(document).ready(function () {
            $('#tipue_drop_input').tipuedrop();
        });
    </script>

  <script type="text/javascript">
    $(document).ready(function() {
    $('form').change(function(event) { //Trigger on form submit

        //Validate fields if required using jQuery

        var data = { //Fetch form data
            'text'     : $('#search-pages').val() //Store name fields value
        };
        console.log(data);
        $.ajax({ //Process the form using $.ajax()
            type      : 'GET', //Method type
            url       : 'api/pages/search-auto-suggestion-pages', //Your form processing file URL
            data      : data, //Forms name
            dataType  : 'json',
            success   : function(data) {
              console.log(data);
                            // if (!data.success) { //If fails
                            //     if (data.errors.name) { //Returned if any error from process.php
                            //         $('.throw_error').fadeIn(1000).html(data.errors.name); //Throw relevant error
                            //     }
                            // }
                            // else {
                            //         $('#success').fadeIn(1000).append('<p>' + data.posted + '</p>'); //If successful, than throw a success message
                            //     }
                            }
        });
        // event.preventDefault(); //Prevent the default submit
    });
});
  </script>
</html>
