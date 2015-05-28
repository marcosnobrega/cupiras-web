/**
 * 
 */

function createModal(title, message) {
	var ModalHtml = '<div class="modal fade">';
	ModalHtml += '<div class="modal-dialog modal-sm">';
	ModalHtml += '<div class="modal-content">';
	ModalHtml += '<div class="modal-header">';
    ModalHtml += '<button type="button" class="close" data-dismiss="modal" aria-label="Close">';
    ModalHtml += '<span aria-hidden="true">&times;</span></button>';
    ModalHtml += '<h4 class="modal-title" id="myModalLabel">' + title + '</h4>';
    ModalHtml += '</div><div class="modal-body">';
    ModalHtml += message;
	ModalHtml += '</div></div></div></div>';
	return ModalHtml;
}

$(document).ready(function() {
	if ($('.successMessage').length > 0) {
		$(createModal("Sucesso", $('.successMessage').text())).modal('show');
	}
	if ($('.errorMessage').length > 0) {
		$(createModal("Erro", $('.errorMessage').text())).modal('show');
	}
});