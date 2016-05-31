var url = 'http://leads.ulsinc.com/get_leads/';

// Messages for no leads
var mainContactNone = 'There are no unflagged leads from the Main Contact form. The system is current.';
var sendMessageNone = 'There are no unflagged leads from the Send Message form. The system is current.';
var oneTouchNone = 'There are no unflagged leads from the 1-Touch Laser Photo form. The system is current.';
var landingPagesNone = 'There are no unflagged leads from the Landing Pages. The system is current.';
var configuratorContactNone = 'There are no unflagged leads from the Configurator Contact/Help form. The system is current.';
var technicalSupportNone = 'There are no unflagged leads from the Technical Support form. The system is current.';
var configuratorNone = 'There are no unflagged leads from the Configurator.  The system is current.';
var spamNone = 'There is no spam.  Hallelujah!';
var globalspecNone = 'There are no unflagged leads from GlobalSpec.  The system is current.';
var verifiedNone = 'There are no verified leads.  Please verify some leads.';
var duplicatesNone = 'There are no duplicate leads.';
var allNone = 'There are no flagged leads.  Please try again later.';
var appsLabNone = 'There are no unflagged leads from the Applications Lab.  The system is current.';
var financingNone = 'There are no unflagged leads from the Financing form.  The system is current.';

// Default messages for no data
var noAddress = 'Address not given';
var noPhone = 'Phone not given';
var noCP = 'No channel partner chosen';
var noNotes = 'There are no questions or comments';
var noCompany = 'No company given';
var noOptions = 'No options requested';
var noAccessories = 'No accessories requested';

function getMainContactJson(cp_id)
{
	resetHtml();
	highlightNav('contactUs');
	$.post(url + 'main_contact', {cp_id: cp_id}, 
		function(data) {	
			if (!$.isEmptyObject(data)) {
				getMCJson(data);	
				
				// reset the count
				getMainContactCount(cp_id);
				
			} else {
				$('#web-leads').html(mainContactNone);
				getMainContactCount(cp_id);
			}
		}, "json"
	);
}

function getMCJson(data) {
	for (var i = 0; i < data.length; i++) {
		if (data[i].City != '') {
			var address = data[i].Addr1 + ', ' +  data[i].City +  ', ' +  data[i].State +  ', ' +  data[i].Country +  ', ' +  data[i].Zip;
		} else {
			var address = noAddress;
		}
		
		if (data[i].Phone != '') {
			var phone = data[i].Phone;
		} else {
			var phone = noPhone;
		}
		
		if (data[i].DealerName != 'null') {
			var cp = noCP;
		} else {
			var cp = data[i].dealerName;
		}
		
		if (data[i].GeneralNotes != '') {
			var notes = data[i].GeneralNotes;
		} else {
			var notes = noNotes;
		}
		
		if (data[i].Company != '') {
			var company = data[i].Company;
		} else {
			var company = noCompany;
		}
		
		d = formatMysqlDate(data[i].timestamp);
			
		var	html  = '<div id="lead-info">';
			html += '<div id="leadID">Lead ID# ' + '' + 'Date: ' + d + '</div>';
			html += '<div id="company">' + company + '</div>';
			html += '<div id="name">' + data[i].FName + ' ' + data[i].LName + '</div>';
			html += '<div id="email"><a href="mailto:' + data[i].EmailAddr + '">' + data[i].EmailAddr + '</a></div>';
			html += '<br class="clearall">';
		
			html += '<div>';
			html += '<div id="row' + data[i].id + '">'
			html += '<div id="phone">' +  phone + '</div>';
			html += '<div id="source">' +  data[i].url + '</div>';
			html += '<div id="cp-name">' +  cp + '</div>';
			html += '<br class="clearall">';
		
			html += '<div id="location">' + address + '<br>';
			html += '<strong>IP Address:</strong> ' + data[i].WebAddress + '<br/>';
			html += '<span>Approximate Location: ' + data[i].ApproxLocation + '</span><br/></div>';
			html += '<div id="details">';
		
			html += '<strong>Questions/Comments</strong><br>';
			html +=  notes;
			html += '</div>';
			html += '</div>';
			html += '</div>';
			html += '</div>';
			
		var learnMore = getLearnMore(data[i].id);
		var buttons = getButtons(data[i].id, 'main_contact');
		
		$('#web-leads').append(learnMore + html + buttons);
		
		// Set "div" and "more" jQuery aliases
		var dataID = data[i].id
		var div = $('#row' + dataID);
		var more = $('#more' + dataID);
		
		// Hide the body of the lead; just show the title bar and the first line
		div.hide();
		
		// Create click event for each "+" button
		more.on("click", {target: div}, function(e){
			e.data.target.slideToggle();
		});
	}
}

function getSendMessageJson(cp_id)
{
	resetHtml();
	highlightNav('sendMessage');
	$.post(url + 'send_message', {cp_id: cp_id}, 
		function(data) {	
			if (!$.isEmptyObject(data)) {
				for (var i = 0; i < data.length; i++) {
					if (data[i].City != '') {
						var address = data[i].Addr1 + ', ' +  data[i].City +  ', ' +  data[i].State +  ', ' +  data[i].Country +  ', ' +  data[i].Zip;
					} else {
						var address = noAddress;
					}
					
					if (data[i].Phone != '') {
						var phone = data[i].Phone;
					} else {
						var phone = noPhone;
					}
					
					if (data[i].DealerName != 'null') {
						var cp = noCP;
					} else {
						var cp = data[i].dealerName;
					}
					
					if (data[i].GeneralNotes != '') {
						var notes = data[i].GeneralNotes;
					} else {
						var notes = noNotes;
					}
					
					d = formatMysqlDate(data[i].datestamp);
					
					var	html  = '<div id="lead-info">';
						html += '<div id="leadID">Lead ID# ' + '' + 'Date: ' + d + '</div>';
						html += '<div id="company">' + 'No company given' + '</div>';
						html += '<div id="name">' + data[i].FName + ' ' + data[i].LName + '</div>';
						html += '<div id="email"><a href="mailto:' + data[i].EmailAddr + '">' + data[i].EmailAddr + '</a></div>';
						html += '<br class="clearall">';
					
						html += '<div>';
						
						html += '<div id="row' + data[i].id + '">'
						html += '<div id="phone">' +  'No phone given' + '</div>';
						html += '<div id="source">' +  data[i].url + '</div>';
						html += '<div id="cp-name">' +  cp + '</div>';
						html += '<br class="clearall">';
					
						html += '<div id="location">' + 'No location given' + '<br>';
						html += '<strong>IP Address:</strong> ' + data[i].WebAddress + '<br/>';
						html += '<span>Approximate Location: ' + data[i].ApproxLocation + '</span><br/></div>';
						html += '<div id="details">';
					
						html += '<strong>Questions/Comments</strong><br>';
						html +=  notes;
						html += '</div>';
						html += '</div>';
						html += '</div>';
						html += '</div>';
						
					var learnMore = getLearnMore(data[i].id);
					var buttons = getButtons(data[i].id, 'send_message');
					
					$('#web-leads').append(learnMore + html + buttons);
					
					// Set "div" and "more" jQuery aliases
					var dataID = data[i].id
					var div = $('#row' + dataID);
					var more = $('#more' + dataID);
					
					// Hide the body of the lead; just show the title bar and the first line
					div.hide();
					
					// Create click event for each "+" button
					more.on("click", {target: div}, function(e){
    					e.data.target.slideToggle();
					});

				}
				
				getSendMessageCount(cp_id);
				
			} else {
				$('#web-leads').html(sendMessageNone);
				getSendMessageCount(cp_id);
			}
		}, "json"
	);
}

function getOneTouchJson(cp_id)
{
	resetHtml();
	highlightNav('oneTouch');
	$.post(url + 'one_touch', {cp_id: cp_id}, 
		function(data) {	
			if (!$.isEmptyObject(data)) {
				for (var i = 0; i < data.length; i++) {
					if (data[i].City != '') {
						var address = data[i].Addr1 + ', ' +  data[i].City +  ', ' +  data[i].State +  ', ' +  data[i].Country +  ', ' +  data[i].Zip;
					} else {
						var address = noAddress;
					}
					
					if (data[i].Phone != '') {
						var phone = data[i].Phone;
					} else {
						var phone = noPhone;
					}
					
					if (data[i].DealerName != 'null') {
						var cp = noCP;
					} else {
						var cp = data[i].dealerName;
					}
					
					if (data[i].GeneralNotes != '') {
						var notes = data[i].GeneralNotes;
					} else {
						var notes = noNotes;
					}
					
					var div = '#row' + data[i].id;
					var more = $('#more' + data[i].id);
					
					d = formatMysqlDate(data[i].datestamp);
					
					var	html  = '<div id="lead-info">';
						html += '<div id="leadID">Lead ID# ' + '' + 'Date: ' + d + '</div>';
						html += '<div id="company">' + 'No company given' + '</div>';
						html += '<div id="name">' + data[i].FName + ' ' + data[i].LName + '</div>';
						html += '<div id="email"><a href="mailto:' + data[i].EmailAddr + '">' + data[i].EmailAddr + '</a></div>';
						html += '<br class="clearall">';
					
						html += '<div>';
					
						html += '<div id="row' + data[i].id + '">'
						html += '<div id="phone">' +  phone + '</div>';
						html += '<div id="source">' +  data[i].url + '</div>';
						html += '<div id="cp-name">' +  cp + '</div>';
						html += '<br class="clearall">';
					
						html += '<div id="location">' + 'No location given' + '<br>';
						html += '<strong>IP Address:</strong> ' + data[i].WebAddress + '<br/>';
						html += '<span>Approximate Location: ' + data[i].ApproxLocation + '</span><br/></div>';
						html += '<div id="details">';
					
						html += '<strong>Questions/Comments</strong><br>';
						html +=  notes;
						html += '</div>';
						html += '</div>';
						html += '</div>';
						html += '</div>';
						
					var learnMore = getLearnMore(data[i].id);
					var buttons = getButtons(data[i].id, 'one_touch');
					
					$('#web-leads').append(learnMore + html + buttons);
					getOneTouchCount();
					
					// Set "div" and "more" jQuery aliases
					var dataID = data[i].id
					var div = $('#row' + dataID);
					var more = $('#more' + dataID);
					
					// Hide the body of the lead; just show the title bar and the first line
					div.hide();
					
					// Create click event for each "+" button
					more.on("click", {target: div}, function(e){
    					e.data.target.slideToggle();
					});
				}
				getOneTouchCount(cp_id);
				
			} else {
				$('#web-leads').html(oneTouchNone);
				getOneTouchCount(cp_id);
			}
		}, "json"
	);
}


function getLandingPagesJson(cp_id)
{
	resetHtml();
	highlightNav('landingPages');
	$.post(url + 'landing_pages', {cp_id: cp_id}, 
		function(data) {	
			if (!$.isEmptyObject(data)) {
				for (var i = 0; i < data.length; i++) {
					if (data[i].City != '') {
						var address = data[i].Addr1 + ', ' +  data[i].City +  ', ' +  data[i].State +  ', ' +  data[i].Country +  ', ' +  data[i].Zip;
					} else {
						var address = noAddress;
					}
					
					if (data[i].Phone != '') {
						var phone = data[i].Phone;
					} else {
						var phone = noPhone;
					}
					
					if (data[i].DealerName != 'null') {
						var cp = noCP;
					} else {
						var cp = data[i].dealerName;
					}
					
					if (data[i].GeneralNotes != '') {
						var notes = data[i].GeneralNotes;
					} else {
						var notes = noNotes;
					}
					
					if (data[i].City != '') {
						var address = data[i].Addr1 + ', ' +  data[i].City +  ', ' +  data[i].State +  ', ' +  data[i].Country +  ', ' +  data[i].Zip;
					} else {
						var address = noAddress;
					}
				
					d = formatMysqlDate(data[i].timestamp);
					
					var	html  = '<div id="lead-info">';
						html += '<div id="leadID">Lead ID# ' + '' + 'Date: ' + d + '</div>';
						html += '<div id="company">' + data[i].Company + '</div>';
						html += '<div id="name">' + data[i].FName + ' ' + data[i].LName + '</div>';
						html += '<div id="email"><a href="mailto:' + data[i].EmailAddr + '">' + data[i].EmailAddr + '</a></div>';
						html += '<br class="clearall">';
					
						html += '<div>';
					
						html += '<div id="row' + data[i].id + '">'
						html += '<div id="phone">' +  phone + '</div>';
						html += '<div id="source">' +  data[i].url + '</div>';
						html += '<div id="cp-name">' +  cp + '</div>';
						html += '<br class="clearall">';
					
						html += '<div id="location">' + address + '<br>';
						html += '<strong>IP Address:</strong> ' + data[i].WebAddress + '<br/>';
						html += '<span>Approximate Location: ' + data[i].ApproxLocation + '</span><br/></div>';
						html += '<div id="details">';
					
						html += '<strong>Questions/Comments</strong><br>';
						html +=  notes;
						html += '</div>';
						html += '</div>';
						html += '</div>';
						html += '</div>';
						
					var learnMore = getLearnMore(data[i].id);
					var buttons = getButtons(data[i].id, 'landing_pages');
					
					$('#web-leads').append(learnMore + html + buttons);
					getLandingPagesCount();
					
					// Set "div" and "more" jQuery aliases
					var dataID = data[i].id
					var div = $('#row' + dataID);
					var more = $('#more' + dataID);
					
					// Hide the body of the lead; just show the title bar and the first line
					div.hide();
					
					// Create click event for each "+" button
					more.on("click", {target: div}, function(e){
    					e.data.target.slideToggle();
					});
				}
				getLandingPagesCount(cp_id);
			} else {
				$('#web-leads').html(landingPagesNone);
				getLandingPagesCount(cp_id);
			}
		}, "json"
	);
}

function getConfiguratorContactJson(cp_id)
{
	resetHtml();
	highlightNav('configuratorContact');
	$.post(url + 'configurator_contact', {cp_id: cp_id}, 
		function(data) {	
			if (!$.isEmptyObject(data)) {
				for (var i = 0; i < data.length; i++) {
					if (data[i].City != '') {
						var address = data[i].Addr1 + ', ' +  data[i].City +  ', ' +  data[i].State +  ', ' +  data[i].Country +  ', ' +  data[i].Zip;
					} else {
						var address = noAddress;
					}
					
					if (data[i].Phone != '') {
						var phone = data[i].Phone;
					} else {
						var phone = noPhone;
					}
					
					if (data[i].DealerName != 'null') {
						var cp = noCP;
					} else {
						var cp = data[i].dealerName;
					}
					
					if (data[i].GeneralNotes != '') {
						var notes = data[i].GeneralNotes;
					} else {
						var notes = noNotes;
					}
						
					d = formatMysqlDate(data[i].datestamp);
					
					var	html  = '<div id="lead-info">';
						html += '<div id="leadID">Lead ID# ' + '' + 'Date: ' + d + '</div>';
						html += '<div id="company">' + 'No company given' + '</div>';
						html += '<div id="name">' + data[i].FName + ' ' + data[i].LName + '</div>';
						html += '<div id="email"><a href="mailto:' + data[i].EmailAddr + '">' + data[i].EmailAddr + '</a></div>';
						html += '<br class="clearall">';
					
						html += '<div>';
					
						html += '<div id="row' + data[i].id + '">'
						html += '<div id="phone">' +  phone + '</div>';
						html += '<div id="source">' +  data[i].url + '</div>';
						html += '<div id="cp-name">' +  cp + '</div>';
						html += '<br class="clearall">';
					
						html += '<div id="location">' + 'No location given' + '<br>';
						html += '<strong>IP Address:</strong> ' + data[i].WebAddress + '<br/>';
						html += '<span>Approximate Location: ' + data[i].ApproxLocation + '</span><br/></div>';
						html += '<div id="details">';
					
						html += '<strong>Questions/Comments</strong><br>';
						html +=  notes;
						html += '</div>';
						html += '</div>';
						html += '</div>';
						html += '</div>';
						
					var learnMore = getLearnMore(data[i].id);
					var buttons = getButtons(data[i].id, 'configurator_contact');
					
					$('#web-leads').append(learnMore + html + buttons);
					getConfiguratorContactCount();
					
					// Set "div" and "more" jQuery aliases
					var dataID = data[i].id
					var div = $('#row' + dataID);
					var more = $('#more' + dataID);
					
					// Hide the body of the lead; just show the title bar and the first line
					div.hide();
					
					// Create click event for each "+" button
					more.on("click", {target: div}, function(e){
    					e.data.target.slideToggle();
					});
				}
				getConfiguratorContactCount(cp_id);
			} else {
				$('#web-leads').html(configuratorContactNone);
				getConfiguratorContactCount(cp_id);
			}
		}, "json"
	);
}

function getTechnicalSupportJson(cp_id)
{
	resetHtml();
	highlightNav('technicalSupport');
	$.post(url + 'technical_support', {cp_id: cp_id}, 
		function(data) {	
			if (!$.isEmptyObject(data)) {
				for (var i = 0; i < data.length; i++) {
					if (data[i].City != '') {
						var address = data[i].Addr1 + ', ' +  data[i].City +  ', ' +  data[i].State +  ', ' +  data[i].Country +  ', ' +  data[i].Zip;
					} else {
						var address = noAddress;
					}
					
					if (data[i].Phone != '') {
						var phone = data[i].Phone;
					} else {
						var phone = noPhone;
					}
					
					if (data[i].DealerName != 'null') {
						var cp = noCP;
					} else {
						var cp = data[i].dealerName;
					}
					
					if (data[i].GeneralNotes != '') {
						var notes = data[i].GeneralNotes;
					} else {
						var notes = noNotes;
					}
					
					d = formatMysqlDate(data[i].datestamp);
					
					var	html  = '<div id="lead-info">';
						html += '<div id="leadID">Lead ID# ' + '' + 'Date: ' + d + '</div>';
						html += '<div id="company">' + 'No company given' + '</div>';
						html += '<div id="name">' + data[i].FName + ' ' + data[i].LName + '</div>';
						html += '<div id="email"><a href="mailto:' + data[i].EmailAddr + '">' + data[i].EmailAddr + '</a></div>';
						html += '<br class="clearall">';
					
						html += '<div>';
					
						html += '<div id="row' + data[i].id + '">'
						html += '<div id="phone">' +  phone + '</div>';
						html += '<div id="source">' +  data[i].url + '</div>';
						html += '<div id="cp-name">' +  cp + '</div>';
						html += '<br class="clearall">';
					
						html += '<div id="location">' + 'No location given' + '<br>';
						html += '<strong>IP Address:</strong> ' + data[i].WebAddress + '<br/>';
						html += '<span>Approximate Location: ' + data[i].ApproxLocation + '</span><br/></div>';
						html += '<div id="details">';
					
						html += '<strong>Questions/Comments</strong><br>';
						html +=  notes;
						html += '</div>';
						html += '</div>';
						html += '</div>';
						html += '</div>';
						
					var learnMore = getLearnMore(data[i].id);
					var buttons = getButtons(data[i].id, 'technical_support');
					
					$('#web-leads').append(learnMore + html + buttons);
					getTechnicalSupportCount();
					
					// Set "div" and "more" jQuery aliases
					var dataID = data[i].id
					var div = $('#row' + dataID);
					var more = $('#more' + dataID);
					
					// Hide the body of the lead; just show the title bar and the first line
					div.hide();
					
					// Create click event for each "+" button
					more.on("click", {target: div}, function(e){
    					e.data.target.slideToggle();
					});
				}
				getTechnicalSupportCount(cp_id);
			} else {
				$('#web-leads').html(technicalSupportNone);
				getTechnicalSupportCount(cp_id);
			}
		}, "json"
	);
}

function getConfiguratorJson(cp_id)
{
	resetHtml();
	highlightNav('configurator');
	$.post(url + 'configurator', {cp_id: cp_id}, 
		function(data) {	
			if (!$.isEmptyObject(data)) {
				for (var i = 0; i < data.length; i++) {
					if (data[i].City != '') {
						var address = data[i].Addr1 + ', ' +  data[i].City +  ', ' +  data[i].State +  ', ' +  data[i].Country +  ', ' +  data[i].Zip;
					} else {
						var address = noAddress;
					}
					
					if (data[i].Phone != '') {
						var phone = data[i].Phone;
					} else {
						var phone = noPhone;
					}
					
					if (data[i].DealerName != 'null') {
						var cp = noCP;
					} else {
						var cp = data[i].dealerName;
					}
					
					if (data[i].GeneralNotes != '') {
						var notes = data[i].GeneralNotes;
					} else {
						var notes = noNotes;
					}
					
					if (data[i].OptionsInterest != '') {
						var option = data[i].OptionsInterest;
					} else {
						var option = noOptions;
					}
					
					if (data[i].AccessoryInterest != '') {
						var acc = data[i].AccessoryInterest;
					} else {
						var acc = noAccessories;
					}
					
					if (!$.isEmptyObject(data[i].datestamp))
					{
						var d = formatMysqlDate(data[i].datestamp);
					}
					
					var	html  = '<div id="lead-info">';
						html += '<div id="leadID">Lead ID# ' + '' + 'Date: ' + d + '</div>';
						html += '<div id="company">' + 'No company given' + '</div>';
						html += '<div id="name">' + data[i].FName + ' ' + data[i].LName + '</div>';
						html += '<div id="email"><a href="mailto:' + data[i].EmailAddr + '">' + data[i].EmailAddr + '</a></div>';
						html += '<br class="clearall">';
					
						html += '<div>';
					
						html += '<div id="row' + data[i].id + '">'
						html += '<div id="phone">' +  phone + '</div>';
						html += '<div id="source">' +  data[i].url + '</div>';
						html += '<div id="cp-name">' +  cp + '</div>';
						html += '<br class="clearall">';
					
						html += '<div id="location">' + 'No location given' + '<br>';
						html += '<strong>IP Address:</strong> ' + data[i].WebAddress + '<br/>';
						html += '<span>Approximate Location: ' + data[i].ApproxLocation + '</span><br/></div>';
						html += '<div id="details">';
						html += '<div id="platformInterest"><strong>Platform:</strong> ' + data[i].PlatformInterest + '</div>';
						html += '<div id="powerInterest"><strong>Power Level:</strong> ' + data[i].PowerInterest + '</div>';
						html += '<div id="optionsInterest"><strong>Options:</strong> ' + option + '</div>';
						html += '<div id="accessoriesInterest"><strong>Accessories:</strong> ' + acc + '</div>';
					
						html += '<strong>Questions/Comments</strong><br>';
						html +=  notes;
						html += '</div>';
						html += '</div>';
						html += '</div>';
						html += '</div>';
						
					var learnMore = getLearnMore(data[i].id);
					var buttons = getButtons(data[i].id, 'configurator');
					
					$('#web-leads').append(learnMore + html + buttons);	
					
					// Set "div" and "more" jQuery aliases
					var dataID = data[i].id
					var div = $('#row' + dataID);
					var more = $('#more' + dataID);
					
					// Hide the body of the lead; just show the title bar and the first line
					div.hide();
					
					// Create click event for each "+" button
					more.on("click", {target: div}, function(e){
    					e.data.target.slideToggle();
					});
				}
				getConfiguratorCount(cp_id);
				
			} else {
				$('#web-leads').html(configuratorNone);
				getConfiguratorCount(cp_id);
			}
		}, "json"
	);
}

function getSpamJson(cp_id)
{
	resetHtml();
	highlightNav('spam');
	$.post(url + 'spam', {cp_id: cp_id},  
		function(data) {	
			if (!$.isEmptyObject(data)) {
				for (var i = 0; i < data.length; i++) {
					if (data[i].City != '') {
						var address = data[i].Addr1 + ', ' +  data[i].City +  ', ' +  data[i].State +  ', ' +  data[i].Country +  ', ' +  data[i].Zip;
					} else {
						var address = noAddress;
					}
					
					if (data[i].Phone != '') {
						var phone = data[i].Phone;
					} else {
						var phone = noPhone;
					}
					
					if (data[i].DealerName != 'null') {
						var cp = noCP;
					} else {
						var cp = data[i].dealerName;
					}
					
					if (data[i].GeneralNotes != '') {
						var notes = data[i].GeneralNotes;
					} else {
						var notes = noNotes;
					}
					
					if (data[i].OptionsInterest != '') {
						var option = data[i].OptionsInterest;
					} else {
						var option = noOptions;
					}
					
					if (data[i].AccessoryInterest != '') {
						var acc = data[i].AccessoryInterest;
					} else {
						var acc = noAccessories;
					}
					
					if (!$.isEmptyObject(data[i].FName)) {
						var name = data[i].FName + ' ' + data[i].LName;
					}
					if (!$.isEmptyObject(data[i].FirstName)) {
						var name = data[i].FirstName + ' ' + data[i].LastName;
					} 
					
					if (!$.isEmptyObject(data[i].datestamp)) {
						var stamp = data[i].datestamp;
					}
					if (!$.isEmptyObject(data[i].timestamp)) {
						var stamp = data[i].timestamp;
					}
					
					d = formatMysqlDate(stamp); 
					
					var	html  = '<div id="lead-info">';
						html += '<div id="leadID">Lead ID# ' + '' + 'Date: ' + d + '</div>';
						html += '<div id="company">' + 'No company given' + '</div>';
						html += '<div id="name">' + name + '</div>';
						html += '<div id="email"><a href="mailto:' + data[i].EmailAddr + '">' + data[i].EmailAddr + '</a></div>';
						html += '<br class="clearall">';
					
						html += '<div>';
					
						html += '<div id="row' + data[i].id + '">'
						html += '<div id="phone">' +  phone + '</div>';
						html += '<div id="source">' +  data[i].url + '</div>';
						html += '<div id="cp-name">' +  cp + '</div>';
						html += '<br class="clearall">';
					
						html += '<div id="location">' + 'No location given' + '<br>';
						html += '<strong>IP Address:</strong> ' + data[i].WebAddress + '<br/>';
						html += '<span>Approximate Location: ' + data[i].ApproxLocation + '</span><br/></div>';
						html += '<div id="details">';
						html += '<div id="platformInterest"><strong>Platform:</strong> ' + data[i].PlatformInterest + '</div>';
						html += '<div id="powerInterest"><strong>Power Level:</strong> ' + data[i].PowerInterest + '</div>';
						html += '<div id="optionsInterest"><strong>Options:</strong> ' + option + '</div>';
						html += '<div id="accessoriesInterest"><strong>Accessories:</strong> ' + acc + '</div>';
					
						html += '<strong>Questions/Comments</strong><br>';
						html +=  notes;
						html += '</div>';
						html += '</div>';
						html += '</div>';
						html += '</div>';
						
					var learnMore = getLearnMore(data[i].id);
					var buttons = getSpamButtons(data[i].id, 'spam');
					
					$('#web-leads').append(learnMore + html + buttons);	
					
					// Set "div" and "more" jQuery aliases
					var dataID = data[i].id
					var div = $('#row' + dataID);
					var more = $('#more' + dataID);
					
					// Hide the body of the lead; just show the title bar and the first line
					div.hide();
					
					// Create click event for each "+" button
					more.on("click", {target: div}, function(e){
    					e.data.target.slideToggle();
					});
				}
				getSpamCount(cp_id);
				
			} else {
				$('#web-leads').html(spamNone);
				getSpamCount(cp_id);
			}
		}, "json"
	);
}

function getVerifiedJson(cp_id)
{
	resetHtml();
	highlightNav('verified');
	$.post(url + 'verified', {cp_id: cp_id}, 
		function(data) {	
			if (!$.isEmptyObject(data)) {
				for (var i = 0; i < data.length; i++) {
					if (data[i].City != '') {
						var address = data[i].Addr1 + ', ' +  data[i].City +  ', ' +  data[i].State +  ', ' +  data[i].Country +  ', ' +  data[i].Zip;
					} else {
						var address = noAddress;
					}
					if (data[i].Phone != '') {
						var phone = data[i].Phone;
					} else {
						var phone = noPhone;
					}
					
					if (data[i].DealerName != 'null') {
						var cp = noCP;
					} else {
						var cp = data[i].dealerName;
					}
					
					if (data[i].GeneralNotes != '') {
						var notes = data[i].GeneralNotes;
					} else {
						var notes = noNotes;
					}
					
					if (data[i].OptionsInterest != '') {
						var option = data[i].OptionsInterest;
					} else {
						var option = noOptions;
					}
					
					if (data[i].AccessoryInterest != '') {
						var acc = data[i].AccessoryInterest;
					} else {
						var acc = noAccessories;
					}
					
					if (!$.isEmptyObject(data[i].FName)) {
						var name = data[i].FName + ' ' + data[i].LName;
					}
					if (!$.isEmptyObject(data[i].FirstName)) {
						var name = data[i].FirstName + ' ' + data[i].LastName;
					}
					
					if (!$.isEmptyObject(data[i].datestamp)) {
						var stamp = data[i].datestamp;
					}
					if (!$.isEmptyObject(data[i].timestamp)) {
						var stamp = data[i].timestamp;
					}
					
					d = formatMysqlDate(stamp); 
					
					var	html  = '<div id="lead-info">';
						html += '<div id="leadID">Lead ID# ' + '' + 'Date: ' + d + '</div>';
						html += '<div id="company">' + 'No company given' + '</div>';
						html += '<div id="name">' + name + '</div>';
						html += '<div id="email"><a href="mailto:' + data[i].EmailAddr + '">' + data[i].EmailAddr + '</a></div>';
						html += '<br class="clearall">';
					
						html += '<div>';
					
						html += '<div id="row' + data[i].id + '">'
						html += '<div id="phone">' +  phone + '</div>';
						html += '<div id="source">' +  data[i].url + '</div>';
						html += '<div id="cp-name">' +  cp + '</div>';
						html += '<br class="clearall">';
					
						html += '<div id="location">' + 'No location given' + '<br>';
						html += '<strong>IP Address:</strong> ' + data[i].WebAddress + '<br/>';
						html += '<span>Approximate Location: ' + data[i].ApproxLocation + '</span><br/></div>';
						html += '<div id="details">';
						html += '<div id="platformInterest"><strong>Platform:</strong> ' + data[i].PlatformInterest + '</div>';
						html += '<div id="powerInterest"><strong>Power Level:</strong> ' + data[i].PowerInterest + '</div>';
						html += '<div id="optionsInterest"><strong>Options:</strong> ' + option + '</div>';
						html += '<div id="accessoriesInterest"><strong>Accessories:</strong> ' + acc + '</div>';
					
						html += '<strong>Questions/Comments</strong><br>';
						html +=  notes;
						html += '</div>';
						html += '</div>';
						html += '</div>';
						html += '</div>';
						
					var learnMore = getLearnMore(data[i].id);
					var buttons = getVerifyButtons(data[i].id, 'verified');
					
					$('#web-leads').append(learnMore + html + buttons);	
					
					// Set "div" and "more" jQuery aliases
					var dataID = data[i].id
					var div = $('#row' + dataID);
					var more = $('#more' + dataID);
					
					// Hide the body of the lead; just show the title bar and the first line
					div.hide();
					
					// Create click event for each "+" button
					more.on("click", {target: div}, function(e){
    					e.data.target.slideToggle();
					});
				}
				getVerifiedCount(cp_id);
				
			} else {
				$('#web-leads').html(verifiedNone);
				getVerifiedCount(cp_id);
			}
		}, "json"
	);
}

function getAllJson(cp_id)
{
	resetHtml();
	highlightNav('seeAll');
	$.ajax({
		url: url + 'all', 
		data: "cp_id=" + cp_id,
		dataType: 'json',
		type: 'POST',
		beforeSend: function() {
			$('#web-leads').html('<img src="http://www.ulsinc.com/imgs/loading2.gif" />');
		},
		success: function(data, status, xhr) {	
			$('#web-leads').html('');
			if (!$.isEmptyObject(data)) {
				for (var i = 0; i < data.length; i++) {
					if (data[i].City != '') {
						var address = data[i].Addr1 + ', ' +  data[i].City +  ', ' +  data[i].State +  ', ' +  data[i].Country +  ', ' +  data[i].Zip;
					} else {
						var address = noAddress;
					}
					
					if (data[i].Phone != '') {
						var phone = data[i].Phone;
					} else {
						var phone = noPhone;
					}
					
					if (data[i].DealerName != 'null') {
						var cp = noCP;
					} else {
						var cp = data[i].dealerName;
					}
					
					if (data[i].GeneralNotes != '') {
						var notes = data[i].GeneralNotes;
					} else {
						var notes = noNotes;
					}
					
					if (data[i].OptionsInterest != '') {
						var option = data[i].OptionsInterest;
					} else {
						var option = noOptions;
					}
					
					if (data[i].AccessoryInterest != '') {
						var acc = data[i].AccessoryInterest;
					} else {
						var acc = noAccessories;
					}
					
					if (!$.isEmptyObject(data[i].FName)) {
						var name = data[i].FName + ' ' + data[i].LName;
					}
					if (!$.isEmptyObject(data[i].FirstName)) {
						var name = data[i].FirstName + ' ' + data[i].LastName;
					} 
					
					if (!$.isEmptyObject(data[i].datestamp)) {
						var stamp = data[i].datestamp;
					}
					if (!$.isEmptyObject(data[i].timestamp)) {
						var stamp = data[i].timestamp;
					}
					
					d = formatMysqlDate(stamp); 
					
					var	html  = '<div id="lead-info">';
						html += '<div id="leadID">Lead ID# ' + '' + 'Date: ' + d + '</div>';
						html += '<div id="company">' + 'No company given' + '</div>';
						html += '<div id="name">' + name + '</div>';
						html += '<div id="email"><a href="mailto:' + data[i].EmailAddr + '">' + data[i].EmailAddr + '</a></div>';
						html += '<br class="clearall">';
					
						html += '<div>';
					
						html += '<div id="row' + data[i].id + '">'
						html += '<div id="phone">' +  phone + '</div>';
						html += '<div id="source">' +  data[i].url + '</div>';
						html += '<div id="cp-name">' +  cp + '</div>';
						html += '<br class="clearall">';
					
						html += '<div id="location">' + 'No location given' + '<br>';
						if (!$.isEmptyObject(data[i].WebAddress)) {
							html += '<strong>IP Address:</strong> ' + data[i].WebAddress + '<br/>';
						}
						if (!$.isEmptyObject(data[i].IPAddress)) {
							html += '<strong>IP Address:</strong> ' + data[i].IPAddress + '<br/>';
						}
						if (!$.isEmptyObject(data[i].ApproxLocation)) {
							html += '<span>Approximate Location: ' + data[i].ApproxLocation + '</span><br/></div>';
						}
						
						html += '<div id="details">';
						
						if (!$.isEmptyObject(data[i].PlatformInterest)) {
							html += '<div id="platformInterest"><strong>Platform:</strong> ' + data[i].PlatformInterest + '</div>';
						}
						if (!$.isEmptyObject(data[i].PowerInterest)) {
							html += '<div id="powerInterest"><strong>Power Level:</strong> ' + data[i].PowerInterest + '</div>';
						}
						if (!$.isEmptyObject(option)) {
							html += '<div id="optionsInterest"><strong>Options:</strong> ' + option + '</div>';
						}
						if (!$.isEmptyObject(acc)) {
							html += '<div id="accessoriesInterest"><strong>Accessories:</strong> ' + acc + '</div>';
						}
						
						html += '<strong>Questions/Comments</strong><br>';
						html +=  notes;
						html += '</div>';
						html += '</div>';
						html += '</div>';
						html += '</div>';
						
					var learnMore = getLearnMore(data[i].id);
					var buttons = getButtons(data[i].id, 'verified');
					
					$('#web-leads').append(learnMore + html + buttons);	
					
					// Set "div" and "more" jQuery aliases
					var dataID = data[i].id
					var div = $('#row' + dataID);
					var more = $('#more' + dataID);
					
					// Hide the body of the lead; just show the title bar and the first line
					div.hide();
					
					// Create click event for each "+" button
					more.on("click", {target: div}, function(e){
    					e.data.target.slideToggle();
					});
				}
				getVerifiedCount(cp_id);
				
			} else {
				$('#web-leads').html(allNone);
				getVerifiedCount(cp_id);
			}
		},
		error: function(xhr, status, error) {
			alert('Error occurred: ' + status + ' ' + error);	
		}
	
	});
}

function getDuplicatesJson(cp_id)
{
	resetHtml();
	highlightNav('duplicates');
	$.ajax({
		url: url + 'duplicates', 
		data: "cp_id=" + cp_id,
		dataType: 'json',
		type: 'POST',
		beforeSend: function() {
			$('#web-leads').html('<img src="http://www.ulsinc.com/imgs/loading2.gif" />');
		},
		success: function(data, status, xhr) {	
			$('#web-leads').html('');
			if (!$.isEmptyObject(data)) {
				for (var i = 0; i < data.length; i++) {
					if (data[i].City != '') {
						var address = data[i].Addr1 + ', ' +  data[i].City +  ', ' +  data[i].State +  ', ' +  data[i].Country +  ', ' +  data[i].Zip;
					} else {
						var address = noAddress;
					}
					
					if (data[i].Phone != '') {
						var phone = data[i].Phone;
					} else {
						var phone = noPhone;
					}
					
					if (data[i].DealerName != 'null') {
						var cp = noCP;
					} else {
						var cp = data[i].dealerName;
					}
					
					if (data[i].GeneralNotes != '') {
						var notes = data[i].GeneralNotes;
					} else {
						var notes = noNotes;
					}
					
					if (data[i].OptionsInterest != '') {
						var option = data[i].OptionsInterest;
					} else {
						var option = noOptions;
					}
					
					if (data[i].AccessoryInterest != '') {
						var acc = data[i].AccessoryInterest;
					} else {
						var acc = noAccessories;
					}
					
					if (!$.isEmptyObject(data[i].FName)) {
						var name = data[i].FName + ' ' + data[i].LName;
					}
					if (!$.isEmptyObject(data[i].FirstName)) {
						var name = data[i].FirstName + ' ' + data[i].LastName;
					} 
					
					if (!$.isEmptyObject(data[i].datestamp)) {
						var stamp = data[i].datestamp;
					}
					if (!$.isEmptyObject(data[i].timestamp)) {
						var stamp = data[i].timestamp;
					}
					
					d = formatMysqlDate(stamp); 
					
					var	html  = '<div id="lead-info">';
						html += '<div id="leadID">Lead ID# ' + '' + 'Date: ' + d + '</div>';
						html += '<div id="company">' + 'No company given' + '</div>';
						html += '<div id="name">' + name + '</div>';
						html += '<div id="email"><a href="mailto:' + data[i].EmailAddr + '">' + data[i].EmailAddr + '</a></div>';
						html += '<br class="clearall">';
					
						html += '<div>';
						
						html += '<div id="row' + data[i].id + '">'
						html += '<div id="phone">' +  phone + '</div>';
						html += '<div id="source">' +  data[i].url + '</div>';
						html += '<div id="cp-name">' +  cp + '</div>';
						html += '<br class="clearall">';
					
						html += '<div id="location">' + 'No location given' + '<br>';
						if (!$.isEmptyObject(data[i].WebAddress)) {
							html += '<strong>IP Address:</strong> ' + data[i].WebAddress + '<br/>';
						}
						if (!$.isEmptyObject(data[i].IPAddress)) {
							html += '<strong>IP Address:</strong> ' + data[i].IPAddress + '<br/>';
						}
						if (!$.isEmptyObject(data[i].ApproxLocation)) {
							html += '<span>Approximate Location: ' + data[i].ApproxLocation + '</span><br/></div>';
						}
						
						html += '<div id="details">';
						
						if (!$.isEmptyObject(data[i].PlatformInterest)) {
							html += '<div id="platformInterest"><strong>Platform:</strong> ' + data[i].PlatformInterest + '</div>';
						}
						if (!$.isEmptyObject(data[i].PowerInterest)) {
							html += '<div id="powerInterest"><strong>Power Level:</strong> ' + data[i].PowerInterest + '</div>';
						}
						if (!$.isEmptyObject(option)) {
							html += '<div id="optionsInterest"><strong>Options:</strong> ' + option + '</div>';
						}
						if (!$.isEmptyObject(acc)) {
							html += '<div id="accessoriesInterest"><strong>Accessories:</strong> ' + acc + '</div>';
						}
						
						html += '<strong>Questions/Comments</strong><br>';
						html +=  notes;
						html += '</div>';
						html += '</div>';
						html += '</div>';
						html += '</div>';
						
					var learnMore = getLearnMore(data[i].id);
					var buttons = getDuplicateButtons(data[i].id, 'verified');
					
					$('#web-leads').append(learnMore + html + buttons);	
					
					// Set "div" and "more" jQuery aliases
					var dataID = data[i].id
					var div = $('#row' + dataID);
					var more = $('#more' + dataID);
					
					// Hide the body of the lead; just show the title bar and the first line
					div.hide();
					
					// Create click event for each "+" button
					more.on("click", {target: div}, function(e){
    					e.data.target.slideToggle();
					});
				}
				getDuplicateCount(cp_id);
				
			} else {
				$('#web-leads').html(duplicatesNone);
				getDuplicateCount(cp_id);
			}
		},
		error: function(xhr, status, error) {
			alert('Error occurred: ' + status + ' ' + error);	
		}
	
	});
}


function getGlobalspecJson(cp_id)
{
	resetHtml();
	highlightNav('globalspec');
	$.post(url + 'globalspec', {cp_id: cp_id}, 
		function(data) {	
			if (!$.isEmptyObject(data)) {
				for (var i = 0; i < data.length; i++) {
					if (data[i].City != '') {
						if (data[i].Address2 != '') {
							var a1a2 = data[i].Address1 + ', ' + data[i].Address2;
						} else {
							var a1a2 = data[i].Address1;
						}
						var address = a1a2 + ', ' +  data[i].City +  ', ' +  data[i].State +  ', ' +  data[i].Country +  ', ' +  data[i].Zip;
					} else {
						var address = noAddress;
					}
					
					if (data[i].Phone != '') {
						var phone = data[i].Phone;
					} else {
						var phone = noPhone;
					}
					
					if (data[i].DealerName != 'null') {
						var cp = noCP;
					} else {
						var cp = data[i].dealerName;
					}
					
					if (data[i].AdditionalInfo != '') {
						var notes = data[i].AdditionalInfo + ' ' + data[i].EmailText;
					} else {
						var notes = noNotes;
					}
					
					if (data[i].OptionsInterest != '') {
						var option = data[i].OptionsInterest;
					} else {
						var option = noOptions;
					}
					
					if (data[i].AccessoryInterest != '') {
						var acc = data[i].AccessoryInterest;
					} else {
						var acc = noAccessories;
					}
					
					if (data[i].AdditionalInfo != '') {
						var notes = data[i].AdditionalInfo + ' ' + data[i].EmailText;
					} else {
						var notes = noNotes;
					}
					
					d = formatMysqlDate(data[i].timestamp);
					
					var	html  = '<div id="lead-info">';
						html += '<div id="leadID">Lead ID# ' + '' + 'Date: ' + d + '</div>';
						html += '<div id="company">' +  data[i].Company + '</div>';
						html += '<div id="name">' + data[i].FirstName + ' ' + data[i].LastName + '</div>';
						html += '<div id="email"><a href="mailto:' + data[i].Email + '">' + data[i].Email + '</a></div>';
						html += '<br class="clearall">';
					
						html += '<div>';
					
						html += '<div id="row' + data[i].id + '">'
						html += '<div id="phone">' +  phone + '</div>';
						html += '<div id="source">' +  'No URL given' + '</div>';
						html += '<div id="cp-name">' +  cp + '</div>';
						html += '<br class="clearall">';
					
						html += '<div id="location"><strong>Address:</strong>' + address + '<br>';
						html += '<strong>IP Address:</strong> ' + data[i].IPAddress + '<br/></div>';
						html += '<div id="details">';
					
						html += '<strong>Questions/Comments</strong><br>';
						html +=  notes;
						html += '</div>';
						html += '</div>';
						html += '</div>';
						html += '</div>';
						
					var learnMore = getLearnMore(data[i].id);
					var buttons = getButtons(data[i].id, 'globalspec');
					
					$('#web-leads').append(learnMore + html + buttons);	
					
					// Set "div" and "more" jQuery aliases
					var dataID = data[i].id
					var div = $('#row' + dataID);
					var more = $('#more' + dataID);
					
					// Hide the body of the lead; just show the title bar and the first line
					div.hide();
					
					// Create click event for each "+" button
					more.on("click", {target: div}, function(e){
    					e.data.target.slideToggle();
					});
				}
				getGlobalspecCount(cp_id);
				
			} else {
				$('#web-leads').html(globalspecNone);
				getGlobalspecCount(cp_id);
			}
		}, "json"
	);
}

function getAppsLabJson(cp_id)
{
	resetHtml();
	highlightNav('appsLab');
	$.post(url + 'apps_lab', {cp_id: cp_id}, 
		function(data) {	
			if (!$.isEmptyObject(data)) {
				for (var i = 0; i < data.length; i++) {
					if (data[i].City != '') {
						var address = data[i].Addr1 + ', ' +  data[i].City +  ', ' +  data[i].State +  ', ' +  data[i].Country +  ', ' +  data[i].Zip;
					} else {
						var address = noAddress;
					}
					
					if (data[i].Phone != '') {
						var phone = data[i].Phone;
					} else {
						var phone = noPhone;
					}
					
					if (data[i].DealerName != 'null') {
						var cp = noCP;
					} else {
						var cp = data[i].dealerName;
					}
				
					if (data[i].Cutting == 1) {
						var cutting = 'Yes';
					} else {
						var cutting = 'No';
					}
					
					if (data[i].Marking == 1) {
						var marking = 'Yes';
					} else {
						var marking = 'No';
					}
					
					if (data[i].Imaging == 1) {
						var imaging = 'Yes';
					} else {
						var imaging = 'No';
					}
					
					if (data[i].Engraving == 1) {
						var engraving = 'Yes';
					} else {
						var engraving = 'No';
					}
					
					if (data[i].GeneralNotes != '') {
						var notes = data[i].GeneralNotes;
					} else {
						var notes = noNotes;
					}
					
					d = formatMysqlDate(data[i].datestamp);
					
					var	html  = '<div id="lead-info">';
						html += '<div id="leadID">Lead ID# ' + '' + 'Date: ' + d + '</div>';
						html += '<div id="company">' +  data[i].Company + '</div>';
						html += '<div id="name">' + data[i].FName + ' ' + data[i].LName + '</div>';
						html += '<div id="email"><a href="mailto:' + data[i].EmailAddr + '">' + data[i].EmailAddr + '</a></div>';
						html += '<br class="clearall">';
					
						html += '<div>';
					
						html += '<div id="row' + data[i].id + '">'
						html += '<div id="phone">' +  phone + '</div>';
						html += '<div id="source">' +  data[i].url + '</div>';
						html += '<div id="cp-name">' +  cp + '</div>';
						html += '<br class="clearall">';
					
						html += '<div id="location"><strong>Address:</strong>' + address + '<br>';
						html += '<strong>IP Address:</strong> ' + data[i].WebAddress + '<br/></div>';
						html += '<div id="details">';
						html += '<div id="industry"><strong>Industry:</strong> ' + data[i].Industry + '<br/></div>';
						html += '<div id="otherIndustry"><strong>Other Industry:</strong> ' + data[i].OtherIndustry + '<br/></div>';
						html += '<div id="material"><strong>Material:</strong> ' + data[i].Material + '<br/></div>';
						html += '<div id="otherMaterial"><strong>Other Material:</strong> ' + data[i].OtherMaterial + '<br/></div>';
						html += '<div id="process"><strong>Cutting:</strong> ' + cutting + '<br/></div>';
						html += '<div id="process"><strong>Marking:</strong> ' + marking + '<br/></div>';
						html += '<div id="process"><strong>Imaging:</strong> ' + imaging + '<br/></div>';
						html += '<div id="process"><strong>Engraving:</strong> ' + engraving + '<br/></div>';
					
						html += '<strong>Questions/Comments</strong><br>';
						html +=  notes;
						html += '</div>';
						html += '</div>';
						html += '</div>';
						html += '</div>';
						
					var learnMore = getLearnMore(data[i].id);
					var buttons = getButtons(data[i].id, 'apps_lab');
					
					$('#web-leads').append(learnMore + html + buttons);	
					
					// Set "div" and "more" jQuery aliases
					var dataID = data[i].id
					var div = $('#row' + dataID);
					var more = $('#more' + dataID);
					
					// Hide the body of the lead; just show the title bar and the first line
					div.hide();
					
					// Create click event for each "+" button
					more.on("click", {target: div}, function(e){
    					e.data.target.slideToggle();
					});
				}
				getGlobalspecCount(cp_id);
				
			} else {
				$('#web-leads').html(appsLabNone);
				getGlobalspecCount(cp_id);
			}
		}, "json"
	);
}

function getFinancingJson(cp_id)
{
	resetHtml();
	highlightNav('financing');
	$.post(url + 'financing', {cp_id: cp_id}, 
		function(data) {	
			if (!$.isEmptyObject(data)) {
				for (var i = 0; i < data.length; i++) {
					if (data[i].City != '') {
						var address = data[i].Addr1 + ', ' +  data[i].City +  ', ' +  data[i].State +  ', ' +  data[i].Country +  ', ' +  data[i].Zip;
					} else {
						var address = noAddress;
					}
					
					if (data[i].Phone != '') {
						var phone = data[i].Phone;
					} else {
						var phone = noPhone;
					}
					
					if (data[i].DealerName != 'null') {
						var cp = noCP;
					} else {
						var cp = data[i].dealerName;
					}
					
					if (data[i].GeneralNotes != '') {
						var notes = data[i].GeneralNotes;
					} else {
						var notes = noNotes;
					}
					
					if (data[i].Company != '') {
						var company = data[i].Company;
					} else {
						var company = noCompany;
					}
					
					d = formatMysqlDate(data[i].datestamp);
						
					var	html  = '<div id="lead-info">';
						html += '<div id="leadID">Lead ID# ' + '' + 'Date: ' + d + '</div>';
						html += '<div id="company">' + company + '</div>';
						html += '<div id="name">' + data[i].FName + ' ' + data[i].LName + '</div>';
						html += '<div id="email"><a href="mailto:' + data[i].EmailAddr + '">' + data[i].EmailAddr + '</a></div>';
						html += '<br class="clearall">';
					
						html += '<div>';
						html += '<div id="row' + data[i].id + '">'
						html += '<div id="phone">' +  phone + '</div>';
						html += '<div id="source">' +  data[i].url + '</div>';
						html += '<div id="cp-name">' +  cp + '</div>';
						html += '<br class="clearall">';
					
						html += '<div id="location">' + address + '<br>';
						html += '<strong>IP Address:</strong> ' + data[i].WebAddress + '<br/>';
						html += '<span>Approximate Location: ' + data[i].ApproxLocation + '</span><br/></div>';
						html += '<div id="details">';
					
						html += '<strong>Questions/Comments</strong><br>';
						html +=  notes;
						html += '</div>';
						html += '</div>';
						html += '</div>';
						html += '</div>';
						
					var learnMore = getLearnMore(data[i].id);
					var buttons = getButtons(data[i].id, 'financing');
					
					$('#web-leads').append(learnMore + html + buttons);
					
					// Set "div" and "more" jQuery aliases
					var dataID = data[i].id
					var div = $('#row' + dataID);
					var more = $('#more' + dataID);
					
					// Hide the body of the lead; just show the title bar and the first line
					div.hide();
					
					// Create click event for each "+" button
					more.on("click", {target: div}, function(e){
    					e.data.target.slideToggle();
					});
					
				}
				
				// reset the count
				getFinancingCount(cp_id);
				
			} else {
				$('#web-leads').html(financingNone);
				getFinancingCount(cp_id);
			}
		}, "json"
	);
}

// Return HTML

function getLearnMore(id) {
	var learnMore =  '<div id="lead' + id + '">';
		learnMore += '<div id="learnmore">';
		learnMore += '<a href="#" class="more" id="more' + id + '">+</a>';
		learnMore += '</div>';
	
	return learnMore;
}

function getButtons(id, table) {
	var buttons  = '<div id="learnmore">';
		buttons += '<a class="markAsVerified" href="#" id="' + id + '|' + table + '">Verify</a>';
		buttons += '<a class="markAsSpam" href="#" id="' + id + '|' + table + '">Spam</a>';
		buttons += '<a class="markAsDuplicate" href="#" id="' + id + '|' + table + '">Duplicate</a>';
		buttons += '</div>';
		buttons += '</div></div><br class="clearall">';
		
	return buttons;
}

function getSpamButtons(id, table) {
	var buttons  = '<div id="learnmore">';
		buttons += '<a class="markAsVerified" href="#" id="' + id + '|' + table + '">Verify</a>';
		buttons += '<a class="markAsNotSpam" href="#" id="' + id + '|' + table + '">Not Spam</a>';
		buttons += '<a class="markAsDuplicate" href="#" id="' + id + '|' + table + '">Duplicate</a>';
		buttons += '</div>';
		buttons += '</div></div><br class="clearall">';
		
	return buttons;
}

function getDuplicateButtons(id, table) {
	var buttons  = '<div id="learnmore">';
		buttons += '<a class="markAsVerified" href="#" id="' + id + '|' + table + '">Verify</a>';
		buttons += '<a class="markAsDuplicate" href="#" id="' + id + '|' + table + '">Not Duplicate</a>';
		buttons += '</div>';
		buttons += '</div></div><br class="clearall">';
		
	return buttons;
}

function getVerifyButtons(id, table) {
	var buttons  = '<div id="learnmore">';
		buttons += '<a class="markAsVerified" href="#" id="' + id + '|' + table + '">Verified!</a>';
		buttons += '</div>';
		buttons += '</div></div><br class="clearall">';
		
	return buttons;
}



// Counts
function getAppsLabCount(cp_id) {
	$.post(url + 'count_apps_lab_leads', {cp_id: cp_id},
		function(data) {
			$('#appsCount').html(data);
		}, "json"
	);
}

function getConfiguratorCount(cp_id) {
	$.post(url + 'count_configurator_leads', {cp_id: cp_id},
		function(data) {
			$('#configuratorCount').html(data);	
		}, "json"
	);
}


function getConfiguratorContactCount(cp_id) {
	$.post(url + 'count_configurator_contact_leads', {cp_id: cp_id},
		function(data) {
			$('#helpCount').html(data);	
		}, "json"
	);
}

function getFinancingCount(cp_id) {
	$.post(url + 'count_financing_leads', {cp_id: cp_id},
		function(data) {
			$('#financingCount').html(data);	
		}, "json"
	);
}

function getGlobalspecCount(cp_id) {
	$.post(url + 'count_globalspec_leads', {cp_id: cp_id},
		function(data) {
			$('#globalspecCount').html(data);	
		}, "json"
	);
}

function getLandingPagesCount(cp_id) {
	$.post(url + 'count_landing_pages_leads', {cp_id: cp_id},
		function(data) {
			$('#landingPagesCount').html(data);	
		}, "json"
	);
}

function getMainContactCount(cp_id) {
	$.post(url + 'count_main_contact_leads', {cp_id: cp_id},
		function(data) {
			$('#contactCount').html(data);	
			return data;
		}, "json"
	);
}


function getOneTouchCount(cp_id) {
	$.post(url + 'count_one_touch_leads', {cp_id: cp_id},
		function(data) {
			$('#oneTouchCount').html(data);	
		}, "json"
	);
}

function getSendMessageCount(cp_id) {
	$.post(url + 'count_send_message_leads', {cp_id: cp_id},
		function(data) {
			$('#sendMessageCount').html(data);	
		}, "json"
	);
}

function getTechnicalSupportCount(cp_id) {
	$.post(url + 'count_technical_support_leads', {cp_id: cp_id},
		function(data) {
			$('#technicalSupportCount').html(data);	
		}, "json"
	);
}

function getThirdPartyCount(cp_id) {
	$.post(url + 'count_third_party_leads', {cp_id: cp_id},
		function(data) {
			$('#thirdPartyCount').html(data);	
		}, "json"
	);
}

function getSpamCount(cp_id) {
	$.post(url + 'count_spam_leads', {cp_id: cp_id},
		function(data) {
			$('.spamCount').html(data);	
			$('#spamCount').html(data);	
		}, "json"
	);
}

function getVerifiedCount(cp_id) {
	$.post(url + 'count_verified_leads', {cp_id: cp_id},
		function(data) {
			$('#verifiedCount').html(data);	
		}, "json"
	);
}

function getAllFlaggedCount(cp_id) {
	$.post(url + 'count_all_flagged', {cp_id: cp_id},
		function(data) {
			$('#allCount').html(data);	
			$('#totalCount').html(data);
			$('title').append('| Leads Total (' + data + ')');
		}, "json"
	);
}

function getDuplicateCount(cp_id) {
	$.post(url + 'count_duplicates', {cp_id: cp_id},
		function(data) {
			$('#duplicateCount').html(data);
		}, "json"
	);
}

// Update DOM
function resetHtml() {
	$('#web-leads').html('');
}

function formatMysqlDate(datestamp) {
	// Format MySQL date
	var t = datestamp.split(/[- :]/);
	var d = new Date(t[0], t[1]-1, t[2], t[3], t[4], t[5]);
	var year = d.getFullYear();
	var mo = d.getMonth();
	var month;
	var day = d.getDate();
	var h = d.getHours();
	var hours;
	var mn = d.getMinutes();
	var minutes;
	var ampm;
	
	switch (mo)
	{
		case 0:
			month = 'January';
			break;
		case 1:
			month = 'February';
			break;
		case 2:
			month = 'March';
			break;
		case 3:
			month = 'April';
			break;
		case 4:
			month = 'May';
			break;
		case 5:
			month = 'June';
			break;
		case 6:
			month = 'July';
			break;
		case 7:
			month = 'August';
			break;
		case 8:
			month = 'September';
			break;
		case 9:
			month = 'October';
			break;
		case 10:
			month = 'November';
			break;
		case 11:
			month = 'December';
			break;
		default:
			month = 'No month given';
	}
	
	if (mn < 10) { 
		minutes = '0' + mn;
	} else {
		minutes = mn;
	}
	
	if (h > 12) {
		hours = h - 12;
		ampm = 'PM';
	} else if(h == 12) {
		hours = h;
		ampm = 'PM'
	} else {
		hours = h;
		ampm = 'AM';
	}
	
	
	return month + ' ' + day + ', ' + year + ' ' + hours + ':' + minutes + ' ' + ampm + ' (Arizona time)';
}

// Navigation CSS
function highlightNav(id) {
	restoreNav();
	if (id != 'spam') {
		$('#' + id).css('background-color', '#666').css('color', '#FFF');
		$ ('.spam').css('background-color', '#EEE').css('color', '#333');
	} else {
		$ ('.' + id).css('background-color', '#666').css('color', '#FFF');
	}
}

function restoreNav() {
	var bc = '#EEE';
	var c = '#333';
	
	$('#contactUs').css('background-color', bc).css('color', c);
	$('#configurator').css('background-color', bc).css('color', c);
	$('#sendMessage').css('background-color', bc).css('color', c);
	$('#appsLab').css('background-color', bc).css('color', c);
	$('#oneTouch').css('background-color', bc).css('color', c);
	$('#landingPages').css('background-color', bc).css('color', c);
	$('#technicalSupport').css('background-color', bc).css('color', c);
	$('#configuratorContact').css('background-color', bc).css('color', c);
	$('#globalspec').css('background-color', bc).css('color', c);
	$('#spam').css('background-color', bc).css('color', c);
	$('#seeAll').css('background-color', bc).css('color', c);
	$('#verified').css('background-color', bc).css('color', c);
	$('#duplicates').css('background-color', bc).css('color', c);
	$('#financing').css('background-color', bc).css('color', c);
}









