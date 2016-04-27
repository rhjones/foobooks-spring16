$(document).ready(function() {
 
    $('#author_id').change(function() {
    	if(this.value == 'other') {
    		$('#add_author').show();
    	} else {
    		$('#add_author').hide();
    	}
    })
 
});