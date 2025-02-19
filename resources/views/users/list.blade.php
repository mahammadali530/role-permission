<!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"> -->
 
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Users') }}
        </h2>
        @can('create users')
        <a href="{{  route('users.create')  }}" class="bg-slate-700 text-sm rounded-md text-white px-3 py-2">Create</a>
        @endcan
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
           <x-message></x-message>
           <table class="w-full">
            <thead class="bg-gray-50">
                <tr class="border-b">
                    <th class="px-6 py-3 text-left" width="60">#</th>
                    <th class="px-6 py-3 text-left">Name</th>
                    <th class="px-6 py-3 text-left">Email</th>
                    <th class="px-6 py-3 text-left">Roles</th>
                    <th class="px-6 py-3 text-left" width="180">Created</th>
                    <th class="px-6 py-3 text-center" width="180">Action</th>
                </tr>
            </thead>
            <tbody class="bg-white">
                @if($users->isNotEmpty())
                @foreach($users as $user)
                <tr  id="user-row-{{ $user->id }}" class="border-b">
                    <td class="px-6 py-3 text-left">{{$user->id}}</td>
                    <td class="px-6 py-3 text-left">{{$user->name}}</td>
                    <td class="px-6 py-3 text-left">{{$user->email}}</td>
                    <td class="px-6 py-3 text-left">{{$user->roles->pluck('name')->implode(', ')}}</td>
                    <td class="px-6 py-3 text-left">{{\Carbon\Carbon::parse($user->created_at)->format('d M, Y')}}</td>
                    <td class="px-6 py-3 text-center">
                    <div class="flex justify-center space-x-2">
                    @can('edit users')
                    <a href="{{ route('users.edit', $user->id) }}" class="bg-slate-700 text-sm rounded-md text-white px-3 py-2 hover:bg-slate-600 " >Edit</a>
                    @endcan
                    @can('delete users')
                   <button onclick="deleteUser({{ $user->id }})"
                    class="bg-red-600 text-sm rounded-md text-white px-3 py-2 hover:bg-red-500">
                    Delete
                   </button>
                    @endcan
                     </div>
                    </td>
                </tr>
                @endforeach
                @endif
               
            </tbody>
           </table>
           <div class="my-3">
           {{$users->links()}}
           </div>
           
        </div>
    </div>

    <!-- <div class="modal fade" id="editmodal" tabindex="-1" aria-labelledby="addServiceModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addServiceModalLabel">Add Menu</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
    <div class="modal-body">
        <form action="" method="post" enctype="multipart/form-data" id="updateForm">  
            @csrf
            <input type="hidden" id="edit_id">  
            <div class="mb-3">
                <label for="icon-name" class="form-label">Name</label>
                <input type="text" class="form-control rounded-md" id="edit_name" placeholder="Enter Your Name" name="name" >
                @error('name')
                <p class="text-red-400 font-medium">{{$message}}</p>
                @enderror
                <div class="error-message" style="color:red; display:none;"></div>
            </div>   
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" name="submit">Update</button>
        </form>
    </div>
 </div> -->
</div>
</div>
</x-app-layout>
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
   $(document).ready(function () {
    console.log("jQuery Loaded!"); 
   
    $(document).on('click', '.editbtn', function () {
        var id = $(this).data('id');
        console.log("Clicked ID:", id); 
        $.ajax({
            url: '/articaledit/' + id,
            type: 'GET',
            success: function (response) {
                console.log("Response Data:", response); 

                if (response.data) {
                    $('#edit_id').val(response.data.id);
                    $('#edit_name').val(response.data.name);


                    $('#editmodal').modal('show');
                } else {
                    alert("No data found!");
                }
            },
            error: function (xhr) {
                alert("Error fetching data!");
                console.log(xhr.responseText); 
            }
        });
    });

    $('#updateForm').on('submit', function (e) {
        e.preventDefault();
        var id = $('#edit_id').val();
        var formData = new FormData(this);
        formData.append('_method', 'PUT');

        $.ajax({
            url: '/edit-artical/' + id,
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                if (response.success) {
                    $('#editmodal').modal('hide');
                    location.reload();
                    //alert(response.message);
                } else {
                    alert("Update failed!");
                }
            },
            error: function (xhr) {
                alert("Error updating data!");
                console.log(xhr.responseText);
            }
        });
    });
});

</script>
 -->
 <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function deleteUser(userId) {
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(`/users/${userId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire("Deleted!", data.message, "success"); 
                        document.getElementById(`user-row-${userId}`).remove();
                    } else {
                        Swal.fire("Error!", data.message, "error");
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire("Error!", "Something went wrong.", "error");
                });
            }
        });
    }
</script>

