

  <!-- Main Content Section -->
  <main class="main-content">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
              <h4 class="mb-0">Appointment Management</h4>
              <div class="d-flex">
                <div class="input-group me-2" style="max-width: 300px;">
                  <input type="text" class="form-control" placeholder="Search appointments...">
                  <button class="btn btn-outline-secondary" type="button">
                    <i class="fas fa-search"></i>
                  </button>
                </div>
                <!-- <button class="btn btn-primary">
                  <i class="fas fa-plus me-1"></i> New Appointment
                </button> -->
              </div>
            </div>

            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th>Patient Name</th>
                      <th>Contact</th>
                      <th>Vist Reason</th>
                      <th>Vist Time</th>
                      <th>Status</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if (!empty($appointments)): ?>
                      <?php foreach ($appointments as $row): ?>
                        <tr>
                          <td><?= htmlspecialchars($row->patient_name) ?></td>
                          <td><?= htmlspecialchars($row->phone) ?></td>
                          <td><?= htmlspecialchars($row->reason) ?></td>
                          <td><?= htmlspecialchars($row->time) ?><?= htmlspecialchars($row->date) ?></td>
                          
                          <td>
                            <?php
                              switch($row->status) {
                                case '1': $statusClass = 'status-confirmed'; $statusText = 'Confirmed'; break;
                                case '2': $statusClass = 'status-cancelled'; $statusText = 'Cancelled'; break;
                                case '3': $statusClass = 'status-rescheduled'; $statusText = 'Rescheduled'; break;
                                default:  $statusClass = 'status-pending'; $statusText = 'Pending'; break;
                              }
                            ?>
                            <span class="status-badge <?= $statusClass ?>"><?= $statusText ?></span>
                          </td>
                          <td>
                            <form method="post" action="<?= base_url('doctor_controller/updateStatus') ?>" class="d-flex">
                              <input type="hidden" name="appointment_id" value="<?= $row->id ?>">
                              <select name="status" class="form-select me-2" style="width: auto;">
                                <option value="0" <?= $row->status == '0' ? 'selected' : '' ?>>Pending</option>
                                <option value="1" <?= $row->status == '1' ? 'selected' : '' ?>>Confirmed</option>
                                <option value="2" <?= $row->status == '2' ? 'selected' : '' ?>>Cancelled</option>
                                <option value="3" <?= $row->status == '3' ? 'selected' : '' ?>>Rescheduled</option>
                              </select>
                              <button type="submit" class="btn btn-primary btn-sm">
                                <i class="fas fa-sync-alt me-1"></i> Update
                              </button>
                            </form>
                          </td>
                        </tr>
                      <?php endforeach; ?>
                    <?php else: ?>
                      <tr><td colspan="6" class="text-center text-muted">No appointments found.</td></tr>
                    <?php endif; ?>
                  </tbody>
                </table>
              </div>

              <!-- Pagination -->
              <nav aria-label="Appointment pagination" class="mt-4">
                <ul class="pagination justify-content-center">
                  <li class="page-item disabled"><a class="page-link" href="#">Previous</a></li>
                  <li class="page-item active"><a class="page-link" href="#">1</a></li>
                  <li class="page-item"><a class="page-link" href="#">2</a></li>
                  <li class="page-item"><a class="page-link" href="#">3</a></li>
                  <li class="page-item"><a class="page-link" href="#">Next</a></li>
                </ul>
              </nav>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>


