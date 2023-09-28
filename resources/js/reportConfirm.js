import {
    createApp
} from 'https://unpkg.com/vue@3/dist/vue.esm-browser.js';

const app = createApp({
    data() {
        return {
            file: {},
            slug: '',
            action: '',
            myModal: {}
        }
    },
    mounted() {
        this.initModal();
    },
    methods: {
        initModal() {
            this.myModal = {
                modal: new bootstrap.Modal(document.querySelector('#confirmationAction')),
                showModal: function() {
                    this.modal.show();
                },
                closeModal: function() {
                    this.modal.hide();
                }
            }
        },
        confirmAction(obj) {
            this.file = obj
            this.myModal.showModal();
        },
        cancelAction(slug) {
            this.action = 'canceled';
            this.slug = slug;
            this.myModal.showModal();
        },
        deleteAction(slug) {
            this.action = 'delete';
            this.slug = slug;
            this.myModal.showModal();
        },
        uploadFile(slug){
            this.slug = slug;
            this.action = 'revision';
            this.myModal.showModal();
        }
    }
}).mount('#app')