// Install Heroicons for modern SVG icons
import { library, dom } from '@fortawesome/fontawesome-svg-core';
import { faEdit, faKey, faTrash } from '@fortawesome/free-solid-svg-icons';
library.add(faEdit, faKey, faTrash);
dom.watch();
