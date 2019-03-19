
$(document).ready(() => {

	const $masterCheckbox = getMasterCheckbox()
	const $responsesList = getResponsesList()

	registerCheckboxHandlers($masterCheckbox)
	registerSortHandlers($responsesList)

})
