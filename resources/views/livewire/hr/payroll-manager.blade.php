<div>
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">Payroll Management</h2>
            <p class="text-muted mb-0">Manage payroll periods, run calculations, and generate payslips</p>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-outline-primary" wire:click="loadAnalytics">
                <i class="fas fa-chart-bar me-2"></i>Analytics
            </button>
            <button class="btn btn-primary" wire:click="$toggle('showCreateModal')">
                <i class="fas fa-plus me-2"></i>New Period
            </button>
        </div>
    </div>

    <!-- Analytics Dashboard (shown when analytics is loaded) -->
    @if($showAnalytics)
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <h6 class="card-title">Total Payroll Cost</h6>
                        <h3 class="mb-0">{{ number_format($analytics['total_cost'] ?? 0, 0) }} RWF</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <h6 class="card-title">Active Employees</h6>
                        <h3 class="mb-0">{{ $analytics['active_employees'] ?? 0 }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-warning text-white">
                    <div class="card-body">
                        <h6 class="card-title">Overtime Cost</h6>
                        <h3 class="mb-0">{{ number_format($analytics['overtime_cost'] ?? 0, 0) }} RWF</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-info text-white">
                    <div class="card-body">
                        <h6 class="card-title">Avg. Net Pay</h6>
                        <h3 class="mb-0">{{ number_format($analytics['avg_net_pay'] ?? 0, 0) }} RWF</h3>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Payroll Periods Table -->
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">Payroll Periods</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Period Name</th>
                            <th>Date Range</th>
                            <th>Status</th>
                            <th>Employees</th>
                            <th>Total Gross</th>
                            <th>Total Net</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($periods as $period)
                            <tr>
                                <td><strong>{{ $period->name }}</strong></td>
                                <td>{{ \Carbon\Carbon::parse($period->start_date)->format('M d, Y') }} - {{ \Carbon\Carbon::parse($period->end_date)->format('M d, Y') }}</td>
                                <td>
                                    <span class="badge bg-{{ $period->status === 'locked' ? 'secondary' : ($period->status === 'approved' ? 'success' : ($period->status === 'processing' ? 'warning' : 'primary')) }}">
                                        {{ ucfirst($period->status) }}
                                    </span>
                                </td>
                                <td>{{ $period->payrollEntries()->count() }}</td>
                                <td>{{ number_format($period->total_gross_pay, 0) }} RWF</td>
                                <td>{{ number_format($period->total_net_pay, 0) }} RWF</td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <button class="btn btn-outline-primary" wire:click="selectPeriod('{{ $period->id }}')">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        
                                        @if($period->status === 'draft')
                                            <button class="btn btn-outline-success" wire:click="$toggle('showRunPayrollModal')" wire:click="$set('runPeriodId', '{{ $period->id }}')">
                                                <i class="fas fa-play"></i>
                                            </button>
                                            <button class="btn btn-outline-warning" wire:click="approvePayroll('{{ $period->id }}')">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        @endif
                                        
                                        @if($period->status === 'approved')
                                            <button class="btn btn-outline-secondary" wire:click="lockPayroll('{{ $period->id }}')">
                                                <i class="fas fa-lock"></i>
                                            </button>
                                        @endif
                                        
                                        @if($period->status !== 'locked')
                                            <button class="btn btn-outline-danger" wire:click="deletePayroll('{{ $period->id }}')" onclick="return confirm('Are you sure?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <div class="text-muted">
                                        <i class="fas fa-calendar-alt fa-3x mb-3"></i>
                                        <p>No payroll periods found. Create your first payroll period to get started.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            {{ $periods->links() }}
        </div>
    </div>

    <!-- Payroll Entries for Selected Period -->
    @if($selectedPeriod)
        <div class="card mt-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Payroll Entries</h5>
                <div class="btn-group btn-group-sm">
                    <button class="btn btn-outline-primary" wire:click="generateBankFile('{{ $selectedPeriod }}')">
                        <i class="fas fa-file-export me-2"></i>Bank File
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Employee</th>
                                <th>Department</th>
                                <th>Basic Salary</th>
                                <th>Gross Pay</th>
                                <th>Deductions</th>
                                <th>Net Pay</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentEntries as $entry)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm bg-primary rounded-circle me-2 d-flex align-items-center justify-content-center text-white">
                                                {{ substr($entry->employee_name, 0, 1) }}
                                            </div>
                                            <div>
                                                <div class="fw-medium">{{ $entry->employee_name }}</div>
                                                <small class="text-muted">{{ $entry->employee_code }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $entry->employee_department ?? '—' }}</td>
                                    <td>{{ number_format($entry->basic_salary, 0) }} RWF</td>
                                    <td>{{ number_format($entry->gross_pay, 0) }} RWF</td>
                                    <td>{{ number_format($entry->total_deductions, 0) }} RWF</td>
                                    <td class="fw-bold text-success">{{ number_format($entry->net_pay, 0) }} RWF</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary" wire:click="generatePayslip('{{ $entry->id }}')">
                                            <i class="fas fa-file-pdf"></i> Payslip
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4">
                                        <div class="text-muted">
                                            <i class="fas fa-users fa-3x mb-3"></i>
                                            <p>No payroll entries found for this period.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                {{ $recentEntries->links() }}
            </div>
        </div>
    @endif

    <!-- Create Payroll Period Modal -->
    @if($showCreateModal)
        <div class="modal fade show d-block" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Create Payroll Period</h5>
                        <button type="button" class="btn-close" wire:click="$toggle('showCreateModal')"></button>
                    </div>
                    <form wire:submit="createPayrollPeriod">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Period Name</label>
                                <input type="text" class="form-control" wire:model="periodName" placeholder="e.g., April 2026" required>
                                @error('periodName') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Start Date</label>
                                <input type="date" class="form-control" wire:model="startDate" required>
                                @error('startDate') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">End Date</label>
                                <input type="date" class="form-control" wire:model="endDate" required>
                                @error('endDate') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" wire:click="$toggle('showCreateModal')">Cancel</button>
                            <button type="submit" class="btn btn-primary">Create Period</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <!-- Run Payroll Modal -->
    @if($showRunPayrollModal)
        <div class="modal fade show d-block" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Run Payroll</h5>
                        <button type="button" class="btn-close" wire:click="$toggle('showRunPayrollModal')"></button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to run payroll for this period? This will:</p>
                        <ul>
                            <li>Calculate attendance data for all active employees</li>
                            <li>Compute earnings (basic salary, allowances, overtime)</li>
                            <li>Calculate deductions (tax, RSSB, CBHI, etc.)</li>
                            <li>Generate payroll entries for review</li>
                        </ul>
                        <p class="text-warning"><strong>Note:</strong> This process may take a few minutes depending on the number of employees.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="$toggle('showRunPayrollModal')">Cancel</button>
                        <button type="button" class="btn btn-success" wire:click="runPayroll('{{ $runPeriodId ?? '' }}')">
                            <i class="fas fa-play me-2"></i>Run Payroll
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
