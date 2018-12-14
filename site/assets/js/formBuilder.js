
class FormBuilder {

	constructor({anchorId}) {
		this.anchorId = anchorId
		this.$anchor = $(document.getElementById(anchorId))
		this._defaultOptions = {
			disabledActionButtons: ['clear', 'data', 'save']
		}
	}

	render(options = {}) {
		const combinedOptions = {...this._defaultOptions, ...options}

		this.$anchor.formBuilder(combinedOptions)
	}

}

var HUB = HUB || {}

HUB.FORMS = HUB.FORMS || {}

HUB.FORMS.FormBuilder = FormBuilder
