$(document).ready(function() {
	
});


function handleSelectBox(sourceId,targetId,link)
{
	$('#'+sourceId).change(function(){

		$('#loader').show();

		$('#'+targetId).empty();

		$.ajax({
			type: 'POST',
			url: link,
			data: {value:$('#'+sourceId).val() },
			dataType: 'json',
			success: function (data) {
				loadList(targetId, data);
			},
			error: function(){
				$('#loader').hide();
			}
		});

		return false;
	});

}


function loadList(id, response){
	$('#'+id).append($("<option></option>").attr("value",'').text(''));
	$.each(response, function(index, element) {
		$('#'+id).append($("<option></option>").attr("value",element.value).text(element.name));
	});

	$('#loader').hide();
}