@extends('components.admin')

@section('title', 'Administración')

@section('content')

    <div class="dashboard__content">
        <div class="dashboard__title-section">
            <h1 class="dashboard__page-title">Administración</h1>
            <p class="dashboard__page-desc">Usuarios con acceso al panel</p>
        </div>

        <div class="table-container">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Rol</th>
                        <th>Estado</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="font-medium">Carlos Méndez</td>
                        <td class="td-email">carlos@empresa.com</td>
                        <td><span class="badge badge-closed">Admin</span></td>
                        <td><span class="badge badge-closed">Activo</span></td>
                        <td class="td-actions">
                            <button class="btn-action btn-edit" title="Editar">✏️</button>
                            <button class="btn-action btn-delete" title="Eliminar">🗑️</button>
                        </td>
                    </tr>
                    <tr>
                        <td class="font-medium">Laura García</td>
                        <td class="td-email">laura@empresa.com</td>
                        <td><span class="badge badge-follow">Editor</span></td>
                        <td><span class="badge badge-closed">Activo</span></td>
                        <td class="td-actions">
                            <button class="btn-action btn-edit" title="Editar">✏️</button>
                            <button class="btn-action btn-delete" title="Eliminar">🗑️</button>
                        </td>
                    </tr>
                    <tr>
                        <td class="font-medium">Roberto Díaz</td>
                        <td class="td-email">roberto@empresa.com</td>
                        <td><span class="badge badge-contacted">Agente de cobros</span></td>
                        <td><span class="badge badge-closed">Activo</span></td>
                        <td class="td-actions">
                            <button class="btn-action btn-edit" title="Editar">✏️</button>
                            <button class="btn-action btn-delete" title="Eliminar">🗑️</button>
                        </td>
                    </tr>
                    <tr>
                        <td class="font-medium">Ana Torres</td>
                        <td class="td-email">ana@empresa.com</td>
                        <td><span class="badge badge-new">Agente de ventas</span></td>
                        <td><span class="badge badge-closed">Activo</span></td>
                        <td class="td-actions">
                            <button class="btn-action btn-edit" title="Editar">✏️</button>
                            <button class="btn-action btn-delete" title="Eliminar">🗑️</button>
                        </td>
                    </tr>
                    <tr>
                        <td class="font-medium">Miguel Ruiz</td>
                        <td class="td-email">miguel@empresa.com</td>
                        <td><span class="badge badge-follow">Soporte</span></td>
                        <td><span class="badge badge-new">Inactivo</span></td>
                        <td class="td-actions">
                            <button class="btn-action btn-edit" title="Editar">✏️</button>
                            <button class="btn-action btn-delete" title="Eliminar">🗑️</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

@endsection