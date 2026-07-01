@extends('layouts.layout')
@section('title', 'My Profile')
@section('content')

<div class="module-form-page">
    <div class="module-return">
        <a href="{{ route('dashboard') }}">
            <i data-lucide="arrow-left"></i>
            <span>Return to Dashboard</span>
        </a>
    </div>

    <x-card title="Edit My Profile">
        {{-- No enctype needed — image is sent as base64 text, not a file upload --}}
        <form action="{{ route('profile.update') }}" method="POST" class="module-form" id="profileForm">
            @csrf

            <div class="profile-avatar-field">
                <div class="profile-avatar-preview" id="avatarPreview">
                    @if($user->avatarUrl())
                        <img src="{{ $user->avatarUrl() }}" alt="{{ $user->name }}">
                    @else
                        <span>{{ strtoupper(mb_substr($user->name, 0, 1)) }}</span>
                    @endif
                </div>

                <div class="profile-avatar-actions">
                    <button type="button" class="btn btn-secondary" id="changePhotoBtn">
                        <i data-lucide="upload"></i> Change photo
                    </button>
                    @if($user->avatarUrl())
                        <label class="profile-remove-avatar">
                            <input type="checkbox" name="remove_avatar" value="1"> Remove current photo
                        </label>
                    @endif
                    {{-- Hidden file picker — not submitted; JS reads & encodes to base64 --}}
                    <input type="file" id="avatarInput" accept="image/jpeg,image/png,image/gif,image/webp" style="display:none">
                </div>

                {{-- Base64-encoded image data sent as a plain text field --}}
                <input type="hidden" name="avatar_b64" id="avatar_b64">

                <span class="form-error" id="avatarClientError" style="display:none"></span>
                @error('avatar')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-divider"></div>

            <x-form-input name="name" label="Full Name" :value="$user->name" required />

            <div class="form-group">
                <label class="form-label">Email</label>
                <input type="email" class="form-control" value="{{ $user->email }}" disabled>
            </div>

            <div class="form-divider"></div>
            <div class="form-actions">
                <x-button :href="route('dashboard')" variant="secondary">Cancel</x-button>
                <x-button type="submit" variant="primary">Save Changes</x-button>
            </div>
        </form>
    </x-card>
</div>

@endsection

@push('styles')
    <link rel="stylesheet" href="{{ url('css/modules.css') }}">
    <style>
        .profile-avatar-field {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 12px;
        }
        .profile-avatar-preview {
            width: 88px;
            height: 88px;
            border-radius: 50%;
            background-color: #0FA4AF;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            font-weight: 700;
            overflow: hidden;
            border: 2px solid #e5e7eb;
        }
        .profile-avatar-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .profile-avatar-actions {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
        }
        .profile-remove-avatar {
            font-size: 0.85em;
            color: #6b7280;
            display: flex;
            align-items: center;
            gap: 6px;
            cursor: pointer;
        }
    </style>
@endpush

@push('scripts')
<script>
(function () {
    var fileInput   = document.getElementById('avatarInput');
    var b64Field    = document.getElementById('avatar_b64');
    var preview     = document.getElementById('avatarPreview');
    var clientError = document.getElementById('avatarClientError');
    var changeBtn   = document.getElementById('changePhotoBtn');

    changeBtn.addEventListener('click', function () {
        fileInput.click();
    });

    fileInput.addEventListener('change', function () {
        clientError.style.display = 'none';
        clientError.textContent   = '';
        b64Field.value            = '';

        if (!this.files || !this.files[0]) return;
        var file = this.files[0];

        var allowed = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        if (!allowed.includes(file.type)) {
            clientError.textContent = 'Please choose a JPG, PNG, GIF, or WebP image.';
            clientError.style.display = '';
            this.value = '';
            return;
        }

        if (file.size > 2 * 1024 * 1024) {
            clientError.textContent = 'This image is ' + (file.size / 1024 / 1024).toFixed(1) + ' MB — please choose a file under 2 MB.';
            clientError.style.display = '';
            this.value = '';
            return;
        }

        var reader = new FileReader();
        reader.onload = function (e) {
            // Store the data URL in the hidden field so it's submitted as plain text
            b64Field.value = e.target.result;
            preview.innerHTML = '<img src="' + e.target.result + '">';
        };
        reader.readAsDataURL(file);
    });
})();
</script>
@endpush
