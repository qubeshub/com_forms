
var HUB = HUB || {}

HUB.FORMS = HUB.FORMS || {}

class ComFormsFormField extends HUB.FORMS.FormBuilderField {

	constructor(args) {
		const mappedState = {...args}
		const stateMap = {
			description: 'help_text',
			maxlength: 'max_length',
			value: 'default_value'
		}

		for (const [key, mappedKey] of Object.entries(stateMap)) {
			mappedState[mappedKey] = args[key]
			mappedState[key] = args[mappedKey]
		}

		super(mappedState)
	}

	static _parseAttribute(name, value) {
		let parsedValue

		switch(name) {
			case 'inline':
			case 'multiple':
			case 'other':
			case 'required':
			case 'toggle':
				parsedValue = value ? 1 : 0
				break;
			default:
				parsedValue = value
		}

		return parsedValue
	}

}

HUB.FORMS.ComFormsFormField = ComFormsFormField
