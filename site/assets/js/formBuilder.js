
var HUB = HUB || {}

HUB.FORMS = HUB.FORMS || {}

class FormBuilder {

	constructor({$anchor}) {
		this.$anchor = $anchor
		this._builder = undefined
		this._defaultOptions = {
			disabledActionButtons: ['clear', 'data', 'save'],
			disabledAttrs: ['access', 'className', 'style'],
			disableFields: ['autocomplete', 'button', 'file']
		}
	}

	render(options = {}) {
		const combinedOptions = {...this._defaultOptions, ...options}

		this._builder = this.$anchor.formBuilder(combinedOptions)
	}

	getFields() {
		const rawFormData = this._builder.formData

		const fields = JSON.parse(rawFormData)

		return fields
	}

}

HUB.FORMS.FormBuilder = FormBuilder
