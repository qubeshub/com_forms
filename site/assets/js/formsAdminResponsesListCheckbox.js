/**
 * @package    hubzero-cms
 * @copyright  Copyright (c) 2005-2020 The Regents of the University of California.
 * @license    http://opensource.org/licenses/MIT MIT
 */

var HUB = HUB || {}

HUB.FORMS = HUB.FORMS || {}

FORMS = HUB.FORMS

FORMS.masterCheckboxId = 'master-checkbox'

FORMS.getMasterCheckbox = () => {
	return $(`#${FORMS.masterCheckboxId}`)
}

FORMS.registerCheckboxHandlers = ($masterCheckbox) => {
  $masterCheckbox.on('click', () => {
    FORMS.toggleCheckboxes($masterCheckbox)
  })
}

FORMS.toggleCheckboxes = ($masterCheckbox) => {
  let checked = $masterCheckbox.prop('checked')

  FORMS.toggleItemCheckboxes(checked)
}

FORMS.toggleItemCheckboxes = (checked) => {
  const checkboxes = $('input[type="checkbox"]', '.response-item')

  checkboxes.prop('checked', checked)
}
