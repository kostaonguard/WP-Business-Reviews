import BasicField from './basic-field';
import ButtonField from './button-field';
import CheckboxesField from './checkboxes-field';
import RadioField from './radio-field';
import PlatformSearchField from './platform-search-field';
import FacebookPagesSelectField from './facebook-pages-select-field';

class FieldFactory {
	createField( element, type ) {
		let field;

		switch ( type ) {
		case 'button' :
			field = new ButtonField( element );
			break;
		case 'checkboxes' :
			field = new CheckboxesField( element );
			break;
		case 'radio' :
			field = new RadioField( element );
			break;
		case 'platform_search' :
			field = new PlatformSearchField( element );
			break;
		case 'facebook_pages_select' :
			field = new FacebookPagesSelectField( element );
			break;
		default :
			field = new BasicField( element );
		}

		return field;
	}
}

export default FieldFactory;
