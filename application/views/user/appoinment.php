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
                        <th>Queue NO:</th>
                        <!-- <th>Patient Name</th> -->
                        <th>Reason</th>
                        <th>Doctor Name</th>
                       

                        <th>Specialization</th>
                         <th>Time</th>
                        <!-- <th>Actions</th> -->
                        <th>Status</th>
                    </tr>
                </thead><?php if (!empty($records)) {
                    foreach ($records as $row) { ?>
                <tr>
                    <td><?= htmlspecialchars($row->record_id) ?></td>
                     <td><?= htmlspecialchars($row->reason) ?></td>

                    <td><?= htmlspecialchars($row->doctor_name) ?></td>
                    <td><?= htmlspecialchars($row->specialist) ?></td>
                    <td><?= htmlspecialchars($row->date) ?>
                        <?= htmlspecialchars($row->time) ?></td>
                    <td>
                        <?php
        $statusText = '';
        $color = '';

        switch ($row->status) {
            case '1':
                $statusText = 'Confirmed';
                $color = '#28a745'; // green
                break;
            case '2':
                $statusText = 'Canceled';
                $color = '#dc3545'; // red
                break;
            case '3':
                $statusText = 'Rescheduled';
                $color = '#ffc107'; // yellow
                break;
            case '':
            case null:
                $statusText = 'Pending';
                $color = '#007bff'; // blue
                break;
            default:
                $statusText = 'Unknown';
                $color = '#6c757d'; // gray
        }
    ?>
                        <span
                            style="color: white; background-color: <?= $color ?>; padding: 4px 8px; border-radius: 4px;">
                            <?= $statusText ?>
                        </span>
                    </td>
                </tr>
                <?php }
                } else { ?>
                <tr>
                    <td colspan="7">No records found.</td>
                </tr>
                <?php } ?>
            </table>
        </div>
    </div>
</div>