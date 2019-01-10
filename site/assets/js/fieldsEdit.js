
const anchorId = 'form-builder-anchor'
var formBuilder

const getFormBuilder = (pageId) => {
	const $anchor = $(`#${anchorId}`)
	const fieldClass = HUB.FORMS.ComFormsFormField

	formBuilder = new HUB.FORMS.ComFormsFormBuilder({
		$anchor, fieldClass, pageId
	})

	return formBuilder
}

const getPage = (id) => {
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

		const pageId = getPageId()
		const page = getPage(pageId)
		const formBuilder = getFormBuilder(pageId)

		formBuilder.render()

		page.fetchFields().then((response) => {
			const currentFields = response['associations']

			formBuilder.setFields(currentFields)
		})

		registerSubmitHandler(page)
	})
})
