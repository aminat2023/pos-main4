<div class="col-md-4 col-sm-4">
    @if (count($checked) > 1)
        <a href="#" class="btn btn-outline btn-sm" wire:click="confirmBulkDelete">
            ( {{ count($checked) }} Row Selected to be<b> Deleted</b>)
        </a>
    @endif
</div>


<table class="table" width="100%" >
    <thead>
        <tr>
            <th><input class="h-5 w-5" type="checkbox" wire:model="selectAll" id=""></th>
            <th>Section Name</th>
            <th>Section Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>

        @foreach ($sections as $section)
            <tr>
                <td><input value="{{ $section->id }}" class="h-5 w-5" type="checkbox" wire:model="checked"
                        id="">
                </td>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $section->section_name }}</td>
                <td>{{ $section->status ? 'Active' : 'Inactive' }}</td>
                <td>
                    {{-- Edit link with styling --}}
                    <a href="#editSection" data-toggle="modal" wire:click="editSection({{ $section->id }})"
                        class="btn btn-outline-info btn-sm " style="margin-right: 5px;">
                        <i class="fa fa-edit"></i>
                     </a>
                     
                     @if (count($checked) < 2)
                     <a href="#" class="btn btn-outline-danger btn-sm"
                     wire:click.prevent=" ConfirmDelete({{ $section->id }},'{{ $section->section_name }}')"
                     style="text-decoration: none;">
                     <i class="fa fa-trash"></i>
                     @endif
                   
                </td>
            </tr>
            @include('sections.edit')
        @endforeach
    </tbody>
    

</a>
</table>

<script>
    window.addEventListener('Swal:DeletedRecord', event => {
        Swal.fire({
            title: event.detail.title,
            text: "Are you sure?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                window.livewire.emit('RecordDeleted', event.detail.id);
                Swal.fire({
                    title: "Deleted!",
                    text: "Your file has been deleted.",
                });
            }
        });
    });

    window.addEventListener('MSGSuccessful', event => {
        const Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
            }
        });
        Toast.fire({
            icon: "success",
            title: event.detail.title
        });
    });
</script>
