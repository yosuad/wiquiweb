@extends('layouts.admin')

@section('title', 'Administration')

@php $pageTitle = 'Administration'; @endphp

@section('content')

    <div class="dashboard__title-section">
        <div class="dashboard__title-row">
            <p class="dashboard__page-desc">Users with panel access</p>
            <button class="btn-primary" onclick="document.getElementById('modal-create').style.display='flex'">
                <i data-lucide="plus"></i> Add user
            </button>
        </div>
    </div>

    {{-- Pending users — solo administrator --}}
    @if($isAdmin && $pending->count())
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
                                    onclick="openEditModal({{ $user->id }}, '{{ $user->name }}', '{{ $user->email }}', '', '{{ $user->status }}')">
                                    <i data-lucide="pencil"></i>
                                </button>
                                <form method="POST" action="{{ route('admin.convert.prospect', $user->id) }}"
                                    data-confirm="¿Convertir a {{ $user->name }} en prospecto? El usuario será eliminado del panel.">
                                    @csrf
                                    <button type="submit" class="btn-action btn-notes" title="Convertir a prospecto">
                                        <i data-lucide="user-check"></i>
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('admin.destroy', $user->id) }}"
                                    data-confirm="¿Eliminar a {{ $user->name }}? Esta acción no se puede deshacer.">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-action btn-delete" title="Delete">
                                        <i data-lucide="trash-2"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    {{-- Active users --}}
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
                            <span class="badge {{ match($admin->status) {
                                'approved' => 'badge-closed',
                                'pending'  => 'badge-follow',
                                'rejected' => 'badge-lost',
                                default    => 'badge-lost'
                            } }}">
                                {{ ucfirst($admin->status) }}
                            </span>
                        </td>
                        <td class="td-actions">
                            <button class="btn-action btn-edit" title="Edit"
                                onclick="openEditModal({{ $admin->id }}, '{{ $admin->name }}', '{{ $admin->email }}', '{{ $admin->roles->first()?->name }}', '{{ $admin->status }}')">
                                <i data-lucide="pencil"></i>
                            </button>
                            <form method="POST" action="{{ route('admin.destroy', $admin->id) }}"
                                data-confirm="¿Eliminar a {{ $admin->name }}? Esta acción no se puede deshacer.">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-action btn-delete" title="Delete">
                                    <i data-lucide="trash-2"></i>
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

    {{-- Permissions matrix — solo administrator --}}
    @if($isAdmin)
        <div class="table-container" style="margin-top: 1.5rem;">
            <div class="table-section-header">
                <strong>Role Permissions</strong>
            </div>
            <form method="POST" action="{{ route('admin.permissions.update') }}">
                @csrf
                @method('PUT')
                <table class="data-table permissions-table">
                    <thead>
                        <tr>
                            <th>Permission</th>
                            @foreach($roles->where('name', '!=', 'administrator') as $role)
                                <th class="text-center">{{ $role->name }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($permissions as $permission)
                            <tr>
                                <td class="font-medium">{{ $permission->name }}</td>
                                @foreach($roles->where('name', '!=', 'administrator') as $role)
                                    <td class="text-center">
                                        <input type="checkbox"
                                            name="permissions[{{ $role->id }}][]"
                                            value="{{ $permission->id }}"
                                            class="check-msg"
                                            {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }}>
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="form-actions" style="padding: 1rem;">
                    <button type="submit" class="btn-primary">
                        <i data-lucide="save"></i> Save permissions
                    </button>
                </div>
            </form>
        </div>
    @endif

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
                    <label>Password</label>
                    <input type="password" name="password" class="form-input" placeholder="Minimum 8 characters" required minlength="8">
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
                    <button type="submit" class="btn-primary"><i data-lucide="save"></i> Save</button>
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
                    <label>New password <span style="font-weight:400; color: var(--text-secondary);">(leave blank to keep current)</span></label>
                    <input type="password" name="password" id="edit-password" class="form-input" placeholder="New password" minlength="8">
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
                <div class="form-group">
                    <label>Status</label>
                    <select name="status" id="edit-status" class="form-input" required>
                        <option value="approved">Approved — acceso activo</option>
                        <option value="pending">Pending — bloqueado temporalmente</option>
                        <option value="rejected">Rejected — bloqueado permanentemente</option>
                    </select>
                </div>
                <div class="form-actions">
                    <button type="button" class="btn-secondary" onclick="document.getElementById('modal-edit').style.display='none'">Cancel</button>
                    <button type="submit" class="btn-primary"><i data-lucide="save"></i> Update</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openEditModal(id, name, email, role, status) {
            document.getElementById('edit-name').value     = name;
            document.getElementById('edit-email').value    = email;
            document.getElementById('edit-role').value     = role;
            document.getElementById('edit-status').value   = status;
            document.getElementById('edit-password').value = '';
            document.getElementById('form-edit').action    = '/admin/' + id;
            document.getElementById('modal-edit').style.display = 'flex';
        }
    </script>

@endsection