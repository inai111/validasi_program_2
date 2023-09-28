@props(['roles'=>[]])
<!-- Modal -->
<div class="modal fade" id="editUser" tabindex="-1" aria-labelledby="editUserLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editUserLabel">Detail User</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    @method('PUT')
                    @csrf
                    <div class="mb-3">
                        @foreach ($roles as $role)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox"
                                    v-model="user.role.some(item=>item.id=={{$role->id}})" value="{{$role->id}}"
                                    id="checkboxRoles">
                                <label class="form-check-label" for="checkboxRoles">
                                    {{$role->name}}
                                </label>
                            </div>
                        @endforeach
                    </div>
                    <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>
