<!-- Appointment Booking Card -->
<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-calendar-plus me-2"></i> Book an Appointment
    </div>
    <div class="card-body">
        <form action="<?= site_url('patient_register/submit_details_patient') ?>" method="post">
            <div class="row">
                <!-- Doctor Selection -->
                <div class="col-md-4 mb-3">
                    <label for="doctor_id" class="form-label">Select Doctor</label>
                    <select name="doctor" id="doctor_id" class="form-control" required>
                        <option value="">-- Choose a Doctor --</option>
                        <?php 
                        if(isset($doctors) && is_array($doctors)) {
                            foreach($doctors as $doctor) {
                                echo '<option value="'.$doctor->id.'">';
                                echo htmlspecialchars($doctor->firstname . ' ' . $doctor->specialist);
                                echo '</option>';
                            }
                        } else {
                            echo '<option value="">No doctors available</option>';
                        }
                        ?>
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