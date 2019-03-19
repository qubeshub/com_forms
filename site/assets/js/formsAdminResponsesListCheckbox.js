
const masterCheckboxId = 'master-checkbox'

const getMasterCheckbox = () => {
	return $(`#${masterCheckboxId}`)
}

const registerCheckboxHandlers = ($masterCheckbox) => {
  $masterCheckbox.on('click', () => {
    toggleCheckboxes($masterCheckbox)
  })
}

const toggleCheckboxes = ($masterCheckbox) => {
  let checked = $masterCheckbox.prop('checked')

  toggleItemCheckboxes(checked)
}

const toggleItemCheckboxes = (checked) => {
  const checkboxes = $('input[type="checkbox"]', '.response-item')

  checkboxes.prop('checked', checked)
}
