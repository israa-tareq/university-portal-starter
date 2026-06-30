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
        <form action="{{ route('profile.update') }}" method="POST" class="module-form" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="profile-avatar-field">
                <div class="profile-avatar-preview" id="avatarPreview">
                    @if($user->avatarUrl())
                        <img src="{{ $user->avatarUrl() }}" alt="{{ $user->name }}" id="avatarPreviewImg">
                    @else
                        <span id="avatarPreviewInitials">
                            {{ strtoupper(mb_substr($user->name, 0, 1)) }}
                        </span>
                    @endif
                </div>
                <div class="profile-avatar-actions">
                    <button type="button" class="btn btn-secondary" onclick="document.getElementById('avatarInput').click()">
                        <i data-lucide="upload"></i> Change photo
                    </button>
                    @if($user->avatarUrl())
                        <label class="profile-remove-avatar">
                            <input type="checkbox" name="remove_avatar" value="1"> Remove current photo
                        </label>
                    @endif
                    <input type="file" id="avatarInput" name="avatar" accept="image/*" style="display:none" onchange="previewAvatar(this)">
                </div>
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
    function previewAvatar(input) {
        if (!input.files || !input.files[0]) return;
        const reader = new FileReader();
        reader.onload = function (e) {
            const preview = document.getElementById('avatarPreview');
            preview.innerHTML = '<img src="' + e.target.result + '" id="avatarPreviewImg">';
        };
        reader.readAsDataURL(input.files[0]);
    }
</script>
@endpush
