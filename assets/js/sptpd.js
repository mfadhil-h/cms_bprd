$(document).ready(function() {

	$('#btn-print').click(function(e) {
		e.preventDefault()
		let el = $(this)
 		window.location.href = el.attr('href');
 	})

 	$('.print').click(function(e) {
 		window.print()
 	})

 	$('.home').click(function(e) {
 		e.preventDefault()
		let el = $(this)
 		window.location.href = el.attr('href');
 	})
})