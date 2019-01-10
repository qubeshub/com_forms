
var HUB = HUB || {}

HUB.FORMS = HUB.FORMS || {}

class ComFormsFormBuilder extends HUB.FORMS.FormBuilder {

	constructor(args) {
		super(args)
		this._pageId = args.pageId
		this._getFieldClass = HUB.FORMS.ComFormsFormField
		this._setFieldClass = HUB.FORMS.FormBuilderField
	}

	setFields(fields) {
		fields = this._formFieldsData(fields, this._setFieldClass)
		fields = this._sortFields(fields)

		super.setFields(fields)

		this._addCmsIdsToDom(fields)
	}

	getFields() {
		let fields = super.getFields()

		fields = this._formFieldsData(fields, this._getFieldClass)
		this._getCmsIdsFromDom(fields)

		return fields
	}

	_formFieldsData(fields, fieldClass) {
		fields = fields.map((field, order) => {
			return this._formFieldData(field, order, fieldClass)
		})

		return fields
	}

	_formFieldData(field, order, fieldClass) {
		field = new fieldClass({
			...field,
			order,
			page_id: this._pageId
		})

		return field.toObject()
	}

	_addCmsIdsToDom(virutalFields) {
		const domFields = this._getFieldDomElements()

		domFields.each((i, domField) => {
			const cmsId = virutalFields[i].id
			this._addCmsIdToDom($(domField), cmsId)
		})
	}

	_addCmsIdToDom($field, cmsId) {
		const dataAttribute = this.constructor.cmsIdsDataAttribute

		$field.attr(dataAttribute, cmsId)
	}

	_getCmsIdsFromDom(virtualFields) {
		const domFields = this._getFieldDomElements()

		domFields.each((i, field) => {
			const cmsId = this._getCmsIdFromDom($(field))
			virtualFields[i].id = cmsId
		})
	}

	_getCmsIdFromDom($field) {
		const dataAttribute = this.constructor.cmsIdsDataAttribute

		let cmsId = $field.attr(dataAttribute)

		return cmsId
	}

	_getFieldDomElements() {
		const $fieldsContainer = $('[id$=-stage-wrap]').find("ul")
		const $fields = $fieldsContainer.children()

		return $fields
	}

	_sortFields(fields) {
		fields.sort((field, fieldNext) => {
			return field.order - fieldNext.order
		})

		return fields
	}

	static get cmsIdsDataAttribute() {
		return 'data-cms-id'
	}

}

HUB.FORMS.ComFormsFormBuilder = ComFormsFormBuilder
