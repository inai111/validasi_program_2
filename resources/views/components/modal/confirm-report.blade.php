<!-- Modal -->
<div class="modal fade" {{$attributes->merge(['id'=>"confirmationAction"])}} tabindex="-1"
aria-labelledby="confirmationActionLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <template v-if="action=='revision'">
                    <h1 class="modal-title fs-5" id="confirmationActionLabel">Upload new File</h1>
                </template>
                <template v-else>
                    <h1 class="modal-title fs-5" id="confirmationActionLabel">Confirmation Action</h1>
                </template>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <template v-if="action=='canceled'">
                    <form method="POST" :action="'/report/'+slug">
                        @csrf
                        @method('PUT')
                        <p>Ingin membatalkan laporan ini?</p>
                        <input type="hidden" name="status" value="canceled">
                        <hr>
                        <div class="d-flex justify-content-between">
                            <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-danger px-5">Cancel</button>
                        </div>
                    </form>
                </template>
                <template v-else-if="action=='delete'">
                    {{-- <form method="POST" :action="/report/{{ slug }}"> --}}
                    <form method="POST" :action="'/report/'+slug">
                    @csrf
                        @method('DELETE')
                        <p>Ingin hapus laporan ini?</p>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-danger px-5">Delete</button>
                        </div>
                    </form>

                </template>
                <template v-else-if="action=='revision'">
                    <form method="POST" enctype="multipart/form-data" :action="'/report/'+slug+'/add-file'">
                    @csrf
                    <div class="mb-3">
                        <x-inputs.floating v-model="action" message="{{$errors->first('action')}}"
                            name="status" placeholder="Action" readonly />
                        <x-inputs.floating type="file" name="file_path"
                        message="{{$errors->first('file_path')}}"
                        placeholder="File Approved" accept="application/pdf" required/>
                        <x-inputs.floating-textarea name="description" placeholder="Description"
                        message="{{$errors->first('description')}}"
                            style="height:120px;resize:none" />
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between">
                        <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary px-5">Send</button>
                    </div>
                    </form>

                </template>
                <template v-else>
                    <form :action="'/file/'+file.slug" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <x-inputs.floating v-model="file.status" name="status"
                            message="{{$errors->first('status')}}" placeholder="Action" readonly />
                            <template v-if="file.status=='accepted'">
                                <x-inputs.floating type="file" name="file_path"
                                    placeholder="File Approved" accept="application/pdf"
                                    message="{{$errors->first('file_path')}}" required/>
                            </template>
                            <x-inputs.floating-textarea name="comment" placeholder="Comment"
                            message="{{$errors->first('comment')}}"
                                style="height:120px;resize:none" />
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary px-5">Save</button>
                        </div>
                    </form>
                </template>
            </div>
        </div>
    </div>
</div>
