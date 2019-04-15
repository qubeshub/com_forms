
var HUB = HUB || {}

HUB.FORMS = HUB.FORMS || {}

FORMS = HUB.FORMS

FORMS.emailButtonId = 'email-respondents-button'
FORMS.emailFormId = 'email-respondents-form'
FORMS.responseIdFieldsName = 'response_ids[]'

FORMS.getEmailButton = () => {
	return $(`#${FORMS.emailButtonId}`)
}

FORMS.registerEmailHandlers = ($emailButton) => {
	$emailButton.on('click', FORMS.submitEmailRespondentsForm)
}

FORMS.submitEmailRespondentsForm = () => {
	const $form = FORMS.getEmailRespondentsForm()

	if (FORMS.responsesSelected()) {
		FORMS.populateEmailRespondentForm($form)
		$form.submit()
	} else {
		FORMS.adviseUserToSelectResponses()
	}
}

FORMS.responsesSelected = () => {
	return FORMS.getSelectedResponsesIds().length > 0
}

FORMS.adviseUserToSelectResponses = () => {
	FORMS.Notify['warn']('Select at least one response from the list below')
}

FORMS.getEmailRespondentsForm = () => {
	return $(`#${FORMS.emailFormId}`)
}

FORMS.populateEmailRespondentForm = ($form) => {
	const selectedResponsesIds = FORMS.getSelectedResponsesIds()

	FORMS.addSelectedResponsesIds($form, selectedResponsesIds)
}

FORMS.getSelectedResponsesIds = () => {
	const $selectedResponsesCheckboxes = FORMS.getSelectedResponsesCheckboxes()
	const selectedResponsesIds = []

	$selectedResponsesCheckboxes.each((i, checkbox) => {
		selectedResponsesIds.push($(checkbox).val())
	})

	return selectedResponsesIds
}

FORMS.getSelectedResponsesCheckboxes = () => {
	const responseCheckboxes = $(`input[name="${FORMS.responseIdFieldsName}"]`)

	const $selectedCheckboxes = responseCheckboxes.filter((i, checkbox) => {
		return $(checkbox).is(':checked')
	})

	return $selectedCheckboxes
}

FORMS.addSelectedResponsesIds = ($form, selectedResponsesIds) => {
	selectedResponsesIds.forEach((responseId) => {
		FORMS.appendResponseIdInput(responseId, $form)
	})
}

FORMS.appendResponseIdInput = (responseId, $form) => {
	const responseIdInput = $(`<input type="hidden" name="response_ids[${responseId}]" value="${responseId}">`)

	$form.append(responseIdInput)
}
