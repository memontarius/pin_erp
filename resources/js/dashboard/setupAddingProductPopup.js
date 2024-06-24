import {ProductModalWindow} from './components/productModalWindow.js';

const addingProductPopup = new ProductModalWindow({
   rootId: 'add-product-modal',
   formSelector: 'form',
   useAttributes: true
});
