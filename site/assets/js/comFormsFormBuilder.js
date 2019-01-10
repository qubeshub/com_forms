
var HUB = HUB || {}

HUB.FORMS = HUB.FORMS || {}

class ComFormsFormBuilder extends HUB.FORMS.FormBuilder {

	constructor(args) {
		super(args)
		this._pageId = args.pageId
	}

	setFields(fields) {
		fields = this._sortFields(fields)

		super.setFields(fields)

		this._addCmsIdsToDom(fields)
	}

	_sortFields(fields) {
		fields.sort((field, fieldNext) => {
			return field.order - fieldNext.order
		})

		return fields
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

	getFields() {
		const fieldsData = super.getFields()

		const supplementedFieldsData = this._addSupplementaryFieldsData(fieldsData)

		return supplementedFieldsData
	}

	_addSupplementaryFieldsData(fieldsData) {
		let supplementedFieldsData = fieldsData.map((fieldData, order) => {
			return this._addSupplementaryFieldData(fieldData, order)
		})

		this._addCmsIds(supplementedFieldsData)

		return supplementedFieldsData
	}

	_addSupplementaryFieldData(field, order) {
		let supplementedFieldData = {
			...field,
			order,
			page_id: this._pageId
		}

		return supplementedFieldData
	}

	_addCmsIds(virtualFields) {
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

	static get cmsIdsDataAttribute() {
		return 'data-cms-id'
	}

}

HUB.FORMS.ComFormsFormBuilder = ComFormsFormBuilder
