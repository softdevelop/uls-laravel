// JavaScript Document
window.onload = function() {
	new Ajax.Autocompleter("search_term", "autocomplete_choices", "http://www.ulsinc.com/materials_library/search_by_application/ajaxsearch", {});
}