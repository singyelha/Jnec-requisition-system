{{-- resources/views/hod/dashboard.blade.php --}}

@extends('layouts.app') {{-- Use your existing Bootstrap layout --}}

@section('content')
    {{-- FontAwesome CSS (Better placed in layouts/app.blade.php <head>) --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    {{-- Main Dashboard Container - Styles for this are now in app.scss --}}
    <div class="dashboard-hod-container">

        {{-- Sidebar Navigation - Styles for this are now in app.scss --}}
        <nav class="sidebar-hod">
             <h2>HOD Dashboard</h2>
             <ul>
                 <li><a href="#" data-target="hod-requisitions" class="sidebar-nav-link active"><i class="fas fa-fw fa-file-alt"></i> Requisition Forms</a></li>
                 <li><a href="#" data-target="hod-status" class="sidebar-nav-link"><i class="fas fa-fw fa-clipboard-list"></i> Form Status</a></li>
             </ul>
             {{-- Logout is handled by layouts/app.blade.php navbar --}}
         </nav>

        {{-- Main Content Area - Styles for this are now in app.scss --}}
        <main class="content-area-hod">

             {{-- Content Area Header - Styles for this are now in app.scss --}}
             <header class="content-header-hod">
                 <div class="header-title">HOD Portal</div>
                 <div class="user-info">
                     Welcome, {{ Auth::user()->name ?? 'HOD' }}
                 </div>
             </header>

             {{-- Display Session Feedback & Validation Errors --}}
             @if (session('success')) <div class="alert alert-success mb-4">{{ session('success') }}</div> @endif
             @if (session('error')) <div class="alert alert-danger mb-4">{{ session('error') }}</div> @endif
             @if ($errors->any())
                 <div class="alert alert-danger mb-4">
                     <strong class="block font-medium">Errors found:</strong>
                     <ul class="mt-2 list-disc list-inside">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                 </div>
             @endif

            {{-- Section 1: Requisition Forms (Initially Active) --}}
            <div id="hod-requisitions" class="content-section-hod active">
                <h2 class="section-title">Requisition Forms</h2>

                {{-- Filter Controls - Styles for this are now in app.scss --}}
                <div class="filter-controls-hod">
                    <label for="departmentFilterHod">Filter by Department:</label>
                    <select id="departmentFilterHod" class="form-select form-select-sm"> {{-- Added Bootstrap class --}}
                        <option value="all">All Departments</option>
                        <option value="DIT">Department of Information Technology</option>
                        <option value="DCES">Department of Civil & Surveying Engineering</option>
                        <option value="DEE">Department of Electrical & Electronics Engineering</option>
                        <option value="DHM">Department of Humanities & Management</option>
                        <option value="DME">Department of Mechanical Engineering</option>
                        <option value="Administration">Administration</option>
                        <option value="Exam Cell">Examination Cell</option>
                        <option value="Games and Sports">Games and Sports</option>
                        <option value="Library">Central Library</option>
                        <option value="Maintenance">Estate & Maintenance</option>
                        <option value="Accounts">Accounts</option>
                        <option value="Student Services">Student Affairs</option>
                    </select>
                </div>

                {{-- Requisition List - Styles for this are now in app.scss --}}
                <div class="requisition-list-hod" id="requisitionListHod">
                    <p>Loading requisitions...</p>
                </div>
            </div>

            {{-- Section 2: Form Status --}}
            <div id="hod-status" class="content-section-hod">
                <h2 class="section-title">Form Status Overview</h2>
                 {{-- Status Summary - Styles for this are now in app.scss --}}
                 <div class="status-summary-hod">
                    <h4>Summary (All Departments)</h4>
                    <ul id="status-summary-list-hod"><li>Loading...</li></ul>
                 </div>
                 {{-- TODO: Add more detailed status view --}}
            </div>

        </main> {{-- End Content Area --}}

    </div> {{-- End Dashboard Container --}}

    {{-- Modal (Positioning works better outside flex container) - Styles for this are now in app.scss --}}
    <div id="editModalHod" class="modal-hod">
        <div class="modal-content">
            <span class="close-btn" title="Close" onclick="closeModalHod()">×</span>
            <h2>Requisition Details</h2>
            <div id="modalBodyHod"><p>Loading...</p></div>
        </div>
    </div>

@endsection {{-- End Content Section --}}

{{-- Push JavaScript to the 'scripts' stack if your layout uses @stack('scripts') --}}
{{-- Otherwise, place the <script> tags directly before @endsection --}}
@push('scripts')
    {{-- JavaScript for Tab Switching --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const hodNavLinks = document.querySelectorAll('.sidebar-hod .sidebar-nav-link');
            const hodSections = document.querySelectorAll('.content-area-hod .content-section-hod');

            function activateHodSection(targetId) { /* ... Tab switching logic ... */
                 if(!targetId) return; // Safety check
                 hodSections.forEach(section => { section.classList.toggle('active', section.id === targetId); });
             }
            function activateHodLink(clickedLink) { /* ... Tab switching logic ... */
                 hodNavLinks.forEach(link => link.classList.remove('active'));
                 if (clickedLink) clickedLink.classList.add('active');
             }

            hodNavLinks.forEach(link => { /* ... Tab switching logic ... */
                 if(link.getAttribute('data-section') !== 'logout') { link.addEventListener('click', function(e) { e.preventDefault(); const targetId = this.getAttribute('data-target'); if (targetId && document.getElementById(targetId)) { activateHodLink(this); activateHodSection(targetId); } else { console.warn(`Target section '#${targetId}' not found.`); } }); }
             });
            // Activate initial section
            const initialActiveHodLink = document.querySelector('.sidebar-hod .sidebar-nav-link.active'); let initialTargetId = initialActiveHodLink?.getAttribute('data-target'); if (!initialTargetId || !document.getElementById(initialTargetId)) { initialTargetId = hodNavLinks.length > 0 ? hodNavLinks[0].getAttribute('data-target') : null; if (initialTargetId && document.getElementById(initialTargetId)){ activateHodLink(hodNavLinks[0]); } else if (hodSections.length > 0) { initialTargetId = hodSections[0].id; } else { initialTargetId = null; } } if(initialTargetId && document.getElementById(initialTargetId)){ activateHodSection(initialTargetId); const linkForInitial = document.querySelector(`.sidebar-hod .sidebar-nav-link[data-target="${initialTargetId}"]`); activateHodLink(linkForInitial || initialActiveHodLink || (hodNavLinks.length > 0 ? hodNavLinks[0] : null) ); }
        });
    </script>

    {{-- JavaScript for HOD Dashboard Functionality --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // --- HOD Dashboard Elements ---
            const requisitionListHod = document.getElementById('requisitionListHod');
            const modalHod = document.getElementById('editModalHod');
            const modalBodyHod = document.getElementById('modalBodyHod');
            const statusSummaryListHod = document.getElementById('status-summary-list-hod');
            const departmentFilterSelectHod = document.getElementById('departmentFilterHod');
            let currentViewingReqId = null; // Keep track of which req is in the modal

             // Check if elements exist before proceeding
             if (!requisitionListHod || !modalHod || !modalBodyHod || !statusSummaryListHod || !departmentFilterSelectHod) {
                 console.warn("HOD Dashboard essential elements not found. JS functionality may be limited.");
                 // return; // Optional: Stop execution if elements are critical
             }

            // --- !!! REPLACE WITH ACTUAL BACKEND DATA FETCHING (e.g., fetch API call) !!! ---
            let hodRequisitionsData = {
                 '101': { id: 101, title: 'Request for New Laptops', item_code: 'LP-MK-01', quantity: 5, reason: 'New hires need laptops.', required_date: '2024-08-15', status: 'Pending', submitted_by: 'Alice Smith', submitted_on: '2024-07-25 10:00:00', details: '5 Laptops (Model XYZ)', department: 'DEE', items: [{name: 'Laptop XYZ', desc: '16GB RAM, 512GB SSD', qty: 5, remarks: 'For new staff'}] }, // Added example items array
                 '102': { id: 102, title: 'Office Supply Replenishment Q3', item_code: 'SUP-Q3-24', quantity: 1, reason: 'Quarterly stock up.', required_date: '2024-08-01', status: 'Approved', submitted_by: 'Bob Johnson', submitted_on: '2024-07-24 15:30:00', details: 'Standard supplies.', department: 'Administration', items: [{name: 'Pens, Paper, etc.', desc: 'Standard office items', qty: 1, remarks: 'Replenish stock'}] },
                 '103': { id: 103, title: 'Software License Renewal - Project X', item_code: 'LIC-PROJX-24', quantity: 10, reason: 'Renew annual licenses.', required_date: '2024-09-01', status: 'Rejected', submitted_by: 'Charlie Brown', submitted_on: '2024-07-23 09:15:00', details: 'Budget constraints.', department: 'DIT', items: [{name: 'Software X License', desc: 'Annual Renewal', qty: 10, remarks: 'Project X requirement'}] },
            };
            // --- END DATA SIMULATION ---


            // --- Utilities ---
            function escapeHtmlHod(unsafe) { /* ... as before ... */ return unsafe ? unsafe.toString().replace(/&/g, "&").replace(/</g, "<").replace(/>/g, ">").replace(/"/g, "").replace(/'/g, "'") : ''; }
            function formatDateTimeHod(dateTimeString) { /* ... as before ... */ if (!dateTimeString) return 'N/A'; try { const d=new Date(dateTimeString); if(isNaN(d.getTime())) return dateTimeString; return d.toLocaleDateString('en-US', {year:'numeric',month:'short',day:'numeric',hour:'numeric',minute:'2-digit',hour12:true}); } catch(e) { return dateTimeString; } }

            // --- Card Rendering ---
            function renderHodCards() { /* ... logic to loop hodRequisitionsData, filter, create/append cards ... */
                if (!requisitionListHod) return; requisitionListHod.innerHTML = ''; const selectedDepartment = departmentFilterSelectHod?.value || 'all'; let visibleCount = 0;
                for (const id in hodRequisitionsData) { const req = hodRequisitionsData[id]; if (selectedDepartment === 'all' || req.department === selectedDepartment) { const card = createHodCardElement(req); requisitionListHod.appendChild(card); updateHodCardUI(id); visibleCount++; } }
                if (visibleCount === 0) { requisitionListHod.innerHTML = '<p style="grid-column: 1 / -1; text-align: center; color: #6c757d;">No requisitions found matching the filter.</p>'; }
             }
            function createHodCardElement(req) { /* ... logic to create card HTML string ... */
                 const article = document.createElement('article'); article.className = 'requisition-card-hod'; article.id = `hod-req-${req.id}`;
                 const statusClass = req.status ? req.status.toLowerCase().replace(/\s+/g, '-') : 'pending'; const deptOption = departmentFilterSelectHod?.querySelector(`option[value="${escapeHtmlHod(req.department)}"]`); const displayDeptName = deptOption ? deptOption.textContent : (req.department || 'N/A');
                 let detailLine = ''; if (req.status === 'Rejected') { detailLine = `<p><strong>Reason Rejected:</strong> ${escapeHtmlHod(req.details)}</p>`; } else { detailLine = `<p><strong>Reason:</strong> ${escapeHtmlHod(req.reason || req.details || '(None)')}</p>`;} // Show reason by default
                 article.innerHTML = `<div class="card-header"><h3>${escapeHtmlHod(req.title)}</h3><span class="status-badge ${statusClass}">${escapeHtmlHod(req.status)}</span></div><div class="card-body"><p><strong>Submitted By:</strong> ${escapeHtmlHod(req.submitted_by)}</p><p><strong>Submitted On:</strong> ${formatDateTimeHod(req.submitted_on)}</p>${detailLine}<p class="department-info">Dept: ${escapeHtmlHod(displayDeptName)}</p></div><div class="card-footer"><button class="action-btn-hod approve" data-req-id="${req.id}" title="Approve">Approve</button><button class="action-btn-hod reject" data-req-id="${req.id}" title="Reject">Reject</button><button class="action-btn-hod view-edit" data-req-id="${req.id}" title="View Details">View/Edit</button></div>`; return article;
             }
             function updateHodCardUI(reqId) { /* ... logic to disable buttons on cards ... */
                 const reqData = hodRequisitionsData[reqId]; const cardElement = document.getElementById(`hod-req-${reqId}`); if (!reqData || !cardElement) return;
                 const approveBtn = cardElement.querySelector('.approve'); const rejectBtn = cardElement.querySelector('.reject'); const isFinalStatus = reqData.status === 'Approved' || reqData.status === 'Rejected'; if (approveBtn) approveBtn.disabled = isFinalStatus; if (rejectBtn) rejectBtn.disabled = isFinalStatus;
                 // Update status badge text/class potentially
                 const statusBadge = cardElement.querySelector('.status-badge'); if (statusBadge) { const statusClass = reqData.status.toLowerCase().replace(/\s+/g, '-'); statusBadge.className = `status-badge ${statusClass}`; statusBadge.textContent = reqData.status; }
                 // Update details line if rejected
                 const detailP = cardElement.querySelector('.card-body p:nth-child(3)'); // Assuming 3rd p is details/reason
                 if(detailP) { if (reqData.status === 'Rejected') { detailP.innerHTML = `<strong>Reason Rejected:</strong> ${escapeHtmlHod(reqData.details)}`; } else { detailP.innerHTML = `<strong>Reason:</strong> ${escapeHtmlHod(reqData.reason || reqData.details || '(None)')}`; } }
             }

            // --- Action Handlers (Simulated - Needs AJAX) ---
            function handleHodApprove(reqId) { /* ... Simulated approve logic ... */
                 console.log("APPROVE:", reqId); if (!hodRequisitionsData[reqId] || hodRequisitionsData[reqId].status === 'Approved' || hodRequisitionsData[reqId].status === 'Rejected') return;
                 // --- TODO: AJAX POST to backend ---
                 alert(`Simulating APPROVE for ID: ${reqId}. Needs AJAX call.`);
                 hodRequisitionsData[reqId].status = 'Approved'; hodRequisitionsData[reqId].details = ''; // Clear details on approve
                 updateHodCardUI(reqId); updateHodStatusSummary();
             }
            function handleHodReject(reqId) { /* ... Simulated reject logic ... */
                 console.log("REJECT:", reqId); if (!hodRequisitionsData[reqId] || hodRequisitionsData[reqId].status === 'Approved' || hodRequisitionsData[reqId].status === 'Rejected') return;
                 const reason = prompt(`Enter reason for rejecting Requisition ${reqId}:`, ''); if (reason === null) return;
                 // --- TODO: AJAX POST to backend ---
                 alert(`Simulating REJECT for ID: ${reqId} with reason: ${reason}. Needs AJAX call.`);
                 hodRequisitionsData[reqId].status = 'Rejected'; hodRequisitionsData[reqId].details = reason;
                 updateHodCardUI(reqId); updateHodStatusSummary();
            }
            function handleHodViewEdit(reqId) { /* ... Opens modal ... */
                 console.log("VIEW/EDIT:", reqId); currentViewingReqId = reqId; openHodModal(reqId);
             }

            // --- Modal Logic ---
            function openHodModal(reqId) { /* ... Populates modal with details ... */
                 if (!modalHod || !modalBodyHod || !hodRequisitionsData[reqId]) return; const req = hodRequisitionsData[reqId];
                 // Basic details
                 let modalHTML = `<div style="font-size: 0.95rem;"><p><strong>Title:</strong> ${escapeHtmlHod(req.title)}</p><p><strong>Submitted By:</strong> ${escapeHtmlHod(req.submitted_by)}</p><p><strong>Submitted On:</strong> ${formatDateTimeHod(req.submitted_on)}</p><p><strong>Department:</strong> ${departmentFilterSelectHod?.querySelector(`option[value="${escapeHtmlHod(req.department)}"]`)?.textContent || req.department}</p><p><strong>Quantity (Overall):</strong> ${escapeHtmlHod(req.quantity)}</p><p><strong>Item Code:</strong> ${escapeHtmlHod(req.item_code || 'N/A')}</p><hr style="margin: 15px 0;"><p><strong>${req.status === 'Rejected' ? 'Rejection Reason' : 'Overall Reason/Details'}:</strong></p><p style="white-space: pre-wrap; background-color: #f9f9f9; padding: 8px; border-radius: 4px;">${escapeHtmlHod(req.details || req.reason || '(None provided)')}</p><hr style="margin: 15px 0;">`;
                 // Add Item Breakdown if exists in data
                 if (req.items && Array.isArray(req.items) && req.items.length > 0) { modalHTML += `<h5>Item Breakdown:</h5><table class="table table-sm table-bordered" style="font-size: 0.9em;"><thead><tr><th>#</th><th>Name</th><th>Desc.</th><th>Qty</th><th>Remarks</th></tr></thead><tbody>`; req.items.forEach((item, index) => { modalHTML += `<tr><td>${index + 1}</td><td>${escapeHtmlHod(item.name)}</td><td>${escapeHtmlHod(item.desc)}</td><td>${escapeHtmlHod(item.qty)}</td><td>${escapeHtmlHod(item.remarks)}</td></tr>`; }); modalHTML += `</tbody></table><hr style="margin: 15px 0;">`; }
                 modalHTML += `<p><strong>Current Status:</strong> <span class="status-badge ${req.status.toLowerCase().replace(/\s+/g, '-')}">${req.status}</span></p></div>`;
                 modalBodyHod.innerHTML = modalHTML; modalHod.style.display = 'block';
            }
            // Make closeModalHod global for inline onclick
            window.closeModalHod = function() { /* ... Closes modal ... */ if (modalHod) modalHod.style.display = 'none'; currentViewingReqId = null; if(modalBodyHod) modalBodyHod.innerHTML = '<p>Loading...</p>'; }
             // Close modal events
             window.addEventListener('click', (event) => { if (event.target == modalHod) closeModalHod(); }); window.addEventListener('keydown', (event) => { if (event.key === 'Escape' && modalHod?.style.display === 'block') closeModalHod(); });

            // --- Update Status Summary ---
            function updateHodStatusSummary() { /* ... Counts statuses ... */
                 if (!statusSummaryListHod) return; const counts = { Pending: 0, Approved: 0, Rejected: 0, 'Needs Edit': 0 }; for (const id in hodRequisitionsData) { const status = hodRequisitionsData[id]?.status; if (counts.hasOwnProperty(status)) counts[status]++; } statusSummaryListHod.innerHTML = `<li>Pending: <span class="badge bg-warning text-dark">${counts.Pending}</span></li><li>Approved: <span class="badge bg-success">${counts.Approved}</span></li><li>Needs Edit: <span class="badge bg-info">${counts['Needs Edit']}</span></li><li>Rejected: <span class="badge bg-danger">${counts.Rejected}</span></li>`; // Using Bootstrap badges
             }

            // --- Event Listeners ---
            if (departmentFilterSelectHod) { departmentFilterSelectHod.addEventListener('change', renderHodCards); }
            if (requisitionListHod) { requisitionListHod.addEventListener('click', (event) => { /* ... Delegates clicks on action buttons ... */ const button = event.target.closest('.action-btn-hod'); if (!button || button.disabled) return; const reqId = button.dataset.reqId; if (!reqId) return; if (button.classList.contains('approve')) handleHodApprove(reqId); else if (button.classList.contains('reject')) handleHodReject(reqId); else if (button.classList.contains('view-edit')) handleHodViewEdit(reqId); }); }

            // --- Initial Load ---
            renderHodCards();
            updateHodStatusSummary();

        }); // End DOMContentLoaded
    </script>
@endpush