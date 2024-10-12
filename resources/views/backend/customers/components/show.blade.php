  <div class="row">
      <div class="col-md-9">
          <div class="ibox-content">
            <div class="form-group">
                <h1>{{$data->title}}</h1>
            </div>
              <div class="form-group">
                  <label>tài khoản </label>
                  <input type="text" value="{{ $user->username }}" name="username" class="form-control" readonly>

              </div>
              <div class="form-group">
                  <label>họ và tên</label>
                  <input type="text" value="{{ $user->full_name }}" name="full_name" class="form-control" readonly>

              </div>
              <div class="form-group">
                  <label>email</label>
                  <input type="text" value="{{ $user->email }}" name="email" class="form-control" readonly>

              </div>
              <div class="form-group">
                  <label>nội dung</label>
                  <input type="text" value="{{ $data->content }}" name="content" class="form-control" readonly>


              </div>

          </div>
      </div>

  </div>
