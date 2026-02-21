<?= $this->extend('admin/template') ?>

<?= $this->section('content') ?>

    <h3>Lista de Usuarios</h3>

    <table class="table table-hover align-middle">
        <thead class="table-light">
            <tr>
                <th>Nombre</th>
                <th>Email</th>
                <th>Horario</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td>
                        <?= esc($user['last_name']) ?>, 
                        <?= esc($user['first_name']) ?>
                    </td>

                    <td><?= esc($user['email']) ?></td>

                    <td>
                        <?php if ($user['approved'] !== null): ?>
                            <a href="<?= base_url('admin/horario/'.$user['id']) ?>" 
                            class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-calendar3"></i> Ver horario
                            </a>
                        <?php else: ?>
                            <span class="text-muted">
                                <i class="bi bi-dash-circle"></i> Sin horario
                            </span>
                        <?php endif; ?>
                    </td>

                    <td>
                        <?php if ($user['approved'] == 1): ?>
                            <span class="badge bg-success">
                                <i class="bi bi-check-circle"></i> 
                                Aprobado
                            </span>
                            <?php if (!empty($user['approved_at'])): ?>
                                <br>
                                <small class="text-muted">
                                    <?= date('d/m/Y', strtotime($user['approved_at'])) ?>
                                </small>
                            <?php endif; ?>

                        <?php elseif ($user['approved'] === null): ?>
                            <span class="badge bg-secondary">
                                <i class="bi bi-x-circle"></i> Sin horario
                            </span>

                        <?php else: ?>
                            <span class="badge bg-warning text-dark">
                                <i class="bi bi-clock-history"></i> Pendiente
                            </span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

<?= $this->endSection() ?>