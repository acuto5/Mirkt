import Tag from './elements/tag.vue';
import Help from "./elements/help.vue";
import Icon from "./elements/icon.vue";
import Modal from "./components/modal.vue";
import Message from "./components/message.vue";
import HelpList from "./elements/help-list.vue";
import TagsField from './components/tags-field.vue';
import SelectFile from './elements/select-file.vue';
import Pagination from "./components/pagination.vue";
import InputField from "./components/input-field.vue";
import SelectField from "./components/select-field.vue";
import ThreeQuarters from "./layouts/three-quarters.vue";
import ImagesGallery from './components/image-gallery.vue';
import TextAreaField from "./components/textarea-field.vue";
import InputDropdown from './components/input-dropdown.vue';
import InputFieldWitchAddon from "./components/input-field-witch-addons.vue";

const components = {
	Tag,
	Help,
	Icon,
	Modal,
	Message,
	HelpList,
	TagsField,
	SelectFile,
	InputField,
	Pagination,
	SelectField,
	ImagesGallery,
	ThreeQuarters,
	TextAreaField,
	InputDropdown,
	InputFieldWitchAddon
};

const BulmVue = {
	install(Vue, options) {
		Vue.mixin({components});
	}
};

export default BulmVue;