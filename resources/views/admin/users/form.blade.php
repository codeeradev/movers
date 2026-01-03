<div class="row g-3">

    <!-- Name -->
    <div class="col-md-6">
        <label class="form-label">Name</label>
        <input type="text" name="name" 
               value="{{ old('name', $employee->name ?? '') }}" 
               class="form-input" required>
    </div>

    <!-- Email -->
    <div class="col-md-6">
        <label class="form-label">Email</label>
        <input type="email" name="email" 
               value="{{ old('email', $employee->email ?? '') }}" 
               class="form-input" required>
    </div>

    <!-- Phone -->
    <div class="col-md-6">
        <label class="form-label">Phone</label>
        <input type="text" name="phone" 
               value="{{ old('phone', $employee->phone ?? '') }}" 
               class="form-input" required>
    </div>

    <!-- Role -->
    <div class="col-md-6">
        <label class="form-label">Role</label>
        <div class="dropdown-wrapper">
            <select name="role" class="form-input">
                @foreach(config('constants.roles') as $key => $value)
                    <option value="{{ $key }}"
                        {{ (isset($employee) && $employee->role == $key) ? 'selected' : '' }}>
                        {{ ucfirst(strtolower($value)) }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- Status -->
    <div class="col-md-6">
        <label class="form-label">Status</label>
        <div class="dropdown-wrapper">
            <select name="status" class="form-input">
                @foreach(config('constants.status') as $key => $value)
                    <option value="{{ $key }}"
                        {{ (isset($employee) && $employee->status == $key) ? 'selected' : '' }}>
                        {{ ucfirst(strtolower($value)) }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- Password (Create + Edit both) -->
    <div class="col-md-6">
        <label class="form-label">Password</label>

        <div class="input-group">
            <input type="password" name="password" id="passwordInput" 
                   class="form-input" {{ !isset($employee) ? 'required' : '' }}>

            <!-- Show/Hide Button -->
            <button type="button" class="btn btn-outline-secondary" id="togglePassword">
                <i class="bi bi-eye-slash" id="togglePasswordIcon"></i>
            </button>

            <!-- Generate Password -->
            <button type="button" class="btn btn-outline-primary" id="generatePassword">
                <i class="bi bi-shuffle"></i>
            </button>
        </div>

        @if(isset($employee))
            <span class="text-muted" style="font-size: 0.8rem;">Leave it blank for no change</span>
        @else
            <span class="text-muted" style="font-size: 0.8rem;">Password is required</span>
        @endif
    </div>

    <!-- Submit Button -->
    <div class="mt-4 text-end">
        <button type="submit" class="btn btn-primary px-4 fw-semibold rounded-3">
            <i class="bi bi-save"></i> Save Employee
        </button>
    </div>

</div>

<style>
  .form-label {
    font-weight: 600;
    color: #111827;
    font-size: 0.9rem;
  }

  .form-input {
    width: 100%;
    border: 1px solid #d1d5db;
    border-radius: 6px;
    background-color: #fff;
    font-size: 0.95rem;
    padding: 10px 12px;
    height: 42px;
    transition: border-color 0.2s ease, box-shadow 0.2s ease;
    appearance: none;
  }

  .form-input:focus {
    border-color: #4b49ac;
    box-shadow: 0 0 0 0.1rem rgba(75, 73, 172, 0.25);
  }

  .dropdown-wrapper {
    position: relative;
  }

  .dropdown-wrapper::after {
    content: '\25BC';
    position: absolute;
    right: 12px;
    top: 50%;
    transform: translateY(-50%);
    font-size: 0.65rem;
    color: #6b7280;
    pointer-events: none;
  }

  select.form-input {
    cursor: pointer;
    padding-right: 28px;
  }

  textarea.form-input {
    height: auto;
    min-height: 90px;
    resize: vertical;
  }

  .btn {
    border-radius: 6px;
    padding: 8px 18px;
    font-weight: 600;
  }

  .btn-primary {
    background-color: #4b49ac;
    border-color: #4b49ac;
  }

  .btn-primary:hover {
    background-color: #3b3a96;
    border-color: #3b3a96;
  }
</style>

<script>
/* Show / Hide Password */
document.getElementById("togglePassword").addEventListener("click", function () {
    const passwordInput = document.getElementById("passwordInput");
    const icon = document.getElementById("togglePasswordIcon");

    if (passwordInput.type === "password") {
        passwordInput.type = "text";
        icon.classList.remove("bi-eye-slash");
        icon.classList.add("bi-eye");
    } else {
        passwordInput.type = "password";
        icon.classList.remove("bi-eye");
        icon.classList.add("bi-eye-slash");
    }
});

/* Auto Generate Password */
document.getElementById("generatePassword").addEventListener("click", function () {
    const passwordInput = document.getElementById("passwordInput");

    const chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789@#$%!";
    let password = "";
    for (let i = 0; i < 10; i++) {
        password += chars.charAt(Math.floor(Math.random() * chars.length));
    }

    passwordInput.value = password;
});
</script>
