@extends('layouts.admin')

@section('content')
    <div class="container py-3">
        <div class="d-flex justify-content-between align-items-center">
            <h2>Prortfolio</h2>
            <a class="btn btn-success" href="{{ route('admin.projects.create') }}">
                <i class="fa-solid fa-plus"></i>
                Add a new project
            </a>
        </div>
        @if (session('status'))
            <div class="bg-light my-2 p-3 border border-secondary">{{ session('status') }}</div>
        @endif

        <div class="table-responsive">
            <table class="table table-primary">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Image</th>
                        <th scope="col">Title</th>
                        <th scope="col">Author</th>
                        <th scope="col">Source code url</th>
                        <th scope="col">Production site url</th>
                        <th scope="col">Actions</th>

                    </tr>
                </thead>
                <tbody>
                    @forelse ($projects as $project)
                        <tr class="">
                            <td scope="row">{{ $project->id }}</td>
                            @if (Str::startsWith($project->image, 'http'))
                                <td>
                                    <img width="100" src="{{ $project->image }}" alt="{{ $project->title }}">
                                </td>
                            @else
                                <td>
                                    <img width="100" src="{{ asset('storage/' . $project->image) }}"
                                        alt="{{ $project->title }}">
                                </td>
                            @endif
                            <td>{{ $project->title }}</td>
                            <td>{{ $project->author }}</td>
                            <td>{{ $project->source_code_url }}</td>
                            <td>{{ $project->production_site_url }}</td>
                            <td scope="col">
                                <a class="btn btn-warning btn-sm m-2" href="{{ route('admin.projects.show', $project) }}">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                                <a class="btn btn-primary btn-sm m-2" href="{{ route('admin.projects.edit', $project) }}">
                                    <i class="fa-solid fa-pencil"></i>
                                </a>
                                <!-- Modal trigger button -->
                                <button type="button" class="btn btn-danger btn-sm m-2" data-bs-toggle="modal"
                                    data-bs-target="#modalId-{{ $project->id }}">
                                    <i class="fa-solid fa-trash"></i>
                                </button>

                                <!-- Modal Body -->
                                <!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
                                <div class="modal fade" id="modalId-{{ $project->id }}" tabindex="-1"
                                    data-bs-backdrop="static" data-bs-keyboard="false" role="dialog"
                                    aria-labelledby="modalTitle-{{ $project->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-sm"
                                        role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="modalTitle-{{ $project->id }}">
                                                    DELETING PROJECT
                                                </h5>
                                            </div>
                                            <div class="modal-body">You're deleting <span
                                                    class="text-danger">{{ $project->title }}</span>, it will not be
                                                possible to bring it back</div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                    <i class="fa-solid fa-arrow-left"></i>
                                                </button>
                                                <form action="{{ route('admin.projects.destroy', $project) }}"
                                                    method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">
                                                        DELETE
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td scope="row" colspan="7">No projects yet</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $projects->links('pagination::bootstrap-5') }}
        </div>

    </div>
@endsection
