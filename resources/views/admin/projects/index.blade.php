@extends('layouts.admin')

@section('content')
    <div class="container py-3">
        <h2>Prortfolio</h2>

        <div class="table-responsive">
            <table class="table table-primary">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Image</th>
                        <th scope="col">Title</th>
                        <th scope="col">Author</th>
                        <th scope="col">Actions</th>

                    </tr>
                </thead>
                <tbody>
                    @forelse ($projects as $project)
                        <tr class="">
                            <td scope="row">{{ $project->id }}</td>
                            <td>
                                <img width="100" src="{{ $project->image }}" alt="">
                            </td>
                            <td>{{ $project->title }}</td>
                            <td>{{ $project->author }}</td>
                            <th scope="col">show/edit/delete</th>
                        </tr>
                    @empty

                        <tr class="">
                            <td scope="row" colspan="5">No projects yet</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $projects->links('pagination::bootstrap-5') }}
        </div>

    </div>
@endsection