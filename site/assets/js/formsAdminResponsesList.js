
$(document).ready(() => {

	FORMS.$emailButton = FORMS.getEmailButton()
	FORMS.$masterCheckbox = FORMS.getMasterCheckbox()
	FORMS.$responsesList = FORMS.getResponsesList()

	FORMS.registerCheckboxHandlers(FORMS.$masterCheckbox)
	FORMS.registerEmailHandlers(FORMS.$emailButton)
	FORMS.registerSortHandlers(FORMS.$responsesList)

})
