@extends('layouts.admin')

@section('title', 'Administration')

@php $pageTitle = 'Administration'; @endphp

@section('content')

    <div class="dashboard__title-section">
        <div class="dashboard__title-row">
            <p class="dashboard__page-desc">Users with panel access</p>
            <button class="btn-primary" onclick="document.getElementById('modal-create').style.display='flex'">
                <i class="fas fa-plus"></i> Add user
            </button>
        </div>
    </div>

    {{-- Pending users (no role assigned) --}}
    @if($pending->count())
        <div class="table-container">
            <div class="table-section-header">
                <strong>⚠ Users without role ({{ $pending->count() }})</strong>
            </div>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pending as $user)
                        <tr>
                            <td class="font-medium">{{ $user->name }}</td>
                            <td class="td-email">{{ $user->email }}</td>
                            <td><span class="badge badge-lost">Sin rol</span></td>
                            <td><span class="badge badge-lost">Pending</span></td>
                            <td class="td-actions">
                                <button class="btn-action btn-edit" title="Assign role"
                                    onclick="openEditModal({{ $user->id }}, '{{ $user->name }}', '{{ $user->email }}', '')">
                                    <i class="fas fa-pen"></i>
                                </button>
                                <form method="POST" action="{{ route('admin.convert.prospect', $user->id) }}">
                                    @csrf
                                    <button class="btn-action btn-notes" title="Convertir a prospecto"
                                        onclick="return confirm('¿Convertir a prospecto? El usuario será eliminado del panel.')">
                                        <i class="fas fa-user-tag"></i>
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('admin.destroy', $user->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn-action btn-delete" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    {{-- Active users with roles --}}
    <div class="table-container">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($admins as $admin)
                    <tr>
                        <td class="font-medium">{{ $admin->name }}</td>
                        <td class="td-email">{{ $admin->email }}</td>
                        <td>
                            @foreach($admin->roles as $role)
                                <span class="badge badge-new">{{ $role->name }}</span>
                            @endforeach
                        </td>
                        <td>
                            <span class="badge {{ $admin->status === 'approved' ? 'badge-closed' : 'badge-lost' }}">
                                {{ ucfirst($admin->status) }}
                            </span>
                        </td>
                        <td class="td-actions">
                            <button class="btn-action btn-edit" title="Edit"
                                onclick="openEditModal({{ $admin->id }}, '{{ $admin->name }}', '{{ $admin->email }}', '{{ $admin->roles->first()?->name }}')">
                                <i class="fas fa-pen"></i>
                            </button>
                            <form method="POST" action="{{ route('admin.destroy', $admin->id) }}">
                                @csrf
                                @method('DELETE')
                                <button class="btn-action btn-delete" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">No users registered.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Create modal --}}
    <div id="modal-create" class="modal-overlay">
        <div class="form-container modal-box">
            <h3 class="modal-title">Add user</h3>
            <form method="POST" action="{{ route('admin.store') }}">
                @csrf
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="name" class="form-input" placeholder="Full name" required>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" class="form-input" placeholder="email@example.com" required>
                </div>
                <div class="form-group">
                    <label>Role</label>
                    <select name="role" class="form-input" required>
                        <option value="">— Select —</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->name }}">{{ $role->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-actions">
                    <button type="button" class="btn-secondary" onclick="document.getElementById('modal-create').style.display='none'">Cancel</button>
                    <button type="submit" class="btn-primary"><i class="fas fa-save"></i> Save</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Edit modal --}}
    <div id="modal-edit" class="modal-overlay">
        <div class="form-container modal-box">
            <h3 class="modal-title">Edit user</h3>
            <form method="POST" id="form-edit" action="">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="name" id="edit-name" class="form-input" required>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" id="edit-email" class="form-input" required>
                </div>
                <div class="form-group">
                    <label>Role</label>
                    <select name="role" id="edit-role" class="form-input" required>
                        <option value="">— Select —</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->name }}">{{ $role->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-actions">
                    <button type="button" class="btn-secondary" onclick="document.getElementById('modal-edit').style.display='none'">Cancel</button>
                    <button type="submit" class="btn-primary"><i class="fas fa-save"></i> Update</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openEditModal(id, name, email, role) {
            document.getElementById('edit-name').value  = name;
            document.getElementById('edit-email').value = email;
            document.getElementById('edit-role').value  = role;
            document.getElementById('form-edit').action = '/admin/' + id;
            document.getElementById('modal-edit').style.display = 'flex';
        }
    </script>

@endsection