import BasicField from './basic-field';
import ButtonField from './button-field';
import CheckboxesField from './checkboxes-field';

class FieldFactory {
	createField( element, type ) {
		let field;

		switch ( type ) {
		case 'platform_search' :

			// Skip because multi-fields require subfields not yet available.
			// TODO: Handle this more elegantly.
			break;
		case 'button' :
			field = new ButtonField( element );
			break;
		case 'checkboxes' :
			field = new CheckboxesField( element );
			break;
		default :
			field = new BasicField( element );
		}

		return field;
	}
}

export default FieldFactory;
