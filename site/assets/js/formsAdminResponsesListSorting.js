
var $sortForm
const sortFormId = 'sort-form'
const directionDataAttribute = 'sort-direction'
const directionOpposites = { asc: 'desc', desc: 'asc' }
const fieldDataAttribute = 'sort-field'
const sortDirectionInputName="sort_direction"
const sortFieldInputName="sort_field"

const getResponsesList = () => {
	return $('table')
}

const registerSortHandlers = ($list) => {
	$list.on('click', '.sortable', sortByField)
}

const sortByField = (e) => {
	const sortData = getSortData(e)

 submitSortForm(sortData)
}

const getSortData = (e) => {
	const $columnHeader = getColumnHeader(e)

	return {
		direction: $columnHeader.data(directionDataAttribute),
		field: $columnHeader.data(fieldDataAttribute )
	}
}

const getColumnHeader = (e) => {
	const $target = $(e.target)

	return $target.closest('td')
}

const submitSortForm = (sortingData) => {
	setSortForm()
	populateSortForm(sortingData)
	$sortForm.submit()
}

const setSortForm = () => {
	if ($sortForm == undefined) {
		$sortForm = $(`#${sortFormId}`)
	}
}

const populateSortForm = (sortingData) => {
	populateDirection(sortingData)
	populateField(sortingData)
}

const populateDirection = ({direction}) => {
	const newDirection = getNewDirection(direction)
	const $directionInput = getInput(sortDirectionInputName)

	$directionInput.val(newDirection)
}

const getNewDirection = (direction) => {
	return directionOpposites[direction]
}

const populateField = ({field}) => {
	const $fieldInput = getInput(sortFieldInputName)

	$fieldInput .val(field)
}

const getInput = (inputName) => {
	return $sortForm.find(`[name="${inputName}"]`)
}
