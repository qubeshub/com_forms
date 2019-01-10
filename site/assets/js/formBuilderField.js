
var HUB = HUB || {}

HUB.FORMS = HUB.FORMS || {}

class FormBuilderField {

	constructor(args) {
		let state = this.constructor._extractState(args)

		state = this.constructor._parseState(args)

		this.constructor._setState(state, this)
	}

	toObject() {
		const thisAsObject = {}

		for (let property in this) {
			if (this.hasOwnProperty(property)) {
				thisAsObject[property] = this[property]
			}
		}

		return thisAsObject
	}

	static _extractState(params) {
		const state = {}

		this.stateList.forEach((attr) => {
			state[attr] = params[attr]
		})

		return state
	}

	static get stateList() {
		return [
			'default_value',
			'help_text',
			'id',
			'inline',
			'label',
			'max',
			'max_length',
			'min',
			'multiple',
			'name',
			'order',
			'other',
			'page_id',
			'placeholder',
			'required',
			'rows',
			'step',
			'subtype',
			'toggle',
			'type',
			'values',
		]
	}

	static _parseState(state) {
		const parsedState = {}

		this.stateList.forEach((attr) => {
			parsedState[attr] = this._parseAttribute(attr, state[attr])
		})

		return parsedState
	}

	static _setState(state, instance) {
		for (const attr in state) {
			instance[attr] = state[attr]
		}
	}

	static _parseAttribute(name, value) {
		let parsedValue

		switch(name) {
			case 'inline':
			case 'multiple':
			case 'other':
			case 'required':
			case 'toggle':
				parsedValue = !!parseInt(value)
				break;
			default:
				parsedValue = value
		}

		return parsedValue
	}

}

HUB.FORMS.FormBuilderField = FormBuilderField
