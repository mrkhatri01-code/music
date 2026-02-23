@extends('admin.layout')

@section('title', 'Add Genre')

@section('content')
    <div class="page-header">
        <h1>Add New Genre</h1>
    </div>

    <div class="card">
        <form action="{{ route('admin.genres.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="name">Genre Name *</label>
                <input type="text" id="name" name="name" class="form-control" required value="{{ old('name') }}">
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" class="form-control">{{ old('description') }}</textarea>
            </div>

            <div style="display: flex; gap: 1rem;">
                <button type="submit" class="btn btn-success">Create Genre</button>
                <a href="{{ route('admin.genres.index') }}" class="btn"
                    style="background: #e2e8f0; color: #4a5568;">Cancel</a>
            </div>
        </form>
    </div>

@endsection