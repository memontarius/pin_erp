import {ProductModalWindow} from "./components/productModalWindow.js";


const productLinks = document.querySelectorAll('.product-link');

productLinks.forEach(l => l.addEventListener('click', onProductClicked));

const showingProductPopup = new ProductModalWindow({
    rootId: 'show-product-modal',
    titleSelector: '.title'
});

const editProductPopup = new ProductModalWindow({
    rootId: 'edit-product-modal',
    titleSelector: '.title',
    formSelector: 'form',
    useAttributes: true,
    submitFormMethod: 'patch'
});

function onProductClicked(e) {
    e.preventDefault();
    showingProductPopup.show();

    const productId = e.target.getAttribute('data-product-id');
    showingProductPopup.loadProduct(productId);
}

let editButton = showingProductPopup.window.querySelector("button.edit-btn");
let closeButton = editProductPopup.window.querySelector(".close-modal");

editButton.addEventListener("click", (e) => {
    showingProductPopup.hide();
    editProductPopup.show();
    editProductPopup.setViewFromProduct(showingProductPopup.product);
});

closeButton.addEventListener("click", (e) => {
    showingProductPopup.show();
    editProductPopup.hide();
});


