(function($){
    $(document).ready(function(){
		
    	$('.get-guide-email').magnificPopup({
			type: 'inline',
			focus: '#email',
			callbacks: {
				beforeOpen: function() {
					if($(window).width() < 700) {
						this.st.focus = false;
					} else {
						this.st.focus = '#email';
					}
				}
			}
		});
		$('.get-visual-communication').magnificPopup({
			callbacks: {
				beforeOpen: function() {
					if (!$('.lightSlider-visual').hasClass('lightSlider')){
						$('.lightSlider-visual').lightSlider({
							gallery: true,
						    item: 1,
						    slideMargin: 0,
						    thumbItem: 9
						});
					}
				},
			}
		});
		$('.get-dimensional-applications').magnificPopup({
			callbacks: {
				beforeOpen: function() {
					if (!$('.lightSlider-dimensional').hasClass('lightSlider')){
						$('.lightSlider-dimensional').lightSlider({
							gallery: true,
						    item: 1,
						    slideMargin: 0,
						    thumbItem: 9
						});
					}
				},
			}
		});

		$('.get-edit-form-list-material').magnificPopup({
			
		});
		$('.get-later').magnificPopup({});

		// $('.alert-question').magnificPopup({});

		$('.alert-question-finish').magnificPopup({});
      	$('.confirm-modal').magnificPopup({});


		new WOW().init();
		$('.lightSlider').each(function() {
		    var $container = $(this);
		    var $imageLinks = $(this).find('li.item a');
		    var items = []; 
		    $imageLinks.each(function(index, el) {
		      var $item = $(this);
		      var type = 'image';
		      if ($item.hasClass('video')) {
		        type = 'iframe';
		      }
		      var magItem = {
		        src: $item.attr('href'),
		        type: type,
		      };
		      magItem.title = $item.data('title');
		      items.push(magItem);
		    });
		    $imageLinks.magnificPopup({
		      mainClass: 'mfp-fade',
		      items: items,
		      gallery:{
		          enabled:true,
		          tPrev: $(this).data('prev-text'),
		          tNext: $(this).data('next-text')
		      },
		      type: 'image',
		      callbacks: {
		        beforeOpen: function() {
		          var index = $imageLinks.index(this.st.el);
		          if (-1 !== index) {
		            this.goTo(index);
		          }
		        }
		      }
		    });
		});
		$('.lightSlider').lightSlider({
		    gallery: true,
		    item: 1,
		    loop:true,
		    slideMargin: 0,
		    thumbItem: 9
		});
		$('figure.image a').magnificPopup({
			type: 'image',
			closeOnContentClick: true,
			mainClass: 'mfp-img-mobile',
			image: {
				verticalFit: true
			}
		});
		$('.get-sample-form').magnificPopup({
			type: 'inline',
			focus: '#FirstName',
			callbacks: {
				beforeOpen: function() {
					if($(window).width() < 700) {
						this.st.focus = false;
					} else {
						this.st.focus = '#FirstName';
					}
				}
			}
		});
		$('.see-demo-form, .test-material-form, .get-sample-form').magnificPopup({
			type: 'inline',
			focus: '#FirstName',
			callbacks: {
				beforeOpen: function() {
					if($(window).width() < 700) {
						this.st.focus = false;
					} else {
						this.st.focus = '#FirstName';
					}
				}
			}
		});
		$('.list-gallery').magnificPopup({
			delegate: '.item a',
			type: 'image',
			tLoading: 'Loading image #%curr%...',
			mainClass: 'mfp-img-mobile',
			gallery: {
				enabled: true,
				navigateByImgClick: true,
				preload: [0,1] // Will preload 0 - before current, and 1 after the current image
			},
		});

		var $container = $('.list-gallery').isotope({
		    itemSelector: '.item'
		});

	  // filter with selects and checkboxes
	  var $checkboxes = $('.group-checked .item input');
	  
	  $checkboxes.change( function() {
	    // map input values to an array
	    var inclusives = [];
	    // inclusive filters from checkboxes
	    $checkboxes.each( function( i, elem ) {
	      // if checkbox, use value if checked
	      if ( elem.checked ) {
	        inclusives.push( elem.value );
	      }
	      console.log(inclusives,'sdfsdf');
	    });

	    // combine inclusive filters
	    var filterValue = inclusives.length ? inclusives.join(', ') : '*';

	    $container.isotope({ filter: filterValue });
	  });
	});

	//  back to top button
$('body').prepend('<a href="#" class="back-to-top">Back to Top</a>');

var amountScrolled = 300;

$(window).scroll(function () {
    if ($(window).scrollTop() > amountScrolled) {
        $('a.back-to-top').fadeIn('slow');
    } else {
        $('a.back-to-top').fadeOut('slow');
    }
});

$('a.back-to-top, a.simple-back-to-top').click(function () {
    $('html, body').animate({
        scrollTop: 0
    }, 700);
    return false;
});


$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})




window.wizard = $("#wizard").steps({
    headerTag: "h2",
    bodyTag: "section",
    transitionEffect: "slideLeft",
    onStepChanged: function (event, currentIndex, priorIndex) { 
    	// var elem = angular.element(document.querySelector('[ng-controller="EditDraftController"]'));
    	var elem = angular.element('[ng-controller]');

    	//get the injector.
	    var injector = elem.injector();

	    //get the service.
	    var $scope = elem.scope();

	    var tmpDataInput = angular.copy($scope.dataInput);

	    tmpDataInput['step'] = priorIndex + 1;

	    $scope.saveDataStep(tmpDataInput);

    	if (currentIndex === 2) {
    		step3();
    	}
    }
});

function step3() {
	var $mySticky = $('.my-sticky-element');

	//store the initial position of the element
	var TopMySticky = $mySticky.offset().top - parseFloat($mySticky.css('margin-top').replace(/auto/, 0));


	var footTop = $('footer').offset().top - parseFloat($('footer').css('marginTop').replace(/auto/, 0));


	var HeightBoxSeLected = $('.my-sticky-element').outerHeight();
	console.log('HeightBoxSeLected',HeightBoxSeLected);

	var MaxHeightBoxSeLected = HeightBoxSeLected + 200;
	console.log('MaxHeightBoxSeLected',MaxHeightBoxSeLected);


	var maxY = footTop - MaxHeightBoxSeLected;
	console.log('maxY',maxY);


	var HeightBoxListiTem = $('.wrap-step-tree .set-height').outerHeight();


	console.log('HeightBoxListiTem',HeightBoxListiTem);


	if (HeightBoxListiTem > MaxHeightBoxSeLected){
		$(window).scroll(function (event){
			console.log('add');

		    var y = $(this).scrollTop();

		    if (y >= TopMySticky) {
		    	if (y < maxY){
		    		$mySticky.addClass('stuck');

		    	}
				else {
				    $mySticky.removeClass('stuck');
				}

		    }else {
		        $mySticky.removeClass('stuck');
		    }
		});
	}
	
}

if (typeof window.dataInput != 'undefined') {
 if (Object.keys(window.dataInput).length > 0) {
  for(var i=0; i< window.dataInput.step-1; i++) {
            window.wizard.steps("next");
   }
 }

}
})(jQuery);
