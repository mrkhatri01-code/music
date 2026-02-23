{{-- Account Settings Modal --}}
<div id="accountModal"
    style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center;">
    <div
        style="background: white; width: 100%; max-width: 500px; border-radius: 12px; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04); overflow: hidden;">
        <div
            style="padding: 1.5rem; border-bottom: 1px solid #e5e7eb; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="margin: 0; font-size: 1.25rem; font-weight: 600; color: #1f2937;">
                <i class="fa-solid fa-user-lock"></i> Account Credentials
            </h3>
            <button type="button" onclick="closeAccountModal()"
                style="background: none; border: none; font-size: 1.5rem; color: #6b7280; cursor: pointer;">&times;</button>
        </div>

        <form id="accountForm" method="POST" action="">
            @csrf
            @method('PUT')
            <div style="padding: 1.5rem;">
                <div class="form-group" style="margin-bottom: 1.5rem;">
                    <label for="modal-email"
                        style="display: block; margin-bottom: 0.5rem; font-weight: 500; color: #374151;">Email
                        Address</label>
                    <input type="email" id="modal-email" name="email" class="form-control"
                        style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 6px;">
                </div>

                <div class="form-group">
                    <label for="modal-password"
                        style="display: block; margin-bottom: 0.5rem; font-weight: 500; color: #374151;">New
                        Password</label>
                    <input type="password" id="modal-password" name="password" class="form-control"
                        placeholder="Leave blank to keep current"
                        style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 6px;">

                    <div style="margin-top: 0.5rem; display: flex; align-items: center;">
                        <input type="checkbox" id="modal-show-password" onclick="toggleModalPassword()"
                            style="margin-right: 0.5rem;">
                        <label for="modal-show-password"
                            style="margin: 0; font-size: 0.9em; color: #4a5568; cursor: pointer;">Show Password</label>
                    </div>
                    <small style="display: block; margin-top: 0.5rem; color: #6b7280;">Min. 6 characters</small>
                </div>
            </div>

            <div
                style="padding: 1.5rem; background: #f9fafb; border-top: 1px solid #e5e7eb; display: flex; justify-content: flex-end; gap: 0.75rem;">
                <button type="button" onclick="closeAccountModal()"
                    style="padding: 0.5rem 1rem; background: white; border: 1px solid #d1d5db; border-radius: 6px; color: #374151; cursor: pointer; font-weight: 500;">Cancel</button>
                <button type="submit"
                    style="padding: 0.5rem 1rem; background: #2563eb; border: none; border-radius: 6px; color: white; cursor: pointer; font-weight: 500;">Update
                    Credentials</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openAccountModal(url, email) {
        document.getElementById('accountForm').action = url;
        document.getElementById('modal-email').value = email;

        // Reset fields
        document.getElementById('modal-password').value = '';
        document.getElementById('modal-password').type = 'password';
        const checkbox = document.getElementById('modal-show-password');
        if (checkbox) checkbox.checked = false;

        const modal = document.getElementById('accountModal');
        modal.style.display = 'flex';
    }

    function closeAccountModal() {
        document.getElementById('accountModal').style.display = 'none';
    }

    // Close on outside click
    document.getElementById('accountModal').addEventListener('click', function (e) {
        if (e.target === this) {
            closeAccountModal();
        }
    });

    function toggleModalPassword() {
        const input = document.getElementById('modal-password');
        if (input.type === 'password') {
            input.type = 'text';
        } else {
            input.type = 'password';
        }
    }
</script>