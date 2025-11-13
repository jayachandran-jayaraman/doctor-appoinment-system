<!-- Appointment Booking Card -->
 <!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(document).ready(function() {
    $('#doctor_id').select2({
        placeholder: "-- Choose a Doctor --",
        allowClear: true,
        ajax: {
            url: "<?= site_url('patient_register/doctor_search') ?>",
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    action: 'search_doctor',
                    term: params.term
                };
            },
            processResults: function(data) {
                return {
                    results: data.results
                };
            },
            cache: true
        },
        minimumInputLength: 1
    });
});
</script>

<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-calendar-plus me-2"></i> Book an Appointment
    </div>
    <div class="card-body">
        <form action="<?= site_url('index/datashow_appoitment') ?>" method="post">
            <div class="row">
                <!-- Doctor Selection -->
                <div class="col-md-4 mb-3">
                    <label for="doctor_id" class="form-label">Select Doctor</label>
                    <select name="doctor" id="doctor_id" class="form-select" required>
                        <option value="">-- Choose a Doctor --</option>
                        <?php if (!empty($doctors) && is_array($doctors)): ?>
                            <?php foreach ($doctors as $doctor): ?>
                                <option value="<?= htmlspecialchars($doctor->id) ?>">
                                    <?= htmlspecialchars($doctor->firstname) ?> (<?= htmlspecialchars($doctor->specialist) ?>)
                                </option>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <option value="">No doctors available</option>
                        <?php endif; ?>
                    </select>
                </div>

                <!-- Appointment Date -->
                <div class="col-md-4 mb-3">
                    <label for="date" class="form-label">Date</label>
                    <input type="date" name="date" id="date" class="form-control" min="<?= date('Y-m-d') ?>" required>
                </div>

                <!-- Appointment Time -->
                <div class="col-md-4 mb-3">
                    <label for="time" class="form-label">Time</label>
                    <input type="time" name="time" id="time" class="form-control" required>
                </div>
            </div>

            <!-- Reason for Visit -->
            <div class="mb-3">
                <label for="reason" class="form-label">Reason for Visit</label>
                <textarea name="reason" id="reason" class="form-control" rows="3" placeholder="Briefly describe your symptoms or reason for appointment"></textarea>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary mt-2">
                <i class="fas fa-calendar-check me-2"></i> Book Appointment
            </button>
        </form>
    </div>
</div>