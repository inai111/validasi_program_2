import {
    createApp
} from 'https://unpkg.com/vue@3/dist/vue.esm-browser.js';

const editRoleUserModal = createApp({
    data() {
        return {
            user: {},
            roles: [],
            myModal: {}

        }
    },
    mounted() {
        this.initModal();
    },
    methods: {
        initModal() {
            this.myModal = {
                modal: new bootstrap.Modal(document.querySelector('#editUser')),
                showModal: function() {
                    this.modal.show();
                },
                closeModal: function() {
                    this.modal.hide();
                }
            }
        },
        setUser(id) {
            fetch(`/user/${id}/resource`, {
                    headers: {
                        'content-type': 'application/json',
                        'accept': 'application/json'
                    }
                })
                .then(ee => ee.json())
                .then(user => {
                    if (user.roles) {
                        this.roles = user.roles.map(obj => obj.id);
                    }
                    delete(user.roles)
                    this.user = user;
                    this.myModal.showModal();
                })
        },
        updateUser() {
            fetch(`/user/${this.user.id}/roles`, {
                    method: "PUT",

                    headers: {
                        'content-type': 'application/json',
                        'accept': 'application/json',
                        'x-csrf-token': document.querySelector(`meta[name=csrf-token]`).content
                    },
                    body: JSON.stringify({
                        roles: this.roles
                    })
                })
                .then(ee => ee.json())
                .then(result => {
                    this.myModal.closeModal()
                    location.reload()
                })
        }
    }
}).mount('#editRoleUserModal')