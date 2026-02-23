@extends('admin.layout')

@section('title', 'Edit Privacy Policy')

@section('content')
    <div class="page-header">
        <div class="page-header-title">
            <h1>Edit Privacy Policy</h1>
            <p>Update the content of the Privacy Policy page.</p>
        </div>
    </div>

    <div class="card">
        <form action="{{ route('admin.settings.privacy-policy.update') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="privacy_policy_content">Content</label>
                <textarea name="privacy_policy_content" id="privacy_policy_content" class="form-control"
                    rows="20">{{ old('privacy_policy_content', $privacyContent) }}</textarea>
                @error('privacy_policy_content')
                    <span class="text-error"
                        style="font-size: 0.875rem; color: var(--color-error); margin-top: 0.25rem; display: block;">{{ $message }}</span>
                @enderror
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
            $('#privacy_policy_content').trumbowyg({
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