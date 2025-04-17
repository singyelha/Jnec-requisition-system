{{-- Use the layout file that ACTUALLY exists in your project --}}
@extends('layouts.app')

{{-- Define the content for the layout's @yield('content') section --}}
@section('content')

    {{-- ====================================================================== --}}
    {{-- == USER DASHBOARD - Requisition Form / Status / Notifications Layout == --}}
    {{-- ====================================================================== --}}

    {{-- FontAwesome CSS (Place in layouts/app.blade.php <head> for better practice) --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    {{-- Embedded Styles for the Custom Dashboard Layout --}}
    {{-- IMPORTANT: These styles are likely being overridden by your global app.scss/Bootstrap --}}
    

    {{-- Main Dashboard Container (Sidebar + Content) --}}
    <div class="dashboard-container">

        {{-- Sidebar Navigation --}}
        <nav class="sidebar">
             <h2>Dashboard</h2>
             <ul>
                 <li><a href="#" data-target="requisition-form" class="nav-link active"><i class="fas fa-fw fa-file-alt"></i> Requisition Form</a></li>
                 <li><a href="#" data-target="form-status" class="nav-link"><i class="fas fa-fw fa-clipboard-list"></i> Form Status</a></li>
                 <li><a href="#" data-target="notification-content" class="nav-link"><i class="fas fa-fw fa-bell"></i> Notification</a></li>
             </ul>
         </nav>

        {{-- Main Content Area --}}
        <main class="content-area">

            {{-- Session Feedback & Validation Errors --}}
            @if (session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
            @if (session('error')) <div class="alert alert-danger">{{ session('error') }}</div> @endif
            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Whoops! Something went wrong.</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Section 1: Requisition Form (Initially Active) --}}
            <div id="requisition-form" class="content-section active">
                {{-- Form Header --}}
                <div class="form-header-jnec"><h2>Jigme Namgyel Engineering College</h2><p>DEOTHANG, SAMDRUP JONGKHAR, BHUTAN</p><h1>REQUISITION FORM</h1></div>
                {{-- Form with correct ID --}}
                <form action="{{ route('user.requisitions.store') }}" method="POST" id="new-requisition">
                @csrf
                    {{-- Top Info --}}
                    <div class="form-grid"><div><label for="req-date">Date:</label><input type="date" id="req-date" name="requisition_date" required value="{{ old('requisition_date', date('Y-m-d')) }}"></div><div><label for="req-department">Department:</label><select id="req-department" name="department" required><option value="" disabled {{ old('department') ? '' : 'selected' }}>-- Select Department --</option><option value="DIT" {{ old('department') == 'DIT' ? 'selected' : '' }}>Department of Information Technology</option><option value="DCES" {{ old('department') == 'DCES' ? 'selected' : '' }}>Department of Civil & Surveying Engineering</option><option value="DEE" {{ old('department') == 'DEE' ? 'selected' : '' }}>Department of Electrical & Electronics Engineering</option><option value="DHM" {{ old('department') == 'DHM' ? 'selected' : '' }}>Department of Humanities & Management</option><option value="DME" {{ old('department') == 'DME' ? 'selected' : '' }}>Department of Mechanical Engineering</option><option value="Administration" {{ old('department') == 'Administration' ? 'selected' : '' }}>Administration and Accounts</option><option value="Exam Cell" {{ old('department') == 'Exam Cell' ? 'selected' : '' }}>Examination Cell</option><option value="Games and Sports" {{ old('department') == 'Games and Sports' ? 'selected' : '' }}>Games and Sports</option><option value="Library" {{ old('department') == 'Library' ? 'selected' : '' }}>Central Library</option><option value="Maintenance" {{ old('department') == 'Maintenance' ? 'selected' : '' }}>Estate & Maint</option><option value="Accounts" {{ old('department') == 'Accounts' ? 'selected' : '' }}>Accounts</option><option value="Student Services" {{ old('department') == 'Student Services' ? 'selected' : '' }}>Student Affairs</option></select></div><div style="grid-column: 1 / -1;"><label>To: The President</label></div></div>
                    <p style="margin-top:15px; margin-bottom: 15px;">Sir, Kindly arrange to supply the following items:</p>
                    {{-- Items Table --}}
                    <div class="table-responsive"><table id="requisition-items-table"><thead><tr><th class="th-checkbox-delete"></th><th class="sl-header">Sl. No.</th><th>Item Name</th><th>Description</th><th>Quantity</th><th>Remarks</th></tr></thead><tbody>
                    {{-- Repopulate Rows --}}
                    @if(is_array(old('item_name')) && count(old('item_name')) > 0) @foreach(old('item_name') as $index => $itemName)<tr><td class="td-checkbox-delete"></td><td class="sl-cell"><span class="sl-no">{{ $index + 1 }}</span></td><td><input type="text" class="item-input" name="item_name[]" placeholder="Enter item name" required value="{{ $itemName }}"></td><td><textarea class="item-input" name="item_description[]" placeholder="Enter description/specs" rows="2">{{ old('item_description')[$index] ?? '' }}</textarea></td><td><input type="text" class="item-input" name="item_quantity[]" placeholder="Enter quantity" required value="{{ old('item_quantity')[$index] ?? '' }}"></td><td><textarea class="item-input" name="item_remarks[]" placeholder="Enter purpose/remarks" rows="2">{{ old('item_remarks')[$index] ?? '' }}</textarea></td></tr> @endforeach @else <tr><td class="td-checkbox-delete"></td><td class="sl-cell"><span class="sl-no">1</span></td><td><input type="text" class="item-input" name="item_name[]" placeholder="Enter item name" required></td><td><textarea class="item-input" name="item_description[]" placeholder="Enter description/specs" rows="2"></textarea></td><td><input type="text" class="item-input" name="item_quantity[]" placeholder="Enter quantity" required></td><td><textarea class="item-input" name="item_remarks[]" placeholder="Enter purpose/remarks" rows="2"></textarea></td></tr> @endif
                    </tbody></table></div>
                    {{-- Action Buttons --}}
                    <div class="table-actions"><button type="button" id="delete-mode-btn" class="action-btn delete-mode-btn" onclick="toggleDeleteMode()">Delete Items</button><button type="button" id="confirm-delete-btn" class="action-btn confirm-delete-btn" onclick="performBulkDelete()" style="display: none;">Confirm Delete Selected</button><button type="button" id="cancel-delete-btn" class="action-btn cancel-delete-btn" onclick="toggleDeleteMode(true)" style="display: none;">Cancel</button><button type="button" id="add-row-btn" class="action-btn add-row-btn" onclick="addItemRow()">+ Add Item Row</button></div>
                    {{-- Requester Info --}}
                    <div class="form-section"><h4>Requested By (Indenter):</h4><div class="form-grid requester-grid"><div><label for="requester-name">Name:</label><input type="text" id="requester-name" name="requester_name" placeholder="Your Name" required value="{{ old('requester_name', Auth::user()->name ?? '') }}"></div><div><label for="requester-designation">Designation:</label><select id="requester-designation" name="requester_designation" required><option value="" disabled {{ old('requester_designation') ? '' : 'selected' }}>-- Select Designation --</option><option value="Lecturer" {{ old('requester_designation') == 'Lecturer' ? 'selected' : '' }}>Lecturer</option><option value="Associate Lecturer" {{ old('requester_designation') == 'Associate Lecturer' ? 'selected' : '' }}>Associate Lecturer</option><option value="Assistant Lecturer" {{ old('requester_designation') == 'Assistant Lecturer' ? 'selected' : '' }}>Assistant Lecturer</option><option value="Lab Technician" {{ old('requester_designation') == 'Lab Technician' ? 'selected' : '' }}>Lab Technician</option><option value="Librarian" {{ old('requester_designation') == 'Librarian' ? 'selected' : '' }}>Librarian</option><option value="Admin Officer" {{ old('requester_designation') == 'Admin Officer' ? 'selected' : '' }}>Admin Officer</option><option value="Accounts Officer" {{ old('requester_designation') == 'Accounts Officer' ? 'selected' : '' }}>Accounts Officer</option><option value="Store Keeper" {{ old('requester_designation') == 'Store Keeper' ? 'selected' : '' }}>Store Keeper</option><option value="HOD" {{ old('requester_designation') == 'HOD' ? 'selected' : '' }}>Head of Department (HOD)</option><option value="Dean" {{ old('requester_designation') == 'Dean' ? 'selected' : '' }}>Dean</option><option value="LRC" {{ old('requester_designation') == 'LRC' ? 'selected' : '' }}>LRC</option><option value="Other" {{ old('requester_designation') == 'Other' ? 'selected' : '' }}>Other Staff</option></select></div></div></div>
                    {{-- Submit/Back Buttons --}}
                    <div class="form-submit-actions"><button type="button" class="back-button" onclick="goBack()">Back</button><button type="submit" class="submit-button">Submit Requisition</button></div>
                </form> {{-- End Form --}}
            </div> {{-- End #requisition-form --}}

            {{-- Section 2: Form Status --}}
            <div id="form-status" class="content-section">
                <h1>Form Status</h1>
                <p>Status updates for your submitted requisitions will appear here.</p>
                {{-- TODO: Add content --}}
            </div>

            {{-- Section 3: Notification --}}
            <div id="notification-content" class="content-section">
                <h1>Notifications</h1>
                <p>Important notifications relevant to you will be displayed here.</p>
                 {{-- TODO: Add content --}}
            </div>

        </main> {{-- End Content Area --}}

    </div> {{-- End Dashboard Container --}}

    {{-- JavaScript for Tab Switching --}}
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

    {{-- JavaScript SPECIFICALLY for the Requisition Form --}}
    @push('scripts') {{-- Use @push if layouts/app.blade.php has @stack('scripts') --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() { const requisitionForm = document.getElementById('new-requisition'); if (!requisitionForm) { return; } const tableBody = document.getElementById('requisition-items-table')?.getElementsByTagName('tbody')[0]; const tableHead = document.getElementById('requisition-items-table')?.getElementsByTagName('thead')[0]; const checkboxHeader = tableHead?.querySelector('.th-checkbox-delete'); const deleteModeBtn = document.getElementById('delete-mode-btn'); const confirmDeleteBtn = document.getElementById('confirm-delete-btn'); const cancelDeleteBtn = document.getElementById('cancel-delete-btn'); const addRowBtn = document.getElementById('add-row-btn'); let isInDeleteMode = false; if (!tableBody || !tableHead || !checkboxHeader || !deleteModeBtn || !confirmDeleteBtn || !cancelDeleteBtn || !addRowBtn) { console.warn("Form elements missing. Add/Delete JS might fail."); } window.goBack = function() { history.back(); } function renumberRows() { if (!tableBody) return; const allRows = tableBody.getElementsByTagName('tr'); for (let i = 0; i < allRows.length; i++) { const slNoCell = allRows[i].cells[1]; const slNoSpan = slNoCell?.querySelector('.sl-no'); if (slNoSpan) { slNoSpan.textContent = i + 1; } } } window.toggleDeleteMode = function(isCancelling = false) { if (!tableBody || !checkboxHeader || !deleteModeBtn || !confirmDeleteBtn || !cancelDeleteBtn || !addRowBtn) return; const allRows = tableBody.getElementsByTagName('tr'); if (!isInDeleteMode && allRows.length === 0 && !isCancelling) { alert("There are no items to delete."); return; } const enteringDeleteMode = !isInDeleteMode && !isCancelling; const exitingDeleteMode = isInDeleteMode && isCancelling; if (enteringDeleteMode || exitingDeleteMode) { isInDeleteMode = enteringDeleteMode; deleteModeBtn.style.display = isInDeleteMode ? 'none' : 'inline-block'; confirmDeleteBtn.style.display = isInDeleteMode ? 'inline-block' : 'none'; cancelDeleteBtn.style.display = isInDeleteMode ? 'inline-block' : 'none'; addRowBtn.disabled = isInDeleteMode; addRowBtn.style.opacity = isInDeleteMode ? '0.6' : '1'; addRowBtn.style.cursor = isInDeleteMode ? 'not-allowed' : 'pointer'; checkboxHeader.innerHTML = isInDeleteMode ? '<i class="fas fa-trash-alt" style="color: #dc3545;" title="Delete Mode Active"></i>' : ''; checkboxHeader.classList.toggle('delete-mode-active', isInDeleteMode); for (let i = 0; i < allRows.length; i++) { const row = allRows[i]; const checkboxCell = row.cells[0]; if (checkboxCell) { if (isInDeleteMode) { if (!checkboxCell.querySelector('.row-checkbox')) { const slNo = row.cells[1]?.querySelector('.sl-no')?.textContent || (i + 1); checkboxCell.innerHTML = `<input type="checkbox" class="row-checkbox" value="${i}" name="select_item_for_delete[]" aria-label="Select item ${slNo} for deletion">`; } } else { checkboxCell.innerHTML = ''; } } } if (!isInDeleteMode) { renumberRows(); } } } window.addItemRow = function() { if (!tableBody) return; const newRow = tableBody.insertRow(); const rowCount = tableBody.rows.length; let cellIndex = 0; const cellCheckbox = newRow.insertCell(cellIndex++); cellCheckbox.className = 'td-checkbox-delete'; if (isInDeleteMode) { cellCheckbox.innerHTML = `<input type="checkbox" class="row-checkbox" value="${rowCount - 1}" name="select_item_for_delete[]" aria-label="Select new item for deletion">`; } else { cellCheckbox.innerHTML = ''; } const cellSlNo = newRow.insertCell(cellIndex++); cellSlNo.className = 'sl-cell'; cellSlNo.innerHTML = `<span class="sl-no">${rowCount}</span>`; const cellItemName = newRow.insertCell(cellIndex++); cellItemName.innerHTML = `<input type="text" class="item-input" name="item_name[]" placeholder="Enter item name" required>`; const cellDesc = newRow.insertCell(cellIndex++); cellDesc.innerHTML = `<textarea class="item-input" name="item_description[]" placeholder="Enter description/specs" rows="2"></textarea>`; const cellQty = newRow.insertCell(cellIndex++); cellQty.innerHTML = `<input type="text" class="item-input" name="item_quantity[]" placeholder="Enter quantity" required>`; const cellRemarks = newRow.insertCell(cellIndex++); cellRemarks.innerHTML = `<textarea class="item-input" name="item_remarks[]" placeholder="Enter purpose/remarks" rows="2"></textarea>`; newRow.querySelector('input[name="item_name[]"]')?.focus(); } window.performBulkDelete = function() { if (!tableBody) return; const selectedCheckboxes = Array.from(tableBody.querySelectorAll('td.td-checkbox-delete input.row-checkbox:checked')); if (selectedCheckboxes.length === 0) { alert('Please select at least one item row to delete.'); return; } if (!confirm(`Are you sure you want to delete ${selectedCheckboxes.length} selected item(s)?`)) { return; } for (let i = selectedCheckboxes.length - 1; i >= 0; i--) { const row = selectedCheckboxes[i].closest('tr'); if (row) { tableBody.removeChild(row); } } toggleDeleteMode(true); } requisitionForm.addEventListener('submit', function(event) { const itemCount = tableBody ? tableBody.rows.length : 0; let hasValidItem = false; if (tableBody && itemCount > 0) { const itemNames = tableBody.querySelectorAll('input[name="item_name[]"]'); itemNames.forEach(input => { if (input.value.trim() !== '') hasValidItem = true; }); } else if (itemCount === 0){ hasValidItem = false; } if (!hasValidItem) { event.preventDefault(); alert("Please add and fill details for at least one item."); tableBody?.querySelector('input[name="item_name[]"]')?.focus(); return; } if (!requisitionForm.checkValidity()) { event.preventDefault(); const firstInvalid = requisitionForm.querySelector(':invalid'); firstInvalid?.focus(); alert("Please fill in all required fields."); return; } const submitButton = requisitionForm.querySelector('.submit-button'); if (submitButton) { submitButton.disabled = true; submitButton.textContent = 'Submitting...'; } console.log("Client-side checks passed. Submitting form..."); }); if(confirmDeleteBtn) confirmDeleteBtn.style.display = 'none'; if(cancelDeleteBtn) cancelDeleteBtn.style.display = 'none'; if(checkboxHeader) checkboxHeader.innerHTML = ''; });
    </script>
    @endpush

@endsection {{-- End of content section --}}
