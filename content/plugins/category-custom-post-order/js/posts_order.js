jQuery(function($) {
	$("#tpo-the-list").sortable();
	$(".reverse").click(function(){
		var list = $('#tpo-the-list');
		var listItems = list.children('li');
		list.append(listItems.get().reverse());
	});
	
	$('#tpo_orderby').on('change', function() {
		if( this.value == 'postmeta' ) {
			$('#tpo_meta_value').removeClass('hidden');
		} else {
			$('#tpo_meta_value').addClass('hidden');
		}
		if( this.value == 'custom' || this.value == 'default' ) {
			$('#tpo_order').addClass('hidden');
		} else {
			$('#tpo_order').removeClass('hidden');
		}
	});
	
});