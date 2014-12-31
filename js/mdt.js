/**
 *	This is the document.ready() for the MDT project as well as various helper
 *	functions. Any js functionality	that needs to be inserted can be done here 
 *	using the jQuery library or native JavaScript.
 *	@author Joel Grissom
 */

/**
 *	Retrieve variables from the URL string and place them into an object
 *	for later use.
 *	@example: If there were a URL such as companies.php?inactive=true&id=5
 *	var urlVars = getUrlVars();
 *	urlVars === {
		inactive: true,
		id: 	  5
 *	}
 *	So a test can be run such as: (urlVars.inactive)? do this : do that;
 */
// for use with various functions to create a temporary string
var tempList = {};

/**
 *	Update list is a function to update hidden input fields but can be
 *	modified to accept other lists like JS variables.
 *	@string var e - the event captured from on click or other events
 *		causing the method to be called.
 *	@object var targetList - the HTML object (a hidden input) whose
 *		value is changed.
 */
function updateList(e, targetList){
    var id = e.target.id;
 	if($(e.target).is(':checked')){
 		(tempList.val == undefined ) ? tempList.val = id : tempList.val += "," + id;
 		while(tempList.val.indexOf(',') === 0){
 			tempList.val.substr(1);
 		}
 		targetList.val(tempList.val);
 	} else {
        var temp;
        // if(typeof tempList.val !== "undefined"){
        // 	continue;
        (tempList.val.indexOf(',') > -1) ? temp = tempList.val.split(',') : temp = [tempList.val];
        for(var i=0, ii=temp.length; i<ii; i++){
        	if(temp[i] == id){
        		temp.remove(id);
        	}
        } // END for loop
        tempList.val = temp.toString();
        targetList.val(tempList.val);
 	} // END else
}

function getUrlVars(){
    var vars = {}, hash;
    var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
    for(var i = 0; i < hashes.length; i++)
    {
        hash = hashes[i].split('=');
        // vars.push(hash[0]);
        vars[hash[0]] = hash[1];
    }
    return vars;
}

/**
 *	adds a remove method to an array object so that it will parse through 
 *	an array and look for tha value passed to .remove() and return the 
 *	remaining values in the array.
 */
Array.prototype.remove = function() {
    var what, a = arguments, L = a.length, ax;
    while (L && this.length) {
        what = a[--L];
        while ((ax = this.indexOf(what)) !== -1) {
            this.splice(ax, 1);
        }
    }
    return this;
};

$(function(){
	/**
	 *	This block of code causes all checkboxes to be checked if the 
	 *	#checkAll checkbox at the top of the list on the default page 
	 *	is clicked to checked, and unchecks all the checkboxes if it is clicked 
	 *	to unchecked.
	 */
	$('#checkAll').on('change', function(){
		var boxes = $(':checkbox');
		if($(this).is(':checked')){
			// i[0] is the master checkbox - exclude this one
			for(var i=1,ii=boxes.length; i<ii; i++){
				boxes[i].click();
			}
		} else {
			// i[0] is the master checkbox - exclude this one
			for(var i=1,ii=boxes.length; i<ii; i++){
				boxes[i].click();
			}
		}
	});

	/**
	 *	Review the active / inactive state of the page and show
	 *	the correct button. with the correct text.
	 */
	var urlVars = getUrlVars();
	var pathname = window.location.pathname;
	if(urlVars.inactive){
		$('#showInactive').prop({'href': pathname}).text('Show Active Only');
	} else {
		$('#showInactive').prop({'href': pathname+'?inactive=true'}).text('Show Inactive');
	}

	/**
	 *	To inactivate companies, employees or future uses. The idea is to provide
	 *	convenience to users. If the list is long, the button is at the bottom and
	 *	top for convenience. The bottom button is only to activate the top form 
	 *	button which also stores the values for those employees or companies that
	 *	are checked for inactivation. On the server side, the values can be parsed
	 *	into an array and submitted for inactivation.
	 */
	$('.toRemove').on('click', function(e){
		updateList(e, $('#iList'));
		if($('.toRemove').is(':checked')){
			$('#topInactive, #bottomInactive').prop('disabled', false);
		} else {
			$('#topInactive, #bottomInactive').prop('disabled', 'disabled');
		}
	}); // END $('.toRemove').on('click')

	// if the bottom inactivate button is clicked, create a click event
	// for the top button.
	$('#bottomInactive').on('click', function(){
		$('#topInactive').click();
	});

	/* @TODO form validation *****************************************/

	
	// if the inactivate button is clicked, confirm that a checkbox 
	// has been clicked
	$('#topInactive').on('click', function(e){
		var theBtn = $(this);
		if($('.toRemove').is(':checked')){
			e.stopPropagation();
			theBtn.prop('disabled', false);
		} else {
			theBtn.prop('disabled', 'disabled');
			$('#bottomInactive').prop('disabled', 'disabled');
		}
	});

	// Datepicker from jqueryUI
	// if there is no native date picker, display the jQuery UI datepicker
	if(!Modernizr.inputtypes.date){
		$('#testDate').datepicker({
			maxDate: "0",
			dateFormat: "yy-mm-dd"
		});		
	}




});