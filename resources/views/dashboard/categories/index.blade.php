@extends('dashboard.layout.master')

@section('content')
    <!-- /.row -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="p-2 d-flex align-items-center justify-content-between border-bottom">
                    <h3 class="card-title">Categories Table</h3>
                    <button type="button" class="btn btn-primary align-items-end" data-toggle="modal"
                        data-target="#modal-default">
                        Create new category
                    </button>
                </div>
                <!-- /.card-header -->
                <div class="p-0 card-body table-responsive">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Status</th>
                                <th>Childrens count</th>
                                <th>Created at</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($categories as $category)
                                <tr class="font-weight-bolder" style="background: rgb(66, 71, 73)">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $category->name }}</td>
                                    <td>
                                        @if ($category->active)
                                            <span class="bg-red-700 btn-sm btn-success font-weight-bolder">
                                                active
                                            </span>
                                        @else
                                            <span class="btn-sm btn-danger font-weight-bolder">
                                                not active
                                            </span>
                                        @endif
                                    </td>
                                    <td>{{ $category->childrens_count }}
                                        <button type="button" class="ml-3 btn btn-primary align-items-end"
                                            data-toggle="modal" data-target="#modal-{{ $category->id }}">
                                            +
                                        </button>
                                    </td>
                                    <td>{{ $category->created_at->toDateString() }}</td>
                                    <td class="gap-2 d-flex align-items-center">
                                        <a href="{{ route('dashboard.categories.toggle', $category->id) }}">
                                            @if ($category->active)
                                                <i class="fas fa-toggle-on text-success" style="font-size: 1.5rem"></i>
                                            @else
                                                <i class="fas fa-toggle-off text-danger" style="font-size: 1.5rem"></i>
                                            @endif
                                        </a>

                                        <button type="button" class="align-items-end" data-toggle="modal"
                                            data-target="#edit-modal-{{ $category->id }}">
                                            <i class="fas fa-edit" style="font-size: 1.2rem"></i>
                                        </button>

                                        @if ($category->childrens_count == 0)
                                            <button type="button" class="align-items-end delete-btn {{ $category->id }}">
                                                <i class="fas fa-trash-alt text-danger" style="font-size: 1.2rem"></i>
                                            </button>
                                            <form action="{{ route('dashboard.categories.destroy', $category->id) }}"
                                                method="POST" class="delete-form">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                                {{-- Modal for update main category --}}
                                <div class="modal fade" id="edit-modal-{{ $category->id }}">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Edit {{ $category->name }}</h4>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form action="{{ route('dashboard.categories.update', $category->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label for="name">Name</label>
                                                        <input type="text" class="form-control" id="name"
                                                            name="name" value="{{ $category->name }}"
                                                            placeholder="Enter new category named">
                                                    </div>
                                                </div>
                                                <div class="modal-footer justify-content-between">
                                                    <button type="button" class="btn btn-default"
                                                        data-dismiss="modal">Close</button>
                                                    <button type="sumbit" class="btn btn-primary">Submit</button>
                                                </div>
                                            </form>
                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                </div>

                                {{-- Modal for create subcategory --}}
                                <div class="modal fade" id="modal-{{ $category->id }}">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Sub category for {{ $category->name }}</h4>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form action="{{ route('dashboard.categories.store') }}" method="POST">
                                                @csrf
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label for="name">Name</label>
                                                        <input type="text" class="form-control" id="name"
                                                            name="name" placeholder="Enter new category named">
                                                    </div>
                                                    <input type="hidden" name="parent_id" value="{{ $category->id }}">
                                                </div>
                                                <div class="modal-footer justify-content-between">
                                                    <button type="button" class="btn btn-default"
                                                        data-dismiss="modal">Close</button>
                                                    <button type="sumbit" class="btn btn-primary">Submit</button>
                                                </div>
                                            </form>
                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                </div>
                                <!-- /.modal-dialog -->
                                @php
                                    $category_num = $loop->iteration;
                                @endphp
                                {{-- ===== Childrens ===== --}}
                                @foreach ($category->childrens as $children)
                                    <tr>
                                        <td>{{ $category_num . '-' . $loop->iteration }}</td>
                                        <td>{{ $children->name }}</td>
                                        <td>
                                            @if ($children->active)
                                                <span class="bg-red-700 btn-sm btn-success font-weight-bolder">
                                                    active
                                                </span>
                                            @else
                                                <span class="btn-sm btn-danger font-weight-bolder">
                                                    not active
                                                </span>
                                            @endif
                                        </td>
                                        <td> - </td>
                                        <td>{{ $children->created_at->toDateString() }}</td>
                                        <td class="gap-2 d-flex align-items-center">
                                            <a href="{{ route('dashboard.categories.toggle', $children->id) }}">
                                                @if ($children->active)
                                                    <i class="fas fa-toggle-on text-success"
                                                        style="font-size: 1.5rem"></i>
                                                @else
                                                    <i class="fas fa-toggle-off text-danger"
                                                        style="font-size: 1.5rem"></i>
                                                @endif
                                            </a>

                                            <button type="button" class="align-items-end" data-toggle="modal"
                                                data-target="#edit-modal-{{ $children->id }}">
                                                <i class="fas fa-edit" style="font-size: 1.2rem"></i>
                                            </button>

                                            <button type="button"
                                                class="align-items-end delete-btn {{ $children->id }}">
                                                <i class="fas fa-trash-alt text-danger" style="font-size: 1.2rem"></i>
                                            </button>
                                            <form action="{{ route('dashboard.categories.destroy', $children->id) }}"
                                                method="POST" class="delete-form">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </td>
                                    </tr>

                                    {{-- Modal for update subcategory  --}}
                                    <div class="modal fade" id="edit-modal-{{ $children->id }}">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Edit {{ $category->name }}</h4>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="{{ route('dashboard.categories.update', $children->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label for="name">Name</label>
                                                            <input type="text" class="form-control" id="name"
                                                                name="name" value="{{ $children->name }}"
                                                                placeholder="Enter new category named">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="edit subcategory">Parent</label>
                                                            <select class="custom-select rounded-0" id="edit subcategory"
                                                                name="parent_id">
                                                                @foreach ($parents as $parent)
                                                                    <option value="{{ $parent->id }}"
                                                                        @selected($parent->id == $children->parent_id)>{{ $parent->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer justify-content-between">
                                                        <button type="button" class="btn btn-default"
                                                            data-dismiss="modal">Close</button>
                                                        <button type="sumbit" class="btn btn-primary">Submit</button>
                                                    </div>
                                                </form>
                                            </div>
                                            <!-- /.modal-content -->
                                        </div>
                                    </div>
                                @endforeach

                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">No categories found</td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>

    <div class="modal fade" id="modal-default">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Main category</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('dashboard.categories.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name"
                                placeholder="Enter new category named">
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="sumbit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
@endsection

@push('scripts')
    <script>
        $('.delete-btn').on('click', function() {
            let deleteBtn = $(this);
            $.confirm({
                buttons: {
                    info: {
                        btnClass: 'btn-blue',
                        text: 'delete',
                        action: function() {
                            deleteBtn.siblings('.delete-form').submit()
                        }
                    },
                    danger: {
                        btnClass: 'btn-red any-other-class', // multiple classes.
                        text: 'cancel'
                    },

                },
                animation: 'zoom',
                closeAnimation: 'scale',
                theme: 'supervan',
                title: 'Delete Category',

            });

        });
    </script>
@endpush
