
/* Custom JS App.JS */

/* Show File Name */
$('input[type="file"]').change(function(e){
	/* Get file name */
	var fileName = e.target.files.length > 0 ? e.target.files[0].name : 'Pilih berkas';

	/* Replace the "Choose a file" label */
	$('.custom-file-label').html(fileName);
});
