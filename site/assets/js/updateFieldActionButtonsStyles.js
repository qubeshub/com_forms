
const fieldActionButtonClass = 'btn'

const removeCollidingClasses = () => {
	const $fieldActionButtons = getAllFieldActionButtons()

	removeBtnClass($fieldActionButtons)
}

const getAllFieldActionButtons = () => {
	const $fieldEditor = getFieldEditor()

	return $fieldEditor.find(`.${fieldActionButtonClass}`)
}

const getFieldEditor = () => {
	return $(`#${anchorId}`)
}

const removeBtnClass = ($fieldActionButtons) => {
	$fieldActionButtons.removeClass(fieldActionButtonClass)
}

$(document).ready(() => {
	setTimeout(() => {
		removeCollidingClasses()
	}, 500)
})
