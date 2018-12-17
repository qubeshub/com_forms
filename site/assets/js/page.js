
var HUB = HUB || {}

HUB.FORMS = HUB.FORMS || {}

class Page {

	static get apiEndpoint() {
		return 'v1.0/forms/fields/'
	}

	static get api() {
		return HUB.FORMS.Api
	}

	constructor({id, fields}) {
		this.id = id
		this._fields = fields
	}

	toArray() {
		const thisAsArray = {
			id: this.id,
			fields: this._fields
		}

		return thisAsArray
	}

	save() {
		const pageData = this.toArray()
		const endpoint = `${this.constructor.apiEndpoint}update`

		const promise = this.constructor.api.post(endpoint, pageData)

		return promise
	}

}

HUB.FORMS.Page = Page
