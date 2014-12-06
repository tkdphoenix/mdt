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
 */
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

$(function(){
	/**
	 *	This block of code causes all checkboxes to be checked if the 
	 *	#checkAll checkbox at the top of the list on the default page 
	 *	is clicked to checked, and unchecks all the checkboxes if it is clicked 
	 *	to unchecked.
	 */
	$('#checkAll').on('click', function(){
		if($(this).is(':checked')){
			$(':checkbox').prop('checked', true);
		} else {
			$(':checkbox').prop('checked', false);
		}
	});

	/**
	 *	Review the active / inactive state of the page and show
	 *	the correct button.
	 */



});