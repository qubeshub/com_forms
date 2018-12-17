
const anchorId = 'form-builder-anchor'
var formBuilder

const getPageId = () => {
	const pageIdInputName = 'page_id'
	const pageIdInput = $('input[name=page_id]')

	const pageId = pageIdInput.val()

	return pageId
}

const submitForm = (e) => {
	e.preventDefault()

	const fields = formBuilder.getFields()
	const pageId = getPageId()
	const page = new HUB.FORMS.Page({id: pageId, fields})

	page.save()
}

$(document).ready(() => {
	Hubzero.initApi(() => {

		const $anchor = $(`#${anchorId}`)
		const $submitButton = $('.btn-success')

		formBuilder = new HUB.FORMS.FormBuilder({$anchor})
		formBuilder.render()

		$submitButton.click(submitForm)

	})
})
