import axios from "axios";


export class ProductModalWindow {
    attributesCount = 0;
    currProductId = undefined;
    requestActive = false;
    attributeNodes = undefined;

    constructor({
                    rootId,
                    formSelector = null,
                    useAttributes = false,
                    titleSelector = "",
                    submitFormMethod = 'post'
    }) {
        this.modalId = rootId;
        this.window = document.getElementById(rootId);
        this.content = this.window.querySelector(".modal-content");
        this.loader = this.window.querySelector(".modal-loader");
        this.contentElements = this.window.querySelectorAll(".content-element");
        this.messageElement = this.window.querySelector(".message");
        this.submitButton = this.window.querySelector(".submit-button");
        this.submitFormMethod = submitFormMethod;

        if (titleSelector !== "") {
            this.title = this.window.querySelector(titleSelector);
        }
        if (formSelector !== null) {
            this.initForm(formSelector);
        }
        if (useAttributes) {
            this.prodAttributeRoot = this.window.querySelector('.product-attribute');
            this.addAttributeButton = this.window.querySelector('.add-attribute-btn');
            this.attributeTemplate = this.window.querySelector('.attribute-template');

            this.initAttributes();
        }

        this.loader.classList.add('hidden');
    }

    initForm(formSelector) {

        this.form = this.window.querySelector(formSelector);

        this.form?.addEventListener('submit', async (event) => {
            event.preventDefault();

            const errorsRoot = this.form.querySelector(".errors");
            errorsRoot.replaceChildren();
            const formData = new FormData(this.form);
            this.activeRequest();

            const handleResponse = response => {
                location.reload();
            };

            const handleError = error => {
                const message = error.response.data['message'];

                for (const [key, errors] of Object.entries(error.response.data.errors)) {
                    let divError = document.createElement('div');
                    divError.innerHTML = errors[0];
                    errorsRoot.append(divError)
                }
            };

            const headers = {
                'Content-Type': 'application/json'
            };

            if (this.submitFormMethod === 'post') {
                axios.post('/api/products', formData)
                    .then(handleResponse)
                    .catch(handleError)
                    .finally(() => this.deactivateRequest() );
            } else if (this.submitFormMethod === 'patch') {
                axios.patch(`/api/products/${this.product.id}`, formData, {headers})
                    .then(handleResponse)
                    .catch(handleError)
                    .finally(() => this.deactivateRequest());
            }
        });
    }

    initAttributes() {
        this.attributesCount = 0;
        this.attributeNodes = [];

        this.addAttributeButton.addEventListener("click", () => {
            this.addAttribute();
        });
    }

    addAttribute(name = "", value ="") {
        this.prodAttributeRoot.classList.remove('hidden');
        const attribute = this.attributeTemplate.cloneNode(true);
        attribute.classList.remove('hidden', 'attribute-template');

        this.attributeNodes.push(attribute);
        this.setAttributeNode(attribute, this.attributesCount, name, value);

        this.attributesCount++;

        attribute.children[2].addEventListener("click", (event) => {
            event.target.parentNode.remove();
            this.attributesCount--;
            if (this.attributesCount === 0) {
                this.prodAttributeRoot.classList.add('hidden');
            }

            this.attributeNodes = this.attributeNodes.filter((node) => node !== event.target.parentNode);
            this.recalculateAttribute();
        })

        this.prodAttributeRoot.appendChild(attribute);
    }

    setAttributeNode(node, index, name = "", value = "") {
        const attrWrappers = node.querySelectorAll("div input");
        attrWrappers[0].setAttribute('name', `attributes[${index}][name]`);
        attrWrappers[1].setAttribute('name', `attributes[${index}][val]`);

        if (name !== "") {
            attrWrappers[0].value = name;
            attrWrappers[1].value = value;
        }
    }

    recalculateAttribute() {
        this.attributeNodes.forEach((node, index) => {
            this.setAttributeNode(node, index)
        });
    }

    clearAttributes() {
        this.attributesCount = 0
        this.prodAttributeRoot.innerHTML = ""
    }

    show() {
        this.hideMessage()
        const modal = FlowbiteInstances.getInstance('Modal', this.modalId)
        modal.show()
    }

    hide() {
        FlowbiteInstances.getInstance('Modal', this.modalId).hide();
    }

    showContent() {
        this.hideMessage();
        this.content.classList.remove('hidden');
        this.title?.children[0].classList.remove('hidden');
        this.contentElements.forEach(element => element.classList.remove('hidden'));
    }

    hideContent() {
        this.content.classList.add('hidden');
        this.title?.children[0].classList.add('hidden');
        this.contentElements.forEach(element => element.classList.add('hidden'));
    }

    showMessage(text) {
        this.messageElement.classList.remove('hidden');
        this.messageElement.innerHTML = text;
    }

    hideMessage() {
        this.messageElement?.classList.add('hidden');
    }

    showLoader() {
        this.loader.classList.remove('hidden');
    }

    hideLoader() {
        this.loader.classList.add('hidden');
    }

    activeRequest() {
        this.requestActive = true;
        this.submitButton.querySelector(".title").classList.add("hidden");
        this.submitButton.querySelector("svg").classList.remove("hidden");
    }

    deactivateRequest() {
        this.requestActive = false;
        this.submitButton.querySelector(".title").classList.remove("hidden");
        this.submitButton.querySelector("svg").classList.add("hidden");
    }

    loadProduct(id) {

        this.hideContent();
        this.showLoader();

        axios.get('/api/products/' + id)
            .then(response => {
                this.currProductId = id;
                this.product = response.data;

                if (this.title !== undefined) {
                    this.title.children[0].innerHTML = response.data.name;
                }

                const formDelete = this.window.querySelector('.form-delete');
                formDelete.setAttribute("action", formDelete.getAttribute("action").replace(/\/\d+$/i, `/${id}`));

                this.window.querySelector('.product-article').innerHTML = response.data.article;
                this.window.querySelector('.product-name').innerHTML = response.data.name;
                this.window.querySelector('.product-status').innerHTML = response.data.status.text;

                let attributesElement = '';
                if (response.data.data !== null) {
                    for (let attribute of Object.entries(response.data.data)) {
                        attributesElement += `<li> ${attribute[0]}: ${attribute[1]}</li>`;
                    }
                }

                this.window.querySelector('.attribute-list').innerHTML = attributesElement;
                this.showContent();
            })
            .catch(error => {
                console.log(error);
            })
            .finally(() => {
                this.hideLoader();
            });
    }

    setViewFromProduct(product) {
        this.product = product;
        this.title.innerHTML = `Редактировать ${product['name']}`;
        this.window.querySelector("input[name='article']").value = product['article'];
        this.window.querySelector("input[name='name']").value = product['name'];

        const status = this.window.querySelector("select[name='status']");

        [...status.children].forEach((statusItem) => {
            if (statusItem.value === product.status.val) {
                statusItem.setAttribute("selected", true);
            } else {
                statusItem.removeAttribute("selected");
            }
        });

        this.clearAttributes()

        if (product.data) {
            Object.entries(product.data).forEach((attr) => {
                this.addAttribute(attr[0], attr[1]);
            });
        }

    }
}
