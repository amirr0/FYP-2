$(function(e){

	//________ Data Table
	$('#project-list').DataTable({
		"order": [[ 0, "desc" ]],
		order: [],
		language: {
			searchPlaceholder: 'Search...',
			sSearch: '',

		}
	});

	//________ Datepicker
	$( '.fc-datepicker').datepicker({
		dateFormat: "dd M yy",
		monthNamesShort: [ "Jan", "Feb", "Mar", "Apr", "Maj", "Jun", "Jul", "Aug", "Sep", "Okt", "Nov", "Dec" ],
		zIndex: 999998,
	});

	/* Select2 */
	$('.select2').select2({
		minimumResultsForSearch: Infinity,
		width:'100%'
	});

 });


