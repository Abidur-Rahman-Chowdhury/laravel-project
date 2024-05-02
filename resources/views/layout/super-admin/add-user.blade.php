@include('layout/super-admin/super-admin-header');

<!-- Begin page -->
<div id="layout-wrapper">

  @include('partials/super-admin/menu')

  <!-- ============================================================== -->
  <!-- Start right Content here -->
  <!-- ============================================================== -->

  <div class="main-content">
    <div class="page-content">
      <div class="container-fluid">
        <div class="row justify-content-center mb-10 mt-10">
          <!-- left column -->
          <div class="col-md-6">
            <!-- general form elements -->
            <div class="card ps-2 pe-2">
              <div class="card-header">
                <h3 class="card-title">Add User Data</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="post" action="{{route('register-user')}}">
                @if(Session::has('success'))
                <div class="text-success text-center">{{Session::get('success')}}</div>
                @endif
                @if(Session::has('fail'))
                <div class="text-danger text-center">{{Session::get('fail')}}</div>
                @endif
                @csrf
                <?php
                $usersGroup =  ['super_admin', 'admin_user', 'merchant_admin', 'merchant_user',];
                $userGroup = '';
                foreach ($usersGroup as $type) {
                  $value = explode('_', $type);
                  $join = implode(' ',   $value);
                  $userGroup .= "<option value='$type'>" . ucwords($join) . "</option>";
                }
                ?>
                <div class="mb-3">
                  <label for="user_group" class="form-label">User Group</label>
                  <select class="form-select mb-3" onchange="toggleClient(this.value)" name="user_group" id="user_group">
                    <option value="">Select User Group</option>
                    <?= $userGroup ?>

                  </select>
                  <span class="text-danger">@error('user_group') {{$message}} @enderror</span>
                </div>
                <div class="mb-3" id="client" style="display:none;">
                  <label for="client_name" class="form-label">Client Name</label>
                  <input class="form-control clientName" onkeyup="getClientName(this.id, this.value)" autocomplete="off" type="text" id="client_name" placeholder="Client Name" name="client_name" value="" />
                  <input type="hidden" name="client_id" id="client_id">
                  <?php
                  $tableTR = '';
                  $tableTR = "<div id='clientNameSuggestions' style='display:none;width:95%; border-radius:5px; height:250px;' class='ClassempIdSuggestions'>
                            <div id='suggestingClientName' class='ClasssuggestingEmpIdList'>
                            </div>
                        </div>";
                  echo $tableTR;
                  ?>
                </div>
                <div class="mb-3">
                  <label for="name" class="form-label">First Name</label>
                  <input type="text" class="form-control" value="{{old('name')}}" id="name" name="name" placeholder="First Name">
                  <span class="text-danger">@error('name') {{$message}} @enderror</span>
                </div>
                <div class="mb-3">
                  <label for="last_name" class="form-label">Last Name</label>
                  <input type="text" class="form-control" id="last_name" value="{{old('last_name')}}" name="last_name" placeholder="Last Name">
                  <span class="text-danger">@error('last_name') {{$message}} @enderror</span>
                </div>
                <div class="mb-3">
                  <label for="email" class="form-label">Email</label>
                  <input type="email" class="form-control" value="{{old('email')}}" id="email" name="email" placeholder="Email">
                  <span class="text-danger">@error('email') {{$message}} @enderror</span>
                </div>
                <div class="mb-3">
                  <label for="phone" class="form-label">Phone</label>
                  <input type="text" class="form-control" id="phone" value="{{old('phone')}}" name="phone" placeholder="Phone">
                  <span class="text-danger">@error('phone') {{$message}} @enderror</span>
                </div>
                <div class="mb-3">
                  <label for="present_address" class="form-label">Present Address</label>
                  <input type="text" class="form-control" id="present_address" value="{{old('present_address')}}" name="present_address" placeholder="Present Address">

                </div>
                <div class="mb-3">
                  <label for="password" class="form-label">Password</label>
                  <div class="position-relative auth-pass-inputgroup mb-3">
                    <input type="password" class="form-control pe-5 password-input pass1" placeholder="Enter password" id="password-input" name="password" value="{{old('password')}}">
                    <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon" type="button" id="password-addon"><i class="ri-eye-fill align-middle"></i></button>
                  </div>
                  <span class="text-danger">@error('password') {{$message}} @enderror</span>
                </div>
                <div class="mb-3">
                  <label for="repass" class="form-label">Re Password</label>
                  <div class="position-relative auth-pass-inputgroup mb-3">
                    <input type="password" class="form-control pe-5 password-input repass" placeholder="Enter password" id="password-input" name="repass" value="{{old('repass')}}">
                    <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon" type="button" id="password-addon"><i class="ri-eye-fill align-middle"></i></button>
                  </div>
                  <span class="text-danger">@error('repass') {{$message}} @enderror</span>
                </div>
                <div class="mb-3">
                  <label for="b_date" class="form-label">Date Of Birth</label>
                  <input type="date" class="form-control" id="b_date" name="b_date" value="">
                </div>
                <div class="mb-3">
                  <label for="start_date" class="form-label">Start Date</label>
                  <input type="date" class="form-control" id="start_date" name="start_date" value="{{old('start_date')}}">
                  <span class="text-danger">@error('start_date') {{$message}} @enderror</span>
                </div>
                <div class="mb-3">
                  <label for="end_date" class="form-label">End Date</label>
                  <input type="date" class="form-control" id="end_date" name="end_date" value="{{old('end_date')}}">
                </div>
                <div class="text-center">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </form>
              <!-- /.card-body -->

            </div>
            <!-- /.card -->
          </div>
          <!--/.col (left) -->
        </div>

      </div>
      <!-- container-fluid -->
    </div>
    <!-- End Page-content -->

    <script>
      function getClientName(id, val) {
        var base_url = "super-admin";
        if (val == '') {
          document.getElementById('client_name').value = '';
          document.getElementById('client_id').value = '';
          $('#clientNameSuggestions').fadeOut();
          return false;
        }
        $.post(base_url + "/getClientName", {
          val: val,
          id: id
        }, function(data) {
          if (data.length > 0) {
            $('#suggestingClientName').html(data);
            $('#clientNameSuggestions').fadeIn("slow");
          }
        });
      }

      function fill_client_id_by_tanent(id, cName) {
        document.getElementById('client_name').value = cName;
        document.getElementById('client_id').value = id;
        $('#clientNameSuggestions').fadeOut();
      }

      function toggleClient(value) {

        if (userGroup[0] == value || userGroup[1] == value) {
          $('#client').hide();
          $('#client_id').val('');

        } else {
          $('#client').show();
        }
      }

      function validatePassword() {
        var password = $(".pass1").val();
        var hasSpecialChar = /[!@#$%^&*()_+\-=\[\]{}|;:'",.<>\/?]/.test(password);
        var hasNumber = /\d/.test(password);
        var hasString = /[a-zA-Z]/.test(password);
        var isMinLength = password.length >= 8;
        if (hasSpecialChar && hasNumber && hasString && isMinLength) {
          return true;
        } else {
          return false;
        }
      }

      // function validation() {
      //   let checkCondition = validatePassword();


      //   if ($('#user_group').val() == '') {
      //     alert('User group is required');
      //     return false;
      //   }
      //   if ($('#user_group').val() == userGroup[2] || $('#user_group').val() == userGroup[3]) {
      //     if ($('#client_id').val() == '') {
      //       alert('Client name is required');
      //       return false;
      //     }
      //   }
      //   if ($('#name').val() == '') {
      //     alert('First name is required');
      //     return false;
      //   }
      //   if ($('#last_name').val() == '') {
      //     alert('Last  name is required');
      //     return false;
      //   }
      //   if ($('#email').val() == '') {
      //     alert('Email is required');
      //     return false;
      //   }
      //   if ($('#phone').val() == '') {
      //     alert('Phone is required');
      //     return false;
      //   }
      //   if ($('.pass1').val() == '') {
      //     alert('Password is required');
      //     return false;
      //   }
      //   if ($('.repass').val() == '') {
      //     alert('Re Password  is required');
      //     return false;
      //   }
      //   if ($('.pass1').val() != $('.repass').val()) {
      //     alert('Password does not match ');
      //     return false;
      //   }
      //   if (checkCondition === false) {
      //     alert("Password has to be at least 8 characters, speacial character, number and string!!!");
      //     return false;
      //   }
      //   if ($('#start_date').val() == '') {
      //     alert('Start date is required');
      //     return false;
      //   }
      // }
    </script>
    @include('layout/super-admin/super-admin-footer');