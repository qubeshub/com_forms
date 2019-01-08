
const anchorId = 'form-builder-anchor'
var formBuilder

const getFormBuilder = () => {
	const $anchor = $(`#${anchorId}`)
	formBuilder = new HUB.FORMS.FormBuilder({$anchor})

	return formBuilder
}

const getPage = () => {
	const id = getPageId()
	const page = new HUB.FORMS.Page({id})

	return page
}

const getPageId = () => {
	const pageIdInputName = 'page_id'
	const pageIdInput = $('input[name=page_id]')

	const pageId = pageIdInput.val()

	return pageId
}

const registerSubmitHandler = (page) => {
	const $submitButton = $('.btn-success')

	$submitButton.click((e) => {
		submitForm(e, page)
	})
}

const submitForm = (e, page) => {
	e.preventDefault()

	const fields = formBuilder.getFields()
	page.setFields(fields)

	page.save()
}

$(document).ready(() => {
	Hubzero.initApi(() => {

		const formBuilder = getFormBuilder()
		const page = getPage()

		formBuilder.render()

		page.fetchFields().then((response) => {
			const currentFields = response['associations']
			formBuilder.setFields(currentFields)
		})

		registerSubmitHandler(page)
	})
})
