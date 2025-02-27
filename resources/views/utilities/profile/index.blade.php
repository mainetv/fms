@extends('layouts.app')

@section('content')
  {{ csrf_field() }}
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Profile</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="/fms/public">Home</a></li>
            <li class="breadcrumb-item active">Profile</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <section class="content">
    <form id="frm_profile">
      <div class="card">
        <div class="card-header">
          Change Password
        </div>
        <div class="card-body py-2">
          <div class="row form-group">
            <label for="old_password" class="col-lg-2 col-form-label">Old Password:</label>
            <div class="col-lg-5 input-group">
                <input type="password" id="old_password" name="old_password" class="form-control" placeholder="Old Password">
                <div class="input-group-append">
                  <button type="button" class="btn btn-outline-secondary toggle-password input-group-text" data-target="old_password">               
                    <i class="fas fa-eye fa-xs"></i>
                  </button>              
                </div>
                <div id="old_password-feedback" class="invalid-feedback"></div>   
            </div>
          </div>

          <div class="row form-group">
            <label for="new_password" class="col-lg-2 col-form-label">New Password:</label>
            <div class="col-lg-5 input-group">
              <input type="password" id="new_password" name="new_password" class="form-control" placeholder="New Password">
              <div class="input-group-append">
                <button type="button" class="btn btn-outline-secondary toggle-password input-group-text" data-target="new_password">               
                  <i class="fas fa-eye fa-xs"></i>
                </button>              
              </div>
              <div id="new_password-feedback" class="invalid-feedback"></div>   
            </div>
          </div>

          <div class="row form-group">
            <label for="confirm_password" class="col-lg-2 col-form-label">Confirm Password:</label>
            <div class="col-lg-5 input-group">
              <input type="password" id="confirm_password" name="confirm_password" class="form-control" placeholder="Confirm Password">
              <div class="input-group-append">
                <button type="button" class="btn btn-outline-secondary toggle-password input-group-text" data-target="confirm_password">               
                  <i class="fas fa-eye fa-xs"></i>
                </button>              
              </div>         
              <div id="confirm_password-feedback" class="invalid-feedback"></div>   
            </div>
          </div>

        </div>
        <div class="card-footer">
          <button type="button" class="save_password btn btn-primary save-buttons">Save</button>
        </div>
      </div>
    </form>
  </section>
@endsection

@section('jscript')
  <script type="text/javascript">
    $(document).ready(function() {  
      const requiredFields = [
				{ id: 'old_password', event: 'input'},
				{ id: 'new_password', event: 'input'},
				{ id: 'confirm_password', event: 'input'},
			];

      @include('scripts.validation')

      $('.toggle-password').click(function () {
        let targetInput = $('#' + $(this).data('target'));
        let icon = $(this).find('i');

        if (targetInput.attr('type') === 'password') {
          targetInput.attr('type', 'text');
          icon.removeClass('fa-eye').addClass('fa-eye-slash');
        } else {
          targetInput.attr('type', 'password');
          icon.removeClass('fa-eye-slash').addClass('fa-eye');
        }
      });

      $('#new_password, #confirm_password').on('input', function () {
        let newPassword = $('#new_password').val();
        let confirmPassword = $('#confirm_password').val();
        let feedbackElement = $('#confirm_password-feedback');

        if (confirmPassword.length > 0) {
          if (newPassword !== confirmPassword) {
            $('#confirm_password').addClass('is-invalid');
            feedbackElement.html('The new password and confirm password do not match.').show();
          } else {
            $('#confirm_password').removeClass('is-invalid');
            feedbackElement.html('').hide();
          }
        } else {
          $('#confirm_password').removeClass('is-invalid');
          feedbackElement.html('').hide();
        }
      });

      $('#frm_profile').on('click', '.save_password', function(e) {
        e.preventDefault();
        Swal.fire({
          title: 'Are you sure you want to change password?',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonText: 'Yes'
        })
        .then((result) => {
          if (result.value) {
            $.ajax({
              method: 'PATCH',
              url: '{{ route('utilities.profile.change_password') }}',
              data: $('#frm_profile').serializeArray(),
              success: function(response) {
                Swal.fire({
                  position: 'top-end',
                  icon: 'success',
                  title: response.message,
                  showConfirmButton: false,
                  timer: 1500
                })
              },
              error: function (xhr) {
                var response = JSON.parse(xhr.responseText);

                $('.is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').html('');

                $.each(response.errors, function(field, messages) {
                  var element = $('#' + field);
                  var feedbackElement = $('#' + field + '-feedback');

                  if (element.length) {
                      element.addClass('is-invalid');
                      feedbackElement.html(messages[0]).show();
                  }
                });

                var $firstErrorField = $('.is-invalid:first');
                if ($firstErrorField.length) {
                  $('html, body').animate({ scrollTop: $firstErrorField.offset().top - 100 }, 'slow');
                }
              }
            });
          }
        })
      });
    })
  </script>
@endsection
