@extends('admin.layout')

@section('title', 'Edit Disclaimer')

@section('content')
    <div class="page-header">
        <div class="page-header-title">
            <h1>Edit Disclaimer</h1>
            <p>Update the content of the Disclaimer page.</p>
        </div>
    </div>

    <div class="card">
        <form action="{{ route('admin.settings.disclaimer.update') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="disclaimer_content">Content</label>
                <textarea name="disclaimer_content" id="disclaimer_content" class="form-control"
                    rows="20">{{ old('disclaimer_content', $disclaimerContent) }}</textarea>
            </div>

            <div class="form-actions" style="margin-top: 2rem;">
                <button type="submit" class="btn btn-primary">
                    <i class="fa-solid fa-save"></i>
                    Save Changes
                </button>
            </div>
        </form>
    </div>

    <!-- jQuery (required for Trumbowyg) -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <!-- Trumbowyg -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.27.3/ui/trumbowyg.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.27.3/trumbowyg.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#disclaimer_content').trumbowyg({
                btns: [
                    ['viewHTML'],
                    ['undo', 'redo'], // Only supported in some browsers
                    ['formatting'],
                    ['strong', 'em', 'del'],
                    ['superscript', 'subscript'],
                    ['link'],
                    ['insertImage'],
                    ['justifyLeft', 'justifyCenter', 'justifyRight', 'justifyFull'],
                    ['unorderedList', 'orderedList'],
                    ['horizontalRule'],
                    ['removeformat'],
                    ['fullscreen']
                ],
                autogrow: true
            });
        });
    </script>
@endsection