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

/**
 *	For adding up all values on the test record pages
 */
function calcTotal(){
	// get values for rates
	numTests = ($('#numTests').val() === 'undefined' || $('#numTests').val() === '') ? 0 : parseFloat($('#numTests').val());
	firstTest = ($('#baseFee').val() === 'undefined' || $('#baseFee').val() === '') ? 0 : parseFloat($('#baseFee').val());
	additionalFees = ($('#additionalFees').val() === 'undefined' || $('#additionalFees').val() === '') ? 0 : parseFloat($('#additionalFees').val());
	fuelFee = ($('#fuelFee').val() === 'undefined' || $('#fuelFee').val() === '') ? 0 : parseFloat($('#fuelFee').val());
	pagerFee = ($('#pagerFee').val() === 'undefined' || $('#pagerFee').val() === '') ? 0 : parseFloat($('#pagerFee').val());
	waitTimeFee = ($('#waitTimeFee').val() === 'undefined' || $('#waitTimeFee').val() === '') ? 0 : parseFloat($('#waitTimeFee').val());
	driveTimeFee = ($('#driveTimeFee').val() === 'undefined' || $('#driveTimeFee').val() === '') ? 0 : parseFloat($('#driveTimeFee').val());
	adminFee = ($('#adminFee').val() === 'undefined' || $('#adminFee').val() === '') ? 0 : parseFloat($('#adminFee').val());
	trainingFee = ($('#trainingFee').val() === 'undefined' || $('#trainingFee').val() === '') ? 0 : parseFloat($('#trainingFee').val());
	holidayFee = ($('#holidayFee').val() === 'undefined' || $('#holidayFee').val() === '') ? 0 : parseFloat($('#holidayFee').val());
	miscFee = ($('#miscFee').val() === 'undefined' || $('#miscFee').val() === '') ? 0 : parseFloat($('#miscFee').val());

	subtotal = fuelFee + pagerFee + waitTimeFee + driveTimeFee + adminFee + trainingFee + holidayFee + miscFee;

	// test if the rate is hourly or per test calculate accordingly
	if($('#rateType').val() === 'hourly'){
		numHours = parseFloat($('#numHours').val());
		var baseFee = firstTest * numHours;
		var additionalFeesSubtotal = additionalFees * numHours;
		var total = baseFee + additionalFeesSubtotal + subtotal;
		return total;
	} else {
		var total = (additionalFees * (numTests-1)) + firstTest + subtotal;
		return total;
	}
}

/**
 *	add a zero if total is like ex: 29.5 to make 29.50 for USD
 *	add two zeros if total is like ex: 29 to make 29.00 for USD
 */
function addDecimalZeros(amt){
	var val = amt.toString();
	var decIndex = val.indexOf('.');
	var splitVal = val.split('.');
	// see if the decimal exists
	if(decIndex < 0){
		val = val + ".00";
		return val;
	} else if(decIndex && splitVal[1].length < 2){
		val = val + "0";
		return val;
	}
}

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

	/**
	 *	when the select tag for the rate is chosen on the 
	 *	"create new test record" page, the 'hourly' input tag is 
	 *	shown or not shown accordingly.
	 */
		
	$('#rateType').on('change', function(){
		// console.log('value: ' + $(this).val());
		if($(this).val() == 'hourly'){
			$('#lNumHours').show();
		} else {
			$('#lNumHours').hide();
		}
	});

	/**
	 *	check the value of rate type when the page is loaded.
	 *	If it is set to 'hourly', show the hours input box.
	 */
	 ($('#rateType').val() === 'hourly')? $('#lNumHours').show() : $('#lNumHours').hide();

	// evaluate total of rates each time a key is pressed
	$('.totalVals').on('blur', function(){
		var total = calcTotal();
		console.log('Total: ' + total);
		$('#totalAmtSpan').html(total);
	});

	// add dataTable() to all tables
	$('.table').dataTable();

	// remove the 'active' class from all <li> elements before adding the 'active' class to the current page
	$('#mainNav>li').removeClass('active');
	$('#mainNav>li>a>span').remove();
	var urlPath = window.location.pathname.substring(location.pathname.lastIndexOf("/") + 1);
	$('#mainNav>li>a').each(function(){
		if($(this).attr('href') === urlPath){
			$(this).append('<span class="sr-only">(current)</span>');
			$(this).parent().addClass('active');
		}
	});

	// handling $.on('change') event for drop down menus on reports and test summaries
	$(".reporting").on('change', function(){
		var selecttag = $(this);
		// need to get the id of the select and the value of the option to pull the correct report
		var selectid = selecttag.attr('id');
		var optid = selecttag.val();
		console.log(optid);
	}); // end $(".reporting").on('change') 
}); // end document.ready()