<!-- Upcoming Appointments Card -->
<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-list-alt me-2"></i> Your Upcoming Appointments
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Doctor</th>
                        <th>Specialization</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (isset($appointments) && is_array($appointments) && !empty($appointments)): ?>
                        <?php foreach ($appointments as $appointment): ?>
                            <tr>
                                <td><?= htmlspecialchars($appointment->doctor_name ?? 'N/A') ?></td>
                                <td><?= htmlspecialchars($appointment->specialization ?? 'N/A') ?></td>
                                <td><?= !empty($appointment->date) ? date('F j, Y', strtotime($appointment->date)) : 'N/A' ?></td>
                                <td><?= !empty($appointment->time) ? date('g:i A', strtotime($appointment->time)) : 'N/A' ?></td>
                                <td>
                                    <?php
                                    // Define status colors and labels
                                    $statusConfig = [
                                        'pending' => ['color' => 'warning', 'label' => 'Pending'],
                                        'confirmed' => ['color' => 'success', 'label' => 'Confirmed'],
                                        'cancelled' => ['color' => 'danger', 'label' => 'Cancelled'],
                                        'completed' => ['color' => 'info', 'label' => 'Completed'],
                                        'noshow' => ['color' => 'secondary', 'label' => 'No Show']
                                    ];
                                    
                                    $status = strtolower($appointment->status ?? 'pending');
                                    $config = $statusConfig[$status] ?? $statusConfig['pending'];
                                    ?>
                                    <span class="badge bg-<?= $config['color'] ?>">
                                        <?= $config['label'] ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <?php if (in_array($status, ['pending', 'confirmed'])): ?>
                                            <a href="<?= base_url('appointments/edit/' . ($appointment->id ?? '')) ?>" 
                                               class="btn btn-outline-primary" 
                                               title="Edit Appointment">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="<?= base_url('appointments/cancel/' . ($appointment->id ?? '')) ?>" 
                                               class="btn btn-outline-danger" 
                                               title="Cancel Appointment"
                                               onclick="return confirm('Are you sure you want to cancel this appointment?');">
                                                <i class="fas fa-times"></i>
                                            </a>
                                        <?php else: ?>
                                            <button class="btn btn-outline-secondary" disabled title="No actions available">
                                                <i class="fas fa-ban"></i>
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                <i class="fas fa-calendar-times fa-2x mb-3 d-block"></i>
                                No upcoming appointments found.
                                <br>
                                <a href="<?= base_url('doctors') ?>" class="btn btn-primary mt-2">Book an Appointment</a>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
        <?php if (isset($appointments) && is_array($appointments) && !empty($appointments)): ?>
        <div class="d-flex justify-content-between align-items-center mt-3">
            <div class="text-muted">
                Showing <?= count($appointments) ?> of 
                <?= isset($total_appointments) ? $total_appointments : count($appointments) ?> 
                appointment<?= (count($appointments) !== 1) ? 's' : '' ?>
            </div>
            <a href="<?= base_url('appointments') ?>" class="btn btn-outline-primary">
                <i class="fas fa-list me-1"></i>View All Appointments
            </a>
        </div>
        <?php endif; ?>
    </div>
</div>

<style>
.status-badge {
    padding: 0.25rem 0.5rem;
    border-radius: 0.25rem;
    font-size: 0.75rem;
    font-weight: 500;
}
</style>