@props(['roles' => []])

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
                    <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>
