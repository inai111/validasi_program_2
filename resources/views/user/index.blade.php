@extends('layouts.app')

@section('scriptVite')
@endsection

@section('header')
    <x-header />
@endsection

@section('body')
    <div id="app" class="container">
        <div class="mb-3">
            <h1>All Users</h1>
            <hr>
        </div>
        <div class="mb-3">
            <table class="table">
                <thead>
                    <tr>
                        <th>Email</th>
                        <th colspan="2">Name</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->name }}</td>
                            <td>
                                <button v-on:click="setUser({{ $user->id }})" class="btn" type="button">
                                    <i class="fa-solid fa-bars"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $users->links() }}
        </div>

        <!-- Modal -->
        <div class="modal fade" id="editUser" tabindex="-1" aria-labelledby="editUserLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="editUserLabel">Detail User</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form @submit.prevent="updateUser()">
                            <div class="mb-3">
                                <x-inputs.floating type="text" readonly v-model="user.name" placeholder="Name" />
                                <x-inputs.floating type="text" readonly v-model="user.email" placeholder="Email" />
                                <div class="mb-3">
                                    <strong>Roles</strong>
                                </div>
                                <div class="ms-2">
                                    @foreach ($roles as $role)
                                        <div class="form-check">
                                            <input class="form-check-input" v-model="roles"
                                                :checked="roles.includes({{ $role->id }})" type="checkbox"
                                                value="{{ $role->id }}" id="checkboxRoles">
                                            <label class="form-check-label" for="checkboxRoles">
                                                {{ $role->name }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between">
                                <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary px-5">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="module">
        import {
            createApp
        } from 'https://unpkg.com/vue@3/dist/vue.esm-browser.js';

        const app = createApp({
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
                    let data = new FormData();
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
                        .then(ee => {
                            this.myModal.closeModal()
                        })
                }
            }
        }).mount('#app')
    </script>
@endsection
