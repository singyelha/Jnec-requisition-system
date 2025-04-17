{{-- The main application layout wrapper --}}
<x-app-layout>

    {{-- ====================================================================== --}}
    {{-- == USER DASHBOARD - Requisition Form / Status / Notifications Layout == --}}
    {{-- ====================================================================== --}}

    {{-- FontAwesome CSS (Ideally load globally in layouts/app.blade.php's <head>) --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    {{-- Embedded Styles for the Custom Dashboard Layout --}}
    <style>
        /* === Global Reset & Body Context === */
        .dashboard-container *, .dashboard-container *::before, .dashboard-container *::after {
             box-sizing: border-box;
        }
        .dashboard-container {
            display: flex;
            /* IMPORTANT: Adjust '68px' if your header height is different */
            min-height: calc(100vh - 68px);
            width: 100%;
            max-width: 100%;
        }
        /* === Sidebar === */
        .sidebar {
            width: 250px;
            background-color: #333;
            color: #fff;
            padding: 20px 15px;
            display: flex;
            flex-direction: column;
            flex-shrink: 0;
             /* IMPORTANT: Adjust '68px' if your header height is different */
            height: calc(100vh - 68px);
            position: fixed;
             /* IMPORTANT: Adjust '68px' if your header height is different */
            top: 68px;
            left: 0;
            z-index: 90;
            overflow-y: auto;
        }
        .sidebar h2 { text-align: center; margin-bottom: 30px; color: #eee; font-size: 1.5em; font-weight: bold; padding-bottom: 15px; border-bottom: 1px solid #444; }
        .sidebar ul { list-style: none; flex-grow: 1; padding-left: 0; margin-bottom: 1rem; }
        .sidebar ul li { margin-bottom: 8px; }
        .sidebar ul li a.nav-link { color: #ccc; text-decoration: none; display: flex; align-items: center; padding: 12px 15px; border-radius: 5px; transition: background-color 0.2s ease-in-out, color 0.2s ease-in-out; font-size: 0.95rem; }
        .sidebar ul li a i.fa-fw { margin-right: 12px; width: 20px; text-align: center; font-size: 1.1em; }
        .sidebar ul li a.nav-link:hover { background-color: #444; color: #fff; }
        .sidebar ul li a.nav-link.active { background-color: #007bff; color: #fff; font-weight: 600; }
        /* === Content Area === */
        .content-area {
            flex-grow: 1;
            padding: 30px;
            background-color: #f8f9fa;
            overflow-y: auto;
            margin-left: 250px; /* Should match sidebar width */
            width: calc(100% - 250px); /* Should match sidebar width */
        }
        /* Content Sections (Tabs) */
        .content-section { display: none; background-color: #ffffff; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); margin-bottom: 20px; }
        .content-section.active { display: block; }
        .content-section p { color: #555; font-size: 1rem; margin-bottom: 1rem; }
        /* Feedback message styles */
         .alert-success { background-color: #d4edda; color: #155724; padding: 10px; border: 1px solid #c3e6cb; border-radius: 4px; margin-bottom: 15px; }
         .alert-danger { background-color: #f8d7da; color: #721c24; padding: 10px; border: 1px solid #f5c6cb; border-radius: 4px; margin-bottom: 15px; }
        /* === Responsive Design === */
        @media (max-width: 991.98px) {
             .sidebar { width: 200px; }
             .content-area { width: calc(100% - 200px); margin-left: 200px; padding: 25px; }
         }
        @media (max-width: 767.98px) {
            .dashboard-container { flex-direction: column; min-height: unset; /* Remove min-height constraint */ }
            .sidebar { width: 100%; height: auto; position: relative; top: 0; padding-bottom: 10px; overflow-y: visible; z-index: auto; border-bottom: 1px solid #444; }
            .sidebar ul { display: flex; justify-content: space-around; flex-wrap: wrap; flex-grow: 0; border-bottom: none; padding-bottom: 0; margin-bottom: 0; }
            .sidebar h2 { font-size: 1.3em; margin-bottom: 15px; padding-bottom: 10px; }
            .sidebar ul li { margin: 3px; }
            .sidebar ul li a.nav-link { padding: 8px 12px; }
            .content-area { width: 100%; margin-left: 0; padding: 20px; min-height: auto; }
        }
    </style>

    {{-- Embedded Styles SPECIFICALLY for the Requisition Form --}}
    <style>
        /* General Styles within the #requisition-form section */
        #requisition-form h1, #requisition-form h2, #requisition-form h4 { color: #333; margin-bottom: 0.5em;}
        #requisition-form p { margin-bottom: 1em; }

        /* Form Header Specific */
        #requisition-form .form-header-jnec { text-align: center; margin-bottom: 20px; }
        #requisition-form .form-header-jnec h2 { font-size: 1.4em; margin-bottom: 0.2em; }
        #requisition-form .form-header-jnec p { font-size: 0.9em; margin-bottom: 0.5em; color: #555; }
        #requisition-form .form-header-jnec h1 { font-size: 1.6em; text-transform: uppercase; margin-bottom: 1em; color: #000; font-weight: bold; border-bottom: 2px solid #333; padding-bottom: 5px; display: inline-block; }

        .form-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 20px; }
        .form-grid label, .requester-grid label { display: block; margin-bottom: 5px; font-weight: bold; color: #555; }
        .form-grid input[type="text"], .form-grid input[type="date"], .form-grid select,
        .requester-grid input[type="text"], .requester-grid select {
            width: 100%; padding: 10px; border: 1px solid #ccc;
            border-radius: 4px; box-sizing: border-box; font-size: 1rem; background-color: #fff;
        }
        .requester-grid { grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; }

        /* Table Styles */
        .table-responsive { overflow-x: auto; margin-bottom: 10px;}
        #requisition-items-table { width: 100%; border-collapse: collapse; }
        #requisition-items-table th, #requisition-items-table td { border: 1px solid #ccc; padding: 8px; text-align: left; vertical-align: top;}
        #requisition-items-table th { background-color: #f2f2f2; font-weight: bold; white-space: nowrap; vertical-align: middle; text-align: center;}

        /* --- Styles for Checkbox Column --- */
        #requisition-items-table th.th-checkbox-delete {
            width: 40px; /* Adjust as needed */
            padding: 8px 5px; /* Reduce padding */
        }
        #requisition-items-table td.td-checkbox-delete {
            width: 40px;
            text-align: center;
            vertical-align: middle;
            padding: 6px 5px; /* Align with inputs */
        }
        #requisition-items-table .row-checkbox { /* Style checkbox itself */
             cursor: pointer;
             width: 16px;
             height: 16px;
             margin: 0 auto; /* Center checkbox in the cell */
             display: block; /* Needed for margin auto centering */
        }

        /* Sl. No. header/cell styles */
        #requisition-items-table th.sl-header {
             width: 50px; /* Adjust as needed, likely smaller now */
        }
        #requisition-items-table td.sl-cell { /* Changed class name */
             text-align: center; /* Center the number */
             vertical-align: middle;
             font-weight: bold;
             padding: 6px 5px;
        }

        /* Input/Textarea styles inside table */
        #requisition-items-table td .item-input {
            width: 100%; padding: 6px; border: 1px solid #dcdcdc;
            border-radius: 3px; box-sizing: border-box; font-size: 0.95rem; background-color: #fff;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }
         #requisition-items-table td .item-input:focus {
             border-color: #007bff; box-shadow: 0 0 0 1px rgba(0, 123, 255, 0.25); outline: none;
         }
        #requisition-items-table td textarea.item-input { resize: vertical; min-height: 40px; }

        /* Table Action Buttons Styles */
        .table-actions { display: flex; justify-content: flex-end; align-items: center; margin-bottom: 15px; flex-wrap: wrap; gap: 10px; }
        .action-btn { padding: 8px 15px; cursor: pointer; border-radius: 4px; border: 1px solid; font-size: 0.95em; white-space: nowrap; transition: background-color 0.2s ease, border-color 0.2s ease, opacity 0.2s ease; }
        .add-row-btn { background-color: #28a745; color: white; border-color: #28a745; margin-left: auto; }
        .add-row-btn:hover { background-color: #218838; }
        .delete-mode-btn { background-color: #dc3545; color: white; border-color: #dc3545; }
        .delete-mode-btn:hover { background-color: #c82333; }
        .confirm-delete-btn { background-color: #ffc107; color: #333; border-color: #ffc107; }
        .confirm-delete-btn:hover { background-color: #e0a800; }
        .cancel-delete-btn { background-color: #6c757d; color: white; border-color: #6c757d; }
        .cancel-delete-btn:hover { background-color: #5a6268; }
        .action-btn:disabled { background-color: #cccccc; border-color: #cccccc; color: #666; cursor: not-allowed; opacity: 0.6; }

        /* Other Sections */
        .form-section { margin-top: 25px; padding-top: 15px; border-top: 1px solid #eee; }
        .form-section h4 { margin-bottom: 15px; }
        .form-submit-actions { text-align: center; margin-top: 30px; display: flex; justify-content: center; align-items: center; gap: 15px; flex-wrap: wrap; }
        .submit-button { background-color: #007bff; color: white; padding: 12px 25px; border: none; border-radius: 4px; cursor: pointer; font-size: 1.1em; transition: background-color 0.3s ease; order: 2; }
        .submit-button:hover { background-color: #0056b3; }
        .back-button { background-color: #6c757d; color: white; padding: 12px 25px; border: none; border-radius: 4px; cursor: pointer; font-size: 1.1em; transition: background-color 0.3s ease; order: 1; }
        .back-button:hover { background-color: #5a6268; }

        /* Responsive adjustments for form */
        @media (max-width: 768px) {
             .table-responsive { margin-bottom: 10px; }
             #requisition-items-table th, #requisition-items-table td { padding: 6px; }
             #requisition-items-table th.th-checkbox-delete,
             #requisition-items-table td.td-checkbox-delete { width: 35px; padding: 6px 4px;} /* Adjust for smaller screens */
             #requisition-items-table th.sl-header { width: auto; } /* Reset width */
             #requisition-items-table td .item-input { padding: 5px; font-size: 0.9rem; }
             .table-actions { justify-content: flex-start; flex-direction: column; align-items: stretch; }
             .action-btn { width: 100%; margin-left: 0 !important; box-sizing: border-box; text-align: center; }
             .add-row-btn { order: 3; } .delete-mode-btn { order: 1; } .confirm-delete-btn { order: 1; } .cancel-delete-btn { order: 2; }
             .form-grid, .requester-grid { grid-template-columns: 1fr; gap: 15px; }
             .form-submit-actions { flex-direction: column; align-items: stretch; }
             .submit-button, .back-button { width: 100%; order: 0; }
             .back-button { margin-bottom: 10px; }
        }
    </style>

    {{-- Main Dashboard Container (Sidebar + Content) --}}
    <div class="dashboard-container">

        {{-- Sidebar Navigation --}}
        <nav class="sidebar">
             <h2>Dashboard</h2>
             <ul>
                 <li><a href="#" data-target="requisition-form" class="nav-link active"><i class="fas fa-fw fa-file-alt"></i> Requisition Form</a></li>
                 <li><a href="#" data-target="form-status" class="nav-link"><i class="fas fa-fw fa-clipboard-list"></i> Form Status</a></li>
                 <li><a href="#" data-target="notification-content" class="nav-link"><i class="fas fa-fw fa-bell"></i> Notification</a></li>
                 {{-- Add other sidebar links here --}}
             </ul>
         </nav>

        {{-- Main Content Area --}}
        <main class="content-area">

            {{-- Display Session Feedback & Validation Errors Here --}}
            @if (session('success')) <div class="alert-success">{{ session('success') }}</div> @endif
            @if (session('error')) <div class="alert-danger">{{ session('error') }}</div> @endif
            @if ($errors->any())
                <div class="alert-danger">
                    <strong>Whoops! Something went wrong.</strong>
                    <ul style="margin-top: 0.5rem; padding-left: 1.5rem;"> {{-- Added style for better list display --}}
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif


            {{-- Section 1: Requisition Form (Initially Active) --}}
            <div id="requisition-form" class="content-section active">

                <!-- Form Header -->
                <div class="form-header-jnec">
                    <h2>Jigme Namgyel Engineering College</h2>
                    <p>DEOTHANG, SAMDRUP JONGKHAR, BHUTAN</p>
                    <h1>REQUISITION FORM</h1>
                </div>

                {{-- Requisition Form --}}
                <form id="new-requisition" action="{{ route('user.requisitions.store') }}" method="POST"> {{-- Added ID --}}
                @csrf

                    <!-- Top Information Section -->
                    <div class="form-grid">
                        <div>
                            <label for="req-date">Date:</label>
                            <input type="date" id="req-date" name="requisition_date" required value="{{ old('requisition_date', date('Y-m-d')) }}">
                        </div>
                        <div>
                            <label for="req-department">Department:</label>
                            <select id="req-department" name="department" required>
                                <option value="" disabled {{ old('department') ? '' : 'selected' }}>-- Select Department --</option>
                                <option value="DIT" {{ old('department') == 'DIT' ? 'selected' : '' }}>Department of Information Technology</option>
                                <option value="DCES" {{ old('department') == 'DCES' ? 'selected' : '' }}>Department of Civil & Surveying Engineering</option>
                                <option value="DEE" {{ old('department') == 'DEE' ? 'selected' : '' }}>Department of Electrical & Electronics Engineering</option>
                                <option value="DHM" {{ old('department') == 'DHM' ? 'selected' : '' }}>Department of Humanities & Management</option>
                                <option value="DME" {{ old('department') == 'DME' ? 'selected' : '' }}>Department of Mechanical Engineering</option>
                                <option value="Administration" {{ old('department') == 'Administration' ? 'selected' : '' }}>Administration and Accounts</option>
                                <option value="Exam Cell" {{ old('department') == 'Exam Cell' ? 'selected' : '' }}>Examination Cell</option>
                                <option value="Games and Sports" {{ old('department') == 'Games and Sports' ? 'selected' : '' }}>Games and Sports</option>
                                <option value="Library" {{ old('department') == 'Library' ? 'selected' : '' }}>Central Library</option>
                                <option value="Maintenance" {{ old('department') == 'Maintenance' ? 'selected' : '' }}>Estate & Maint</option>
                                <option value="Accounts" {{ old('department') == 'Accounts' ? 'selected' : '' }}>Accounts</option>
                                <option value="Student Services" {{ old('department') == 'Student Services' ? 'selected' : '' }}>Student Affairs</option>
                            </select>
                        </div>
                        <div style="grid-column: 1 / -1;">
                             <label style="font-weight: normal;">To: The President</label> {{-- Made label normal weight --}}
                        </div>
                    </div>
                    <p style="margin-top:15px; margin-bottom: 15px;">Sir, Kindly arrange to supply the following items:</p>

                    <!-- Items Table -->
                    <div class="table-responsive">
                        <table id="requisition-items-table">
                            <thead>
                                <tr>
                                    <th class="th-checkbox-delete"></th> {{-- Checkbox Header --}}
                                    <th class="sl-header">Sl. No.</th>
                                    <th>Item Name</th>
                                    <th>Description / Specification</th> {{-- Expanded title --}}
                                    <th>Quantity</th>
                                    <th>Purpose / Remarks</th> {{-- Expanded title --}}
                                </tr>
                            </thead>
                            <tbody>
                                {{-- Use old() helper to repopulate table rows --}}
                                @php $oldItems = old('item_name') ?? []; @endphp
                                @if(!empty($oldItems))
                                    @foreach($oldItems as $index => $itemName)
                                        @if(!empty($itemName)) {{-- Check if item name is not empty --}}
                                        <tr>
                                            <td class="td-checkbox-delete"></td> {{-- Checkbox Cell --}}
                                            <td class="sl-cell"><span class="sl-no">{{ $index + 1 }}</span></td>
                                            <td><input type="text" class="item-input" name="item_name[]" placeholder="Enter item name" required value="{{ $itemName }}"></td>
                                            <td><textarea class="item-input" name="item_description[]" placeholder="Enter description/specs" rows="2">{{ old('item_description')[$index] ?? '' }}</textarea></td>
                                            <td><input type="text" class="item-input" name="item_quantity[]" placeholder="e.g., 5 units" required value="{{ old('item_quantity')[$index] ?? '' }}"></td> {{-- Added placeholder example --}}
                                            <td><textarea class="item-input" name="item_remarks[]" placeholder="Enter purpose/remarks" rows="2">{{ old('item_remarks')[$index] ?? '' }}</textarea></td>
                                        </tr>
                                        @endif
                                    @endforeach
                                @else
                                    {{-- Default initial row --}}
                                    <tr>
                                        <td class="td-checkbox-delete"></td> {{-- Checkbox Cell --}}
                                        <td class="sl-cell"><span class="sl-no">1</span></td>
                                        <td><input type="text" class="item-input" name="item_name[]" placeholder="Enter item name" required></td>
                                        <td><textarea class="item-input" name="item_description[]" placeholder="Enter description/specs" rows="2"></textarea></td>
                                        <td><input type="text" class="item-input" name="item_quantity[]" placeholder="e.g., 5 units" required></td> {{-- Added placeholder example --}}
                                        <td><textarea class="item-input" name="item_remarks[]" placeholder="Enter purpose/remarks" rows="2"></textarea></td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>

                    <!-- Action Buttons Container -->
                    <div class="table-actions">
                         <button type="button" id="delete-mode-btn" class="action-btn delete-mode-btn" onclick="toggleDeleteMode()"><i class="fas fa-trash-alt"></i> Delete Items</button>
                         <button type="button" id="confirm-delete-btn" class="action-btn confirm-delete-btn" onclick="performBulkDelete()" style="display: none;"><i class="fas fa-check"></i> Confirm Delete</button>
                         <button type="button" id="cancel-delete-btn" class="action-btn cancel-delete-btn" onclick="toggleDeleteMode(true)" style="display: none;"><i class="fas fa-times"></i> Cancel</button>
                         <button type="button" id="add-row-btn" class="action-btn add-row-btn" onclick="addItemRow()"><i class="fas fa-plus"></i> Add Item Row</button>
                    </div>

                    <!-- Requester Information -->
                    <div class="form-section">
                         <h4>Requested By (Indenter):</h4>
                         <div class="form-grid requester-grid">
                             <div>
                                <label for="requester-name">Name:</label>
                                {{-- Pre-fill with logged-in user's name --}}
                                <input type="text" id="requester-name" name="requester_name" placeholder="Your Name" required value="{{ old('requester_name', Auth::user()->name ?? '') }}">
                             </div>
                             <div>
                                 <label for="requester-designation">Designation:</label>
                                 <select id="requester-designation" name="requester_designation" required>
                                     <option value="" disabled {{ old('requester_designation') ? '' : 'selected' }}>-- Select Designation --</option>
                                     <option value="Lecturer" {{ old('requester_designation') == 'Lecturer' ? 'selected' : '' }}>Lecturer</option>
                                     <option value="Associate Lecturer" {{ old('requester_designation') == 'Associate Lecturer' ? 'selected' : '' }}>Associate Lecturer</option>
                                     <option value="Assistant Lecturer" {{ old('requester_designation') == 'Assistant Lecturer' ? 'selected' : '' }}>Assistant Lecturer</option>
                                     <option value="Lab Technician" {{ old('requester_designation') == 'Lab Technician' ? 'selected' : '' }}>Lab Technician</option>
                                     <option value="Librarian" {{ old('requester_designation') == 'Librarian' ? 'selected' : '' }}>Librarian</option>
                                     <option value="Admin Officer" {{ old('requester_designation') == 'Admin Officer' ? 'selected' : '' }}>Admin Officer</option>
                                     <option value="Accounts Officer" {{ old('requester_designation') == 'Accounts Officer' ? 'selected' : '' }}>Accounts Officer</option>
                                     <option value="Store Keeper" {{ old('requester_designation') == 'Store Keeper' ? 'selected' : '' }}>Store Keeper</option>
                                     <option value="HOD" {{ old('requester_designation') == 'HOD' ? 'selected' : '' }}>Head of Department (HOD)</option>
                                     <option value="Dean" {{ old('requester_designation') == 'Dean' ? 'selected' : '' }}>Dean</option>
                                     <option value="LRC" {{ old('requester_designation') == 'LRC' ? 'selected' : '' }}>LRC</option>
                                     <option value="Other" {{ old('requester_designation') == 'Other' ? 'selected' : '' }}>Other Staff</option>
                                 </select>
                             </div>
                         </div>
                    </div>

                    <!-- Submit/Back Buttons Container -->
                    <div class="form-submit-actions">
                        <button type="button" class="back-button" onclick="goBack()"><i class="fas fa-arrow-left"></i> Back</button>
                        <button type="submit" class="submit-button"><i class="fas fa-paper-plane"></i> Submit Requisition</button>
                    </div>
                </form>
            </div> {{-- End #requisition-form --}}


            {{-- Section 2: Form Status --}}
            <div id="form-status" class="content-section">
                <h1>Form Status</h1>
                <p>Status updates for your submitted requisitions will appear here.</p>
                 {{-- Placeholder for status display --}}
                 <div style="text-align: center; color: #777; margin-top: 30px;">
                     <i class="fas fa-spinner fa-spin fa-3x"></i>
                     <p style="margin-top: 15px;">Loading form status...</p>
                 </div>
                 {{-- TODO: Replace above placeholder with actual status logic/component --}}
                 {{-- Example: <livewire:user-requisition-status /> --}}
            </div>

            {{-- Section 3: Notification --}}
            <div id="notification-content" class="content-section">
                <h1>Notifications</h1>
                <p>Important notifications relevant to you will be displayed here.</p>
                 {{-- Placeholder for notifications --}}
                 <div style="text-align: center; color: #777; margin-top: 30px;">
                     <i class="fas fa-bell-slash fa-3x"></i>
                      <p style="margin-top: 15px;">No new notifications.</p>
                  </div>
                 {{-- TODO: Replace above placeholder with actual notification logic/component --}}
                 {{-- Example: <livewire:user-notifications /> --}}
            </div>

        </main> {{-- End Content Area --}}

    </div> {{-- End Dashboard Container --}}


    {{-- Embedded JavaScript for Tab Switching --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const navLinks = document.querySelectorAll('.sidebar .nav-link');
            const sections = document.querySelectorAll('.content-area .content-section');

            function activateSection(targetId) {
                sections.forEach(section => {
                    if (section.id === targetId) {
                        section.classList.add('active');
                    } else {
                        section.classList.remove('active');
                    }
                });
                 // Store active tab in localStorage
                 localStorage.setItem('activeDashboardTab', targetId);
            }

            function activateLink(clickedLink) {
                navLinks.forEach(link => link.classList.remove('active'));
                if (clickedLink) {
                     clickedLink.classList.add('active');
                }
            }

            navLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const targetId = this.getAttribute('data-target');
                    if (targetId) {
                        activateLink(this);
                        activateSection(targetId);
                    }
                });
            });

            // On page load, check localStorage for the last active tab
            const savedTabId = localStorage.getItem('activeDashboardTab');
            let initialTargetId = null;

            if (savedTabId && document.getElementById(savedTabId)) {
                 initialTargetId = savedTabId;
                 const correspondingLink = document.querySelector(`.sidebar .nav-link[data-target="${savedTabId}"]`);
                 activateLink(correspondingLink);
            } else {
                // Fallback to the first link if no saved tab or saved tab doesn't exist
                const initialActiveLink = document.querySelector('.sidebar .nav-link.active'); // Check if one is marked active initially in HTML
                initialTargetId = initialActiveLink?.getAttribute('data-target');
                 if (!initialTargetId && navLinks.length > 0) { // If none active, activate the first one
                     initialTargetId = navLinks[0].getAttribute('data-target');
                     activateLink(navLinks[0]);
                 }
            }

             // Activate the determined initial section
             if (initialTargetId) {
                activateSection(initialTargetId);
             } else if (sections.length > 0) {
                 // Absolute fallback: activate the first section if nothing else works
                 sections[0].classList.add('active');
                 if (navLinks.length > 0) navLinks[0].classList.add('active'); // Also activate first link
             }

        });
    </script>

    {{-- Embedded JavaScript SPECIFICALLY for the Requisition Form --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // --- Form Elements Selection ---
            const requisitionForm = document.getElementById('new-requisition'); // Using the ID added to the form
            if (!requisitionForm) { console.error("Requisition form ID 'new-requisition' not found."); return; } // Stop if form not found

            const tableBody = document.getElementById('requisition-items-table')?.getElementsByTagName('tbody')[0];
            const tableHead = document.getElementById('requisition-items-table')?.getElementsByTagName('thead')[0];
            const checkboxHeader = tableHead?.querySelector('.th-checkbox-delete');
            const deleteModeBtn = document.getElementById('delete-mode-btn');
            const confirmDeleteBtn = document.getElementById('confirm-delete-btn');
            const cancelDeleteBtn = document.getElementById('cancel-delete-btn');
            const addRowBtn = document.getElementById('add-row-btn');
            let isInDeleteMode = false;

            // Basic check if core elements exist
            if (!tableBody || !tableHead || !checkboxHeader || !deleteModeBtn || !confirmDeleteBtn || !cancelDeleteBtn || !addRowBtn) {
                 console.warn("One or more requisition form elements (table body/head, buttons, checkbox header) not found. JS functionality might be limited.");
                 // Do not return here, allow other JS to potentially run
            }

            // --- Function to Go Back ---
            window.goBack = function() { history.back(); }

            // --- Function to Renumber Rows ---
            function renumberRows() {
                if (!tableBody) return;
                const allRows = tableBody.getElementsByTagName('tr');
                for (let i = 0; i < allRows.length; i++) {
                     const slNoCell = allRows[i].cells[1]; // Sl. No. is the second cell (index 1)
                     const slNoSpan = slNoCell?.querySelector('.sl-no');
                     if (slNoSpan) { slNoSpan.textContent = i + 1; }
                }
            }

            // --- Function to Toggle Delete Mode ---
            window.toggleDeleteMode = function(isCancelling = false) {
                // Ensure all required buttons and table elements exist
                if (!tableBody || !checkboxHeader || !deleteModeBtn || !confirmDeleteBtn || !cancelDeleteBtn || !addRowBtn) {
                    console.error("Cannot toggle delete mode: essential elements missing.");
                    return;
                 }

                const allRows = tableBody.getElementsByTagName('tr');
                // Prevent entering delete mode if no rows exist
                if (!isInDeleteMode && allRows.length === 0 && !isCancelling) {
                    alert("There are no items to delete.");
                    return;
                }

                const enteringDeleteMode = !isInDeleteMode && !isCancelling;
                const exitingDeleteMode = isInDeleteMode && isCancelling;

                // Only proceed if entering or exiting delete mode
                 if (enteringDeleteMode || exitingDeleteMode) {
                    isInDeleteMode = enteringDeleteMode; // Update state

                    // Toggle button visibility and state
                    deleteModeBtn.style.display = isInDeleteMode ? 'none' : 'inline-block';
                    confirmDeleteBtn.style.display = isInDeleteMode ? 'inline-block' : 'none';
                    cancelDeleteBtn.style.display = isInDeleteMode ? 'inline-block' : 'none';
                    addRowBtn.disabled = isInDeleteMode;
                    addRowBtn.style.opacity = isInDeleteMode ? '0.6' : '1';
                    addRowBtn.style.cursor = isInDeleteMode ? 'not-allowed' : 'pointer';

                    // Update checkbox header content/visibility
                    checkboxHeader.innerHTML = isInDeleteMode ? '<i class="fas fa-trash-alt" style="color: #dc3545;" title="Delete Mode Active"></i>' : '';
                    checkboxHeader.classList.toggle('delete-mode-active', isInDeleteMode);

                    // Add/Remove checkboxes in table rows
                    for (let i = 0; i < allRows.length; i++) {
                        const row = allRows[i];
                        const checkboxCell = row.cells[0]; // Checkbox is the first cell (index 0)
                        if (checkboxCell) {
                            if (isInDeleteMode) {
                                // Add checkbox if it doesn't exist
                                if (!checkboxCell.querySelector('.row-checkbox')) {
                                    const slNo = row.cells[1]?.querySelector('.sl-no')?.textContent || (i + 1); // Get Sl. No. from cell 1
                                    checkboxCell.innerHTML = `<input type="checkbox" class="row-checkbox" name="select_item_for_delete[]" aria-label="Select item ${slNo} for deletion" value="${i}">`; // Optional: add value=index
                                }
                            } else {
                                checkboxCell.innerHTML = ''; // Clear cell content when exiting delete mode
                                 // Ensure any previously checked state is cleared visually if needed (though removing removes the input)
                            }
                        }
                    }

                     // Renumber rows when exiting delete mode to ensure correct numbering after potential deletions
                     if (!isInDeleteMode) {
                        renumberRows();
                     }
                }
            }


            // --- Function to Add Item Row ---
            window.addItemRow = function() {
                 if (!tableBody) { console.error("Table body not found, cannot add row."); return; }

                const newRow = tableBody.insertRow(); // Add row to the end
                const rowCount = tableBody.rows.length;
                let cellIndex = 0;

                // Cell 0: Checkbox Cell
                const cellCheckbox = newRow.insertCell(cellIndex++);
                cellCheckbox.className = 'td-checkbox-delete';
                if (isInDeleteMode) { // If already in delete mode, add checkbox to new row
                    cellCheckbox.innerHTML = `<input type="checkbox" class="row-checkbox" name="select_item_for_delete[]" aria-label="Select new item for deletion" value="${rowCount - 1}">`;
                } else { cellCheckbox.innerHTML = ''; }

                // Cell 1: Sl. No. Cell
                const cellSlNo = newRow.insertCell(cellIndex++);
                cellSlNo.className = 'sl-cell';
                cellSlNo.innerHTML = `<span class="sl-no">${rowCount}</span>`;

                // Cell 2: Item Name
                const cellItemName = newRow.insertCell(cellIndex++);
                cellItemName.innerHTML = `<input type="text" class="item-input" name="item_name[]" placeholder="Enter item name" required>`;

                // Cell 3: Description
                const cellDesc = newRow.insertCell(cellIndex++);
                cellDesc.innerHTML = `<textarea class="item-input" name="item_description[]" placeholder="Enter description/specs" rows="2"></textarea>`;

                // Cell 4: Quantity
                const cellQty = newRow.insertCell(cellIndex++);
                cellQty.innerHTML = `<input type="text" class="item-input" name="item_quantity[]" placeholder="e.g., 5 units" required>`; // Added example placeholder

                // Cell 5: Remarks
                const cellRemarks = newRow.insertCell(cellIndex++);
                cellRemarks.innerHTML = `<textarea class="item-input" name="item_remarks[]" placeholder="Enter purpose/remarks" rows="2"></textarea>`;

                // Focus on the first input of the new row for better UX
                const firstInput = newRow.querySelector('input[name="item_name[]"]');
                 if(firstInput) firstInput.focus();
            }


            // --- Function to Perform Bulk Delete ---
            window.performBulkDelete = function() {
                 if (!tableBody) { console.error("Table body not found, cannot delete rows."); return; }

                // Select checked checkboxes within the designated checkbox cells
                const selectedCheckboxes = Array.from(tableBody.querySelectorAll('td.td-checkbox-delete input.row-checkbox:checked'));

                if (selectedCheckboxes.length === 0) {
                    alert('Please select at least one item row to delete.');
                    return;
                }

                if (!confirm(`Are you sure you want to delete ${selectedCheckboxes.length} selected item(s)? This action cannot be undone.`)) {
                    return; // User cancelled
                }

                // Iterate backwards to safely remove rows without index issues
                for (let i = selectedCheckboxes.length - 1; i >= 0; i--) {
                    const checkbox = selectedCheckboxes[i];
                    const row = checkbox.closest('tr'); // Get the parent <tr> element
                    if (row) { tableBody.removeChild(row); }
                }

                // Exit delete mode after deletion is complete (this also handles renumbering)
                toggleDeleteMode(true); // Pass true to indicate cancellation/exit
            }

            // --- Form Submit Handler (Client-side validation) ---
            requisitionForm.addEventListener('submit', function(event) {
                 let isValid = true;
                 let firstErrorElement = null;

                 // 1. Check if table has at least one valid row
                 if (!tableBody || tableBody.rows.length === 0) {
                     isValid = false;
                     alert("Please add at least one item to the requisition.");
                     firstErrorElement = addRowBtn; // Focus add button if table is empty
                 } else {
                     // Check if the first item name is filled (basic check)
                     const firstItemNameInput = tableBody.querySelector('input[name="item_name[]"]');
                     if (!firstItemNameInput || firstItemNameInput.value.trim() === '') {
                          isValid = false;
                          alert("Please fill in the details for the first item.");
                          firstErrorElement = firstItemNameInput;
                      }
                      // You could add more checks here for quantity etc. if needed
                 }

                 // 2. Use HTML5 checkValidity for other required fields
                 if (!requisitionForm.checkValidity()) {
                     isValid = false;
                      // Find the first invalid element within the form for focusing
                      if (!firstErrorElement) {
                          firstErrorElement = requisitionForm.querySelector(':invalid');
                      }
                      requisitionForm.reportValidity(); // Show default browser validation messages
                      alert("Please fill in all required fields (like Date, Department, Name, Designation, and item details).");
                  }

                 // Prevent submission if any validation failed
                 if (!isValid) {
                     event.preventDefault(); // Stop form submission
                     if (firstErrorElement) {
                         firstErrorElement.focus(); // Focus the first element with an error
                     }
                     return;
                 }

                 // If all validations pass:
                 console.log("Client-side validation passed. Submitting form...");
                 // Optionally: disable submit button to prevent double clicks
                 const submitButton = requisitionForm.querySelector('.submit-button');
                 if(submitButton) { submitButton.disabled = true; submitButton.textContent = 'Submitting...'; }
            });

            // --- Initial Setup ---
            // Ensure delete mode buttons are hidden on page load
            if(confirmDeleteBtn) confirmDeleteBtn.style.display = 'none';
            if(cancelDeleteBtn) cancelDeleteBtn.style.display = 'none';
            // Ensure checkbox header is initially empty
            if(checkboxHeader) checkboxHeader.innerHTML = '';
            // Initial renumbering in case the page loaded with pre-filled rows (e.g., from 'old' input)
             renumberRows();

        }); // End DOMContentLoaded listener
    </script>

</x-app-layout>