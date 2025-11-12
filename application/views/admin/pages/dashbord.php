<!-- Upcoming Appointments Card -->
<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-list-alt me-2"></i> Your Upcoming Appointments
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
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
                    <?php if (isset($appointments) && is_array($appointments)) : ?>
                        <?php foreach ($appointments as $appointment) : ?>
                            <tr>
                                <td><?= htmlspecialchars($appointment->doctor_name) ?></td>
                                <td><?= htmlspecialchars($appointment->specialization) ?></td>
                                <td><?= date('F j, Y', strtotime($appointment->date)) ?></td>
                                <td><?= date('g:i A', strtotime($appointment->time)) ?></td>
                                <td>
                                    <span class="status-badge status-<?= strtolower($appointment->status) ?>">
                                        <?= ucfirst($appointment->status) ?>
                                    </span>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary me-1"><i class="fas fa-edit"></i></button>
                                    <button class="btn btn-sm btn-outline-danger"><i class="fas fa-times"></i></button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="6" class="text-center">No upcoming appointments found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-between align-items-center mt-3">
            <div>Showing <?= isset($appointments) ? count($appointments) : 0 ?> of 5 appointments</div>
            <button class="btn btn-outline-primary">View All Appointments</button>
        </div>
    </div>
</div>