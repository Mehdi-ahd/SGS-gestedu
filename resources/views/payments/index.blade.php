@extends('layouts.app')

@section('title', 'Fee Management')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h1>Fee Management</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Fee Management</li>
            </ol>
        </nav>
    </div>
    <div>
        <button class="btn btn-outline-primary me-2" id="printPayments">
            <i class="fas fa-print me-1"></i> Print
        </button>
        <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPaymentModal">
            <i class="fas fa-plus me-1"></i> Record Payment
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-12 mb-4">
        <div class="card">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-3 mb-3 mb-md-0">
                        <label for="classFilter" class="form-label">Class</label>
                        <select class="form-select" id="classFilter">
                            <option value="all">All Classes</option>
                            <option value="1">10th Grade - Section A</option>
                            <option value="2">10th Grade - Section B</option>
                            <option value="3">11th Grade - Section A</option>
                            <option value="4">11th Grade - Section B</option>
                            <option value="5">12th Grade - Section A</option>
                            <option value="6">12th Grade - Section B</option>
                        </select>
                    </div>
                    <div class="col-md-3 mb-3 mb-md-0">
                        <label for="statusFilter" class="form-label">Payment Status</label>
                        <select class="form-select" id="statusFilter">
                            <option value="all">All Status</option>
                            <option value="paid">Paid</option>
                            <option value="partial">Partially Paid</option>
                            <option value="pending">Pending</option>
                            <option value="overdue">Overdue</option>
                        </select>
                    </div>
                    <div class="col-md-3 mb-3 mb-md-0">
                        <label for="dateFrom" class="form-label">Date From</label>
                        <input type="date" class="form-control" id="dateFrom">
                    </div>
                    <div class="col-md-3">
                        <label for="dateTo" class="form-label">Date To</label>
                        <input type="date" class="form-control" id="dateTo">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 offset-md-8">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search by student name, ID..." id="searchPayment">
                            <button class="btn btn-outline-secondary" type="button">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Payment Records</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-striped">
                        <thead>
                            <tr>
                                <th>Invoice #</th>
                                <th>Student</th>
                                <th>Fee Type</th>
                                <th>Amount</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>INV-2025-001</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar me-2">
                                            <span>JD</span>
                                        </div>
                                        <div>
                                            John Doe<br>
                                            <small class="text-muted">10th Grade - A</small>
                                        </div>
                                    </div>
                                </td>
                                <td>Tuition Fee</td>
                                <td>$1,250.00</td>
                                <td>May 15, 2025</td>
                                <td><span class="badge bg-success">Paid</span></td>
                                <td>
                                    <div class="d-flex">
                                        <a href="#" class="btn btn-sm btn-outline-primary me-1" data-bs-toggle="tooltip" title="View" onclick="viewPayment(1)">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="#" class="btn btn-sm btn-outline-success me-1" data-bs-toggle="tooltip" title="Receipt" onclick="printReceipt(1)">
                                            <i class="fas fa-file-invoice"></i>
                                        </a>
                                        <a href="#" class="btn btn-sm btn-outline-danger" data-bs-toggle="tooltip" title="Delete" onclick="deletePayment(1)">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>INV-2025-002</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar me-2">
                                            <span>JS</span>
                                        </div>
                                        <div>
                                            Jane Smith<br>
                                            <small class="text-muted">10th Grade - B</small>
                                        </div>
                                    </div>
                                </td>
                                <td>Tuition Fee</td>
                                <td>$1,250.00</td>
                                <td>May 14, 2025</td>
                                <td><span class="badge bg-success">Paid</span></td>
                                <td>
                                    <div class="d-flex">
                                        <a href="#" class="btn btn-sm btn-outline-primary me-1" data-bs-toggle="tooltip" title="View" onclick="viewPayment(2)">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="#" class="btn btn-sm btn-outline-success me-1" data-bs-toggle="tooltip" title="Receipt" onclick="printReceipt(2)">
                                            <i class="fas fa-file-invoice"></i>
                                        </a>
                                        <a href="#" class="btn btn-sm btn-outline-danger" data-bs-toggle="tooltip" title="Delete" onclick="deletePayment(2)">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>INV-2025-003</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar me-2">
                                            <span>MB</span>
                                        </div>
                                        <div>
                                            Michael Brown<br>
                                            <small class="text-muted">11th Grade - A</small>
                                        </div>
                                    </div>
                                </td>
                                <td>Tuition Fee</td>
                                <td>$1,100.00</td>
                                <td>May 12, 2025</td>
                                <td><span class="badge bg-warning">Partial</span></td>
                                <td>
                                    <div class="d-flex">
                                        <a href="#" class="btn btn-sm btn-outline-primary me-1" data-bs-toggle="tooltip" title="View" onclick="viewPayment(3)">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="#" class="btn btn-sm btn-outline-success me-1" data-bs-toggle="tooltip" title="Receipt" onclick="printReceipt(3)">
                                            <i class="fas fa-file-invoice"></i>
                                        </a>
                                        <a href="#" class="btn btn-sm btn-outline-danger" data-bs-toggle="tooltip" title="Delete" onclick="deletePayment(3)">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>INV-2025-004</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar me-2">
                                            <span>EJ</span>
                                        </div>
                                        <div>
                                            Emily Johnson<br>
                                            <small class="text-muted">11th Grade - B</small>
                                        </div>
                                    </div>
                                </td>
                                <td>Tuition Fee</td>
                                <td>$1,350.00</td>
                                <td>May 10, 2025</td>
                                <td><span class="badge bg-success">Paid</span></td>
                                <td>
                                    <div class="d-flex">
                                        <a href="#" class="btn btn-sm btn-outline-primary me-1" data-bs-toggle="tooltip" title="View" onclick="viewPayment(4)">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="#" class="btn btn-sm btn-outline-success me-1" data-bs-toggle="tooltip" title="Receipt" onclick="printReceipt(4)">
                                            <i class="fas fa-file-invoice"></i>
                                        </a>
                                        <a href="#" class="btn btn-sm btn-outline-danger" data-bs-toggle="tooltip" title="Delete" onclick="deletePayment(4)">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>INV-2025-005</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar me-2">
                                            <span>RW</span>
                                        </div>
                                        <div>
                                            Robert Wilson<br>
                                            <small class="text-muted">12th Grade - A</small>
                                        </div>
                                    </div>
                                </td>
                                <td>Tuition Fee</td>
                                <td>$1,250.00</td>
                                <td>Apr 30, 2025</td>
                                <td><span class="badge bg-danger">Overdue</span></td>
                                <td>
                                    <div class="d-flex">
                                        <a href="#" class="btn btn-sm btn-outline-primary me-1" data-bs-toggle="tooltip" title="View" onclick="viewPayment(5)">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="#" class="btn btn-sm btn-outline-success me-1" data-bs-toggle="tooltip" title="Receipt" onclick="printReceipt(5)">
                                            <i class="fas fa-file-invoice"></i>
                                        </a>
                                        <a href="#" class="btn btn-sm btn-outline-danger" data-bs-toggle="tooltip" title="Delete" onclick="deletePayment(5)">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div>
                        <p class="text-muted">Showing 1 to 5 of 156 entries</p>
                    </div>
                    <nav aria-label="Page navigation">
                        <ul class="pagination">
                            <li class="page-item disabled">
                                <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
                            </li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item">
                                <a class="page-link" href="#">Next</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Payment Summary</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="card border-0 bg-light">
                            <div class="card-body text-center">
                                <h4 class="mb-0 text-success">$156,750</h4>
                                <p class="text-muted mb-0">Total Collected</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="card border-0 bg-light">
                            <div class="card-body text-center">
                                <h4 class="mb-0 text-danger">$23,500</h4>
                                <p class="text-muted mb-0">Outstanding</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <h6 class="mt-3 mb-2">Fee Collection Rate</h6>
                <div class="progress mb-3" style="height: 20px;">
                    <div class="progress-bar bg-success" role="progressbar" style="width: 85%;" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100">85%</div>
                </div>
                
                <h6 class="mt-4 mb-2">Payment Status</h6>
                <div class="table-responsive">
                    <table class="table table-sm">
                        <tbody>
                            <tr>
                                <td>
                                    <span class="badge bg-success me-1">Paid</span> Fully Paid
                                </td>
                                <td class="text-end">105</td>
                            </tr>
                            <tr>
                                <td>
                                    <span class="badge bg-warning me-1">Partial</span> Partially Paid
                                </td>
                                <td class="text-end">32</td>
                            </tr>
                            <tr>
                                <td>
                                    <span class="badge bg-primary me-1">Pending</span> Pending
                                </td>
                                <td class="text-end">12</td>
                            </tr>
                            <tr>
                                <td>
                                    <span class="badge bg-danger me-1">Overdue</span> Overdue
                                </td>
                                <td class="text-end">7</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Fee Structure</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Class</th>
                                <th>Tuition Fee</th>
                                <th>Other Fees</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>10th Grade</td>
                                <td>$4,500</td>
                                <td>$500</td>
                                <td>$5,000</td>
                            </tr>
                            <tr>
                                <td>11th Grade</td>
                                <td>$4,800</td>
                                <td>$700</td>
                                <td>$5,500</td>
                            </tr>
                            <tr>
                                <td>12th Grade</td>
                                <td>$5,000</td>
                                <td>$1,000</td>
                                <td>$6,000</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <div class="d-grid mt-3">
                    <a href="#" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#feeStructureModal">
                        <i class="fas fa-list-ul me-1"></i> View Full Fee Structure
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Payment Modal -->
<div class="modal fade" id="addPaymentModal" tabindex="-1" aria-labelledby="addPaymentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addPaymentModalLabel">Record Payment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addPaymentForm">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="student_id" class="form-label">Student <span class="text-danger">*</span></label>
                            <select class="form-select" id="student_id" name="student_id" required>
                                <option value="" selected disabled>Select Student</option>
                                <option value="1">John Doe (10th Grade - Section A)</option>
                                <option value="2">Jane Smith (10th Grade - Section B)</option>
                                <option value="3">Michael Brown (11th Grade - Section A)</option>
                                <option value="4">Emily Johnson (11th Grade - Section B)</option>
                                <option value="5">Robert Wilson (12th Grade - Section A)</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="fee_type" class="form-label">Fee Type <span class="text-danger">*</span></label>
                            <select class="form-select" id="fee_type" name="fee_type" required>
                                <option value="" selected disabled>Select Fee Type</option>
                                <option value="tuition">Tuition Fee</option>
                                <option value="exam">Examination Fee</option>
                                <option value="transportation">Transportation Fee</option>
                                <option value="lab">Laboratory Fee</option>
                                <option value="library">Library Fee</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="amount" class="form-label">Amount <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control" id="amount" name="amount" step="0.01" min="0" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="payment_date" class="form-label">Payment Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="payment_date" name="payment_date" value="{{ date('Y-m-d') }}" required>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="payment_method" class="form-label">Payment Method <span class="text-danger">*</span></label>
                            <select class="form-select" id="payment_method" name="payment_method" required>
                                <option value="" selected disabled>Select Payment Method</option>
                                <option value="cash">Cash</option>
                                <option value="check">Check</option>
                                <option value="bank_transfer">Bank Transfer</option>
                                <option value="credit_card">Credit Card</option>
                                <option value="debit_card">Debit Card</option>
                                <option value="online">Online Payment</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="payment_status" class="form-label">Payment Status <span class="text-danger">*</span></label>
                            <select class="form-select" id="payment_status" name="payment_status" required>
                                <option value="paid">Paid</option>
                                <option value="partial">Partially Paid</option>
                                <option value="pending">Pending</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="mb-3" id="transactionIdField" style="display: none;">
                        <label for="transaction_id" class="form-label">Transaction ID/Reference</label>
                        <input type="text" class="form-control" id="transaction_id" name="transaction_id">
                    </div>
                    
                    <div class="mb-3">
                        <label for="description" class="form-label">Description/Note</label>
                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                    </div>
                    
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="send_receipt" name="send_receipt" checked>
                        <label class="form-check-label" for="send_receipt">
                            Send receipt to student/parent
                        </label>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="savePaymentBtn">Save Payment</button>
            </div>
        </div>
    </div>
</div>

<!-- View Payment Detail Modal -->
<div class="modal fade" id="viewPaymentModal" tabindex="-1" aria-labelledby="viewPaymentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewPaymentModalLabel">Payment Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="card border-0">
                    <div class="card-body p-0">
                        <div class="row mb-4">
                            <div class="col-12 text-center mb-4">
                                <h4>Payment Receipt</h4>
                                <div>Invoice #: INV-2025-001</div>
                                <div>Date: May 15, 2025</div>
                            </div>
                            <div class="col-md-6">
                                <h6>Student Information:</h6>
                                <div><strong>Name:</strong> John Doe</div>
                                <div><strong>ID:</strong> STD-001</div>
                                <div><strong>Class:</strong> 10th Grade - Section A</div>
                                <div><strong>Email:</strong> john.doe@example.com</div>
                            </div>
                            <div class="col-md-6 text-md-end">
                                <h6>School Information:</h6>
                                <div><strong>GestEdu School</strong></div>
                                <div>123 Education Street</div>
                                <div>Anytown, State 12345</div>
                                <div>Phone: (123) 456-7890</div>
                            </div>
                        </div>
                        
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Description</th>
                                        <th>Fee Type</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Tuition Fee (Term 1)</td>
                                        <td>Tuition Fee</td>
                                        <td>$1,250.00</td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="2">Total:</th>
                                        <th>$1,250.00</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <h6>Payment Information:</h6>
                                <div><strong>Payment Method:</strong> Credit Card</div>
                                <div><strong>Transaction ID:</strong> TXN123456</div>
                                <div><strong>Paid By:</strong> Michael Smith (Father)</div>
                            </div>
                            <div class="col-md-6">
                                <h6>Additional Information:</h6>
                                <div><strong>Status:</strong> <span class="badge bg-success">Paid</span></div>
                                <div><strong>Notes:</strong> First term payment</div>
                            </div>
                        </div>
                        
                        <div class="mt-4 text-center">
                            <p class="text-muted">Thank you for your payment!</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="printReceipt(1)">
                    <i class="fas fa-print me-1"></i> Print Receipt
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Fee Structure Modal -->
<div class="modal fade" id="feeStructureModal" tabindex="-1" aria-labelledby="feeStructureModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="feeStructureModalLabel">Fee Structure</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th rowspan="2">Class</th>
                                <th colspan="3">Tuition Fee (Per Term)</th>
                                <th colspan="3">Other Fees (Annual)</th>
                                <th rowspan="2">Total Annual</th>
                            </tr>
                            <tr>
                                <th>Term 1</th>
                                <th>Term 2</th>
                                <th>Term 3</th>
                                <th>Registration</th>
                                <th>Lab/Library</th>
                                <th>Exam Fee</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>10th Grade</td>
                                <td>$1,500</td>
                                <td>$1,500</td>
                                <td>$1,500</td>
                                <td>$200</td>
                                <td>$150</td>
                                <td>$150</td>
                                <td>$5,000</td>
                            </tr>
                            <tr>
                                <td>11th Grade</td>
                                <td>$1,600</td>
                                <td>$1,600</td>
                                <td>$1,600</td>
                                <td>$200</td>
                                <td>$250</td>
                                <td>$250</td>
                                <td>$5,500</td>
                            </tr>
                            <tr>
                                <td>12th Grade</td>
                                <td>$1,750</td>
                                <td>$1,750</td>
                                <td>$1,750</td>
                                <td>$200</td>
                                <td>$300</td>
                                <td>$250</td>
                                <td>$6,000</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <div class="mt-4">
                    <h6>Payment Schedule:</h6>
                    <ul>
                        <li>Term 1 Fee: Due by July 15th</li>
                        <li>Term 2 Fee: Due by November 15th</li>
                        <li>Term 3 Fee: Due by March 15th</li>
                    </ul>
                    
                    <h6>Payment Methods:</h6>
                    <ul>
                        <li>Cash payment at school accounting office</li>
                        <li>Check payment (payable to "GestEdu School")</li>
                        <li>Bank transfer</li>
                        <li>Credit/Debit card (2% processing fee applies)</li>
                        <li>Online payment through school portal</li>
                    </ul>
                    
                    <h6>Discounts:</h6>
                    <ul>
                        <li>Full year payment: 5% discount if paid before start of academic year</li>
                        <li>Sibling discount: 10% for second child, 15% for third and subsequent children</li>
                        <li>Merit scholarship: Based on academic performance (contact administration)</li>
                    </ul>
                    
                    <h6>Late Payment:</h6>
                    <ul>
                        <li>1% late fee per month on outstanding balance</li>
                        <li>Students with outstanding fees may not receive report cards or certificates</li>
                    </ul>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">
                    <i class="fas fa-print me-1"></i> Print Fee Structure
                </button>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
    $(document).ready(function() {
        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });
        
        // Show/hide transaction ID field based on payment method
        $('#payment_method').change(function() {
            var method = $(this).val();
            if(method === 'bank_transfer' || method === 'check' || method === 'online' || method === 'credit_card') {
                $('#transactionIdField').show();
            } else {
                $('#transactionIdField').hide();
            }
        });
        
        // Handle save payment
        $('#savePaymentBtn').click(function() {
            // Validate form
            var form = document.getElementById('addPaymentForm');
            if(!form.checkValidity()) {
                form.reportValidity();
                return;
            }
            
            // Here you would normally submit the form via AJAX
            // For demo purposes, we'll just show a success message
            alert('Payment recorded successfully!');
            $('#addPaymentModal').modal('hide');
        });
    });
    
    // Function to view payment details
    function viewPayment(id) {
        // In a real application, you would fetch the payment details via AJAX
        // For this demo, we'll just show the modal
        $('#viewPaymentModal').modal('show');
    }
    
    // Function to print receipt
    function printReceipt(id) {
        // In a real application, you would redirect to a printable receipt page
        // For this demo, we'll just show an alert
        alert('Printing receipt for payment #' + id);
    }
    
    // Function to delete payment
    function deletePayment(id) {
        // In a real application, you would ask for confirmation and then delete via AJAX
        // For this demo, we'll just show an alert
        if(confirm('Are you sure you want to delete this payment record? This action cannot be undone.')) {
            alert('Payment #' + id + ' deleted successfully!');
        }
    }
</script>
@endsection

@section('styles')
<style>
    @media print {
        .modal,
        .btn,
        .form-select,
        .nav-tabs,
        .page-header,
        .card-header,
        .pagination {
            display: none !important;
        }
        
        .card {
            border: none !important;
            box-shadow: none !important;
        }
        
        .table {
            border-collapse: collapse !important;
        }
        
        .table td,
        .table th {
            background-color: #fff !important;
        }
        
        .bg-success, .bg-warning, .bg-danger, .bg-primary {
            background-color: transparent !important;
            color: #000 !important;
            border: 1px solid #ddd !important;
        }
    }
</style>
@endsection
@endsection