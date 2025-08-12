<div id="changePasswordModal" class="modal-overlay" style="display:none;">
  <div class="modal-container">
    <div class="modal-header">
      <h3 class="modal-title">Đổi mật khẩu</h3>
      <button onclick="closeChangePasswordModal()" class="modal-close">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <line x1="18" y1="6" x2="6" y2="18"></line>
          <line x1="6" y1="6" x2="18" y2="18"></line>
        </svg>
      </button>
    </div>

    <form id="changePasswordForm" method="POST" action="{{ route('client.users.change-password') }}">
      @csrf
   
      <div id="step1" class="modal-step">
        <div class="step-indicator">
          <div class="step-number active">1</div>
          <div class="step-line"></div>
          <div class="step-number">2</div>
        </div>
        
        <div class="step-content">
          <h4 class="step-title">Xác thực email</h4>
          <p class="step-description">Nhập email tài khoản để nhận mã OTP</p>
          
          <div class="form-group">
            <label for="change_password_email" class="form-label">
              <svg class="label-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                <polyline points="22,6 12,13 2,6"></polyline>
              </svg>
              Địa chỉ email
            </label>
            <div class="input-container">
              <input type="email" name="email" id="change_password_email" required class="form-input" placeholder="Nhập địa chỉ email của bạn">
            </div>
          </div>

          <button type="button" id="btnSendOtp" onclick="sendOtp()" class="btn-primary">
            <span id="btnSendOtpText">Gửi mã OTP</span>
            <div id="btnSendOtpSpinner" class="spinner" style="display:none;"></div>
          </button>
          
          <div id="otpSendMsg" class="message"></div>
        </div>
      </div>

      <div id="step2" class="modal-step" style="display:none;">
        <div class="step-indicator">
          <div class="step-number completed">✓</div>
          <div class="step-line completed"></div>
          <div class="step-number active">2</div>
        </div>
        
        <div class="step-content">
          <h4 class="step-title">Đặt mật khẩu mới</h4>
          <p class="step-description">Nhập mã OTP và mật khẩu mới</p>
          
          <div class="form-group">
            <label for="otp_code" class="form-label">
              <svg class="label-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                <circle cx="12" cy="16" r="1"></circle>
                <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
              </svg>
              Mã OTP
            </label>
            <div class="input-container">
              <input type="text" name="otp" id="otp_code" required class="form-input" placeholder="Nhập mã OTP từ email">
            </div>
          </div>

          <div class="form-group">
            <label for="new_password" class="form-label">
              <svg class="label-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
              </svg>
              Mật khẩu mới
            </label>
            <div class="input-container" style="position:relative;">
              <input type="password" name="new_password" id="new_password" required class="form-input" placeholder="Nhập mật khẩu mới">
              <span class="toggle-password" onclick="togglePassword('new_password', this)" style="position:absolute;right:12px;top:calc(50% - 8px);transform:translateY(-50%);cursor:pointer;">
                <svg id="icon-new_password" xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                  <path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7S1 12 1 12z" />
                  <circle cx="12" cy="12" r="3" />
                </svg>
              </span>
            </div>
          </div>

          <div class="form-group">
            <label for="new_password_confirmation" class="form-label">
              <svg class="label-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
              </svg>
              Xác nhận mật khẩu
            </label>
             <div class="input-container">
              <input type="password" name="new_password_confirmation" id="new_password_confirmation" required class="form-input" placeholder="Nhập lại mật khẩu mới">
            </div>
</style>
<script>
function togglePassword(id, btn) {
  const input = document.getElementById(id);
  const icon = document.getElementById('icon-' + id);
  if (input.type === 'password') {
    input.type = 'text';
    icon.innerHTML = '<path d="M17.94 17.94A10.94 10.94 0 0 1 12 19c-7 0-11-7-11-7a21.77 21.77 0 0 1 5.06-6.06M1 1l22 22"/><circle cx="12" cy="12" r="3"/>';
  } else {
    input.type = 'password';
    icon.innerHTML = '<path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7S1 12 1 12z" /><circle cx="12" cy="12" r="3" />';
  }
}
</script>
          </div>

          <div class="modal-actions">
            <button type="button" onclick="backToStep1()" class="btn-secondary">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <polyline points="15,18 9,12 15,6"></polyline>
              </svg>
              Quay lại
            </button>
            <button type="submit" class="btn-primary">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <polyline points="20,6 9,17 4,12"></polyline>
              </svg>
              Đổi mật khẩu
            </button>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>

<style>
/* Modal Overlay */
.modal-overlay {
  position: fixed;
  z-index: 9999;
  left: 0;
  top: 0;
  width: 100vw;
  height: 100vh;
  background: rgba(0, 0, 0, 0.6);
  backdrop-filter: blur(4px);
  display: flex;
  align-items: center;
  justify-content: center;
  animation: fadeIn 0.3s ease;
}

@keyframes fadeIn {
  from { opacity: 0; }
  to { opacity: 1; }
}

/* Modal Container */
.modal-container {
  background: #fff;
  border-radius: 20px;
  min-width: 480px;
  max-width: 90vw;
  max-height: 90vh;
  overflow-y: auto;
  box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
  position: relative;
  animation: slideUp 0.3s ease;
}

@keyframes slideUp {
  from { 
    opacity: 0;
    transform: translateY(30px) scale(0.95);
  }
  to { 
    opacity: 1;
    transform: translateY(0) scale(1);
  }
}

/* Modal Header */
.modal-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 2rem 2rem 1rem 2rem;
  border-bottom: 1px solid #f1f3f4;
}

.modal-title {
  font-size: 1.75rem;
  font-weight: 700;
  color: #1a1a1a;
  margin: 0;
}

.modal-close {
  background: #f8f9fa;
  border: none;
  width: 40px;
  height: 40px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  transition: all 0.2s ease;
  color: #6c757d;
}

.modal-close:hover {
  background: #e9ecef;
  color: #495057;
  transform: scale(1.1);
}

/* Step Indicator */
.step-indicator {
  display: flex;
  align-items: center;
  justify-content: center;
  margin: 2rem 0 2.5rem 0;
  padding: 0 2rem;
}

.step-number {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: 700;
  font-size: 1rem;
  background: #f8f9fa;
  color: #6c757d;
  border: 2px solid #e9ecef;
  transition: all 0.3s ease;
}

.step-number.active {
  background: #000;
  color: #fff;
  border-color: #000;
  box-shadow: 0 0 0 4px rgba(0, 0, 0, 0.1);
}

.step-number.completed {
  background: #28a745;
  color: #fff;
  border-color: #28a745;
}

.step-line {
  flex: 1;
  height: 2px;
  background: #e9ecef;
  margin: 0 1rem;
  transition: all 0.3s ease;
}

.step-line.completed {
  background: #28a745;
}

/* Step Content */
.modal-step {
  padding: 0 2rem 2rem 2rem;
}

.step-content {
  max-width: 400px;
  margin: 0 auto;
}

.step-title {
  font-size: 1.5rem;
  font-weight: 700;
  color: #1a1a1a;
  margin-bottom: 0.5rem;
  text-align: center;
}

.step-description {
  color: #6c757d;
  text-align: center;
  margin-bottom: 2rem;
  font-size: 1rem;
}

/* Form Groups */
.form-group {
  margin-bottom: 1.5rem;
}

.form-label {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  font-weight: 600;
  color: #1a1a1a;
  margin-bottom: 0.5rem;
  font-size: 0.95rem;
}

.label-icon {
  color: #6c757d;
}

.input-container {
  position: relative;
}

.form-input {
  width: 100%;
  padding: 1rem 1.25rem;
  border: 2px solid #e9ecef;
  border-radius: 12px;
  font-size: 1rem;
  transition: all 0.3s ease;
  background: #fff;
  color: #1a1a1a;
  box-sizing: border-box;
}

.form-input:focus {
  outline: none;
  border-color: #000;
  box-shadow: 0 0 0 3px rgba(0, 0, 0, 0.1);
}

.form-input::placeholder {
  color: #adb5bd;
}

/* Buttons */
.btn-primary {
  width: 100%;
  background: #000;
  color: #fff;
  border: none;
  padding: 1rem 1.5rem;
  border-radius: 12px;
  font-weight: 600;
  font-size: 1rem;
  cursor: pointer;
  transition: all 0.3s ease;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 0.5rem;
  margin-top: 1rem;
}

.btn-primary:hover:not(:disabled) {
  background: #333;
  transform: translateY(-2px);
  box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
}

.btn-primary:disabled {
  opacity: 0.7;
  cursor: not-allowed;
  transform: none;
}

.btn-secondary {
  background: #f8f9fa;
  color: #6c757d;
  border: 2px solid #e9ecef;
  padding: 0.875rem 1.5rem;
  border-radius: 12px;
  font-weight: 600;
  font-size: 1rem;
  cursor: pointer;
  transition: all 0.3s ease;
  display: flex;
  align-items: center;
  gap: 0.5rem;
}

.btn-secondary:hover {
  background: #e9ecef;
  color: #495057;
  border-color: #dee2e6;
}

/* Modal Actions */
.modal-actions {
  display: flex;
  gap: 1rem;
  margin-top: 2rem;
}

.modal-actions .btn-primary {
  flex: 1;
  margin-top: 0;
}

/* Spinner */
.spinner {
  width: 20px;
  height: 20px;
  border: 2px solid rgba(255, 255, 255, 0.3);
  border-top: 2px solid #fff;
  border-radius: 50%;
  animation: spin 1s linear infinite;
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

/* Message */
.message {
  margin-top: 1rem;
  padding: 0.75rem 1rem;
  border-radius: 8px;
  font-weight: 500;
  text-align: center;
  transition: all 0.3s ease;
}

.message.success {
  background: #d4edda;
  color: #155724;
  border: 1px solid #c3e6cb;
}

.message.error {
  background: #f8d7da;
  color: #721c24;
  border: 1px solid #f5c6cb;
}

/* Responsive */
@media (max-width: 768px) {
  .modal-container {
    min-width: 0;
    width: 95vw;
    margin: 1rem;
  }
  
  .modal-header,
  .modal-step {
    padding-left: 1.5rem;
    padding-right: 1.5rem;
  }
  
  .step-indicator {
    padding: 0 1.5rem;
  }
  
  .modal-title {
    font-size: 1.5rem;
  }
  
  .modal-actions {
    flex-direction: column;
  }
}
</style>

<script>
function openChangePasswordModal() {
  document.getElementById('changePasswordModal').style.display = 'flex';
  document.body.style.overflow = 'hidden'; // Prevent background scroll
}

function closeChangePasswordModal() {
  document.getElementById('changePasswordModal').style.display = 'none';
  document.body.style.overflow = 'auto'; // Restore scroll
  resetModal();
}

function resetModal() {
  // Reset to step 1
  document.getElementById('step1').style.display = 'block';
  document.getElementById('step2').style.display = 'none';
  
  // Clear form
  document.getElementById('changePasswordForm').reset();
  
  // Clear messages
  document.getElementById('otpSendMsg').innerHTML = '';
  document.getElementById('otpSendMsg').className = 'message';
  
  // Reset button state
  const btn = document.getElementById('btnSendOtp');
  const btnText = document.getElementById('btnSendOtpText');
  const btnSpinner = document.getElementById('btnSendOtpSpinner');
  
  btn.disabled = false;
  btnText.style.display = 'inline';
  btnSpinner.style.display = 'none';
}

function backToStep1() {
  document.getElementById('step1').style.display = 'block';
  document.getElementById('step2').style.display = 'none';
}

// Close modal when clicking outside
document.getElementById('changePasswordModal').addEventListener('click', function(e) {
  if (e.target === this) {
    closeChangePasswordModal();
  }
});

// Close modal with Escape key
document.addEventListener('keydown', function(e) {
  if (e.key === 'Escape' && document.getElementById('changePasswordModal').style.display === 'flex') {
    closeChangePasswordModal();
  }
});

// Fix nút Hủy ở ngoài modal
document.addEventListener('DOMContentLoaded', function() {
  var cancelBtns = document.querySelectorAll('.btn-cancel');
  cancelBtns.forEach(function(btn) {
    btn.addEventListener('click', function(e) {
      if (document.getElementById('changePasswordModal').style.display === 'flex') {
        closeChangePasswordModal();
        e.preventDefault();
      }
    });
  });
});

function sendOtp() {
  var email = document.getElementById('change_password_email').value;
  var msg = document.getElementById('otpSendMsg');
  var btn = document.getElementById('btnSendOtp');
  var btnText = document.getElementById('btnSendOtpText');
  var btnSpinner = document.getElementById('btnSendOtpSpinner');
  
  // Clear previous message
  msg.innerHTML = '';
  msg.className = 'message';
  
  // Show loading state
  btn.disabled = true;
  btnText.style.display = 'none';
  btnSpinner.style.display = 'inline-block';
  
  fetch("{{ route('client.users.send-otp') }}", {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': document.querySelector('input[name=_token]').value
    },
    body: JSON.stringify({email: email})
  })
  .then(res => res.json())
  .then(data => {
    // Reset button state
    btn.disabled = false;
    btnText.style.display = 'inline';
    btnSpinner.style.display = 'none';
    
    if(data.success) {
      msg.innerHTML = '✅ Mã OTP đã được gửi về email của bạn';
      msg.className = 'message success';
      
      // Move to step 2 after a short delay
      setTimeout(() => {
        document.getElementById('step1').style.display = 'none';
        document.getElementById('step2').style.display = 'block';
      }, 1500);
    } else {
      msg.innerHTML = '❌ ' + (data.message || 'Có lỗi xảy ra, vui lòng thử lại');
      msg.className = 'message error';
    }
  })
  .catch(() => {
    // Reset button state
    btn.disabled = false;
    btnText.style.display = 'inline';
    btnSpinner.style.display = 'none';
    
    msg.innerHTML = '❌ Có lỗi xảy ra, vui lòng thử lại';
    msg.className = 'message error';
  });
}
</script>