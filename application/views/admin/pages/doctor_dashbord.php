<!-- Upcoming Appointments Card -->
<div class="card">
    <div class="card-header">
        <i class="fas fa-list-alt me-2"></i> Your Upcoming Appointments
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Patient</th>
                        <th>Contact</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Sickness / Reason</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (isset($appointments) && !empty($appointments)) : ?>
                        <?php foreach ($appointments as $appointment) : ?>
                            <?php
                            // Convert numeric status to consistent format
                            $statusMap = [
                                0 => 'pending',
                                1 => 'confirmed', 
                                2 => 'cancelled'
                            ];
                            $appointmentStatus = isset($appointment->status) ? 
                                (is_numeric($appointment->status) ? $statusMap[$appointment->status] : strtolower($appointment->status)) 
                                : 'pending';
                            
                            // Get sickness/reason information - check different possible field names
                            $sickness = '';
                            if (!empty($appointment->sickness)) {
                                $sickness = $appointment->sickness;
                            } elseif (!empty($appointment->reason)) {
                                $sickness = $appointment->reason;
                            } elseif (!empty($appointment->symptoms)) {
                                $sickness = $appointment->symptoms;
                            } elseif (!empty($appointment->description)) {
                                $sickness = $appointment->description;
                            } elseif (!empty($appointment->medical_condition)) {
                                $sickness = $appointment->medical_condition;
                            } elseif (!empty($appointment->illness)) {
                                $sickness = $appointment->illness;
                            }
                            
                            // Get patient information - check different possible field names
                            $patientName = '';
                            $patientEmail = '';
                            $patientPhone = '';
                            
                            if (!empty($appointment->patient_name)) {
                                $patientName = $appointment->patient_name;
                            } elseif (!empty($appointment->firstname)) {
                                $patientName = $appointment->firstname . ' ' . (!empty($appointment->lastname) ? $appointment->lastname : '');
                            } elseif (!empty($appointment->name)) {
                                $patientName = $appointment->name;
                            }
                            
                            if (!empty($appointment->patient_email)) {
                                $patientEmail = $appointment->patient_email;
                            } elseif (!empty($appointment->email)) {
                                $patientEmail = $appointment->email;
                            }
                            
                            if (!empty($appointment->patient_phone)) {
                                $patientPhone = $appointment->patient_phone;
                            } elseif (!empty($appointment->phone)) {
                                $patientPhone = $appointment->phone;
                            } elseif (!empty($appointment->contact)) {
                                $patientPhone = $appointment->contact;
                            }
                            ?>
                            <tr>
                                <td>
                                    <strong><?= !empty($patientName) ? htmlspecialchars($patientName) : 'Unknown Patient' ?></strong>
                                </td>
                                <td>
                                    <?php if (!empty($patientEmail)) : ?>
                                        <small class="d-block"><?= htmlspecialchars($patientEmail) ?></small>
                                    <?php endif; ?>
                                    <?php if (!empty($patientPhone)) : ?>
                                        <small class="d-block text-muted"><?= htmlspecialchars($patientPhone) ?></small>
                                    <?php endif; ?>
                                    <?php if (empty($patientEmail) && empty($patientPhone)) : ?>
                                        <small class="text-muted">No contact info</small>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if (!empty($appointment->date)) : ?>
                                        <?= date('F j, Y', strtotime($appointment->date)) ?>
                                    <?php else : ?>
                                        <span class="text-muted">N/A</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if (!empty($appointment->time)) : ?>
                                        <?= date('g:i A', strtotime($appointment->time)) ?>
                                    <?php else : ?>
                                        <span class="text-muted">N/A</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if (!empty($sickness)) : ?>
                                        <div class="sickness-info">
                                            <button class="btn btn-sm btn-outline-info" 
                                                    data-bs-toggle="tooltip" 
                                                    title="<?= htmlspecialchars($sickness) ?>">
                                                <i class="fas fa-stethoscope"></i> View Details
                                            </button>
                                            <!-- Truncated preview -->
                                            <small class="d-block text-muted mt-1">
                                                <?= strlen($sickness) > 50 ? htmlspecialchars(substr($sickness, 0, 50)) . '...' : htmlspecialchars($sickness) ?>
                                            </small>
                                        </div>
                                    <?php else : ?>
                                        <span class="text-muted"><i>No information provided</i></span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="badge bg-<?= 
                                        $appointmentStatus == 'confirmed' ? 'success' : 
                                        ($appointmentStatus == 'pending' ? 'warning' : 'danger') 
                                    ?>">
                                        <?= ucfirst($appointmentStatus) ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <?php if ($appointmentStatus == 'pending') : ?>
                                            <form action="<?= site_url('doctor_controller/update_appointment_status') ?>" method="post" style="display: inline;">
                                                <input type="hidden" name="appointment_id" value="<?= $appointment->id ?>">
                                                <input type="hidden" name="status" value="confirmed">
                                                <button type="submit" class="btn btn-sm btn-success me-1" title="Confirm Appointment">
                                                    <i class="fas fa-check"></i> Confirm
                                                </button>
                                            </form>
                                        <?php endif; ?>
                                        
                                        <?php if ($appointmentStatus != 'cancelled') : ?>
                                            <form action="<?= site_url('doctor_controller/cancel_appointment/' . $appointment->id) ?>" method="post" style="display: inline;">
                                                <input type="hidden" name="appointment_id" value="<?= $appointment->id ?>">
                                                <button type="submit" class="btn btn-sm btn-danger me-1" 
                                                        onclick="return confirm('Are you sure you want to cancel this appointment?')"
                                                        title="Cancel Appointment">
                                                    <i class="fas fa-times"></i> Cancel
                                                </button>
                                            </form>
                                        <?php endif; ?>
                                        
                                        <!-- View Full Details Button -->
                                        <button class="btn btn-sm btn-outline-primary" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#appointmentDetailModal"
                                                data-appointment-id="<?= $appointment->id ?>"
                                                title="View Full Details">
                                            <i class="fas fa-eye"></i> Details
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                <i class="fas fa-calendar-times fa-2x mb-3"></i><br>
                                No upcoming appointments found.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-between align-items-center mt-3">
            <div class="text-muted">Showing <?= isset($appointments) ? count($appointments) : 0 ?> appointments</div>
            <a href="<?= site_url('doctor_controller/all_appointments') ?>" class="btn btn-outline-primary">
                <i class="fas fa-list"></i> View All Appointments
            </a>
        </div>
    </div>
</div>