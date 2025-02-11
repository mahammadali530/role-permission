<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Article') }}
        </h2>
        @can('create articles')
        <a href="{{  route('articles.create')  }}" class="bg-slate-700 text-sm rounded-md text-white px-3 py-2">Create</a>
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
                    <th class="px-6 py-3 text-left">Author</th>
                    <th class="px-6 py-3 text-left" width="180">Created</th>
                    <th class="px-6 py-3 text-center" width="180">Action</th>
                </tr>
            </thead>
            <tbody class="bg-white">
                @if($articles->isNotEmpty())
                @foreach($articles as $article)
                <tr class="border-b">
                    <td class="px-6 py-3 text-left">{{$article->id}}</td>
                    <td class="px-6 py-3 text-left">{{$article->title}}</td>
                    <td class="px-6 py-3 text-left">{{$article->author}}</td>
                    <td class="px-6 py-3 text-left">{{\Carbon\Carbon::parse($article->created_at)->format('d M, Y')}}</td>
                    <td class="px-6 py-3 text-center">
                    <div class="flex justify-center space-x-2">
                    @can('edit articles')
                    <button class="bg-slate-700 text-sm rounded-md text-white px-3 py-2 hover:bg-slate-600 editbtn" data-id="{{ $article->id }}">Edit</button>
                    @endcan
                    @can('delete articles')
                    <a href="{{ route('deletea.artical', ['id' => $article]) }}" onclick="return confirm('Are you sure?');" class="bg-red-600 text-sm rounded-md text-white px-3 py-2 hover:bg-red-500">Delete</a>
                    @endcan
                   </div>
                    </td>
                </tr>
                @endforeach
                @endif
               
            </tbody>
           </table>
           <div class="my-3">
           {{$articles->links()}}
           </div>
           
        </div>
    </div>

    <div class="modal fade" id="editmodal" tabindex="-1" aria-labelledby="addServiceModalLabel" aria-hidden="true">
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
                <input type="text" class="form-control rounded-md" id="edit_title" placeholder="Enter Your Name" name="title" >
                @error('title')
                <p class="text-red-400 font-medium">{{$message}}</p>
                @enderror    
            </div>   
            <label for="" class="text-lg font-midium">Content</label>
            <div class="my-3">
                <textarea name="text"  class="form-control rounded-md" placeholder="Enter Content" id="text" class="border-gray-300 shadow-sm w-1/2 rounded-lg" cols="30" rows="6">{{ old('text')}}</textarea>
            </div>
            <label for="" class="text-lg font-midium">Author</label>
            <div class="my-3">
                <input value="{{ old('author')}}" class="form-control rounded-md" id="author" name="author" placeholder="Enter Author" type="text" class="border-gray-300 shadow-sm w-1/2 rounded-lg">
                @error('author')
                <p class="text-red-400 font-midium">{{$message}}</p>
                @enderror
            </div>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" name="submit">Update</button>
        </form>
    </div>
 </div>
</div>
</div>
</x-app-layout>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
   $(document).ready(function () {
    console.log("jQuery Loaded!"); 
   
    $(document).on('click', '.editbtn', function () {
        var id = $(this).data('id');
        console.log("Clicked ID:", id); 
        $.ajax({
            url: '/articelsedit/' + id,
            type: 'GET',
            success: function (response) {
                console.log("Response Data:", response); 

                if (response.data) {
                    $('#edit_id').val(response.data.id);
                    $('#edit_title').val(response.data.title);
                    $('#text').val(response.data.text);
                    $('#author').val(response.data.author);


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
            url: '/edit-articels/' + id,
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

