$(document).ready(function(){
// Executed once all the page elements are loaded

	// Convert the UL with all the tutorials into a sortable list:
	$("ul.sort").sortable({
		handle : '.tut-img',
		axis:'y',
		containment: 'document',
		opacity: 0.6
	});

	// The hover method takes a mouseover and a mouseout function:
	$(".tut").hover(

		function(){

			$(this).find('.drag-label').stop().animate({marginTop:'-25px'},'fast');
		},
		
		function(){
			
			$(this).find('.drag-label').stop().animate({marginTop:'0'},'fast');
		}
	);
	
	// Binding an action to the submitPoll button:
	
	$('#submitPoll').click(function(e){
	
		// We then turn the sortable into a comma-separated string
		// and assign it to the sortdata hidden form field:
		
		$('#sortdata').val($('ul.sort').sortable('toArray').join(','));
		
		// After this we submit the form:
		$('#sform').submit();

		// Preventing the default action triggered by clicking on the link
		e.preventDefault();
	});
	
});