$(document).ready(function() {
 	$('#suban-list').dataTable()

	$('#btn-cancel').click(function(e) {
		e.preventDefault()
		let el = $(this)
 		window.location.href = el.attr('href');
 	})

	function validation(message) {
		var t = this
		let form = '#suban_form'
		formValidation(form,
			{
				suban_name: { required: true }
			},
			{},
			(form)=>{
				submitHandler(form, message)
			}
		);
	}

	function submitHandler(form, message) {
		let t = this
		let subanName = $('input[name="suban_name"]').val()
		let status = ''
		let args = {
			suban_name : subanName
		}
		$.post({
	        url	: 'before_saving',
	        data: args,
	        success: function(jsonData){      
				status = `${jsonData[11]}${jsonData[12]}${jsonData[13]}${jsonData[14]}`
				if (status == 'true') {
					toastr['success'](message)
					let delay = 1000;
					setTimeout(function() {
	 					form.submit()
					}, delay);
				} else {
					toastr['warning']('Nama suku badan pajak sudah tersedia')
				}
	    	},
	    	error: function(jsonData){      
	        	
	     	}
	    });
	}

 	$('#btn-submit').click(function(e) {
 		let el = $(this)

 		let type = el.attr('btn-type')
 		let message = null
 		if (type == 'create') {
 			message = 'Data suku badan pajak berhasil disimpan '
 		} else {
			message = 'Data suku badan pajak diperbarui.'
 		}

 		validation(message)
 	})

 	$('.delete-control').click(function(e) {
 		e.preventDefault()
 		let el 	= $(this)
 		subanId = el.attr('data-suban-id')

 		let args = {
 			suban_id : subanId
 		}
 		
 		$.post({
 			url		: 'before_delete',
 			data 	: args,
 			success	: function(jsonData) {
 				status = `${jsonData[11]}${jsonData[12]}${jsonData[13]}${jsonData[14]}`
 				if (status == 'true') {
 					if (confirm('Yakin akan menghapus data ?')) {
 						toastr['success']('Data berhasil dihapus')
						let delay = 2000;
						setTimeout(function() {
		 					window.location.href = el.attr('href');
						}, delay)
			 		}
 				} else {
 					toastr['warning']('Data suku badan pajak tidak bisa dihapus.')
 				}
 			},
 			
 			error	: function(jsonData) {
 				toastr['warning']('Terjadi kesalahan saat menghapus data.')
 			}
 		});
 	})
})