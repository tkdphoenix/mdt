/**
 *	This is the document.ready() for the MDT project. Any js functionality
 *	that needs to be inserted can be done here using the jQuery library
 *	or native JavaScript.
 *	@author Joel Grissom
 */
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

});